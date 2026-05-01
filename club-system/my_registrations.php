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
    <title>My Registrations</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table { width:100%; border-collapse:collapse; margin-top:20px; }
        table,th,td { border:1px solid #ccc; }
        th,td { padding:12px; text-align:center; }
        th { background:#007bff; color:white; }
        tr:nth-child(even) { background:#f2f2f2; }
        .btn-danger { background:#dc3545; padding:8px 12px; color:white; border:none; border-radius:5px; }
    </style>
</head>
<body>
<div class="container">
    <div class="nav">
        <h2>My Registered Activities</h2>
        <a href="dashboard.php">Home</a>
        <a href="view_all_registrations.php">All Registrations</a>
        <a href="logout.php">Logout</a>
    </div>

    <table>
        <tr>
            <th>Activity</th>
            <th>Date</th>
            <th>Registered At</th>
            <th>Action</th>
        </tr>

        <?php
        $user_id = $_SESSION['user_id'];
        $stmt = $pdo->prepare("
            SELECT registrations.id, activities.title, activities.event_date, registrations.registered_at
            FROM registrations
            JOIN activities ON registrations.activity_id = activities.id
            WHERE registrations.user_id = ?
        ");
        $stmt->execute([$user_id]);

        while($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td>".$row['title']."</td>";
            echo "<td>".$row['event_date']."</td>";
            echo "<td>".$row['registered_at']."</td>";
            echo "<td>
                    <form method='post' action='unregister.php' onsubmit='return confirm(\"Cancel registration?\")'>
                        <input type='hidden' name='reg_id' value='".$row['id']."'>
                        <button type='submit' class='btn-danger'>Unregister</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
</body>
</html>