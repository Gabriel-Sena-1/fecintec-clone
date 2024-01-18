<?php
require_once (__DIR__."/../Util/conectaPDO.php");

function cadastrarUsuario($tipoUsuario, $nome, $email)
{

    $conn = conecta();

    try { //* Verificação de email, pois não será permitido o cadastro de um mesmo email mais de uma vez

        $sqlBusca = "SELECT email FROM usuario WHERE email = :email";

        $stmt = $conn->prepare($sqlBusca);
        $stmt->bindValue(':email', $email);

        $stmt->execute();

        $result = $stmt->fetch();

        if (!empty($result) || $result != '') {
            $msg = "Erro - Email já cadastrado!!!";
            header("Location: ../View/adm/cadastrarAvaliador.php?msg=$msg");
        }
    } catch (PDOException $e) {
        $conn->rollBack();
        echo $e->getMessage();
        echo "Erro na verificação de email...";
    }

    try { //* Caso a verificação tenha dado certo (não existe esse email no banco) será realizado o cadastro do usuário no banco de dados

        //* Define a syntax sql para inserir um novo usuário no banco de dados
        //? Descobrir da onde que vem o id_evento
        $sqlNovoUsuario = "INSERT INTO usuario(id, nome, email, senha, id_evento, id_tipo) VALUES (DEFAULT, :nome, :email, 'e10adc3949ba59abbe56e057f20f883e', 1/* :idEvento */, :idTipo)";

        $stmt = $conn->prepare($sqlNovoUsuario);

        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email);
        //$stmt->bindValue(':idEvento', $id_evento);
        $stmt->bindValue(':idTipo', $tipoUsuario);

        $stmt->execute();

        if ($tipoUsuario == 3) {
            $idUsuario = $conn->lastInsertId();
            return $idUsuario;
        } else {
            $msg = "Usuário cadastrado com sucesso!!";
            header("Location: ../View/adm/cadastrarAvaliador.php?msg=$msg");
        }
    } catch (PDOException $e) {
        $conn->rollBack();
        echo $e->getMessage();
        $e = "Não foi possível cadastrar o usuário!";
        header("Location: ../view/adm/cadastrarAvaliador.php?msg=$e");
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function cadastrarUsuarioAvaliador($tipoUsuario, $nome, $email, $cpf)
{

    $conn = conecta();

    try { //* Verificação de email, pois não será permitido o cadastro de um mesmo email mais de uma vez

        $sqlBusca = "SELECT email FROM usuario WHERE email = :email";

        $stmt = $conn->prepare($sqlBusca);
        $stmt->bindValue(':email', $email);

        $stmt->execute();

        $result = $stmt->fetch();


        if (!empty($result) || $result != '') {
            return null;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        echo "Erro na verificação de email...";
    }

    try { //* Caso a verificação tenha dado certo (não existe esse email no banco) será realizado o cadastro do usuário no banco de dados

        //* Define a syntax sql para inserir um novo usuário no banco de dados
        //? Descobrir da onde que vem o id_evento
        $sqlNovoAvaliador = "INSERT INTO usuario (nome, email, senha, id_evento, id_tipo) VALUES (:nome, :email, :senha, :id_evento, :id_tipo)";

        $stmt = $conn->prepare($sqlNovoAvaliador);

        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha', $cpf);
        $stmt->bindValue(':id_evento', 1);
        $stmt->bindValue(':id_tipo', $tipoUsuario);



        $stmt->execute();
        
        $idUsuario = $conn->lastInsertId();

        return $idUsuario;
    } catch (PDOException $e) {
        echo $e->getMessage();
        var_dump($e);
        die();
        $e = "Não foi possível cadastrar o usuário!";
        header("Location: ../view/adm/saguaoAdm.php?msg=$e");
    }
}
