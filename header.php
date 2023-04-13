<?php

require 'vendor/autoload.php';
include 'config1.php';
if(isset($message)){
    foreach($message as $message){
        echo '
      <div class="message">
         <span>'.$message.'</span>
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
                <a href="#" class="fab fa-facebook-f"></a>
                <a href="#" class="fab fa-twitter"></a>
                <a href="#" class="fab fa-instagram"></a>
                <a href="#" class="fab fa-linkedin"></a>
            </div>
            <p>  <a href="login.php">Acceder</a> | <a href="register.php">Registrarse</a> </p>
        </div>
    </div>

    <div class="header-2">
        <div class="flex">
            <a href="home.php" class="logo">El taco Feliz</a>

            <nav class="navbar">
                <a href="home.php">Inicio</a>
                <a href="about.php">Acerca</a>
                <a href="shop.php">Tienda</a>
                <a href="contact.php">Contactanos</a>
                <a href="orders.php">Ordenes</a>
            </nav>

            <div class="icons">
                <div id="menu-btn" class="fas fa-bars"></div>
                <a href="search_page.php" class="fas fa-search"></a>
                <div id="user-btn" class="fas fa-user"></div>
                <?php

                $carrito = $cart->find(
                    ['user_id' => new MongoDB\BSON\ObjectId($user_id)]
                );
                $counter=0;
                foreach($carrito as $doc)
                {
                    $counter++;
                }

                ?>
                <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $counter; ?>)</span> </a>
            </div>

            <div class="user-box">
                <p>username : <span><?php echo $_SESSION['user_name']; ?></span></p>
                <p>email : <span><?php echo $_SESSION['user_email']; ?></span></p>
                <a href="logout.php" class="delete-btn">Salir</a>
            </div>
        </div>
    </div>

</header>