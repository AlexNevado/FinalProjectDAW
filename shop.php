<?php
session_start();
include 'functions.php';

isLogged();
$user = getUser();

$messages = [0 => 'No tienes suficientes monedas',
    1 => 'Ha habido un error en la compra',
    2 => 'La compra se ha realizado con éxito'];
$error = -1;
$itemList = Entity::findOneBy("miscellaneous", array());
$itemList = $itemList['items'];

if (isset($_POST["submit-btn"])) {
  if ($_POST['totalSale'] > $user->get("coins")) {
    $error = 0;
  } else {
    $input = $_POST;
    unset($input['submit-btn']);
    unset($input['totalSale']);
    foreach ($input as $key => $value) {
      $input[$key] = (int)$value;
    }
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

    foreach ($itemToBuy as $key => $item) {
      $user->addItems(substr($item["id"], -1), $item['amount']);
    }
    $user->set("coins", $user->get("coins") - $_POST['totalSale']);
    $user->save();

    $error = 2;
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
<div class="container" id="shop">
  <div class="row">
    <div class="col-sm-4 col-sm-offset-4" id="shopHeader">
      <h1><img src="image/items/gem_1.png" width="30" height="30"/>&nbsp;&nbsp;&nbsp;&nbsp;Tienda&nbsp;&nbsp;&nbsp;&nbsp;
        <img src="image/items/gem_2.png" width="30" height="30"/></h1>
    </div>
  </div>
  <div class="shopMenu">
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
      <a href="mainMenu.php" class="btn btn-login btn-sm">Volver al Menú</a>
      <a href="validate.php?logout" class="btn btn-login btn-sm">Logout</a>
    </div>
  </div>
  <?php footer() ?>
</div>
<audio controls autoplay loop id="battleSong">
  <source src="audio/mainMenuTheme.ogg" type="audio/ogg">
  <source src="audio/mainMenuTheme.mp3" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>
</body>
</html>