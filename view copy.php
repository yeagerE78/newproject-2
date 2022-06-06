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
    <link rel="stylesheet" href="view.css?v=1">
    <title>ดูซีรี่ย์ฟรีออนไลท์ 24 ชั่วโมงที่นี่</title>
</head>

<body class="bg-white">

    <?php include('navbar.php'); ?>

    <div class="container bg-white px-4 mt-2">
        <div class="row">

            <div class="col-12 mb-1" style="height: auto;">
                <div class="row">
                    <?php for ($i = 0; $i <= 1; $i++) { ?>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 p-0 d-blcok">
                            <img class="cat-ads" src="Hydra888.gif" alt="">
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="col-12 mb-1" style="min-height:10px;height:auto;">
                <div class="row">
                    <div class="col-12 d-flex flex-wrap justify-content-center" style="min-height: 10px;height:auto">
                        <div class=" catmain bg-light mb-2 view mt-1 py-4" style="height:fit-content; width:fit-content;">
                            <div class="w-100 d-flex flex-row">
                                <div class="col-12 d-flex justify-content-center ">
                                    <img class="cat mb-3" src="image/<?php echo $row_data['image'] ?>" alt="<?php echo $row_data['title'] ?>" style="width:100%;">
                                </div>
                            </div>
                            <p class=" h3 cat text-dark p-1 text-center text-capitalize my-2"><?php echo $row_data['title'] ?></p>
                            <div class="w-100 d-flex justify-content-center mb-2">
                                <iframe allow="fullscreen" style="margin:0 auto;" class="ggggd" src="<?php echo $row_if['url'] ?>" frameborder="0"></iframe>
                            </div>
                            <div class="d-flex justify-content-center my-2">
                                <a href="#" class="btn btn-outline-primary disabled p-1">สำรอง1</a>
                                <a href="#" class="btn btn-outline-primary disabled p-1 mx-1">สำรอง2</a>
                                <a href="#" class="btn btn-outline-primary disabled p-1">สำรอง3</a>
                            </div>
                            <?php
                            if ($stmt->rowCount() == 1) {
                            } else {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <div class="w-100 p-1 d-flex justify-content-center">
                                        <a class="text-center text-capitalize text-decoration-none" href="view.php?id=<?php echo $id ?>&ep=<?php echo $row['part'] ?>"><?php echo $row_data['title'] ?> ตอนที่ <?php echo $row['part'] ?></a>
                                    </div>
                            <?php }
                            } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12" style="height: auto;">
                <div class="row">
                    <?php for ($i = 0; $i <= 1; $i++) { ?>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 p-0 d-blcok">
                            <img class="cat-ads" src="Hydra888.gif" alt="">
                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
    <div class="container-fluid p-0" style="position:absolute;">
        <div class="bg-dark p-1" style="height:auto;">
            <p class="text-center text-white">
                Copyright ©lizavalentine 2022 fkaseries ดูซีรี่ย์ออนไลน์ ดูซีรี่ย์ หนังดูซีรี่ย์ฟรี ดูซีรี่ย์ใหม่ 2022
            </p>
        </div>
    </div>
</body>

</html>