<?php
require_once('action/db.php');
session_start();

if (isset($_GET['search'])) {
    try {
        $search = '%' . $_GET['search'] . '%';
        $stmt = $conn->prepare('SELECT * FROM data WHERE title LIKE :search ORDER BY id desc');
        $stmt->bindParam(':search', $search);
        $stmt->execute();
        if ($stmt->rowCount() < 0) {
            $_SESSION['error'] = 'ไม่มีข้อมูล';
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
        header('location:dashboard.php');
    }
} else {
    try {
        $stmt = $conn->prepare('SELECT * FROM data ORDER BY id desc');
        $stmt->execute();
    } catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
        header('location:dashboard.php');
    }
}

if (isset($_GET['clear'])) {
    unset($_GET['search']);
    header('location:dashboard.php');
}

if (!isset($_SESSION['admin'])) {
    $_SESSION['error'] = 'กรุณาล็อคอินเข้าสู่ระบบ';
    header('location:login.php');
}

if (isset($_GET['delete_id'])) {
    try {
        $delete_id = $_GET['delete_id'];
        $stmt = $conn->prepare("SELECT * FROM data WHERE id =:id");
        $stmt->bindParam(':id', $delete_id);
        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (unlink("image/" . $row['image'])) {
                try {
                    $delete_id = $_GET['delete_id'];
                    $delete_stmt = $conn->prepare("DELETE FROM data WHERE id =:id");
                    $delete_stmt->bindParam(':id', $delete_id);

                    $delete_stmt_ep = $conn->prepare("DELETE FROM episode WHERE dataid =:id");
                    $delete_stmt_ep->bindParam(':id', $delete_id);
                    $delete_stmt_ep->execute();

                    if ($delete_stmt->execute()) {
                        header('location:dashboard.php');
                    }
                } catch (PDOException $e) {
                    $_SESSION['error'] = "ไม่สามารถลบข้อมูล" . $e->getMessage();
                }
            }
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "ไม่สามารถลบรูปภาพ" . $e->getMessage();
    }
    header('location:dashboard.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- add bootstrap and jquery sweetalert -->
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script src="jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#tableShow").click(function() {
                $('#table').fadeToggle(500);
                $('#search').fadeToggle(500);
            });

            $("#logOut").click(function() {
                if (!confirm("ยืนยันที่จะออกจากระบบ???")) {
                    return false;
                }
            });

            $("#delete").click(function() {
                if (!confirm("ยืนยันที่จะลบ???")) {
                    return false;
                }
            });

        });
    </script>
    <title>Dashboard</title>
</head>

<body class="bg-white">
    <div class="container-sm mt-4 bg-white">
        <a href="addseries.php" class="btn btn-primary mb-4">เพิ่มซีรี่ย์</a>
        <a href="category.php" class="btn btn-info text-white mb-4 disabled">เพิ่มหมวดหมู่</a>
        <button class="btn btn-danger mb-4" id="tableShow">แสดงตาราง/ซ่อนตาราง</button>
        <a class="btn btn-success mb-4" href="episode.php">หน้าตารางตอนซีรี่ย์ทั้งหมด</a>
        <a href="?clear" class="btn btn-warning mb-4 text-white">ยกเลิก/Clear</a>

        <a href="index.php" class=" btn btn-outline-danger mb-4">หน้าแรก</a>
        <a href="action/logout.php" id="logOut" class=" btn btn-secondary mb-4">ออกจากระบบ</a>

        <table>
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

            <table class="table mb-2 text-dark mt-3" id="table">
                <form method="get" class="mb-2">
                    <input id="search" type="search" name="search" class="form-control bg-light text-dark" placeholder="ค้นหาโดยใช้ชื่อ">
                </form>
                <thead>
                    <tr>
                        <th scope="col">ไอดี (<?php echo $stmt->rowCount() ?>)</th>
                        <th scope="col">ชื่อเรื่อง</th>
                        <th scope="col">รูปภาพ</th>
                        <th scope="col">ตอน</th>
                        <th scope="col">หมวดหมู่</th>
                        <th scope="col">แก้ไข/ลบ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                        <tr>
                            <th scope="row">
                                <?php echo $row['id'] ?>
                            </th>
                            <td class="text-capitalize">
                                <?php echo $row['title'] ?>
                            </td>
                            <td>
                                <img width="160" height="200" src="image/<?php echo $row['image'] ?>" alt="<?php echo $row['title'] ?>">
                            </td>
                            <td><?php echo $row['chapter'] ?></td>
                            <td><?php
                                if ($row['category'] == '') {
                                    echo 'ยังไม่มีหมวดหมู่';
                                } else {
                                    echo $row['category'];
                                } ?></td>
                            <td>
                                <a href="addepisode.php?_id=<?php echo $row['id'] ?>" class="btn btn-primary">เพิ่ม/ลบตอนซีรี่ย์</a>
                                <a href="edit.php?_id=<?php echo $row['id'] ?>" class="btn btn-secondary">แก้ไข</a>
                                <a href="?delete_id=<?php echo $row['id'] ?>" class="btn btn-danger" id="delete">ลบ</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </table>
    </div>
</body>

</html>