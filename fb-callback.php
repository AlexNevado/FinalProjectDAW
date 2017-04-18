<?php
session_start();
  require_once __DIR__ . '/vendor/autoload.php';

# login-callback.php
$fb = new Facebook\Facebook([
  'app_id' => '259915584478602', 
  'app_secret' => 'be739ec8db993b668937fe4c7c58c649',
  'default_graph_version' => 'v2.3',
  ]); 

$helper = $fb->getRedirectLoginHelper();
try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (isset($accessToken)) {
  // Logged in!
  $_SESSION['facebook_access_token'] = (string) $accessToken;
  header("Location: home.php");
  // Now you can redirect to another page and use the
  // access token from $_SESSION['facebook_access_token']
}