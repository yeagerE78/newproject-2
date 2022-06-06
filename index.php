<?php
error_reporting(0);
require_once('action/db.php');
try {

    $perpage = 20;
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
    <link rel="stylesheet" href="style.css?v=3" />
    <script src="jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

        });
    </script>
    <title>Fkaseries ดูซีรี่ย์ฟรีออนไลท์ 24 ชั่วโมงที่นี่</title>
</head>

<body class="bg-dark">
    <nav class="navbar bg-dark navbar-expand-lg bg-light ps-5 py-3 border-bottom border-light">
        <div class="container-fluid">
            <a class="navbar-brand text-light" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">หน้าแรก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">หนังทั้งหมด</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            หมวดหมู่
                        </a>
                        <ul class="dropdown-menu bg-dark" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item text-white" href="#">Breaking Bad</a></li>
                            <li><a class="dropdown-item text-white" href="#">Marvel</a></li>
                            <li><a class="dropdown-item text-white" href="#">Prison Break</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-3">
        <div class="new mb-2">
            <div class="w-100 d-flex">
                <p class="h5 text-light ms-5 me-3">อัปเดตใหม่ล่าสุด</p>
                <p><a href="#" class="text-warning">ดูทั้งหมด</a></p>
            </div>
            <div class=" d-flex flex-row flex-wrap justify-content-start ps-5">
                <?php for ($i = 1; $i < 2; $i++) {
                ?>
                    <div class="bg-success m-2 ms-0">
                        <div class="cat">
                            <img class="cat-img" src="image/bts.jpg" alt="">
                            <p class="cat-p">Lorem ipsum dolor sit, amet consectetur adipisicing.</p>
                        </div>
                    </div>
                    <div class="bg-primary m-2 ms-0">
                        <div class="cat">
                            <img class="cat-img" src="image/bts.jpg" alt="">
                            <p class="cat-p">Lorem ipsum dolor sit, amet consectetur adipisicing.</p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="breaking-bad mb-2">
            <div class="w-100 d-flex">
                <p class="h5 text-white ms-5 me-3">Breaking Bad</p>
                <p><a href="#" class="text-danger">ดูทั้งหมด</a></p>
            </div>
            <div class=" d-flex flex-row flex-wrap justify-content-start ps-5">
                <?php for ($i = 1; $i < 2; $i++) {
                ?>
                    <div class="bg-success m-2 ms-0">
                        <div class="cat">
                            <img class="cat-img" src="image/bts.jpg" alt="">
                            <p class="cat-p">Lorem ipsum dolor sit, amet consectetur adipisicing.</p>
                        </div>
                    </div>
                    <div class="bg-primary m-2 ms-0">
                        <div class="cat">
                            <img class="cat-img" src="image/bts.jpg" alt="">
                            <p class="cat-p">Lorem ipsum dolor sit, amet consectetur adipisicing.</p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="marvel">
            <div class="w-100 d-flex">
                <p class="h5 text-white ms-5 me-3">Marvel</p>
                <p><a href="#" class="text-danger">ดูทั้งหมด</a></p>
            </div>
            <div class=" d-flex flex-row flex-wrap justify-content-start ps-5">
                <?php for ($i = 1; $i < 2; $i++) {
                ?>
                    <div class="bg-success m-2 ms-0">
                        <div class="cat">
                            <img class="cat-img" src="image/bts.jpg" alt="">
                            <p class="cat-p">Lorem ipsum dolor sit, amet consectetur adipisicing.</p>
                        </div>
                    </div>
                    <div class="bg-primary m-2 ms-0">
                        <div class="cat">
                            <img class="cat-img" src="image/bts.jpg" alt="">
                            <p class="cat-p">Lorem ipsum dolor sit, amet consectetur adipisicing.</p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <footer class="bg-dark w-100 border-top py-3">
        <p class="text-center text-white">© 2022 Company, Inc</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
</body>

</html>