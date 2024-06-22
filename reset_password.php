<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("UPDATE users SET password=? WHERE reset_token=?");
    $stmt->bind_param("ss", $new_password, $token);

    if ($stmt->execute()) {
        echo "Password reset successful! <a href='index.html'>Login</a>";
    } else {
        echo "Error: " . $stmt->error;
    }
} elseif (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    die("Invalid request.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="reset-container">
        <h2>Enter New Password</h2>
        <form action="reset_password.php" method="post">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <div class="input-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            <div class="input-group">
                <button type="submit">Reset Password</button>
            </div>
        </form>
    </div>
</body>
</html>
