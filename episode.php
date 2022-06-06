<?php
require_once('action/db.php');
session_start();
if (!isset($_SESSION['admin'])) {
    $_SESSION['error'] = 'กรุณาล็อคอินเข้าสู่ระบบ';
    header('location:login.php');
}

try {
    $stmt = $conn->prepare('SELECT * FROM episode ORDER BY id asc');
    $stmt->execute();
} catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=,initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script src="jquery-3.6.0.min.js"></script>
    <title>episode</title>
</head>

<body class="bg-white">
    <div class="container-sm mt-2">
        <a class="btn btn-success mb-4 mt-2" href="dashboard.php">กลับไปหน้าหน้าตารางซีรี่ย์ทั้งหมด</a>
        <table class="table mb-2 text-dark mt-3" id="table">
            <form method="get" class="mb-2">
                <input id="search" type="search" name="search" class="form-control" placeholder="ค้นหาโดยใช้ชื่อ">
            </form>
            <thead>
                <tr>
                    <th scope="col">ชื่อเรื่อง</th>
                    <th scope="col">ตอนที่</th>
                    <th scope="col">ลิ้ง</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td>
                            <?php
                            $id = $row['dataid'];
                            try {
                                $stmt_data = $conn->prepare('SELECT * FROM data WHERE id = :id');
                                $stmt_data->bindParam(':id', $id);
                                $stmt_data->execute();
                                $rowdata = $stmt_data->fetch(PDO::FETCH_ASSOC);
                                echo $rowdata['title'];
                            } catch (PDOException $e) {
                                $_SESSION['error'] = $e->getMessage();
                            }

                            ?>
                        </td>
                        <td class="text-capitalize">
                            <?php echo $row['part'] ?>
                        </td>
                        <td><?php echo $row['url'] ?></td>

                    </tr>
                <?php } ?>
            </tbody>
        </table>
        </table>
    </div>
</body>

</html>