<?php
// session_start();

// if (!empty($_SESSION) && isset($_SESSION) && isset($_SESSION['credenciamento'])) 
// {

require_once __DIR__ . '/../../Controller/estudanteController.php';
require_once __DIR__ . '/../../Controller/orientadorController.php';

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/IconFCT.png" type="image/x-icon">
    <title>Presenças - Trabalho: <?= $_GET['nomeTrabalho'] ?></title>
    <!-- Links -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php include '../fragments/paths.php';
                                    echo absolutePath . 'View/css/estilo.css';
                                    ?>">
    <link rel="stylesheet" href="<?php echo absolutePath . 'View/css/telaAvaliador.css' ?>">

    <script>

    </script>
    <style>
        .fonteFecintec {
            width: unset;
        }
    </style>
    <style>

    </style>
</head>

<body style="background-color: #f5f5f5">

    <!-- Header -->
    <?php
    include __DIR__ . '/../fragments/header.php';
    ?>

    <?php
    if (isset($_GET['msg']) || !empty($_GET['msg'])) {
        echo "<script> alert('" . $_GET['msg'] . "'); </script>";
    }
    ?>

    <main class="mx-auto main">



        <div>
            <a href="./telaCredenciamento.php">
                <button type="button" class="button verde" style="left: 15px; margin-bottom: 20px; color: white; font-weight: 400;">
                    Voltar
                </button>
            </a>
        </div>



        <!-- Legenda dos status (avaliação) dos trabalhos -->
        <div id="divLegendaTrabalhos">
            <div class="alinhamento mt-5 mb-4">
                <!-- Título da Caixa -->
                <h1 class="legendaTitulo upperFont negrito px-1 elementoFonte">Legenda</h1>

                <!-- Borda da caixa -->
                <div class="legendaBorda mb-3" style="margin-top: 18px;">
                    <div class="my-2" style="display: flex; flex-direction: row; align-items: center;">
                        <?= "<img src=" . absolutePathImg . "notCheck.png" . " alt='Icone de presenca' width='30px'>" ?>
                        <p class="elementoFonte" style="margin-left: 10px;">Ausência</p>
                    </div>

                    <div class="my-2" style="display: flex; flex-direction: row; align-items: center;">
                        <?= "<img src=" . absolutePathImg . "check.png" . " alt='Icone de presenca' width='30px'>" ?>
                        <p class="elementoFonte" style="margin-left: 10px;">Presença</p>
                    </div>

                </div>
            </div>
        </div>


        <!-- Título -->
        <div class="alinhamento m-5">

            <!-- Função para imprimir o nome do trabalho? -->
            <h1 class="negrito upperFont has-text-centered">
                <?php echo '<strong>[' . $_GET['idTrabalho'] . '] </strong>' . $_GET['nomeTrabalho'] . '';
                ?>
            </h1>
        </div>


        <div style="justify-content: center;
    display: flex;">
            <table class="table is-bordered is-striped is-narrow is-hoverable" style="width: 350px;">
                <!-- Cabeçalho da Tabela -->
                <thead class="verde">
                    <!-- Linha com Trabalhos | Status -->
                    <tr>
                        <th align="center" class="upperFont negrito is-size-6 has-text-white">Estudante(s)</th>
                        <th align="center" class="upperFont negrito is-size-6 has-text-white">Presença</th>
                    </tr>
                </thead>

                <!-- Corpo da Tabela -->
                <tbody class="cinzaTabela">
                    <?php

                    $idTrabalhosEstudantes = $_GET['id'];

                    $estudantes = buscarEstudantes($idTrabalhosEstudantes);

                    foreach ($estudantes as $estudante) {
                    ?>

                        <tr>
                            <td>
                                <?= "<strong>[" . $estudante['id_estudante'] . "]</strong> " . $estudante['nome'] ?>
                            </td>

                            <td align="center" style="vertical-align: middle;">
                                <?php
                                // if nao presenca = 0
                                if (!verificaPresencaEstudante($estudante['id_estudante'], $idTrabalhosEstudantes)) {
                                    echo '<a href="./../../Service/processaEstudante.php?act=presenca&id=' . $estudante['id_estudante'] . '&nome=' . $estudante['nome'] . '&id_trabalho=' . $idTrabalhosEstudantes . '&nomeTrabalho=' . $_GET['nomeTrabalho'] .'" onclick="return confirm(\'Você tem certeza que quer atribuir presença ao estudante ' . $estudante['nome'] . '?\')">';
                                    echo "<img src=" . absolutePathImg . "notCheck.png" . " alt='Icone de presenca' width='20px'>";
                                    echo "</a>";
                                } else {
                                    echo "<img src=" . absolutePathImg . "check.png" . " alt='Icone de presenca' width='20px'>";
                                }
                                ?>
                            </td>

                        </tr>

                    <?php } ?>

                </tbody>
            </table>


        </div>

        <div style="justify-content: center;
    display: flex; margin: 10px; margin-bottom: 50px;">
            <table class="table is-bordered is-striped is-narrow is-hoverable" style="width: 350px;">
                <!-- Cabeçalho da Tabela -->
                <thead class="verde">
                    <!-- Linha com Trabalhos | Status -->
                    <tr>
                        <th align="center" class="upperFont negrito is-size-6 has-text-white">Orientador(es)</th>
                        <th align="center" class="upperFont negrito is-size-6 has-text-white">Presença</th>
                    </tr>
                </thead>

                <!-- Corpo da Tabela -->
                <tbody class="cinzaTabela">
                    <?php


                    $orientadores = buscarOrientadores($idTrabalhosEstudantes);

                    foreach ($orientadores as $orientador) {
                    ?>

                        <tr>
                            <td>
                                <?= "<strong>[" . $orientador['id'] . "]</strong> " . $orientador['nome'] ?>
                            </td>

                            <td align="center" style="vertical-align: middle;">
                                <?php
                                // if nao presenca = 0
                                if (!verificaPresencaOrientador($orientador['id'])) {
                                    echo '<a href="./../../Service/processaOrientador.php?act=presenca&id=' . $orientador['id'] . '&nome=' . $orientador['nome'] . '&id_trabalho=' . $idTrabalhosEstudantes . '&nomeTrabalho=' . $_GET['nomeTrabalho'] .'" onclick="return confirm(\'Você tem certeza que quer atribuir presença ao estudante ' . $orientador['nome'] . '?\')">';
                                    echo "<img src=" . absolutePathImg . "notCheck.png" . " alt='Icone de presenca' width='20px'>";
                                    echo "</a>";
                                } else {
                                    echo "<img src=" . absolutePathImg . "check.png" . " alt='Icone de presenca' width='20px'>";
                                }
                                ?>
                            </td>

                        </tr>

                    <?php } ?>

                </tbody>
            </table>


        </div>
    </main>

</body>

<!-- Footer -->
<?php
include absolutePath . 'View/fragments/footer.php';
?>

</html>

<script>
    contarRegistros();
</script>

<?php
// } else {
//     echo "Você não tem permissão para acessar esta página.";
//     header("Refresh:2; URL=../avaliador/login.php");
// }
// } else {
//     echo "Você não tem permissão para acessar esta página.";
//     header("Refresh:2; URL=../avaliador/login.php");
// }

?>