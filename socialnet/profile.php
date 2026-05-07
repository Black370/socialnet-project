<?php
session_start();
require_once "db.php";
if (!isset($_SESSION['username'])) { header("Location: signin.php"); exit(); }

$owner = isset($_GET['owner']) ? $_GET['owner'] : $_SESSION['username'];

$stmt = $conn->prepare("SELECT fullname, description, profile_pic FROM account WHERE username = ?");
$stmt->bind_param("s", $owner);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) { die("User not found."); }
$profile = $result->fetch_assoc();

$display_pic = ($profile['profile_pic'] !== 'default.png') ? "uploads/" . $profile['profile_pic'] : "https://via.placeholder.com/150";
?>
<!DOCTYPE html>
<body style="font-family: Arial; padding: 20px; text-align: center;">
    <?php include "menubar.php"; ?>
    
    <div style="max-width: 500px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; border: 1px solid #ccc;">
        <img src="<?php echo htmlspecialchars($display_pic); ?>" style="width:150px; height:150px; border-radius:50%; object-fit:cover;">
        
        <h2><?php echo htmlspecialchars($profile['fullname']); ?></h2>
        <p style="color: #777;">@<?php echo htmlspecialchars($owner); ?></p>
        
        <hr>
        <h4 style="text-align: left;">Profile Description:</h4>
        <p style="text-align: left; background: #f9f9f9; padding: 15px;">
            <?php echo nl2br(htmlspecialchars($profile['description'] ?? 'No description provided.')); ?>
        </p>
    </div>
</body>
