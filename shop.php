<?php
session_start();
include 'functions.php';

isLogged();

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
      $('.glyphicon').mousedown(function () {
        $(this).css({"font-size": "0.8em"});
      });
      $('.glyphicon').mouseup(function () {
        $(this).css({"font-size": "1em"});
      });
      $('.glyphicon').click(function () {
        var id = $(this).attr('id').substr(4,1);
        var object = $('input[name="item" + id]);
            object.val(parseInt(object.val())+1);
        //$('input[name="item" + id]).val(parseInt($('input[name="item" + id])) + 1);
      });
    });
  </script>
</head>
<body>
<div class="container">
  <div class="shopList">
    <form>
      <?php
      $itemList = Entity::findOneBy("miscellaneous", array());
      $itemList = $itemList['items'];
      foreach ($itemList as $item) {
        ?>
        <div class="row">
          <img src="<?php print $item['img']; ?>" class="col-xs-2 img-responsive itemPic">
          <div class="col-xs-4">
            <h4><?php print $item['name']; ?></h4>
          </div>
          <div class="col-xs-3"><p>Precio : <b><?php print $item['price']; ?></b> <img src="image/items/coin.png" width="30" height="30"></p></div>
          <div class="col-xs-3">
            <input class="input-sm" type="text"  disabled="disabled" value="0" name="item<?php print $item['id']; ?>">
            <span id="plus<?php print $item['id']; ?>" class="glyphicon glyphicon-plus"></span>
            <span id="minu<?php print $item['id']; ?>" class="glyphicon glyphicon-minus"></span>
          </div>
        </div>
        <?php
      }
      ?>
      <div class="row">
        <div class="col-xs-2 col-xs-offset-8"><input type="submit" class="btn btn-success" value="Comprar"></div>
      </div>
    </form>
  </div>
  <?php footer() ?>
</div>
</body>
</html>