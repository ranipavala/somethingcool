<?php
// Start the session
session_start();
// Check if the session variable 'email' exists
if (!isset($_SESSION["admin_email"])) {
  $page = 'xAdminSession';
  include 'sessionError.php';
  exit();
}
$admin = $_SESSION["admin_email"]; // Assign session value to $user
$con=mysqli_connect("localhost", "root", "","music_festival") or die("Cannot connect to server.".mysqli_error($con));
$password = $_POST["password"];

$sql="SELECT * FROM administrators WHERE admin_email='$admin'";
$update_sql="UPDATE administrators SET password ='$password' WHERE admin_email='$admin'";
$sql_result=mysqli_query($con,$update_sql);
if($sql_result){
    $page = 'successAdminUpt';
    include 'sessionError.php';
    exit();
}
else{
    $page = 'errorAdminUpt';
    include 'sessionError.php';
    exit();
}
?>