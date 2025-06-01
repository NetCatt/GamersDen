<?php
session_start();

// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'db.php';

// Get game ID from URL and validate it
$game_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($game_id <= 0) {
    header("Location: index.php");
    exit;
}

// Handle review submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review'])) {
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
    $comment = isset($_POST['review_text']) ? trim($_POST['review_text']) : '';
    $user_id = $_SESSION['user_id'];

    // Validate inputs
    if (empty($comment)) {
        $error = "Please write a review comment";
    } elseif ($rating < 1 || $rating > 5) {
        $error = "Please select a rating between 1 and 5 stars";
    } else {
        // Check if user has already reviewed this game
        $check_sql = "SELECT review_id FROM reviews WHERE game_id = ? AND user_id = ?";
        $check_stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "ii", $game_id, $user_id);
        mysqli_stmt_execute($check_stmt);
        $existing_review = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($existing_review) > 0) {
            $error = "You have already reviewed this game";
        } else {
            // Sanitize the comment
            $comment = htmlspecialchars($comment);
            
            $review_sql = "INSERT INTO reviews (game_id, user_id, rating, comment) 
                          VALUES (?, ?, ?, ?)";
            
            $review_stmt = mysqli_prepare($conn, $review_sql);
            if ($review_stmt) {
                mysqli_stmt_bind_param($review_stmt, "iiis", $game_id, $user_id, $rating, $comment);
                if (mysqli_stmt_execute($review_stmt)) {
                    header("Location: game-details.php?id=" . $game_id);
                    exit;
                } else {
                    $error = "Error submitting review: " . mysqli_error($conn);
                }
                mysqli_stmt_close($review_stmt);
            }
        }
        mysqli_stmt_close($check_stmt);
    }
}

// Fetch game details with error handling
$sql = "SELECT g.*, 
        COALESCE(AVG(r.rating), 0) as avg_rating,
        COUNT(r.rating) as rating_count
        FROM games g 
        LEFT JOIN reviews r ON g.game_id = r.game_id 
        WHERE g.game_id = ?
        GROUP BY g.game_id";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die("Error preparing statement: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $game_id);
if (!mysqli_stmt_execute($stmt)) {
    die("Error executing statement: " . mysqli_error($conn));
}

$result = mysqli_stmt_get_result($stmt);
$game = mysqli_fetch_assoc($result);

if (!$game) {
    header("Location: index.php");
    exit;
}

// Fetch reviews
$reviews_sql = "SELECT r.*, u.username, r.rating 
                FROM reviews r 
                JOIN users u ON r.user_id = u.user_id 
                WHERE r.game_id = ? 
                ORDER BY r.review_id DESC";

$reviews_stmt = mysqli_prepare($conn, $reviews_sql);
mysqli_stmt_bind_param($reviews_stmt, "i", $game_id);
mysqli_stmt_execute($reviews_stmt);
$reviews = mysqli_stmt_get_result($reviews_stmt);

include 'header.php';
?>

<div class="game-details container">
    <div class="game-header">
        <div class="game-image">
            <img src="<?php echo htmlspecialchars($game['image_path']); ?>" alt="<?php echo htmlspecialchars($game['title']); ?>">
        </div>
        <div class="game-info">
            <h1><?php echo htmlspecialchars($game['title']); ?></h1>
            <div class="game-meta">
                <span class="genre"><?php echo htmlspecialchars($game['genre']); ?></span>
                <div class="rating">
                    <?php 
                    $avg_rating = round($game['avg_rating']); // Round to nearest whole number
                    for($i = 1; $i <= 5; $i++): 
                    ?>
                        <i class='bx bxs-star <?php echo ($i <= $avg_rating) ? 'filled' : ''; ?>'></i>
                    <?php endfor; ?>
                    <span>(<?php echo number_format($game['avg_rating'], 1); ?>)</span>
                    <small>(<?php echo $game['rating_count']; ?> reviews)</small>
                </div>
                <div class="price">$<?php echo number_format($game['price'], 2); ?></div>
            </div>
            <p class="description"><?php echo nl2br(htmlspecialchars($game['description'])); ?></p>
            <div class="action-buttons">
                <form action="add_to_cart.php" method="POST">
                    <input type="hidden" name="game_id" value="<?php echo $game['game_id']; ?>">
                    <button type="submit" class="btn add-to-cart">
                        <i class='bx bx-cart-add'></i> Add to Cart
                    </button>
                </form>
                <button class="btn add-to-wishlist">
                    <i class='bx bx-heart'></i> Add to Wishlist
                </button>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="reviews-section">
        <h2>Reviews</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <!-- Check if user has already reviewed -->
        <?php
        $can_review = true;
        if (isset($_SESSION['user_id'])) {
            $check_sql = "SELECT review_id FROM reviews WHERE game_id = ? AND user_id = ?";
            $check_stmt = mysqli_prepare($conn, $check_sql);
            mysqli_stmt_bind_param($check_stmt, "ii", $game_id, $_SESSION['user_id']);
            mysqli_stmt_execute($check_stmt);
            $existing_review = mysqli_stmt_get_result($check_stmt);
            if (mysqli_num_rows($existing_review) > 0) {
                $can_review = false;
            }
            mysqli_stmt_close($check_stmt);
        }
        ?>

        <?php if ($can_review): ?>
        <form class="review-form" method="POST">
            <div class="rating-input">
                <label>Your Rating:</label>
                <div class="stars">
                    <div class="star-rating">
                        <?php for($i = 5; $i >= 1; $i--): ?>
                            <input type="radio" id="star<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>" required>
                            <label for="star<?php echo $i; ?>"><i class='bx bxs-star'></i></label>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
            <textarea name="review_text" placeholder="Write your review..." required></textarea>
            <input type="hidden" name="review" value="1">
            <button type="submit" class="btn submit-review">Submit Review</button>
        </form>
        <?php else: ?>
            <p class="already-reviewed">You have already reviewed this game.</p>
        <?php endif; ?>

        <div class="reviews-list">
            <?php 
            // Fetch reviews with ratings
            $reviews_sql = "SELECT r.*, u.username, r.rating 
                           FROM reviews r 
                           JOIN users u ON r.user_id = u.user_id 
                           WHERE r.game_id = ? 
                           ORDER BY r.review_id DESC";

            $reviews_stmt = mysqli_prepare($conn, $reviews_sql);
            mysqli_stmt_bind_param($reviews_stmt, "i", $game_id);
            mysqli_stmt_execute($reviews_stmt);
            $reviews = mysqli_stmt_get_result($reviews_stmt);
            
            while($review = mysqli_fetch_assoc($reviews)): 
            ?>
                <div class="review-card">
                    <div class="review-header">
                        <div class="user-info">
                            <span class="username"><?php echo htmlspecialchars($review['username']); ?></span>
                            <div class="rating">
                                <?php 
                                $rating = (int)$review['rating']; // Ensure rating is an integer
                                for($i = 1; $i <= 5; $i++): 
                                ?>
                                    <i class='bx bxs-star <?php echo ($i <= $rating) ? 'filled' : ''; ?>'></i>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                    <p class="review-text"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<?php
mysqli_stmt_close($stmt);
mysqli_stmt_close($reviews_stmt);
mysqli_close($conn);
?>
