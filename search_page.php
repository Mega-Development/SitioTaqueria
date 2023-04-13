<?php

require 'vendor/autoload.php';
include 'config1.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
};

if(isset($_POST['add_to_cart'])){

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $filter = array('user_id'=>new MongoDB\BSON\ObjectId($user_id),'name' => $product_name);
    $conteo=$cart->count($filter);

    if($conteo>0){
        $message[] = 'already added to cart!';
    }else{
        $insertOneResult = $cart->insertOne(
            ['user_id' => new MongoDB\BSON\ObjectId($user_id), 'name' => $product_name, 'price' => (int)$product_price,'quantity' => (int)$product_quantity,'image' => $product_image]
        );
        $message[] = 'product added to cart!';
    }

};

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busqueda</title>
    <link rel="icon" href="images/icono.png">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'header.php'; ?>

<div class="heading">
    <h3>search page</h3>
    <p> <a href="home.php">Inicio</a> / Búsqueda </p>
</div>

<section class="search-form">
    <form action="" method="post">
        <input type="text" name="search" placeholder="search products..." class="box">
        <input type="submit" name="submit" value="search" class="btn">
    </form>
</section>

<section class="products" style="padding-top: 0;">

    <div class="box-container">
        <?php
        if(isset($_POST['submit'])){
            $search_item = $_POST['search'];

            $select_products1 = $products->find(
                ['name'=>$search_item]
            );
            foreach($select_products1 as $document){
                ?>
                <form action="" method="post" class="box">
                    <img class="image" src="uploaded_img/<?php echo $document['image']; ?>" alt="">
                    <div class="name"><?php echo $document['name']; ?></div>
                    <div class="price">$<?php echo $document['price']; ?>/-</div>
                    <input type="number"  class="qty" name="product_quantity" min="1" value="1">
                    <input type="hidden" name="product_name" value="<?php echo $document['name']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $document['price']; ?>">
                    <input type="hidden" name="product_image" value="<?php echo $document['image']; ?>">
                    <input type="submit" class="btn" value="add to cart" name="add_to_cart">
                </form>
                <?php
            }

        }else{
            echo '<p class="empty">search something!</p>';
        }
        ?>
    </div>


</section>









<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>