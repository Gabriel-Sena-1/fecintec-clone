<?php

require_once(__DIR__ . '/../Util/conectaPDO.php');
require_once(__DIR__ . '/../Controller/avaliacaoController.php');

echo "<pre>";
$conn = conecta();

// cria variavel para a lista orientadores - é usada em avaliador controler
$listaOrientadores = array();

try {
    // Inicia uma transação no banco de dados
    $conn->beginTransaction();

    // Executa uma consulta para buscar todos os avaliadores ordenados por ID
    $sqlListar = "SELECT * FROM avaliador ORDER BY id";
    $stmt = $conn->prepare($sqlListar);
    $stmt->execute();

    // Obtém os resultados da consulta como um array associativo
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Em caso de erro, captura a exceção do PDO e imprime a mensagem de erro
    echo "ERRO";
    echo $e->getMessage();
}


//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

foreach ($result as $avaliador) {
    $trabalhosAvaliados = trabalhosAvaliadosAvaliador($avaliador['id']);
    $i = 1;

    foreach ($trabalhosAvaliados as $trabalho) {
        // GERAR O PDF
        $nomeArquivo = "Certificado Trabalho - " . $trabalho['titulo'];


        // COLOCAR CAMINHO PARA O PDF
        echo "<pre>";
        echo $avaliador['nome'];
        echo "<br>";
        echo $trabalho['titulo'];
        echo "<br>";
        echo $avaliador['email'];
        echo "<br>";
        echo $nomeArquivo;
        echo "</pre>";
        // USAR A BIBLIOTECA PHPMAILER



        $i++;
    }
    echo "<br>";
}
