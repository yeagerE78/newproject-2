<?php
require_once('db.php');
session_start();


if (isset($_POST['addcategory'])) {
    if ($_POST['categoryselected'] == "default") {
        $_SESSION['error'] = 'กรุณาเลือกหมวดหมู่';
        header('location:../category.php');
    } else if (empty($_POST['checklist'])) {
        $_SESSION['error'] = 'กรุณาเลือกหนังที่จะเพิ่มหมวดหมู่';
        header('location:../category.php');
    } else if (!empty($_POST['checklist'])) {
        $category = $_POST['addcategory'];
        foreach ($_POST['checklist'] as $check) {
            $id = $check;
            $category = $_POST['categoryselected'];
            try {
                $stmt = $conn->prepare('UPDATE data SET category=:category WHERE id=:id');
                $stmt->bindParam(':category', $category);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $_SESSION['success'] = 'เพิ่มหมวดหมู่เรียบร้อย';
                header('location:../category.php');
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
}
