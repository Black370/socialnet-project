<?php 
session_start(); 
if (!isset($_SESSION['username'])) { 
    header("Location: signin.php"); 
    exit(); 
}
?>
<!DOCTYPE html>
<html>
<body style="font-family: Arial; padding: 20px;">
    <?php include "menubar.php"; ?>
    
    <h2>About Page</h2>
    
    <p><strong>Student Name:</strong> Static content</p>
    <p><strong>Student Number:</strong> Static content</p>
    
</body>
</html>
