<?php
session_start();
include 'functions.php';

if (isset($_SESSION["Authenticated"]) && $_SESSION["Authenticated"] == 1) {
  header("Location: home.php");
}
// Añadir a la base de datos
/*
 db.miscellaneous.insert({skills:[{id:0,name:"Fireball",power:4},{id:1,name:"Punch",power:3},{id:2,name:"Drain",power:1},{id:3,name:"Thunder",power:4}],
items:[{id:0, name:"Poción", power:6, type:'cure', img:'image/items/potion_xs.png', price:10},
{id:1, name:"SuperPoción", power:12 , type:"cure", img:'image/items/potion_s.png', price:50},
{id:2, name:"Bomba", power:5, type:"damage", img:'image/items/bomb.png', price:100},
{id:3, name:"Revivir", power:2, type:"cure", img:'image/items/feather.png', price:1000}]})
*/
?>
<!DOCTYPE html>
<html>
<head>
  <title>Monstruos' Bizarre Adventure 2</title>
  <script src="js/jquery-3.2.1.min.js"></script>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col-xs-12" role="main">
      <div class="row">
        <img src="image/login_image1.png" class="col-xs-8 col-xs-offset-2 img-responsive loginImage"/>
      </div>
      <div class="row">
        <h2> Monstruos' Bizarre Adventure <img src="image/number2.png" width="50" height="50" alt="image number 2"></h2><br/>
        <fieldset class="form-group col-xs-4 col-sm-offset-4 col-xs-offset-1">
          <legend>
            <a href="index.php" <?php if (!isset($_GET["register"])) {
              print 'class="activeSection"';
            } ?>>Login</a>
            /
            <a href="index.php?register" <?php if (isset($_GET["register"])) {
              print 'class="activeSection"';
            } ?>>Registro</a>
          </legend>
          <?php
          if (isset($_GET["register"])) {
            register();
          } else {
            login();
          }
          ?>
        </fieldset>
      </div>
    </div>
  </div>
  <?php footer() ?>
</div>
</body>
</html>