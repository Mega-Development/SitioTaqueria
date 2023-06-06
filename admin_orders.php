<?php


require 'vendor/autoload.php';
include 'db_connection.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login');
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
    header('location:admin_orders');
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
                        <div class="card crypto-card-3 pull-up">
                            <div class="card-content">
                                <div class="card-body">

                                    <p> ID de Usuario: <span><?php echo $fetch_orders1['user_id']; ?></span> </p>
                                    <p> Pedido a: <span><?php echo $fetch_orders1['placed_on']; ?></span> </p>
                                    <p> Nombre de usuario:<span><?php echo $fetch_orders1['name']; ?></span> </p>
                                    <p> Teléfono: <span><?php echo $fetch_orders1['number']; ?></span> </p>
                                    <p> Correo: <span><?php echo $fetch_orders1['email']; ?></span> </p>
                                    <p> Dirección: <span><?php echo $fetch_orders1['address']; ?></span> </p>
                                    <p> Total de platillos: <span><?php echo $fetch_orders1['total_products']; ?></span> </p>
                                    <p> Cuenta total: <span>$<?php echo $fetch_orders1['total_price']; ?>/-</span> </p>
                                    <p> Método de pago: <span><?php echo $fetch_orders1['method']; ?></span> </p>
                                    <form action="" method="post">
                                        <input type="hidden" name="order_id" value="<?php echo $fetch_orders1['_id']; ?>">
                                        <select name="update_payment">
                                            <option value="" selected disabled><?php echo $fetch_orders1['payment_status']; ?></option>
                                            <option value="pending">Pendiente</option>
                                            <option value="completed">Completado</option>
                                        </select>
                                        <input type="submit" value="Actualizar" name="update_order" class="option-btn">
                                        <a href="admin_orders?delete=<?php echo $fetch_orders1['_id']; ?>" onclick="return confirm('¿Desea eliminar esta orden?');" class="delete-btn">Eliminar</a>
                                    </form>
                                </div>
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