<?php
class boletaDAO{
    private $idBoleta;
    private $cantidad;
    private $precioUnidad;
    private $precioTotal;
    private $idEvento;
    private $idFactura;
    private $idCliente;

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
        return "select * from boleta";
    }
    public function consultarBoleta(){
        return "select * from boleta
                where id_boleta = '" . $this-> idBoleta . "'";
    }
    public function insertarBoleta($idBoleta, $cantidad, $precioUnidad, $precioTotal, $idEvento, $idFactura, $idCliente){
        return "insert into boleta values (".$idBoleta.",".$cantidad.",".$precioUnidad.",".
        $precioTotal.",".$idEvento.",".$idFactura.",".$idCliente.");";
    }

}

?>