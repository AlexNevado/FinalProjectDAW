<?php
include 'functions.php';

$newUser = json_decode($_POST['user']);
$user = getUser();
$user->set("coins",$newUser['coins']);
//foreach ($newUser['items'] as $item) {}
foreach ($newUser['monstruos'] as $monstruo) {
  $monstruo=Monstruo::fromArray($monstruo);
  $a=0;
}
foreach($user as $producto)
{
  echo $producto->id . ', ';
  echo $producto->coins . ', ';
  echo $producto->username . ', ';
  echo '<br/>';
}