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
         <span>'.$message.'</span>
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

    <div class="flex">

        <a href="admin_page.php" style="text-decoration: none;" class="logo">Administrador<span>Panel</span></a>

        <nav class="navbar">
            <a href="admin_page.php" style="text-decoration: none;">Inicio</a>
            <a href="admin_products.php" style="text-decoration: none;">Menú</a>
            <a href="admin_orders.php" style="text-decoration: none;">Ordenes</a>
            <a href="admin_users.php" style="text-decoration: none;">Usuarios</a>
            <a href="admin_contacts.php" style="text-decoration: none;">Mensajes</a>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>

        <div class="account-box">
            <p>Nombre de usuario: <span><?php echo $_SESSION['admin_name']; ?></span></p>
            <p>Correo: <span><?php echo $_SESSION['admin_email']; ?></span></p>
            <a href="logout.php" style="text-decoration: none;" class="delete-btn">Salir</a>
            <div>Nuevo <a href="login.php" style="text-decoration: none;">Acceder</a> | <a href="register.php" style="text-decoration: none;">Registrarse</a></div>
        </div>

    </div>

</header>