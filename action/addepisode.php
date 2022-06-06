<?php

require_once('db.php');
session_start();

$id  = $_GET['_id'];

try {
    $stmt = $conn->prepare('SELECT * FROM data WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $chapter = $row['chapter'];
} catch (PDOException $e) {
    echo $e->getMessage();
}

if (isset($_POST['addepisode'])) {
    for ($i = 1; $i < $chapter + 1; $i++) {
        if (empty($_POST['episode' . $i])) {
            $_SESSION['error'] = 'กรุณาใส่ข้อมูลให้ครบทุกช่อง';
            header('location:../addepisode.php?_id=' . $id);
            break;
        } else {
            $episode = $_POST['episode' . $i];
            try {
                $insert_stmt = $conn->prepare("INSERT INTO episode(dataid, part,url) VALUES (:dataid, :part,:url)");
                $insert_stmt->bindParam(':dataid', $id);
                $insert_stmt->bindParam(':part', $i);
                $insert_stmt->bindParam(':url', $episode);
                $insert_stmt->execute();
            } catch (PDOException $e) {
                $_SESSION['error'] = "ไม่สามารถเพิ่มข้อมูล " . $e->getMessage();
            }
        }
        $_SESSION['success'] = "เพิ่มข้อมูลในตารางเรียบร้อย";
        header('location:../addepisode.php?_id=' . $id);
    }
}
