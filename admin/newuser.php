<?php
require_once "../socialnet/db.php"; 
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['username']);
    $full = trim($_POST['fullname']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    $stmt = $conn->prepare("INSERT INTO account (username, fullname, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $full, $pass);
    if ($stmt->execute()) { $message = "<div style='color:green;'>User added!</div>"; } 
    else { $message = "<div style='color:red;'>Error: Username taken.</div>"; }
    $stmt->close();
}
?>
<!DOCTYPE html>
<body style="font-family: Arial; padding: 20px;">
    <h2>Admin: Create New User</h2>
    <?php echo $message; ?>
    <form method="POST">
        Username: <input type="text" name="username" required><br><br>
        Full Name: <input type="text" name="fullname" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <button type="submit">Create User</button>
    </form>
</body>
