<?php
session_start();
require_once 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please login first";
    header('Location: login.php');
    exit;
}

if (!isset($_POST['game_id'])) {
    $_SESSION['error'] = "Invalid request";
    header('Location: index.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$game_id = mysqli_real_escape_string($conn, $_POST['game_id']);

// Check if game exists and get its price
$game_query = mysqli_query($conn, "SELECT game_id, price FROM games WHERE game_id = '$game_id'");
if (mysqli_num_rows($game_query) == 0) {
    $_SESSION['error'] = "Game not found";
    header('Location: index.php');
    exit;
}
$game = mysqli_fetch_assoc($game_query);

// Check if user has an active cart
$cart_query = mysqli_query($conn, "SELECT cart_id FROM carts WHERE user_id = '$user_id'");

if (mysqli_num_rows($cart_query) == 0) {
    // Create new cart
    mysqli_query($conn, "INSERT INTO carts (user_id, total_price) VALUES ('$user_id', 0)");
    $cart_id = mysqli_insert_id($conn);
} else {
    $cart = mysqli_fetch_assoc($cart_query);
    $cart_id = $cart['cart_id'];
}

// Add new item to cart (no need to check for duplicates since quantity is handled)
mysqli_query($conn, "INSERT INTO cartitems (cart_id, game_id, quantity) VALUES ('$cart_id', '$game_id', 1)");

// Update cart total
$total_query = mysqli_query($conn, "
    SELECT SUM(g.price) as total 
    FROM cartitems ci 
    JOIN games g ON ci.game_id = g.game_id 
    WHERE ci.cart_id = '$cart_id'
");
$total = mysqli_fetch_assoc($total_query)['total'] ?? 0;
mysqli_query($conn, "UPDATE carts SET total_price = '$total' WHERE cart_id = '$cart_id'");

$_SESSION['success'] = "Game added to cart successfully";
header('Location: index.php');
mysqli_close($conn);
?>