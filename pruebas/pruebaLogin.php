<?php
// Pass session data over.
session_start();
 
// Include the required dependencies.
require_once( 'vendor/autoload.php' );

$fb = new Facebook\Facebook([
  'app_id' => '259915584478602', 
  'app_secret' => 'be739ec8db993b668937fe4c7c58c649',
  'default_graph_version' => 'v2.3',
  ]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email', 'user_posts']; // optional
$callback    = 'http://mba.com/pruebas/fb-callback.php';
$loginUrl    = $helper->getLoginUrl($callback, $permissions);
 
echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
?>