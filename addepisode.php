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
        $chapter = $row['chapter'];
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    header('location:dashboard.php');
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    try {
        $delete_id = $_GET['delete_id'];
        $delete_stmt = $conn->prepare("DELETE FROM episode WHERE dataid =:id");
        $delete_stmt->bindParam(':id', $delete_id);
        if ($delete_stmt->execute()) {
            $_SESSION['success'] = 'ลบข้อมูลเรียบร้อย';
            header('location:addepisode.php?_id=' . $id);
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "ไม่สามารถลบข้อมูล" . $e->getMessage();
    }
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
            $("#deleteAll").click(function() {
                if (!confirm("ยืนยันที่จะลบทั้งหมด???")) {
                    return false;
                }
            });

        });
    </script>
    <title>เพิ่มตอนซีรี่ย์</title>
</head>

<body class="bg-white">
    <div class="container-sm mt-3">
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
        <form action="action/addepisode.php?_id=<?php echo $id ?>" method="post" enctype="multipart/form-data">

            <?php
            for ($i = 1; $i < $chapter + 1; $i++) {
            ?>
                <div class="mb-3">
                    <label for="episode<?php echo $i ?>" class="form-label">EP : <?php echo $i ?></label>
                    <textarea class="form-control mb-2" name="episode<?php echo $i ?>" rows="1"></textarea>
                </div>
            <?php } ?>
            <!-- alert box -->

            <button class="btn btn-success" type="submit" name="addepisode">ตกลง</button>
            <a href="dashboard.php" class="btn btn-primary">กลับไปหน้าแรก</a>
        </form>

        <?php
        try {
            $stmt_ep = $conn->prepare('SELECT * FROM episode WHERE dataid = :id');
            $stmt_ep->bindParam(':id', $id);
            $stmt_ep->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        } ?>
        <table>
            <table class="table mb-3 text-dark mt-3">
                <thead>

                    <tr>
                        <th scope="col">ชื่อเรื่อง</th>
                        <th scope="col">ตอนที่เพิ่มแล้ว(<?php echo $stmt_ep->rowCount() ?>)</th>
                        <th scope="col">ลิ้ง</th>
                    </tr>

                </thead>
                <tbody>

                    <?php
                    while ($row_ep = $stmt_ep->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr class="pb-4">
                            <td><?php echo $row['title'] ?></td>
                            <td><?php echo $row_ep['part'] ?></td>
                            <td><?php echo $row_ep['url'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </table>
        <a href="addepisode.php?_id=<?php echo $id ?>&delete_id=<?php echo $id ?>" class="btn btn-danger mb-4" id="deleteAll">ลบข้อมูลทั้งหมด</a>
    </div>
</body>

</html>