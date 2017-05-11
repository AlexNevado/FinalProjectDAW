<?php
session_start();
include 'functions.php';

if (!isset($_SESSION["Authenticated"]) || $_SESSION["Authenticated"] == 0) {
  header("Location: index.php");
}
$monsters = Entity::findAllBy("monstruos", array("userID" => new MongoId($_SESSION['user']['_id'])));

foreach ($monsters as $key => $monster) {
  $monsters[$key] = Monstruo::fromArray($monster)->toJSON();
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
/*
 db.miscellaneous.insert({abilities:[{id:0,name:"Fireball",power:4},{id:1,name:"Punch",power:3},{id:2,name:"Drain",power:1},{id:3,name:"Thunder",power:4}],
items:[{id:0, name:"Poción", power:6, type:'cure'},{id:1, name:"Antídoto" , type:"cure"},{id:2, name:"Bomba", power:5, type:"damage"},{id:3, name:"Revivir", power:2, type:"cure"}]})
*/
$list = Entity::findOneBy("miscellaneous", array());
$user = User::fromArray(Entity::findOneBy("users", array("_id" => new MongoId($_SESSION['user']['_id']))));
$abilitiesList = $list['abilities'];
$itemList = $list['items'];
$userMonstruosList = $user->get("monstruos");
foreach ($userMonstruosList as $key => $monstruo){
  $userMonstruosList[$key]['_id'] = (string)$monstruo['_id'];
}
$userArray = array(
    "id" => (string)$user->get("_id"),
    "username" => $user->get("username"),
    "coins" => $user->get("coins"),
    "items" => $user->get("items"),
    "monstruos" => $userMonstruosList,
);
$a=0;
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
  <script src="js/battle.js"></script>
  <script type="application/javascript">
    var canvasID = '#battleCanvas';
    var playerMonstruos =<?php print json_encode($monsters); ?>;
    for(var i=0; i < playerMonstruos.length; i++) {
      playerMonstruos[i] = JSON.parse(playerMonstruos[i]);
    }
    var user = new User();
    var yourMonster = new Monstruo();
    user.buildWithJson(<?php print json_encode($userArray) ?>);
    user.monstruos.forEach(function (monstruo) {
      if(monstruo.pos == 0) {
        playerMonstruos.forEach(function (playerMonstruo) {
          if(playerMonstruo._id == monstruo._id) {
            yourMonster.buildWithJson(playerMonstruo);
          }
        });
      }
    });
    var first = <?php print json_encode($_POST['first']); ?>;
    var player = <?php print json_encode($_SESSION['player']); ?>;
    //var strMonstruo = JSON.parse(playerMonstruos[0]);
    var abilitiesList = <?php print json_encode($abilitiesList) ?>;
    var itemsList = <?php print json_encode($itemList) ?>;
    var enemy;
    if (player == 'single') {
      var enemyMonstruos=[];
      for(var  i=0; i< 3; i++) {
        enemyMonstruos.push(randomEnemy("easy"));
      }
      enemy = enemyMonstruos[0];
    } else {
      enemy = <?php print $otherMonster; ?>;
    }
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
                <h3 id="btn-change">Cambio</h3>
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