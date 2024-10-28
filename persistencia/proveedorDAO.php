<?php
class proveedorDAO{
    private $idPersona;
    private $nombre;
    private $apellido;
    private $correo;
    private $clave;

    public function __construct($idPersona=null, $nombre=null, $apellido=null, $correo=null, $clave=null){
        $this -> idPersona = $idPersona;
        $this -> nombre = $nombre;
        $this -> apellido = $apellido;
        $this -> correo = $correo;
        $this -> clave = $clave;
    }

    public function autenticar(){
        return "select id_proveedor from proveedor
                where correo = '" . $this -> correo . "' and clave = '" . $this -> clave. "'";
    }

    public function consultarProveedor(){
        return "select nombre, apellido, correo from proveedor
                where id_proveedor = '" . $this-> idPersona . "'";
    }

}

?>