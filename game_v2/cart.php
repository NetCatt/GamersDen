<?php
session_start();

// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'db.php';
include 'header.php';

// Get user's cart
$user_id = $_SESSION['user_id'];
$cart_sql = "SELECT c.cart_id, c.total_price 
             FROM carts c 
             WHERE c.user_id = ?";

$cart_stmt = mysqli_prepare($conn, $cart_sql);
mysqli_stmt_bind_param($cart_stmt, "i", $user_id);
mysqli_stmt_execute($cart_stmt);
$cart_result = mysqli_stmt_get_result($cart_stmt);
$cart = mysqli_fetch_assoc($cart_result);

// If user doesn't have a cart, create one
if (!$cart) {
    mysqli_query($conn, "INSERT INTO carts (user_id, total_price) VALUES ('$user_id', 0)");
    $cart_id = mysqli_insert_id($conn);
    $cart = ['cart_id' => $cart_id, 'total_price' => 0];
}

// Get cart items
$items_sql = "SELECT g.*, ci.quantity, ci.cart_item_id
              FROM cartitems ci
              JOIN games g ON ci.game_id = g.game_id
              WHERE ci.cart_id = ?";

$items_stmt = mysqli_prepare($conn, $items_sql);
mysqli_stmt_bind_param($items_stmt, "i", $cart['cart_id']);
mysqli_stmt_execute($items_stmt);
$items_result = mysqli_stmt_get_result($items_stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="css\style.css">
    
</head>
<body>
    <main class="cart-container">
        <h1 class="cart-title">
            Your Cart
        </h1>

        <?php if (mysqli_num_rows($items_result) > 0): ?>
            <div class="cart-content">
                <div class="cart-items">
                    <?php while ($item = mysqli_fetch_assoc($items_result)): ?>
                        <div class="cart-item">
                            <div class="item-image">
                                <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                            </div>
                            <div class="item-details">
                                <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                                <p class="item-genre"><?php echo htmlspecialchars($item['genre']); ?></p>
                                <div class="item-price">$<?php echo number_format($item['price'], 2); ?></div>
                                <div class="item-actions">
                                    <form action="remove_from_cart.php" method="POST" class="remove-form">
                                        <input type="hidden" name="cart_item_id" value="<?php echo $item['cart_item_id']; ?>">
                                        <button type="submit" class="btn-remove">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <div class="cart-summary">
                    <h2>Order Summary</h2>
                    <div class="summary-item">
                        <span>Total Items:</span>
                        <span><?php echo mysqli_num_rows($items_result); ?></span>
                    </div>
                    <div class="summary-item total">
                        <span>Total:</span>
                        <span>$<?php echo number_format($cart['total_price'], 2); ?></span>
                    </div>
                    <form action="checkout.php" method="POST">
                        <button type="submit" class="btn-checkout">Proceed to Checkout</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-cart">
                <p>Your cart is empty</p>
                <a href="index.php" class="btn-continue">Continue Shopping</a>
            </div>
        <?php endif; ?>
    </main>

    <?php
    mysqli_stmt_close($cart_stmt);
    mysqli_stmt_close($items_stmt);
    mysqli_close($conn);
    ?>
</body>
</html>
