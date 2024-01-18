<?php 
//Necessita passar o id da classe "Trabalho" por parâmetro no construtor?
//include 'orientador.php';
include 'AreaDeConhecimento.php';
//include 'avaliador.php';
include 'TipoDePesquisa.php';

class Trabalho {
    private $id;
    private $nivel;
    // private $cpf_coorientador;
    // private $cpf_orientador;
    private $descricaoMDIS;
    // private $email_coorientador;
    // private $email_orientador;
    //private AreaDeConhecimento $id_area_de_conhecimento;
    private $id_area_de_conhecimento;
    private $id_orientador;
    private $id_coorientador;
    //private TipoDePesquisa $id_tipo_de_pesquisa;
    private $id_tipo_de_pesquisa;
    private $media_final; //recebe os valores da tabela avaliaçao e faz a media final, existe apenas na aplicação, não existe no banco dados
    private $nome_coorientador;
    private $nome_orientador;
    private $titulo;
    private $ativo;
    private $instituicao;
    private $notaResumo;
   
    
    
    //private Orientador $id_orientador;
    //private Avaliador $id_avaliadores = array();
    
    public function __construct($nivel = null, $titulo = null, $instituicao = null, $ativo = null, $notaResumo = null ) {
        $this->nivel = $nivel;
        $this->titulo = $titulo;    
        $this->instituicao = $instituicao;
        $this->ativo = $ativo;
        $this->notaResumo = $notaResumo;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNivel() {
        return $this->nivel;
    }

    public function setNivel($nivel) {
        $this->nivel = $nivel;
    }

    public function getCpfCoorientador() {
        return $this->cpf_coorientador;
    }

    public function setCpfCoorientador($cpf_coorientador) {
        $this->cpf_coorientador = $cpf_coorientador;
    }

    public function getCpfOrientador() {
        return $this->cpf_orientador;
    }

    public function setCpfOrientador($cpf_orientador) {
        $this->cpf_orientador = $cpf_orientador;
    }

    public function getDescricaoMDIS() {
        return $this->descricaoMDIS;
    }

    public function setDescricaoMDIS($descricaoMDIS) {
        $this->descricaoMDIS = $descricaoMDIS;
    }

    public function getEmailCoorientador() {
        return $this->email_coorientador;
    }

    public function setEmailCoorientador($email_coorientador) {
        $this->email_coorientador = $email_coorientador;
    }

    public function getEmailOrientador() {
        return $this->email_orientador;
    }

    public function setEmailOrientador($email_orientador) {
        $this->email_orientador = $email_orientador;
    }

    public function getEstudantes() {
        return $this->estudantes;
    }

    public function setEstudantes($estudantes) {
        $this->estudantes = $estudantes;
    }

    public function getIdAreaDeConhecimento() {
        return $this->id_area_de_conhecimento;
    }

    public function setIdAreaDeConhecimento($id_area_de_conhecimento) {
        $this->id_area_de_conhecimento = $id_area_de_conhecimento;
    }

    public function getIdTipoDePesquisa() {
        return $this->id_tipo_de_pesquisa;
    }

    public function setIdTipoDePesquisa($id_tipo_de_pesquisa) {
        $this->id_tipo_de_pesquisa = $id_tipo_de_pesquisa;
    }

    public function getMediaFinal() {
        return $this->media_final;
    }

    public function setMediaFinal($media_final) {
        $this->media_final = $media_final;
    }

    public function getNomeCoorientador() {
        return $this->nome_coorientador;
    }

    public function setNomeCoorientador($nome_coorientador) {
        $this->nome_coorientador = $nome_coorientador;
    }

    public function getNomeOrientador() {
        return $this->nome_orientador;
    }

    public function setNomeOrientador($nome_orientador) {
        $this->nome_orientador = $nome_orientador;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function getAtivo() {
        return $this->ativo;
    }

    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    public function getInstituicao() {
        return $this->instituicao;
    }

    public function setInstituicao($instituicao) {
        $this->instituicao = $instituicao;
    }

    public function getNotaResumo() {
        return $this->notaResumo;
    }

    public function setNotaResumo($notaResumo) {
        $this->notaResumo = $notaResumo;
    }

    /* public function getIdOrientador() {
        return $this->id_orientador;
    }

    public function setIdOrientador($id_orientador) {
        $this->id_orientador = $id_orientador;
    } */

/*     public function getIdAvaliadores() {
        return $this->id_avaliadores;
    }

    public function setIdAvaliadores($id_avaliadores) {
        $this->id_avaliadores = $id_avaliadores;
    }
 */
   
}
