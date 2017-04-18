<?php
require_once __DIR__ . '/vendor/autoload.php';
# index.php
$fb = new Facebook\Facebook([
    'app_id' => '259915584478602',
    'app_secret' => 'be739ec8db993b668937fe4c7c58c649',
    'default_graph_version' => 'v2.3',
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // optional
$loginUrl = $helper->getLoginUrl('http://mba2.com/fb-callback.php', $permissions);
$GLOBALS['loginUrl'] = $loginUrl;

function register()
{
  ?>
    <form action="register.php" method="post">
      <div class="col-xs-12 login">
        <?php
        if (isset($_GET["error"])) {
          errorMessage("Este nombre de usuario ya está siendo usado");
        }
        ?>
        <div class="form-group">
          <label for="usr">Username:</label>
          <input type="text" class="form-control" name="username">
        </div>
        <div class="form-group">
          <label for="pwd">Password:</label>
          <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-login btn-sm">Enviar</button>
        <?php
        echo '<a href="' . $GLOBALS['loginUrl'] . '" class="btn btn-login fb-button"></a>';
        ?>
      </div>
    </form>

  <?php
}

function login()
{
  ?>
  <form action="validate.php" method="post">
    <div class="col-xs-12 login">
      <?php
      if (isset($_GET["error"])) {
        errorMessage("El usuario no existe o los datos son incorrectos");
      }
      ?>
      <div class="form-group">
        <label for="usr">Username:</label>
        <input type="text" class="form-control" name="username">
      </div>
      <div class="form-group">
        <label for="pwd">Password:</label>
        <input type="password" class="form-control" name="password" required>
      </div>
      <button type="submit" class="btn btn-login btn-sm">Enviar</button>
      <?php
      echo '<a href="' . $GLOBALS['loginUrl'] . '" class="btn btn-login fb-button"></a>';
      ?>
  </form>
  <?php
}

function errorMessage($message)
{
  ?>
  <div class="row">
    <div class="alert alert-warning col-xs-12">
      <p><?php print $message; ?></p>
    </div>
  </div>
  <?php
}

function footer()
{
  ?>
  <div class="row">
    <div class="col-xs-12 rrss">
      <a href="#"><img id="fb" src="image/img_trans.gif"></a>
      <a href="#"><img id="tw" src="image/img_trans.gif"></a>
      <a href="#"><img id="in" src="image/img_trans.gif"></a>
      <a href="#"><img id="tu" src="image/img_trans.gif"></a>
    </div>
    <div class="col-xs-12" role="footer">
      <p>@2017 | Designed by GrupoSinNombre</p>
    </div>
  </div>
  <?php
}