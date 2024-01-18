<?php
require_once(__DIR__ . '/../Util/conectaPDO.php');

//* Função que pega o id e o nome de todas as áreas
function buscarAreas()
{

    $conn = conecta();

    $sql = "SELECT * FROM area_de_conhecimento";
    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchAll();
    $lista = [];

    foreach ($result as $item) {
        $lista[] = array(
            "id" => $item['id'],
            "descricao" => $item['descricao']
        );
    }

    return $lista;
}

?>