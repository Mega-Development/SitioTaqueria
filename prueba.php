<?php 
    require 'vendor/autoload.php';
    include 'db_connection.php';
    
    $delete_id = $_GET['delete'];

    $dato = $products->findOne(
        ['_id' => new MongoDB\BSON\ObjectId($delete_id)]
    );
    var_dump($dato['image']);
    unlink('uploaded_img/'.$dato['image']);

    $deleteResult = $products->deleteMany(
        ['_id' => new MongoDB\BSON\ObjectId($delete_id)]
    );

    //unlink('uploaded_img/enchiladas_verdes.png');
    var_dump($deleteResult);
    //prueba.php?delete=6278c0fe5161000044003665

?>