<?php
//Necessita de um construtor??--Resposta: Sim, precisa
//Necessita passar o id da classe "Questão" por parâmetro no construtor?--Resposta: Não precisa
include_once 'TipoDePesquisa.php';

class Questao
{
  private $id;
  private $criterio;
  //private $peso;
  private TipoDePesquisa $id_tipo_de_pesquisa;

  public function __construct($criterio, $id_tipo_de_pesquisa)
  {
    $this->criterio = $criterio;
    $this->id_tipo_de_pesquisa = $id_tipo_de_pesquisa;
  }

  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
    $this->id = $id;
  }

  public function getCriterio()
  {
    return $this->criterio;
  }

  public function setCriterio($criterio)
  {
    $this->criterio = $criterio;
  }

  /*   public function getPeso() {
      return $this->peso;
  }

  public function setPeso($peso) {
      $this->peso = $peso;
  } */

  public function getIdTipoDePesquisa()
  {
    return $this->id_tipo_de_pesquisa;
  }

  public function setIdTipoDePesquisa($id_tipo_de_pesquisa)
  {
    $this->id_tipo_de_pesquisa = $id_tipo_de_pesquisa;
  }
}
