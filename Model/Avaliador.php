<?php
//include 'area_de_conhecimento.php';
class Avaliador
{
  private $id;
  private $cidade_instituicao;
  private $cpf;
  private $link_lattes;
  private $presenca;
  private $telefone;
  private $orienta;

  public function __construct($cidade_instituicao = null, $cpf = null, $orienta, $link_lattes = null, $telefone = null)
  {
    $this->cidade_instituicao = $cidade_instituicao;
    $this->cpf = $cpf;
    $this->orienta = $orienta;
    $this->link_lattes = $link_lattes;
    $this->telefone = $telefone;
  }
  //$this->senha = md5($cpf);

  public function tabelaConstruct($id = null, $nome = null, $email = null, $telefone = null, $cidade_instituicao = null, $link_lattes = null, $cpf = null)
  {
    $this->id = $id;
    $this->cidade_instituicao = $cidade_instituicao;
    $this->cpf = $cpf;
    $this->email = $email;
    $this->link_lattes = $link_lattes;
    $this->nome = $nome;
    $this->telefone = $telefone;
  }

  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
    $this->id = $id;
  }

  public function getCidadeInstituicao()
  {
    return $this->cidade_instituicao;
  }

  public function setCidadeInstituicao($cidade_instituicao)
  {
    $this->cidade_instituicao = $cidade_instituicao;
  }

  public function getCpf()
  {
    return $this->cpf;
  }

  public function setCpf($cpf)
  {
    $this->cpf = $cpf;
  }
  
  public function getLinkLattes()
  {
    return $this->link_lattes;
  }

  public function setLinkLattes($link_lattes)
  {
    $this->link_lattes = $link_lattes;
  }

  /*public function getSexo() {
    return $this->sexo;
  } */

  /*public function setSexo($sexo) {
    $this->sexo = $sexo;
  } */

  public function getTelefone()
  {
    return $this->telefone;
  }

  public function setTelefone($telefone)
  {
    $this->telefone = $telefone;
  }


  public function getOrienta()
  {
    return $this->orienta;
  }

  public function setOrienta($orienta)
  {
    $this->orienta = $orienta;
  }

  public function getPresenca()
  {
    return $this->presenca;
  }

  public function setPresenca($presenca)
  {
    $this->presenca = $presenca;
  }
  //* Cria getters para todos os atributos do objeto
  public function __get($name){
    return $this->$name;
  }

  //* Cria setter para todos os atributos
  public function __set($name, $value){

      //* Verifica se existe a propriedade
      if(property_exists('Avaliador', $name)){
          $this->$name = $value;
      }
      else {
          throw new Exception("Propriedade não existe");
      }

  }
}
