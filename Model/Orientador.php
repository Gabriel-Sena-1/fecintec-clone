<?php

class Orientador
{
    private $id;
    private $nome;
    private $presenca;
    private $email;
    private $cpf;

    // Construtor
    public function __construct($nome, $email, $cpf)
    {
        $this->nome = $nome;
        $this->email = $email;
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

    public function getEmail()
    {
        return $this->email;
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

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }
}