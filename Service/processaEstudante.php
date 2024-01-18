<?php

require_once('./../Controller/estudanteController.php');


if (!empty($_GET['act']) && $_GET['act'] == 'presenca') {

    $idEstudante = $_GET['id'];
    $nome = $_GET['nome'];
    $id = $_GET['id_trabalho'];
    $nomeTrabalho = $_GET['nomeTrabalho'];
    
    $result = presencaEstudante($idEstudante, $nome, $id, $nomeTrabalho);

    if ($result) {
        $msg = "Presença atribuida ao estudante " . $nome . ".";
        header('Location: ./../view/credenciamento/telaPresencaEstudantes.php?id='.$id.'&msg=' . $msg .'&nomeTrabalho='.$_GET['nomeTrabalho'].'&idTrabalho='.$id.'&dia='.$dia);
    }else{
    $msg = 'Não deu certo.';
    header('Location: ./../view/credenciamento/telaCredenciamento.php?msg=' . $msg);
}
}

if (!empty($_GET['act']) && $_GET['act'] == 'zeraPresenca') {

    $result = zerarPresencas();

    if ($result) {
        $msg = "Todas as presenças zeradas!";
        header('Location: ./../view/adm/saguaoadm.php?msg='.$msg);
    }else{
    $msg = 'Não deu certo.';
    header('Location: ./../view/adm/saguaoadm.php?msg='.$msg);
}
}