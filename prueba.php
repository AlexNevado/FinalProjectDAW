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
$user->addItems(2,15);
$result = Entity::findOneBy("abilities", array());
$list = $result['abilities'];

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
      }

      $('#y').click(function () {
        var div;
        for (var i = 0; i < 5; i++) {
          div += '<img id="sign'+i+'" class="img-sign" src="image/rightSign.png" width="20" height="20">';
          div += "<h3 id='btn-abi-" + i + "' >Habilidad</h3>";
        }
        $('#a').html(div);
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
    });

  </script>
</head>
<!-- <body>  -->
<body onload="startBattle()">
<canvas id="battleCanvas" width="640" height="480"></canvas>
<div id="a"></div>
<button id="x">X</button>
<button id="y">Y</button>

</body>
</html>