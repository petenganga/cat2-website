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
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f2f5; display: flex; justify-content: center; padding-top: 60px; }
        form { background: #fff; padding: 30px; border-radius: 8px; width: 300px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        input { width: 100%; padding: 8px; margin: 8px 0; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #2d6cdf; color: #fff; border: none; border-radius: 4px; }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Login</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Log In</button>
        <p><?php echo $msg; ?></p>
        <p><a href="signup.php">No account? Sign up</a></p>
    </form>
</body>
</html>
