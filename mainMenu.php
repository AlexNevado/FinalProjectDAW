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
</head>
<body>
<script></script>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <!-- title -->
            <img src="image/login_image1.png" class="col-xs-8 col-xs-offset-2 img-responsive loginImage"/>
<<<<<<< HEAD
=======
            <div class="col-xs-12">
                <h2> Monstruos's Bizarre Adventure <img src="image/number2.png" width="50" height="50" alt="image number 2"></h2><br/>
            </div>
>>>>>>> e7337a212b390f3de57394d6c570a5f6b86d4b97
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
                <h2> Monstruos's Bizarre Adventure <img src="image/number2.png" width="50" height="50" alt="image number 2"></h2>
        </div>
    </div>
    </div>
    <!-- begins menu -->
     <div class="row">
        <div class="col-xs-12">
            <button type="" class="btn btn-sm btn-menu-principal" id="searchBattle">Buscar batalla</button>
        </div>
    </div>
     <div class="row">
        <div class="col-xs-12">
            <button type="" class="btn btn-sm btn-menu-principal" id="perfil">Perfil</button>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <button type="" class="btn btn-sm btn-menu-principal" id="options">Opciones</button>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <button type="" class="btn btn-sm btn-menu-principal" id="exit">Salir</button>
        </div>
    </div>
    <!-- ends menu -->
    <div class="row">
        <div class="col-xs-12">
            <a href="validate.php?logout" class="btn btn-login btn-sm">Logout</a>
        </div>
    </div>
    <?php footer() ?>
</div>

</body>
</html>