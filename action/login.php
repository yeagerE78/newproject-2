<?php
require_once('db.php');
session_start();

if (isset($_POST['login'])) {
    if (empty($_POST['username'])) {
        $_SESSION['error'] = 'กรุณาใส่ username';
        header('location:../login.php');
    } else if (empty($_POST['password'])) {
        $_SESSION['error'] = 'กรุณาใส่ password';
        header('location:../login.php');
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];
        try {
            $check_data = $conn->prepare("SELECT * FROM users WHERE username = :username");
            $check_data->bindParam(":username", $username);
            $check_data->execute();
            $row = $check_data->fetch(PDO::FETCH_ASSOC);

            if ($check_data->rowCount() > 0) {
                if ($username == $row['username']) {
                    if (($password = $row['password'])) {
                        $_SESSION['admin'] = $row['id'];
                        header("location: ../dashboard.php");
                    } else {
                        $_SESSION['error'] = 'password ผิด';
                        header("location: ../login.php");
                    }
                } else {
                    $_SESSION['error'] = 'username ผิด';
                    header("location: ../login.php");
                }
            } else {
                $_SESSION['error'] = "ไม่มีข้อมูลในระบบ " . $check_data->rowCount();
                header("location: ../login.php");
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "ไม่สามารถเข้าสู่ระบบ" . $e->getMessage();
        }
    }
}
