<?php
session_start();
include 'functions.php';

if (!isset($_SESSION["Authenticated"]) || $_SESSION["Authenticated"] == 0) {
  header("Location: index.php");
}
$monster = Monstruo::fromArray(Entity::findOneBy(monstruos, array("name" => "dragoncito")));
$monsterJson = $monster->toJSON();
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
    var strMonstruo = <?php print $monsterJson ?>;
    var enemy2= new Monstruo();
    enemy1.buildWithJson(strMonstruo);
    function drawImage(imgSrc='image/panel1.png', canvas = '#battleCanvas', x = 0, y = 300, width = 800 ,height = 180, name = "panel", index = 0) {
      $(document).ready(function () {
        $(canvas).drawImage({
          layer: true,
          name : name,
          draggable: true,
          source: imgSrc,
          x: x, y: y,
          index : index,
          width: width,
          height: height,
          fromCenter: false
        });
      });
    }
    function game() {
      $(document).ready(function () {
        $('#menuBattle').hide();
        drawImage();
        drawImage("image/bar.png", '#battleCanvas', 50, 50,300, 20,"bar", 1);
        $('#battleCanvas').moveLayer('bar', 4).drawLayers();
        $('#battleCanvas').moveLayer('monstruo', -1);

        messages();
        var enemy1 = randomEnemy();
        enemy1.draw();
        enemy1.move(300);
        $('#menuBattle').delay( 1000 ).fadeIn( 600 );

      });
    }
    function randomEnemy() {
      var enemy1 = new Monstruo();
      enemy1.set("_id","0");
      enemy1.set("userID", "CPU");
      enemy1.set("name", "enemyXYZ");
      var img;
      switch (randomInt(0, 6)) {
        case 0:
          img = "image/monstersAvatars/DivineGuardian.png";
          break;
        case 1:
          img = "image/monstersAvatars/Dragon.png";
          break;
        case 2:
          img = "image/monstersAvatars/Goblin.png";
          break;
        case 3:
          img = "image/monstersAvatars/Harpy.png";
          break;
        case 4:
          img = "image/monstersAvatars/Lichlord.png";
          break;
        case 5:
          img = "image/monstersAvatars/LordofViolence.png";
          break;
        case 6:
          img = "image/monstersAvatars/Naga.png";
          break;
      }
      enemy1.set("img", img);
      enemy1.setSTR(randomInt(1, 5));
      enemy1.setDEF(randomInt(1, 5));
      enemy1.setLUK(randomInt(1, 5));
      var maxHp = randomInt(1, 50);
      enemy1.setHP(maxHp);
      enemy1.setMAXHP(maxHp);
      enemy1.addAbility("Hab3");
      return enemy1;
    }
    //Create random integer
    function randomInt(min, max) {
      return Math.floor(Math.random()*(max-min+1)+min);
    }
    function messages(message, canvas = "#battleCanvas") {
      $(document).ready(function () {
        $(canvas).animateLayer('monstruo', {
          fontSize: 48,
          fontFamily: 'Verdana, sans-serif',
          text: 'Hello'
        }, 1500, function(layer) {});
      });
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
            <div class="col-sm-4 col-sm-offset-8 col-xs-offset-6 menu-options" id="menuBattle">
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