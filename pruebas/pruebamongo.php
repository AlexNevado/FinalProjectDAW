<!DOCTYPE html>
<html>
<head>
	<title>PRUEBA MONGO</title>
</head>
<body>
<?php
echo 'helloWorld';
$conexion = new MongoClient(); // conectar a localhost:27017
//$conexión = new MongoClient('mongodb://localhost/videoclub' ); // conectar a un host remoto (puerto predeterminado: 27017)

$bd = $conexion->videoclub;

// seleccionar una colección:
$coleccion = $bd->pelicules;
$documento = $coleccion->findOne(array("Codpeli" => 6));
var_dump($coleccion);
var_dump($documento);
echo "Codpeli: " . $documento['Codpeli'] . "<br>";
echo "Titol: " . $documento['Titol'];


?>
</body>
</html>