<?php

require 'vendor/autoload.php';
include 'config1.php';
session_start();


if(isset($_POST['submit'])){

    $email1 = $users->findOne(
        ['email' => $_POST['email']]
    );

    if (isset($email1["email"])) {

        if ($email1["email"]== $_POST['email']) {
            if ($email1["pass"] == $_POST['password']) {
                if($email1["user_type"] == 'admin'){

                    $_SESSION['admin_name'] = $email1['name'];
                    $_SESSION['admin_email'] = $email1['email'];
                    $_SESSION['admin_id'] = $email1['_id'];
                    header('location:admin_page.php');

                }elseif($email1["user_type"] == 'user'){

                    $_SESSION['user_name'] = $email1['name'];
                    $_SESSION['user_email'] = $email1['email'];
                    $_SESSION['user_id'] = $email1['_id'];
                    header('location:home.php');

                }
            }

        }
    }else{
        $message[] = '¡Email o contraseña incorrecta!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceder</title>
    <link rel="icon" href="images/icono.png">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php
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

<div class="form-container">

    <form action="" method="post">
        <h3>Accede ahora</h3>
        <input type="email" name="email" placeholder="Ingresa tu correo" required class="box">
        <input type="password" name="password" placeholder="Ingresa tu contraseña" required class="box">
        <input type="submit" name="submit" value="login now" class="btn">
        <p>¿Aún no tienes una cuenta? <a href="register.php" style="text-decoration: none;">Regístrate ahora</a></p>
    </form>

</div>

</body>
</html>