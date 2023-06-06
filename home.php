<?php


require 'vendor/autoload.php';
include 'config1.php';
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
        $message[] = 'already added to cart!';
    } else {
        $insertOneResult = $cart->insertOne(
            ['user_id' => new MongoDB\BSON\ObjectId($user_id), 'name' => $product_name, 'price' => (int)$product_price, 'quantity' => (int)$product_quantity, 'image' => $product_image]
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
    <title>El Rincón del Taco</title>
    <link rel="icon" href="images/icono.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php include 'header.php'; ?>

    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/Banner_Taquería1.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="images/Banner_Taquería2.jpg" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>

    <section class="products">

        <h1 class="title">Últimos productos</h1>

        <div class="box-container">

            <?php
            $select_products1 = $products->find(
                //['name'=>'Conceptos Basicos Php']
            );
            foreach ($select_products1 as $fetch_products1) {
            ?>
                <form action="" method="post" class="box">
                    <img id="img_product" class="image" src="uploaded_img/<?php echo $fetch_products1['image']; ?>" alt="">
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

        <div class="load-more" style="margin-top: 2rem; text-align:center">
            <a href="shop.php" class="option-btn">Ver más</a>
        </div>

    </section>

    <section class="about">

        <div class="flex">

            <div class="image">
                <img src="images/about-img.jpg" alt="">
            </div>

            <div class="content">
                <h3>Acerca de nosotros</h3>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit quos enim minima ipsa dicta officia corporis ratione saepe sed adipisci?</p>
                <a href="about.php" class="btn">Leer más</a>
            </div>

        </div>

    </section>

    <section class="home-contact">

        <div class="content">
            <h3>¿Necesitas ponerte en contacto con nosotros?</h3>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque cumque exercitationem repellendus, amet ullam voluptatibus?</p>
            <a href="contact.php" style="text-decoration: none;" class="white-btn">Contáctanos</a>
        </div>

    </section>

    <?php include 'footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>