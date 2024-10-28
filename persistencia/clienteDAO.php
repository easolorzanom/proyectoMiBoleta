<?php
class clienteDAO{
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
        return "select id_cliente from cliente
                where correo = '" . $this -> correo . "' and clave = '" . $this -> clave. "'";
    }

    public function consultarCliente(){
        return "select nombre, apellido, correo from cliente
                where id_cliente = '".$this -> idPersona."'";
    }
}
?>