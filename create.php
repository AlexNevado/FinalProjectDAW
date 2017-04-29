<?php
session_start();
include 'functions.php';

if (isset ($_POST["monsterName"])) {

  $monstruo = new Monstruo();
  $monstruo->set('_id', new MongoId());
  $monstruo->set('userID', new MongoId($_SESSION["user"]["_id"]));
  $monstruo->set('name', $_POST["monsterName"]);
  $monstruo->set('characteristics', array('str' => $_POST['str'], 'def' => $_POST['def'], 'luk' => $_POST['luk'], 'hp'=> rand(10,50)));
  $monstruo->set('abilities', array('abi1' => $_POST['abi']));
  $monstruo->save();

  $user = new User();
  $user = Entity::findOneBy("users", array("_id" => new MongoId($_SESSION['user']['_id'])));
  if (!empty($user)) {
    $user = User::fromArray($user);
    $user->addMonstruo($monstruo->get('_id'));
    $user->save();
  }




  header("Location: home.php");
}