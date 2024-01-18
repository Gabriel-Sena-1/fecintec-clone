<?php
require_once(__DIR__ . '/../Util/conectaPDO.php');

function AvaliadorAreas($id)
{
    $conn = conecta();

    try {
        $conn->beginTransaction();

        $sql = "SELECT nome, id FROM Avaliador";


        $stmt = $conn->prepare($sql);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conn->commit();

        if ($stmt->rowCount() == 1) {
            $result = $result[0];

            $_SESSION['nome'] = $result['nome'];
            $_SESSION['id'] = $result['id'];
        }
        foreach ($result as $dados) {

            $sql = "SELECT ar.descricao FROM area_de_conhecimento ar 
            JOIN avaliador_area_de_conhecimento avar
            ON avar.id_area_de_conhecimento = ar.id WHERE avar.id_avaliador =" . $id;

            $stmt = $conn->prepare($sql);

            $stmt->execute();
            $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo '<pre>';
            echo $dados['id'] . ' ';
            echo $dados['nome'] . " Areas de conhecimento:  ";
            foreach ($areas as $ar) {
                $sigla = explode(" -", $ar['descricao']);
                echo $sigla[0] . ',';
            }
            echo '<br>' . '</pre>';
        }
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Erro ao executar a consulta: " . $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function verificarAreas($idAvaliador, $idArea)
{
    $conn = conecta();

    try {
        $sql = "SELECT id_area_de_conhecimento FROM avaliador_area_de_conhecimento WHERE id_avaliador = " . $idAvaliador .
            " AND id_area_de_conhecimento = " . $idArea;

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($result)) {
            return false;
        }

        return true;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function ListarTrabalhos()
{
    $conn = conecta();

    try {
        $conn->beginTransaction();

        $sql = "SELECT nome, id FROM Avaliador";


        $stmt = $conn->prepare($sql);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conn->commit();

        if ($stmt->rowCount() == 1) {
            $result = $result[0];

            $_SESSION['nome'] = $result['nome'];
            $_SESSION['id'] = $result['id'];
        }
        foreach ($result as $dados) {

            $sql = "SELECT ar.descricao FROM area_de_conhecimento ar 
            JOIN avaliador_area_de_conhecimento avar
            ON avar.id_area_de_conhecimento = ar.id WHERE avar.id_avaliador =" . $dados['id'];

            $stmt = $conn->prepare($sql);

            $stmt->execute();
            $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo '<pre>';
            echo $dados['id'] . ' ';
            echo $dados['nome'] . " Areas de conhecimento:  ";
            foreach ($areas as $ar) {
                $sigla = explode(" -", $ar['descricao']);
                echo $sigla[0] . ',';
            }
            echo '<br>' . '</pre>';
        }
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Erro ao executar a consulta: " . $e->getMessage();
    }
}
