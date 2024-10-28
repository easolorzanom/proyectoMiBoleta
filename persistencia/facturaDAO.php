<?php
class facturaDAO{
    private $idFactura;
    private $fechaCompra;
    private $subtotal;
    private $iva;
    private $total;
    private $idCliente;

    public function __construct($idFactura=0, $fechaCompra=null, $subtotal=0,$iva=0,$total=0,$idCliente=0){
        $this -> idFactura = $idFactura;
        $this -> fechaCompra = $fechaCompra;
        $this -> subtotal = $subtotal;
        $this -> iva = $iva;
        $this -> total = $total;
        $this->idCliente = $idCliente;
    }

    public function consultarFacturas(){
        return "select * from factura";
    }

    public function consultarFactura(){
        return "select * from factura
                where id_factura = '" . $this-> idFactura . "'";
    }

    public function insertarFactura($idFactura,$fechaCompra,$subtotal,$iva,$total,$idCliente){
        return "insert into factura values (".$idFactura.",'".$fechaCompra."',".$subtotal.",".$iva.",".$total.",".$idCliente.")";
    }
}
?>