<?php
session_start();
if (isset($_SESSION['level'])) {
    header("Location: dashboard.php");
    exit;
}
require 'functions/config.php';

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $pas  = md5($pass);
    $sql  = mysqli_query($conn, "SELECT * FROM users WHERE username = '$user' AND password = '$pas'");
    $row  = mysqli_fetch_array($sql);
    $username = $row['username'];
    $password = $row['password'];
    $level    = $row['level'];

    if ($user == $username && $pas == $password) {
        $_SESSION['level'] = $level;
        header("Location: dashboard.php");
    } else {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - FMJ Farma</title>
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        body {
            background: #f7f7f7;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 900px;
            max-width: 100%;
        }
        .login-image {
            width: 50%;
            height: auto;
        }
        .login-form {
            padding: 30px;
            width: 50%;
        }
        .login-form h3 {
            margin-bottom: 20px;
            font-weight: bold;
            color: #222366;
        }
        .form-control {
            margin-bottom: 20px;
            height: 45px;
            border-radius: 5px;
            box-shadow: none;
            border: 1px solid #ddd;
        }
        .btn-primary {
            background-color: #222366;
            border: none;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #1a1a56;
        }
        .form-group a {
            display: block;
            text-align: right;
            color: #222366;
            text-decoration: none;
        }
        .form-group a:hover {
            text-decoration: underline;
        }
        .brand {
            text-align: center;
            margin-bottom: 30px;
        }
        .brand h1 {
            font-size: 2.5em;
            font-weight: bold;
            color: #222366;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="assets/img/login.png" alt="Login Image" class="login-image">
        <div class="login-form">
            <div class="brand">
                <h1>FMJ Farma</h1>
            </div>
            <h3 class="text-center">Login Admin</h3>
            <?php if (isset($error)) : ?>
                <p style="color: red; font-style: italic;">Username / Password Salah!</p>
            <?php endif; ?>
            <form action="" method="post">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Username" autocomplete="off" autofocus />
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" name="password" autocomplete="off" />
                </div>
                <div class="form-group">
                    <input type="submit" name="login" class="btn btn-primary form-control" value="Login">
                </div>
                <div class="form-group">
                    <a href="#">Forgot Password?</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
