<!DOCTYPE html>
<html>
<head>
	<title>PRUEBA MONGO</title>
</head>
<body>
<?php
echo 'helloWorld';
/*
$conexion = new MongoClient(); // conectar a localhost:27017
//$conexión = new MongoClient('mongodb://localhost/videoclub' ); // conectar a un host remoto (puerto predeterminado: 27017)

$bd = $conexion->videoclub;
echo 'xxxxx';

// seleccionar una colección:
$coleccion = $bd->pelicules;
var_dump($coleccion);*/
$doc = array(
    "username" => "superadmin",
    "password" => md5('pass'));
/*
$conexión = new MongoClient();
echo 'pas1';

$colección = $conexión->mba->users;

$colección->insert( $doc );
echo 'inserted';
*/
$user = "superadmin";

$dbname = "mba";
$conexión = new MongoClient();
echo 'x';
$usersCollection = $connection->$dbname->users;
echo 'x';

$result = $usersCollection->findOne(array("username" => $user));
echo 'x';

echo "result:" . $result;
?>
</body>
</html>