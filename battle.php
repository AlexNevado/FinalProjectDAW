<?php
session_start();
include 'functions.php';
isLogged();

// Esto es de prueba hasta que añadamos el método via server
$_SESSION['player'] = "single";
$_POST['first'] = "1";
// Set volume
$volume = !isset($_COOKIE['volumen']) ? 1 : $_COOKIE['volumen'];
//$volume = 1;
// if mode is multiplayer get monstruos from enemies
if ($_SESSION['player'] == 'multi') {
  $otherMonstruos = Entity::findAllBy("monstruos", array("userID" => new MongoId($_POST['userID'])));
} else {
  $otherMonstruos = 'null';
}
// Get items and skills list
$list = Entity::findOneBy("miscellaneous", array());
$skillsList = $list['skills'];
$itemList = $list['items'];

$user = getUser();
$userMonstruosList = $user->get("monstruos");
$ordenedListById = array();
foreach ($userMonstruosList as $key => $monstruo) {
  $ordenedListById[(string)$userMonstruosList[$key]['_id']] = $userMonstruosList[$key]['pos'];
}
// Get all your team
$monstruos = Entity::findAllBy("monstruos", array("userID" => new MongoId($_SESSION['user']['_id'])));
foreach ($monstruos as $key => $monster) {
  $monster = Monstruo::fromArray($monster);
  $monster->set("pos", $ordenedListById[(string)$monster->get('_id')]);
  $monstruos[$key] = $monster->toJSON();
}

//Create array to client
$userArray = array(
    "id" => (string)$user->get("_id"),
    "username" => $user->get("username"),
    "coins" => $user->get("coins"),
    "items" => $user->get("items"),
    "monstruos" => $monstruos,
);
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Monstruos' Bizarre Adventure</title>
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/main.css">
  <script src="js/jcanvas.min.js"></script>
  <script src="js/monstruo.js"></script>
  <script src="js/user.js"></script>
  <script src="js/cookies.js"></script>
  <script src="js/battle.js"></script>
  <script type="application/javascript">
    // Create all the background for the battle
    var canvasID = '#battleCanvas';
    var BreakException = {};
    var volume = parseFloat(<?php print $volume ?>);
    var user = new User();
    var yourMonster = new Monstruo();
    user.buildWithJson(<?php print json_encode($userArray) ?>);
    user.monstruos.sort(function(a, b){return a.id-b.id});
    for (var i = 0; i < user.monstruos.length; i++) {
      var monstruo = new Monstruo();
      monstruo.buildWithJson(JSON.parse(user.monstruos[i]));
      user.monstruos[i] = monstruo;
      if (monstruo.pos == 0) yourMonster = monstruo;
    }

    var first = <?php print json_encode($_POST['first']); ?>;
    var player = <?php print json_encode($_SESSION['player']); ?>;
    var skillsList = <?php print json_encode($skillsList) ?>;
    var itemsList = <?php print json_encode($itemList) ?>;
    var enemy;
    // Create enemies team
    if (player == 'single') {
      var enemyMonstruos = [];
      for (var i = 0; i < 1; i++) {
        enemyMonstruos.push(randomEnemy("easy"));
      }
      enemy = enemyMonstruos[0];
    } else {
      enemyMonstruos = <?php print $otherMonstruos; ?>;
      enemy = enemyMonstruos[0];
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
            <div class="screen">
              <div class="col-sm-6 col-sm-offset-3 col-xs-offset-1" id="end-screen">
                <h2 id="end-message"></h2>
                <p>¿Seguir luchando?</p>
                <a href="battle.php" class="btn btn-lg btn-battle">Sí</a>
                <a href="mainMenu.php" class="btn btn-lg btn-battle">No</a>
              </div>
              <div class="col-sm-4 col-sm-offset-8 col-xs-offset-6 menu-options" id="menuBattle">
                <h3 id="btn-skill">Habilidades</h3>
                <h3 id="btn-item">Objetos</h3>
                <h3 id="btn-change">Cambio</h3>
              </div>
              <div class="col-sm-6 col-sm-offset-6 col-xs-offset-1 menu-options" id="menuSkills">
                <div class="col-xs-10" id="skillsList">
                  <?php
                  skillsButtons();
                  ?>
                </div>
                <div class="col-xs-1 backButton">
                </div>
              </div>
              <div class="col-sm-8 col-sm-offset-4 col-xs-offset-2 menu-options" id="menuItems">
                <div class="col-xs-10" id="itemList">
                  <?php
                  itemsButtons();
                  ?>
                </div>
                <div class="col-xs-1 backButton">
                </div>
              </div>
              <div class="col-xs-12" id="menuList">
                <div class="col-xs-12 monstruosList" id="pos0"></div>
                <div class="col-xs-12 monstruosList" id="pos1"></div>
                <div class="col-xs-12 monstruosList" id="pos2"></div>
              </div>
            </div>
            <canvas id="battleCanvas" width="640" height="480"></canvas>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-2 col-sm-offset-6 volume">
          <span class="glyphicon glyphicon-play"></span>
          <span class="glyphicon glyphicon-volume-off"></span>
          <span class="glyphicon glyphicon-volume-down"></span>
          <span class="glyphicon glyphicon-volume-up"></span>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-4 col-sm-offset-8 logout">
      <a href="mainMenu.php" class="btn btn-login btn-sm">Volver al Menú</a>
      <a href="validate.php?logout" class="btn btn-login btn-sm">Logout</a>
    </div>
  </div>
  <?php footer() ?>
</div>
</body>
</html>