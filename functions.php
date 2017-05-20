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
$loginUrl = $helper->getLoginUrl('http://'. $_SERVER['HTTP_HOST'] .'/fb-callback.php', $permissions);
$GLOBALS['loginUrl'] = $loginUrl;

if (!isset($_SESSION["Authenticated"]) && isset($_COOKIE["user"])) {
  $_SESSION["user"]["_id"] = $_COOKIE["user"];
  $user = getUser();
  $_SESSION["user"]["username"] = $user->get("username");
  $_SESSION["Authenticated"] = 1;
}
/**
 * Get actual user
 *
 * @return User
 */
function getUser() {
  $user = User::fromArray(Entity::findById("users", new MongoId($_SESSION["user"]["_id"])));
  return $user;
}

/**
 * Get actual user monstruos
 *
 * @return array|null
 */
function getMonstruos() {
  $monstruos = Entity::findAllBy("monstruos", array("userID" => new MongoId($_SESSION['user']['_id'])));
  return $monstruos;
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
      echo '<a href="' . $GLOBALS['loginUrl'] . '" class="btn btn-login fb-button" target="_top"></a>';
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
      <a href="https://www.facebook.com/Monstruos-Bizarre-Adventure-2-1495483530516515/"><img id="fb" src="image/img_trans.gif"></a>
      <a href="https://twitter.com/mba2com"><img id="tw" src="image/img_trans.gif"></a>
      <a href="#"><img id="in" src="image/img_trans.gif"></a>
      <a href="#"><img id="tu" src="image/img_trans.gif"></a>
    </div>
    <div class="col-xs-12" role="footer">
      <p>@2017 | Designed by GrupoN3</p>
    </div>
    <div class="col-xs-12" id="contact">
      <p><span class="glyphicon glyphicon-envelope"></span> Contacto : <a href="mailto:mba2soporte@gmail.com">mba2soporte@gmail.com</a></p>
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

/**
 * Create items list for user panel
 *
 * @param $userItemList
 */
function itemList($userItemList) {
  ?>
  <div class="row">
    <div class="col-xs-4 col-xs-offset-1 userTables">Objetos</div>
  </div>
  <div id="itemsData">

  <?php
  foreach ($userItemList as $item) {
    ?>
    <div class="row">
      <img src="<?php print $item['img']; ?>" class="col-xs-2 img-responsive itemPic"/>
      <div class="col-xs-4">
        <h4><?php print $item['name']; ?></h4>
      </div>
      <div class="col-xs-4">
        <p>Uds x<?php print $item['amount']; ?></p>
      </div>
    </div>
    <?php
  }
  ?>
  </div>
  <?php
}

/**
 * Create a list of all of users monstruos for user panel
 *
 * @param $monstruos
 */
function monstruoList($monstruos) {
  ?>
  <div class="row">
    <div class="col-xs-4 col-xs-offset-1 userTables">Monstruos</div>
  </div>
  <?php
  foreach ($monstruos as $monstruo) {
    $monstruo = Monstruo::fromArray($monstruo);
    $charasteristics = $monstruo->get('characteristics');
    ?>
    <div class="row">
      <img src="<?php print $monstruo->get('img'); ?>" class="col-sm-2 col-xs-4"/>
      <div class="col-xs-8">
        <div class="col-xs-12 monstruoName">
          <h4>Nombre : <?php print $monstruo->get('name'); ?></h4>
        </div>
        <div class="col-sm-4 col-sm-offset-4 col-xs-offset-2">
          <table>
            <tr>
              <td>HP :</td>
              <td><?php print $charasteristics['hp'] . '/' . $charasteristics['maxHp']; ?></td>
            </tr>
            <tr>
              <td>STR :</td>
              <td><?php print $charasteristics['str']; ?></td>
            </tr>
            <tr>
              <td>DEF :</td>
              <td><?php print $charasteristics['def']; ?></td>
            </tr>
            <tr>
              <td>LUK :</td>
              <td><?php print $charasteristics['luk']; ?></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <?php
  }
}
