<?php 
    require 'vendor/autoload.php';
    include 'db_connection.php';
    session_start();
    $user_id = $_SESSION['user_id'];

    if (isset($_GET['order'])) {

    
    }else{
        header('location:orden.php');
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
    <title>Detalles</title>
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

    <?php include 'header.php'; ?>
    <!-- about -->
    <div class="about">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title">
                        <i class="fa-solid fa-money-check-dollar"></i>
                        <h2>Ver detalles del pedido</h2>
                        <span>Todas tus órdenes al alcance de un click
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- end about -->

    
    <section class="placed-orders">
        <div class="box-container">
        <?php
            $filter = array('user_id' => new MongoDB\BSON\ObjectId($user_id));
            $doc = $orders->count($filter);
            $orden_id=$_GET['order'];
        
            //? Aqui Conseguiremos la variables de fecha  n°pedido Total Direccion
            $document = $orders->findOne(
                ['_id' => new MongoDB\BSON\ObjectId($orden_id)]
            );
            //? Aqui Conseguiremos la variables de Nombre usuario
            $usuario = $users->findOne(
                ['_id' => new MongoDB\BSON\ObjectId($user_id)]
            );

            $cadena = $document['total_products'];
            $separador = ",";
            $separada = explode($separador, $cadena);
            $enlaze=$separada;
        
            //* Aqui Conseguiremos la variables de Nombre producto y cantidad
            $i=0;
            foreach($enlaze as $doc){
                $cadena = $doc;
                $separador = " • ";
                $separada = explode($separador, $cadena);
                //var_dump($separada);
                //echo "$separada[0]"."</br>";
                $nombre=$separada[0];
                //var_dump((int)$separada[1]);
                //? Aqui Conseguiremos la variables de precio producto
                $producto = $products->findOne(
                    ['name' => $nombre]
                );
                $factura_products[]=$separada[1]." ".$separada[0]." $".$producto['price']."\n";
                $cant[]=$separada[1];
                $nom[]=$separada[0];
                $sub[]=$producto['price'];
                $img[]=$producto['image'];
                $desc[]=$producto['Desc'];
                $totalizado[]=$producto['price']*(int)$separada[1];
                //var_dump($producto['price']);
            }
            $t_products = implode('', $factura_products);


            ?>

            <div class="container">
            <div class="card text-dark bg-light mb-3">
                <div class="card-header">Pedido n.º: <span style="color: green;"><?php echo "".$document['_id'] ?></span></div>
                <div class="card-body" >
                    <h5 class="card-title">Pedido realizado: <span style="color:goldenrod;"><?php echo "".$document['placed_on'] ?></span></h5>
                    <p class="card-text">Dirección de envío: <span style="color:goldenrod;"><?php echo "".$document['address'] ?></span></p>
                </div>
            </div>
            <hr>
                <div class="row align-items-start">
                <div class="col-6 align-self-start">
                    <h6 class="display-3">Total Factura</h6>
                </div>
                <div class="col-3">
                    <h6 class="display-3"><?php echo "$".$document['total_price'] ?></h6>
                </div>
                <div class="col-3">
                <a href="recibo?order=<?php echo $orden_id ?>"><button type="button" class="btn">Imprimir Recibo</button></a>
                </div>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Cant</th>
                            <th scope="col">Nombre Producto</th>
                            <th scope="col">Precio Unidad</th>
                            <th scope="col">Precio total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php                         
                        for ($i=0; $i <count($nom) ; $i++) {

                        ?>
                        <tr>
                            <th scope="row"><?php echo "".$cant[$i] ?></th>
                            <td><?php echo "".$nom[$i] ?></td>
                            <td><?php echo "$".$sub[$i] ?></td>
                            <td><?php echo "$".$cant[$i]*$sub[$i] ?></td>
                        </tr>
                        <?php   
                        }
                        ?>
                    </tbody>
                </table>
                <?php                         
                        for ($i=0; $i <count($nom) ; $i++) {

                        ?>
                <div class="card mb-3" style="max-width: 1200px;">
                    <div class="row g-0">
                        <div class="col-2">
                        <img src="images/<?php echo $img[$i] ?>" class="img-fluid rounded-start" alt="..." width="200px" height="200px">
                        </div>
                        <div class="col-10">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo "".$nom[$i] ?></h5>
                            <p class="card-text"><?php echo "".$desc[$i] ?></p>
                            <a href="shop" style="color:goldenrod">Comprar Nuevamente </a>   
                            
                            <label class="card-text"><small class="text-muted"><span style="color:brown"><?php echo "$".$sub[$i] ?></span></small></label>
                        </div>
                        </div>
                    </div>
                </div>
                <?php  }?>
            </div>
                
            <?php

            ?>
            <!-- <div class="container">

                <div class="row">
                    <div class="col-sm">
                    One of three columns
                    </div>
                    <div class="col-sm">
                    One of three columns
                    </div>
                    <div class="col-sm">
                    One of three columns
                    </div>
                </div>
            </div> -->

    </section>

    <section></section>
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

</html>