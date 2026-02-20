<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login Validation</title>
</head>

<body>
<?php
    $con=mysqli_connect("localhost", "root", "","music_festival") or die("Cannot connect to server");
    
    $mail=$_POST["mail"];
    $password=$_POST["password"];
    
    $sql="Select * from users where email='$mail'";
    $result=mysqli_query($con,$sql);
    
    if(mysqli_num_rows($result)== 0){
        $page = 'xMail';
        include 'sessionError.php';
        exit();
    }
    
    else{
        $data=mysqli_fetch_array($result,MYSQLI_BOTH);
    
        if($data['password']==$password){
            session_start();
            $_SESSION["email"]= $mail;
            header("Location:/WP-Project/User/Dashboard/MainPage/userDashboard.php");
        }
        else{
            $page = 'xPassword';
            include 'sessionError.php';
            exit();
        }
    }
?>
</body>
</html>