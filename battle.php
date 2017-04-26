<?php
session_start();
include 'functions.php';

if (!isset($_SESSION["Authenticated"]) || $_SESSION["Authenticated"] == 0) {
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Monstruos's Bizarre Adventure</title>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
          integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
          crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/main.css">
        <script type="application/javascript">
      /*
ctx.drawImage(img, 0, 0, img.width,    img.height,     // source rectangle
                   0, 0, canvas.width, canvas.height);

      */
    function draw() {
      var canvas = document.getElementById('battleCanvas');
      if (canvas.getContext) {
        var ctx = canvas.getContext('2d');
        var imageObj1 = new Image();
        var imageObj2 = new Image();
        var tWidth = 800;
        var tHeight = 600;
       

        imageObj2.onload = function() {
          ctx.drawImage(imageObj2, 0, 20, tWidth, tHeight, 300, 0 ,tWidth,tHeight);

        }
        imageObj1.onload = function() {
          ctx.drawImage(imageObj1, 0, 0, tWidth, tHeight, 0, 300,tWidth, tHeight - tHeight * 0.25);
        };

        imageObj1.src = 'image/panel1.png';
        imageObj2.src = 'image/monstersAvatars/Dragon.png';


        //ctx.fillText("Habilidades",500,300);
      }
    }
  </script>
    <style type="text/css">
      #battleCanvas { border: 1px solid black; }
    </style>
</head>
<body onload="draw()">
<div class="container">
  <div class="row">
    <div class="col-xs-12" role="main">
      <div class="row">
        <div class="col-xs-12">
          <div class="screen">
            <div class="col-sm-4 col-sm-offset-8 col-xs-offset-6 menu-options">
              <h3>Habilidades</h3>
              <h3>Objetos</h3>
              <h3>Cambio</h3>
            </div>
          </div>
          <div class="screen messsage-screen"> </div>
          <canvas id="battleCanvas" width="640" height="480"></canvas>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-1 col-xs-offset-9">
          <a href="validate.php?logout" class="btn btn-login btn-sm">Logout</a>
        </div>
      </div>
    </div>
  </div>
  <?php footer() ?>
</div>
</body>
</html>