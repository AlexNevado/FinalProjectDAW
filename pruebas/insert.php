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
$conexión = new MongoClient();
$colección = $conexión->mba->users;

$colección->insert( $doc );

?>
</body>
</html>