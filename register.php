<?php
require 'db.php';
session_start();
if($_SERVER["REQUEST_METHOD"]== "POST" && isset($_POST['submit']))
{
    $name=$_POST['username'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $role=$_POST['role'];
    $password=password_hash($password,PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (name, email, password, role) 
            VALUES ('$name', '$email', '$password', '$role')";
    $result=mysqli_query($conn,$sql);
    if (!$result) {
        $_SESSION['messageBox'] = true;
        $_SESSION['messageType'] = 'error';
        $_SESSION['messageTitle'] = 'Error';
        $_SESSION['messageText'] = 'Registration failed: ' . mysqli_error($conn);
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['messageBox'] = true;
        $_SESSION['messageType'] = 'success';
        $_SESSION['messageTitle'] = 'Registration Complete';
        $_SESSION['messageText'] = 'Your account has been created. You can now log in.';
        header("Location: login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - BlogPost</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="register.css">
  <link rel="stylesheet" href="message.css">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Inter', Arial, sans-serif;
      background: #ededf2;
    }
    .container {
      display: flex;
      min-height: 100vh;
      align-items: center;
      justify-content: center;
    }
    .left {
      background: #fff;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 60px 48px 40px 80px;
      min-width: 350px;
      max-width: 480px;
      box-shadow: 0 4px 32px 0 rgba(60, 72, 88, 0.10);
      border-radius: 24px;
      margin: 0 auto;
    }
    .logo {
      font-weight: 900;
      color: #6f6ee8;
      font-size: 1.1rem;
      letter-spacing: 1px;
      margin-bottom: 32px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .logo-icon {
      width: 18px;
      height: 18px;
      background: #a18fff;
      border-radius: 4px;
      display: inline-block;
    }
    .welcome-title {
      font-size: 2.3rem;
      font-weight: 900;
      margin: 0 0 10px 0;
      color: #232323;
    }
    .welcome-desc {
      color: #888;
      font-size: 1.08rem;
      margin-bottom: 32px;
    }
    .register-form {
      display: flex;
      flex-direction: column;
      gap: 18px;
    }
    .register-form input[type="text"],
    .register-form input[type="email"],
    .register-form input[type="password"],
    .register-form select {
      padding: 13px 16px;
      border: 1.5px solid #e0e0e0;
      border-radius: 8px;
      font-size: 1.08rem;
      background: #f7f7fa;
      outline: none;
      transition: border-color 0.2s;
    }
    .register-form input:focus,
    .register-form select:focus {
      border-color: #a18fff;
    }
    .register-btn {
      margin-top: 10px;
      padding: 13px 0;
      background: #6f6ee8;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 1.13rem;
      font-weight: 700;
      cursor: pointer;
      transition: background 0.18s;
      box-shadow: 0 2px 8px 0 rgba(79, 140, 255, 0.10);
    }
    .register-btn:hover {
      background: #a18fff;
    }
    .login-link {
      margin-top: 38px;
      text-align: left;
      color: #888;
      font-size: 1.01rem;
    }
    .login-link a {
      color: #6f6ee8;
      text-decoration: none;
      font-weight: 600;
      margin-left: 4px;
      transition: color 0.18s;
    }
    .login-link a:hover {
      color: #a18fff;
      text-decoration: underline;
    }
    @media (max-width: 900px) {
      .container {
        flex-direction: column;
        min-height: unset;
      }
      .left {
        border-radius: 24px;
        min-width: 0;
        max-width: 100vw;
        padding: 32px 12vw;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="left">
      <div class="logo"><span class="logo-icon"></span>BlogPost</div>
      <div class="welcome-title">Create Your Account</div>
      <div class="welcome-desc">Sign up to get started with your special place</div>
      <form class="register-form" action="register.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role" required>
          <option value="" disabled selected>Select Role</option>
          <option value="author">Author</option>
          <option value="subscriber">Subscriber</option>
        </select>
        <button class="register-btn" type="submit" name="submit">Register</button>
      </form>
      <div class="login-link">Already have an account? <a href="login.php">Login</a></div>
      <?php include 'message-box.php'; ?>
    </div>
  </div>
  <?php include 'footer.php'; ?>
</body>
</html>