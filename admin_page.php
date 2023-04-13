<?php


require 'vendor/autoload.php';
include 'config1.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin panel</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>

<?php include 'admin_header.php'; ?>

<!-- admin dashboard section starts  -->

<section class="dashboard">

    <h1 class="title">Tablero administrador</h1>

    <div class="box-container">

        <div class="box">
            <?php
            $total_pendings = 0;
            $filter = array('payment_status'=>'pending');
            $doc=$orders->count($filter);

            if($doc > 0){
                $select_pending1 = $orders->find(
                    ['payment_status'=>'pending']
                );
                foreach($select_pending1 as $fetch_pendings1){
                    $total_price = $fetch_pendings1['total_price'];
                    $total_pendings += $total_price;
                };
            };
            ?>
            <h3>$<?php echo $total_pendings; ?>/-</h3>
            <p>Total pendientes</p>
        </div>

        <div class="box">
            <?php
            $total_completed = 0;
            $filter2 = array('payment_status'=>'completed');
            $doc2=$orders->count($filter2);
            if($doc2 > 0){
                $select_completed1 = $orders->find(
                    ['payment_status'=>'completed']
                );
                foreach($select_completed1 as $fetch_completed1){
                    $total_price = $fetch_completed1['total_price'];
                    $total_completed += $total_price;
                };
            };
            ?>
            <h3>$<?php echo $total_completed; ?>/-</h3>
            <p>Pagos procesados</p>
        </div>

        <div class="box">
            <?php
            $doc3=$orders->count();
            $number_of_orders = $doc3;
            ?>
            <h3><?php echo $number_of_orders; ?></h3>
            <p>Pedidos realizados</p>
        </div>

        <div class="box">
            <?php
            $doc4=$products->count();
            $number_of_products = $doc4;
            ?>
            <h3><?php echo $number_of_products; ?></h3>
            <p>Productos añadidos</p>
        </div>

        <div class="box">
            <?php
            $filter5 = array('user_type'=>'user');
            $doc5=$users->count($filter5);
            $number_of_users = $doc5;
            ?>
            <h3><?php echo $number_of_users; ?></h3>
            <p>Usuarios normales</p>
        </div>

        <div class="box">
            <?php
            $filter6 = array('user_type'=>'admin');
            $doc6=$users->count($filter6);
            $number_of_admins = $doc6;
            ?>
            <h3><?php echo $number_of_admins; ?></h3>
            <p>Usuarios administradores</p>
        </div>

        <div class="box">
            <?php
            $doc7=$users->count();
            $number_of_account = $doc7;
            ?>
            <h3><?php echo $number_of_account; ?></h3>
            <p>Total de cuentas</p>
        </div>

        <div class="box">
            <?php
            $doc8=$mensaje->count();
            $number_of_messages = $doc8;
            ?>
            <h3><?php echo $number_of_messages; ?></h3>
            <p>Mensajes nuevos</p>
        </div>

    </div>

</section>

<!-- admin dashboard section ends -->



<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>