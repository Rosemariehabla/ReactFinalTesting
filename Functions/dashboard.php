<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}
$user = $_SESSION['user'];
?>
<!doctype html>
<html>
<head>
  <title>Dashboard</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
 
  <div class="container mt-4">
    <h2>Welcome, <?= $user['role'] ?> (<?= $user['username'] ?>)!</h2>
    <p>This is your dashboard.</p>
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>

</body>
</html>
