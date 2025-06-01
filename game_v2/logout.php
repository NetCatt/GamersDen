<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Delete remember me cookie if it exists
if(isset($_COOKIE['username'])) {
    setcookie("username", "", time() - 3600, "/");
}

// Redirect to login page
header("location: login.php");
exit;
?> 