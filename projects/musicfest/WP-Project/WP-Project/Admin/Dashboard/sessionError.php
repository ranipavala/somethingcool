<!DOCTYPE html>
<html>
<head>
    <title>Session Expired</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js for interactivity -->
    <script src="https://unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="style.css">
</head>

<body x-data="{ open: true, darkMode: false, openLogoutModal: false }" :class="darkMode ? 'dark' : ''">
    <!--Link to session expired page-->
    <?php if ($page == 'xSession') { ?>
        <div class="logout-section">
            <div class="logout-container">
            <p class="logout-message">No session exist or session is expired. Please log in again</p>
                <a class="logout-btn" href="/WP-Project/User/Login/login.html">Click here to return to login page.</a>
            </div>
        </div>
    <?php } ?>
    
    <!--Link to email does not exit page-->
    <?php if ($page == 'xMail') { ?>
        <div class="logout-section">
            <div class="logout-container">
                <h1 class="text-2xl font-bold mb-6">/Email does not exist/</h1>
                <p class="logout-message">Please try again</p>
                <div class="flex gap-4">
                <a class="logout-btn-g" href="/WP-Project/User/Signup/signup.html">Create Account</a>
                <a class="logout-btn" href="/WP-Project/User/Login/login.html">Login Again</a>
                </div>
            </div>
        </div>
    <?php } ?>
    
    <!--Link to password wrong page-->
    <?php if ($page == 'xPassword') { ?>
        <div class="logout-section">
            <div class="logout-container">
                <h1 class="text-2xl font-bold mb-6">/Password Wrong/</h1>
                <p class="logout-message">Please try again</p>
                <a class="logout-btn" href="/WP-Project/User/Login/login.html">Click here to return to login page.</a>
            </div>
        </div>
    <?php } ?>

    <!--Link to no ticket page-->
    <?php if ($page == 'xTicket') { ?>
        <div class="logout-section">
            <div class="logout-container">
                <p class="logout-message">You haven't purchased any tickets yet.</p>
                <a  class="logout-btn" href="/WP-Project/User/Dashboard/Purchase/purchase.php">Click here to buy a ticket.</a>
            </div>
        </div>
    <?php } ?>

    <!--Link to Success Update Profile-->
    <?php if ($page == 'successUpt') { ?>
        <div class="logout-section">
            <div class="logout-container">
                <p class="logout-message">Succesfully update the data.</p>
                <a  class="logout-btn" href="/WP-Project/User/Dashboard/Account/userProfile.php">View your account here.</a>
            </div>
        </div>
    <?php } ?>

    <!--Link to Error Update Profile-->
    <?php if ($page == 'errorUpt') { ?>
        <div class="logout-section">
            <div class="logout-container">
                <p class="logout-message">Error in updating the data.</p>
                <a  class="logout-btn" href="/WP-Project/User/Dashboard/Account/userProfile.php">Return to your accoun</a>
            </div>
        </div>
    <?php } ?>
    
    <!--Link to Password X Match page-->
    <?php if ($page == 'pwdWrong') { ?>
        <div class="logout-section">
            <div class="logout-container">
                <p class="logout-message">Passwords do not match.</p>
                <a  class="logout-btn" href="/WP-Project/User/Signup/signup.html">Sign Up here</a>
            </div>
        </div>
    <?php } ?>
    
    <!--Link to email exist page-->
    <?php if ($page == 'mailExist') { ?>
        <div class="logout-section">
            <div class="logout-container">
                <p class="logout-message">Email is already registered. Please use a different email address.</p>
                <a  class="logout-btn" href="/WP-Project/User/Signup/signup.html">Try Again</a>
            </div>
        </div>
    <?php } ?>

    <!--Link to admin's mail x exist page-->
    <?php if ($page == 'xAdminMail') { ?>
        <div class="logout-section">
            <div class="logout-container">
                <h1 class="text-2xl font-bold mb-6">/Email does not exist/</h1>
                <p class="logout-message">Please try again</p>
                <a class="logout-btn" href="/WP-Project/Admin/Login/admin_login.html">Click here to return to login page.</a>
            </div>
        </div>
    <?php } ?>
    
    <!--Link to admin's password wrong page-->
    <?php if ($page == 'xAdminPassword') { ?>
        <div class="logout-section">
            <div class="logout-container">
                <h1 class="text-2xl font-bold mb-6">/Password Wrong/</h1>
                <p class="logout-message">Please try again</p>
                <a class="logout-btn" href="/WP-Project/Admin/Login/admin_login.html">Click here to return to login page.</a>
            </div>
        </div>
    <?php } ?>

    <!--Link to ADMIN session expired page-->
    <?php if ($page == 'xAdminSession') { ?>
        <div class="logout-section">
            <div class="logout-container">
            <p class="logout-message">No session exist or session is expired. Please log in again</p>
                <a class="logout-btn" href="/WP-Project/Admin/Login/admin_login.html">Click here to return to login page.</a>
            </div>
        </div>
    <?php } ?>
</body>
</html>