<?php
error_reporting(0);
require_once('action/db.php');
try {

    $perpage = 24;
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    $start = ($page - 1) * $perpage;

    if (isset($_GET['category'])) {
        $category = $_GET['category'];
        $stmt_li = $conn->prepare('SELECT * FROM data WHERE category = :category LIMIT :start,:perpage');
        $stmt_li->bindValue(':category', $category, PDO::PARAM_STR);
    } else {
        $stmt_li = $conn->prepare('SELECT * FROM data LIMIT :start,:perpage');
    }

    $stmt_li->bindValue(':start', $start, PDO::PARAM_INT);
    $stmt_li->bindValue(':perpage', $perpage, PDO::PARAM_INT);
    $stmt_li->execute();

    $stmt = $conn->prepare('SELECT * FROM data');
    $stmt->execute();
    $total_record = $stmt->rowCount();
    $total_page = ceil($total_record / $perpage);
} catch (PDOException $e) {
    echo  $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="desciption" content="ดูซีรี่ย์ Netflix ฟรี หนังมาใหม่ 2022 ซับไทย พากย์ไทย ดูเต็มเรื่อง ฝรั่ง พากย์ไทย น่าดูมากที่สุด อัพเดตก่อนใคร.">
    <meta name="keywords" content="ดูซีรี่ย์, Netflix, หนังมาใหม่,ฟรี,2022">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css?v=5" />
    <script src="jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            $('li').each(
                    function() {
                        $(this).addClass('disabled');
                    }
                );

            $('#btnwd').click(function() {
                $('.bg').each(
                    function() {
                        $(this).toggleClass('bg-white bg-dark');
                    }
                );
                $('.txt').each(
                    function() {
                        $(this).toggleClass('text-dark text-white');
                    }
                );
            })



        });
    </script>
    <title>Fkaseries ดูซีรี่ย์ฟรีออนไลท์ 24 ชั่วโมงที่นี่</title>
</head>

<body class="bg-white bg">

    <?php include('navbar.php'); ?>

    <div class="container-fluid mt-2">
        <div class="row">
            <div class=" col-12 col-lg-9  mb-1" style="min-height:10px;height:auto;">

                <div class="row px-2">
                    <?php
                    while ($row = $stmt_li->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <div class="col-4 col-sm-4 col-md-3 col-lg-3 col-xl-2 p-0 pt-2 d-flex flex-wrap justify-content-center" style="min-height: 10px;height:auto">
                            <a target="_blank" href="view.php?id=<?php echo $row['id'] ?>">
                                <div class="mb-1 main position-relative" style="height:fit-content; width:fit-content;">
                                    <img src="image/<?php echo $row['image'] ?>" alt="<?php echo $row['title'] ?>">
                                    <p class="text-light p-1 text-center fw-lighter text-capitalize"><?php echo $row['title'] ?></p>
                                </div>
                            </a>
                        </div>
                    <?php
                    } ?>
                    <nav aria-label="Page navigation example" class="mt-3 d-flex justify-content-center">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="index.php?page=1">&laquo;</a></li>
                            <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                                <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php } ?>
                            <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $total_page; ?>">&raquo</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <div class="col-12 col-lg-3 mt-2 mb-4 ">
                <div class="row px-4">
                    <div class="col-12 p-0">
                        <ul class="list-group">
                            <li class="list-group-item bg bg-white"><a target="_blank" href="index.php?category=action" class="text-decoration-none txt text-dark">Action แอคชั่น</a></li>
                            <li class="list-group-item bg bg-white"><a target="_blank" href="index.php?category=mystery" class="text-decoration-none txt text-dark">Mystery ลึกลับ</a></li>
                            <li class="list-group-item bg bg-white"><a target="_blank" href="index.php?category=scifi" class="text-decoration-none txt text-dark">Sci-fi วิทยาศาสตร์</a></li>
                            <li class="list-group-item bg bg-white"><a target="_blank" href="index.php?category=horror" class="text-decoration-none txt text-dark">Horror สยองขวัญ</a></li>
                            <li class="list-group-item bg bg-white"><a target="_blank" href="index.php?category=romance" class="text-decoration-none txt text-dark">Romance โรแมนติก</a></li>
                            <li class="list-group-item bg bg-white"><a target="_blank" href="index.php?category=drama" class="text-decoration-none txt text-dark">Drama ดราม่า</a></li>
                            <li class="list-group-item bg bg-white"><a target="_blank" href="index.php?category=musical" class="text-decoration-none txt text-dark">Musical เพลง</a></li>
                            <li class="list-group-item bg bg-white"><a target="_blank" href="index.php?category=family" class="text-decoration-none txt text-dark">Family ครอบครัว</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
    <div class="container-fluid p-0" style="position:absolute; bottom: 0px;">
        <div class="bg-dark p-1" style="height:auto;">
            <p class="text-center text-white">
                Copyright ©lizavalentine 2022 fkaseries ดูซีรี่ย์ออนไลน์ ดูซีรี่ย์ หนังดูซีรี่ย์ฟรี ดูซีรี่ย์ใหม่ 2022
            </p>
        </div>
    </div>
</body>

</html>