<?php
require("./persistencia/boletaDAO.php");
require_once("./persistencia/conexion.php");
class boleta{
    private $idBoleta;
    private $cantidad;
    private $precioUnidad;
    private $precioTotal;
    private $idEvento;
    private $idFactura;
    private $idCliente;

    public function getIdBoleta(){
        return $this-> idBoleta;
    }
    public function getCantidad(){
        return $this-> cantidad;
    }
    public function getPrecioUnidad(){
        return $this-> precioUnidad;
    }
    public function getPrecioTotal(){
        return $this-> precioTotal;
    }
    public function getIdEvento(){
        return $this-> idEvento;
    }
    public function getIdFactura(){
        return $this-> idFactura;
    }
    public function getIdCliente(){
        return $this-> idCliente;
    }

    public function setIdBoleta($idBoleta){
        $this->idBoleta = $idBoleta;
    }
    public function setCantidad($cantidad){
        $this->cantidad = $cantidad;
    }
    public function setPrecioUnidad($precioUnidad){
        $this->precioUnidad = $precioUnidad;
    }
    public function setPrecioTotal($precioTotal){
        $this->precioTotal = $precioTotal;
    }
    public function setIdEvento($idEvento){
        $this ->idEvento = $idEvento;
    }
    public function setIdFactura($idFactura){
        $this ->idFactura = $idFactura;
    }
    public function setIdCliente($idCliente){
        $this ->idCliente = $idCliente;
    }

    public function __construct($idBoleta=0,$cantidad=0,$precioUnidad=0,$precioTotal=0,$idEvento=0,$idFactura=0,$idCliente=0){
        $this->idBoleta = $idBoleta;
        $this->cantidad = $cantidad;
        $this->precioUnidad = $precioUnidad;
        $this->precioTotal = $precioTotal;
        $this ->idEvento = $idEvento;
        $this ->idFactura = $idFactura;
        $this ->idCliente = $idCliente;
    }
    public function consultarBoletas(){
        $boletas = array();
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $boletaDAO = new boletaDAO();
        $conexion -> ejecutarConsulta($boletaDAO -> consultarBoletas());
        while($registro = $conexion -> siguienteRegistro()){
            $boleta = new boleta($registro[0], $registro[1], $registro[2], $registro[3], $registro[4], $registro[5], $registro[6]);
            array_push($boletas, $boleta);
        }
        $conexion -> cerrarConexion();
        return $boletas;
    }
    public function consultar(){
        $conexion = new conexion();
        $conexion -> abrirConexion();
        $boletaDAO= new boletaDAO($this -> idBoleta);
        $conexion -> ejecutarConsulta($boletaDAO -> consultarBoleta());
        $registro = $conexion -> siguienteRegistro();
        $this->idBoleta = $registro[0];
        $this->cantidad = $registro[1];
        $this->precioUnidad = $registro[2];
        $this->precioTotal = $registro[3];
        $this->idEvento = $registro[4];
        $this->idFactura = $registro[5];
        $this->idCliente = $registro[6];
        $conexion -> cerrarConexion();
    }
    public function crearBoleta(){
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $boletaDAO = new boletaDAO();
        $conexion ->ejecutarConsulta($boletaDAO->insertarBoleta($this->idBoleta,$this->cantidad, $this->precioUnidad,
        $this->precioTotal,$this->idEvento,$this->idFactura,$this->idCliente));
        $conexion -> cerrarConexion();
    }

}
?>