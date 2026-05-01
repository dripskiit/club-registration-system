<?php
include 'config.php';
if($_SESSION['role'] != 'admin') exit("Access denied");

if($_FILES['image']) {
    $name = $_FILES['image']['name'];
    $target = "images/".basename($name);
    move_uploaded_file($_FILES['image']['tmp_name'], $target);
    
    $id = $_POST['id'];
    $pdo->prepare("UPDATE activities SET activity_image=? WHERE id=?")->execute([$name,$id]);
    header("Location: dashboard.php");
}
?>