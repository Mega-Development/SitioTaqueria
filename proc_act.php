<?php
require 'vendor/autoload.php';
include 'db_connection.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
};
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    $deleteResult = $products->deleteMany(
        ['_id' => new MongoDB\BSON\ObjectId($delete_id)]
    );
    unlink('uploaded_img/' . $delete_image['image']);
    header('location:admin_products.php');
}

if (isset($_POST['update_product'])) {

    $update_p_id = $_POST['update_p_id'];
    $update_name = $_POST['update_name'];
    $update_price = $_POST['update_price'];
    $update_desc = $_POST['update_desc'];
    $update_type = $_POST['update_type'];

    $updateResult = $products->updateMany(
        array('_id' => new MongoDB\BSON\ObjectId($update_p_id)),
        [
            '$set' => [
                'name' => $update_name,
                'price' => (int)$update_price,
                'Desc' => $update_desc,
                'type' => $update_type
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
    <title>Actualizar</title>
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

<body>

    <?php include 'admin_header.php'; ?>
    <!-- about -->
    <div class="about">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <h2>Actualizador</h2>
                        <span>Actualiza el producto admin
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end about -->

    <section class="products">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-7">
                    <?php
                    $dato_id = $_GET['update'];
                    $name = $products->findOne(
                        array('_id' => new MongoDB\BSON\ObjectId($dato_id))
                    );
                    ?>
                    <img src="uploaded_img/<?php echo $name['image']; ?>" alt="" width="400px" height="400px">
                </div>
                <div class="col-5">
                    <div class="display-1"><?php echo $name['name']; ?></div>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="update_p_id" value="<?php echo $name['_id']; ?>">
                        <input type="hidden" name="update_old_image" value="<?php echo $name['image']; ?>"><br><br>
                        <label for="update_name">Nombre y Precio</label></br>
                        <input class="nombre-prod-update" name="update_name" value="<?php echo $name['name']; ?>" required placeholder="Ingrese un nombre para el producto">
                        <input class="nombre-prod-update" type="number" name="update_price" value="<?php echo $name['price']; ?>" min="0" class="box" required placeholder="Ingrese un precio para el producto"><br><br>
                        <label for="Descripcion">Descripcion del producto</label></br>
                        <textarea type="text" name="update_desc" class="nombre-prod-update" rows="5" cols="50"  required><?php echo $name['Desc']; ?></textarea><br>
                        <label for="update_type">Tipo de producto</label></br>
                        <select name="update_type" class="nombre-prod-update" required>
                            <option hidden selected><?php echo $name['type']; ?></option>    
                            <option value="Taco">Taco</option>
                            <option value="Burrito">Burrito</option>
                            <option value="Enchilada">Enchilada</option>
                            <option value="Torta">Torta</option>
                        </select>
                        <br><br><input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
                        <br><input type="submit" value="Actualizar" name="update_product" class="btn">
                        <input type="reset" value="Cancelar" onclick="window.history.back();" id="close-update" class="btn">
                    </form>
                </div>
            </div>
        </div>
    </section>


    <?php include 'footer.php'; ?>
    <!-- end footer -->

    </div>
    </div>
    <div class="overlay"></div>
    <!-- Javascript files-->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>

    <script src="js/jquery-3.0.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#dismiss, .overlay').on('click', function() {
                $('#sidebar').removeClass('active');
                $('.overlay').removeClass('active');
            });

            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').addClass('active');
                $('.overlay').addClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });
    </script>

    <style>
        #owl-demo .item {
            margin: 3px;
        }

        #owl-demo .item img {
            display: block;
            width: 100%;
            height: auto;
        }
    </style>


    <script>
        $(document).ready(function() {
            var owl = $('.owl-carousel');
            owl.owlCarousel({
                margin: 10,
                nav: true,
                loop: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 5
                    }
                }
            })
        })
    </script>

</body>

</html>