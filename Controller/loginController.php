<?php 
require_once (__DIR__.'/../Util/conectaPDO.php');

// function limparCaracteres($texto){
//     $texto = addcslashes($texto,"--");
//     return addslashes(strip_tags($texto));
// }


session_start();

function verificaLogin($senha, $email){
    $conn = conecta();

    // $senha = limparCaracteres($senha);
    // $email = limparCaracteres($email);

    try{
        $conn->beginTransaction();

        $senha = md5($senha);
        $sqlVerifica = ("SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha' ");

        $stmt = $conn->prepare($sqlVerifica);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$result){
            return false;
        }
        else if($result){
            $_SESSION['usuario'] = $result;
            return true;
        }
        
        /* if($result = $stmt->fetch()){
            $_SESSION['avaliador'] = $result;
            return true;
        }
        else{
            return false;
        } */

    }catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function verificaAdm($senha, $email){
    $conn = conecta();

    // $senha = limparCaracteres($senha);
    // $email = limparCaracteres($email);

    try{
        $conn->beginTransaction();

        $senha = md5($senha);
        $sqlVerifica = ("SELECT * FROM administrador WHERE email = '$email' AND senha = '$senha' ");

        $stmt = $conn->prepare($sqlVerifica);
        $stmt->execute();
        
        if($result = $stmt->fetch()){
            $_SESSION['administrador'] = $result;
            return true;
        }
        else{
            return false;
        }

    }catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function verificaCredenciamento($senha, $email){
    $conn = conecta();

    // $senha = limparCaracteres($senha);
    // $email = limparCaracteres($email);

    try{
        $conn->beginTransaction();

        $senha = md5($senha);
        $sqlVerifica = ("SELECT * FROM credenciamento WHERE email = '$email' AND senha = '$senha' ");

        $stmt = $conn->prepare($sqlVerifica);
        $stmt->execute();
        
        if($result = $stmt->fetch()){
            $_SESSION['credenciamento'] = $result;
            return true;
        }
        else{
            return false;
        }

    }catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//* Função que recebe como parametro os valores que estão na sessão do usuario ($usuario) e o id do tipo de usuário permitido para logar em determinada página
function verificaLogado($usuario, $tipo_de_usuario){

    if(is_numeric($tipo_de_usuario)){
        if($usuario['id_tipo'] == $tipo_de_usuario){
            return true;
        }
        else{
            return false;
        }
    }

}

?>