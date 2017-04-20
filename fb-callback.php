<?php
session_start();
$dbname = "mba";
require_once __DIR__ . '/vendor/autoload.php';

$fb = new Facebook\Facebook([
    'app_id' => '259915584478602',
    'app_secret' => 'be739ec8db993b668937fe4c7c58c649',
    'default_graph_version' => 'v2.3',
]);

$helper = $fb->getRedirectLoginHelper();
try {
  $accessToken = $helper->getAccessToken();
} catch (Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch (Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (isset($accessToken)) {
  // Logged in!
  $_SESSION['facebook_access_token'] = (string)$accessToken;
  $_SESSION["Authenticated"] = 1;
  // Now you can redirect to another page and use the
  // access token from $_SESSION['facebook_access_token']
  $fb = new Facebook\Facebook([
      'app_id' => '259915584478602',
      'app_secret' => 'be739ec8db993b668937fe4c7c58c649',
      'default_graph_version' => 'v2.3',
  ]);

  try {
    // Returns a `Facebook\FacebookResponse` object
    $response = $fb->get('/me?fields=id,name', $_SESSION['facebook_access_token']);
    $_SESSION["Authenticated"] == 1;
  } catch (Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }
  //Get users' data
  $user = $response->getGraphUser();
  // connect to localhost:27017
  $connection = new MongoClient();
  $usersCollection = $connection->$dbname->users;
  $result = $usersCollection->findOne(array("facebookID" => $user['id']));
  //Find the user, if doesn't exist create new user with facebook's id
  if (empty($result)) {
    //First create a new user with the and save de facebookID
    $newUser = array("facebookID" => $user['id']);
    $usersCollection->insert($newUser);
    //Update the same user with username == mongoID
    //This way we create a new user with a serialID by username
    $newData = array('$set' => array("username" => (string) $newUser['_id']));
    $usersCollection->update(array("facebookID" => $user['id']), $newData);
    $_SESSION["user"]["name"] = (string) $newUser['_id'];
    $_SESSION["user"]["id"] = (string) $newUser['_id'];
  }else {
    $_SESSION["user"]["name"] = $result['username'];
    $_SESSION["user"]["id"] = (string) $result['_id'];
  }
  header("Location: home.php");
}