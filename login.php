<?php
include 'Functions/connectdb.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $conn = Connect();
  $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc(); // get full user info
    $_SESSION['user'] = $user;      // store full user record
    header("Location: dashboard.php");
    exit;
  } else {
    echo "Invalid login!";
  }
  $conn->close();
}
?>
