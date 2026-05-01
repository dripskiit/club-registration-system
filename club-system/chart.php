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
    <title>Registration Statistics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .container { width:85%; margin:30px auto; }
        canvas { margin-top:20px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Activity Registration Chart</h2>
    <a href="dashboard.php">Back to Home</a>
    <canvas id="chart"></canvas>
</div>

<?php
// 取出所有活动（包括0人）
$acts = $pdo->query("SELECT * FROM activities");
$labels = [];
$counts = [];

foreach ($acts as $a) {
    $labels[] = $a['title'];
    
    // 查报名人数
    $c = $pdo->prepare("SELECT COUNT(*) FROM registrations WHERE activity_id=?");
    $c->execute([$a['id']]);
    $counts[] = (int)$c->fetchColumn();
}
?>

<script>
new Chart(document.getElementById("chart"), {
    type: "bar",
    data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
            label: "Registrations",
            data: <?php echo json_encode($counts); ?>,
            backgroundColor: [
                "#007bff",
                "#28a745",
                "#dc3545",
                "#ffc107"
            ]
        }]
    },
    options: {
        scales: {
            y: { beginAtZero: true, ticks: { precision:0 } }
        }
    }
});
</script>
</body>
</html>