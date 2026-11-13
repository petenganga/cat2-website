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
    <title>Sign Up</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f2f5; display: flex; justify-content: center; padding-top: 60px; }
        form { background: #fff; padding: 30px; border-radius: 8px; width: 300px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        input { width: 100%; padding: 8px; margin: 8px 0; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #2d6cdf; color: #fff; border: none; border-radius: 4px; }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Sign Up</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
        <p><?php echo $msg; ?></p>
        <p><a href="login.php">Already have an account? Log in</a></p>
    </form>
</body>
</html>
