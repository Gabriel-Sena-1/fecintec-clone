<?php
//mds que medo de perder o projeto
// include_once '../../config.php';
const servername = "localhost";
const username = "root"; // const username = "root";
const password = ""; // const password = ""; // Depois eu tiro :D
const data_base_name = "fecintec";  // const data_base_name = "fecintec";


function conecta()
{
    $conexao = null;
    try {
        $conexao = new PDO("mysql:host=" . servername . ";port=3306;dbname=" . data_base_name, username, password);
        // echo 'conectado';
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Não foi possível conectar ao BD :(<br>';
        echo $e->getMessage();
    }

    return $conexao;
}

// class ConexaoBD{
//     private $conexao;
//     private $sql;
//     public $declaracao;
//     public $ultimoIdInserido;

//     function __construct($sql = NULL){
//         $this->conectar();
//         if(!is_null($sql)){
//             $this->preparar($sql);
//         }
//     }

//     public function conectar(){
//         $this->conexao = new PDO('mysql:host=' . BD_HOST . ';dbname=' . BD_NOME, BD_USUARIO, BD_SENHA);
//     }

//     public function preparar($sql){
//         $this->sql = $sql;
//         $this->declaracao = $this->conexao->prepare($sql);
//     }

//     public function beginTransaction() {
//         $this->conexao->beginTransaction();
//     }

//     public function commit() {
//         $this->conexao->commit();
//     }

//     public function executar($dados){

//             if (!$this->declaracao->execute($dados)) {
//                 throw new Exception("Falha ao executar SQL");
//             }

//             $this->ultimoIdInserido = $this->conexao->lastInsertId();

//     }

//     public function quantidadeLinhasAfetadas(){
//         return $this->declaracao->rowCount();
//     }

//     public function houveLinhasAfetadas(){
//         if($this->quantidadeLinhasAfetadas() > 0)
//             return true;
//         return false;
//     }

//     public function buscar($dados = NULL){
//         $this->executar($dados);

//         if ($this->quantidadeLinhasAfetadas() > 0) {

//             return $this->declaracao->fetchAll();
//         }

//         return NULL;

//     }

//     public function getUltimoIdInserido() {
//         return $this->ultimoIdInserido;
//     }

//     public function rollBack(){

//     }
// }
