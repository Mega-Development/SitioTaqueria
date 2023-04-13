<?php


require 'vendor/autoload.php';
include 'config1.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
}

if(isset($_POST['update_cart'])){
    $cart_id = $_POST['cart_id'];
    $cart_quantity = (int)$_POST['cart_quantity'];
    $updateResult = $cart->updateOne(
        array('_id' => new MongoDB\BSON\ObjectId($cart_id)),
        ['$set' => ['quantity' => (int)$cart_quantity]]
    );

    $message[] = "actulizado con exito";
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    var_dump($delete_id);
    $deleteResult = $cart->deleteOne(
        array('_id' => new MongoDB\BSON\ObjectId($delete_id))
    );

    header('location:cart.php');
}

if(isset($_GET['delete_all'])){
    var_dump($user_id);
    $deleteResult = $cart->deleteMany(
        ['user_id' => new MongoDB\BSON\ObjectId($user_id)]
    );
    $message[] =printf("Deleted %d documents", $deleteResult->getDeletedCount());
    header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="icon" href="images/icono.png">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'header.php'; ?>

<div class="heading">
    <h3>Carrito de compra</h3>
    <p> <a href="home.php">Inicio</a> / Carrito </p>
</div>

<section class="shopping-cart">

    <h1 class="title">Productos añadidos</h1>

    <div class="box-container">
        <?php
        $grand_total = 0;

        $select_cart1 = $cart->find(
            ['user_id'=>new MongoDB\BSON\ObjectId($user_id)]
        );
        if(!empty($select_cart1)){
            foreach($select_cart1 as $fetch_cart1){
                ?>
                <div class="box">
                    <a href="cart.php?delete=<?php echo $fetch_cart1['_id']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
                    <img src="uploaded_img/<?php echo $fetch_cart1['image']; ?>" alt="">
                    <div class="name"><?php echo $fetch_cart1['name']; ?></div>
                    <div class="price">$<?php echo $fetch_cart1['price']; ?>/-</div>
                    <form action="" method="post">
                        <input type="hidden" name="cart_id" value="<?php echo $fetch_cart1['_id']; ?>">
                        <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart1['quantity']; ?>">
                        <input type="submit" name="update_cart" value="update" class="option-btn">
                    </form>
                    <div class="sub-total"> sub total : <span>$<?php echo $sub_total = ($fetch_cart1['quantity'] * $fetch_cart1['price']); ?>/-</span> </div>
                </div>
                <?php
                $grand_total += $sub_total;
            }
        }else{
            echo '<p class="empty">your cart is empty</p>';
        }
        ?>
    </div>

    <div style="margin-top: 2rem; text-align:center;">
        <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('delete all from cart?');">delete all</a>
    </div>

    <div class="cart-total">
        <p>Total : <span>$<?php echo $grand_total; ?>/-</span></p>
        <div class="flex">
            <a href="shop.php" class="option-btn">Continuar comprando</a>
            <a href="checkout.php" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">Procesar el pago</a>
        </div>
    </div>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>