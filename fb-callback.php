<?php
session_start();
include 'functions.php';
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
  } catch (Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }
  //Get users' data
  $facebookUser = $response->getGraphUser();

  //Create new user with facebookID
  $user = new User();
  $user->set("facebookID", $facebookUser['id']);
  //Find the user, if doesn't exist create new user with facebook's id
  $result = $user->findByField("facebookID");
  if (empty($result)) {
    // Set users propertys and save
    $user->set("_id", new MongoId());
    $user->set("username", (string)$user->_id);
    $user->save();

    $_SESSION['user']['_id'] = (string)$user->_id;
  } else {
    $_SESSION['user']['_id'] = (string)$result['_id'];
  }
  header("Location: home.php");
}