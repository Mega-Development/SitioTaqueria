<?php


require 'vendor/autoload.php';
include 'config1.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_POST['update_order'])) {

    $order_update_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];
    $updateResult = $orders->updateOne(
        array('_id' => new MongoDB\BSON\ObjectId($order_update_id)),
        ['$set' => ['payment_status' => $update_payment]]
    );

    $message[] = 'payment status has been updated!';
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $deleteResult = $orders->deleteOne(
        array('_id' => new MongoDB\BSON\ObjectId($delete_id))
    );
    header('location:admin_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>orders</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

    <?php include 'admin_header.php'; ?>

    <section class="orders">

        <h1 class="title">Pedidos realizados</h1>

        <div class="box-container">
            <?php
            $doc = $orders->count();
            if ($doc > 0) {
                $select_orders1 = $orders->find();
                foreach ($select_orders1 as $fetch_orders1) {
            ?>
                    <div class="box">
                        <p> ID de Usuario: <span><?php echo $fetch_orders1['user_id']; ?></span> </p>
                        <p> Pedido a : <span><?php echo $fetch_orders1['placed_on']; ?></span> </p>
                        <p> Nombre de usuario:<span><?php echo $fetch_orders1['name']; ?></span> </p>
                        <p> number : <span><?php echo $fetch_orders1['number']; ?></span> </p>
                        <p> Correo : <span><?php echo $fetch_orders1['email']; ?></span> </p>
                        <p> Dirección : <span><?php echo $fetch_orders1['address']; ?></span> </p>
                        <p> Total de platillos: <span><?php echo $fetch_orders1['total_products']; ?></span> </p>
                        <p> Cuenta total : <span>$<?php echo $fetch_orders1['total_price']; ?>/-</span> </p>
                        <p> Método de pago : <span><?php echo $fetch_orders1['method']; ?></span> </p>
                        <form action="" method="post">
                            <input type="hidden" name="order_id" value="<?php echo $fetch_orders1['_id']; ?>">
                            <select name="update_payment">
                                <option value="" selected disabled><?php echo $fetch_orders1['payment_status']; ?></option>
                                <option value="pending">pending</option>
                                <option value="completed">completed</option>
                            </select>
                            <input type="submit" value="update" name="update_order" class="option-btn">
                            <a href="admin_orders.php?delete=<?php echo $fetch_orders1['_id']; ?>" onclick="return confirm('delete this order?');" class="delete-btn">delete</a>
                        </form>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">no orders placed yet!</p>';
            }
            ?>
        </div>

    </section>










    <!-- custom admin js file link  -->
    <script src="js/admin_script.js"></script>

</body>

</html>