<?php
require 'vendor/autoload.php';
include 'db_connection.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['add_to_cart'])) {

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $filter = array('user_id' => new MongoDB\BSON\ObjectId($user_id), 'name' => $product_name);
    $conteo = $cart->count($filter);

    if ($conteo > 0) {
        $message[] = 'Ya fue añadido previamente';
    } else {
        $insertOneResult = $cart->insertOne(
            ['user_id' => new MongoDB\BSON\ObjectId($user_id), 'name' => $product_name, 'price' => (int)$product_price, 'quantity' => (int)$product_quantity, 'image' => $product_image]
        );
        $message[] = 'Producto añadido exitosamente al carrito';
    }
};

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
    <title>Inicio</title>
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
        <!-- end loader -->

        <div id="content">
            <!-- header -->
            <?php include 'header.php'; ?>
            <!-- end header -->
            <!-- start slider section -->
            <div class="slider_section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="full">
                                <div id="main_slider" class="carousel vert slide" data-ride="carousel" data-interval="5000">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="slider_cont">
                                                        <h3>El Rincón del Taco<br>te invita a su reapertura</h3>
                                                        <p>Estamos emocionados por hacerte la invitación a nuestra
                                                            reapertura este 13 de novimebre de 2023</p>
                                                        <a class="btn" href="contact.php">Contáctanos</a>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="slider_image full text_align_center">
                                                        <img class="img-responsive" src="images/taco_feliz_2.png" alt="#" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="slider_cont">
                                                        <h3>El Rincón del Taco</h3>
                                                        <p>Somos un restaurante de comida mexicana. Nuestro local
                                                            principal se encuentra en Santa Ana,
                                                            pero contamos con varias sucursales al rededor del país.Será
                                                            un placer atenderte.</p>
                                                        <a class="btn" href="shop.php">Menú</a>
                                                    </div>
                                                </div>
                                                <div class="col-md-7 full text_align_center">
                                                    <div class="slider_image">
                                                        <img class="img-responsive" src="images/taco_feliz_2.png" alt="#" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="carousel-control-prev" href="#main_slider" role="button" data-slide="prev">
                                        <i class="fa fa-angle-up"></i>
                                    </a>
                                    <br><br><br><br><br><br>
                                    <a class="carousel-control-next" href="#main_slider" role="button" data-slide="next">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end slider section -->
            <section class="products">
                <h1 class="title">Últimos productos</h1>
                <div class="box-container">
                    <?php
                    $select_products1 = $products->find(
                        //['name'=>'Conceptos Basicos Php']
                    );

                    foreach (new LimitIterator($select_products1, 0, 3) as $fetch_products1) {

                    ?>
                        <form action="" method="post" class="box">
                            <img class="product_blog_img" src="uploaded_img/<?php echo $fetch_products1['image']; ?>" alt="">
                            <div class="product_blog_cont">
                                <div class="name"><?php echo $fetch_products1['name']; ?></div>
                                <div class="theme_color">$<?php echo $fetch_products1['price']; ?></div>
                                <input type="hidden" min="1" name="product_quantity" value="1" class="qty">
                                <input type="hidden" name="product_name" value="<?php echo $fetch_products1['name']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $fetch_products1['price']; ?>">
                                <input type="hidden" name="product_image" value="<?php echo $fetch_products1['image']; ?>">
                                <input type="submit" value="Agregar al carrito" name="add_to_cart" class="btn" class="main_bt_border">
                            </div>
                        </form>

                    <?php
                        //var_dump($fetch_products1['name']);
                    }

                    ?>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-5">
                        </div>
                        <div class="col-2">
                            <div class="load-more" style="margin-top: 2rem;">
                                <a href="shop.php" class="option-btn">Ver más</a>
                            </div>
                        </div>
                        <div class="col-5">
                        </div>
                    </div>
                </div>

            </section>


            <!-- section -->


            <section class="about">

                <div class="flex">

                    <div class="image">
                        <img src="images/about-img.jpg" alt="">
                    </div>

                    <div class="content">
                        <h3>Acerca de nosotros</h3>
                        <p>Somos una empresa familiar, creamos nuestro restaurante de comida mexicana en el año 1996. Cuando comenzamos en Santa Ana
                            logramos tener dos sucursales por al menos 10 años. En el 2004 comenzamos a proyectarnos al menos 2 sucursales más, y en el 2006 esta meta fue posible.
                        </p>
                        <a href="about.php" class="btn">Leer más</a>
                    </div>

                </div>

            </section>

            <section class="home-contact">

                <div class="content">
                    <h3>¿Necesitas ponerte en contacto con nosotros?</h3>
                    <p>Actualmente contamos con 10 sucursales al rededor del país.</p>
                    <a href="contact.php" class="btn">Contáctanos</a>
                </div>

            </section>

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