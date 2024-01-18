<?php

require_once(__DIR__ . '/../Util/conectaPDO.php');

function orientadorJaCadastrado($cpf)
{
    $conn = conecta();

    $sql = "SELECT * FROM orientador
    WHERE cpf =$cpf";
    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchAll();
    if (empty($result)) {
        return false;
    }
    return true;
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function cadastraOrientador($orientador){
    $conn = conecta();

    try {
        $conn->beginTransaction();

        $sql = "INSERT INTO orientador (nome, email, cpf) VALUES (:nome, :email, :cpf)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':nome', $orientador->getNome(), PDO::PARAM_STR);
        $stmt->bindValue(':email', $orientador->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':cpf', $orientador->getCpf(), PDO::PARAM_STR);

        $stmt->execute();

        // Obtém o ID inserido
        $orientadorId = $conn->lastInsertId();

        $conn->commit();

        // Retorna o ID do orientador
        return $orientadorId;
    } catch (PDOException $e) {
        $conn->rollBack();
        echo $e->getMessage();

        $e = "Não foi possível cadastrar o orientador!" . $orientador->getNome();
        header("Location: ../view/adm/saguaoadm.php?msg=$e");
        die($e);
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function buscaIdOrientador($cpf){
    $conn = conecta();

    $sql = "SELECT id FROM orientador WHERE cpf = $cpf";
    $stmt = $conn->prepare($sql);

    $stmt->execute();

    return $stmt->fetch()['id'];
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function verificaPresencaOrientador($idOrientador)
{
    $conn = conecta();

    try {
        $sql = "SELECT o.presenca
        FROM orientador o
        WHERE id = $idOrientador 
                ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['presenca'] == 1) {
            return true;
        }
        return false;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function buscarOrientadores($idTrabalho)
{
    $conn = conecta();

    try {
        $sql = "SELECT DISTINCT o.id, o.nome
        FROM orientador o, trabalho t
        WHERE t.id = $idTrabalho
        AND t.id_orientador = o.id;
                ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $orientadores = [];

        foreach ($result as $orientador) {
            $orientador['id'];
            $orientador['nome'];

            $orientadores[] = $orientador;
        }
        return $orientadores;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function presencaOrientador($idOrientador, $nome)
{
    $conn = conecta();

    try {
        $conn->beginTransaction();

        $sql = "UPDATE orientador SET presenca = :presenca WHERE id = :idOrientador";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':presenca', 1, PDO::PARAM_INT); // Use 1 em vez de "1" para presenca
        $stmt->bindValue(':idOrientador', $idOrientador, PDO::PARAM_INT); // Associe o ID do orientador


        $stmt->execute();

        updateLogPresencaOrientador($nome);

        return $conn->commit();
    } catch (PDOException $e) {
        throw new Exception("Erro na consulta SQL: " . $e->getMessage());
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function updateLogPresencaOrientador($nome)
{
    $conn = conecta();

    try {
        $conn->beginTransaction();

        $sql = "INSERT INTO `log` (comentario) VALUES ('Presença atribuida ao orientador $nome.') ";
        $stmt = $conn->prepare($sql);

        $stmt->execute();
        return $conn->commit();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

