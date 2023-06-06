<?php
require 'vendor/autoload.php';
include 'db_connection.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login');
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
    <title>Productos</title>
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

<body>

    <?php include 'header.php'; ?>
    <!-- about -->
    <div class="about">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title">
                        <i class="fa-solid fa-cookie-bite"></i>
                        <h2>Producto</h2>
                        <span>Observa mas de cerca nuestra cocina
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end about -->

    <section class="products">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-7">
                    <?php
                    $dato_id = $_GET['dato'];
                    $name = $products->findOne(
                        array('_id' => new MongoDB\BSON\ObjectId($dato_id))
                    );
                    ?>
                    <img src="uploaded_img/<?php echo $name['image']; ?>" alt="" width="400px" height="400px">
                </div>
                <div class="col-5">
                    <div class="display-1"><?php echo $name['name']; ?></div>
                    <h3>Descripcion</h3>
                    <div class="name"><?php echo $name['Desc']; ?></div>
                    <h3>Precio</h3>
                    <div class="theme_color">$<?php echo $name['price']; ?></div>
                    <form action="" method="post">
                        <div class="">
                            <label for="product_quantity">Ingrese la cantidad deseada</label></br>
                            <input type="number" min="1" name="product_quantity" value="1" class="form-control" style="font-size:25px;">
                            <input type="hidden" name="product_name" value="<?php echo $name['name']; ?>">
                            <input type="hidden" name="product_price" value="<?php echo $name['price']; ?>">
                            <input type="hidden" name="product_image" value="<?php echo $name['image']; ?>">
                            <input type="submit" value="add to cart" name="add_to_cart" class="btn"></br>
                        </div>
                    </form>
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