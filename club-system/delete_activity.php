<?php
include 'config.php';
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: dashboard.php");
    exit;
}

if($_POST['activity_id']) {
    $id = $_POST['activity_id'];
    $pdo->prepare("DELETE FROM activities WHERE id=?")->execute([$id]);
}

header("Location: dashboard.php");
?>