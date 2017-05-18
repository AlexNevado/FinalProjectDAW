<?php
session_start();
include 'functions.php';


isLogged();
$user = getUser();
$monstruos = Entity::findAllBy("monstruos", array("userID" => new MongoId($_SESSION['user']['_id'])));

// Error messages
$messages = [0 => 'No tienes suficientes monedas',
    1 => 'Ha habido un error en la compra',
    2 => 'La compra se ha realizado con éxito',
    3 => 'El nombre de usuario ha sido cambiado',
    4 => 'El nombre de usuario está siendo usado'];
$error = -1;
$itemList = Entity::findOneBy("miscellaneous", array());
$itemList = $itemList['items'];
$userItemList = $user->get('items');
// Compare itemList with user item ID list
foreach ($itemList as $item) {
  foreach ($userItemList as $key => $userItem) {
    if ($userItem['id'] == $item['id']) {
      $userItemList[$key] = array_merge($userItem, $item);
    }
  }
}
// Buy item in the shop
if (isset($_POST["submit-btn"])) {
  // Check the user have enough coins
  if ($_POST['totalSale'] > $user->get("coins")) {
    $error = 0;
  } else {
    // This make easier the task
    $input = $_POST;
    unset($input['submit-btn']);
    unset($input['totalSale']);
    foreach ($input as $key => $value) {
      $input[$key] = (int)$value;
    }
    // Create a item list with the items to buy
    $itemToBuy = array();
    for ($i = 0; $i < (count($input) / 2); $i++) {

      if ($input["item" . $i] > 0) {
        $itemToBuy[] = array(
            "id" => $i,
            "amount" => $input["item" . $i],
            "price" => $input["price" . $i],
        );
      }
    }
    // Spend the money and save the items
    $user->set("coins", $user->get("coins") - $_POST['totalSale']);
    foreach ($itemToBuy as $key => $item) {
      $user->addItems(substr($item["id"], -1), $item['amount']);
    }

    $error = 2;
  }
}
// Change username
if (isset($_POST["submit-btn-user"])) {
  $user1 = Entity::findOneBy("users", array("username" => $_POST['username']));
  if (empty($user1)) {
    $user->set('username', $_POST['username']);
    $user->save();
    $_SESSION['user']['username'] = $_POST['username'];
    $error = 3;
  } else {
    $error = 4;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Monstruos' Bizarre Adventure 2</title>
  <script src="js/jquery-3.2.1.min.js"></script>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/main.css">
  <script src="js/shop.js"></script>
  <script type="application/javascript">
    $(document).ready(function () {
      var coins = <?php print $user->get('coins'); ?>;
      var message = <?php print $error; ?>;
      if (message != -1) {
        $(".sales-message")
            .css({
              'display': 'block',
              'opacity': 0
            })
            .animate({
              marginTop: '+=200px',
              opacity: 1
            }, 'slow');
      }
    });
  </script>
</head>
<body>
<div class="sales-message">
  </br>
  </br>
  <p id="message-shop">
    <?php
    if ($error != -1) {
      print $messages[$error];
    }
    ?></p>
  </br>
  <button class="btn btn-login" id="confirm">Aceptar</button>
</div>
<div class="container" id="mainMenu" style="display: <?php
$display = isset($_POST["submit-btn"]) || isset($_POST["submit-btn-user"]) ? "none" : "block";
print $display;
?>;">
  <div class="row">
    <div class="col-xs-12">
      <!-- title -->
      <img src="image/login_image1.jpg" class="col-xs-8 col-xs-offset-2 img-responsive loginImage"/>

      <div class="col-xs-12">
        <h2> Monstruos' Bizarre Adventure <img src="image/number2.png" width="50" height="50" alt="image number 2"></h2>
        <br/>
      </div>
    </div>
  </div>
  <!-- begins menu -->
  <div class="row">
    <div class="col-xs-12">
      <a href="battle.php" class="btn btn-sm btn-menu-principal" id="singleBattle">Batalla</a>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <button type="button" class="btn btn-sm btn-menu-principal" id="searchBattle">Buscar batalla Multijugador</button>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <button type="button" class="btn btn-sm btn-menu-principal" id="perfil">Perfil</button>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <button type="button" class="btn btn-sm btn-menu-principal" id="shopButton">Tienda</button>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <button type="button" class="btn btn-sm btn-menu-principal" id="options">Opciones</button>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <a href="validate.php?logout" class="btn btn-login btn-sm">Logout</a>
    </div>
  </div>
</div>
<div class="container" id="shop" style="display: <?php
$display = isset($_POST["submit-btn"]) ? "block" : "none";
print $display;
?>;">
  <div class="row">
    <div class="col-sm-4 col-sm-offset-4" id="shopHeader">
      <h1><img src="image/items/gem_1.png" width="30" height="30"/>&nbsp;&nbsp;&nbsp;&nbsp;Tienda&nbsp;&nbsp;&nbsp;&nbsp;
        <img src="image/items/gem_2.png" width="30" height="30"/></h1>
    </div>
  </div>
  <div class="shopMenu">
    <div class="shopList">
      <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="row">
          <div class="col-sm-2 col-sm-offset-10 col-xs-offset-6" id="message">
            <p>Tienes : <?php print $user->get('coins'); ?> <img src="image/items/coin.png" width="30" height="30"/></p>
          </div>
        </div>
        <?php
        foreach ($itemList as $item) {
          ?>
          <div class="row">
            <img src="<?php print $item['img']; ?>" class="col-xs-2 img-responsive itemPic"/>
            <div class="col-xs-4">
              <h4><?php print $item['name']; ?></h4>
            </div>
            <div class="col-xs-3"><p>Precio : <b><?php print $item['price']; ?></b> <img src="image/items/coin.png"
                                                                                         width="30" height="30"/></p>
            </div>
            <div class="col-xs-3">
              <input class="input-sm itemReadOnly" type="text" size="2" value=0 id="item<?php print $item['id']; ?>"
                     name="item<?php print $item['id']; ?>" readonly>
              <input class="input-sm" type="text" value="<?php print $item['price']; ?>"
                     id="price<?php print $item['id']; ?>" name="price<?php print $item['id']; ?>" hidden>
              <span id="plus<?php print $item['id']; ?>" class="glyphicon glyphicon-plus"></span>
              <span id="minu<?php print $item['id']; ?>" class="glyphicon glyphicon-minus"></span>
            </div>
          </div>
          <?php
        }
        ?>
        <div class="row">
          <div class="col-sm-2 col-sm-offset-8 col-xs-offset-7">
            <input id="totalSale" name="totalSale" type="text" class="input-sm itemReadOnly" size="4" readonly
                   value=0><img src="image/items/coin.png" width="30" height="30"/>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-2 col-xs-offset-8"><input type="submit" class="btn btn-success" value="Comprar"
                                                       name="submit-btn"></div>
        </div>
      </form>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-4 col-sm-offset-8 logout">
      <button type="button" class="btn btn-login btn-sm backMenu">Volver al Menú</button>
      <a href="validate.php?logout" class="btn btn-login btn-sm">Logout</a>
    </div>
  </div>
</div>
<div class="container" id="user" style="display: <?php
$display = isset($_POST["submit-btn-user"]) ? "block" : "none";
print $display;
?>;">
  <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
    <div class="row">
      <div class="col-sm-4 col-sm-offset-4">
        <img src="image/anonymous.png" width="100" height="100" class="userImg"></br>
        <input type="text" value="<?php print $_SESSION['user']['username']; ?>" id="inputName" name="username"/>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4 col-xs-offset-1 userTables">Monstruos</div>
    </div>
    <div>
      <?php
      monstruoList($monstruos);
      ?>
    </div>
    <div class="row">
      <div class="col-xs-4 col-xs-offset-1 userTables">Objetos</div>
    </div>
    <?php
    itemList($userItemList);
    ?>
    <div class="row"></div>
    <input type="submit" class="btn btn-login btn-sm backMenu" name="submit-btn-user"
           value="Guardar cambios en el perfil"/>
  </form>
  <div class="row">
    <div class="col-sm-4 col-sm-offset-8 logout">
      <button type="button" class="btn btn-login btn-sm backMenu">Volver al Menú</button>
      <a href="validate.php?logout" class="btn btn-login btn-sm">Logout</a>
    </div>
  </div>
</div>
<div class="container">
  <?php footer() ?>
</div>
<audio controls autoplay loop id="battleSong">
  <source src="audio/mainMenuTheme.ogg" type="audio/ogg">
  <source src="audio/mainMenuTheme.mp3" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>
</body>
</html>