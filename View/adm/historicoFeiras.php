<?php
//session_start();

include_once(dirname(dirname(__DIR__))."/Controller/loginController.php");

if (isset($_SESSION) && !empty($_SESSION) && verificaLogado($_SESSION['usuario'], 1)) {

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
        <link rel="stylesheet" href="<?php include '../fragments/paths.php';
                                        echo absolutePath . 'View/css/estilo.css'; ?>">

        <style>
            .tittle {
                text-align: center;
                font-weight: 300;
                margin: 30px;
            }
        </style>

    </head>

    
    <body style="background-color: #f5f5f5">

        <!-- Header -->
        <?php
        include __DIR__ . '/../fragments/header.php';
        ?>

        <main class="mx-auto main">
            <div>
                <h1 class="tittle">Olá <?= $_SESSION['usuario']['nome'] . ", seja bem vindo ao Histórico das Feiras de Ciências!" ?></h1>



                <div>
                    <div style="display: flex; flex-direction: column; align-items: center;">
                        <div style="color: white; font-weight: 600; flex-direction: column; align-items: center;">

                            <div style="display: flex; flex-direction: row-reverse; justify-content: space-between;">
                                <div>
                                    <a href="./saguaoAdm.php" style="align-items: unset; ">
                                        <button type="button" class="button verde" style="margin-bottom: 20px; color: white; font-weight: 400;">
                                            Voltar
                                        </button>
                                    </a>
                                </div>

                                <div style="width: 80%;">
                                    <input type="text" class="input" id="filtroInput" placeholder="Coloque o que deseja filtrar" onkeypress="filtro(this.value)" onkeyup="filtro(this.value)" style="">
                                </div>
                            </div>

                            <div>
                                <table class="table is-striped is-hoverable" style="text-align: center; width: 600px;" id="responsivo">
                                    <thead style="background-color: #82c282">
                                        <tr>
                                            <th style="text-align: center;">ID</th>
                                            <th style="text-align: center;">Evento</th>
                                            <th style="text-align: center;">Baixar</th>
                                        </tr>
                                    </thead>

                                    <tbody class="cinzaTabela">
                                        <tr>
                                            <?php
                                            // alterar o seguinte trecho de codigo
                                            // foreach
                                            ?>

                                            <td> 1 </td>
                                            <td> Fecintec 2023 </td>

                                            <td class="negrito">
                                                <a style="" href="<?php echo absolutePath . 'Controller/historicoController.php' ?>"><img src="<?= absolutePathImg . "/pdficon.png" ?>" alt="Ícone PDF" width="30px"></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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