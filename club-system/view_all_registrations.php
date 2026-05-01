<?php 
include 'config.php';
if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 3;
$offset = ($page - 1) * $limit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Registrations</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table { width:100%; border-collapse:collapse; margin-top:20px; }
        table,th,td { border:1px solid #ccc; }
        th,td { padding:12px; text-align:center; }
        th { background:#007bff; color:white; }
        tr:nth-child(even) { background:#f2f2f2; }
        .table-img { width:80px; height:50px; object-fit:cover; }
        .search-box { margin:20px 0; text-align:center; }
        .search-box input { padding:8px; width:250px; }
        .search-box button { padding:8px 16px; background:#007bff; color:white; border:none; }
        .pagination { margin-top:20px; text-align:center; }
        .pagination a { padding:8px 12px; margin:0 4px; background:#007bff; color:white; text-decoration:none; border-radius:4px; }
    </style>
</head>
<body>
<div class="container">
    <div class="nav">
        <h2>All Registrations</h2>
        <a href="dashboard.php">Home</a>
        <a href="my_registrations.php">My Registrations</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="search-box">
        <form method="get">
            <input type="text" name="search" placeholder="Search name/activity" value="<?php echo htmlspecialchars($search)?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <table>
        <tr>
            <th>Image</th>
            <th>Student</th>
            <th>Activity</th>
            <th>Time</th>
        </tr>
        <?php
        if($search) {
            $stmt = $pdo->prepare("SELECT registrations.id, users.name, activities.title, activities.activity_image, registrations.registered_at FROM registrations JOIN users ON registrations.user_id=users.id JOIN activities ON registrations.activity_id=activities.id WHERE users.name LIKE ? OR activities.title LIKE ? LIMIT $offset,$limit");
            $stmt->execute(["%$search%","%$search%"]);
        } else {
            $stmt = $pdo->query("SELECT registrations.id, users.name, activities.title, activities.activity_image, registrations.registered_at FROM registrations JOIN users ON registrations.user_id=users.id JOIN activities ON registrations.activity_id=activities.id ORDER BY registrations.id DESC LIMIT $offset,$limit");
        }
        while($row = $stmt->fetch()) {
            echo "<tr>
            <td><img src='images/{$row['activity_image']}' class='table-img'></td>
            <td>{$row['name']}</td>
            <td>{$row['title']}</td>
            <td>{$row['registered_at']}</td>
            </tr>";
        }
        ?>
    </table>

    <div class="pagination">
        <a href="?page=<?php echo $page-1; ?>&search=<?php echo $search?>">Previous</a>
        <a href="?page=<?php echo $page+1; ?>&search=<?php echo $search?>">Next</a>
    </div>
</div>
</body>
</html>