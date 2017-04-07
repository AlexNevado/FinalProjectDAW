<?php
	session_start();
	$dbname = "mba";
	if(isset($_GET["logout"])) {
      session_destroy();
      $_SESSION[] = array();
      setcookie("user",$_SESSION["user"]["login"],time() - 3600);
      unset($_COOKIE['PHPSESSID']);
  }else if (isset ($_POST["username"]) && isset($_POST['password'])) {
      $connection = new MongoClient(); // conectar a localhost:27017

      $user = $_POST["username"];
      $pass = md5($_POST["password"]);

      $usersCollection = $connection->$dbname->users;
      $result = $usersCollection->findOne(array("username" => 6,"password" => $pass));

      if(!empty($result)){
          $_SESSION["Authenticated"] = 1;
          $_SESSION["user"] = $result.username;
      }else {
          $_SESSION["Authenticated"] = 0;
      }
      setcookie("user",$_SESSION["user"]["login"],time()+31556926);
  }
	session_write_close();
	header("Location: home.php");
