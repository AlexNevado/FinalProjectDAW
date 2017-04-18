<?php
session_start();
$dbname = "mba";
if (isset ($_POST["username"]) && isset($_POST['password'])) {
  $connection = new MongoClient(); // conectar a localhost:27017

  $user = $_POST["username"];
  $pass = md5($_POST["password"]);

  $usersCollection = $connection->$dbname->users;

  $result = $usersCollection->findOne(array("username" => $user), array('password' => 0));

  if (!empty($result)) {
    header("Location: index.php?register&&error");
  } else {
    $usersCollection->insert(array("username" => $user, 'password' => $pass));
    header("Location: index.php");
  }
}
session_write_close();
