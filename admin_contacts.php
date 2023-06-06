<?php


require 'vendor/autoload.php';
include 'db_connection.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:login.php');
};

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $deleteResult = $messages->deleteOne(
        array('_id' => new MongoDB\BSON\ObjectId($delete_id))
    );
    header('location:admin_contacts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Mensajes</title>
    <link rel="icon" href="images/icono.png">
    <!-- owl css -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <!-- style css -->

    <link rel="stylesheet" href="css/estyle.css">
    <link rel="stylesheet" href="css/estilos.css">
    <!-- responsive-->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- awesome fontfamily -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="messages">

    <h1 class="title"> Mensajes </h1>

    <div class="box-container">
        <?php
        $doc=$messages->count();
        if($doc > 0){
            $select_message1 = $messages->find(

            );
            foreach($select_message1 as $fetch_message1){

                ?>
                <div class="box">
                    <p> ID de usuario : <span><?php echo $fetch_message1['user_id']; ?></span> </p>
                    <p> Nombre : <span><?php echo $fetch_message1['name']; ?></span> </p>
                    <p> Número : <span><?php echo $fetch_message1['number']; ?></span> </p>
                    <p> Correo : <span><?php echo $fetch_message1['email']; ?></span> </p>
                    <p> messages : <span><?php echo $fetch_message1['message']; ?></span> </p>
                    <a href="admin_contacts.php?delete=<?php echo $fetch_message1['_id']; ?>" onclick="return confirm('¿Desea eliminar?');" class="delete-btn">Eliminar mensaje</a>
                </div>
                <?php
            };
        }else{
            echo '<p class="empty">No tiene mensajes</p>';
        }
        ?>
    </div>

</section>


</body>
</html>