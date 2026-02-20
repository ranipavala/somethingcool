<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $ic = $_POST['ic'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Check if email already exists
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {   
        $page = 'mailExist';
        include 'sessionError.php';
        exit();
    } else {
        if ($password === $confirm) {
            $stmt = $conn->prepare("INSERT INTO users (fullname, username, email, contact, ic, password) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $fullname, $username, $email, $contact, $ic, $password);

            if ($stmt->execute()) {
                echo "
                <!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <title>Registration Success</title>
                    <style>
                        html, body {
                            margin: 0;
                            padding: 0;
                            height: 100%;
                            font-family: 'Copperplate', fantasy;
                            background: transparent;
                        }
                        #bgVideo {
                            position: fixed;
                            top: 0;
                            left: 0;
                            min-width: 100vw;
                            min-height: 100vh;
                            object-fit: cover;
                            z-index: -2;
                        }
                        .overlay {
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100vw;
                            height: 100vh;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            background-color: rgba(0, 0, 0, 0.4);
                            backdrop-filter: blur(8px);
                            color: white;
                            font-size: 26px;
                            text-align: center;
                            z-index: 2;
                            cursor: pointer;
                        }
                    </style>
                </head>
                <body onclick=\"window.location.href='/WP-Project/User/Login/login.html'\">
                    <video autoplay muted loop playsinline id='bgVideo'>
                        <source src='background.mp4' type='video/mp4'>
                    </video>
                    <div class='overlay'>Registration Successful!<br>Click anywhere to continue.</div>
                </body>
                </html>
                ";
            } else {
                echo "<p>Error: " . $stmt->error . "</p>";
            }
        } else {
            $page = 'pwdWrong';
            include 'sessionError.php';
            exit();
        }
    }
}
?>
