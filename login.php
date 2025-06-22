<?php 
require 'db.php';
session_start();
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['submit'])){
    $email=$_POST['email'];
    $password=$_POST['password'];

    $sql="SELECT * FROM users WHERE email='$email'";
    $result=mysqli_query($conn,$sql);
    if(!$result){
        echo "failed:". mysqli_error($conn);
    }
    else {
        if(mysqli_num_rows($result)>0){
              $user=mysqli_fetch_assoc($result);
             if(password_verify($password,$user['password'])){
                  $_SESSION['userid']=$user['id'];
                  $_SESSION['username']=$user['name'];
                  $_SESSION['userrole']=$user['role'];
                  $_SESSION['email']=$user['email'];
                  header("Location: displayPost.php");
                  exit();
             }else{
                    $messageBox = true;
                    $messageTitle = "Login Failed";
                    $messageText = "Incorrect password. Please try again.";
                    $messageType = "error";
             }

        }else {
            $messageBox = true;
            $messageTitle = "Login Failed";
            $messageText = "No account found with that email. Please register.";
            $messageType = "error";
        }
    }};
    
 if (isset($_SESSION['messageBox']) && $_SESSION['messageBox']) {
    $messageBox = true;
    $messageType = $_SESSION['messageType'] ?? 'info';
    $messageTitle = $_SESSION['messageTitle'] ?? 'Message';
    $messageText = $_SESSION['messageText'] ?? '';

    
    unset($_SESSION['messageBox']);
    unset($_SESSION['messageType']);
    unset($_SESSION['messageTitle']);
    unset($_SESSION['messageText']);
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BlogPost</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="message.css">
</head>
<body>
    <div class="container">
        <div class="left">
            <div class="logo"><span class="logo-icon"></span>BlogPost</div>
            <div class="welcome-title">Selam, <br />Welcome Back</div>
            <div class="welcome-desc">Hey, welcome back to your special place</div>
            <form class="login-form" action="login.php" method="POST">
                <input type="email" name="email" placeholder="stanley@gmail.com" required>
                <input type="password" name="password" placeholder="••••••••••••••" required>
                <button class="login-btn" type="submit" name="submit">Sign In</button>
            </form>
            <div class="signup-link">Don't have an account? <a href="register.php">Sign Up</a></div>
            <?php include 'message-box.php'; ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>