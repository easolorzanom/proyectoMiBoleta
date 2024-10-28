<?php
require("./persistencia/facturaDAO.php");
require_once("./persistencia/conexion.php");
class factura{
    private $idFactura;
    private $fechaCompra;
    private $subtotal;
    private $iva;
    private $total;
    private $idCliente;

    public function getIdFactura() {
        return $this->idFactura;
    }
    public function getFechaCompra(){
        return $this->fechaCompra;
    }
    public function getSubtotal() {
        return $this->subtotal;
    }
    public function getIva() {
        return $this->iva;
    }
    public function getTotal() {
        return $this->total;
    }
    public function getIdCliente() {
        return $this->idCliente;
    }
    public function setIdFactura($idFactura){
        $this->idFactura = $idFactura;
    }
    public function setFechaCompra($fechaCompra){
        $this->fechaCompra = $fechaCompra;
    }
    public function setSubtotal($subtotal){
        $this->subtotal = $subtotal;
    }
    public function setIva($iva){
        $this->iva = $iva;
    }
    public function setTotal($total){
        $this->total = $total;
    }
    public function setIdCliente($idCliente){
        $this->idCliente = $idCliente;
    }

    public function __construct($idFactura=0, $fechaCompra=null, $subtotal=0,$iva=0,$total=0,$idCliente=0){
        $this -> idFactura = $idFactura;
        $this -> fechaCompra = $fechaCompra;
        $this -> subtotal = $subtotal;
        $this -> iva = $iva;
        $this -> total = $total;
        $this-> idCliente = $idCliente;
    }

    public function consultarFacturas(){
        $facturas = array();
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $facturaDAO = new facturaDAO();
        $conexion -> ejecutarConsulta($facturaDAO -> consultarFacturas());
        while($registro = $conexion -> siguienteRegistro()){
            $factura = new factura($registro[0], $registro[1], $registro[2], $registro[3], $registro[4], $registro[5]);
            array_push($facturas, $factura);
        }
        $conexion -> cerrarConexion();
        return $facturas;
    }

    public function consultar(){
        $conexion = new conexion();
        $conexion -> abrirConexion();
        $facturaDAO= new facturaDAO($this -> idFactura);
        $conexion -> ejecutarConsulta($facturaDAO -> consultarFactura());
        $registro = $conexion -> siguienteRegistro();
        $this->idFactura = $registro[0];
        $this->fechaCompra = $registro[1];
        $this->subtotal = $registro[2];
        $this->iva = $registro[3];
        $this->total = $registro[4];
        $this->idCliente = $registro[5];
        $conexion -> cerrarConexion();
    }

    public function crearFactura(){
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $facturaDAO = new facturaDAO();
        $conexion ->ejecutarConsulta($facturaDAO->insertarFactura($this->idFactura,$this->fechaCompra, $this->subtotal,
        $this->iva,$this->total,$this->idCliente));
        $conexion -> cerrarConexion();
    }

}
?>