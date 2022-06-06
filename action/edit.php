<?php
require_once('db.php');
session_start();
$id = $_GET['_id'];

if (isset($_POST['edit'])) {

    if (empty($_POST['title'])) {
        $_SESSION['error'] = 'กรุณาใส่ชื่อเรื่อง';
        header('location: ../edit.php?_id=' . $id);
    } else {
        $title = $_POST['title'];
        $chapter = $_POST['chapter'];
        try {
            $stmt = $conn->prepare('SELECT * FROM data WHERE id=:id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($title == $row['title']) {
                $_SESSION['error'] = 'ไม่ได้แก้ไขชื่อเรื่อง';
                header('location: ../edit.php?_id=' . $id);
            } else {
                try {
                    $stmt_update = $conn->prepare('UPDATE data SET title=:title WHERE id=:id');
                    $stmt_update->bindParam(':title', $title);
                    $stmt_update->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt_update->execute();
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                $_SESSION['success'] = 'แก้ไขชื่อเรื่องเรียบร้อย';
                header('location: ../edit.php?_id=' . $id);
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
     
    }
    if ($_FILES['image']['size'] == 0) {
        $_SESSION['i-error'] = 'ไม่ได้แก้ไขรูปภาพ';
        header('location: ../edit.php?_id=' . $id);
    } else {
        $image = $_FILES['image']['name'];
        $filename = $_FILES["image"]["name"];
        $tempname = $_FILES["image"]["tmp_name"];
        $folder = "../image/" . $filename;
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if ($ext != 'jpg' && $ext != 'png') {
            $_SESSION['i-error']  = 'ไม่รองรับไฟล์ประเภทนี้';
            header('location: ../edit.php?_id=' . $id);
        } else if (move_uploaded_file($tempname, $folder)) {
            try {
                $stmt_update = $conn->prepare('UPDATE data SET image=:image WHERE id=:id');
                $stmt_update->bindParam(':image', $image);
                $stmt_update->bindParam(':id', $id, PDO::PARAM_INT);
                if ($stmt_update->execute()) {
                    $_SESSION['i-success'] = 'แก้ไขรูปภาพเรียบร้อย';
                    header('location: ../edit.php?_id=' . $id);
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
}
