<?php
//session_start();

include_once(dirname(dirname(__DIR__))."/Controller/loginController.php");

if (isset($_SESSION) && !empty($_SESSION) && verificaLogado($_SESSION['usuario'], 1)) //! ARRUMAR PÓS FASE DE TESTES
{ //! SAGUÃO TEM -> TRABALHOS NÃO AVALIADOS / MONITORIA / BOTÃO DISTRIBUIR 

    require_once('../fragments/paths.php');
    require_once(__DIR__ . '/../../Controller/AvaliadorController.php');

    ?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../img/IconFCT.png" type="image/x-icon">
        <title>Listar Avaliadores</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
        <link rel="stylesheet" href=<?php echo absolutePath . "View/css/estilo.css" ?>>
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

            function fechaPop(acao) {
                var importar = document.getElementById('importar');
                var exportar = document.getElementById('exportar');

                var popID_importar = document.getElementById('popUp_Importar');
                var popID_exportar = document.getElementById('popUp_Exportar');

                if (acao == 'importar' && popID_importar.style.display == 'flex') { //verifica se foi o importar ou exportar que chamou a função
                    popID_importar.style.display = 'none';
                } else if (acao == 'exportar' && popID_exportar.style.display == 'flex') {//verifica se foi o exportar ou exportar que chamou a função
                    popID_exportar.style.display = 'none';
                }

                //* Faz desaparecer a div que escurece o fundo
                document.getElementById('ofuscaTela').style.display = 'none';

            }


            function popUpInfos(acao) {

                var importar = document.getElementById('importar');

                var popID_importar = document.getElementById('popUp_Importar');

                if (acao == 'importar' && popID_importar.style.display == 'none') { //verifica se foi o importar ou exportar que chamou a função
                    document.getElementById('ofuscaTela').style.display = 'unset';
                    popID_importar.style = 'width: 500px; height: 200px; display: flex; z-index: 2; text-align: center; position: absolute; flex-direction: column; left: 33%; top: 15vw;';
                }

            }
        </script>

        <style>
            /* Tamanho da Tabela do listarAvaliadores() */
            @media screen and (max-width: 800px) {

                #responsivo {
                    width: 100% !important;
                }

            }
        </style>

    </head>


    <?php
    include __DIR__ . '/../fragments/header.php';
    ?>



    <div id="ofuscaTela" style="display: none;">
        <div style="width: 100%; height: 100%; background-color: black; position: fixed; z-index: 1; opacity: 0.4;">
        </div>
    </div>


    <body>

        <?php
        if (isset($_GET['msg']) || !empty($_GET['msg'])) {
            echo "<script> alert('" . $_GET['msg'] . "'); </script>";
        }
        ?>

        <div class="notification" style="display: none;" id="popUp_Importar">
            <button class="delete" onclick="fechaPop('importar')"></button>

            <!-- COLOCAR UM FOR FAZENDO A CONSULTA DOS TRABALHOS DO AVALIADOR X E APRESENTANDO 
                 atenção a linkagem
                 atenção a condição para a div aparecer
            -->
            <div>

            <?php 
            //$trabalhosDoAvaliador = listarTrabalhosPorAvaliador($_GET['id']);
            //print_r($trabalhosDoAvaliador);
            $x = 4 /* Tamanho da lista de trabalhos d
            o avaliador X */;

            echo "<ul>";
            for ($i=0; $i < $x; $i++) { 
                echo'<li style="margin: 8px;">
                <a class="" href="./" style="text-decoration: none; font-size: 100%; font-weight: 600; width: 80%; height: 5rem;">
                    Trabalho de Bla bla bla bla
                </a>
                </li>';
            }
            echo "</ul>";
            ?>
            </div>

        </div>

        <?=listarAvaliadores()?>

        <?php
        include __DIR__ . '/../fragments/footer.php';
        ?>

        <script>

            function contarRegistros() {
                var lista = document.querySelectorAll('tbody tr');
                var qtde = 0;

                for (let index = 0; index < lista.length; index++) {
                    const element = lista[index];

                    if (element.style.display !== "none") {
                        qtde++;
                    }

                }

                //console.log(qtde);

                if (qtde < 10) {
                    document.body.style.position = 'relative';
                    document.body.style.minHeight = '100vh';

                    var footer = document.querySelector('footer');
                    footer.style.position = 'absolute';
                }

                else {
                    var footer = document.querySelector('footer');
                    footer.style.position = 'unset';
                }
            }

            var valorFiltro = document.getElementById('filtroInput');
            valorFiltro.addEventListener('keyup', contarRegistros);

            contarRegistros();

        </script>

    </body>

    </html>


    <?php
} else {
    echo "Você não tem permissão para acessar esta página.";
    header("Refresh:2; URL=../avaliador/login.php");
}

?>