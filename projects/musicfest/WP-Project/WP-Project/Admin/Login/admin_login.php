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
    
    $sql="Select * from administrators where admin_email='$mail'";
    $result=mysqli_query($con,$sql);
    
    if(mysqli_num_rows($result)== 0){
        $page = 'xAdminMail';
        include 'sessionError.php';
    }
    
    else{
        $data=mysqli_fetch_array($result,MYSQLI_BOTH);
    
        if($data['password']==$password){
            session_start();
            $_SESSION["admin_email"]= $mail;
            header("Location:/WP-Project/Admin/Dashboard/admindashboard.php");
        }
        else{
            $page = 'xAdminPassword';
            include 'sessionError.php';
        }
           
    }
?>
</body>
</html>