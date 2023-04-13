<?php


require 'vendor/autoload.php';
include 'config1.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:login.php');
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $deleteResult = $users->deleteOne(
        array('_id' => new MongoDB\BSON\ObjectId($delete_id))
    );
    header('location:admin_users.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>users</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="users">

    <h1 class="title"> Cuentas de usuarios</h1>

    <div class="box-container">
        <?php
        $select_users1 = $users->find(

        );
        foreach($select_users1 as $fetch_users1){
            ?>
            <div class="box">
                <p> ID de Usuario: <span><?php echo $fetch_users1['_id']; ?></span> </p>
                <p> Nombre de usuario: <span><?php echo $fetch_users1['name']; ?></span> </p>
                <p> Correo : <span><?php echo $fetch_users1['email']; ?></span> </p>
                <p> Tipo de usuario : <span style="color:<?php if($fetch_users1['user_type'] == 'admin'){ echo 'var(--orange)'; } ?>"><?php echo $fetch_users1['user_type']; ?></span> </p>
                <a href="admin_users.php?delete=<?php echo $fetch_users1['_id']; ?>" onclick="return confirm('delete this user?');" class="delete-btn">Eliminar usuario</a>
            </div>
            <?php
        };
        ?>
    </div>

</section>









<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>