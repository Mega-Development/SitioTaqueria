<?php


require 'vendor/autoload.php';
include 'config1.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
}

if(isset($_POST['send'])){

    $name1 = $_POST['name'];
    $email1 = $_POST['email'];
    $number1 = $_POST['number'];
    $msg1 = $_POST['message'];

    $filter = array('name'=>$name1,'email'=>$email1,'number'=>$number1,'message'=>$msg1);
    $doc=$mensaje->count($filter);

    if($doc> 0){
        $message[] = '¡Se ha enviado el mensaje!';
    }else{
        $insertOneResult = $mensaje->insertOne(
            ['user_id' => new MongoDB\BSON\ObjectId($user_id), 'name' => $name1, 'email' => $email1,'number' => $number1,'message' => $msg1]
        );

        $message[] = '¡El mensaje se envió correctamente!';
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'header.php'; ?>

<div class="heading">
    <h3>Contáctanos</h3>
    <p> <a href="home.php">Inicio</a> / Contáctanos </p>
</div>

<section class="contact">

    <form action="" method="post">
        <h3>¿Tienes algo que decirnos?</h3>
        <input type="text" name="name" required placeholder="Ingresa tu nombre" class="box">
        <input type="email" name="email" required placeholder="Ingresa tu correo" class="box">
        <input type="number" name="number" required placeholder="Ingresa tu teléfono" class="box">
        <textarea name="message" class="box" placeholder="Ingresa tu mensaje" id="" cols="30" rows="10"></textarea>
        <input type="submit" value="send message" name="send" class="btn">
    </form>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>