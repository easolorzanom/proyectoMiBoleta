<?php
session_start();
if(!isset($_SESSION["id"])){
    header("Location: iniciarSesion.php");
}
if(isset($_GET["idEvento"])){
    $eventoId = $_GET["idEvento"];
}
require ("logica/evento.php");
require ("logica/boleta.php");
require ("logica/factura.php");
require ("logica/persona.php");
require ("logica/cliente.php");
require ("./imgEvento.php");
$clienteId = $_SESSION["id"];
//$eventoId = $_SESSION["eventoId"];
$evento = new evento($eventoId);
$evento -> consultar();
$cliente = new cliente($clienteId);
$cliente -> consultar();

if(isset($_POST["volver"])){
    header("Location: index.php");
}
?>

<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php
        if (!isset($_SESSION["id"])) {
			echo '<meta http-equiv="refresh" content="0; url=iniciarSesion.php">';
			exit();
		}else{

        }
    ?>
    

</head>
<body class="bg-secondary" style="--bs-bg-opacity: .3;">
    <div class="container">
        <div class="p-3 mb-3">
            <div class="container sm-3">
                <?php include ("encabezado.php");?>
            </div>
            

            <div class="container text-center mt-5 bg-light rounded-4">
                <div class="row">
                    <div class="col-5 mt-1">
                        <!--foto del evento-->
                        <?php
                            echo buscarImagen($eventoId);                  
                        ?>
                    </div>
                    <div class="col-7">
                        <!--informacion del evento-->
                        <?php
                            echo "<h2>".$evento -> getNombre() . "<br><br></h2>";
                            echo "<h4>Artista: ".$evento -> getArtista(). "<br></h4>";
                            echo "<h4>Fecha de presentación: ".$evento -> getFechaPresentacion(). "<br></h4>";
                            echo "<h4>Lugar: ".$evento -> getLugar(). "<br></h4>";
                            echo "<h4>Hora: ".$evento -> getHora(). "<br></h4>";
                            echo "<h4>Fecha de venta desde: ".$evento -> getFechaInicioCompra(). " hasta ".$evento -> getFechaFinCompra(). "<br><br></h4>";
                        ?>
                        <form method="post" action="compraBoleta.php">
                            <button type="submit" name="volver" class="btn btn-secondary">Volver al inicio</button>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Comprar Boleta</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
                

            ?>  
        </div>
    </div>

    <!--modal-->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Compra tus boletas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <div class="modal-body">
                    <form method="post" action="compraBoleta.php?idEvento= <?php echo $eventoId ?>">
                        <?php echo "<h6>¿Cuantas boletas deseas comprar ". $cliente->getNombre()."?</h6>";?>
                        <div id="emailHelp" class="form-text">Por nuestras politicas, el maximo de boletas que puede comprar un usuario es 10.</div><br>
                        <label for="customRange2" class="form-label">Cantidad de boletas: </label>
                        <input type="range" class="form-range" min="1" max="10" id="cantidad" name="cantidad" value="1" oninput="mostrarValor(this.value)">
                        <div class="container text-center ">
                            <h4>
                                <span id="valorRango">1</span>
                            </h4>
                            <label for="resultado">Precio Total:</label>
                            <span id="precioTotal"> <?php echo $evento->getPrecioBoleta() ?> COP</span>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary" name="comprar">Comprar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </form>
                </div>                
            </div>
        </div>
    </div>
    
    <?php 
    if(isset($_POST["comprar"])){
        $fechaActual = date("Y-m-d");
        $total = $evento->getPrecioBoleta()*$_POST["cantidad"];
        $iva = ($total*19)/100;
        $subtotal = $total-$iva;
        $factura = new factura(0,$fechaActual,$subtotal,$iva,$total,$cliente->getIdPersona());
        $facturas = $factura->consultarFacturas();
        $nuevoIdFactura = count($facturas)+1;
        $factura->setIdFactura($nuevoIdFactura);
        $factura->crearFactura();
        $boleta = new boleta(0,$_POST["cantidad"],$evento->getPrecioBoleta(),$total,$evento->getIdEvento(),$factura->getIdFactura(),$cliente->getIdPersona());
        $boletas = $boleta->consultarBoletas();
        $nuevoIdBoleta = count($boletas)+1;
        $boleta->setIdBoleta($nuevoIdBoleta);
        $boleta->crearBoleta();
        /*echo "id boleta ".$boleta->getIdBoleta()."<br>";
        echo "cant ".$boleta->getCantidad()."<br>";
        echo "prec total ".$boleta->getPrecioTotal()."<br>";
        echo "prec und ".$boleta->getPrecioUnidad()."<br>";
        echo "id evento ".$boleta->getIdEvento()."<br>";
        echo "id Factura ".$boleta->getIdBoleta()."<br>";
        echo "id cliente ".$boleta->getIdCliente()."<br>";*/
        
        echo "<div class='container'>";
        echo "<div class='row'>";
        echo "<div class='col text-center mt-2'>";
        echo "<button class='btn btn-primary' onclick='redirigirPDF(".$boleta->getIdBoleta().",".$boleta->getIdEvento().",".$boleta->getIdFactura().",".$boleta->getIdCliente().")'>Generar Factura</button>";
        echo "</div>";
        echo "</div>";
        echo "</div>";

        
    }
    ?>

    <script>
        function redirigirPDF(idBoleta, idEvento, idFactura, idCliente) {// Función para abrir una nueva pestaña
            window.open('./facturaPDF.php?idBoleta='+idBoleta+"&idEvento="+idEvento+"&idFactura="+idFactura+"&idCliente="+idCliente, '_blank');
        }
        const precio = <?php echo $evento->getPrecioBoleta() ?>;
        function mostrarValor(valor) {
            const cantidad = document.getElementById("valorRango").textContent = valor;
            const resultado = cantidad*precio;
            document.getElementById("precioTotal").textContent = resultado + " COP";
        }
    </script>
</body>