<?php
require_once('action/db.php');
try {
    $id = $_GET['id'];

    $stmt_data = $conn->prepare('SELECT * FROM data WHERE id = :id');
    $stmt_data->bindParam(':id', $id);
    $stmt_data->execute();
    $row_data = $stmt_data->fetch(PDO::FETCH_ASSOC);


    $stmt = $conn->prepare('SELECT * FROM episode WHERE dataid = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if (isset($_GET['ep'])) {
        $ep = $_GET['ep'];
        $stmt_if = $conn->prepare('SELECT * FROM episode WHERE part = :ep');
        $stmt_if->bindParam(':ep', $ep);
        $stmt_if->execute();
        $row_if = $stmt_if->fetch(PDO::FETCH_ASSOC);
    } else {
        $ep = 1;
        $stmt_if = $conn->prepare('SELECT * FROM episode WHERE dataid = :ep');
        $stmt_if->bindParam(':ep', $ep);
        $stmt_if->execute();
        $row_if = $stmt_if->fetch(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo  $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css?v=1">
    <title>ดูซีรี่ย์ฟรีออนไลท์ 24 ชั่วโมงที่นี่</title>
</head>

<body class="bg-white">
    <div class="container">
        <?php include('navbar.php'); ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
</body>

</html>