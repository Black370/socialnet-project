<?php
session_start();
require_once "db.php";
if (isset($_SESSION['username'])) { header("Location: home.php"); exit(); }

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['username']);
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM account WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($pass, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: home.php");
            exit();
        } else { $error = "Invalid password."; }
    } else { $error = "User not found."; }
    $stmt->close();
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
