<?php
include 'Questao.php';
//include 'TrabalhoAvaliador.php';
class Avaliacao
{
    private $id;
    private $nota;
    private Questao $id_questao;
    private TrabalhoAvaliador $id_trabalho_avaliador;


    public function __construct($nota, $id_questao, $id_trabalho_avaliador)
    {
        $this->nota = $nota;
        $this->id_questao = $id_questao;
        $this->id_trabalho_avaliador = $id_trabalho_avaliador;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNota()
    {
        return $this->nota;
    }

    public function setNota($nota)
    {
        $this->nota = $nota;
    }

    public function getIdQuestao()
    {
        return $this->id_questao;
    }

    public function setIdQuestao($id_questao)
    {
        $this->id_questao = $id_questao;
    }

    public function getIdTrabalhoAvaliador()
    {
        return $this->id_trabalho_avaliador;
    }

    public function setIdTrabalhoAvaliador($id_trabalho_avaliador)
    {
        $this->id_trabalho_avaliador = $id_trabalho_avaliador;
    }
}
