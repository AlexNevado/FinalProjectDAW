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
        $(canvasID).animateLayer("fireball4", {x: "+=300"}, {duration: 800, easing: 'swing'});
        $(canvasID).delayLayer("fireball3", 20).animateLayer("fireball3", {x: "+=300"}, {
          duration: 800,
          easing: 'swing'
        });
        $(canvasID).delayLayer("fireball2", 30).animateLayer("fireball2", {x: "+=300"}, {
          duration: 800,
          easing: 'swing'
        });
        $(canvasID).delayLayer("fireball1", 40).animateLayer("fireball1", {x: "+=300"}, {
          duration: 800,
          easing: 'swing'
        });

      });
      function fireball(i = 1) {
        $(canvasID).drawImage({
          layer: true,
          name: "fireball" + i,
          source: 'image/fireball.png',
          x: 150, y: 150,
          width: 100, height: 100,
        });
      }

      function fireballShadow(i = 1) {
        $(canvasID).drawArc({
          layer: true,
          name: "fireball" + i,
          fillStyle: 'orange',
          opacity: 0.4,
          shadowColor: 'black',
          shadowBlur: 20,
          x: 150, y: 150,
          radius: 35
        });
      }
    });

  </script>
</head>
<!-- <body>  -->
<body onload="startBattle()">
<canvas id="battleCanvas" width="640" height="480"></canvas>
<button onclick="move()" id="x">X</button>
</div>
</body>
</html>