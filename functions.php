<?php
require_once __DIR__ . '/vendor/autoload.php';

foreach (glob("classes/*.php") as $filename) {
  include $filename;
}

$fb = new Facebook\Facebook([
    'app_id' => '259915584478602',
    'app_secret' => 'be739ec8db993b668937fe4c7c58c649',
    'default_graph_version' => 'v2.3',
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // optional
$loginUrl = $helper->getLoginUrl('http://mba2.com/fb-callback.php', $permissions);
$GLOBALS['loginUrl'] = $loginUrl;

if (!isset($_SESSION["Authenticated"]) && isset($_COOKIE["user"])) {
  $_SESSION["user"]["_id"] = $_COOKIE["user"];
  $user = getUser();
  $_SESSION["user"]["username"] = $user->get("username");
  $_SESSION["Authenticated"] = 1;
}

function getUser() {
  $user = User::fromArray(Entity::findById("users", new MongoId($_SESSION["user"]["_id"])));
  return $user;
}

/**
 * If user is not logged return to index
 */
function isLogged() {
  if (!isset($_SESSION["Authenticated"]) || $_SESSION["Authenticated"] == 0) {
    header("Location: index.php");
  }
}

/**
 * Create register interface
 */
function register() {
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

/**
 * Create login interface
 */
function login() {
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

/**
 * Send message error
 * @param $message
 */
function errorMessage($message) {
  ?>
  <div class="row">
    <div class="alert alert-warning col-xs-12">
      <p><?php print $message; ?></p>
    </div>
  </div>
  <?php
}

/**
 * Create footer
 */
function footer() {
  ?>
  <div class="row">
    <div class="col-xs-12 rrss">
      <a href="#"><img id="fb" src="image/img_trans.gif"></a>
      <a href="#"><img id="tw" src="image/img_trans.gif"></a>
      <a href="#"><img id="in" src="image/img_trans.gif"></a>
      <a href="#"><img id="tu" src="image/img_trans.gif"></a>
    </div>
    <div class="col-xs-12" role="footer">
      <p>@2017 | Designed by GrupoN3</p>
    </div>
    <div class="col-xs-12" id="thanks">
      <p>Agradecimientos a la comunidad OpenGameArt.org</p>
      <p> por todo el material audiovisual</p>
    </div>
  </div>
  <?php
}

/**
 * Check if the user has monstruos
 * @return bool
 */
function hasMonstruos() {
  $result = Entity::findOneBy("monstruos", array("userID" => new MongoId($_SESSION['user']['_id'])));
  if (empty($result))
    return false;
  return true;
}

/**
 * Create skills buttons on battle
 */
function skillsButtons() {
  for ($i = 0; $i < 10; $i++) {
    ?>
    <div class="col-xs-3">
      <img id="sign<?php print $i; ?>" class="img-sign" src="image/rightSign.png" width="20"
           height="20">
    </div>
    <div class="col-xs-9">
      <h3 id="btn-skill-<?php print $i; ?>">Habilidad<?php print $i; ?></h3>
    </div>
    <?php
  }
}

/**
 * Create skills buttons on battle
 */
function itemsButtons() {
  for ($i = 0; $i < 17; $i++) {
    ?>
    <div class="col-sm-4 col-xs-6 item">
      <h3 id="btn-item-<?php print $i; ?>">-<?php print $i; ?></h3>
    </div>
    <?php
  }
}