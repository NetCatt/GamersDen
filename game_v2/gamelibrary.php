<?php
session_start();
require_once 'db.php';

$isHomePage = false;
$hideLogin = isset($_SESSION['user_id']);
include 'header.php';
?>

<div class="banner-lib">
    <img src="image/bloodb.jpg">
</div>
<div class="heading">
    <h2>Browse Games</h2>
</div>
<section class="browse-games-container">
    <div class="brgame-content" id="game-list">
        <?php
        // Check if a category is selected
        $category = isset($_GET['category']) ? $_GET['category'] : '';

        // Base SQL query with average rating
        $baseSql = "SELECT g.*, 
                    COALESCE(AVG(r.rating), 0) as avg_rating,
                    COUNT(r.rating) as rating_count
                    FROM games g 
                    LEFT JOIN reviews r ON g.game_id = r.game_id";

        if ($category) {
            // Add category filter
            $sql = $baseSql . " WHERE g.genre = ? GROUP BY g.game_id";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $category);
        } else {
            // No category filter
            $sql = $baseSql . " GROUP BY g.game_id";
            $stmt = $conn->prepare($sql);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $games = $result->fetch_all(MYSQLI_ASSOC);

        // Display all games
        foreach ($games as $game) {
            $avg_rating = number_format($game['avg_rating'], 1);
            ?>
            <div class="game-grid">
                <img src="<?php echo htmlspecialchars($game['image_path']); ?>" 
                     alt="<?php echo htmlspecialchars($game['title']); ?>">
                <div class="box-text">
                    <h2><?php echo htmlspecialchars($game['title']); ?></h2>
                    <h3><?php echo htmlspecialchars($game['genre']); ?></h3>
                    <div class="rating-download">
                        <div class="rating">
                            <div class="stars">
                                <?php
                                // Display filled and empty stars based on rating
                                for($i = 1; $i <= 5; $i++): 
                                    $starClass = $i <= round($avg_rating) ? 'filled' : '';
                                ?>
                                    <i class='bx bxs-star <?php echo $starClass; ?>'></i>
                                <?php endfor; ?>
                            </div>
                            <span>(<?php echo $game['rating_count']; ?>)</span>
                        </div>
                        <form action="add_to_cart.php" method="POST" style="display: inline;">
                            <input type="hidden" name="game_id" value="<?php echo $game['game_id']; ?>">
                            <button type="submit" class="box-btn">
                                <i class='bx bx-cart-download'></i>
                            </button>
                        </form>
                    </div>
                    <div class="game-actions">
                        <div class="price">
                            <h4>$<?php echo number_format($game['price'], 2); ?></h4>
                        </div>
                        <a href="game-details.php?id=<?php echo $game['game_id']; ?>" class="btn see-more">
                            See More
                        </a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</section>

<?php
mysqli_stmt_close($stmt);
mysqli_close($conn);

?>