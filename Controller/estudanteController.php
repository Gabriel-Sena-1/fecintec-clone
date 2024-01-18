<?php

require_once(__DIR__ . '/../Util/conectaPDO.php');


function buscarEstudantes($idTrabalho)
{
    $conn = conecta();

    try {
        $sql = "SELECT e.id AS id_estudante, e.nome
        FROM estudante e
        INNER JOIN estudante_trabalho et ON e.id = et.id_estudante
        INNER JOIN trabalho t ON et.id_trabalho = t.id
        WHERE t.id = $idTrabalho;
                ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $estudantes = [];

        foreach ($result as $estudante) {
            $estudante['id_estudante'];
            $estudante['nome'];

            $estudantes[] = $estudante;
        }
        return $estudantes;
    } catch (PDOException $e) {
        echo "Erro na função buscarEstudantes - estudanteController";
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function presencaEstudante($idEstudante, $nome, $id, $nomeTrabalho)
{
    $conn = conecta();

    try {
        $conn->beginTransaction();

        $sql = "UPDATE estudante SET presenca = :presenca, kit = :kit WHERE id = :idEstudante";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':presenca', 1, PDO::PARAM_INT); // Use 1 em vez de "1" para presenca
        $stmt->bindValue(':kit', 0, PDO::PARAM_INT); // Use 0 em vez de "0" para kit
        $stmt->bindValue(':idEstudante', $idEstudante, PDO::PARAM_INT); // Associe o ID do estudante



        $result = $stmt->execute();

        if ($result) {
            updateLogPresencaEstudante($nome, $nomeTrabalho);
            return $conn->commit();
        } else {
            $msg = 'Houve um erro na atribuição da presença ao estudante.';
            return header('Location: ' . absolutePath . '/view/credenciamento/telaPresencaEstudantes.php?id=' . $id . '&msg=' . $msg . '&nomeTrabalho=' . $nomeTrabalho);
        }
    } catch (PDOException $e) {
        throw new Exception("Erro na consulta SQL: " . $e->getMessage());
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function cadastraEstudante($estudante) //! MANO NAO PRECISA DE PRESENCA E KIT
{
    $conn = conecta();

    try {
        $conn->beginTransaction();

        $sql = "INSERT INTO estudante (nome, kit, cpf) VALUES (:nome, :kit, :cpf)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':nome', $estudante->getNome(), PDO::PARAM_STR);
        $stmt->bindValue(':kit', $estudante->getKit(), PDO::PARAM_STR);
        $stmt->bindValue(':cpf', $estudante->getCpf(), PDO::PARAM_STR);

        $stmt->execute();

        // Obtém o ID inserido
        $estudanteId = $conn->lastInsertId();

        $conn->commit();

        // Retorna o ID do orientador
        return $estudanteId;
    } catch (PDOException $e) {
        $conn->rollBack();
        echo $e->getMessage();

        $e = "Não foi possível cadastrar o estudante " . $estudante->getNome() . "!";
        header("Location: ../view/adm/saguaoadm.php?msg=$e");
        die($e);
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function estudanteJaCadastrado($cpf)
{

    $conn = conecta();

    $sql = "SELECT * FROM estudante WHERE cpf ='" . $cpf . "'";
    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchAll();
    if (empty($result)) {
        return false;
    }
    return true;
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function buscaIdEstudante($cpf)
{
    $conn = conecta();

    try {
        $sql = "SELECT id FROM estudante WHERE cpf = $cpf";
        $stmt = $conn->prepare($sql);

        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Erro na função buscaIdEstudante - estudanteController";
        echo $e->getMessage();
        die($e);
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function verificaPresencaEstudantesTrabalho($idTrabalho, $quantidadeEstudantes)
{
    $conn = conecta();

    try {
        $sql = "SELECT SUM(e.presenca)
        FROM estudante e
        INNER JOIN estudante_trabalho et ON e.id = et.id_estudante
        INNER JOIN trabalho t ON et.id_trabalho = t.id
        WHERE t.id = $idTrabalho
                ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($result["SUM(e.presenca)"] == $quantidadeEstudantes) {
            return true;
        }
        return false;
    } catch (PDOException $e) {
        echo "Erro na função verificaPresencaEstudantesTrabalho - estudanteController";
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function verificaPresencaEstudante($idEstudante, $idTrabalho)
{
    $conn = conecta();

    try {
        $sql = "SELECT e.presenca
        FROM estudante e
        INNER JOIN estudante_trabalho et ON e.id = $idEstudante
        INNER JOIN trabalho t ON et.id_trabalho = t.id
        WHERE t.id = $idTrabalho
                ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result["presenca"] == 1) {
            return true;
        }
        return false;
    } catch (PDOException $e) {
        echo "Erro na função verificaPresencaEstudante - estudanteController";
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function updateLogPresencaEstudante($nome, $nomeTrabalho)
{
    $conn = conecta();

    try {
        $conn->beginTransaction();

        $sql = "INSERT INTO `log` (comentario) VALUES ('Presença atribuida ao estudante $nome no trabalho: $nomeTrabalho.') ";
        $stmt = $conn->prepare($sql);

        $stmt->execute();
        return $conn->commit();
    } catch (PDOException $e) {
        echo "Erro na função updateLogPresencaEstudante- estudanteController";
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function verificaPresencaEstudantePorNome($nome, $idTrabalho)
{
    $conn = conecta();

    try {
        $sql = "SELECT e.presenca
        FROM estudante e
        INNER JOIN estudante_trabalho et ON e.nome = '$nome'
        INNER JOIN trabalho t ON et.id_trabalho = t.id
        WHERE t.id = $idTrabalho
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

function zerarPresencas()
{
    $conn = conecta();

    try {
        $conn->beginTransaction(); 
        
        // Atualiza presenca na tabela estudante
        $sql1 = "UPDATE estudante SET presenca = 0";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute();
        
        // Atualiza presenca na tabela orientador
        $sql2 = "UPDATE orientador SET presenca = 0";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute();

        // Commit das alterações
        $conn->commit();
        
        return true;
    } catch (PDOException $e) {
        // Rollback em caso de erro
        $conn->rollBack();
        echo "Erro na função zerar presenca - estudanteController";
        echo $e->getMessage();
        return false;
    }
}
