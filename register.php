<?php
session_start();
include 'functions.php';

$dbname = "mba";
if (isset ($_POST["username"]) && isset($_POST['password'])) {
  /* $connection = new MongoClient(); // conectar a localhost:27017

   $user = $_POST["username"];
   $pass = md5($_POST["password"]);

   $usersCollection = $connection->$dbname->users;
 */
  $user = new User();
  $user->set("username", $_POST["username"]);
  $result = $user->findThisByUsername();
  //$result = $usersCollection->findOne(array("username" => $user), array('password' => 0));

  if (!empty($result)) {
    header("Location: index.php?register&&error");
  } else {
    $user->create(md5($_POST["password"]));
    //$usersCollection->insert(array("username" => $user, 'password' => $pass));
    header("Location: index.php");
  }
}
session_write_close();
