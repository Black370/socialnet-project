<?php
session_start();
require_once "db.php";
if (!isset($_SESSION['username'])) { header("Location: signin.php"); exit(); }

$current_user = $_SESSION['username'];
$current_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_friend_id'])) {
    $friend_id = $_POST['add_friend_id'];
    $conn->query("INSERT IGNORE INTO friends (user_id, friend_id) VALUES ($current_id, $friend_id)");
    header("Location: home.php"); exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    $msg = trim($_POST['message']);
    $stmt = $conn->prepare("INSERT INTO posts (author, message) VALUES (?, ?)");
    $stmt->bind_param("ss", $current_user, $msg);
    $stmt->execute();
    header("Location: home.php"); exit();
}

$me = $conn->query("SELECT fullname FROM account WHERE username = '$current_user'")->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<body style="font-family: Arial; padding: 20px; background: #f0f2f5;">
    <?php include "menubar.php"; ?>
    
    <div style="display: flex; gap: 20px;">
        <div style="flex: 2; background: white; padding: 20px; border-radius: 8px;">
            <h3>Post an Update</h3>
            <form method="POST">
                <textarea name="message" rows="3" style="width: 100%;" required></textarea><br>
                <button type="submit" style="margin-top: 10px;">Post</button>
            </form>
            <hr>
            <h3>Live Feed</h3>
            <?php
            $posts = $conn->query("SELECT author, message, created_at FROM posts ORDER BY created_at DESC");
            while($row = $posts->fetch_assoc()) {
                echo "<p><strong>{$row['author']}</strong> <em>{$row['created_at']}</em><br>" . nl2br(htmlspecialchars($row['message'])) . "</p><hr>";
            }
            ?>
        </div>

        <div style="flex: 1; background: white; padding: 20px; border-radius: 8px;">
            <h3>My Info</h3>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($current_user); ?></p>
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($me['fullname']); ?></p>
            <hr>
            
            <h3>My Friends</h3>
            <ul>
            <?php
            $friends = $conn->query("SELECT a.username, a.fullname FROM account a JOIN friends f ON a.id = f.friend_id WHERE f.user_id = $current_id");
            while ($row = $friends->fetch_assoc()) {
                echo "<li>{$row['fullname']} (<a href='profile.php?owner={$row['username']}'>Profile</a>)</li>";
            }
            ?>
            </ul>

            <h3>Other Users (Strangers)</h3>
            <ul>
            <?php
            $strangers = $conn->query("SELECT id, username, fullname FROM account WHERE id != $current_id AND id NOT IN (SELECT friend_id FROM friends WHERE user_id = $current_id)");
            while ($row = $strangers->fetch_assoc()) {
                echo "<li>{$row['fullname']} (<a href='profile.php?owner={$row['username']}'>Profile</a>)
                      <form method='POST' style='display:inline;'><input type='hidden' name='add_friend_id' value='{$row['id']}'><button type='submit'>Add</button></form></li>";
            }
            ?>
            </ul>
        </div>
    </div>
</body>
</html>
