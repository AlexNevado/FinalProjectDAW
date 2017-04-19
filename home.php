<?php
session_start();
include 'functions.php';
require_once __DIR__ . '/vendor/autoload.php';

if (!isset($_SESSION["Authenticated"]) || $_SESSION["Authenticated"] == 0) {
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Monstruos's Bizarre Adventure</title>
  <script src="js/jquery-3.2.1.min.js"></script>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
<script>
  $(document).ready(function () {
    $('input[type=number]').on('change', function () {
      var total = 0;
      $('input[type=number]').each(function () {
        total += parseInt(this.value);
      });
      if (total > 7) {
        $('input[type=number]').each(function () {
          $(this).attr({'max': this.value});
          $('#create').removeAttr('disabled');
        });
      } else {
        $('input[type=number]').each(function () {
          $(this).attr({'max': 6});
          $('#create').attr({'disabled': 'disabled'});
        });
      }
    });
    $('#selImg').on('change', function () {
      $('#avatarMnt').attr({src : this.value});
    });
  });
</script>
<div class="container">
  <div class="row">
    <div class="col-xs-12" role="main">
      <h3>Creador De Monstruo</h3>
      <form>
        <div class="form-group col-sm-3 col-sm-offset-4 col-xs-10 col-xs-offset-1">
          <label for="usr">Nombre:</label>
          <input type="text" class="form-control col-xs-4" id="monsterName" name="monsterName" required>
        </div>
        <div class="form-group col-sm-5 col-sm-offset-1">
          <table>
            <tr>
              <td>Str :</td>
              <td><input type="number" value="1" name="stat1" min="1" max="6" class="col-xs-5"></td>
            </tr>
            <tr>
              <td>Def :</td>
              <td><input type="number" value="1" name="stat2" min="1" max="6" class="col-xs-5"></td>
            </tr>
            <tr>
              <td>Luk :</td>
              <td><input type="number" value="1" name="stat3" min="1" max="6" class="col-xs-5"></td>
            </tr>
          </table>
        </div>
        <div class="form-group col-sm-5">
          <label for="selImg">Imágen:</label>
          <img src="image/monstersAvatars/Dragon2.png" class="avatarImg" id="avatarMnt">
          <select class="form-control" id="selImg" size="4">
            <option value="image/monstersAvatars/Dragon2.png" selected="selected">Img1</option>
            <option value="image/monstersAvatars/Goblin2.png">Img2</option>
            <option value="image/monstersAvatars/Harpy2.png">Img3</option>
            <option value="image/monstersAvatars/LordofViolence2.png">Img4</option>
          </select>
        </div>
        <div class="form-group col-sm-3 col-xs-10 col-xs-offset-1">
          <label for="selHab">Habilidades:</label>
          <select class="form-control" id="selHab">
            <option selected="selected">Hab1</option>
            <option>Hab2</option>
            <option>Hab3</option>
            <option>Hab4</option>
          </select>
        </div>
        <div class="col-xs-12">
          <button type="submit" class="btn btn-login btn-sm" disabled="disabled" id="create">Crear</button>
        </div>
      </form>
      <div class="col-xs-2 col-xs-offset-10">
        <a href="validate.php?logout" class="btn btn-login btn-sm">Logout</a>
      </div>
    </div>

  </div>
  <?php footer() ?>
</div>
</body>
</html>