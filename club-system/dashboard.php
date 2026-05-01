<?php 
include 'config.php';
if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .activity-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 18px;
            background-color: #f0f4f8;
        }
        .activity-card {
            border: 1px solid #e2e8f0;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 10px;
            background: white;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        .activity-card h3 {
            font-size: 22px;
            color: #222;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="nav">
        <h2>Welcome, <?php echo $_SESSION['user_name']; ?></h2>
        <a href="dashboard.php">Home</a>
        <a href="my_registrations.php">My Registrations</a>
        <a href="view_all_registrations.php">All Registrations</a>
        <a href="chart.php">Statistics Chart</a>
        <a href="logout.php">Logout</a>
    </div>

    <h3>Available Club Activities</h3>

    <?php if(isset($_GET['success'])): ?>
        <div class="success">Registered successfully!</div>
    <?php endif; ?>

    <?php if(isset($_GET['error'])): ?>
        <div class="error">
            <?php if($_GET['error']=='full') echo 'Activity is full!'; ?>
            <?php if($_GET['error']=='already') echo 'You already registered!'; ?>
        </div>
    <?php endif; ?>

    <?php
    $stmt = $pdo->query("SELECT * FROM activities");
    $activities = $stmt->fetchAll();

    foreach($activities as $act):
    ?>
    <div class="activity-card">
        <img src="images/<?php echo $act['activity_image']; ?>" 
             alt="<?php echo $act['title']; ?>" 
             class="activity-img">
        
        <h3><?php echo $act['title']; ?></h3>
        <p><?php echo $act['description']; ?></p>
        <p><strong>Event Date:</strong> <?php echo $act['event_date']; ?></p>
        <p><strong>Max Participants:</strong> <?php echo $act['max_participants']; ?></p>
        
        <form action="register_activity.php" method="post" style="margin-top:10px;">
            <input type="hidden" name="activity_id" value="<?php echo $act['id']; ?>">
            <button type="submit">Join This Activity</button>
        </form>

        <!-- 管理员删除按钮 -->
        <?php if($_SESSION['role'] == 'admin'): ?>
        <form method="post" action="delete_activity.php" onsubmit="return confirm('Delete?')">
            <input type="hidden" name="activity_id" value="<?php echo $act['id']; ?>">
            <button type="submit" style="background:red; margin-top:8px;">Delete Activity</button>
        </form>
        <?php endif; ?>

    </div>
    <?php endforeach; ?>
</div>
</body>
</html>