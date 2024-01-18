<?php 
include 'area_de_conhecimento.php';
include 'avaliador.php';
class AvaliadorAreaDeConhecimento {
    private $id;
    private AreaDeConhecimento $id_areas_de_conhecimento = array();
    private Avaliador $id_avaliadores = array();
    

    public function __construct($id_areas_de_conhecimento, $id_avaliadores) {
        $this->id_areas_de_conhecimento = $id_areas_de_conhecimento;
        $this->id_avaliadores = $id_avaliadores;
    }

    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
    }

    public function getIdAreasDeConhecimento() {
        return $this->id_areas_de_conhecimento;
    }

    public function setIdAreasDeConhecimento($id_areas_de_conhecimento) {
        $this->id_areas_de_conhecimento = $id_areas_de_conhecimento;
    }
    public function getIdAvaliadores() {
        return $this->id_avaliadores;
    }

    public function setIdAvaliadores($id_avaliadores) {
        $this->id_avaliadores = $id_avaliadores;
    }
}
