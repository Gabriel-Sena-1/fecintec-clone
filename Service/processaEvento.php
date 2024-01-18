<?php

require_once('../Controller/eventoController.php');


if (!empty($_POST)) {

    $nomeEvento = $_POST['nomeEvento'];
    $dataInicio = $_POST['dataInicio'];
    $dataFim = $_POST['dataFinal'];

    $result = cadastraEvento($nomeEvento, $dataInicio, $dataFim);

    if ($result) {
        $msg = "Evento cadastrado com sucesso!";
        header('Location: ./../view/adm/cadastrarEvento.php?msg=' . $msg);
    } else {
        $msg = "Erro ao cadastrar evento!";
        header('Location: ./../view/adm/cadastrarEvento.php?msg=' . $msg);
    }

    if ($nomeEvento == '' || $dataInicio == '' || $dataFim = '') {
        $msg = "Preencha todos os campos.";
        header('Location: ./../view/adm/cadastrarEvento.php?msg=' . $msg);
    }
}