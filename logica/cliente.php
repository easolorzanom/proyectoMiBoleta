<?php
class cliente extends Persona{

    public function __construct($idPersona=0, $nombre="", $apellido="", $correo="", $clave=""){
        parent::__construct($idPersona, $nombre, $apellido, $correo, $clave);
    }

    public function autenticar(){
        $conexion = new conexion();
        $conexion -> abrirConexion();
        $clienteDAO = new clienteDAO(null, null, null, $this->correo, $this->clave);
        $conexion -> ejecutarConsulta($clienteDAO -> autenticar());
        if($conexion -> numeroFilas() == 0){
            $conexion -> cerrarConexion();
            return false;
        }else{
            $registro = $conexion -> siguienteRegistro();
            $this -> idPersona = $registro[0];
            $conexion -> cerrarConexion();
            return true;
        }
    }

    public function consultar(){
        $conexion = new conexion();
        $conexion -> abrirConexion();
        $clienteDAO = new clienteDAO($this -> idPersona);
        $conexion -> ejecutarConsulta($clienteDAO -> consultarCliente());
        $registro = $conexion -> siguienteRegistro();
        $this -> nombre = $registro[0];
        $this -> apellido = $registro[1];
        $this -> correo = $registro[2];
        $conexion -> cerrarConexion();
    }
}
?>