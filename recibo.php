<?php 
    require 'vendor/autoload.php';
    include 'db_connection.php';
    session_start();
    $user_id = $_SESSION['user_id'];

    if (isset($_GET['order'])) {
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
                $codigo[]=$producto['_id'];
                $desc[]=$producto['Desc'];
                $totalizado[]=$producto['price']*(int)$separada[1];
                //var_dump($producto['price']);
            }
            $t_products = implode('', $factura_products);
    
    }else{
        header('location:orden.php');
    }
    
?>

<?php
/// Powered by Evilnapsis go to http://evilnapsis.com
include "fpdf/fpdf.php";

$pdf = new FPDF($orientation='P',$unit='mm');
$pdf->AddPage();
$pdf->SetFont('Arial','B',20);    
$textypos = 5;
$pdf->setY(12);
$pdf->setX(10);
// Agregamos los datos de la empresa
$pdf->Cell(5,$textypos,"Detalles del pedido #");
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','I',14);
$pdf->SetTextColor(24,100,25);
$pdf->Cell(5,$textypos,$orden_id);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',10);    
$pdf->setY(30);$pdf->setX(10);
$pdf->Cell(5,$textypos,"EMPRESA:");
$pdf->SetFont('Arial','',10);    
$pdf->setY(35);$pdf->setX(10);
$pdf->Cell(5,$textypos,"El Rincon del Taco");
$pdf->setY(40);$pdf->setX(10);
$pdf->Cell(5,$textypos,"Colonia IVU 20 Calle Pte");
$pdf->setY(45);$pdf->setX(10);
$pdf->Cell(5,$textypos,"24458997");
$pdf->setY(50);$pdf->setX(10);
$pdf->Cell(5,$textypos,"elrincondeltaco@gmail.com");

// Agregamos los datos del cliente
$pdf->SetFont('Arial','B',10);    
$pdf->setY(30);$pdf->setX(75);
$pdf->Cell(5,$textypos,"CLIENTE:");
$pdf->SetFont('Arial','',10);    
$pdf->setY(35);$pdf->setX(75);
$pdf->Cell(5,$textypos,$document['name']);
$pdf->setY(40);$pdf->setX(75);
$pdf->Cell(5,$textypos,$document['email']);
$pdf->setY(45);$pdf->setX(75);
$pdf->Cell(5,$textypos,$document['number']);
$pdf->setY(50);$pdf->setX(75);
$pdf->Cell(5,$textypos,$document['address']);

// Agregamos los datos del cliente
$pdf->SetFont('Arial','B',10);    
$pdf->setY(30);$pdf->setX(135);
$pdf->Cell(5,$textypos,"FACTURA: ".rand());
$pdf->SetFont('Arial','',10);    
$pdf->setY(35);$pdf->setX(135);
$pdf->Cell(5,$textypos,"Fecha: ".date("d/M/Y"));
$pdf->setY(40);$pdf->setX(135);
$pdf->setY(45);$pdf->setX(135);
$pdf->Cell(5,$textypos,"");
$pdf->setY(50);$pdf->setX(135);
$pdf->Cell(5,$textypos,"");

/// Apartir de aqui empezamos con la tabla de productos
$pdf->setY(60);$pdf->setX(135);
    $pdf->Ln();
/////////////////////////////
//// Array de Cabecera
$header = array("Cod Producto", "Nombre Producto","Cantidad","Precio","Total");
//// Arrar de Productos
for ($i=0; $i <count($nom) ; $i++) { 
    $pc[]= array($codigo[$i], $nom[$i] ,$cant[$i],$sub[$i],0);
    $products = array(
        array($i, $nom[$i] ,$cant[$i],$sub[$i],0),
    );

}


    // Column widths
    $w = array(50, 65, 20, 25, 25);
    // Header
    for($i=0;$i<count($header);$i++)
        $pdf->Cell($w[$i],7,$header[$i],1,0,'C');
    $pdf->Ln();
    // Data
    $total = 0;
    foreach($pc as $row)
    {
        $pdf->Cell($w[0],6,$row[0],1);
        $pdf->Cell($w[1],6,$row[1],1);
        $pdf->Cell($w[2],6,number_format($row[2]),'1',0,'R');
        $pdf->Cell($w[3],6,"$ ".number_format($row[3],2,".",","),'1',0,'R');
        $pdf->Cell($w[4],6,"$ ".number_format($row[3]*$row[2],2,".",","),'1',0,'R');

        $pdf->Ln();
        $total+=$row[3]*$row[2];

    }
/////////////////////////////
//// Apartir de aqui esta la tabla con los subtotales y totales
$yposdinamic = 60 + (count($products)*10);

$pdf->setY($yposdinamic);
$pdf->setX(235);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();

    
/////////////////////////////
$header = array("", "");
$data2 = array(
	array("Subtotal",$total),
	array("Descuento", 0),
	array("Impuesto", 0),
	array("Total", $total),
);
    // Column widths
    $w2 = array(40, 40);
    // Header

    $pdf->Ln();
    // Data
    foreach($data2 as $row)
    {
$pdf->setX(115);
        $pdf->Cell($w2[0],6,$row[0],1);
        $pdf->Cell($w2[1],6,"$ ".number_format($row[1], 2, ".",","),'1',0,'R');

        $pdf->Ln();
    }
/////////////////////////////
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$yposdinamic += (count($data2)*10);
$pdf->SetFont('Arial','B',10);    

$pdf->setY($yposdinamic);
$pdf->setX(10);
$pdf->Cell(5,$textypos,"Muchas gracias por su compra");
$pdf->SetFont('Arial','',10);    

$pdf->setY($yposdinamic+10);
$pdf->setX(10);
$pdf->Cell(5,$textypos,"Comprobante de compra");
$pdf->setY($yposdinamic+20);
$pdf->setX(10);


$pdf->output();