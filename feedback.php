<?php
require 'config.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $_POST['name'], $_POST['email'], $_POST['message']);
    $stmt->execute();
    $msg = "Thank you, your feedback was saved.";
}
$rows = $conn->query("SELECT id, name, email, message, submitted_at FROM feedback ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Feedback | CAT2 Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="card" style="max-width:700px; margin:30px 0;">
        <div class="brand">CAT2 Portal</div>
        <div class="subtitle">Send us your feedback</div>
        <form method="POST">
            <label>Name</label>
            <input type="text" name="name" required>
            <label>Email</label>
            <input type="email" name="email" required>
            <label>Message</label>
            <input type="text" name="message" required>
            <button type="submit">Submit</button>
        </form>
        <div class="msg"><?php echo $msg; ?></div>
        <h3 style="margin-top:25px;">Submitted feedback</h3>
        <table style="width:100%; border-collapse:collapse; font-size:14px; margin-top:10px;">
            <tr style="background:#eef6f9; text-align:left;">
                <th style="padding:8px;">ID</th><th style="padding:8px;">Name</th><th style="padding:8px;">Email</th><th style="padding:8px;">Message</th><th style="padding:8px;">Time</th>
            </tr>
            <?php while ($r = $rows->fetch_assoc()): ?>
            <tr style="border-bottom:1px solid #e5e7eb;">
                <td style="padding:8px;"><?php echo $r['id']; ?></td>
                <td style="padding:8px;"><?php echo htmlspecialchars($r['name']); ?></td>
                <td style="padding:8px;"><?php echo htmlspecialchars($r['email']); ?></td>
                <td style="padding:8px;"><?php echo htmlspecialchars($r['message']); ?></td>
                <td style="padding:8px;"><?php echo $r['submitted_at']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <div class="link"><a href="signup.php">Sign up</a> | <a href="login.php">Log in</a></div>
    </div>
</body>
</html>
