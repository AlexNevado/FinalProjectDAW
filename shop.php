<?php
session_start();
include 'functions.php';

isLogged();
$user = getUser();

$messages = [ 0 => 'No tienes suficientes monedas',
              1 => 'Ha habido un error en la compra'];
$error = -1;
$itemList = Entity::findOneBy("miscellaneous", array());
$itemList = $itemList['items'];


if (isset($_POST["submit-btn"])) {
  if($_POST['totalSale'] > $user->get("coins")) {
    $error = 0;
  }else {
    unset($_POST['submit-btn']);
    foreach ($_POST as $key => $value) {
      $user->addItems(substr($key, -1),0);

    }
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
  <script type="application/javascript">
    $(document).ready(function () {
      var message = <?php print $error; ?>;
      if(message != -1){
        $(".sales-message").animate({
          marginTop: '+=200px',
          opacity: 1,
        }, 'slow');
      }
      var coins =<?php print $user->get('coins'); ?>;
      $('#confirm').click(function () {
        $(".sales-message").animate({
          marginTop: '-=200px',
          opacity: 0,
        }, 'slow');
      });
      $('.glyphicon').mousedown(function () {
        $(this).css({"font-size": "0.8em"});
      });
      $('.glyphicon').mouseup(function () {
        $(this).css({"font-size": "1em"});
      });
      $('.glyphicon').click(function () {
        var id = $(this).attr('id').substr(4,1);
        var value =  $(this).attr('id').substr(0,4) == 'plus'? 1 : -1 ;
        var newValue = parseInt($('#item' + id).val()) + value;
        newValue = newValue > 0 ? newValue : 0;
        $('#item' + id).val(newValue);
        var totalValue = 0;
        $('input[id^=item]').each(function () {
          var id = $(this).attr('id').substr(4,1);
          var itemValue = parseInt($('input[id^=price' + id + ']').val());
          var amount = parseInt($(this).val());
          totalValue += itemValue * amount;
        });
        $('#totalSale').val(totalValue);

      });
      $('input[type=text]').change(function(){
        alert("The text has been changed.");
      });
    });
  </script>
</head>
<body>
<div class="container">
  <div class="col-xs-4 col-xs-offset-3 sales-message">
    </br>
    </br>
    <p id="message-shop">
      <?php

      if (isset($_GET['salesMessages'])) {
        print $messages[$_GET['salesMessages']];
      }

      ?></p>
    </br>
    <button class="btn btn-login" id="confirm">Aceptar</button>
  </div>
  <div class="shopList">
    <form action="<?=$_SERVER['PHP_SELF']?>" method="get">
      <div class="row">
        <div class="col-xs-2 col-xs-offset-10" id="message">
          <p>Tienes : 100 <img src="image/items/coin.png" width="30" height="30"/></p>
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
          <div class="col-xs-3"><p>Precio : <b><?php print $item['price']; ?></b> <img src="image/items/coin.png" width="30" height="30"/></p></div>
          <div class="col-xs-3">
            <input class="input-sm" type="text" value=0 id="item<?php print $item['id']; ?>" name="item<?php print $item['id']; ?>" disabled="disabled">
            <input class="input-sm" type="text" value="<?php print $item['price']; ?>" id="price<?php print $item['id']; ?>" name="price<?php print $item['id']; ?>" hidden>
            <span id="plus<?php print $item['id']; ?>" class="glyphicon glyphicon-plus"></span>
            <span id="minu<?php print $item['id']; ?>" class="glyphicon glyphicon-minus"></span>
          </div>
        </div>
        <?php
      }
      ?>
      <div class="row">
        <div class="col-xs-2 col-xs-offset-8">
          <input id="totalSale" name="totalSale" type="text" class="input-sm" disabled="disabled" value=0><img src="image/items/coin.png" width="30" height="30"/>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-2 col-xs-offset-8"><input type="submit" class="btn btn-success" value="Comprar" name="submit-btn"></div>
      </div>
    </form>
  </div>
  <?php footer() ?>
</div>
</body>
</html>