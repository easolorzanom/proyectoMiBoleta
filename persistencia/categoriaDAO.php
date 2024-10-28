<?php
class categoriaDAO{
    private $idCategoria;
    private $nombre;

    public function __construct($idCategoria=0,$nombre=""){
        $this -> idCategoria = $idCategoria;
        $this -> nombre = $nombre;
    }

    public function consultarTodos(){
        return "select id_categoria, nombre from categoria";
    }
}
?>