<?php
require_once("./persistencia/conexion.php");
require("./persistencia/eventoDAO.php");

class evento{
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

    public function getIdEvento(){
        return $this-> idEvento;
    }
    public function getNombre(){
        return $this-> nombre;
    }
    public function getArtista(){
        return $this-> artista;
    }
    public function getAforo(){
        return $this-> aforo;
    }
    public function getLugar(){
        return $this-> lugar;
    }
    public function getHora(){
        return $this-> hora;
    }
    public function getRecaudoEvento(){
        return $this-> recaudoEvento;
    }
    public function getPrecioBoleta(){
        return $this-> precioBoleta;
    }
    public function getFechaPresentacion(){
        return $this-> fechaPresentacion;
    }
    public function getFechaInicioCompra(){
        return $this-> fechaInicioCompra;
    }
    public function getFechaFinCompra(){
        return $this-> fechaFinCompra;
    }
    public function getIdCategoria(){
        return $this-> idCategoria;
    }
    public function getIdProveedor(){
        return $this->idProveedor;
    }

    public function setIdEvento($idEvento){
        $this->idEvento = $idEvento;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function setArtista($artista){
        $this->artista = $artista;
    }
    public function setAforo($aforo){
        $this->aforo = $aforo;
    }
    public function setLugar($lugar){
        $this->lugar = $lugar;
    }
    public function setHora($hora){
        $this->hora = $hora;
    }
    public function setRecaudoEvento($recaudoEvento){
        $this->recaudoEvento = $recaudoEvento;
    }
    public function setPrecioBoleta($precioBoleta){
        $this-> precioBoleta = $precioBoleta;
    }
    public function setFechaPresentacion($fechaPresentacion){
        $this->fechaPresentacion = $fechaPresentacion;
    }
    public function setFechaInicioCompra($fechaInicioCompra){
        $this->fechaInicioCompra = $fechaInicioCompra;
    }
    public function setFechaFinCompra($fechaFinCompra){
        $this->fechaFinCompra = $fechaFinCompra;
    }
    public function setIdCategoria($idCategoria){
        $this->idCategoria = $idCategoria;
    }
    public function setIdProveedor($idProveedor){
        $this->idProveedor = $idProveedor;
    }
    public function __construct($idEvento=0, $nombre="", $artista="", $aforo=0 , $lugar="", $hora=null, 
    $recaudoEvento=0,$precioBoleta=0 ,$fechaPresentacion=null,$fechaInicioCompra=null,$fechaFinCompra=null,$idCategoria=0,$idProveedor=0){
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

    public function consultarEventos(){
        $eventos = array();
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $eventoDAO = new eventoDAO();
        $conexion -> ejecutarConsulta($eventoDAO -> consultarTodos());
        while($registro = $conexion -> siguienteRegistro()){
            $evento = new evento($registro[0], $registro[1], $registro[2], $registro[3], $registro[4], $registro[5], 
            $registro[6], $registro[7], $registro[8], $registro[9], $registro[10], $registro[11], $registro[12]);
            array_push($eventos, $evento);
        }
        $conexion -> cerrarConexion();
        return $eventos;
    }

    public function crearEvento(){
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $eventoDAO = new eventoDAO();
        $conexion ->ejecutarConsulta($eventoDAO->insertarEvento($this->idEvento,$this->nombre, $this->artista,
        $this->aforo,$this->lugar,$this->hora,$this->recaudoEvento,$this->precioBoleta,$this->fechaPresentacion,
        $this->fechaInicioCompra,$this->fechaFinCompra, $this->idCategoria, $this->idProveedor));
        $conexion -> cerrarConexion();
    }

    public function consultar(){
        $conexion = new conexion();
        $conexion -> abrirConexion();
        $eventoDAO= new eventoDAO($this -> idEvento);
        $conexion -> ejecutarConsulta($eventoDAO -> consultarEvento());
        $registro = $conexion -> siguienteRegistro();
        $this->idEvento = $registro[0];
        $this->nombre = $registro[1];
        $this->artista = $registro[2];
        $this->aforo = $registro[3];
        $this->lugar = $registro[4];
        $this->hora = $registro[5];
        $this->recaudoEvento = $registro[6];
        $this->precioBoleta = $registro[7];
        $this->fechaPresentacion = $registro[8];
        $this->fechaInicioCompra = $registro[9];
        $this->fechaFinCompra = $registro[10];
        $this->idCategoria = $registro[11];
        $this->idProveedor = $registro[12];
        $conexion -> cerrarConexion();
    }
}
?>