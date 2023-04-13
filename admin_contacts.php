<?php


require 'vendor/autoload.php';
include 'config1.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:login.php');
};

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $deleteResult = $mensaje->deleteOne(
        array('_id' => new MongoDB\BSON\ObjectId($delete_id))
    );
    header('location:admin_contacts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>messages</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="messages">

    <h1 class="title"> messages </h1>

    <div class="box-container">
        <?php
        $doc=$mensaje->count();
        if($doc > 0){
            $select_message1 = $mensaje->find(

            );
            foreach($select_message1 as $fetch_message1){

                ?>
                <div class="box">
                    <p> ID de usuario : <span><?php echo $fetch_message1['user_id']; ?></span> </p>
                    <p> Nombre : <span><?php echo $fetch_message1['name']; ?></span> </p>
                    <p> Número : <span><?php echo $fetch_message1['number']; ?></span> </p>
                    <p> Correo : <span><?php echo $fetch_message1['email']; ?></span> </p>
                    <p> Mensaje : <span><?php echo $fetch_message1['message']; ?></span> </p>
                    <a href="admin_contacts.php?delete=<?php echo $fetch_message1['_id']; ?>" onclick="return confirm('delete this message?');" class="delete-btn">Eliminar mensaje</a>
                </div>
                <?php
            };
        }else{
            echo '<p class="empty">you have no messages!</p>';
        }
        ?>
    </div>

</section>









<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>