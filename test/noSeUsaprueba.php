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
// db.abilities.insert({abilities:[{id:0,name:"Fireball",power:4},{id:1,name:"Punch",power:3},{id:2,name:"Drain",power:1},{id:3,name:"Thunder",power:4}]});
// db.items.insert({items:[{id:0, name:"Poción", power:6},{id:1, name:"Antídoto"},{id:2, name:"Bomba", power:5},{id:3, name:"Revivir", power:2}]});
// db.miscellaneous.insert({abilities:[{id:0,name:"Fireball",power:4},{id:1,name:"Punch",power:3},{id:2,name:"Drain",power:1},{id:3,name:"Thunder",power:4}], items:[{id:0, name:"Poción", power:6},{id:1, name:"Antídoto"},{id:2, name:"Bomba", power:5},{id:3, name:"Revivir", power:2}]})

$user = User::fromArray(Entity::findOneBy("users", array("_id" => new MongoId($_SESSION['user']['_id']))));
$amount = 0;
$condition = false;
$user->addItems(0,$amount);
$user->addItems(1,$amount);
$user->addItems(2,$amount);
$user->addItems(3,$amount);
//$user->addMonstruo("5914b2e047864a7a1f8b4567" );
$result = Entity::findOneBy("abilities", array());
$list = $result['abilities'];

//Add random Monster
if($condition) {
  $maxHp = rand(10, 50);
  $monstruo = new Monstruo();
  $monstruo->set('_id', new MongoId());
  $monstruo->set('userID', new MongoId($_SESSION["user"]["_id"]));
  $monstruo->set('name', generateRandomString());
  $monstruo->set('img', selectRandomImg());
  $monstruo->set('characteristics', array('str' => rand(0, 6),
      'def' => rand(0, 6),
      'luk' => rand(0, 6),
      'maxHp' => $maxHp,
      'hp' => $maxHp));
  $monstruo->push("monstruos",array('skills' => rand(0, 3)));
  $monstruo->save();

  $user = Entity::findOneBy("users", array("_id" => new MongoId($_SESSION['user']['_id'])));
  if (!empty($user)) {
    $user = User::fromArray($user);
    $user->addMonstruo($monstruo->get('_id'));
  }
}

function generateRandomString($length = 10) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

function selectRandomImg() {
  switch (rand(0, 6)) {
    case 0:
      $img = "image/monstersAvatars/DivineGuardian.png";
      break;
    case 1:
      $img = "image/monstersAvatars/Dragon.png";
      break;
    case 2:
      $img = "image/monstersAvatars/Goblin.png";
      break;
    case 3:
      $img = "image/monstersAvatars/Harpy.png";
      break;
    case 4:
      $img = "image/monstersAvatars/Lichlord.png";
      break;
    case 5:
      $img = "image/monstersAvatars/LordofViolence.png";
      break;
    case 6:
      $img = "image/monstersAvatars/Naga.png";
      break;
  }
  return $img;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Monstruos' Bizarre Adventure</title>
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/main.css">
  <script src="js/jquery.easyAudioEffects.min.js"></script>
  <script src="js/jcanvas.min.js"></script>
  <script src="js/monstruo.js"></script>
  <script type="text/javascript">
    var canvasID = '#battleCanvas';
    $(document).ready(function () {
      fireball();
      fireball(2);
      fireball(3);
      fireball(4);

      $("#x").click(function () {
        $(canvasID).animateLayer("fireball4", {x: "+=340", y: "-=180"}, {duration: 800, easing: 'swing'});
        $(canvasID).delayLayer("fireball3", 50).animateLayer("fireball3", {x: "+=340", y: "-=180"}, {
          duration: 800,
          easing: 'swing'
        });
        $(canvasID).delayLayer("fireball2", 100).animateLayer("fireball2", {x: "+=340", y: "-=180"}, {
          duration: 800,
          easing: 'swing'
        });
        $(canvasID).delayLayer("fireball1", 150).animateLayer("fireball1", {x: "+=340", y: "-=180"}, {
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
          index: 50,
          opacity: 0,
        }).animateLayer('flash', {opacity: 1}, 800, function (layer) {
          $(this).removeLayerGroup('fireballs');
          $(this).animateLayer(layer, {opacity: 0}, 300);
        });
      });
      function fireball(i = 1) {
        $(canvasID).drawImage({
          layer: true,
          name: "fireball" + i,
          groups: ['fireballs'],
          source: 'image/fireball.png',
          shadowColor: 'red',
          shadowBlur: 10,
          x: 150, y: 300,
          width: 100 * i / 4, height: 100 * i / 4,
        });
      } /*
      $('#y').click(function () {
        setTimeout(function () {
          new Audio('audio/hit.ogg').play();
        }, 1000);
      });
/*
      $('#y').delay(3000).easyAudioEffects({
        ogg : "audio/hit.ogg",
        mp3 : "audio/hit.mp3",
        eventType :  "click"
      });
  */

      $('#y').click(function () {

        var div;
        var arrayDesordenada = [{id:1, name:"e"}, {id:0, name:"w"}, {id:5 , name:"e"}, {id:3, name:"a"}, {id:4, name:"es"}, {id:2, name:"eqwe"}];
        arrayDesordenada.sort(function(a, b){return a.id-b.id});
        var array=new Array(arrayDesordenada.length);
        for(var i =0; i < arrayDesordenada.length; i++) {
          array[arrayDesordenada.id] = arrayDesordenada[i];
        }

        for (var i = 0; i < 5; i++) {
          div += '<img id="sign'+i+'" class="img-sign" src="image/rightSign.png" width="20" height="20">';
          div += "<h3 id='btn-abi-" + i + "' >Habilidad</h3>";
        }
        $('#a').html(div);

      });
      $('#a').on("click","h3#btn-abi-0", function() {
        alert("x");
      });
      $('h3[id^=btn-abi-]').mouseenter(function () {
        alert("x");
      });
      $('h3[id^=btn-abi-]').mouseleave(function () {
        alert("x");
      });
      $('h3[id^=btn-abi-]').click(function () {
        alert("x");
      });


      $('#z').click(function () {
        function showText(string, x = 200, y = 100) {
          var string = string;
          var a = 0;

          function createString(char, x, y, i) {
            $(canvasID).drawText({
              layer: true,
              name: 'char' + i,
              groups: ['info'],
              fillStyle: 'gray',
              strokeStyle: 'white',
              strokeWidth: 1,
              x: x, y: y,
              fontSize: '16pt',
              opacity: 1,
              fontFamily: 'Verdana, sans-serif',
              text: char,
              scale: 2,
            }).animateLayer('char' + i, {opacity: 1, scale: '-=1'}, 1000);
          }

          var interval = setInterval(function () {
            createString(string.substr(a, 1), x + a * 20, y, a);
            a++;
            if (a == string.length) {
              clearInterval(interval);
            }
          }, 500);
        }
      });




    });

  </script>
  <style>
    button {
      color: black;
    }
    .screen {
      width:700px;
      border: 45px solid transparent;
      -webkit-border-image: url(image/frame.png) 20% round; /* Safari 3.1-5 */
      -o-border-image: url(image/frame.png) 20% round; /* Opera 11-12.1 */
      border-image: url(image/frame.png) 20% round;
    }
  </style>
</head>
<!-- <body>  -->
<body onload="startBattle()">
<div class="container ">
  <div class="row ">
    <div class="col-xs-12" role="main">
      <div class="row">
        <div class="col-xs-12">
          <form>
            <div class="">
              <div class="screen">
              </div>
              <canvas id="battleCanvas" width="640" height="480"></canvas>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
  <?php footer() ?>
</div>
<div id="a"></div>
<button id="x">X</button>
<button id="y">Y</button>
<button id="z">Z</button>
<div id="demo">
  <p>Texto aqui</p>
</div>

</body>
</html>