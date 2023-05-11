<?php


require 'vendor/autoload.php';
include 'db_connection.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $deleteResult = $users->deleteOne(
        array('_id' => new MongoDB\BSON\ObjectId($delete_id))
    );
    header('location:admin_users.php');
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
    <title>Usuarios</title>
    <link rel="icon" href="images/icono.png">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
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
    <div class="about">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title">
                        <i class="fa-solid fa-user-check"></i>
                        <h2>Usuarios Creados</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="users">

        <div class="container">
            <div class="row">
                <div class="col">
                    <section class="show-products">
                        <div class="box-container">
                            <div class="row">

                                <?php
                                $select_users1 = $users->find();
                                foreach ($select_users1 as $fetch_users1) {
                                ?>


                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-body">

                                                <p> ID de Usuario: <span><?php echo $fetch_users1['_id']; ?></span> </p>
                                                <p> Nombre de usuario: <span><?php echo $fetch_users1['name']; ?></span> </p>
                                                <p> Correo: <span><?php echo $fetch_users1['email']; ?></span> </p>
                                                <p> Tipo de usuario: <span style="color:<?php if ($fetch_users1['user_type'] == 'admin') {
                                                                                                echo 'var(--orange)';
                                                                                            } ?>"><?php echo $fetch_users1['user_type']; ?></span> </p>
                                                <a href="admin_users.php?delete=<?php echo $fetch_users1['_id']; ?>" onclick="return confirm('¿Desea eliminar este usuario?');" class="delete-btn">Eliminar usuario</a>

                                            </div>
                                        </div>
                                    </div>
                                <?php
                                };
                                ?>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
    </section>
    

    <!-- custom admin js file link  -->
    <script src="js/admin_script.js"></script>

</body>

</html>