<?php

require 'vendor/autoload.php';
include 'config1.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>órdenes</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'header.php'; ?>

<div class="heading">
    <h3>Tus ordenes</h3>
    <p> <a href="home.php" style="text-decoration: none;">Inicio</a> / Órdenes </p>
</div>

<section class="placed-orders">

    <h1 class="title">Tus órdenes</h1>

    <div class="box-container">

        <?php
        $filter = array('user_id'=>new MongoDB\BSON\ObjectId($user_id));
        $doc=$orders->count($filter);

        if($doc > 0){
            $order_query1 = $orders->find(array('user_id'=>new MongoDB\BSON\ObjectId($user_id)));
            foreach($order_query1 as $fetch_orders1){
                ?>
                <div class="box">
                    <p> Colocado en: <span><?php echo $fetch_orders1['placed_on']; ?></span> </p>
                    <p> Nombrae: <span><?php echo $fetch_orders1['name']; ?></span> </p>
                    <p> Número: <span><?php echo $fetch_orders1['number']; ?></span> </p>
                    <p> Correo: <span><?php echo $fetch_orders1['email']; ?></span> </p>
                    <p> Dirección: <span><?php echo $fetch_orders1['address']; ?></span> </p>
                    <p> Método de pago: <span><?php echo $fetch_orders1['method']; ?></span> </p>
                    <p> Tus órdenes: <span><?php echo $fetch_orders1['total_products']; ?></span> </p>
                    <p> Precio total: <span>$<?php echo $fetch_orders1['total_price']; ?>/-</span> </p>
                    <p> Estado de pago: <span style="color:<?php if($fetch_orders1['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; } ?>;"><?php echo $fetch_orders1['payment_status']; ?></span> </p>
                </div>
                <?php
            }
        }else{
            echo '<p class="empty">No tienes órdenes aún</p>';
        }
        ?>
    </div>
            <center>
            <div class="text-center mb-2">
              <a href="/recibo.php" target="_blank" class="btn btn-success">Factura</a>
            </div>
            </center>
</section>



<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>