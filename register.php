<?php
require 'vendor/autoload.php';
include 'config1.php';

if(isset($_POST['submit'])){
    $name1 = $_POST['name'];
    $email1 = $_POST['email'];
    $pass1 = $_POST['password'];
    $cpass1 = $_POST['cpassword'];
    $user_type = $_POST['user_type'];

    $filtro = array('email'=>$email1);
    $doc = $users->count($filtro);

    if($doc> 0){
        $message[] = 'Ya existe un usuario con ese correo!';
    }else{
        if($pass1 != $cpass1){
            $message[] = 'La contraseña no conincide!';
        }else{
            //La contrasena se encripta por medio de la funcion password_hash
            $pass1 = password_hash($pass1, PASSWORD_DEFAULT);
            $cpass1 = password_hash($cpass1, PASSWORD_DEFAULT);

            //Se realiza el insert con la contrasena encriptada
            $insertOneResult = $users->insertOne(
                ['name' => $name1, 'email' => $email1, 'pass' => $pass1,'cpass' => $cpass1,'user_type' => $user_type]
            );
            $message[] = 'Registro Exitoso!';
            header('location:login.php');
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
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
        <h3>Registrate ahora</h3>
        <input type="text" name="name" placeholder="Ingresa tu nombre" required class="box">
        <input type="email" name="email" placeholder="Ingresa tu correo" required class="box">
        <input type="password" name="password" placeholder="Ingresa tu contraseña" required class="box">
        <input type="password" name="cpassword" placeholder="Confrima tu contraseña" required class="box">
        <select name="user_type" class="box">
            <option value="user">Usuario</option>
            <option value="admin">Administrador</option>
        </select>
        <input type="submit" name="submit" value="register now" class="btn">
        <p>¿Ya tienes una cuenta? <a href="login.php">Ingresa Ahora</a></p>
    </form>

</div>

</body>
</html>