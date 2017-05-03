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
  <!-- <script src="js/jquery-3.2.1.min.js"></script>
  <script src="https://code.jquery.com/jquery-migrate-3.0.0.js"></script>-->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script> -->
  <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/main.css">
  <script src="js/jcanvas/jcanvas.js"></script>
  <script type="application/javascript">
    /*
     ctx.drawImage(img, 0, 0, img.width,    img.height,     // source rectangle
     0, 0, canvas.width, canvas.height);

     */
    var enemy = {
      _id: "5900cb0c47864ae7038b4567",
      userID: "58fa1e7647864a930c8b4567",
      name: "dragoncito",
      img: "image/monstersAvatars/Dragon.png",
      characteristics: [{
        str: 10,
        def: 10,
        luk: 10,
        hp: 20
      }],
      abilities: [{
        abi1: "Hab1"
      }],
      draw: function() {
        var canvas = document.getElementById('battleCanvas');
        var ctx = canvas.getContext('2d');
        var monstruo = new Image();
        imageMonstruo.src = 'image/monstersAvatars/Dragon.png';

      }
    };

    $(document).ready(function () {

      // Draw a pentagon
      $("#battleCanvas").drawPolygon({
        draggable: true,
        fillStyle: "#6c3",
        x: 100, y: 100,
        radius: 50, sides: 5
      });
      $('#battleCanvas').drawImage({
        draggable: true,
        source: 'image/panel1.png',
        x: 0, y: 300,
        width: 800,
        height: 180,
        fromCenter: false
      });
    });





    function startBattle() {
      var canvas = document.getElementById('battleCanvas');

      if (canvas.getContext) {
        var ctx = canvas.getContext('2d');
        var imagePanel = new Image();
        var imageMonstruo = new Image();
        var tWidth = 800;
        var tHeight = 600;

        imagePanel.src = 'image/panel1.png';
        imageMonstruo.src = 'image/monstersAvatars/Dragon.png';

        imageMonstruo.onload = function () {
          ctx.drawImage(imageMonstruo, 0, 20, tWidth, tHeight, 300, 0, tWidth, tHeight);

        }
        imagePanel.onload = function () {
          ctx.drawImage(imagePanel, 0, 0, tWidth, tHeight, 0, 300, tWidth, tHeight - tHeight * 0.25);
        };


        //ctx.fillText("Habilidades",500,300);
      }
    }

  </script>

  <style type="text/css">
    #battleCanvas {
      border: 1px solid black;
    }
  </style>
</head>
<!-- <body>  -->
<body onload="">
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
          <div class="screen messsage-screen"></div>
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