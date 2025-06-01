<?php
require_once "db.php";
session_start();

// If user is already logged in, redirect to index page
if(isset($_SESSION['user_id'])) {
    header("location: index.php");
    exit;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password";
    } else {
        $sql = "SELECT user_id, username, password FROM users WHERE username = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $username);
            
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                
                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    if (password_verify($password, $row['password'])) {
                        // Start the session and store user data
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['username'] = $row['username'];
                        
                        // If remember me is checked, set cookies
                        if(isset($_POST['remember'])) {
                            setcookie("username", $username, time() + (86400 * 30), "/"); // 30 days
                        }
                        
                        header("location: index.php");
                        exit;
                    } else {
                        $error = "Invalid password";
                    }
                } else {
                    $error = "Invalid username";
                }
            } else {
                $error = "Something went wrong. Please try again.";
            }
            $stmt->close();
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="icon" type="image/jpg" sizes="192x192" href="geto.jpg">
    <link rel="stylesheet" href="css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="register-body">
    <div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h1>Login</h1>
            <?php if (!empty($error)): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="remember-forgot">
                <label><input type="checkbox" name="remember">Remember Me</label>
                <a href="#">Forgot Password</a>
            </div>
            <button type="submit" class="btn">Login</button>
            <div class="register-link">
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </div>
        </form>
    </div>
</body>
</html>