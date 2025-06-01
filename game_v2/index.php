<?php
session_start();

// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$isHomePage = true; // This will hide the Home button
$hideLogin = true;  // This will hide the Login button
include 'header.php';
?>

<!-- Banner Section -->
<div class="banner">
    <img src="image/Cyberpunk.png">
    <div class="bg">
        <div class="content">
            <h2>Home For Gamers</h2>
            <p>Enter the world of endless digital entertainment. Discover the largest global marketplace for digital items and entertainment. Open the gate to adventure!</p>
            <a href="login/login.html" class="btn">Discover Now</a>
        </div>
    </div>
</div>

<!-- Trending Games Section -->
<section class="trending container" id="trending">
    <div class="heading">
        <i class='bx bxs-flame'></i>
        <h2>Trending Games</h2>
    </div>
    <div class="trending-content">
        <?php
        require_once 'db.php';
        
        $sql = "SELECT g.*, 
                COALESCE(AVG(r.rating), 0) as avg_rating,
                COUNT(r.rating) as rating_count
                FROM games g 
                LEFT JOIN reviews r ON g.game_id = r.game_id 
                GROUP BY g.game_id 
                ORDER BY g.added_time DESC LIMIT 8";
                
        $result = mysqli_query($conn, $sql);
        
        if ($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="box">
                    <img src="<?php echo isset($row['image_path']) ? $row['image_path'] : 'image/default-game.jpg'; ?>" alt="">
                    <div class="box-text">
                        <h2><?php echo isset($row['title']) ? $row['title'] : 'Untitled'; ?></h2>
                        <h3><?php echo isset($row['genre']) ? $row['genre'] : 'Unknown Genre'; ?></h3>
                        <div class="rating-download">
                            <div class="rating">
                                <i class='bx bxs-star'></i>
                                <span><?php echo number_format($row['avg_rating'], 1); ?></span>
                                <small>(<?php echo $row['rating_count']; ?> reviews)</small>
                            </div>
                            <div class="price">
                                $<?php echo number_format($row['price'], 2); ?>
                            </div>
                        </div>
                        <div class="action-buttons">
                            <form action="add_to_cart.php" method="POST" style="display: inline;">
                                <input type="hidden" name="game_id" value="<?php echo $row['game_id']; ?>">
                                <button type="submit" class="btn add-to-cart">
                                    <i class='bx bx-cart-add'></i> Add to Cart
                                </button>
                            </form>
                            <a href="game-details.php?id=<?php echo $row['game_id']; ?>" class="btn see-more">
                                <i class='bx bx-right-arrow-alt'></i> See More
                            </a>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        mysqli_close($conn);
        ?>
    </div>
</section>

</body>
</html>