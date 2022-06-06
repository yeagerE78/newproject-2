<?php
require_once('db.php');
session_start();

if (isset($_POST['addseries'])) {

    if (empty($_POST['title'])) {
        $_SESSION['error'] = 'กรุณาใส่ชื่อเรื่อง';
        header('location:../addseries.php');
    } else if ($_FILES['image']['size'] == 0) {
        $_SESSION['error'] = 'กรุณาใส่รูปภาพ';
        header('location:../addseries.php');
    } else if (empty($_POST['chapter'])) {
        $_SESSION['error'] = 'กรุณาใส่ตอน';
        header('location:../addseries.php');
    } else {
        $title = $_POST['title'];
        $image = $_FILES['image']['name'];
        $chapter = $_POST['chapter'];
        $filename = $_FILES["image"]["name"];
        $tempname = $_FILES["image"]["tmp_name"];
        $folder = "../image/" . $filename;
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg') {
            $_SESSION['i-error']  = 'ไม่รองรับไฟล์ประเภทนี้';
            header('location:../addseries.php');
        } else if (move_uploaded_file($tempname, $folder)) {
            try {
                $insert_stmt = $conn->prepare("INSERT INTO data(title, image,chapter) VALUES (:title, :image,:chapter)");
                $insert_stmt->bindParam(':title', $title);
                $insert_stmt->bindParam(':image', $image);
                $insert_stmt->bindParam(':chapter', $chapter);
                if ($insert_stmt->execute()) {
                    $_SESSION['success'] = "เพิ่มข้อมูลในตารางเรียบร้อย";
                    $_SESSION['i-success']  = 'เพิ่มรูปภาพเรียบร้อย';
                    header('location:../addseries.php');
                }
            } catch (PDOException $e) {
                $_SESSION['error'] = "ไม่สามารถเพิ่มข้อมูล " . $e->getMessage();
                unlink("../image/" . $filename);
                $_SESSION['i-error']  = 'ลบรูปภาพเรียบร้อย';
                header('location:../addseries.php');
            }
        } else {
            $_SESSION['i-error']  = 'ไม่สามารถเพิ่มรูปภาพ';
        }
    }
}
