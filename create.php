<?php
session_start();
$dbname = "mba";
if (isset ($_POST["monsterName"])) {
  $hp = rand(10,50);
  // connect to localhost:27017
  $connection = new MongoClient();
  $monstruosCollection = $connection->$dbname->monstruos;
  $monstruo = array(
      "userID" => new MongoId($_SESSION["user"]["id"]),
      "name" => $_POST["monsterName"],
      "characteristics" => array('str' => $_POST['str'], 'def' => $_POST['def'], 'luk' => $_POST['luk'], 'hp'=> $hp),
      "abilities" => array('abi1' => $_POST['abi']));
  $monstruosCollection->insert($monstruo);

  $connection = new MongoClient();
  $usersCollection = $connection->$dbname->users;
  $newData = array('$push' => array('monstruos' => array('monstruoID' => $monstruo['_id'])));
  $usersCollection->update(array('_id' => new MongoId($_SESSION['user']['id'])), $newData);

  header("Location: home.php");
}