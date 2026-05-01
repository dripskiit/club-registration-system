<?php
include 'config.php';
if($_SESSION['role'] != 'admin') exit('Access denied');
?>

<h2>Upload Activity Image (Admin Only)</h2>
<form action="upload.php" method="post" enctype="multipart/form-data">
    Activity ID: <input type="number" name="id" required><br>
    Image: <input type="file" name="image" required><br>
    <button type="submit">Upload</button>
</form>