<?php
session_start();
require 'config.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if ($row && password_verify($_POST['password'], $row['password'])) {
        $_SESSION['user'] = $username;
        $msg = "Login successful. Welcome, " . htmlspecialchars($username) . "!";
    } else {
        $msg = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | CAT2 Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="card">
        <div class="brand">CAT2 Portal</div>
        <div class="subtitle">Sign in to your account</div>
        <form method="POST">
            <label>Username</label>
            <input type="text" name="username" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <button type="submit">Log In</button>
        </form>
        <div class="msg"><?php echo $msg; ?></div>
        <div class="link">No account? <a href="signup.php">Sign up</a> | <a href="feedback.php">Feedback</a></div>
    </div>
</body>
</html>
