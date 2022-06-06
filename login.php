<?php
require_once('action/db.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
</head>

<body class="text-left">
    <main class="form-signin w-100 m-auto">
        <form method="post" action="action/login.php">
            <img width="300" height="260" class="mb-4" src="logo.jpg" alt="logo">
            <div class="mb-2">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username">
            </div>
            <div class="mb-2">
                <label for="password">Password</label>
                <input type="password" class="form-control mb-2" name="password">
            </div>
            <button class="w-100 fs-5 btn btn-lg btn-primary" type="submit" name="login">เข้าสู่ระบบ</button>
            <p class="mt-2 text-danger text-center">@lizavalentine</p>
            <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>
            <?php if (isset($_SESSION['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php } ?>
        </form>
    </main>

</body>

</html>