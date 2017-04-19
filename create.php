<?php
session_start();
$dbname = "mba";
if (isset ($_POST["monsterName"])) {
  // connect to localhost:27017
  $connection = new MongoClient();

}