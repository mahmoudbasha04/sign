<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $old_password = $_POST['old_password'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row && password_verify($old_password, $row['password'])) {
        $query = "UPDATE users SET password='$new_password' WHERE username='$username'";
        if (mysqli_query($conn, $query)) {
            echo "Password changed successfully!";
        } else {
            echo "Error updating password.";
        }
    } else {
        echo "Old password is incorrect.";
    }
}
?>
