<?php
session_start();
require_once('../Controller/avaliadorController.php');
require_once('../Controller/trabalhoController.php');


$idTrabalho = $_POST['idTrabalho'];
$idAvaliador = $_POST['idAvaliador'];

$teste = verificaQuestao($idTrabalho);
$ids = array();
foreach ($teste as $t) {
    $ids[] = $t['id'];
}

unset($_POST['id']);

if (!empty($_POST['act']) && $_POST['act'] == 'nota') {

    foreach ($_POST as $id => $nota) {
        if (in_array($id, $ids)) {
            $nota = (str_replace(',', '.', $nota));
            if (strlen($nota) > 4) {
                $aviso = 'Nenhuma nota não pode ter mais de 2 casas decimais!';
                return header('Location: ./../view/avaliador/telaAvaliador.php?aviso=' . $aviso);
            }
            $nota = (float) $nota;
            if (is_numeric($nota)) {
                if ($nota > 10) {
                    $aviso = 'Nenhuma nota pode ser maior que 10, reenvie todas as notas!';
                    return header('Location: ./../view/avaliador/telaAvaliador.php?aviso=' . $aviso);
                }
                if ($nota < 0) {
                    $aviso = 'Nenhuma nota pode ser menor que 0, reenvie todas as notas!';
                    return header('Location: ./../view/avaliador/telaAvaliador.php?aviso=' . $aviso);
                }
            } else {
                $aviso = 'Todas as notas devem ser um numero, reenvie todas as notas!';
                return header('Location: ./../view/avaliador/telaAvaliador.php?aviso=' . $aviso);
            }
        }
    }
    foreach ($_POST as $id => $nota) {
        if (in_array($id, $ids)) {
            $nota = (str_replace(',', '.', $nota));
            $nota = (float) $nota;
        }
        $msg = cadastrarAvaliacao($nota, $idAvaliador, $id, $idTrabalho);
    }

    if ($msg) {
        $aviso = 'Avaliação cadastrada com sucesso!';
        if (!empty($_SESSION) && !empty($_SESSION['avaliador'])) {
            header('Location: ./../view/avaliador/telaAvaliador.php?aviso=' . $aviso);
        }
        elseif (!empty($_SESSION) && !empty($_SESSION['administrador'])) {
            header('Location: ./../view/adm/alterarAvaliador.php?id=' . base64_encode($idTrabalho) . '&msg=' . $aviso);
        }        
    } else {
        $aviso = 'Não foi possivel cadastrar a avaliação!';
        header('Location: ./../view/avaliador/telaAvaliador.php?aviso=' . $aviso);
    }
}