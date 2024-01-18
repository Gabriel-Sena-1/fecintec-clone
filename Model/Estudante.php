<?php

class Estudante
{
    private $id;
    private $nome;
    private $presenca;
    private $kit;
    private $cpf;

    // Construtor
    public function __construct($nome, $kit, $cpf)
    {
        $this->nome = $nome;
        $this->kit = $kit;
        $this->cpf = $cpf;
    }

    // Métodos Getter
    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getPresenca()
    {
        return $this->presenca;
    }

    public function getKit()
    {
        return $this->kit;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    // Métodos Setter
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setPresenca($presenca)
    {
        $this->presenca = $presenca;
    }

    public function setKit($kit)
    {
        $this->kit = $kit;
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }
}