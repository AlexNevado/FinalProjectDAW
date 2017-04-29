<?php
session_start();
include 'functions.php';

echo '<a href="validate.php?logout">EXIT</a>';
if (!isset($_SESSION["Authenticated"]) || $_SESSION["Authenticated"] == 0) {
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Monstruos's Bizarre Adventure 2</title>
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
      $('#avatarMnt').attr({src: this.value});
    });
    //Check if total number is more than 8 before submit
    $('#createForm').submit(function () {
      var total = 0;
      $('input[type=number]').each(function () {
        total += parseInt(this.value);
      });
      if (total > 8) {
        alert("Error: No te pases de listo, máximo 8 puntos para empezar");
        return false; // return false to cancel form action
      }
      return true;
    });
    $('#userButton').click(function(){
      window.location.href="mainMenu.php";
    });
  });
</script>
<div class="container">
  <div class="row">
    <div class="col-xs-12" role="main">
      <?php
      if (hasMonstruos()) {
        ?>
        <div class="userLogin" id="userButton">
          <img src="image/anonymous.png" width="100" height="100" class="userImg"></br>
          <label for="username"><?php print $_SESSION['user']['username']; ?></label>
        </div>
        <?php
      } else {
        ?>
        <h3>Creador De Monstruo</h3>
        <form id="createForm" action="create.php" method="post">
          <div class="row">
            <div class="form-group col-sm-3 col-sm-offset-4 col-xs-10 col-xs-offset-1">
              <label for="usr">Nombre:</label>
              <input type="text" class="form-control col-xs-4" id="monsterName" name="monsterName" required>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-sm-4 col-sm-offset-1">
              <table class="table stats">
                <tr>
                  <td>Str:</td>
                  <td><input type="number" value="1" name="str" min="1" max="6" class="col-xs-5">
                  </td>
                </tr>
                <tr>
                  <td>Def:</td>
                  <td><input type="number" value="1" name="def" min="1" max="6" class="col-xs-5">
                  </td>
                </tr>
                <tr>
                  <td>Luk:</td>
                  <td><input type="number" value="1" name="luk" min="1" max="6" class="col-xs-5">
                  </td>
                </tr>
              </table>
            </div>
            <div class="form-group col-sm-5">
              <label for="selImg">Imágen:</label>
              <img src="image/monstersAvatars/Dragon.png" class="avatarImg" id="avatarMnt">
              <select class="form-control" id="selImg" name="avatarName" size="4">
                <option value="image/monstersAvatars/Dragon.png" selected="selected">Dragón</option>
                <option value="image/monstersAvatars/Goblin.png">Goblin</option>
                <option value="image/monstersAvatars/Harpy.png">Arpía</option>
                <option value="image/monstersAvatars/LordofViolence.png">SeñorDeLaViolencia</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-sm-3 col-xs-10 col-xs-offset-1">
              <label for="selHab">Habilidades:</label>
              <select class="form-control" id="selHab" name="abi">
                <option selected="selected">Hab1</option>
                <option>Hab2</option>
                <option>Hab3</option>
                <option>Hab4</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <button type="submit" class="btn btn-login btn-sm" disabled="disabled" id="create">Crear</button>
            </div>
          </div>
        </form>
        <?php
      }
      ?>
      <div class="col-xs-1 col-xs-offset-9">
        <a href="validate.php?logout" class="btn btn-login btn-sm">Logout</a>
      </div>
    </div>
  </div>
  <?php footer() ?>
</div>
</body>
</html>