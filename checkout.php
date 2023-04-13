<?php


require 'vendor/autoload.php';
include 'config1.php';

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
    $address1 = 'flat no. ' . $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . ' - ' . $_POST['pin_code'];
    $placed_on1 = date('d-M-Y');


    $cart_total = 0;
    $cart_products[] = '';


    $filter = array('user_id' => new MongoDB\BSON\ObjectId($user_id));
    $conteo = $cart->count($filter);

    if ($conteo > 0) {


        $cart_query1 = $cart->find(array('user_id' => new MongoDB\BSON\ObjectId($user_id)));
        foreach ($cart_query1 as $cart_item1) {
            $cart_products[] = $cart_item1['name'] . ' (' . $cart_item1['quantity'] . ') ';
            $sub_total = ($cart_item1['price'] * $cart_item1['quantity']);
            $cart_total += $sub_total;
        }
    }

    $total_products = implode(', ', $cart_products);


    $filter = array('name' => $name1, 'number' => $number1, 'email' => $email1, 'method' => $method1, 'address' => $address1, 'total_products' => $total_products, 'total_price' => $cart_total);
    $order_query1 = $orders->count($filter);

    if ($cart_total == 0) {
        $message[] = 'your cart is empty';
    } else {
        if ($order_query1 > 0) {
            $message[] = 'order already placed!';
        } else {
            
            // VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
            $insertOneResult = $orders->insertOne(
                ['user_id' => new MongoDB\BSON\ObjectId($user_id), 'name' => $name1, 'number' => $number1, 'email' => $email, 'method' => $method1, 'address' => $address1, 'total_products' => $total_products, 'total_price' => $cart_total, 'placed_on' => $placed_on, 'payment_status' => 'pending']
            );
            $message[] = 'order placed successfully!';
            $deleteResult = $cart->deleteMany(
                ['user_id' => new MongoDB\BSON\ObjectId($user_id)]
            );
            header('location:orders.php');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>checkout</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php include 'header.php'; ?>

    <div class="heading">
        <h3>Proceso de compra</h3>
        <p> <a href="home.php">Inicio</a> / Compra </p>
    </div>

    <section class="display-order">

        <?php
        $grand_total = 0;
    
        $filter = array('user_id' => new MongoDB\BSON\ObjectId($user_id));
        $doc = $cart->count($filter);

        if ($doc > 0) {

            $cart_query1 = $cart->find(array('user_id' => new MongoDB\BSON\ObjectId($user_id)));
            foreach ($cart_query1 as $fetch_cart1) {
                $total_price = ($fetch_cart1['price'] * $fetch_cart1['quantity']);
                $grand_total += $total_price;
        ?>
                <p> <?php echo $fetch_cart1['name']; ?> <span>(<?php echo '$' . $fetch_cart1['price'] . '/-' . ' x ' . $fetch_cart1['quantity']; ?>)</span> </p>
        <?php
            }
        } else {
            echo '<p class="empty">your cart is empty</p>';
        }
        ?>
        <div class="grand-total"> grand total : <span>$<?php echo $grand_total; ?>/-</span> </div>

    </section>

    <section class="checkout">

        <form action="" method="post">
            <h3>Realice su pedido</h3>
            <div class="flex">
                <div class="inputBox">
                    <span>Nombre:</span>
                    <input type="text" name="name" required placeholder="Ingresa tu nombre">
                </div>
                <div class="inputBox">
                    <span>your number :</span>
                    <input type="number" name="number" required placeholder="Ingresa tu número">
                </div>
                <div class="inputBox">
                    <span>your email :</span>
                    <input type="email" name="email" required placeholder="Ingresa tu correo">
                </div>
                <div class="inputBox">
                    <span>Método de pago:</span>
                    <select name="method">
                        <option value="cash on delivery">Contra entrega</option>
                        <option value="credit card">Tarjeta de crédito/débito</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>Dirección :</span>
                    <input type="number" min="0" name="flat" required placeholder="e.g. flat no.">
                </div>
                <div class="inputBox">
                    <span>Departamento :</span>
                    <input type="text" name="state" required placeholder="e.g. maharashtra">
                </div>
                <div class="inputBox">
                    <span>Municipio :</span>
                    <input type="text" name="city" required placeholder="e.g. mumbai">
                </div>
            </div>
            <input type="submit" value="order now" class="btn" name="order_btn">
        </form>

    </section>



    <?php include 'footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>