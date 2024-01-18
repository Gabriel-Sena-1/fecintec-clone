<?php
include 'Trabalho.php';
include 'Avaliador.php';
class TrabalhoAvaliador
{
    private $id;
    private $foiAvaliado;
    private $media;
    private $id_trabalho = array();
    //TODO - ADICIONAR TRABALHO
    private $id_avaliadores = array();
    //TODO - ADICIONAR AVALIADOR

    public function __construct($foiAvaliado, $media, $id_trabalho, $id_avaliadores)
    {
        $this->foiAvaliado = $foiAvaliado;
        $this->media = $media;
        $this->id_trabalho = $id_trabalho;
        $this->id_avaliadores = $id_avaliadores;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getFoiAvaliado()
    {
        return $this->foiAvaliado;
    }

    public function setFoiAvaliado($foiAvaliado)
    {
        $this->foiAvaliado = $foiAvaliado;
    }

    public function getMedia()
    {
        return $this->media;
    }

    public function setMedia($media)
    {
        $this->media = $media;
    }

    public function getIdTrabalho()
    {
        return $this->id_trabalho;
    }

    public function setIdTrabalho($id_trabalho)
    {
        $this->id_trabalho = $id_trabalho;
    }

    public function getIdAvaliadores()
    {
        return $this->id_avaliadores;
    }

    public function setIdAvaliadores($id_avaliadores)
    {
        $this->id_avaliadores = $id_avaliadores;
    }
}
