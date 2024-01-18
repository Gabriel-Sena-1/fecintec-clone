<?php
require_once('../Util/conectaPDO.php');
require_once('../Controller/AvaliadorController.php');
require_once('../Controller/trabalhoController.php');
include_once(dirname(__DIR__) . "/Controller/areasController.php");

if ($_GET['action'] == 'vincular') {
    $idAvaliador = $_GET['id'];
    $idTrabalho = $_GET['idt'];
    $idTipo = $_GET['idp'];

    $result = adicionarAvaliador($idTrabalho, $idAvaliador, $idTipo);


    if ($result = !'' || $result = !NULL) {

        $msg = 'Avaliador vinculado com sucesso!';
        return header('Location: ./../view/adm/alterarAvaliador.php?id=' . base64_encode($idTrabalho) . '&msg=' . $msg);
    } else {
        $msg = 'Não foi possivel vincular o avaliador!';

        return header('Location: ./../view/adm/alterarAvaliador.php?id=' . base64_encode($idTrabalho) . '&msg=' . $msg);

    }
} 

if (!empty($_GET['act']) && $_GET['act'] == 'presenca') {

    $idAvaliador = $_GET['id'];
    $nome = $_GET['nomeAvaliador'];
    $dia = $_GET['dia'];



    $result = presencaAvaliador($idAvaliador, $nome, $dia);

    if ($result) {
        $msg = "Presença atribuida ao Avaliador $nome no dia $dia.";
        header('Location: ./../view/credenciamento/telaCredenciamentoAvaliadores.php?id=' . $id . '&msg=' . $msg);
    } else {
        $msg = 'Não deu certo.';
        header('Location: ./../view/credenciamento/telaCredenciamentoAvaliadores.php?msg=' . $msg);
    }
}