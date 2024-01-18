<?php

require_once(__DIR__ . '/../Util/conectaPDO.php');

function listarLog()
{
    $conn = conecta();

    try {
        $conn->beginTransaction();

        $sqlLog = "SELECT * FROM `log`";
        $stmt = $conn->prepare($sqlLog);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }catch (PDOException $e) {
        $conn->rollBack();
        echo $e->getMessage();
        $e = "Problemas no log!";
    }

}
