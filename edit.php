<?php
require_once('action/db.php');
session_start();

if (isset($_GET['_id'])) {
    $id = $_GET['_id'];
    try {
        $stmt = $conn->prepare('SELECT * FROM data WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    header('location:dashboard.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script src="jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            $("#edit").click(function() {
                if (!confirm("!ยืนยันที่จะแก้ไข")) {
                    return false;
                }
            });
        });
    </script>
    <title>แก้ไขซีรี่ย์</title>
</head>

<body class="bg-white">
    <div class="container-sm mt-2">
        <h2 class="text-capitalize"><?php echo $row['title'] ?></h2>

        <!-- input series form -->
        <form action="action/edit.php?_id=<?php echo $_GET['_id'] ?>" method="post" enctype="multipart/form-data">

            <!-- input ชื่อเรื่อง -->
            <div class="mb-3">
                <label for="title" class="form-label">แก้ไขชื่อเรื่อง</label>
                <textarea class="form-control mb-2" name="title" rows="1"><?php echo $row['title'] ?></textarea>
                <span class="text-success mb-2">*ใส่ ชื่อ ปี ซีซั่นที่ฉาย ชื่อภาษาไทย <br> ถูก better call saul season 1 (2015) มีปัญหา ปรึกษาซอล</span> <br>
                <span class="text-danger text-capitalize">*ห้ามใส่ตัวอักษรภาษาอังกฤษตัวใหญ่ <br> ผิด better call saul season 1 (2015) มีปัญหา ปรึกษาซอล </span>

            </div>

            <!-- input รูปภาพ -->
            <div class="mb-3">
                <img while="150" height="150" class="mb-4" src="image/<?php echo $row['image'] ?>" alt="<?php echo $row['title'] ?>"> <br>
                <label for="image" class="form-label mb-2">แก้ไขรูปภาพ</label>
                <input class="form-control mb-2" type="file" name="image">
                <span class="text-success">*รองรับเฉพาะรูปภาพสกุล jpg และ png </span> <br>
                <span class="text-danger">*ไม่รองรับภาพรูปภาพสกุล gif </span>
            </div>

            <!-- alert box -->
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
            <?php if (isset($_SESSION['i-error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                    echo $_SESSION['i-error'];
                    unset($_SESSION['i-error']);
                    ?>
                </div>
            <?php } ?>
            <?php if (isset($_SESSION['i-success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php
                    echo $_SESSION['i-success'];
                    unset($_SESSION['i-success']);
                    ?>
                </div>
            <?php } ?>
            <?php if (isset($_SESSION['c-error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                    echo $_SESSION['c-error'];
                    unset($_SESSION['c-error']);
                    ?>
                </div>
            <?php } ?>
            <?php if (isset($_SESSION['c-success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php
                    echo $_SESSION['c-success'];
                    unset($_SESSION['c-success']);
                    ?>
                </div>
            <?php } ?>


            <button class="btn btn-success" type="submit" name="edit" id="edit">ตกลง</button> 
            <a href="dashboard.php" class="btn btn-danger">กลับไปหน้าแรก</a>
        </form>

    </div>
</body>

</html>