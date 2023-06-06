<?php

require 'vendor/autoload.php';
include 'db_connection.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

if (isset($_POST['update_cart'])) {
   $cart_id = $_POST['cart_id'];
   $cart_quantity = (int)$_POST['cart_quantity'];
   var_dump($cart_quantity);
   $updateResult = $cart->updateOne(
      array('_id' => new MongoDB\BSON\ObjectId($cart_id)),
      ['$set' => ['quantity' => $cart_quantity]]
   );

   $message[] = "Actualizado con éxito";
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   var_dump($delete_id);
   $deleteResult = $cart->deleteOne(
      array('_id' => new MongoDB\BSON\ObjectId($delete_id))
   );

   header('location:cart.php');
}

if (isset($_GET['delete_all'])) {
   var_dump($user_id);
   $deleteResult = $cart->deleteMany(
      ['user_id' => new MongoDB\BSON\ObjectId($user_id)]
   );
   $message[] = printf("Deleted %d documents", $deleteResult->getDeletedCount());
   header('location:cart.php');
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
   <title>Carrito</title>
   <link rel="icon" href="./images/favicon.png">
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
   <!-- loader  -->
   <div class="loader_bg" style="background-color: white;">
      <div class="loader"><img src="images/loader_4.gif" alt="" /></div>
   </div>

   <?php include 'header.php'; ?>
   <!-- about -->
   <div class="about">
      <div class="container">
         <div class="row">
            <div class="col-md-12">
               <div class="title">
                  <i class="fa-solid fa-cart-shopping"></i>
                  <h2>Carrito de compra</h2>
                  <span>Productos añadidos
                  </span>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- end about -->


   <section class="products">
      <div class="box-container">
         <?php
         $grand_total = 0;

         $select_cart1 = $cart->find(
            ['user_id' => new MongoDB\BSON\ObjectId($user_id)]
         );
         if (!empty($select_cart1)) {
            foreach ($select_cart1 as $fetch_cart1) {
         ?>
               <div class="box">
                  <a href="cart.php?delete=<?php echo $fetch_cart1['_id']; ?>" class="fa-solid fa-trash fa-2x" style="color: Red;" onclick="return confirm('¿Desea eliminarlo?');"></a>
                  <img src="uploaded_img/<?php echo $fetch_cart1['image']; ?>" alt="">
                  <div class="name"><?php echo $fetch_cart1['name']; ?></div>
                  <div class="theme_color">$<?php echo $fetch_cart1['price']; ?></div>
                  <form action="" method="post">
                     <input type="hidden" name="cart_id" value="<?php echo $fetch_cart1['_id']; ?>">
                     <input class="qty" type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart1['quantity']; ?>">
                     <input type="submit" name="update_cart" value="Actualizar" class="option-btn-center">
                  </form>
                  <div class="sub-total"> Sub total : <span>$<?php echo $sub_total = ($fetch_cart1['quantity'] * $fetch_cart1['price']); ?>/-</span> </div>
               </div>
         <?php
               $grand_total += $sub_total;
            }
         } else {
            echo '<p class="empty">Su carrito está vacío</p>';
         }
         ?>

      </div>

      <div style="margin-top: 2rem; text-align:center;">
         <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>" onclick="return confirm('¿Desea eliminarlo?');">Eliminar todo</a>
         </br>
         </br>
         <h2>Total: <span>$<?php echo $grand_total; ?></span></h2>
      </div>

      <div class="cart-total" style="margin-top: 2rem; text-align:center;">
         <div class="flex">
            <a href="shop.php" style="margin-left: 0;" class="option-btn">Continuar comprando</a></br>
            <a href="checkout.php" class="btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>">Procesar pago</a></br>
         </div>
      </div>

   </section>


   <!-- footer -->
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/Eliminar.js"></script>

</html>