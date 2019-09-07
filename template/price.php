<?php
include "../setting/config.php";
include "../include/include.php";

global $lng;
global $crt_lang_code;
if (isset($_GET['lang_id'])) {
    $lang_id = $_GET['lang_id'];
} else {
    $lang_id = $crt_lang_code;
}
session_start();


$result = $config->getAboutContentByCode($lang_id);
$about = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="<?php echo $crt_lang_code;?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href=" ">
    <title>Carpass Registration - Price</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/custom.css" rel="stylesheet">

    <link href="../css/loaders.css" rel="stylesheet">
    <link href="../css/swiper.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/animate.min.css">
    <link rel="stylesheet" href="../css/nivo-lightbox.css">
    <link rel="stylesheet" href="../css/nivo_themes/default/default.css">

    <link rel="stylesheet" href="/css/all.css" crossorigin="anonymous">
    <style>
        @media (max-width: 1023px) {
            .privacy-box p img {
                width: 100% !important;
                height: 20% !important;
            }
        }

    </style>
    <script>
        exdate=new Date();
        exdate.setDate(exdate.getDate() + 365);
    </script>
</head>
<body>
<?php
include "header.php";
?>

<div class="contact-sec info-panel parallax-section" style="background-size: cover; background-repeat: no-repeat;">
    <div class="container privacy mt-3">
        <h2>Price</h2>
        <div class="row pt-2">
            <div class="col-md-2"></div>
            <div class="col-md-8 privacy-box">
                <p><?php echo $about['content']; ?></p>
                <p><?php echo $about['content2']; ?></p>
                <p class="text-center">Carpass</p>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>
</div>


<?php
include('footer.php')
?>

<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/scrollPosStyler.js"></script>
<script src="../js/swiper.min.js"></script>
<script src="../js/isotope.min.js"></script>
<script src="../js/nivo-lightbox.min.js"></script>
<script src="../js/wow.min.js"></script>
<script src="../js/core.js"></script>

</body>
</html>
