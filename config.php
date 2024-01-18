<?php
    ### Credenciais servidor web ###
    define('BD_HOST', 'localhost');
    define('BD_USUARIO', 'root');
    define('BD_SENHA', '');
    define('BD_NOME', 'fecintec');

    define('DS', DIRECTORY_SEPARATOR);
    define('ROOT_PATH', __DIR__ . DS . '..' . DS);
    define('CLASS_PATH', ROOT_PATH . 'class' . DS);
    define('LIB_PATH', ROOT_PATH . 'lib' . DS);

    define('URL_SEPARATOR', '/');
    define('UDS', URL_SEPARATOR);
    define('ROOT_URL_PATH', UDS);

    session_start();
