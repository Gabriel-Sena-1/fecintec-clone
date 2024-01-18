<?php

require_once('./../Controller/orientadorController.php');


if (!empty($_GET['act']) && $_GET['act'] == 'presenca') {

    $idOrientador = $_GET['id'];
    $nome = $_GET['nome'];
    $id = $_GET['id_trabalho'];


    $result = presencaOrientador($idOrientador, $nome);

    if ($result) {
        $msg = "Presença atribuida ao orientador " . $nome . ".";
        header('Location: ./../view/credenciamento/telaPresencaEstudantes.php?id='.$id.'&msg=' . $msg .'&nomeTrabalho='.$_GET['nomeTrabalho'].'&idTrabalho='.$id);
    }else{
    $msg = 'Não deu certo.';
    header('Location: ./../view/credenciamento/telaCredenciamento.php?msg=' . $msg);
}
}