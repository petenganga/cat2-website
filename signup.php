<?php
require 'config.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    try {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        $stmt->execute();
        $msg = "Account created for " . htmlspecialchars($username) . ". You can now log in.";
    } catch (mysqli_sql_exception $e) {
        $msg = "Error: that username or email already exists.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up | CAT2 Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="card">
        <div class="brand">CAT2 Portal</div>
        <div class="subtitle">Create your account</div>
        <form method="POST">
            <label>Username</label>
            <input type="text" name="username" required>
            <label>Email</label>
            <input type="email" name="email" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <button type="submit">Register</button>
        </form>
        <div class="msg"><?php echo $msg; ?></div>
        <div class="link">Already have an account? <a href="login.php">Log in</a> | <a href="feedback.php">Feedback</a></div>
    </div>
</body>
</html>
