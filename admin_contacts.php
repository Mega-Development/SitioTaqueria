<?php


require 'vendor/autoload.php';
include 'db_connection.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
};

if (isset($_GET['delete'])) {
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
            $doc = $messages->count();
            if ($doc > 0) {
                $select_message1 = $messages->find();
                foreach ($select_message1 as $fetch_message1) {

            ?>
                    <div class="col-xl-4 col-md-6 col-sm-6">
                        <div class="card">
                            <div class="card-header " style="background-color: #d3d3d3 ;">
                                <div class="row">
                                    <div class="col-sm">
                                    <p class="card-text" style="margin-left: 20px;"><b>Mensaje de: <span><?php echo $fetch_message1['name']; ?></span></b> </p>
                                    </div>
                                </div>

                            </div>

                            <div class="card-body" style="width: 460px;max-height:250px ;">
                                <p class="card-text"> ID de usuario : <span><?php echo $fetch_message1['user_id']; ?></span> </p>
                                <p class="card-text"> Número : <span><?php echo $fetch_message1['number']; ?></span> </p>
                                <p class="card-text"> Correo : <span><?php echo $fetch_message1['email']; ?></span> </p>
                                <p class="card-text"> Mensaje : <span><?php echo $fetch_message1['message']; ?></span> </p>
                                <a href="admin_contacts.php?delete=<?php echo $fetch_message1['_id']; ?>" onclick="return confirm('¿Desea eliminar?');" class="delete-btn">Eliminar mensaje</a>
                            </div>
                        </div>
                    </div>
                    <br>
            <?php
                };
            } else {
                echo '<p class="empty">No tiene mensajes</p>';
            }
            ?>
        </div>

    </section>


    <!-- custom admin js file link  -->
    <script src="js/admin_script.js"></script>
</body>

</html>