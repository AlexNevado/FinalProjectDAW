 <?php
session_start();
include 'functions.php';
require_once __DIR__ . '/vendor/autoload.php';

if (!isset($_SESSION["Authenticated"]) || $_SESSION["Authenticated"] == 0) {
header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Monstruos's Bizarre Adventure 2</title>
    <script src="js/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <style>#slider { margin: 10px; }   </style>
</head>
<body>
<script></script>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <!-- title -->
            <img src="image/login_image1.png" class="col-xs-8 col-xs-offset-2 img-responsive loginImage"/>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
                <h2> Options</h2>
        </div>
    </div>
    </div>
    <!-- begins options menu -->
    <div class="row">
        <div class="col-xs-12">
            <div id="slider"></div>
        </div>
    </div>
    <?php footer() ?>
</div>
<script>
    $("#slider").slider();
</script>
</body>
</html>