<?php

require 'vendor/autoload.php';
include 'db_connection.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
};

if (isset($_POST['add_product'])) {

    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;

    $name1 = $_POST['name'];
    $price1 = $_POST['price'];
    $image1 = $_FILES['image']['name'];
    $Desc = $_POST['Desc'];
    $type = $_POST['type'];


    $filter = array('name' => $name1);
    $doc = $products->count($filter);


    if ($doc > 0) {
        $message[] = 'El nombre del producto ya ha sido ingresado';
    } else {


        $insertOneResult = $products->insertOne(
            ['name' => $name1, 'price' => (int)$price1, 'Desc' => $Desc, 'type' => $type, 'image' => $image1]
        );

        if ($insertOneResult) {
            if ($image_size > 2000000) {
                $message[] = 'La imagen es muy grande';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Producto añadido exitosamente';
            }
        } else {
            $message[] = 'El producto no pudo ser añadido';
        }
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    $dato = $products->findOne(
        ['_id' => new MongoDB\BSON\ObjectId($delete_id)]
    );
    var_dump($dato['image']);
    unlink('uploaded_img/' . $dato['image']);

    $deleteResult = $products->deleteMany(
        ['_id' => new MongoDB\BSON\ObjectId($delete_id)]
    );
    header('location:admin_products.php');
}

if (isset($_POST['update_product'])) {

    $update_p_id = $_POST['update_p_id'];
    $update_name = $_POST['update_name'];
    $update_price = $_POST['update_price'];

    $updateResult = $products->updateMany(
        array('_id' => new MongoDB\BSON\ObjectId($update_p_id)),
        [
            '$set' => [
                'name' => $update_name,
                'price' => (int)$update_price
            ]
        ]
    );

    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_folder = 'uploaded_img/' . $update_image;
    $update_old_image = $_POST['update_old_image'];

    if (!empty($update_image)) {
        if ($update_image_size > 2000000) {
            $message[] = 'image file size is too large';
        } else {
            $updateResult = $products->updateOne(
                array('_id' => new MongoDB\BSON\ObjectId($update_p_id)),
                ['$set' => ['image' => $update_image]]
            );
            move_uploaded_file($update_image_tmp_name, $update_folder);
            unlink('uploaded_img/' . $update_old_image);
        }
    }

    header('location:admin_products.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>El taco feliz</title>
    <link rel="icon" href="images/icono.png">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- owl css -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <!-- style css -->

    <link rel="stylesheet" href="css/estyle.css">
    <link rel="stylesheet" href="css/estilos.css">
    <!-- responsive-->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- awesome fontfamily -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>

<body>

    <?php include 'admin_header.php'; ?>

    <!-- product CRUD section starts  -->
    <!-- about -->
    <div class="about">
        <div class="container">
            <div class="title">
                <i class="fa-solid fa-drumstick-bite"></i>
                <h2>Menú de administradores</h2>
            </div>
        </div>
    </div>
    <!-- end about -->

    <div class="container">
        <div class="row">
            <div class="col">
                <section class="add-products">
                    <form action="" method="post" enctype="multipart/form-data">
                        <h2>Añadir producto</h2><br>
                        <label class="nombre_prod" for="name">Nombre de Producto</label></br>
                        <input type="text" name="name" class="form-control" placeholder="Ingresa el nombre del producto" required>
                        <label for="price">Precio de producto</label></br>
                        <input type="number" min="0" name="price" class="form-control" placeholder="Ingresa el precio del producto" required>
                        <label for="Descripcion">Descripción del producto</label></br>
                        <textarea type="text" name="Desc" class="form-control" rows="4" cols="50" placeholder="Ingresa la descripcion" required></textarea>
                        <label for="type">Ingrese tipo de la comida</label></br>
                        <select name="type" required>
                            <option hidden selected>Selecciona el tipo</option>
                            <option value="Taco">Taco</option>
                            <option value="Burrito">Burrito</option>
                            <option value="Enchilada">Enchilada</option>
                            <option value="Torta">Torta</option>
                            <option value="Sopa">Sopa</option>
                            <option value="Quesadilla">Quesadilla</option>
                        </select></br>
                        <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required></br>
                        <input type="submit" value="Añadir al menú" name="add_product" class="btn">
                    </form>
                </section>
            </div>
        </div>
    </div>
    <br><br><br><br>

    <!-- show products  -->
    <div class="container">
        <div class="row">
            <div class="col">
                <section class="show-products">
                    <div class="box-container">
                        <div class="row">

                            <?php
                            //$filter = array('name'=>$name1);
                            $doc = $products->count();
                            if ($doc > 0) {
                                $select_products1 = $products->find(
                                    //Parametros de busqueda
                                );
                                foreach ($select_products1 as $fetch_products1) {
                            ?>
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h1 class="nombre-products"> <?php echo $fetch_products1['name']; ?> </h1>
                                            </div>
                                            <div class="card-body">
                                                <h3 class="card-title"> <img class="img-menu" src="uploaded_img/<?php echo $fetch_products1['image']; ?>" alt=""> </h3>
                                                <h2 class="card-title centrado"> $<?php echo $fetch_products1['price']; ?> </h2>
                                                <a href="proc_act.php?update=<?php echo $fetch_products1['_id']; ?>" class="option-btn btn-centrado">Editar</a>
                                                <a href="admin_products.php?delete=<?php echo $fetch_products1['_id']; ?>" class="delete-btn btn-centrado" onclick="return confirm('¿Desea eliminar el producto?');">Eliminar</a>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            } else {
                                echo '<p class="empty">Aún no has añadido ningún producto</p>';
                            }
                            ?>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- custom admin js file link  -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.13/dist/sweetalert2.all.min.js"></script>

</body>

</html>