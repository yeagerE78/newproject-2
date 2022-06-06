<?php
session_start();
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

            $("#addSeries").click(function() {
                if (!confirm("!ยืนยันที่จะเพิ่มซีรี่ย์!")) {
                    return false;
                }
            });
        });
    </script>
    <title>Addseries</title>
</head>

<body class="bg-white">
    <div class="container-sm mt-3">
        <!-- input series form -->
        <form action="action/addseries.php" method="post" enctype="multipart/form-data">

            <!-- input ชื่อเรื่อง -->
            <div class="mb-3">
                <label for="title text-dark" class="form-label">ชื่อเรื่อง</label>
                <textarea class="form-control mb-2" name="title" rows="1"></textarea>
                <span class="text-success mb-2">*ใส่ ชื่อ ปี ซีซั่นที่ฉาย ชื่อภาษาไทย <br> ถูก better call saul season 1 (2015) มีปัญหา ปรึกษาซอล</span> <br>
                <span class="text-danger text-capitalize">*ห้ามใส่ตัวอักษรภาษาอังกฤษตัวใหญ่ <br> ผิด better call saul season 1 (2015) มีปัญหา ปรึกษาซอล </span>
            </div>

            <!-- input รูปภาพ -->
            <div class="mb-3">
                <label for="image text-dark" class="form-label">เพิ่มรูปภาพ</label>
                <input class="form-control mb-2" type="file" name="image">
                <span class="text-success">*รองรับเฉพาะรูปภาพสกุล jpg และ png </span> <br>
                <span class="text-danger">*ไม่รองรับภาพรูปภาพสกุล gif </span>
            </div>
            <div class="mb-3">
                <label for="chapter text-dark" class="form-label">จำนวนตอน</label>
                <input class="form-control mb-2" type="number" name="chapter">
                <span class="text-success">*ใส่แค่ตัวเลข </span> <br>
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


            <button class="btn btn-success" type="submit" name="addseries" id="addSeries">ตกลง</button>
            <a href="dashboard.php" class="btn btn-danger">กลับไปหน้าแรก</a>
        </form>

    </div>
</body>

</html>