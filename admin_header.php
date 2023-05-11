<?php
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/estilos.css">

    <div class="header-2">
        <div class="flex">

            <nav class="navbar">
                <a class="logo" href="admin_page.php"><img src="./images/Logo_Taquería.png" width="125px" alt="#"></a>
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