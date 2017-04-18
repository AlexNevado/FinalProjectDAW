<?php
// Pass session data over.
session_start();
 
// Include the required dependencies.
require_once( 'vendor/autoload.php' );

// Initialize the Facebook PHP SDK v5.
$fb = new Facebook\Facebook([
  'app_id' => '259915584478602', 
  'app_secret' => 'be739ec8db993b668937fe4c7c58c649',
  'default_graph_version' => 'v2.3',
  ]);

# Facebook PHP SDK v5: Check Login Status Example
 
// Choose your app context helper
$helper = $fb->getCanvasHelper();
//$helper = $fb->getPageTabHelper();
//$helper = $fb->getJavaScriptHelper();
 
// Grab the signed request entity
$sr = $helper->getSignedRequest();
 
// Get the user ID if signed request exists
$user = $sr ? $sr->getUserId() : null;
 
if ( $user ) {
  try {
 
    // Get the access token
    $accessToken = $helper->getAccessToken();
  } catch( Facebook\Exceptions\FacebookSDKException $e ) {
 
    // There was an error communicating with Graph
    echo $e->getMessage();
    exit;
  }
}
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email', 'user_posts']; // optional
$callback    = 'http://mba.com/pruebas/index.php';
$loginUrl    = $helper->getLoginUrl($callback, $permissions);
 
echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
$accessToken = $helper->getAccessToken();

if (isset($accessToken)) {
  // Logged in!
  $_SESSION['facebook_access_token'] = (string) $accessToken;

  // Now you can redirect to another page and use the
  // access token from $_SESSION['facebook_access_token']
      header("Location: home.php");
}