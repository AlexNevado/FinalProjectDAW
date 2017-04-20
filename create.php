<?php
session_start();
$dbname = "mba";
if (isset ($_POST["monsterName"])) {
  // connect to localhost:27017
  $connection = new MongoClient();
  $usersCollection = $connection->$dbname->users;

  $usersCollection->update(array("_id" => new MongoId($_SESSION["user"]["id"])),
      array("monstruos" =>
          array("monstruoID" => new MongoId(),
              "name"=>$_POST["monsterName"],
              "characteristics" => array("str" => $_POST['str'], "def" => $_POST['def'], "luk" => $_POST['luk']),
              "abilities" => array("abi1" => $_POST['abi']))));
  header("Location: home.php");
}