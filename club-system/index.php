<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login / Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Club Activity Registration System</h2>

    <?php if(isset($_GET['msg'])): ?>
        <div class="success"><?php echo $_GET['msg']; ?></div>
    <?php endif; ?>

    <?php if(isset($_GET['error'])): ?>
        <div class="error"><?php echo $_GET['error']; ?></div>
    <?php endif; ?>

    <h3>Login</h3>
    <form action="login.php" method="post">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>

    <br><hr><br>

    <h3>Register</h3>
    <form action="register.php" method="post">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Register</button>
    </form>
</div>
</body>
</html>