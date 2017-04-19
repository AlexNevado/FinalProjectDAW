<?php
session_start();
include 'functions.php';

?>
<!DOCTYPE html>
<html>
<head>
  <title>Monstruos's Bizarre Adventure</title>
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
        <h2> Monstruos's Bizarre Adventure</h2><br/>
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