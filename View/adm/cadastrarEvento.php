<?php
//session_start();

include_once(dirname(dirname(__DIR__)) . "/Controller/loginController.php");

if (isset($_SESSION) && !empty($_SESSION) && verificaLogado($_SESSION['usuario'], 1)) //* Valor 1 para admin, 2 para monitor, 3 para avaliador, escolhe o que desejar :)
{

?>
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../img/IconFCT.png" type="image/x-icon">
        <title>Nome da Página</title>

        <!-- Links -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?php include '../fragments/paths.php';
                                        echo absolutePath . 'View/css/estilo.css'; ?>">

    </head>

    <body style="background-color: #f5f5f5">

        <!-- Header -->
        <?php
        include __DIR__ . '/../fragments/header.php';
        ?>

        <main>

        <?php
        if (isset($_GET['msg']) || !empty($_GET['msg'])) {
            echo "<script> alert('" . $_GET['msg'] . "'); </script>";
        }
        ?>

            <div class="alinhamento">

                <div class="title is-5 my-5" id="fecintec">
                    <h1>Feira de Ciência e Tecnologia de Campo Grande</h1>

                    <div class="alinhamento" style="position: absolute; left: 25px; top: 15px;">
                        <a href="./saguaoAdm.php" style="align-items: unset;">
                            <button type="button" class="button verde is-medium" style="color: white;">
                                Voltar
                            </button>
                        </a>
                    </div>
                </div>



                <div class="title" id="fecintec" style="text-align: center;">
                    <h1>Cadastro de Evento</h1>
                </div>



                <div>

                    <form class="bloco cinza mb-6" action="./../../Service/processaEvento.php" method="post" style="border-radius: 0px 6px 6px 6px!important;">

                        <div class="field">
                            <label class="label" for="nome">Nome do Evento</label>
                            <div class="control">
                                <input class="input" type="text" name="nomeEvento" placeholder="Insira seu nome" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label" for="dataInicio">Data de início: </label>
                            <div class="control">
                                <input class="input" type="date" name="dataInicio" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label" for="dataFinal">Data de final: </label>
                            <div class="control">
                                <input class="input" type="date" name="dataFinal" required>
                            </div>
                        </div>


                        <!-- Botão -->
                        <div style="text-align:center;">
                            <button class="button verdeEscuro" id="btnLogar" type="submit">Cadastrar</button>
                        </div>

                    </form>

                </div>

                <!-- Botão para caso já exista cadastro -->
                <!-- <div class="mt-5">
    <a class="is-size-7" style="color: rgb(0, 0, 0)"
        href="<?php /* echo absolutePath."View/avaliador/login.php"; */ ?>">Já tenho cadastro!</a>
</div> -->

            </div>

        </main>

    </body>

    <!-- Footer -->
    <?php
    include absolutePath . 'View/fragments/footer.php';
    ?>

    </html>


<?php
} else {
    echo "Você não tem permissão para acessar esta página.";
    header("Refresh:2; URL=../avaliador/login.php");
}

?>