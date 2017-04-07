<?php
$fb = new Facebook\Facebook([
  'app_id' => '259915584478602', // Replace {app-id} with your app id
  'app_secret' => 'be739ec8db993b668937fe4c7c58c649',
  'default_graph_version' => 'v2.2',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://example.com/fb-callback.php', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
?>