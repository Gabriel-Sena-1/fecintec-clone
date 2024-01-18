<script>
    function updateProgress() {
        $("#progress-container").load("loader.php");
    }
    setInterval(updateProgress, 5000);
</script>


<?php
//session_start();

include_once(dirname(dirname(__DIR__))."/Controller/loginController.php");

if (isset($_SESSION) && !empty($_SESSION) && verificaLogado($_SESSION['usuario'], 1)) {


    require_once('../fragments/paths.php');
    require_once(__DIR__ . '/../../Controller/AvaliadorController.php');
    require_once(__DIR__ . '/../../Controller/TrabalhoController.php');


    $quantTrab = contaTodosTrabalhos()[0][0];
    $quantAvaliadores = contaTodosAvaliadores()[0][0];

    // contaDesclassificados()[0]['COUNT(*)'];
    $trabs = buscarTrabalhoSaguao();
    $verde = 0;
    $todosTrab = contaTodosTrabalhos()[0]['COUNT(*)'];
    foreach ($trabs as $trab) {
        if (countAvaliacoes($trab['id']) >= 3) {
            $verde++;
        }
    }

    if (file_exists("../../infoDistribuicao.json")) {
        //* Se existe ele pega o conteúdo que está no arquivo e guarda na $arraySerializada
        $arraySerializada = file_get_contents("../../infoDistribuicao.json");

        //* Meio que "desformata" para array
        $arrayAvaliadores = json_decode($arraySerializada, true);

        //* Separa os arrays
        $mediaPorArea = $arrayAvaliadores["mediaPorArea"];


        /* echo '<pre>';
        echo '</pre>';  */
    }

    $area1 = count(trabalhosArea(1));
    $area2 = count(trabalhosArea(2));
    $area3 = count(trabalhosArea(3));
    $area4 = count(trabalhosArea(4));
    $area5 = count(trabalhosArea(5));



    $avaliadorArea1 = count($arrayAvaliadores['avaliadoresPorArea'][1]);
    $avaliadorArea2 = count($arrayAvaliadores['avaliadoresPorArea'][2]);
    $avaliadorArea3 = count($arrayAvaliadores['avaliadoresPorArea'][3]);
    $avaliadorArea4 = count($arrayAvaliadores['avaliadoresPorArea'][4]);
    $avaliadorArea5 = count($arrayAvaliadores['avaliadoresPorArea'][5]);

    $mediaArea1 = ceil($mediaPorArea[1] * 3);
    $mediaArea2 = ceil($mediaPorArea[2] * 3);
    $mediaArea3 = ceil($mediaPorArea[3] * 3);
    $mediaArea4 = ceil($mediaPorArea[4] * 3);
    $mediaArea5 = ceil($mediaPorArea[5] * 3);

?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../img/IconFCT.png" type="image/x-icon">
        <title>Gráficos da Feira</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
        <link rel="stylesheet" href=<?php echo absolutePath . "View/css/estilo.css" ?>>

        <style>
            body {
                -webkit-font-smoothing: antialised;
                -moz-osx-font-smoothing: grayscale;
                text-rendering: optimizeLegibility;
                font-feature-settings: "cv11", "salt", "ss01", "ss03"
                    , "cv01", "cv02", "cv03", "cv04", "cv05",
                    "cv06", "cv09", "cv10", ;
            }

            rect {
                fill: #f5f5f5;
            }


            #progress-container {
                width: 300px;
                border: 1px solid #ccc;
                height: 30px;
            }

            #progress-bar {
                width: 0;
                height: 100%;
                background-color: #4CAF50;
            }

            footer {
                display: inline-block !important;
            }
        </style>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Task', 'Hours per Day'],
                    ['CAE - Ciências Agrárias e Engenharias', <?= $area1 ?>],
                    ['CBS - Ciências Biológicas e da Saúde', <?= $area2 ?>],
                    ['CET - Ciências Exatas e da Terra', <?= $area3 ?>],
                    ['CHSAL - Ciências Humanas; Sociais Aplicadas e Linguística', <?= $area4 ?>],
                    ['MDIS - Multidisciplinar', <?= $area5 ?>]
                ]);

                var options = {
                    title: 'Trabalhos na FECINTEC por Área de conhecimento',
                    'height': 300,
                    'width': 500,
                    pieHole: 0.2,
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                chart.draw(data, options);
            }
        </script>

        <script type="text/javascript">
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Task', 'Hours per Day'],
                    ['CAE - Ciências Agrárias e Engenharias', <?= $avaliadorArea1 ?>],
                    ['CBS - Ciências Biológicas e da Saúde', <?= $avaliadorArea2 ?>],
                    ['CET - Ciências Exatas e da Terra', <?= $avaliadorArea3 ?>],
                    ['CHSAL - Ciências Humanas; Sociais Aplicadas e Linguística', <?= $avaliadorArea4 ?>],
                    ['MDIS - Multidisciplinar', <?= $avaliadorArea5 ?>]
                ]);

                var options = {
                    title: 'Avaliadores na FECINTEC por Área de conhecimento',
                    pieHole: 0.2,
                    'height': 300,
                    'width': 500,
                    'legend': 'left',
                    backgroundColor: '#CFC3F8',
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

                chart.draw(data, options);
            }

            // window.onresize = diminui();

            // function diminui() {

            // }

            // window.dispatchEvent(new Event('resize'));
        </script>

        <script type="text/javascript">
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Task', 'Hours per Day'],
                    ['CAE - Ciências Agrárias e Engenharias', <?= $mediaArea1 ?>],
                    ['CBS - Ciências Biológicas e da Saúde', <?= $mediaArea2 ?>],
                    ['CET - Ciências Exatas e da Terra', <?= $mediaArea3 ?>],
                    ['CHSAL - Ciências Humanas; Sociais Aplicadas e Linguística', <?= $mediaArea4 ?>],
                    ['MDIS - Multidisciplinar', <?= $mediaArea5 ?>]
                ]);

                var options = {
                    title: 'Média de trabalhos por Avaliador por ÁREA DE CONHECIMENTO',
                    pieHole: 0.2,
                    'height': 300,
                    'width': 500,
                    'legend': 'left',
                    backgroundColor: '#CFC3F8',
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart3'));

                chart.draw(data, options);
            }

            // window.onresize = diminui();

            // function diminui() {

            // }

            // window.dispatchEvent(new Event('resize'));
        </script>
        <script>
            
            let currentValue = 0;

            function incrementProgress() {
                const progressBar = document.getElementById('progress-bar');
                const incrementValue = (100 * (<?= $verde ?> / <?= $todosTrab ?>)).toFixed(2);

                if (!isNaN(incrementValue)) {
                    currentValue += incrementValue;
                    if (currentValue > 100) {
                        currentValue = 100;
                    }
                    progressBar.style.width = currentValue + '%';
                    progressBar.innerHTML = parseFloat(currentValue).toFixed(2) + '%';
                }
            }

            const voltar = () => {
                event.preventDefault();
                history.back();
            };
        </script>

    </head>

    <!-- <style>
        @media screen and (max-width: 800px){

            #botao-voltar-max{
                display: none;
            }
            #botao-voltar-min{
                display: ;
            }
        }
    </style> -->

    <?php
    include __DIR__ . '/../fragments/header.php';
    ?>

    <body onload="incrementProgress();">
        <main>



            <div style="display: flex; flex-direction: column; align-items: center; margin-top: 20px; -webkit-overflow-scrolling: touch; overflow: auto; overflow-y: hidden; max-width: 100%;">
                <h1 style="font-weight: 600;">% Trabalhos avaliados</h1>
                <div id="progress-container">
                    <div id="progress-bar"></div>
                </div>


                <div>
                    <div id="piechart2"></div>
                </div>


                <div>
                    <div id="piechart" style=""></div>
                </div>

                <div>
                    <div id="piechart3" style=""></div>
                </div>

                <a id="botao-voltar-max" href="#" style="align-items: unset; " onclick="voltar()">
                    <button type="button" class="button verde is-medium" style="margin-bottom: 20px; color: white;">
                        Voltar
                    </button>
                </a>

            </div>





        </main>

        <?php
        include __DIR__ . '/../fragments/footer.php';
        ?>
    </body>

    </html>


<?php
} else {
    echo "Você não tem permissão para acessar esta página.";
    header("Refresh:2; URL=../avaliador/login.php");
}

?>