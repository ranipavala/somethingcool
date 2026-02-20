<?php
// Start session and check admin authentication
session_start();
// Check if the session variable 'admin_email' exists
if (!isset($_SESSION["admin_email"])) {
  $page = 'xAdminSession';
  include 'sessionError.php';
  exit();
}

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli("localhost", "root", "", "music_festival");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process deletion
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get and validate subevent ID
    $id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;

    if ($id <= 0) {
        $_SESSION['error_message'] = "Invalid subevent ID provided";
        header("Location: /WP-Project/Admin/SubEventManagement/subevent.php");
        exit();
    }

    // Prepare delete statement
    $delete_stmt = $conn->prepare("DELETE FROM subevent WHERE id = ?");
    if (!$delete_stmt) {
        $_SESSION['error_message'] = "Database error: " . $conn->error;
        header("Location: /WP-Project/Admin/SubEventManagement/subevent.php");
        exit();
    }

    $delete_stmt->bind_param("i", $id);

    if (!$delete_stmt->execute()) {
        $_SESSION['error_message'] = "Error deleting subevent: " . $delete_stmt->error;
    } else {
        $_SESSION['success_message'] = "Subevent deleted successfully";
    }

    $delete_stmt->close();
} else {
    $_SESSION['error_message'] = "Invalid request method";
}

$conn->close();
header("Location: /WP-Project/Admin/SubEventManagement/subevent.php");
exit();
?>
