<?php
require 'vendor/autoload.php';
include 'db_connection.php';
session_start();

if (isset($_POST['submit'])) {
    if (isset($_POST['submit'])) {

        $email1 = $users->findOne(
            ['email' => $_POST['email']]
        );

        if (isset($email1["email"])) {

            if ($email1["email"] == $_POST['email']) {
                var_dump(password_verify($_POST['password'], $email1["pass"]));
                if (password_verify($_POST['password'], $email1["pass"])) {
                    if ($email1["user_type"] == 'admin') {

                        $_SESSION['admin_name'] = $email1['name'];
                        $_SESSION['admin_email'] = $email1['email'];
                        $_SESSION['admin_id'] = $email1['_id'];
                        header('location:admin_page.php');
                    } elseif ($email1["user_type"] == 'user') {

                        $_SESSION['user_name'] = $email1['name'];
                        $_SESSION['user_email'] = $email1['email'];
                        $_SESSION['user_id'] = $email1['_id'];
                        header('location:home.php');
                    }
                }
            }
        } else {
            $message[] = '¡Email o contraseña incorrecta!';
        }
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
    <title>Inicio de Sesión</title>
    <link rel="icon" href="./images/favicon.png">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- owl css -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- style css -->
    <link rel="stylesheet" href="css/cuadros.css">
    <!-- responsive-->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- awesome fontfamily -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<!-- body -->

<body class="main-layout">

    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
        <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
        }
    }
    ?>
    <!-- loader  -->
    <div class="loader_bg">
        <div class="loader"><img src="images/loader_2.gif" alt="" /></div>
    </div>

    <div class="wrapper">
        <!-- end loader -->

        <div id="content">
            <!-- header -->

            <!-- end header -->
            <!-- start slider section -->
            <div class="slider_section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="full">
                                <div id="main_slider" class="carousel vert slide" data-ride="carousel" data-interval="5000">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="slider_cont">
                                                <h3>Inicia sesión</h3>
                                                <form action="" method="post">
                                                    <p>
                                                        <label for="email">Ingresa tu email</label></br>
                                                        <input type="email" name="email" placeholder="Ingrese su correo" required class="textbox" style="width : 400px;" /></br>
                                                        <label for="password">Ingresa tu contraseña</label></br>
                                                        <input type="password" name="password" placeholder="Ingrese su contraseña" required class="textbox" style="width : 400px;" /></br>
                                                        <br>
                                                        <input type="submit" name="submit" value="Acceder" class="main_bt_border"><br>
                                                    </p>
                                                    <br><br>
                                                    <p>¿Aún no tienes una cuenta? <a href="register.php" style="color: orange;">Regístrate ahora</a></p>
                                                </form>
                                                <br><br><br><br><br><br> <br><br>

                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="slider_image full text_align_center">
                                            <img class="img-responsive" src="./images/Logo.png" alt="#" style="height: 550px; margin-left: 100px;"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end slider section -->

            <div class="bg_bg">
                <!-- about -->

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