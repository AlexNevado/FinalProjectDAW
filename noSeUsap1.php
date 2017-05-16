<?php
/**
 * Created by PhpStorm.
 * User: tero
 * Date: 4/26/17
 * Time: 11:57 PM
 */
session_start();
include 'functions.php';
const DDBB_NAME = "mba";

$dbname = "mba";

$monstruo = new Monstruo();
$monstruo->set("name","Monstruaco");
$monstruo->set("img","image/aaaaa.png");
$monstruo->set("_id", new MongoId("590122c98ead0ed71b74ac0c"));
$monstruo->save();
$a=0;


$user = new User();
$user->set("username","personajazo");
$user->set("img","image/aaaaa.png");
$user->save();

echo DDBB_NAME;
$collectionName ="users";
$connection = new MongoClient();
$collection = $connection->DDBB_NAME->$collectionName;
$aa = $collection->findOne(array("_id" => new MongoId("58f93a488ead0ecf048b4568")));
$a=0;