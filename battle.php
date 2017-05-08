<?php
session_start();
include 'functions.php';

if (!isset($_SESSION["Authenticated"]) || $_SESSION["Authenticated"] == 0) {
  header("Location: index.php");
}
$monster = Monstruo::fromArray(Entity::findOneBy("monstruos", array("userID" => new MongoId($_SESSION['user']['_id']))));
$monsterJson = $monster->toJSON();
// Esto es de prueba hasta que añadamos el método via server
$_SESSION['player'] = "single";
$_POST['first'] = "1";

if ($_SESSION['player'] == 'multi') {
  $otherMonster = Monstruo::fromArray(Entity::findOneBy("monstruos", array("userID" => new MongoId($_POST['userID']))));
} else {
  $otherMonster = 'null';
}
// db.abilities.insert({abilities:[{Punch:3},{Drain:1}]});
//> db.abilities.insert({abilities:[{id:0,name:"Fireball",power:4},{id:1,name:"Punch",power:3},{id:2,name:"Drain",power:1},{id:3,name:"Thunder",power:4}]});

$result = Entity::findOneBy("abilities", array());
$list = $result['abilities'];
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
    var first = <?php print json_encode($_POST['first']); ?>;
    var player = <?php print json_encode($_SESSION['player']); ?>;
    var strMonstruo = <?php print $monsterJson; ?>;
    var canvasID = '#battleCanvas';
    var yourMonster = new Monstruo();
    var enemy1;
    var listAbilities = <?php print json_encode($list) ?>;
    if (player == 'single') {
      enemy1 = randomEnemy();
    } else {
      enemy1 = <?php print $otherMonster; ?>;
    }

    yourMonster.buildWithJson(strMonstruo);
    function drawImage(imgSrc = 'image/panel1.png', x = 0, y = 300, width = 800, height = 180, name = "panel", index = 0, opacity = 1) {
      $(document).ready(function () {
        $(canvasID).drawImage({
          layer: true,
          name: name,
          draggable: true,
          opacity: opacity,
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
        enemy1.draw(0, 'mDamage1', enemy1.img.substr(0, enemy1.img.length - 4) + "2.png", 300);
        drawPanels(canvasID);
        enemy1.move(300);
        yourMonster.draw(1, 'yourMonster', yourMonster.img, 10, 340, 150, 150, 10);
        if (yourMonster.characteristics.luk > enemy1.characteristics.luk) {
          showMenu();
        } else if (first) {
          showMenu();
        } else {
          messages("Esperando al oponente...");
        }
      });
    }
    function endBattle() {
      $(document).ready(function () {
        setTimeout(function () {
          drawImage("image/background12.jpg", 0, 0, 640, 480, "end", 20, 0.5);
          $('#end-screen').show();
          if (yourMonster.characteristics.hp > enemy1.characteristics.hp) {
            $('#end-message').html("¡Has Vencido!");
          } else {
            $('#end-message').html("¡Has Perdido!");
          }
        }, 1000);
      });

    }
    /**
     *Show menus
     */
    function showMenu() {
      $(document).ready(function () {
        $('#menuBattle').delay(1000).fadeIn(600);
      });
    }
    /**
     * Hide menus
     */
    function hideMenu() {
      $(document).ready(function () {
        $('#menuBattle').fadeOut(600);
        $('#menuAbi').delay(1000).fadeIn(600);
      });
    }
    /**
     * Draw the panels
     */
    function drawPanels(canvasID) {
      $(document).ready(function () {
        drawImage();
        drawImage("image/empty-bar.png", 50, 50, 300, 20, "empty-bar1", 1);
        drawImage("image/bar.png", 50, 50, 300 * percentageHp(enemy1), 20, "bar1", 2);
        drawImage("image/empty-bar.png", 10, 320, 200, 20, "empty-bar2", 3);
        drawImage("image/bar.png", 10, 320, 200 * percentageHp(yourMonster), 20, "bar2", 4);
        drawImage("image/blood.png", 0, 0, 640, 480, "hurt", 20, 0);

        //alert($(canvasID).getLayer('empty-bar2').width);
        //$(canvasID).setLayer('monstruo', {});
      });
    }
    /**
     *Calculate percentage of Hp
     **/
    function percentageHp(monstruo) {
      return monstruo.characteristics.hp / monstruo.characteristics.maxHp;
    }
    /**
     * Create randon enemy
     */
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
      var maxHp = randomInt(1, 30);
      enemy1.setHP(maxHp);
      enemy1.setMAXHP(maxHp);
      enemy1.addAbility(1);
      enemy1.addAbility(3);
      return enemy1;
    }
    //Create random integer
    function randomInt(min, max) {
      return Math.floor(Math.random() * (max - min + 1) + min);
    }
    /**
     * Show messages
     */
    /*
     *     function messages(text="", x = 150, y = 150, width = 350, height = 200
     , name = "message", index = 10, opacity = 1,imgSrc = 'image/message.png', canvas = '#battleCanvas') {
     * */
    function messages(text = "Has perdido", x = 0, y = 0, width = 640, height = 480
        , name = "message", index = 10, opacity = 0.5, imgSrc = 'image/background12.jpg') {
      $(document).ready(function () {
        $(canvasID).drawImage({
          layer: true,
          name: name,
          draggable: true,
          opacity: opacity,
          source: imgSrc,
          x: x, y: y,
          index: index,
          width: width,
          height: height,
          fromCenter: false,
        });
      });
    }
    $(document).ready(function () {
      $('#btn-abi').click(function () {
        $('#menuBattle').hide();
        $('#menuAbi').fadeIn(300);
        for (var i = 0; i < yourMonster.abilities.length; i++) {
          var ability = getAbility(yourMonster.abilities[i]);
          $('#btn-abi-' + i).html(ability.name);
          $('#btn-abi-' + i).show();
        }
      });
      $('h3[id^=btn-abi-]').mouseenter(function () {
        var signNumber = $(this).attr('id').slice(-1);
        $('#sign' + signNumber).fadeIn(200);
      });
      $('h3[id^=btn-abi-]').mouseleave(function () {
        var signNumber = $(this).attr('id').slice(-1);
        $('#sign' + signNumber).fadeOut(200);
      });
      $('h3[id^=btn-abi-]').click(function () {
        $('#menuAbi').hide();
        doAction("Ability", $(this).html());
      });
      $('#backButton').click(function () {
        for (var i = 0; i < 10; i++) {
          $('#btn-abi-' + i).hide();
        }
        $('#menuAbi').hide();
        $('#menuBattle').fadeIn(300);
      });
    });
    function getAbility(id) {
      var ability;
      listAbilities.forEach(function (object) {
        if (object.id == id) {
          ability = object;
        }
      });
      return ability;
    }
    /**
     * Do player action
     */
    function doAction(action, object) {
      switch (action) {
        case "Ability":
          listAbilities.forEach(function (ability) {
            if (ability.name === object) {
              attack(yourMonster, enemy1, ability);
            }
          });
          break;
        case "items":
          break;
        case "Change":
          break;
      }
    }
    /**
     * Attack an enemy
     */
    function attack(attacker, defender, ability) {
      //Critical double the attack power if you have enough luk
      //and can make you miss an attack
      var random = randomInt(attacker.characteristics.luk, 40);
      var critical = random > 30 ? 2 : random < 5 ? 0 : 1;
      var newHp = (defender.characteristics.def - attacker.characteristics.str - ability.power) * critical;
      if (newHp < 0) {
        defender.setHP(newHp);
        var animation = attacker == yourMonster ? "playerAttack" : "enemyAttack";
        doAnimations(animation);
      } else {
        var animation = attacker == yourMonster ? "playerMiss" : "enemyMiss";
        doAnimations(animation);
      }

      //Maybe in a future had to be types in abilities parameters for this but for now
      //it's ok this way
      if (ability.id == 2) {
        yourMonster.setHP(ability.power);
        doAnimations("playerCure");
      }
      //TODO Do some stuff with canvas, effects and shit
      //checkBarChanges();
      if (yourMonster.characteristics.hp == 0 || enemy1.characteristics.hp == 0) {
        endBattle();
      } else if (player == "multi") {
        sendJSON();
      } else {
        if (attacker == yourMonster) {
          setTimeout(function () {
            randomAction();
          }, 2000);
        } else {
          setTimeout(function () {
            showMenu();
          }, 2000);
        }
      }
    }

    function doAnimations(animation) {
      $(document).ready(function () {
        switch (animation) {
          case "enemyAttack":
            enemy1.attackAnimation();
            $(canvasID).animateLayer("bar2", {width: 200 * percentageHp(yourMonster)}, 1000);
            drawImage("image/blood.png", 0, 0, 640, 480, "hurt", 20);
            $(canvasID).animateLayer("hurt", {opacity: 1}, 300, function (layer) {
              $(this).animateLayer(layer, {opacity: 0}, 1000);
            });
            break;
          case "playerAttack":
            $(canvasID).animateLayer("mDamage1", {opacity: 0.8}, 200, function (layer) {
              $(this).animateLayer(layer, {opacity: 0}, 200);
            });
            $(canvasID).animateLayer("bar1", {width: 300 * percentageHp(enemy1)}, 1000)
            break;
          case "playerCure":
            $(canvasID).animateLayer("bar2", {width: 200 * percentageHp(yourMonster)}, 1000);
            break;
          case "playerMiss":
            $(canvasID).drawText({
              layer: true,
              name: 'Text',
              groups: ['Miss'],
              fillStyle: '#B00000',
              strokeStyle: 'darkred',
              strokeWidth: 2,
              x: 450, y: 100,
              fontSize: '36pt',
              fontFamily: 'Verdana, sans-serif',
              text: 'Miss'
            }).drawArc({
              layer: true,
              groups: ['Miss'],
              fillStyle: 'darkred',
              opacity: 0.2,
              x: 450, y: 100,
              radius: $(canvasID).measureText('Text').width / 2
            }).animateLayer('Text', {fontSize: '66pt'}, 500).delayLayer('Text', 500).animateLayer("Text", {opacity: 0}, 1000);
            setTimeout(function () {
              $(canvasID).removeLayerGroup('Miss');
            }, 1500);
            break;
          case "enemyMiss":
            $(canvasID).drawText({
              layer: true,
              name: 'Text',
              groups: ['Miss'],
              fillStyle: '#B00000',
              strokeStyle: 'darkred',
              strokeWidth: 2,
              x: 100, y: 400,
              fontSize: '36pt',
              fontFamily: 'Verdana, sans-serif',
              text: 'Miss'
            }).drawArc({
              layer: true,
              groups: ['Miss'],
              fillStyle: 'darkred',
              opacity: 0.2,
              x: 100, y: 400,
              radius: $(canvasID).measureText('Text').width / 2
            }).animateLayer('Text', {fontSize: '66pt'}, 500).delayLayer('Text', 500).animateLayer("Text", {opacity: 0}, 1000);
            setTimeout(function () {
              $(canvasID).removeLayerGroup('Miss');
            }, 1500);
            break;
        }
      });
    }
    function sendJSON() {
      //TODO
    }
    function receiveJSON() {
      //TODO receive JSON and make changes in local
      doAnimations();
      if (yourMonster.characteristics.hp == 0 || enemy1.characteristics.hp == 0) {
        endBattle();
      } else {
        showMenu();
      }
    }
    function randomAction() {
      var random = randomInt(0, enemy1.abilities.length - 1);
      listAbilities.forEach(function (ability) {
        if (ability.id == enemy1.abilities[random]) {
          attack(enemy1, yourMonster, ability);
        }
      });
      //TODO Add items in future
    }
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
          <form>
            <div class="screen">
              <div class="col-sm-6 col-sm-offset-3 col-xs-offset-1" id="end-screen">
                <h2 id="end-message"></h2>
                <input type="submit" class="btn btn-lg btn-battle" value="Aceptar">
              </div>
              <div class="col-sm-4 col-sm-offset-8 col-xs-offset-6 menu-options" id="menuBattle">
                <h3 id="btn-abi">Habilidades</h3>
                <h3 id="btn-obj">Objetos</h3>
                <h3 id="btn-chn">Cambio</h3>
              </div>
              <div class="col-sm-6 col-sm-offset-6 col-xs-offset-1 menu-options" id="menuAbi">
                <div class="col-xs-10" id="abilitiesList">
                  <?php
                  for ($i = 0; $i < 10; $i++) {
                    ?>
                    <div class="col-xs-3">
                      <img id="sign<?php print $i; ?>" class="img-sign" src="image/rightSign.png" width="20"
                           height="20">
                    </div>
                    <div class="col-xs-9">
                      <h3 id="btn-abi-<?php print $i; ?>">Habilidad<?php print $i; ?></h3>
                    </div>
                    <?php
                  }
                  ?>
                </div>
                <div class="col-xs-1" id="backButton">
                </div>
              </div>
            </div>

            <canvas id="battleCanvas" width="640" height="480"></canvas>
          </form>
        </div>
      </div>
      <div class="row">
        <audio controls loop>
          <source src="audio/battleThemeA.ogg" type="audio/ogg">
          <source src="audio/battleThemeA.mp3" type="audio/mpeg">
          Your browser does not support the audio element.
        </audio>
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