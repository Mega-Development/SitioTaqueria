<?php
require_once __DIR__ . '/vendor/autoload.php';
// Crea un alias del namespace
use MongoDB\Client as Mongo;

// Crea una instancia del driver MongoDB
$mongo= new Mongo("mongodb://localhost:27017");

// Selecciona la base de datos llamada "taqueria_db"
$taqueria_db = $mongo->taqueria_db;

// Selecciona la colección llamada "users" de la base de datos "taqueria_db"
$users = $taqueria_db->usuarios;
$cart = $taqueria_db->carrito;
$products= $taqueria_db->productos;
$orders= $taqueria_db->ordenes;
$mensaje= $taqueria_db->mensajes;
//PRUEBA

?>
