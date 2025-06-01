<?php
session_start();
require_once 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please login first";
    header('Location: login.php');
    exit;
}

if (!isset($_POST['cart_item_id'])) {
    $_SESSION['error'] = "Invalid request";
    header('Location: cart.php');
    exit;
}

$cart_item_id = mysqli_real_escape_string($conn, $_POST['cart_item_id']);
$user_id = $_SESSION['user_id'];

// Verify the cart item belongs to the user
$verify_query = "SELECT c.cart_id 
                 FROM cartitems ci 
                 JOIN carts c ON ci.cart_id = c.cart_id 
                 WHERE ci.cart_item_id = ? AND c.user_id = ?";

$verify_stmt = mysqli_prepare($conn, $verify_query);
mysqli_stmt_bind_param($verify_stmt, "ii", $cart_item_id, $user_id);
mysqli_stmt_execute($verify_stmt);
$result = mysqli_stmt_get_result($verify_stmt);

if (mysqli_num_rows($result) > 0) {
    $cart = mysqli_fetch_assoc($result);
    
    // Remove the item
    mysqli_query($conn, "DELETE FROM cartitems WHERE cart_item_id = '$cart_item_id'");
    
    // Update cart total
    $total_query = mysqli_query($conn, "
        SELECT SUM(g.price * ci.quantity) as total 
        FROM cartitems ci 
        JOIN games g ON ci.game_id = g.game_id 
        WHERE ci.cart_id = '{$cart['cart_id']}'
    ");
    
    $total = mysqli_fetch_assoc($total_query)['total'] ?? 0;
    mysqli_query($conn, "UPDATE carts SET total_price = '$total' WHERE cart_id = '{$cart['cart_id']}'");
    
    $_SESSION['success'] = "Item removed from cart";
} else {
    $_SESSION['error'] = "Invalid cart item";
}

mysqli_stmt_close($verify_stmt);
mysqli_close($conn);
header('Location: cart.php');
?> 