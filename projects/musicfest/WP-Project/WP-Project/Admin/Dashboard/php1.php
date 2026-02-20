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
    // Get and validate user ID
    $id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;

    if ($id <= 0) {
        $_SESSION['error_message'] = "Invalid user ID provided";
        header("Location: /WP-Project/Admin/Dashboard/admindashboard.php");
        exit();
    }

    // Check if user has event registrations
    $check_stmt = $conn->prepare("SELECT COUNT(*) as registration_count FROM event_registrations WHERE userID = ?");
    if (!$check_stmt) {
        $_SESSION['error_message'] = "Database error: " . $conn->error;
        header("Location: /WP-Project/Admin/Dashboard/admindashboard.php");
        exit();
    }

    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    $row = $result->fetch_assoc();
    $check_stmt->close();

    if ($row['registration_count'] > 0) {
        $_SESSION['error_message'] = "Cannot delete user - they have registered for events";
        header("Location: /WP-Project/Admin/Dashboard/admindashboard.php");
        exit();
    }

    // Prepare statement to delete user
    $delete_stmt = $conn->prepare("DELETE FROM users WHERE userID = ?");
    if (!$delete_stmt) {
        $_SESSION['error_message'] = "Database error: " . $conn->error;
        header("Location: /WP-Project/Admin/Dashboard/admindashboard.php");
        exit();
    }

    $delete_stmt->bind_param("i", $id);
    
    if (!$delete_stmt->execute()) {
        $_SESSION['error_message'] = "Error deleting user: " . $delete_stmt->error;
    } else {
        $_SESSION['success_message'] = "User deleted successfully";
    }

    $delete_stmt->close();
} else {
    $_SESSION['error_message'] = "Invalid request method";
}

$conn->close();
header("Location: /WP-Project/Admin/Dashboard/admindashboard.php");
exit();
?>