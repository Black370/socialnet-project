<?php
session_start();
require_once "db.php";
if (isset($_SESSION['username'])) { header("Location: home.php"); exit(); }

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['username']);
    $pass = $_POST['password'];

    $query = "SELECT id, username, password FROM account WHERE username = '$user' AND password = '$pass'";
    $result = mysqli_query($conn, $query);

    if ($row = $result->fetch_assoc()) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        header("Location: home.php");
        exit();
    } else { 
        $error = "User not found or incorrect password."; 
    }
}
?>
<!DOCTYPE html>
<body style="font-family: Arial; padding: 20px; text-align: center;">
    <h2>Sign In to SocialNet</h2>
    <p style="color:red;"><?php echo $error; ?></p>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit" style="padding: 10px 20px;">Login</button>
    </form>
</body>
