<?php
session_start();
include 'functions.php';

if (!isset($_SESSION["Authenticated"]) || $_SESSION["Authenticated"] == 0) {
  header("Location: index.php");
}
$monster = Monstruo::fromArray(Entity::findOneBy(monstruos, array("name" => "dragoncito")));
$a=0;
$monsterJson = $monster->toJSON();
$b=0;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Monstruos's Bizarre Adventure</title>
  <script src="js/jquery-3.2.1.min.js"></script>
  <!-- <script src="https://code.jquery.com/jquery-migrate-3.0.0.js"></script>-->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script> -->
  <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/main.css">
  <script src="js/jcanvas.min.js"></script>
  <script src="js/monstruo.js"></script>
  <script type="application/javascript">

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
      draw: function (canvas = '#battleCanvas', x = 300, y = 0) {
        var img = this.img;
        $(document).ready(function () {
          $(canvas).drawImage({
            draggable: true,
            source: img,
            x: x, y: y,
            width: 300,
            height: 300,
            fromCenter: false
          });
        });
      }
    };
    var strMonstruo = <?php print $monsterJson ?>;
    var enemy1= new Monstruo();
    enemy1.buildWithJson(strMonstruo);
    enemy1.move();
    function drawPanel(canvas = '#battleCanvas', x = 0, y = 300) {
      $(document).ready(function () {
        $(canvas).drawImage({
          draggable: true,
          source: 'image/panel1.png',
          x: x, y: y,
          width: 800,
          height: 180,
          fromCenter: false
        });
      });
    }
    function game() {
      drawPanel();
      enemy1.draw();
    }
    function randomEnemy() {

    }

  </script>

  <style type="text/css">
    #battleCanvas {
      border: 1px solid black;
    }
  </style>
</head>
<!-- <body>  -->
<body onload="game()">
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