<?php
class proveedor extends persona{
    
    public function __construct($idPersona=0, $nombre="", $apellido="", $correo="", $clave=""){
        parent::__construct($idPersona, $nombre, $apellido, $correo, $clave);
    }

    public function autenticar(){
        $conexion = new conexion();
        $conexion -> abrirConexion();
        $proveedorDAO = new proveedorDAO(null, null, null, $this->correo, $this->clave);
        $conexion -> ejecutarConsulta($proveedorDAO -> autenticar());
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
        $proveedorDAO = new proveedorDAO($this -> idPersona);
        $conexion -> ejecutarConsulta($proveedorDAO -> consultarProveedor());
        $registro = $conexion -> siguienteRegistro();
        $this -> nombre = $registro[0];
        $this -> apellido = $registro[1];
        $this -> correo = $registro[2];
        $conexion -> cerrarConexion();
    }
}
?>