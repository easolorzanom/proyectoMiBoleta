<?php
class Conexion{
    private $mysqlConexion;
    private $resultado;
    
    public function abrirConexion(){
        $this -> mysqlConexion = new mysqli("localhost", "root", "", "proyecto_apps");
    }
    
    public function ejecutarConsulta($sentenciaSQL){
        $this -> resultado = $this -> mysqlConexion -> query($sentenciaSQL);
    }
    
    public function siguienteRegistro(){
        return $this -> resultado -> fetch_row();
    }
    
    public function cerrarConexion(){
        $this -> mysqlConexion -> close();
    }

    public function numeroFilas(){
        return $this -> resultado -> num_rows;
    }
}
?>