<?php
session_start();
if(!isset($_SESSION["id"])){
    header("Location: iniciarSesion.php");
}
// Incluir la biblioteca FPDF
require("./fpdf/fpdf.php");
require("./persistencia/conexion.php");
require("./logica/boleta.php");
require("./logica/evento.php");
require("./logica/factura.php");
require("./logica/persona.php");
require("./logica/cliente.php");

$idBoleta = $_GET["idBoleta"];
$idEvento = $_GET["idEvento"];
$idFactura = $_GET["idFactura"];
$idCliente = $_GET["idCliente"];

$boleta = new boleta($idBoleta);
$evento = new evento($idEvento);
$factura = new factura($idFactura);
$cliente = new cliente($idCliente);

$boleta -> consultar();
$evento -> consultar();
$factura -> consultar();
$cliente -> consultar();

$nombreCliente = "".$cliente->getNombre()." ".$cliente->getApellido();
// Crear una nueva instancia de FPDF
$pdf = new FPDF();
$pdf->AddPage();

$pdf->Image("./img/logo_1.jpg",90,10,-500);
$pdf->Ln(40);

// Configurar la fuente y añadir texto
$pdf->SetFont('Arial', 'B', 12);
$pdf->MultiCell(0,10,"Nombre comprador: ".PHP_EOL.$nombreCliente.PHP_EOL. "Fecha de compra: ". $factura->getFechaCompra() .PHP_EOL.PHP_EOL."Usted adquirio "
.$boleta->getCantidad()." boleta(s) para el evento: ".$evento->getNombre().PHP_EOL. "Fecha del evento: ". $evento->getFechaPresentacion().PHP_EOL. "Hora: ". $evento->getHora() .PHP_EOL .PHP_EOL."Valor unitario de la boleta: "
.$boleta->getPrecioUnidad(). " COP".PHP_EOL."Subtotal: ". $factura->getSubtotal() ." COP" .PHP_EOL . "IVA: ". $factura->getIva()
." COP".PHP_EOL. "Total de la compra: ". $factura->getTotal(). " COP" ,0,"L");

// Generar el archivo PDF en el navegador
$pdf->Output();
?>

