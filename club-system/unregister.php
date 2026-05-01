<?php
include 'config.php';
if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if($_POST['reg_id']) {
    $reg_id = $_POST['reg_id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("DELETE FROM registrations WHERE id=? AND user_id=?");
    $stmt->execute([$reg_id, $user_id]);
}

header("Location: my_registrations.php");
exit;
?>