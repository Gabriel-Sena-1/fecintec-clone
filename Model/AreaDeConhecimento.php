<?php
class AreaDeConhecimento
{
  private $id;
  private $descricao;

  public function __construct($descricao)
  {
    $this->descricao = $descricao;
  }

  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
    $this->id = $id;
  }

  public function getDescricao()
  {
    return $this->descricao;
  }

  public function setDescricao($descricao)
  {
    $this->descricao = $descricao;
  }
}
