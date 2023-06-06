<?php
require_once __DIR__ . '/vendor/autoload.php';

// Crea una instancia del driver MongoDB Atlas
// $uri="mongodb+srv://<Usuario>:<Contraseña>.@clustertem2022.fuzew.mongodb.net/?retryWrites=true&w=majority";
// $client=new MongoDB\Client($uri);

// Crea una instancia del driver MongoDB Local
use MongoDB\Client as Mongo;
$mongo= new Mongo("mongodb://localhost:27017");

// Selecciona la base de datos llamada "taqueria_db"
$taqueria_db = $mongo->taqueria_db;

// Selecciona las colecciones de la base de datos "taqueria_db"
$users = $taqueria_db->usuarios;
$cart = $taqueria_db->carrito;
$products= $taqueria_db->productos;
$orders= $taqueria_db->ordenes;
$messages= $taqueria_db->mensajes;
$invoices= $taqueria_db->facturas;

?>
