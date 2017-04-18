<?php
session_start();
$_SESSION["url"] = $_SERVER['PHP_SELF'];
include 'functions.php';

require_once __DIR__ . '/vendor/autoload.php';


if (isset($_SESSION['facebook_access_token'])) {
  $_SESSION["Authenticated"] = 1;
}
/*
 * $fb = new Facebook\Facebook([
    'app_id' => '259915584478602',
    'app_secret' => 'be739ec8db993b668937fe4c7c58c649',
    'default_graph_version' => 'v2.3',
]);

  try {
    // Returns a `Facebook\FacebookResponse` object
    $response = $fb->get('/me?fields=id,name', $_SESSION['accessToken']);
    $_SESSION["Authenticated"] == 1;
  } catch (Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }

  $user = $response->getGraphUser();
  echo 'Name: ' . $user['name'];
  var_dump($user);
*/
if (!isset($_SESSION["Authenticated"]) || $_SESSION["Authenticated"] == 0) {
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Monstruos's Bizarre Adventure</title>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
          integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
          crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col-xs-12" role="main">

    </div>
  </div>
  <div class="row">
    <div class="col-xs-2 col-xs-offset-8">
      <a href="validate.php?logout" class="btn btn-login btn-sm">Logout</a>
    </div>
  </div>
  <?php footer() ?>
</div>
</body>
</html>