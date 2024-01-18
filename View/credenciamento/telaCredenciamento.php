<?php
// session_start();

// if (!empty($_SESSION) && isset($_SESSION) && isset($_SESSION['credenciamento'])) 
// {
require __DIR__ . '/../../Util/conectaPDO.php';
require __DIR__ . '/../../Controller/trabalhoController.php';
require __DIR__ . '/../../Controller/estudanteController.php';
require __DIR__ . '/../../Controller/orientadorController.php';

// UPDATE credenciamento
// SET kits = (SELECT LENGTH(estudantes) - LENGTH(REPLACE(estudantes, ';', '')) FROM trabalho WHERE trabalho.id = 2) + 1
// WHERE credenciamento.id = 1; UPDATE DOS KITS EM ALGUMA TABELA AI

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/IconFCT.png" type="image/x-icon">
    <title>Credenciamento dos Trabalhos da Feira</title>
    <!-- Links -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php include '../fragments/paths.php';
                                    echo absolutePath . 'View/css/estilo.css'; ?>">
    <link rel="stylesheet" href="<?php echo absolutePath . 'View/css/telaAvaliador.css' ?>">
    <style>
        #divTable {
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin: -1vw 4vw 4vw 4vw;
        }
    </style>
    <script>
        function filtro(textoFiltro) {
            var lista = document.querySelectorAll('tbody tr');


            for (let i = 0; i < lista.length; i++) {
                const element = lista[i];
                var textoLinha = element.innerText;
                element.style.display = '';
                textoLinha = textoLinha.toLowerCase();
                var filt = textoFiltro.toLowerCase();


                if (!textoLinha.includes(filt)) {
                    element.style.display = 'none';
                }

            }
        }

      
    </script>

</head>

<body style="background-color: #f5f5f5">

    <!-- Header -->
    <?php
    include __DIR__ . '/../fragments/header.php';
    ?>

    <main class="mx-auto main">

        <!-- Legenda dos status (avaliação) dos trabalhos -->
        <div id="divLegendaTrabalhos">
            <div class="alinhamento mt-5 mb-4">
                <!-- Título da Caixa -->
                <h1 class="legendaTitulo upperFont negrito px-1 elementoFonte">Legenda</h1>

                <!-- Borda da caixa -->
                <div class="legendaBorda mb-3" style="margin-top: 18px;">
                    <div class="my-2" style="display: flex; flex-direction: row; align-items: center;">
                        <?= "<img src=" . absolutePathImg . "presencaIcon.png" . " alt='Icone de ausência' width='30px'>" ?>
                        <p class="elementoFonte" style="margin-left: 10px;">Ao menos 1 estudante ausente.</p>
                    </div>

                    <div class="my-2" style="display: flex; flex-direction: row; align-items: center;">
                        <?= "<img src=" . absolutePathImg . "presencaIconCheck.png" . " alt='Icone de presenca' width='30px'>" ?>
                        <p class="elementoFonte" style="margin-left: 10px;">Todos os estudantes presentes.</p>
                    </div>

                </div>
            </div>
        </div>

        <div class="table-container" id="divTable">
            <div style="margin: 20px;">
                <input type="text" class="input" id="filtroInput" placeholder="Coloque o que deseja filtrar" onkeypress="filtro(this.value)" onkeyup="filtro(this.value)">
            </div>

            <table class="table is-bordered is-striped is-narrow is-hoverable">
                <!-- Cabeçalho da Tabela -->
                <thead class="verde">
                    <!-- Linha com Trabalhos | Status -->
                    <tr>
                        <th class="upperFont alinhamento negrito is-size-6 has-text-white">Todos os Trabalhos</th>
                        <th align="center" class="upperFont negrito is-size-6 has-text-white">Estudantes</th>
                        <th align="center" class="upperFont negrito is-size-6 has-text-white">Orientadores</th>
                        <th align="center" class="upperFont negrito is-size-6 has-text-white">Presença</th>
                    </tr>
                </thead>

                <!-- Corpo da Tabela -->
                <tbody class="cinzaTabela">
                    <?php
                    $trabalhos = buscarTrabalhoCredenciamento();


                    foreach ($trabalhos as $atributos) {
                        $orientadores = buscarOrientadores($atributos['id']);


                    ?>

                        <tr>
                            <td>
                                <?= "<strong>[" . $atributos['id'] . "]</strong> " . $atributos['titulo'] ?>
                            </td>

                            <td>
                                <?= $atributos['nomes_estudantes'] ?>
                            </td>

                            <?php foreach ($orientadores as $orientador) {
                            ?>
                            <td style="color:<?= verificaPresencaOrientador($orientador['id']) ? 'green' : 'red' ?>;">
                                <?= "<strong>[" . $orientador['id'] . "]</strong> " . $orientador['nome'] ?>
                            </td>

                    <?php } ?>


                    <td align="center" style="vertical-align: middle;">
                        <?php
                        $quantidadeEstudantes = (substr_count($atributos['nomes_estudantes'], "</p>"));

                        if (verificaPresencaEstudantesTrabalho($atributos['id'], $quantidadeEstudantes) && verificaPresencaOrientador($orientador['id'])) {
                            echo "<img src=" . absolutePathImg . "presencaIconCheck.png" . " alt=Icone de presenca width='20px'>";
                        } else {
                            echo '<a href="./telaPresencaEstudantes.php?id=' . $atributos['id'] . '&nomeTrabalho=' . $atributos['titulo'] . '&idTrabalho=' . $atributos['id'] . '&dia=1">';
                            echo "<img src=" . absolutePathImg . "presencaIcon.png" . " alt=Icone de presenca width='20px'>";
                            echo "</a>";
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
<!-- <a href="https://www.flaticon.com/br/icones-gratis/certo" title="certo ícones">Certo ícones criados por Arkinasi - Flaticon</a> -->

</html>


<?php
// } else {
//     echo "Você não tem permissão para acessar esta página.";
//     header("Refresh:2; URL=../avaliador/login.php");
// }

?>