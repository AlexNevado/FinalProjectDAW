<?php
session_start();

	require_once __DIR__ . '/vendor/autoload.php';
 		# login.php
$fb = new Facebook\Facebook([
  'app_id' => '259915584478602', 
  'app_secret' => 'be739ec8db993b668937fe4c7c58c649',
  'default_graph_version' => 'v2.3',
  ]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email', 'user_likes']; // optional
$loginUrl = $helper->getLoginUrl('http://mba2.com/pruebas/callback.php', $permissions);

echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';