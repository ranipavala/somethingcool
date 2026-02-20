<?php
// Start the session
session_start();
// Check if the session variable 'email' exists
if (!isset($_SESSION["email"])) {
  $page = 'xSession';
  include 'sessionError.php';
  exit();
}
$user = $_SESSION["email"]; // Assign session value to $user
$con=mysqli_connect("localhost", "root", "","music_festival") or die("Cannot connect to server.".mysqli_error($con));
$fname = $_POST["fullname"];
$contact = $_POST["contact"];
$password = $_POST["password"];

$sql="SELECT * FROM users WHERE email='$user'";
$update_sql="UPDATE users SET fullname='$fname', contact='$contact', password ='$password' WHERE email='$user'";
$sql_result=mysqli_query($con,$update_sql);
if($sql_result){
    $page = 'successUpt';
    include 'sessionError.php';
    exit();
}
else{
    $page = 'errorUpt';
    include 'sessionError.php';
    exit();
}
?>