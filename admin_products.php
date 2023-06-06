<?php

require 'vendor/autoload.php';
include 'config1.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:login.php');
};

if(isset($_POST['add_product'])){

    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/'.$image;

    $name1 = $_POST['name'];
    $price1 = $_POST['price'];
    $image1 = $_FILES['image']['name'];


    $filter = array('name'=>$name1);
    $doc=$products->count($filter);


    if($doc > 0){
        $message[] = 'El nombre del producto ya existe';
    }else{

        $insertOneResult = $products->insertOne(
            ['name' =>$name1, 'price' => (int)$price1, 'image' => $image1]
        );

        if($insertOneResult){
            if($image_size > 2000000){
                $message[] = 'La imagen es muy pesada';
            }else{
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Producto añadido exitosamente';
            }
        }else{
            $message[] = 'El producto no pudo ser añadido';
        }
    }
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];

    $deleteResult = $products->deleteMany(
        ['_id' => new MongoDB\BSON\ObjectId($delete_id)]
    );
    unlink('uploaded_img/'.$delete_image['image']);
    header('location:admin_products.php');
}

if(isset($_POST['update_product'])){

    $update_p_id = $_POST['update_p_id'];
    $update_name = $_POST['update_name'];
    $update_price = $_POST['update_price'];

    $updateResult = $products->updateMany(
        array('_id' => new MongoDB\BSON\ObjectId($update_p_id)),
        ['$set' => [
            'name' => $update_name,
            'price'=> (int)$update_price
        ]
        ]
    );

    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_folder = 'uploaded_img/'.$update_image;
    $update_old_image = $_POST['update_old_image'];

    if(!empty($update_image)){
        if($update_image_size > 2000000){
            $message[] = 'image file size is too large';
        }else{
            $updateResult = $products->updateOne(
                array('_id' => new MongoDB\BSON\ObjectId($update_p_id)),
                ['$set' => ['image' => $update_image]]
            );
            move_uploaded_file($update_image_tmp_name, $update_folder);
            unlink('uploaded_img/'.$update_old_image);
        }
    }

    header('location:admin_products.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú</title>
    <link rel="icon" href="images/icono.png">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>

<?php include 'admin_header.php'; ?>

<!-- product CRUD section starts  -->

<section class="add-products">

    <h1 class="title">Menú</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <h3>Añadir producto</h3>
        <input type="text" name="name" class="box" placeholder="Ingresa el nombre del producto" required>
        <input type="number" min="0" name="price" class="box" placeholder="Ingresa el precio del producto" required>
        <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
        <input type="submit" value="add product" name="add_product" class="btn">
    </form>

</section>

<!-- product CRUD section ends -->

<!-- show products  -->

<section class="show-products">

    <div class="box-container">

        <?php
        //$filter = array('name'=>$name1);
        $doc=$products->count();
        if($doc > 0){
            $select_products1 = $products->find(
            //Parametros de busqueda
            );
            foreach($select_products1 as $fetch_products1){
                ?>
                <div class="box">
                    <img src="uploaded_img/<?php echo $fetch_products1['image']; ?>" alt="">
                    <div class="name"><?php echo $fetch_products1['name']; ?></div>
                    <div class="price">$<?php echo $fetch_products1['price']; ?>/-</div>
                    <a href="admin_products.php?update=<?php echo $fetch_products1['_id']; ?>" class="option-btn">Actualizar</a>
                    <a href="admin_products.php?delete=<?php echo $fetch_products1['_id']; ?>" class="delete-btn" onclick="return confirm('¿Desea eliminar el producto?');">Eliminar</a>
                </div>
                <?php
            }
        }else{
            echo '<p class="empty">Aún no has añadido ningún producto</p>';
        }
        ?>
    </div>

</section>

<section class="edit-product-form">

    <?php
    if(isset($_GET['update'])){
        $update_id = $_GET['update'];
        $filter2 = array('_id'=>new MongoDB\BSON\ObjectId($update_id));
        $doc2=$products->count($filter2);
        if($doc2> 0){
            $select_products1 = $products->find(
                ['_id'=>new MongoDB\BSON\ObjectId($update_id)]
            );
            foreach($select_products1 as $fetch_update1){
                ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="update_p_id" value="<?php echo $fetch_update1['_id']; ?>">
                    <input type="hidden" name="update_old_image" value="<?php echo $fetch_update1['image']; ?>">
                    <img src="uploaded_img/<?php echo $fetch_update1['image']; ?>" alt="">
                    <input type="text" name="update_name" value="<?php echo $fetch_update1['name']; ?>" class="box" required placeholder="Ingrese el nombre del producto">
                    <input type="number" name="update_price" value="<?php echo $fetch_update1['price']; ?>" min="0" class="box" required placeholder="Ingrese el precio del producto">
                    <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
                    <input type="submit" value="update" name="update_product" class="btn">
                    <input type="reset" value="cancel" id="close-update" class="option-btn">
                </form>
                <?php
            }
        }
    }else{
        echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
    }
    ?>

</section>



<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>