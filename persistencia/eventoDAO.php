<?php
class eventoDAO{
    private $idEvento;
    private $nombre;
    private $artista;
    private $aforo;
    private $lugar;
    private $hora;
    private $recaudoEvento;
    private $precioBoleta;
    private $fechaPresentacion;
    private $fechaInicioCompra;
    private $fechaFinCompra;
    private $idCategoria;
    private $idProveedor;

    public function __construct($idEvento=0, $nombre="", $artista="", $aforo=0 , $lugar="", $hora=null, 
    $recaudoEvento=0, $precioBoleta=0,$fechaPresentacion=null,$fechaInicioCompra=null,$fechaFinCompra=null,$idCategoria=0,$idProveedor=0){
        $this->idEvento = $idEvento;
        $this->nombre = $nombre;
        $this->artista = $artista;
        $this->aforo = $aforo;
        $this->lugar = $lugar;
        $this->hora = $hora;
        $this->recaudoEvento = $recaudoEvento;
        $this->precioBoleta = $precioBoleta;
        $this->fechaPresentacion = $fechaPresentacion;
        $this->fechaInicioCompra = $fechaInicioCompra;
        $this->fechaFinCompra = $fechaFinCompra;
        $this->idCategoria = $idCategoria;
        $this->idProveedor = $idProveedor;
    }

    public function consultarTodos(){
        return "select * from evento";
    }

    public function consultarEvento(){
        return "select * from evento
                where id_evento = '" . $this-> idEvento . "'";
    }

    public function insertarEvento($idEvento, $nombre, $artista, $aforo, $lugar, $hora, $recaudoEvento, $precioBoleta,
    $fechaPresentacion,$fechaInicioCompra,$fechaFinCompra,$idCategoria,$idProveedor){
        return "insert into evento values 
        (".$idEvento.",'".$nombre."','".$artista."',".$aforo.",'".$lugar."','".$hora."',".$recaudoEvento.",".$precioBoleta.
        ",'".$fechaPresentacion."','".$fechaInicioCompra."','".$fechaFinCompra."',".$idCategoria.",".$idProveedor.");";
    }
}

?>