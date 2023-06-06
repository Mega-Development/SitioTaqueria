<?php


require 'vendor/autoload.php';
include 'db_connection.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
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
    <title>Acerca de</title>
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

</head>
<!-- body -->

<body class="main-layout">
    <!-- loader  -->
    <!-- <div class="loader_bg">
        <div class="loader"><img src="images/loading.gif" alt="" /></div>
    </div> -->

    <div class="wrapper">
        <!-- end loader -->


        <div id="content">
            <!-- header -->
            <?php include "header.php"; ?>
            <!-- end header -->


            <div class="bg_bg">
                <!-- about -->
                <div class="about">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="title">
                                    <i class="fa-solid fa-circle-info"></i>
                                    <h2>Acerca de nosotros</h2>
                                    <span>Somos una empresa familiar, creamos nuestro restaurante de comida mexicana en
                                        el año 1996. Cuándo comenzamos en Santa Ana logramos tener dos sucursales por al
                                        menos 10 años. En el 2004 comenzamos a proyectarnos al menos 2 sucursales más, y
                                        en el 2006 esta meta fue posible. Actualmente contamos con 10 sucursales al
                                        rededor del país.
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="about_box">
                                    <h3>Nuestra comida</h3>
                                    <p>Las recetas de cada platillo de nuestro menú provienen originalmente de México,
                                        Alejandra Gónzalez, es la madre de Rosa Gónzalez, quién comenzó este proyecto.
                                        Alejandra era originaria de Ciduad de México y toda su vida se dedicó a la
                                        cocina en casa, tenía un pequeño comedor que a toda la gente del pueblo le
                                        encantaba.<br><br>
                                        Cuándo su hija creció, aprendió el arte de la cocina Mexicana, se enamoró de la
                                        cocina cómo su madre.<br><br>
                                        Por diferentes factores tuvieron que emigrar a El Salvador, y es en la ciudad de
                                        Santa Ana que el negocio resurgió, esta vez se convirtió en un negcio familiar
                                        que estamos seguros a la señora Alejandra le enorgullecería mucho, ya que partió
                                        en el año 2010. <br><br>
                                        Al dejar su legado su familia ha continuado con este negocio, y a crecido
                                        exponencialmente. Hoy en día la empresa busca compartir un poco de su historia
                                        culinaria y familiar por medio de nuevos medios cómo su nueva plataforma.</p>
                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-5 col-md-10 col-sm-12 about_img_boxpdnt">
                                <div class="about_img">
                                    <figure><img src="images/familia.jfif"></figure>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end about -->

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