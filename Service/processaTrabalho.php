<?php

require_once('./../Controller/avaliadorController.php');
require_once('./../Controller/trabalhoController.php');


if (!empty($_GET['act']) && $_GET['act'] == 'desclassifica') {

    $id = base64_decode($_GET['id']);
    $result = desclassificarTrabalho($id);
    // die(var_dump($result));
    if ($result) {

        $msg = 'Trabalho desclassificado!';
        header('Location: ./../view/adm/alterarAvaliador.php?id=' . $_GET['id'] . '&msg=' . $msg);
    }else{
    $msg = 'Não deu certo.';
    header('Location: ./../view/adm/alterarAvaliador.php?id=' . $_GET['id'] . '&msg=' . $msg);
}
}

if (!empty($_GET['act']) && $_GET['act'] == 'presenca') {

    $id = $_GET['id'];
    $result = presencaTrabalho($id);

    if ($result) {
        $msg = 'Presença atribuida!';
        header('Location: ./../view/credenciamento/telaCredenciamento.php?msg=' . $msg);
    }else{
    $msg = 'Não deu certo.';
    header('Location: ./../view/credenciamento/telaCredenciamento.php?msg=' . $msg);
}
}