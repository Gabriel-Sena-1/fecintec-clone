<?php
include_once '../Controller/avaliadorController.php';
include_once './../Model/Usuario.php';
include_once './../Controller/orientadorController.php';


//TODO - MODIFICAR

//$url = "https://script.google.com/macros/s/AKfycbywuo9Si3gi4Vn0KP31lnwU0e42hiiqmv_XG5urSb_WD0eiofdDc-LQBShRLRC86wI-/exec";

$url = "https://script.google.com/macros/s/AKfycbxL0CJlwXkU69S4-sRlAUeKiq95XQMVSpKvXlOJOxMKWkV0BwgfzGpbCHYdiNamUMRcMQ/exec";

$result = json_decode(file_get_contents($url));

foreach ($result as $key => $avaliador) {
    $_avaliador = new Avaliador(
        $cidade_instituicao = $avaliador->Instituicao,
        $cpf = trim($avaliador->CPF),
        $orienta = 0,
        $link_lattes = $avaliador->Lattes,
        $telefone = $avaliador->Telefone
    );

    $usuario = new Usuario(
        $email = strtoupper($avaliador->Email),
        $nome = trim($avaliador->Nome),
        $senha = md5($avaliador->CPF)
    );
    $tipoUsuario = 3;
   $idUsuario = cadastrarUsuarioAvaliador($tipoUsuario, $nome, $email, $senha);

    $_avaliadorAreas = [];


    if (str_contains($avaliador->Areas, 'CAE')) {
        $_avaliadorAreas[] = 1;
    }
    if (str_contains($avaliador->Areas, 'CBS')) {
        $_avaliadorAreas[] = 2;
    }
    if (str_contains($avaliador->Areas, 'CET')) {
        $_avaliadorAreas[] = 3;
    }
    if (str_contains($avaliador->Areas, 'CHSAL')) {
        $_avaliadorAreas[] = 4;
    }
    if (str_contains($avaliador->Areas, 'MDIS')) {
        $_avaliadorAreas[] = 5;
    }



    if (!avaliadorJaCadastrado($email, $cpf)) {
        cadastrarAvaliadorPorPlanilha($_avaliador, $_avaliadorAreas, $idUsuario);
    }
    if(orientadorJaCadastrado($cpf)){
        updateOrientacao($cpf);
    }

}
$msg = 'Todos os avaliadores já foram cadastrados';
header("Location: ../view/adm/saguaoadm.php?msg=$msg");
