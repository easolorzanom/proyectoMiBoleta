<?php
session_start();
if(isset($_GET["cerrarSesion"])){
    session_destroy();
}
require("logica/categoria.php");
require ("logica/persona.php");
require("logica/evento.php");
require("./imgEvento.php");
require("logica/proveedor.php");
require("logica/cliente.php");
?>

<html lang="en">
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<?php
		if (!isset($_SESSION["id"])) {
			//echo '<meta http-equiv="refresh" content="0; url=iniciarSesion.php">';
			//exit();
		}else{
			$rol = $_SESSION["rol"];
			$id = $_SESSION["id"];
		}
	?>
</head>
<body>
	<div class="p-3 mb-3 bg-secondary" style="--bs-bg-opacity: .3;">
		<div class="container sm-3">
			<?php include ("encabezado.php");?>
		</div>

		
		<div class="border border-white border-2 rounded-4 mt-3">
			<nav class="navbar navbar-expand-lg bg-secondary rounded-4" style="--bs-bg-opacity: .3;">
				<div class="container">
					<a class="navbar-brand" href="./index.php"><img src="img/logo_2.jpg" width="50"/></a>
					<button class="navbar-toggler" type="button"
						data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
						aria-controls="navbarNavDropdown" aria-expanded="false"
						aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarNavDropdown">
						<ul class="navbar-nav me-auto">

							<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categorias</a>
								<ul class="dropdown-menu">
								<?php
									$categoria = new Categoria();
									$categorias = $categoria->consultarCategorias();
									foreach ($categorias as $categoriaActual) {
										echo "<li><a class='dropdown-item' href='./index.php?idCategoria=".$categoriaActual->getIdCategoria()."'>" . $categoriaActual->getNombre() . "</a></li>";
									}
								?>
								</ul>
							</li>
							<li class="nav-item">
								<a class="nav-link active" aria-current="page" href="./sesionCliente.php">Historial de facturas</a>
							</li>

						</ul>
						<ul class="navbar-nav">
							<?php
								if(!isset($_SESSION["id"])){
									echo "<li class='nav-item'><a href='iniciarSesion.php' class='nav-link' aria-disabled='true'>Iniciar Sesion</a></li>";
								}else if($rol=="proveedor"){
									$proveedor = new proveedor($id);
									$proveedor -> consultar();
									echo "<li class='nav-item dropdown'>";
                                	echo "<a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>";
                                    echo $proveedor -> getNombre() . " " . $proveedor -> getApellido();
                                	echo "</a>";
                                	echo "<ul class='dropdown-menu'>";
                                    echo "<li><a class='dropdown-item' href='iniciarSesion.php?cerrarSesion=true'>Cerrar Sesion</a></li>";
                                	echo "</ul>";
                            		echo "</li>";
								}else if($rol=="cliente"){
									$cliente = new cliente($id);
									$cliente -> consultar();
									echo "<li class='nav-item dropdown'>";
                                	echo "<a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>";
                                    echo $cliente -> getNombre() . " " . $cliente -> getApellido();
                                	echo "</a>";
                                	echo "<ul class='dropdown-menu'>";
                                    echo "<li><a class='dropdown-item' href='./sesionCliente.php'>Historial de facturas</a></li>";
									echo "<li><a class='dropdown-item' href='iniciarSesion.php?cerrarSesion=true'>Cerrar Sesion</a></li>";
                                	echo "</ul>";
                            		echo "</li>";
								}
							?>
						
						</ul>
					</div>
				</div>
			</nav>
		</div>
		


		<div class="container mt-4">
			<div class="row mb-3">
				<div class="col">
					<div class="card-body">
							<?php
							$i = 0;
							$evento = new evento();
							$eventos = $evento->consultarEventos();
							foreach ($eventos as $eventoActual) {
								if( !isset($_GET["idCategoria"]) ){

									if ($i % 4 == 0) {
										echo "<div class='row mb-3'>";
									}
									echo "<div class='col-lg-3 col-md-4 col-sm-6' >";
									echo "<div class='card text-bg-light'>";
									echo "<div class='card-body'>";
									if(!isset($_SESSION["id"])){
										echo "<a class='content-link-container text-black text-decoration-none d-flex flex-column h-100' href='./iniciarSesion.php'>";
									}else if($rol=="proveedor"){
										echo "<a class='content-link-container text-black text-decoration-none d-flex flex-column h-100' href='./sesionProveedor.php'>";
									}else if($rol=="cliente"){
									echo "<a class='content-link-container text-black text-decoration-none d-flex flex-column h-100' href='./compraBoleta.php?idEvento=".$eventoActual->getIdEvento()."'>";
									}

									echo buscarImagen($eventoActual->getIdEvento())."<br>";
									$_SESSION["eventoId"] = $eventoActual->getIdEvento();
									echo "<h5>" . $eventoActual->getNombre() . "</h5><br>";
									echo "" . $eventoActual->getArtista() . "<br>";
									echo "Fecha: " . $eventoActual->getFechaPresentacion() . "<br>";
									echo "Lugar: " . $eventoActual->getLugar() . "<br>";
									echo "Hora: " . $eventoActual->getHora() . "<br>";
									echo "Venta desde: " . $eventoActual->getFechaInicioCompra() . "<br>";
									echo "hasta: " . $eventoActual->getFechaFinCompra() . "<br>";

									echo "</a>";
									echo "</div>";
									echo "</div>";
									echo "</div>";
									if ($i % 4 == 3) {
										echo "</div>";
									}
									$i ++;

								}else if( $_GET["idCategoria"] == $eventoActual->getIdCategoria() ){

									if ($i % 4 == 0) {
										echo "<div class='row mb-3'>";
									}
									echo "<div class='col-lg-3 col-md-4 col-sm-6' >";
									echo "<div class='card text-bg-light'>";
									echo "<div class='card-body'>";
									if(!isset($_SESSION["id"])){
										echo "<a class='content-link-container text-black text-decoration-none d-flex flex-column h-100' href='./iniciarSesion.php'>";
									}else if($rol=="proveedor"){
										echo "<a class='content-link-container text-black text-decoration-none d-flex flex-column h-100' href='./sesionProveedor.php'>";
									}else if($rol=="cliente"){
									echo "<a class='content-link-container text-black text-decoration-none d-flex flex-column h-100' href='./compraBoleta.php?idEvento=".$eventoActual->getIdEvento()."'>";
									}

									echo buscarImagen($eventoActual->getIdEvento())."<br>";
									$_SESSION["eventoId"] = $eventoActual->getIdEvento();
									echo "<h5>" . $eventoActual->getNombre() . "</h5><br>";
									echo "" . $eventoActual->getArtista() . "<br>";
									echo "Fecha: " . $eventoActual->getFechaPresentacion() . "<br>";
									echo "Lugar: " . $eventoActual->getLugar() . "<br>";
									echo "Hora: " . $eventoActual->getHora() . "<br>";
									echo "Venta desde: " . $eventoActual->getFechaInicioCompra() . "<br>";
									echo "hasta: " . $eventoActual->getFechaFinCompra() . "<br>";

									echo "</a>";
									echo "</div>";
									echo "</div>";
									echo "</div>";
									if ($i % 4 == 3) {
										echo "</div>";
									}
									$i ++;

								}
							}
							if ($i % 4 != 0) {
								echo "</div>";
							}
							?>
						</div>
					
				</div>
			</div>
		</div>





	<?php
		/*
		$evento = new evento();
		$eventos = $evento ->consultarEventos();
		foreach ($eventos as $eventoActual){
			echo "<h6><br>";
			echo "id evento: ". $eventoActual->getIdEvento()."<br>";
			echo "nombre del evento: ". $eventoActual->getNombre()."<br>";
			echo "artista: ". $eventoActual->getArtista()."<br>";
			echo "aforo: ". $eventoActual->getAforo()."<br>";
			echo "Recaudo del evento: ". $eventoActual->getRecaudoEvento()."<br>";
			echo "Fecha de presentacion: ". $eventoActual->getFechaPresentacion()."<br>";
			echo "Fecha inicio de compra: ". $eventoActual->getFechaInicioCompra()."<br>";
			echo "Fecha fin de compra: ". $eventoActual->getFechaFinCompra()."<br>";
			echo $eventoActual->getIdCategoria()."<br>";
			echo $eventoActual->getIdProveedor()."<br>";
			echo "</h6>";
			echo count($eventos);
		}*/
	?>


	</div>	
</body>
</html>