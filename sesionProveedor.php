<?php
session_start();
require ("logica/persona.php");
require ("logica/categoria.php");
require ("logica/proveedor.php");
require ("logica/evento.php");
$id = $_SESSION["id"];
$proveedor = new proveedor($id);
$proveedor -> consultar();

if (!isset($_SESSION["id"])) {
    echo '<meta http-equiv="refresh" content="0; url=iniciarSesion.php">';
    exit();
}
?>

<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
</head>
<body class="bg-secondary" style="--bs-bg-opacity: .3;">
    <div class="p-3 mb-3">
        <div class="container sm-3">
            <?php include ("encabezado.php");?>
        </div>
        <div class="border border-white border-2 rounded-4 mt-3">
            <nav class="navbar navbar-expand-lg bg-secondary rounded-4" style="--bs-bg-opacity: .3;">
                <div class="container">
                    <a class="navbar-brand" href="#"><img src="img/logo_2.jpg" width="50" /></a>
                    <button class="navbar-toggler" type="button"
                        data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                        aria-controls="navbarNavDropdown" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle"
                                href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">Eventos</a>
                                <ul class="dropdown-menu">
                                    <li><!-- Button trigger modal -->
                                        <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                        Nuevo evento
                                        </button>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo $proveedor -> getNombre() . " " . $proveedor -> getApellido() ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class='dropdown-item' href='iniciarSesion.php?cerrarSesion=true'>Cerrar Sesion</a></li>
                                </ul>
                            </li>
                        </ul>			
                    </div>
                </div>
            </nav>
        </div>
    </div>


    <!-- Modal Nuevo evento -->
    <div class="modal fade modal-dialog-scrollable" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Crear Evento</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="sesionProveedor.php">
                        <div class="mb-3">
                            <label for="nombreEvento" class="form-label">Nombre del evento</label>
                            <input type="text" name="nombreEvento" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="artista" class="form-label">Artista</label>
                            <input type="text" name="artista" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="aforo" class="form-label">Aforo</label>
                            <input type="number" name="aforo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <select class="form-select" name="categoria" required>
                                <option selected>Categoria</option>
                                <?php
									$categoria = new Categoria();
									$categorias = $categoria->consultarCategorias();
									foreach ($categorias as $categoriaActual) {
										echo "<option value=".$categoriaActual->getIdCategoria().">" . $categoriaActual->getNombre() . "</option>";
									}
								?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="lugar" class="form-label">Lugar</label>
                            <input type="text" name="lugar" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="hora" class="form-label">Hora</label>
                            <input type="time" name="hora" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="fechaEvento" class="form-label">Fecha de evento</label>
                            <input type="date" name="fechaEvento" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="precioBoleta" class="form-label">Precio de la boleta</label>
                            <input type="number" name="precioBoleta" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="abrirVenta" class="form-label">Cuando abre la venta de boletas:</label>
                            <input type="date" name="abrirVenta" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="cerrarVenta" class="form-label">Cuando cierra la venta de boletas</label>
                            <input type="date" name="cerrarVenta" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-outline-secondary" name="btnCrearEvento">Crear evento</button>
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    
                </div>
            </div>
        </div>
    </div>

    <?php
        if (isset($_POST["btnCrearEvento"])) {
            $evento = new evento(0, $_POST["nombreEvento"], $_POST["artista"], $_POST["aforo"], $_POST["lugar"],
            $_POST["hora"], 0, $_POST["precioBoleta"], $_POST["fechaEvento"], $_POST["abrirVenta"], $_POST["cerrarVenta"], $_POST["categoria"], $id);
            
            /*echo "nombre evento ".$evento->getNombre()."<br>";
            echo "artista ".$evento->getArtista()."<br>";
            echo "aforo ".$evento->getAforo()."<br>";
            echo "lugar ".$evento->getLugar()."<br>";
            echo "hora ".$evento->getHora()."<br>";
            echo "fecha evento ".$evento->getFechaPresentacion()."<br>";
            echo "abrir venta ".$evento->getFechaInicioCompra()."<br>";
            echo "cerrar venta ".$evento->getFechaFinCompra()."<br>";
            echo "id categoria ".$evento->getIdCategoria()."<br>";
            echo "id proveedor ".$evento->getIdProveedor()."<br>";*/
            $eventos = $evento->consultarEventos();
            $idEvento = count($eventos)+1;
            $evento->setIdEvento($idEvento);
            $evento->crearEvento();
            
        }
    ?>
    <div class="container">
        <div class="row mb-3">
            <div class="col">
                <div class="card border-dark">
                    <div class="card-header bg-secondary">
                        <h4>Sesion Proveedor</h4>
                    </div>
                    <div class="card-body">
                        <p>Bienvenido Proveedor <?php echo $proveedor -> getNombre() . " " . $proveedor -> getApellido() ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>