<?php
session_start();
$admin = 'admin';
$pass = 'toor';
if($_POST['submit']){
 if($admin == $_POST['user'] AND $pass == $_POST['pass']){
 $_SESSION['admin'] = $admin;
 header("Location: index.php");
 exit;
 }else echo '<p>Логин или пароль неверны!</p>';
}
if($_SESSION['admin']){
    header("Location: index.php");
    exit;
   }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PC Builder</title>

    <link type="text/css" href="/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="/css/main.css" rel="stylesheet">
    <link type="text/css" href="/css/bootstrap-icons.css" rel="stylesheet">
    <script
            src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="/js/products.js"></script>
</head>
<body>
    <div class="login-form-wrapper">
        <div class="form-box">
            <form method="post" action="">
                <div class="mb-3">
                    <label for="inputLogin" class="form-label">Login</label>
                    <input type="login" name="user" class="form-control" id="inputLogin" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="inputPassword" class="form-label">Password</label>
                    <input type="password" name="pass" class="form-control" id="inputPassword">
                </div>
                <input type="submit" class="btn btn-primary" name="submit" value="Войти" />
            </form>

        </div>
    </div>
</body>