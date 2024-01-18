<?php

session_start();
function acessVerify()
{
    $path = 'http://'
        . $_SERVER['SERVER_NAME']
        . '/View/login.php';

    if (!isset($_SESSION['logado'])) {
        header('Location: ' . $path . '?msg=Acesso Negado');
        exit();
    }
}
