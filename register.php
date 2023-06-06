<?php
require 'vendor/autoload.php';
include 'db_connection.php';

if (isset($_POST['submit'])) {
    $name1 = $_POST['name'];
    $email1 = $_POST['email'];
    $pass1 = $_POST['password'];
    $cpass1 = $_POST['cpassword'];
    $user_type = $_POST['user_type'];
    $filtro = array('email' => $email1);
    $doc = $users->count($filtro);
    if ($doc > 0) {
        $message[] = 'Ya hay un usuario con ese correo!';
    } else {
        if ($pass1 != $cpass1) {
            $message[] = 'La contraseña no coincide!';
        } else {
            $pass1 = password_hash($pass1, PASSWORD_DEFAULT);
            $cpass1 = password_hash($cpass1, PASSWORD_DEFAULT);
            $insertOneResult = $users->insertOne(
                ['name' => $name1, 'email' => $email1, 'pass' => $pass1, 'cpass' => $cpass1, 'user_type' => $user_type]
            );
            $message[] = 'Registro Exitoso!';
            header('location:login.php');
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
    <title>Registro</title>
    <link rel="icon" href="images/icono.png">
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
    <div class="loader_bg" style="margin-top: 100px;">
        <div class="loader"><img src="images/loading.gif" alt="" /></div>
    </div>
    <div class="wrapper">
        <!-- end loader -->
        <div id="content" style="margin-top: -100px;">
            <!-- start slider section -->
            <div class="slider_section" >
                <div class="container">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="slider_cont">
                                <h3>Regístrate</h3>
                                <form action="" method="post">
                                    <p>
                                        <label for="name">Nombre</label></br>
                                        <input type="text" name="name" placeholder="Ingresa tu nombre" class="textbox" style="width : 400px;" /></br>
                                        </br>
                                        <label for="email">Email</label></br>
                                        <input type="email" name="email" placeholder="Ingresa tu correo" required class="textbox" style="width : 400px;" /></br>
                                        </br>
                                        <label for="password">Contraseña</label></br>
                                        <input type="password" name="password" placeholder="Ingresa tu contraseña" required class="textbox" style="width : 400px;" /></br>
                                        </br>
                                        <label for="cpassword">Confirmar contraseña</label></br>
                                        <input type="password" name="cpassword" placeholder="Confirma tu contraseña" required class="textbox" style="width : 400px;" /></br>
                                        </br>
                                        <label for="user_type">Seleccione el tipo de usuario</label></br>
                                        <select name="user_type" class="textbox" style="width : 400px;">
                                            <option value="user">Usuario</option>
                                            <option value="admin">Administrador</option>
                                        </select><br>
                                        <input type="submit" name="submit" value="Registrarse" class="main_bt_border"></br>
                                    </p>
                                    </br>
                                    </br>
                                    <p>¿Ya tienes una cuenta? <a href="login.php">Ingresa Ahora</a></p>
                                    </br>
                                    </br>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6 align-items-center">
                            <div>
                                <img class="img-responsive" src="./images/Logo_Taquería.png" alt="#" style="height: 550px; margin-left: 100px; margin-top: 170px;"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end slider section -->
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