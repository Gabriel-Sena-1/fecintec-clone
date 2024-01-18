<?php
require_once('../Controller/AvaliadorController.php');

if (array_key_exists(1, $_POST)) {
    $AreasDeConhecimento[] = 1;
}
if (array_key_exists(2, $_POST)) {
    $AreasDeConhecimento[] = 2;
}
if (array_key_exists(3, $_POST)) {
    $AreasDeConhecimento[] = 3;
}
if (array_key_exists(4, $_POST)) {
    $AreasDeConhecimento[] = 4;
}
if (array_key_exists(5, $_POST)) {
    $AreasDeConhecimento[] = 5;
}

if (empty($AreasDeConhecimento)) {
    echo "Sem area de conhecimento";
    // die();
}

if (!empty($_POST) && $_POST['action'] = 'editar') {

    $avaliador = [];

    $avaliador['id'] = $_POST['id'];
    $avaliador['nome'] = $_POST['nome'];
    $avaliador['email'] = $_POST['email'];
    $avaliador['telefone'] = $_POST['telefone'];
    $avaliador['cidade_instituicao'] = $_POST['cidade_instituicao'];
    $avaliador['link_lattes'] = $_POST['link_lattes'];
    $avaliador['senha'] = $_POST['senha'];
    $avaliador['cpf'] = $_POST['cpf'];

    editarAvaliador($avaliador, $AreasDeConhecimento);
}



