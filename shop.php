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


    <?php include 'header.php'; ?>


    <!-- about -->
    <div class="about">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title">
                        <i class="fa-solid fa-utensils"></i>
                        <h2>Haz tu pedido</h2>
                        <span>Nuestro menú cuenta con más de 25 platillos exquisitos que representan la cultura mexicana.
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- end about -->

    <!-- section tacos-->
    <section class="resip_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="ourheading">
                        <h2>Tacos</h2>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="owl-carousel owl-theme">
                                <?php
                                $select_products1 = $products->find(
                                    //['name'=>'Conceptos Basicos Php']
                                );
                                foreach ($select_products1 as $fetch_products1) {
                                ?>
                                    <?php if ($fetch_products1['type'] == 'Taco') { ?>
                                        <form action="" method="post" class="box">
                                            <a href="producto.php?dato=<?php echo $fetch_products1['_id']; ?>"><img class="product_blog_img" src="uploaded_img/<?php echo $fetch_products1['image']; ?>" alt=""></a>
                                            <div class="product_blog_cont">
                                                <a href="producto.php?dato=<?php echo $fetch_products1['_id']; ?>">
                                                    <h3><?php echo $fetch_products1['name']; ?></h3>
                                                </a>
                                                <div class="theme_color">$<?php echo $fetch_products1['price']; ?></div>
                                                <input type="hidden" min="1" name="product_quantity" value="1" class="qty">
                                                <input type="hidden" name="product_name" value="<?php echo $fetch_products1['name']; ?>">
                                                <input type="hidden" name="product_price" value="<?php echo $fetch_products1['price']; ?>">
                                                <input type="hidden" name="product_image" value="<?php echo $fetch_products1['image']; ?>">
                                                <input type="submit" value="Agregar" name="add_to_cart" class="btn">
                                            </div>
                                        </form>
                                    <?php } else {
                                    } ?>
                                <?php
                                    //var_dump($fetch_products1['name']);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- section burritos-->
    <section class="resip_section_w">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="ourheading_w">
                        <h2>Burritos</h2>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="owl-carousel owl-theme">
                                <?php
                                $select_products1 = $products->find(
                                    //['name'=>'Conceptos Basicos Php']
                                );
                                foreach ($select_products1 as $fetch_products1) {
                                ?>
                                    <?php if ($fetch_products1['type'] == 'Burrito') { ?>
                                        <form action="" method="post" class="box">
                                            <a href="producto.php?dato=<?php echo $fetch_products1['_id']; ?>"><img class="product_blog_img" src="uploaded_img/<?php echo $fetch_products1['image']; ?>" alt=""></a>
                                            <div class="product_blog_cont">
                                                <a href="producto.php?dato=<?php echo $fetch_products1['_id']; ?>">
                                                    <h3 style="color: #000000;"><?php echo $fetch_products1['name']; ?></h3>
                                                </a>
                                                <div class="theme_color">$<?php echo $fetch_products1['price']; ?></div>
                                                <input type="hidden" min="1" name="product_quantity" value="1" class="qty">
                                                <input type="hidden" name="product_name" value="<?php echo $fetch_products1['name']; ?>">
                                                <input type="hidden" name="product_price" value="<?php echo $fetch_products1['price']; ?>">
                                                <input type="hidden" name="product_image" value="<?php echo $fetch_products1['image']; ?>">
                                                <input type="submit" value="Agregar" name="add_to_cart" class="btn">
                                            </div>
                                        </form>
                                    <?php } else {
                                    } ?>
                                <?php
                                    //var_dump($fetch_products1['name']);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- section enchiladas-->
    <section class="resip_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="ourheading">
                        <h2>Enchiladas</h2>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="owl-carousel owl-theme">
                                <?php
                                $select_products1 = $products->find(
                                    //['name'=>'Conceptos Basicos Php']
                                );
                                foreach ($select_products1 as $fetch_products1) {
                                ?>
                                    <?php if ($fetch_products1['type'] == 'Enchilada') { ?>
                                        <form action="" method="post" class="box">
                                            <a href="producto.php?dato=<?php echo $fetch_products1['_id']; ?>"><img class="product_blog_img" src="uploaded_img/<?php echo $fetch_products1['image']; ?>" alt=""></a>
                                            <div class="product_blog_cont">
                                                <a href="producto.php?dato=<?php echo $fetch_products1['_id']; ?>">
                                                    <h3><?php echo $fetch_products1['name']; ?></h3>
                                                </a>
                                                <div class="theme_color">$<?php echo $fetch_products1['price']; ?></div>
                                                <input type="hidden" min="1" name="product_quantity" value="1" class="qty">
                                                <input type="hidden" name="product_name" value="<?php echo $fetch_products1['name']; ?>">
                                                <input type="hidden" name="product_price" value="<?php echo $fetch_products1['price']; ?>">
                                                <input type="hidden" name="product_image" value="<?php echo $fetch_products1['image']; ?>">
                                                <input type="submit" value="Agregar" name="add_to_cart" class="btn">
                                            </div>
                                        </form>
                                    <?php } else {
                                    } ?>
                                <?php
                                    //var_dump($fetch_products1['name']);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- section sopas-->
    <section class="resip_section_w">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="ourheading_w">
                        <h2>Sopas</h2>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="owl-carousel owl-theme">
                                <?php
                                $select_products1 = $products->find(
                                    //['name'=>'Conceptos Basicos Php']
                                );
                                foreach ($select_products1 as $fetch_products1) {
                                ?>
                                    <?php if ($fetch_products1['type'] == 'Sopa') { ?>
                                        <form action="" method="post" class="box">
                                            <a href="producto.php?dato=<?php echo $fetch_products1['_id']; ?>"><img class="product_blog_img" src="uploaded_img/<?php echo $fetch_products1['image']; ?>" alt=""></a>
                                            <div class="product_blog_cont">
                                                <a href="producto.php?dato=<?php echo $fetch_products1['_id']; ?>">
                                                    <h3 style="color: #000000;"><?php echo $fetch_products1['name']; ?></h3>
                                                </a>
                                                <div class="theme_color">$<?php echo $fetch_products1['price']; ?></div>
                                                <input type="hidden" min="1" name="product_quantity" value="1" class="qty">
                                                <input type="hidden" name="product_name" value="<?php echo $fetch_products1['name']; ?>">
                                                <input type="hidden" name="product_price" value="<?php echo $fetch_products1['price']; ?>">
                                                <input type="hidden" name="product_image" value="<?php echo $fetch_products1['image']; ?>">
                                                <input type="submit" value="Agregar" name="add_to_cart" class="btn">
                                            </div>
                                        </form>
                                    <?php } else {
                                    } ?>
                                <?php
                                    //var_dump($fetch_products1['name']);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- section Tortas-->
    <!-- section tacos-->
    <section class="resip_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="ourheading">
                        <h2>Tortas</h2>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="owl-carousel owl-theme">
                                <?php
                                $select_products1 = $products->find(
                                    //['name'=>'Conceptos Basicos Php']
                                );
                                foreach ($select_products1 as $fetch_products1) {
                                ?>
                                    <?php if ($fetch_products1['type'] == 'Torta') { ?>
                                        <form action="" method="post" class="box">
                                            <a href="producto.php?dato=<?php echo $fetch_products1['_id']; ?>"><img class="product_blog_img" src="uploaded_img/<?php echo $fetch_products1['image']; ?>" alt=""></a>
                                            <div class="product_blog_cont">
                                                <a href="producto.php?dato=<?php echo $fetch_products1['_id']; ?>">
                                                    <h3><?php echo $fetch_products1['name']; ?></h3>
                                                </a>
                                                <div class="theme_color">$<?php echo $fetch_products1['price']; ?></div>
                                                <input type="hidden" min="1" name="product_quantity" value="1" class="qty">
                                                <input type="hidden" name="product_name" value="<?php echo $fetch_products1['name']; ?>">
                                                <input type="hidden" name="product_price" value="<?php echo $fetch_products1['price']; ?>">
                                                <input type="hidden" name="product_image" value="<?php echo $fetch_products1['image']; ?>">
                                                <input type="submit" value="Agregar" name="add_to_cart" class="btn">
                                            </div>
                                        </form>
                                    <?php } else {
                                    } ?>
                                <?php
                                    //var_dump($fetch_products1['name']);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- section Quesadillas-->
    <section class="resip_section_w">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="ourheading_w">
                        <h2>Quesadillas</h2>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="owl-carousel owl-theme">
                                <?php
                                $select_products1 = $products->find(
                                    //['name'=>'Conceptos Basicos Php']
                                );
                                foreach ($select_products1 as $fetch_products1) {
                                ?>
                                    <?php if ($fetch_products1['type'] == 'Quesadilla') { ?>
                                        <form action="" method="post" class="box">
                                            <a href="producto.php?dato=<?php echo $fetch_products1['_id']; ?>"><img class="product_blog_img" src="uploaded_img/<?php echo $fetch_products1['image']; ?>" alt=""></a>
                                            <div class="product_blog_cont">
                                                <a href="producto.php?dato=<?php echo $fetch_products1['_id']; ?>">
                                                    <h3 style="color: #000000;"><?php echo $fetch_products1['name']; ?></h3>
                                                </a>
                                                <div class="theme_color">$<?php echo $fetch_products1['price']; ?></div>
                                                <input type="hidden" min="1" name="product_quantity" value="1" class="qty">
                                                <input type="hidden" name="product_name" value="<?php echo $fetch_products1['name']; ?>">
                                                <input type="hidden" name="product_price" value="<?php echo $fetch_products1['price']; ?>">
                                                <input type="hidden" name="product_image" value="<?php echo $fetch_products1['image']; ?>">
                                                <input type="submit" value="Agregar" name="add_to_cart" class="btn">
                                            </div>
                                        </form>
                                    <?php } else {
                                    } ?>
                                <?php
                                    //var_dump($fetch_products1['name']);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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