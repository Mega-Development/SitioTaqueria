<?php
// Desactivar la caché en el lado del cliente
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

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
            <a href="home" style="text-decoration: none;" class="logo">El Rincón del Taco</a>

            <nav class="navbar">
                <a href="home" style="text-decoration: none;">Inicio</a>
                <a href="about" style="text-decoration: none;">Acerca de</a>
                <a href="shop" style="text-decoration: none;">Menú</a>
                <a href="contact" style="text-decoration: none;">Contáctanos</a>
                <a href="orders" style="text-decoration: none;">Órdenes</a>
            </nav>

            <div class="icons">
                <div id="menu-btn" class="fas fa-bars"></div>
                <a href="search_page" style="text-decoration: none;" class="fas fa-search"></a>
                <div id="user-btn" class="fas fa-user"></div>
                <?php

                $carrito = $cart->find(
                    ['user_id' => new MongoDB\BSON\ObjectId($user_id)]
                );
                $counter = 0;
                foreach ($carrito as $doc) {
                    $counter++;
                }

                ?>
                <a href="cart" style="text-decoration: none;"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $counter; ?>)</span> </a>
            </div>

            <div class="user-box">
                <p>Usuario : <span><?php echo $_SESSION['user_name']; ?></span></p>
                <p>Correo : <span><?php echo $_SESSION['user_email']; ?></span></p>
                <a href="logout" class="delete-btn" style="text-decoration: none;">Salir</a>
            </div>
        </div>
    </div>

</header>