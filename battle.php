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
// db.miscellaneous.insert({abilities:[{id:0,name:"Fireball",power:4},{id:1,name:"Punch",power:3},{id:2,name:"Drain",power:1},{id:3,name:"Thunder",power:4}], items:[{id:0, name:"Poción", power:6},{id:1, name:"Antídoto"},{id:2, name:"Bomba", power:5},{id:3, name:"Revivir", power:2}]})

$list = Entity::findOneBy("miscellaneous", array());
$user = User::fromArray(Entity::findOneBy("users", array("_id" => new MongoId($_SESSION['user']['_id']))));
$abilitiesList = $list['abilities'];
$itemList = $list['items'];
$userArray = array(
    "id" => (string)$user->get("_id"),
    "username" => $user->get("username"),
    "coins" => $user->get("coins"),
    "items" => $user->get("items"),
);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Monstruos' Bizarre Adventure</title>
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/main.css">
  <script src="js/jcanvas.min.js"></script>
  <script src="js/monstruo.js"></script>
  <script src="js/user.js"></script>
  <script type="application/javascript">
    var canvasID = '#battleCanvas';
    var first = <?php print json_encode($_POST['first']); ?>;
    var player = <?php print json_encode($_SESSION['player']); ?>;
    var strMonstruo = <?php print $monsterJson; ?>;
    var abilitiesList = <?php print json_encode($abilitiesList) ?>;
    var itemsList = <?php print json_encode($itemList) ?>;
    var user = new User();
    user.buildWithJson(<?php print json_encode($userArray) ?>);
    var yourMonster = new Monstruo();
    yourMonster.buildWithJson(strMonstruo);
    var enemy1;
    if (player == 'single') {
      enemy1 = randomEnemy();
    } else {
      enemy1 = <?php print $otherMonster; ?>;
    }

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
      var maxHp = randomInt(1, 30);
      enemy1.set("img", img);
      enemy1.setSTR(randomInt(1, 5));
      enemy1.setDEF(randomInt(1, 5));
      enemy1.setLUK(randomInt(1, 5));
      enemy1.setHP(maxHp);
      enemy1.setMAXHP(maxHp);
      enemy1.addAbility(1);
      enemy1.addAbility(3);
      return enemy1;
    }

    /**
     * Create random integer
     */
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

    /**
     * Get an ability by their id
     */
    function getAbility(id) {
      var ability;
      abilitiesList.forEach(function (object) {
        if (object.id == id) {
          ability = object;
        }
      });
      return ability;
    }

    /**
     * Get an item by their id
     */
    function getItem(id) {
      var item;
      itemsList.forEach(function (object) {
        if (object.id == id) {
          item = object;
        }
      });
      return item;
    }

    /**
     * Do player action
     */
    function doAction(action, string) {
      switch (action) {
        case "ability":
          abilitiesList.forEach(function (ability) {
            if (ability.name === string) {
              attack(yourMonster, enemy1, ability);
            }
          });
          break;
        case "item":
          itemsList.forEach(function (item) {
            if (item.name === string) {
              useItem(yourMonster, enemy1, item);
            }
          });
          break;
        case "change":
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
        if (ability.id == 0) {
          fireball();
          fireball(2);
          fireball(3);
          fireball(4);
        }
        doAnimations(animation, ability.id);
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

    /**
     * Use items
     */
    function useItem() {

    }

    /**
     * Do animations and effects for the battle
     */
    function doAnimations(animation, animationId) {
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
            if (animationId == 0) {
              $(canvasID).animateLayer("fireball4", {x: "+=300", y: "-=140"}, {duration: 800, easing: 'swing'});
              $(canvasID).delayLayer("fireball3", 50).animateLayer("fireball3", {x: "+=300", y: "-=140"}, {
                duration: 800,
                easing: 'swing'
              });
              $(canvasID).delayLayer("fireball2", 100).animateLayer("fireball2", {x: "+=300", y: "-=140"}, {
                duration: 800,
                easing: 'swing'
              });
              $(canvasID).delayLayer("fireball1", 150).animateLayer("fireball1", {x: "+=300", y: "-=140"}, {
                duration: 800,
                easing: 'swing'
              });
              $(canvasID).drawRect({
                layer: true,
                name: 'flash',
                fillStyle: 'white',
                x: 320, y: 240,
                width: 640,
                height: 480,
                index: 90,
                opacity: 0,
              }).animateLayer('flash', {opacity: 1}, 800, function (layer) {
                $(this).removeLayerGroup('fireballs');
                $(this).animateLayer(layer, {opacity: 0}, 300);
              });
            } else {
              $(canvasID).animateLayer("mDamage1", {opacity: 0.8}, 200, function (layer) {
                $(this).animateLayer(layer, {opacity: 0}, 200);
              });
            }
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
    /**
     * Draw a fireball
     */
    function fireball(i = 1) {
      $(document).ready(function () {
        $(canvasID).drawImage({
          layer: true,
          name: "fireball" + i,
          groups: ['fireballs'],
          source: 'image/fireball.png',
          shadowColor: 'red',
          shadowBlur: 10,
          x: 180, y: 250,
          width: 100 * i / 4, height: 100 * i / 4,
        });
      });
    }

    /**
     * Send JSON to server
     */
    function sendJSON() {
      //TODO
    }

    /**
     * Receive JSON from server
     */
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
      abilitiesList.forEach(function (ability) {
        if (ability.id == enemy1.abilities[random]) {
          attack(enemy1, yourMonster, ability);
        }
      });
      //TODO Add items in future
    }

    //Mouse Functions
    $(document).ready(function () {
      $('#btn-abi').click(function () {
        $('#menuBattle').hide();
        $('#menuAbi').fadeIn(300);
        for (var i = 0; i < yourMonster.abilities.length; i++) {
          var ability = getAbility(yourMonster.abilities[i]);
          $('#btn-abi-' + i).html(ability.name);
          $('#btn-abi-' + i).val(ability.id);
          $('#btn-abi-' + i).show();
        }
      });
      $('#btn-item').click(function () {
        $('#menuBattle').hide();
        $('#menuItems').fadeIn(300);
        for (var i = 0; i < user.items.length ; i++) {
          var item = getItem(user.items[i].id);
          $('#btn-item-' + i).html("-" + item.name);
          $('#btn-item-' + i).show();
          $('#btn-item-' + i).parent().show();
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
      $('h3[id^=btn-item-]').mouseenter(function () {
        $(this).css("font-size", "1.2em");
      });
      $('h3[id^=btn-item-]').mouseleave(function () {
        $(this).css("font-size", "0.9em");
      });
      $('h3[id^=btn-abi-]').click(function () {
        $('#menuAbi').hide();
        doAction("ability", $(this).html());
      });
      $('h3[id^=btn-item-]').click(function () {
        var itemName = $(this).html();
        $('#menuItem').hide();
        doAction("item", itemName.substring(1, itemName.length);
      });
      $('.backButton').click(function () {
        for (var i = 0; i < 10; i++) {
          $('#btn-abi-' + i).hide();
        }
        $('#menuAbi').hide();
        $('#menuItems').hide();
        $('#menuBattle').fadeIn(300);
      });
    });
  </script>
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
                <h3 id="btn-item">Objetos</h3>
                <h3 id="btn-chn">Cambio</h3>
              </div>
              <div class="col-sm-6 col-sm-offset-6 col-xs-offset-1 menu-options" id="menuAbi">
                <div class="col-xs-10" id="abilitiesList">
                  <?php
                  abilitiesButtons();
                  ?>
                </div>
                <div class="col-xs-1 backButton">
                </div>
              </div>
              <div class="col-sm-8 col-sm-offset-4 col-xs-offset-1 menu-options" id="menuItems">
                <div class="col-xs-10" id="itemList">
                  <?php
                  itemsButtons();
                  ?>
                </div>
                <div class="col-xs-1 backButton">
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