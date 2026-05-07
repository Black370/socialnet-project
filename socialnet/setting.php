<?php
session_start();
require_once "db.php";
if (!isset($_SESSION['username'])) { header("Location: signin.php"); exit(); }

$current_user = $_SESSION['username'];
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_desc = trim($_POST['description']);
    $stmt = $conn->prepare("UPDATE account SET description = ? WHERE username = ?");
    $stmt->bind_param("ss", $new_desc, $current_user);
    $stmt->execute();
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $ext = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'png', 'jpeg'])) {
            $new_file = "user_" . $_SESSION['user_id'] . "_" . time() . "." . $ext;
            move_uploaded_file($_FILES['profile_pic']['tmp_name'], "uploads/" . $new_file);
            $conn->query("UPDATE account SET profile_pic = '$new_file' WHERE username = '$current_user'");
        }
    }
    $message = "<p style='color:green;'>Settings updated!</p>";
}

$current_data = $conn->query("SELECT description, profile_pic FROM account WHERE username = '$current_user'")->fetch_assoc();
?>
<!DOCTYPE html>
<body style="font-family: Arial; padding: 20px;">
    <?php include "menubar.php"; ?>
    <h2>Settings Page</h2>
    <?php echo $message; ?>
    
    <form method="POST" enctype="multipart/form-data" style="background: #f9f9f9; padding: 20px; border: 1px solid #ccc;">
        <label><strong>Profile Picture:</strong></label><br>
        <input type="file" name="profile_pic"><br><br>
        
        <label><strong>Profile Description:</strong></label><br>
        <textarea name="description" rows="5" cols="50"><?php echo htmlspecialchars($current_data['description'] ?? ''); ?></textarea><br><br>
        
        <button type="submit">Save Changes</button>
    </form>
</body>
