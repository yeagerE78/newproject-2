<?php
require_once('action/db.php');
session_start();

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $category = '';
    try {
        $stmt = $conn->prepare('UPDATE data SET category=:category WHERE id=:id');
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        header('location:category.php');
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


?>

้้
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
            $("#delete").click(function() {
                if (!confirm("ยืนยันที่จะหมวดหมู่???")) {
                    return false;
                }
            });

        });
    </script>
    <title>เพิ่มหมวดหมู่</title>
</head>

<body>
    <div class="container-sm mt-4 bg-white">
        <a class="btn btn-success mb-4 mt-2" href="dashboard.php">กลับไปหน้าหน้าตารางซีรี่ย์ทั้งหมด</a>
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
        <form action="action/category.php" method="post">
            <select class="form-select mb-2" name="categoryselected">
                <option selected value="default">เพิ่มหมวดหมู่</option>
                <option value="action">Action แอคชั่น</option>
                <option value="mystery">Mystery ลึกลับ</option>
                <option value="scifi">Sci-fi วิทยาศาสตร์</option>
                <option value="horror">Horror สยองขวัญ</option>
                <option value="Romance">Romance โรแมนติก</option>
                <option value="drama">Drama ดราม่า</option>
                <option value="musical">Musical เพลง</option>
                <option value="family">Family ครอบครัว</option>
            </select>

            <?php
            $b = '';
            $stmt = $conn->prepare('SELECT * FROM data WHERE category = :b');
            $stmt->bindParam(':b', $b);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="form-check">
                    <input type="checkbox" name="checklist[]" value="<?php echo $row['id'] ?>">
                    <label class="form-check-label text-capitalize" for="checklist[]">
                        <?php echo $row['title'] ?>
                    </label>
                </div>
            <?php } ?>

            <button class="btn btn-danger my-2" type="submit" name="addcategory">เพิ่มหมวดหมู่</button>
        </form>


        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ไอดี</th>
                    <th scope="col">ชื่อเรื่อง</th>
                    <th scope="col">รูปภาพ</th>
                    <th scope="col">หมวดหมู่</th>
                    <th scope="col">#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $bc = '';
                $stmt_ct = $conn->prepare('SELECT * FROM data WHERE category <> :bc');
                $stmt_ct->bindParam(':bc', $bc);
                $stmt_ct->execute();
                while ($row_ct = $stmt_ct->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?php echo $row_ct['id'] ?></td>
                        <td class="text-capitalize"><?php echo $row_ct['title'] ?></td>
                        <td><img width="160" height="200" src="image/<?php echo $row_ct['image'] ?>" alt="<?php echo $row['title'] ?>"></td>
                        <td><?php echo $row_ct['category'] ?></td>
                        <td><a href="?delete_id=<?php echo $row_ct['id'] ?>" class="btn btn-danger" id="delete">ลบหมวดหมู่</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>