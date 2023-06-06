<?php

require 'vendor/autoload.php';
include 'db_connection.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
}

if(isset($_POST['send'])){

    $name1 = $_POST['name'];
    $email1 = $_POST['email'];
    $number1 = $_POST['number'];
    $msg1 = $_POST['message'];

    $filter = array('name'=>$name1,'email'=>$email1,'number'=>$number1,'message'=>$msg1);
    $doc=$mensaje->count($filter);

    if($doc> 0){
        $message[] = 'message sent already!';
    }else{
        $insertOneResult = $mensaje->insertOne(
            ['user_id' => new MongoDB\BSON\ObjectId($user_id), 'name' => $name1, 'email' => $email1,'number' => $number1,'message' => $msg1]
        );

        $message[] = 'message sent successfully!';
    }

}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>El taco feliz</title>
    <link rel="icon" href="./images/favicon.png">
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
<!-- body -->

<body class="main-layout">
    <!-- loader  -->
    <div class="loader_bg" style="background-color: white;">
        <div class="loader"><img src="images/loader_4.gif" alt="" /></div>
    </div>

    <div class="wrapper">
        <div id="content">

            <?php include "header.php"; ?>
        <!-- about -->
        <div class="about">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="title">
                                <i class="fa-solid fa-mobile-button"></i>
                                    <h2>Contáctanos</h2>
                                    <span>Mantente comunicado con nosotros
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
        <!-- end about -->
                <!--contact us-->
                <div class="container">
                    <div class="row">
                        <div class="col-6">
                            <form action="" method="post">
                                <h3>¿Tienes algo que decirnos?</h3>
                                <label class="lead" style="font-size: 25px">Nombre</label><br>
                                <input type="text" name="name" required placeholder="Ingresa tu nombre" class="nombre-contact"><br>
                                <label class="lead" style="font-size: 25px">Correo</label><br>
                                <input type="email" name="email" required placeholder="Ingresa tu correo" class="nombre-contact"><br>
                                <label class="lead" style="font-size: 25px">Telefono</label><br>
                                <input type="number" name="number" required placeholder="Ingresa tu telefono" class="nombre-contact"><br>
                                <label class="lead" style="font-size: 25px">Mensaje</label><br>
                                <textarea name="message" class="nombre-contact" placeholder="Ingresa tu mensaje" id="" cols="30" rows="10"></textarea><br>
                                <input type="submit" value="Enviar Mensaje" name="send" class="btn">
                            </form>
                        </div>

                        <div class="col-6">
                                <ul class="list-group list-group-flush" >
                                    <li class="">
                                        <i class="fa-brands fa-instagram fa-4x" style="color:#B21A4A;"></i> <label class="lead" style="font-size: 25px">Instagram</label>
                                        <p class="pricing-features-item" style="font-size: 18px">En nuestra página de Instagram podrás encontrar información extra de nuestro negocio.
                                                            Podrás ver los horarios en los que trabajamos y seguirnos para estar pendiente de las promociones que períodicamente creamos.</p>
                                        <a href="https://www.instagram.com" class="pricing-button">Siguenos</a>
                                        <hr>
                                    </li>
                                    <li class="">
                                    <i class="fa-brands fa-whatsapp fa-4x" style="color:green;"></i> <label class="lead" style="font-size: 25px">WhatsApp</label>
                                        <p class="pricing-features-item" style="font-size: 18px">Podrás llamarnos o escribirnos por whatsapp para hacer tu pedido de inmediato. Contamos con delivery y pago contra entrega.</p>
                                        <a href="https://wa.me/message/GCWRBNEEBSIEH1" class="pricing-button">Escríbenos</a>
                                        <hr>
                                    </li>
                                    <li class="">
                                    <i class="fa-brands fa-facebook-square fa-4x" style="color:#1A7DB2;"></i> <label class="lead" style="font-size: 25px">Facebook</label>
                                        <p class="pricing-features-item" style="font-size: 18px">En nuestra página de facebook podrás encontrar información extra de nuestro negocio.
                                                            Podrás ver los horarios en los que trabajamos y seguirnos para estar pendiente de las promociones que períodicamente creamos.</p>
                                        <a href="https://www.facebook.com" class="pricing-button">Siguenos</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <!-- footer -->
            <?php include 'footer.php'; ?>
            <!-- end footer -->

        </div>
    </div>
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