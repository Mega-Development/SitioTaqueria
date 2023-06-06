<?php


require 'vendor/autoload.php';
include 'db_connection.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
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
    <title>Administración</title>
    <link rel="icon" href="./images/favicon.png">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- owl css -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="css/estyle.css">
    <!-- awesome fontfamily -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>

<body>

    <?php include 'admin_header.php'; ?>

    <!-- admin dashboard section starts  -->

    <section class="dashboard">

        <!-- about -->
        <div class="about">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="title">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                            <h2>Tablero de administradores</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end about -->

        <div class="box-container">
            <div class="row mt-2">

                <div class="col-xl-4 col-md-6 col-sm-6">
                    <div class="card crypto-card-3 pull-up">
                        <div class="card-content">
                            <div class="card-body">

                                <?php
                                $total_pendings = 0;
                                $filter = array('payment_status' => 'pending');
                                $doc = $orders->count($filter);

                                if ($doc > 0) {
                                    $select_pending1 = $orders->find(
                                        ['payment_status' => 'pending']
                                    );
                                    foreach ($select_pending1 as $fetch_pendings1) {
                                        $total_price = $fetch_pendings1['total_price'];
                                        $total_pendings += $total_price;
                                    };
                                };
                                ?>

                                <div class="row">
                                    <div class="px-1 align-self-center">
                                        <h2 class="text-bold-500">Total de dinero en ordenes pendientes</h2>
                                    </div>
                                </div>
                                <div class="row py-2 d-flex justify-content-around">
                                    <div class="mr-auto ml-1">
                                        <h3>$<?php echo $total_pendings; ?></h3><span class="text-light"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 col-sm-6">
                    <div class="card crypto-card-3 pull-up">
                        <div class="card-content">
                            <div class="card-body">

                                <?php
                                $total_completed = 0;
                                $filter2 = array('payment_status' => 'completed');
                                $doc2 = $orders->count($filter2);
                                if ($doc2 > 0) {
                                    $select_completed1 = $orders->find(
                                        ['payment_status' => 'completed']
                                    );
                                    foreach ($select_completed1 as $fetch_completed1) {
                                        $total_price = $fetch_completed1['total_price'];
                                        $total_completed += $total_price;
                                    };
                                };
                                ?>

                                <div class="row">
                                    <div class="px-1 align-self-center">
                                        <h2 class="text-bold-500">Total de dinero en órdenes completadas</h2>
                                    </div>
                                </div>
                                <div class="row py-2 d-flex justify-content-around">
                                    <div class="mr-auto ml-1">
                                        <h3>$<?php echo $total_completed; ?></h3>
                                        <span class="text-light"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 col-sm-6">
                    <div class="card crypto-card-3 pull-up">
                        <div class="card-content">
                            <div class="card-body">

                                <?php
                                $doc3 = $orders->count();
                                $number_of_orders = $doc3;
                                ?>
                                <div class="row">
                                    <div class="px-1 align-self-center">
                                        <h2 class="text-bold-500">Órdenes</h2>
                                    </div>
                                </div>
                                <div class="row py-2 d-flex justify-content-around">
                                    <div class="mr-auto ml-1">
                                        <h3><?php echo $number_of_orders; ?></h3><span class="text-light"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xl-4 col-md-6 col-sm-6">
                    <div class="card crypto-card-3 pull-up">
                        <div class="card-content">
                            <div class="card-body">

                                <?php
                                $doc4 = $products->count();
                                $number_of_products = $doc4;
                                ?>
                                <div class="row">
                                    <div class="px-1 align-self-center">
                                        <h2 class="text-bold-500">Total de productos añadidos al menú</h2>
                                    </div>
                                </div>
                                <div class="row py-2 d-flex justify-content-around">
                                    <div class="mr-auto ml-1">
                                        <h3><?php echo $number_of_products; ?></h3><span class="text-light"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xl-4 col-md-6 col-sm-6">
                    <div class="card crypto-card-3 pull-up">
                        <div class="card-content">
                            <div class="card-body">

                                <?php
                                $filter5 = array('user_type' => 'user');
                                $doc5 = $users->count($filter5);
                                $number_of_users = $doc5;
                                ?>

                                <div class="row">
                                    <div class="px-1 align-self-center">
                                        <h2 class="text-bold-500">Total de usuarios normales</h2>
                                    </div>
                                </div>
                                <div class="row py-2 d-flex justify-content-around">
                                    <div class="mr-auto ml-1">
                                        <h3><?php echo $number_of_users; ?></h3><span class="text-light"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 col-sm-6">
                    <div class="card crypto-card-3 pull-up">
                        <div class="card-content">
                            <div class="card-body">

                                <?php
                                $filter6 = array('user_type' => 'admin');
                                $doc6 = $users->count($filter6);
                                $number_of_admins = $doc6;
                                ?>

                                <div class="row">
                                    <div class="px-1 align-self-center">
                                        <h2 class="text-bold-500">Total de usuarios administradores</h2>
                                    </div>
                                </div>
                                <div class="row py-2 d-flex justify-content-around">
                                    <div class="mr-auto ml-1">
                                        <h3><?php echo $number_of_admins; ?></h3><span class="text-light"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 col-sm-6">
                    <div class="card crypto-card-3 pull-up">
                        <div class="card-content">
                            <div class="card-body">

                                <?php
                                $doc7 = $users->count();
                                $number_of_account = $doc7;
                                ?>
                                <div class="row">
                                    <div class="px-1 align-self-center">
                                        <h2 class="text-bold-500">Total de cuentas</h2>
                                    </div>
                                </div>
                                <div class="row py-2 d-flex justify-content-around">
                                    <div class="mr-auto ml-1">
                                        <h3><?php echo $number_of_account; ?></h3>
                                        <span class="text-light"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 col-sm-6">
                    <div class="card crypto-card-3 pull-up">
                        <div class="card-content">
                            <div class="card-body">
                                <?php
                                $doc8 = $messages->count();
                                $number_of_messages = $doc8;
                                ?>

                                <div class="row">
                                    <div class="px-1 align-self-center">
                                        <h2 class="text-bold-500">Mensajes nuevos</h2>
                                    </div>
                                </div>
                                <div class="row py-2 d-flex justify-content-around">
                                    <div class="mr-auto ml-1">
                                        <h3><?php echo $number_of_messages; ?></h3>
                                        <span class="text-light"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </section>

    <script src="js/admin_script.js"></script>

</body>

</html>