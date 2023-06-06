<?php

require 'vendor/autoload.php';
include 'db_connection.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};

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
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Búsqueda</title>
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

<body>
    <!-- loader  -->
    <div class="loader_bg" style="background-color: white;">
        <div class="loader"><img src="images/loader_4.gif" alt="" /></div>
    </div>
    <?php include 'header.php'; ?>

    <div class="about">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="title">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                    <h2>ALGÚN PRODUCTO EN ESPECIFICO?</h2>
                                    <span>El que busca encuentra
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>

    <section class="search-form">
        <form action="" method="post">
            <!-- <label for="email" >Algun producto en especial?</label></br> -->
            <input type="text" name="search" placeholder="Ingrese Producto a buscar" class="nombre-contact">
            <input type="submit" name="submit" value="Buscar" class="btn">
        </form>

    </section>

    <section class="products" style="padding-top: 0;">

        <div class="box-container">
            <?php
            if (isset($_POST['submit'])) {
                $search_item = $_POST['search'];

                $filter = array('name' => $search_item);
                $conteo = $products->count($filter);
                if ($conteo > 0) {
                    $select_products1 = $products->find(
                        ['name' => $search_item]
                    );
                    foreach ($select_products1 as $fetch_products1) {
            ?>
                        <form action="" method="post" class="box">
                            <img class="product_blog_img" src="uploaded_img/<?php echo $fetch_products1['image']; ?>" alt="">
                            <div class="product_blog_cont">
                                <div class="name"><?php echo $fetch_products1['name']; ?></div>
                                <div class="theme_color">$<?php echo $fetch_products1['price']; ?></div>
                                <input type="number" min="1" name="product_quantity" value="1" class="qty">
                                <input type="hidden" name="product_name" value="<?php echo $fetch_products1['name']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $fetch_products1['price']; ?>">
                                <input type="hidden" name="product_image" value="<?php echo $fetch_products1['image']; ?>">
                                <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                            </div>
                        </form>
            <?php
                    }
                } else {
                    echo '<p class="empty">No hemos podido encontrar tu comida preferida</p>';
                    //echo '<i class="fa-solid fa-face-sad-tear fa-3x" style="color: Black"></i>';
                }
            } else {
                echo '<p class="empty">Ups, parece que no hemos encontrado nada</p>';
            }
            ?>
        </div>


    </section>
    </section>
    <br>
    <Br>
    <br>

    <section class="home-contact">

        <div class="content">
            <h3>¿Necesitas ponerte en contacto con nosotros?</h3>
            <p>Actualmente contamos con 10 sucursales al rededor del país.</p>
            <a href="contact.php" class="btn">Contáctanos</a>
        </div>

    </section>


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