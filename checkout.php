<?php


require 'vendor/autoload.php';
include 'db_connection.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['order_btn'])) {

    $number = $_POST['number'];
    $placed_on = date('d-M-Y');

    $name1 = $_POST['name'];
    $number1 = $_POST['number'];
    $email1 = $_POST['email'];
    $method1 = $_POST['method'];
    $address1 = 'flat no. ' . $_POST['flat'] . ', ' . $_POST['state'] . ', ' . $_POST['city'];
    $placed_on1 = date('d-M-Y');


    $cart_total = 0;
    $cart_products[] = '';


    $filter = array('user_id' => new MongoDB\BSON\ObjectId($user_id));
    $conteo = $cart->count($filter);
    $i=0;
    if ($conteo > 0) {


        $cart_query1 = $cart->find(array('user_id' => new MongoDB\BSON\ObjectId($user_id)));
        foreach ($cart_query1 as $cart_item1) {

            if ($i>0) {
                $cart_products[] = ','.$cart_item1['name'] . ' • ' . $cart_item1['quantity'];
            }else{
                $cart_products[] = $cart_item1['name'] . ' • ' . $cart_item1['quantity'];
            }
            $sub_total = ($cart_item1['price'] * $cart_item1['quantity']);
            $cart_total += $sub_total;
            $i++;
        }
    }

        $total_products = implode('', $cart_products);


    $filter = array('name' => $name1, 'number' => $number1, 'email' => $email1, 'method' => $method1, 'address' => $address1, 'total_products' => $total_products, 'total_price' => $cart_total);
    $order_query1 = $orders->count($filter);

    if ($cart_total == 0) {
        $message[] = 'Tu carrito de compras está sólo';
    } else {
        if ($order_query1 > 0) {
            $message[] = 'Orden realizada previamente';
        } else {

            // VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
            $insertOneResult = $orders->insertOne(
                ['user_id' => new MongoDB\BSON\ObjectId($user_id), 'name' => $name1, 'number' => $number1, 'email' => $email1, 'method' => $method1, 'address' => $address1, 'total_products' => $total_products, 'total_price' => $cart_total, 'placed_on' => $placed_on, 'payment_status' => 'pending']
            );
            $message[] = 'Orden realizada correctamente';
            $deleteResult = $cart->deleteMany(
                ['user_id' => new MongoDB\BSON\ObjectId($user_id)]
            );
            //header('location:orders.php');
        }
    }
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
    <title>Pago</title>
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
    <div class="about">
        <div class="container">
            <div class="col-md-12">
                <div class="title">
                    <i class="fa-solid fa-bag-shopping"></i>
                    <h2>Procede al Pago de tus pedidos</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
    <div class="row">
        <div class="col-8">
        <form action="" method="post">
            <h3>Realice su pedido</h3>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="lb-datos">Nombre:</label>
                    <input type="text" class="form-control" name="name" required placeholder="Ingresa tu nombre">
                </div>
                <div class="form-group col-md-6">
                    <label class="lb-datos">Celular:</label>
                    <input type="text" class="form-control" name="number" required placeholder="Ingresa tu número">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="lb-datos">Correo Electrónico:</label>
                    <input class="form-control" type="email" name="email" required placeholder="Ingresa tu correo">
                </div>
                <div class="form-group col-md-6">
                    <label class="lb-datos">Método de pago:</label>
                    <select name="method" class="form-control custom-select  alto" style="height:40px ;">
                        <option value="cash on delivery">Contra entrega</option>
                        <option value="credit card">Tarjeta de crédito/débito</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="lb-datos">Departamento:</label>
                    <input class="form-control" type="text" name="state" required placeholder="Departamento">
                </div>
                <div class="form-group col-md-6">
                    <label class="lb-datos">Municipio:</label>
                    <input class="form-control" type="text" name="city" required placeholder="Municipio">
                </div>
            </div>

            <div class="form-group">
                <label class="lb-datos">Dirección:</label>
                <input type="text" class="form-control" name="flat" required placeholder="Ingrese su dirección">
            </div>
            <input type="submit" value="Pedir" class="btn" name="order_btn"><br>
        </form>
        </div>
        <div class="col-4">
        <?php
                    $grand_total = 0;
                    $filter = array('user_id' => new MongoDB\BSON\ObjectId($user_id));
                    $doc = $cart->count($filter);
                    echo "<h2>Cuenta a pagar</h2>";
                    if ($doc > 0) {
                        $cart_query1 = $cart->find(array('user_id' => new MongoDB\BSON\ObjectId($user_id)));
                        foreach ($cart_query1 as $fetch_cart1) {
                            $total_price = ($fetch_cart1['price'] * $fetch_cart1['quantity']);
                            $grand_total += $total_price;
                    ?>
                            <ul class="list-group list-group-flush">
                                <li class=""style="font-size: 15px ;"><?php echo $fetch_cart1['name']; ?> (<?php echo '$' . $fetch_cart1['price'] . ' X ' . $fetch_cart1['quantity']; ?>)</li>
                                <hr style="height:1px;border:none;color:#333;background-color:#333;">
                            </ul>
                    <?php
                        }
                    } else {
                        echo '<p class="empty">Tu carrito de compra esta sólo</p>';
                    }
                    ?>
                <div class="container">
                    <div class="row">
                            <div class="grand-total" style="font-size: 18px ;color:tomato"> Total a pagar: <span>$<?php echo $grand_total; ?></span> </div>
                        </div>
                    </div>    
                </div>
        </div>
    </div>

    </div>

    


    </section>
    <section class=""></section>
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