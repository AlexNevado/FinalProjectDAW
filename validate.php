<?php
session_start();
include 'functions.php';
$dbname = "mba";
if (isset($_GET["logout"])) {
  session_destroy();
  $_SESSION[] = array();
  setcookie("user", $_SESSION["user"]["name"], time() - 3600);
  unset($_COOKIE['PHPSESSID']);
  header("Location: index.php");
} else if (isset ($_POST["username"]) && isset($_POST['password'])) {
  $connection = new MongoClient(); // connect to localhost:27017

  $user = $_POST["username"];
  $pass = md5($_POST["password"]);

  $usersCollection = $connection->$dbname->users;
  $result = $usersCollection->findOne(array("username" => $user, "password" => $pass));

  if (!empty($result)) {
    $_SESSION["Authenticated"] = 1;
    $_SESSION["user"]["name"] = $result['username'];
    $_SESSION["user"]["id"] = (string) $result['_id'];
    setcookie("user", $_SESSION["user"]["name"], time() + 31556926);
    header("Location: home.php");
  } else {
    $_SESSION["Authenticated"] = 0;
    header("Location: index.php?error");
  }
} else {
  header("Location: index.php?error");
}
session_write_close();
