<?php 
require_once ('../Controller/loginController.php');
require_once ('../Controller/avaliadorController.php');

if($_POST['senha'] == '' || $_POST['email'] == ''){
    $msg = 'Senha ou email não inseridos';
    header("Location: ../view/avaliador/login.php?msg=".$msg);
}

$senha = $_POST['senha'];
$email = $_POST['email'];

if(verificaLogin($senha,$email)){
    if($_SESSION['usuario']['id_tipo'] == 3){ //* Usuario avaliador
        $_SESSION['msg'] = 'Seja bem-vindo '.$_SESSION['usuario']['nome'];
 
        $id = $_SESSION['usuario']['id'] - contaAdm();
        presencaAvaliador($id, $_SESSION['usuario']['nome']);
        header("Location: ../view/avaliador/telaAvaliador.php"); 

    }
    else if($_SESSION['usuario']['id_tipo'] == 2){ //* Usuario monitor
        $_SESSION['msg'] = 'Seja bem-vindo '.$_SESSION['usuario']['nome'];

        header("Location: ../view/credenciamento/telaCredenciamento.php"); 
    }
    else if($_SESSION['usuario']['id_tipo'] == 1){ //* Usuario admin
        $msg = 'Seja bem-vindo administrador '.$_SESSION['usuario']['nome'];

        header("Location: ../view/adm/saguaoAdm.php?msg=$msg"); 
    }
}

if(verificaLogin($senha, $email) == false){
    $msg = 'Senha ou email incorretos!';
    
    header("Location: ../view/avaliador/login.php?msg=".$msg); 
}

/* if(verificaAdm($senha, $email)){
    $msg = 'Seja bem-vindo administrador '.$_SESSION['administrador']['nome'].'.';
    header("Location: ../view/adm/saguaoAdm.php?msg=".$msg); 
}

if(verificaCredenciamento($senha, $email)){
    $msg = 'Seja bem-vindo monitor!';
    header("Location: ../view/credenciamento/telaCredenciamento.php?msg=".$msg); 
} */