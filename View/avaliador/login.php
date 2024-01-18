<?php
session_start();

if (isset($_SESSION['avaliador'])) {
    return header('Location: ./telaAvaliador.php');
}

if (isset($_SESSION['administrador'])) {
    return header('Location: ./../adm/saguaoAdm.php');
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/IconFCT.png" type="image/x-icon">
    <title>Login</title>

    <!-- Links -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="<?php include '../fragments/paths.php';
        echo absolutePath . 'View/css/estilo.css';
        $PAGE = 'login.php'; ?>">

</head>

<body style="background-color: #f5f5f5">

    <!-- Header -->
    <?php
    include __DIR__ . '/../fragments/header.php';
    ?>

    <main class="mx-auto main">
        <?php

        include absolutePath . "/Util/conectaPDO.php";
        //conecta();
        
        ?>
        <!-- <img src="img/logfecintec.png" alt=""> -->



        <div class="alinhamento">

            <div class="title is-5 my-5" id="fecintec">
                <h1>Feira de Ciência e Tecnologia de Campo Grande</h1>
            </div>

            <!-- Bloco do form cinza -->
            <form class="bloco cinza mb-6" action="./../../Service/processaLogin.php" method="post">

                <!-- Icone do usuário -->
                <div class="alinhamento m-2 mb-5">
                    <img src="<?php echo absolutePathImg . 'userIcon.png' ?>" alt="UserIcon" width="130px">
                </div>

                <!-- Campo do Email -->
                <div class="field">
                    <label class="label" for="email">Email</label>
                    <div class="control">
                        <input class="input" type="email" name="email" placeholder="Digite seu e-mail">
                        <small id="emailHelp" class="form-text text-muted">Este é o mesmo e-mail do cadastro.</small>
                    </div>
                </div>

                <!-- Campo da Senha -->
                <div class="field">
                    <label class="label" for="senha">Senha</label>
                    <div class="control">
                        <input class="input" type="password" name="senha" placeholder="Digite a sua senha">
                        <small id="emailHelp" class="form-text text-muted">A senha foi informada no e-mail.</small>
                    </div>
                </div>

                <!-- Botão para entrar  -->
                <div class="alinhamento mt-5">
                    <button class="button verdeEscuro" id="btnLogar" type="submit">LOGIN</button>
                </div>

                <?php
                if (isset($_GET['msg']) || !empty($_GET['msg'])) {
                    echo "<script> alert('" . $_GET['msg'] . "'); </script>";
                }
                ?>

            </form>

        </div>

    </main>

</body>

<!-- Footer -->
<?php
include absolutePath . 'View/fragments/footer.php';
?>

</html>