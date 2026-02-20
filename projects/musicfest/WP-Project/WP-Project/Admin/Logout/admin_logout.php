<?php
session_start();

// Check if the session exists
if (isset($_SESSION["admin_email"])) {
    session_unset(); //clear all session variables
    session_destroy();//destroy session
    

    // Redirect to the home page
    header("Location: admin_logout.php");
    exit(); // Stop further execution after redirect

} else {
    // If no session exists, display the message
    $message = "No session exists or session has expired. Please log in again.";
    $redirectLink = "/WP-Project/Admin/Login/admin_login.html";
    $linkText = "Click here to return to login page.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link href="style.css" rel="stylesheet">
</head>
<body class="logout-section">
    <!-- Background Image Section -->
    <div class="logout-container">
        <h1>Logout Successful</h1>
        <p class="logout-message"><?php echo $message; ?></p>
        <a href="<?php echo $redirectLink; ?>" class="logout-btn"><?php echo $linkText; ?></a>
    </div>
</body>
</html>