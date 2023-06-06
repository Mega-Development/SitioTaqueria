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
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/estilos.css">

    <div class="header-2">
        <div class="flex">

            <nav class="navbar">
                <!-- <a class="logo" href="admin_page.php"><img src="./images/Logo.png" width="125px" alt="#"></a> -->
                <a class="logo" href="home.php"><img src="./images/Logo_Horizontal.png" width="220px"  alt="#" /></a>
                <a href="admin_page.php">Inicio</a>
                <a href="admin_products.php">Menú</a>
                <a href="admin_orders.php">Órdenes</a>
                <a href="admin_users.php">Usuarios</a>
                <a href="admin_contacts.php">Mensajes</a>
            </nav>

            <div class="icons">
                <a href="logout.php" class="fa-solid fa-right-from-bracket"></a>
            </div>
        </div>
    </div>

</header>
</br>
</br>
</br>