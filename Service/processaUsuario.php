<?php

include_once (dirname(__DIR__)."/Controller/usuarioController.php");
include_once (dirname(__DIR__)."/Controller/avaliadorController.php");
include_once (dirname(__DIR__)."/Controller/areasController.php");

if($_POST['action'] == 'cadastrar'){
    
    $idTipoUsuario = $_POST['tipoUsuario'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if(!empty($nome) && !empty($email)){
        $idUsuario = cadastrarUsuario($idTipoUsuario, $nome, $email);
        
        if($idTipoUsuario == 3 && !empty($idUsuario) && $idUsuario != null){

            $areas = buscarAreas();
            $AreasDeConhecimento = [];

            foreach($areas as $area){
                if (array_key_exists($area['id'], $_POST)) {
                    $AreasDeConhecimento[] = $area['id'];
                }
            }

            if (empty($AreasDeConhecimento)) {
                $msg = 'Sem area de conhecimento! Selecione ao menos uma para continuar.';
                header("Location: ../View/adm/cadastrarAvaliador.php?msg=".$msg); 
            }

            $avaliador = new Avaliador(
                $_POST['cidade_instituicao'],
                $_POST['cpf'],
                $_POST['email'],
                $_POST['link_lattes'],
                $_POST['nome'],
                $_POST['telefone']
            );

            /* print_r($avaliador);
            die(); */

            /* $verifica = buscarEmail();
            foreach($verifica as $email){
                if($_POST['email'] == $email['email']){
                    $msg = "Esse email já está cadastrado!";
                    return header('Location: ./../view/adm/cadastrarAvaliador.php?msg=' . $msg);
                }
            } */

            $verificaCpf = buscarCPF();
            foreach($verificaCpf as $cpf){
                if($_POST['cpf'] == $cpf['cpf']){
                    $msg = "Esse CPF já está cadastrado!";
                    return header('Location: ./../view/adm/cadastrarAvaliador.php?msg=' . $msg);
                }
            }
            
            cadastrarAvaliador($avaliador, $AreasDeConhecimento, $idUsuario);

        }
    }
    else{
        $msg = "Erro ao cadastrar usuário - Falta de dados para cadastro, por favor certifique-se de preencher todos os campos!";
        header("Location: ../View/adm/cadastrarAvaliador.php?msg=$msg");
    }

}

?>