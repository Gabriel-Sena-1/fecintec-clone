<?php
class Usuario
{
  private $id;
  private $email;
  private $nome;
  private $senha;
  private $idTipo;

  public function __construct($email , $nome, $senha)
  {
    $this->email = $email;
    $this->nome = $nome;
    $this->senha = $senha;
  }


  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
    $this->id = $id;
  }

  public function getNome()
  {
    return $this->nome;
  }

  public function setNome($nome)
  {
    $this->nome = $nome;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function setEmail($email)
  {
    $this->email = $email;
  }


  public function getSenha()
  {
    return $this->senha;
  }

  public function setSenha($senha){
    $this->senha = $senha;
  }

  
  public function getIdTipo()
  {
    return $this->idTipo;
  }

  public function setIdTipo($idTipo){
    $this->idTipo = $idTipo;
  }

    }