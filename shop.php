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
        $message[] = '¡Ya señadió al carrito!';
    }else{
        $insertOneResult = $cart->insertOne(
            ['user_id' => new MongoDB\BSON\ObjectId($user_id), 'name' => $product_name, 'price' => (int)$product_price,'quantity' => (int)$product_quantity,'image' => $product_image]
        );
    
        $message[] = '¡Producto añadido al carrito!';
    }

};

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'header.php'; ?>

<div class="heading">
    <h3>Nuestro Menú</h3>
    <p> <a href="home.php" style="text-decoration: none;">Inicio</a> / Tienda </p>
</div>

<section class="products">

    <h1 class="title">Platillos Disponibles</h1>

    <div class="box-container">

        <?php
        $select_products1 = $products->find(
        //['name'=>'Conceptos Basicos Php']
        );
        foreach($select_products1 as $fetch_products1)
        {
            ?>
            <form action="" method="post" class="box">
                <img class="image" src="uploaded_img/<?php echo $fetch_products1['image']; ?>" alt="">
                <div class="name"><?php echo $fetch_products1['name']; ?></div>
                <div class="price">$<?php echo $fetch_products1['price']; ?>/-</div>
                <input type="number" min="1" name="product_quantity" value="1" class="qty">
                <input type="hidden" name="product_name" value="<?php echo $fetch_products1['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_products1['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_products1['image']; ?>">
                <input type="submit" value="add to cart" name="add_to_cart" class="btn">
            </form>
            <?php
            //var_dump($fetch_products1['name']);
        }
        echo "<pre>";
        ?>
    </div>

</section>



<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>