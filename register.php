<?php
session_start();
include 'functions.php';

if (isset ($_POST["username"]) && isset($_POST['password'])) {
  $user = new User();
  $user->set("username", $_POST["username"]);
  $result = $user->findByField("username");

  if (!empty($result)) {
    header("Location: index.php?register&&error");
  } else {
    $user->set("coins", 10);
    $user->create(md5($_POST["password"]));
    header("Location: index.php");
  }
}
session_write_close();
