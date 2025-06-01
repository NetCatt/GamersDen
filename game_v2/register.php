<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="register-body">
<div class="container mt-5">
    <div class="form-container">
        <h2 class="text-center">Register</h2>
        <form action="" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
    </div>
</div>

<?php
require "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && !empty($_POST['username']) && 
        isset($_POST['email']) && !empty($_POST['email']) && 
        isset($_POST['password']) && !empty($_POST['password'])) {
        
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Check if email already exists
        $checkEmailSql = "SELECT * FROM users WHERE email = ?";
        $checkEmailStmt = $conn->prepare($checkEmailSql);
        $checkEmailStmt->bind_param("s", $email);
        $checkEmailStmt->execute();
        $result = $checkEmailStmt->get_result();

        if ($result->num_rows > 0) {
            echo "<div class='alert alert-danger text-center mt-3'>Email already exists!</div>";
        } else {
            // Insert user details into the database
            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $email, $password);

            if ($stmt->execute()) {
                // Redirect to login page after successful registration
                header("Location: login.php");
                exit();
            } else {
                echo "<div class='alert alert-danger text-center mt-3'>Error: " . $stmt->error . "</div>";
            }

            $stmt->close();
        }

        $checkEmailStmt->close();
        $conn->close();
    } else {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo "<div class='alert alert-danger text-center mt-3'>All fields are required!</div>";
        }
    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
