<?php
session_start();
if(isset($_GET["cerrarSesion"])){
    session_destroy();
}
require ("logica/persona.php");
require ("logica/proveedor.php");
require ("logica/cliente.php");
$error = false;
if(isset($_POST["autenticar"])){
    $dominio ="/miboleta.com/i";
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];
    if (preg_match($dominio, $correo)){
        $proveedor = new proveedor(null, null, null, $correo, $clave);
        if($proveedor -> autenticar()){
            $_SESSION["id"] = $proveedor -> getIdPersona();
            $_SESSION["rol"] = "proveedor";
            header("Location: sesionProveedor.php");
        }else{
            $error = true;
        }
    }else{
        $cliente = new cliente(null, null, null, $correo, $clave);
        if($cliente -> autenticar()){
            $_SESSION["id"] = $cliente -> getIdPersona();
            $_SESSION["rol"] = "cliente";
            header("Location: index.php");
        }else{
            $error = true;
        }
    }
        
}
if(isset($_POST["volver"])){
    header("Location: index.php");
}
?>

<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="bg-secondary" style="--bs-bg-opacity: .4;">
        <div class="p-3 mb-3">
            <?php include("encabezado.php") ?>
            <div class="container">
                <div class="row mt-5">
                    <div class="col-4"></div>
                    <div class="col-4">
                        <form method="post" action="iniciarSesion.php" >
                            <div class="mb-3">
                                <input type="email" name="correo" class="form-control" placeholder="Correo">
                            </div>
                            <div class="mb-3">
                                <input type="password" name="clave" class="form-control" placeholder="Clave">
                            </div>
                            <div class="d-grid gap-2 col-6 mx-auto">
                                <button type="submit" name="autenticar" class="btn btn-secondary">Iniciar Sesion</button><br>
                            </div>
                            <div class="d-grid gap-2 col-6 mx-auto">
                                <button type="submit" name="volver" class="btn btn-secondary">Volver al inicio</button>
                            </div>
                            <?php if($error){ ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                Error de correo o clave
                            </div>    
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>