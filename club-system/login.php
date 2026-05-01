<?php 
include 'config.php';

if($_POST) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: dashboard.php");
        exit;
    } else {
        header("Location: index.php?error=Invalid email or password");
        exit;
    }
}
?>