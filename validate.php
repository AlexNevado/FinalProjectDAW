<?php
session_start();
include 'functions.php';

if (isset($_GET["logout"])) {
  session_destroy();
  $_SESSION[] = array();
  setcookie("user", $_SESSION["user"]["_id"], time() - 3600);
  unset($_COOKIE['PHPSESSID']);
  header("Location: index.php");
} else if (isset ($_POST["username"]) && isset($_POST['password'])) {
  $result = Entity::findOneBy('users',array('username' => $_POST["username"], 'password' => md5($_POST["password"])));

  if (!empty($result)) {
    $_SESSION["Authenticated"] = 1;
    $_SESSION['user'] = array(
        '_id' => (string)$result['_id'],
        'username' => $result['username'],
    );
    setcookie("user", $_SESSION["user"]["_id"], time() + 31556926);
    header("Location: home.php");
  } else {
    $_SESSION["Authenticated"] = 0;
    header("Location: index.php?error");
  }
} else {
  header("Location: index.php?error");
}
session_write_close();
