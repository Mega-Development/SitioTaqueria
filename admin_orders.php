<?php


require 'vendor/autoload.php';
include 'db_connection.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_POST['update_order'])) {

    $order_update_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];
    $updateResult = $orders->updateOne(
        array('_id' => new MongoDB\BSON\ObjectId($order_update_id)),
        ['$set' => ['payment_status' => $update_payment]]
    );

    $message[] = 'La orden ha sido actualizada';
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $deleteResult = $orders->deleteOne(
        array('_id' => new MongoDB\BSON\ObjectId($delete_id))
    );
    header('location:admin_orders.php');
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
    <title>Órdenes</title>
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
                        <i class="fa-solid fa-list-check"></i>
                        <h2>Pedidos Realizados</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="orders">

        <div class="box-container">
            <?php
            $doc = $orders->count();
            if ($doc > 0) {
                $select_orders1 = $orders->find();
                foreach ($select_orders1 as $fetch_orders1) {
            ?>
                    <div class="col-xl-4 col-md-6 col-sm-6">
                        <div class="card">
                            <div class="card-header " style="background-color: #d3d3d3 ;">
                                <div class="row">
                                    <div class="col-sm">
                                        <b>N° Pedido:<br><span style="text-align:end; color:green;"></b><?php echo $fetch_orders1['_id']; ?></span>
                                    </div>
                                </div>

                            </div>

                            <div class="card-body" style="width: 460px;max-height:550px ;">
                                <h5 class="card-title">Pedido el: <span><?php echo $fetch_orders1['placed_on']; ?></span></h5>
                                <p> ID de Usuario: <span><?php echo $fetch_orders1['user_id']; ?></span> </p>
                                <p class="card-text"> Pedido a: <span><?php echo $fetch_orders1['placed_on']; ?></span> </p>
                                <p class="card-text"> Cliente: <span><?php echo $fetch_orders1['name']; ?></span> </p>
                                <p class="card-text"> Teléfono: <span><?php echo $fetch_orders1['number']; ?></span> </p>
                                <p class="card-text"> Correo: <span><?php echo $fetch_orders1['email']; ?></span> </p>
                                <p class="card-text"> Dirección: <span><?php echo $fetch_orders1['address']; ?></span> </p>
                                <p class="card-text"> Total de platillos: <span><?php echo $fetch_orders1['total_products']; ?></span> </p>
                                <p class="card-text"> Cuenta total: <span>$<?php echo $fetch_orders1['total_price']; ?>/-</span> </p>
                                <p class="card-text"> Método de pago: <span><?php echo $fetch_orders1['method']; ?></span> </p>
                                <br>
                                <p class="card-text"><b> Actualizar estado: </b></p>
                                <form action="" method="post">
                                    <input type="hidden" name="order_id" value="<?php echo $fetch_orders1['_id']; ?>">
                                    <select name="update_payment">
                                        <option value="" selected disabled><?php echo $fetch_orders1['payment_status']; ?></option>
                                        <option value="pending">Pendiente</option>
                                        <option value="completed">Completado</option>
                                    </select>
                                    <input type="submit" value="Actualizar" name="update_order" class="option-btn" >
                                    <hr>
                                    <a href="admin_orders.php?delete=<?php echo $fetch_orders1['_id']; ?>" onclick="return confirm('¿Desea eliminar esta orden?');" class="delete-btn" >Eliminar</a>
                                </form>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">Aún no ha sido realizada ninguna orden</p>';
            }
            ?>
        </div>

    </section>



    <!-- custom admin js file link  -->
    <script src="js/admin_script.js"></script>

</body>

</html>