<?php
session_start();
include 'functions.php';

if (!isset($_SESSION["Authenticated"]) || $_SESSION["Authenticated"] == 0) {
  header("Location: index.php");
}
$monster = Monstruo::fromArray(Entity::findOneBy(monstruos, array("userID" => new MongoId($_SESSION['user']['_id']))));
$monsterJson = $monster->toJSON();
$monsterEnemy = 1;
// Esto es de prueba hasta que añadamos el método via server
$_POST['first'] = 1;

$first = $_POST['first'] == 1 ? TRUE : FALSE;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Monstruos' Bizarre Adventure</title>
  <script src="js/jquery-3.2.1.min.js"></script>
  <!-- <script src="https://code.jquery.com/jquery-migrate-3.0.0.js"></script>-->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script> -->
  <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/main.css">
  <script src="js/jcanvas.min.js"></script>
  <script src="js/monstruo.js"></script>
  <script type="application/javascript">
    var canvasID = '#battleCanvas';
    var strMonstruo = <?php print $monsterJson; ?>;
    var yourMonster = new Monstruo();
    var enemy1 = randomEnemy();
    var first =<?php print $first; ?>;
    yourMonster.buildWithJson(strMonstruo);
    function drawImage(imgSrc = 'image/panel1.png', canvas = '#battleCanvas', x = 0, y = 300, width = 800, height = 180, name = "panel", index = 0) {
      $(document).ready(function () {
        $(canvas).drawImage({
          layer: true,
          name: name,
          draggable: true,
          source: imgSrc,
          x: x, y: y,
          index: index,
          width: width,
          height: height,
          fromCenter: false
        });
      });
    }
    function startBattle() {
      $(document).ready(function () {
        enemy1.draw(0);
        drawPanels(canvasID);
        enemy1.move(300);
        yourMonster.draw(1, 10, 340, 150, 150, 10, 'yourMonster');
        if (yourMonster.characteristics.luk > enemy1.characteristics.luk) {
          showMenu();
        } else if (first) {
          showMenu();
        } else {
          messages("Esperando al oponente...");
        }
      });
    }
    function battle() {
      $(document).ready(function () {

      });
    }
    function endBattle() {

    }
    function showMenu() {
      $(document).ready(function () {
        $('#menuBattle').delay(1000).fadeIn(600);
      });
    }
    function hideMenu() {
      $(document).ready(function () {
        $('#menuBattle').fadeOut(600);
      });
    }
    function drawPanels(canvasID) {
      $(document).ready(function () {
        drawImage();
        drawImage("image/empty-bar.png", canvasID, 50, 50, 300, 20, "empty-bar1", 1);
        drawImage("image/bar.png", canvasID, 50, 50, 300 * percentageHp(enemy1), 20, "bar1", 2);
        drawImage("image/empty-bar.png", canvasID, 10, 320, 200, 20, "empty-bar2", 3);
        drawImage("image/bar.png", canvasID, 10, 320, 200 * percentageHp(yourMonster), 20, "bar2", 4);
        //alert($(canvasID).getLayer('empty-bar2').width);
        //$(canvasID).setLayer('monstruo', {});
      });
    }
    function percentageHp(monstruo) {
      return monstruo.characteristics.hp / monstruo.characteristics.maxHp;
    }
    function attack() {

    }
    function randomEnemy() {
      var enemy1 = new Monstruo();
      enemy1.set("_id", "0");
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
      return Math.floor(Math.random() * (max - min + 1) + min);
    }
    function messages(message, canvas = "#battleCanvas") {
      $(document).ready(function () {
        $(canvas).animateLayer('monstruo', {
          fontSize: 48,
          fontFamily: 'Verdana, sans-serif',
          text: 'Hello'
        }, 1500, function (layer) {
        });
      });
    }
    $(document).ready(function () {
      $('#btn-abi').click(function () {

        $('#menuBattle').hide();
        $('#menuAbi').fadeIn(300);
      });
      $('#btn-abi-1, #btn-abi-2, #btn-abi-3').mouseenter(function () {
        var signNumber = $(this).attr('id').slice(-1);
        $('#sign' + signNumber).fadeIn(200);
      });
      $('#btn-abi-1, #btn-abi-2, #btn-abi-3').mouseleave(function () {
        var signNumber = $(this).attr('id').slice(-1);
        $('#sign' + signNumber).fadeOut(200);
      });
      $('#backButton').click(function () {

      });
    });
  </script>
  <style type="text/css">
    #battleCanvas {
      border: 1px solid black;
    }
  </style>
</head>
<!-- <body>  -->
<body onload="startBattle()">
<div class="container">
  <div class="row">
    <div class="col-xs-12" role="main">
      <div class="row">
        <div class="col-xs-12">
          <div class="screen">
            <div class="col-sm-4 col-sm-offset-8 col-xs-offset-6 menu-options" id="menuBattle">
              <h3 id="btn-abi">Habilidades</h3>
              <h3 id="btn-obj">Objetos</h3>
              <h3 id="btn-chn">Cambio</h3>
            </div>
            <div class="col-sm-6 col-sm-offset-6 col-xs-offset-6 menu-options" id="menuAbi">
              <div class="col-xs-10">
                <div class="col-xs-2">
                  <img id="sign1" class="img-sign" src="image/rightSign.png" width="20" height="20">
                </div>
                <div class="col-xs-10">
                  <h3 id="btn-abi-1">Habilidad1</h3>
                </div>
                <div class="col-xs-2">
                  <img id="sign2" class="img-sign" src="image/rightSign.png" width="20" height="20">
                </div>
                <div class="col-xs-10">
                  <h3 id="btn-abi-2">Habilidad2</h3>
                </div>
                <div class="col-xs-2">
                  <img id="sign3" class="img-sign" src="image/rightSign.png" width="20" height="20">
                </div>
                <div class="col-xs-10">
                  <h3 id="btn-abi-3">Habilidad3</h3>
                </div>
              </div>
              <div class="col-xs-1" id="backButton">
              </div>
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