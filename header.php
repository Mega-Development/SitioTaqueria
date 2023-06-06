<?php

require 'vendor/autoload.php';
include 'config1.php';
if (isset($message)) {
    foreach ($message as $message) {
        echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
    }
}
?>

<header class="header">

    <div class="header-1">
        <div class="flex">
            <div class="share">
                <a href="#" style="text-decoration: none;" class="fab fa-facebook-f"></a>
                <a href="#" style="text-decoration: none;" class="fab fa-twitter"></a>
                <a href="#" style="text-decoration: none;" class="fab fa-instagram"></a>
                <a href="#" style="text-decoration: none;" class="fab fa-linkedin"></a>
            </div>
            <p> <a href="login" style="text-decoration: none;">Acceder</a> | <a href="register" style="text-decoration: none;">Registrarse</a> </p>
        </div>
    </div>

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