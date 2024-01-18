<?php

require_once(__DIR__ . '/../Util/conectaPDO.php');

function cadastraEvento($nome, $dataInicio, $dataFim){

    $conn = conecta();

    try {
        $conn->beginTransaction();

        $sql = "INSERT INTO `evento`(`nome`, `data_inicio`, `data_fim`) VALUES ('$nome','$dataInicio','$dataFim')";
        $stmt = $conn->prepare($sql);

        
        $stmt->execute();
        
        return $conn->commit();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    //
}
