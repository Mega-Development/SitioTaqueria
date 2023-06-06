<?php

require 'vendor/autoload.php';
include 'db_connection.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login');
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
    <title>El taco feliz</title>
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

    <?php include 'header.php'; ?>
    <!-- about -->
    <div class="about">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title">
                        <i class="fa-solid fa-money-check-dollar"></i>
                        <h2>Revisa tus pedidos</h2>
                        <span>Todas tus órdenes al alcanze de un click
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- end about -->



    <section class="placed-orders">
        <div class="box-container">
            <?php
            $filter = array('user_id' => new MongoDB\BSON\ObjectId($user_id));
            $doc = $orders->count($filter);

            if ($doc > 0) {
                $order_query1 = $orders->find(array('user_id' => new MongoDB\BSON\ObjectId($user_id)));
                foreach ($order_query1 as $fetch_orders1) {
            ?>
                    <div class="">
                        <div class="card">
                            <div class="card-header " style="background-color: #d3d3d3 ;">
                                <div class="row">
                                    <div class="col-sm">
                                        Total a pagar:<br><span>$<?php echo $fetch_orders1['total_price']; ?></span>
                                    </div>
                                    <div class="col-sm">
                                        N° Pedido:<br><span style="text-align:end; color:green;"><?php echo $fetch_orders1['_id']; ?></span>
                                    </div>
                                </div>

                            </div>

                            <div class="card-body" style="width: 550px;max-height:550px ;">
                                <h5 class="card-title">Pedido el: <span><?php echo $fetch_orders1['placed_on']; ?></span></h5>
                                <p class="card-text">Enviar a: <span><?php echo $fetch_orders1['name']; ?></span></p>
                                <p class="card-text"> Número: <span><?php echo $fetch_orders1['number']; ?></span> </p>
                                <p class="card-text"> Correo: <span><?php echo $fetch_orders1['email']; ?></span> </p>
                                <p class="card-text"> Dirección: <span><?php echo $fetch_orders1['address']; ?></span> </p>
                                <p class="card-text"> Método de pago: <span><?php echo $fetch_orders1['method']; ?></span> </p>
                                <p class="card-text"> Tus órdenes: <span style="color:goldenrod;"><?php echo $fetch_orders1['total_products']; ?></span> </p>
                                <p class="card-text"> Estado de pago: <span style="color:<?php if ($fetch_orders1['payment_status'] == 'pending') {
                                                                                                echo 'red';
                                                                                            } else {
                                                                                                echo 'green';
                                                                                            } ?>;"><?php echo $fetch_orders1['payment_status']; ?></span> </p>

                                <a href="factura?order=<?php echo $fetch_orders1['_id']; ?>" class="btn">Ver Detalles</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">Aún no ha realizado ninguna orden</p>';
            }
            ?>
        </div>
    </section>

    <!-- footer -->
    <?php include 'footer.php'; ?>
    <!-- end footer -->

    <div class="overlay"></div>
    <!-- Javascript files-->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>

    <script src="js/jquery-3.0.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#dismiss, .overlay').on('click', function() {
                $('#sidebar').removeClass('active');
                $('.overlay').removeClass('active');
            });

            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').addClass('active');
                $('.overlay').addClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });
    </script>

    <style>
        #owl-demo .item {
            margin: 3px;
        }

        #owl-demo .item img {
            display: block;
            width: 100%;
            height: auto;
        }
    </style>


    <script>
        $(document).ready(function() {
            var owl = $('.owl-carousel');
            owl.owlCarousel({
                margin: 10,
                nav: true,
                loop: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 5
                    }
                }
            })
        })
    </script>

</body>

</html>