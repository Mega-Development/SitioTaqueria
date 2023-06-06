<?php
require 'vendor/autoload.php';
include 'db_connection.php';
if (isset($message)) {
    foreach ($message as $message) {
        echo '
            <div class="message">
                <span>' . $message . '</span>
                <a class="btn" href="cart.php">Ver Carrito</a>
                <i class="fa-solid fa-circle-check"></i>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
        ';
    }
}
?>

<header class="header">
    <!-- Caché -->
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
    
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/estilos.css">

    <div class="header-2">
        <div class="flex">

            <nav class="navbar">
                <a class="logo" href="home.php"><img src="./images/Logo_Taquería.png" width="125px" alt="#" /></a>
                <a href="home.php">Inicio</a>
                <a href="about.php">Acerca de</a>
                <a href="shop.php">Menú</a>
                <a href="contact.php">Contactános</a>
                <a href="orders.php">Órdenes</a>
            </nav>

            <div class="icons">
                <div id="menu-btn" class="fas fa-bars"></div>
                <a href="search_page.php" class="fas fa-search"></a>
                <a href="logout.php" class="fa-solid fa-right-from-bracket"></a>
                <?php

                $carrito = $cart->find(
                    ['user_id' => new MongoDB\BSON\ObjectId($user_id)]
                );
                $counter = 0;
                foreach ($carrito as $doc) {
                    $counter++;
                }

                ?>
                <a href="cart.php"> <i class="fa-solid fa-cart-plus"></i> <span>(<?php echo $counter; ?>)</span> </a>
            </div>
            <div class="user-box">
                <p>username : <span><?php echo $_SESSION['user_name']; ?></span></p>
                <p>email : <span><?php echo $_SESSION['user_email']; ?></span></p>
                <a href="logout.php" class="delete-btn">Salir</a>
            </div>
        </div>
    </div>

</header>