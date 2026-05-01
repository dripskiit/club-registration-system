<?php 
include 'config.php';
if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$activity_id = $_POST['activity_id'];

// 检查人数是否已满
$count = $pdo->prepare("SELECT COUNT(*) as cnt FROM registrations WHERE activity_id=?");
$count->execute([$activity_id]);
$cnt = $count->fetch()['cnt'];

$max = $pdo->prepare("SELECT max_participants FROM activities WHERE id=?");
$max->execute([$activity_id]);
$max_num = $max->fetch()['max_participants'];

if($cnt >= $max_num) {
    header("Location: dashboard.php?error=full");
    exit;
}

// 检查是否已报名
$check = $pdo->prepare("SELECT * FROM registrations WHERE user_id=? AND activity_id=?");
$check->execute([$user_id, $activity_id]);

if($check->rowCount() == 0) {
    $stmt = $pdo->prepare("INSERT INTO registrations (user_id, activity_id) VALUES (?,?)");
    $stmt->execute([$user_id, $activity_id]);
    header("Location: dashboard.php?success=1");
} else {
    header("Location: dashboard.php?error=already");
}
exit;
?>