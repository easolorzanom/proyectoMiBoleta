<?php 
session_start();
$id = $_SESSION["id"];
if (!isset($_SESSION["id"])) {
    echo '<meta http-equiv="refresh" content="0; url=iniciarSesion.php">';
    exit();
}

?>