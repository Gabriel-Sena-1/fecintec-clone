<?php


//session_start();

include_once(dirname(dirname(__DIR__))."/Controller/loginController.php");

if (isset($_SESSION) && !empty($_SESSION) && verificaLogado($_SESSION['usuario'], 1)) {

    include_once __DIR__ . '/../fragments/paths.php';
    require_once __DIR__ . '/../../Util/conectaPDO.php';
    require_once __DIR__ . '/../../Controller/trabalhoController.php';


?>
    <!DOCTYPE html>
    <html lang="en" style="background-color: #f5f5f5;">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../img/IconFCT.png" type="image/x-icon">
        <title>Resumo dos Trabalhos</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
        <link rel="stylesheet" href=<?php require_once './../fragments/paths.php';
                                    echo absolutePath . "View/css/estilo.css"; ?>>
        <link rel="stylesheet" href="<?php echo absolutePath . 'View/css/telaAvaliador.css' ?>">

        <style>
            .table-container {
                overflow: auto !important;
                overflow-scrolling: touch !important;
            }

            @media screen and (max-width: 850px) {
                .menuzinho {
                    width: 100% !important;
                }

                table tr td {
                    vertical-align: middle !important;
                }
            }
        </style>






        <?php
        function manterPrimeirasTresLetras($nome)
        {
            if ($nome === "CHSAL - Ciências Humanas; Sociais Aplicadas e Linguística") {
                $primeirasTresLetras = substr($nome, 0, 5);
                return $primeirasTresLetras;
            } else
                $primeirasTresLetras = substr($nome, 0, 4);
            return $primeirasTresLetras;
        }
        ?>

    </head>

    <body>

        <?php
        include __DIR__ . '/../fragments/header.php';
        ?>

        <main class="alinhamento">



            <div id="divLegendaTrabalhos">

                <div style="display: flex; justify-content: space-around; margin: 20px 0px;">
                    <a href="./graficos.php" style="align-items: unset;">
                        <button type="button" class="button verde is-medium" style="margin-bottom: 20px; color: white;">
                            Gráficos
                        </button>
                    </a>

                    <a href="#" onclick="voltar()" style="align-items: unset;">
                        <button type="button" class="button verde is-medium" style="margin-bottom: 20px; color: white;">
                            Voltar
                        </button>
                    </a>
                </div>
                <!-- Informações sobre as quantidades de trabalhos com determinado status -->

                <div class="alinhamento mt-5 mb-4">
                    <!-- Título da Caixa -->
                    <h1 class="legendaTitulo upperFont negrito px-1 elementoFonte">Informações</h1>

                    <!-- Parte em php responsável por pegar as Informações -->
                    <?php
                    $trabs = buscarTrabalhoSaguao();
                    $verde = 0;
                    $cinza = 0;
                    $amarelo = 0;
                    $vermelho = 0;

                    foreach ($trabs as $trab) {
                        //* Se já tiver avaliado
                        if (countAvaliacoes($trab['id']) >= 3) {
                            $verde++;
                        }

                        //* Se tiver duas avaliações (incompleto)
                        else if (countAvaliacoes($trab['id']) == 2) {
                            $amarelo++;
                        } else if (countAvaliacoes($trab['id']) == 1) {
                            $cinza++;
                        }

                        //* Se tiver menos de duas avaliações (0 ou 1 avaliação, práticamente não avaliado) / com zero avaliações
                        else if (countAvaliacoes($trab['id']) == 0) {
                            $vermelho++;
                        }
                    }
                    ?>

                    <!-- Borda da caixa -->
                    <div class="legendaBorda mb-3" style="margin-top: 18px;">

                        <!-- Elementos da caixa -->
                        <div class="my-2">
                            <p class="elementoFonte" style="margin-left: 10px;">Quantidade de trabalhos avaliados:
                                <?php echo $verde; ?>
                            </p>
                        </div>

                        <div class="my-2">
                            <p class="elementoFonte" style="margin-left: 10px;">Quantidade de trabalhos com avaliação
                                incompleta (2 avaliações):
                                <?php echo $amarelo; ?>
                            </p>
                        </div>

                        <div class="my-2">
                            <p class="elementoFonte" style="margin-left: 10px;">Quantidade de trabalhos com avaliação
                                incompleta (1 avaliação):
                                <?php echo $cinza; ?>
                            </p>
                        </div>

                        <div class="my-2">
                            <p class="elementoFonte" style="margin-left: 10px;">Quantidade de trabalhos não avaliados:
                                <?php echo $vermelho; ?>
                            </p>
                        </div>

                    </div>

                </div>

                <!-- Legenda das áreas dos trabalhos -->
                <div class="alinhamento mt-5 mb-4">
                    <!-- Título da Caixa -->
                    <h1 class="legendaTitulo upperFont negrito px-1 elementoFonte">Áreas</h1>

                    <!-- Borda da caixa -->
                    <div class="legendaBorda mb-3" style="margin-top: 18px;">

                        <div class="my-2" style="display: flex; flex-direction: row;">
                            <p class="elementoFonte" style="margin-left: 10px;">CAE - Ciências Agrárias e Engenharias</p>
                        </div>

                        <div class="my-2" style="display: flex; flex-direction: row;">
                            <p class="elementoFonte" style="margin-left: 10px;">CBS - Ciências Biológicas e da Saúde</p>
                        </div>

                        <div class="my-2" style="display: flex; flex-direction: row;">
                            <p class="elementoFonte" style="margin-left: 10px;">CET - Ciências Exatas e da Terra</p>
                        </div>

                        <div class="my-2" style="display: flex; flex-direction: row;">
                            <p class="elementoFonte" style="margin-left: 10px;">CHSAL - Ciências Humanas; Sociais Aplicadas e Linguística</p>
                        </div>

                        <div class="my-2" style="display: flex; flex-direction: row;">
                            <p class="elementoFonte" style="margin-left: 10px;">MDIS - Multidisciplinar</p>
                        </div>

                    </div>
                </div>

                <!-- Legenda dos status (avaliação) dos trabalhos -->
                <div class="alinhamento mt-5 mb-4">
                    <!-- Título da Caixa -->
                    <h1 class="legendaTitulo upperFont negrito px-1 elementoFonte">Legenda</h1>

                    <!-- Borda da caixa -->
                    <div class="legendaBorda mb-3" style="margin-top: 18px;">

                        <div class="my-2" style="display: flex; flex-direction: row;">
                            <div class="bolinhaStatus bolinhaMaior verdeStatus m-2"></div>
                            <p class="elementoFonte" style="margin-left: 10px;">Avaliação Completa</p>
                        </div>

                        <div class="my-2" style="display: flex; flex-direction: row;">
                            <div class="bolinhaStatus bolinhaMaior amareloStatus m-2"></div>
                            <p class="elementoFonte" style="margin-left: 10px;">Duas Avaliações</p>
                        </div>

                        <div class="my-2" style="display: flex; flex-direction: row;">
                            <div class="bolinhaStatus bolinhaMaior laranjaStatus m-2"></div>
                            <p class="elementoFonte" style="margin-left: 10px;">Uma Avaliação</p>
                        </div>

                        <div class="my-2" style="display: flex; flex-direction: row;">
                            <div class="bolinhaStatus bolinhaMaior vermelhoStatus m-2"></div>
                            <p class="elementoFonte" style="margin-left: 10px;">Nenhuma Avaliação</p>
                        </div>

                    </div>
                </div>



                <!-- Filtro que vai para a pagina resumoTrabalho  -->
                <script>
                    function filtro(textoFiltro) {

                        // Obtem todas as linhas da tabela 
                        var lista = document.querySelectorAll('tbody tr');

                        // Obtem ref. dos checkboxes de ensino medio e ensino fundamental
                        var checkEM = document.getElementById('checkEM');
                        var checkEF = document.getElementById('checkEF');

                        // Obtem ref. dos checkboxes status (verde. amarelo, vermelho)
                        var checkGreen = document.getElementById('checkGreen');
                        var checkYellow = document.getElementById('checkYellow');
                        var checkRed = document.getElementById('checkRed');
                        var checkLaranja = document.getElementById('checkLaranja');

                        for (let i = 0; i < lista.length; i++) {
                            const element = lista[i];
                            var textoLinha = element.innerText;
                            element.style.display = '';

                            textoLinha = textoLinha.toLowerCase();
                            var filt = textoFiltro.toLowerCase();

                            // Obtem categoria da celula
                            var categoriaLinha = element.querySelector('td:nth-child(4)');
                            var categoriaTexto = categoriaLinha.textContent.trim();

                            // obtem status da celula
                            var status = element.querySelector('td:nth-child(5) .bolinhaStatus');
                            var verdeStatus = status.classList.contains("verdeStatus");
                            var amareloStatus = status.classList.contains("amareloStatus");
                            var vermelhoStatus = status.classList.contains("vermelhoStatus");
                            var laranjaStatus = status.classList.contains("laranjaStatus");

                            if (
                                (textoLinha.includes(filt) || filt === '') && //verifica se o que tem na barra bate com oque tem na descrição da celula ou se esta vazia

                                ((!checkEM.checked && !checkEF.checked) || (checkEM.checked && categoriaTexto === "EM") || (checkEF.checked && categoriaTexto === "EF")) && //verifica se check ensino esta checado e se estiver compara com categoria da celula

                                ((!checkGreen.checked && !checkYellow.checked && !checkRed.checked) || (checkGreen.checked && verdeStatus) || (checkYellow.checked && amareloStatus) || (checkRed.checked && vermelhoStatus) || (checkLaranja.checked && laranjaStatus)) // verifica se chekc status esta funcionando e se estiver compara com o status da celula

                            ) {
                                element.style.display = '';
                            } else {
                                element.style.display = 'none';
                            }
                        }
                    }


                    function checkFiltro() {
                        // Obtem todas as linhas da tabela 
                        var lista = document.querySelectorAll('tbody tr');

                        // Obtem ref. dos checkboxes de ensino medio e ensino fundamental
                        var checkEM = document.getElementById('checkEM');
                        var checkEF = document.getElementById('checkEF');

                        // Obtem ref. dos checkboxes status (verde. amarelo, vermelho)
                        var checkGreen = document.getElementById('checkGreen');
                        var checkYellow = document.getElementById('checkYellow');
                        var checkRed = document.getElementById('checkRed');
                        var checkLaranja = document.getElementById('checkLaranja');

                        // Obtem texto que esta na barra de busca
                        var textoBusca = document.getElementById("filtroInput").value;

                        textoBusca = textoBusca.toLowerCase();

                        for (let index = 0; index < lista.length; index++) {
                            const element = lista[index];
                            var textoLinha = element.innerText;

                            // obtem categoria da celula 
                            var categoriaLinha = element.querySelector('td:nth-child(4)');
                            var categoriaTexto = categoriaLinha.textContent.trim();

                            // obtem status da celula
                            var status = element.querySelector('td:nth-child(5) .bolinhaStatus');
                            var verdeStatus = status.classList.contains("verdeStatus");
                            var amareloStatus = status.classList.contains("amareloStatus");
                            var vermelhoStatus = status.classList.contains("vermelhoStatus");
                            var laranjaStatus = status.classList.contains("laranjaStatus");


                            textoLinha = textoLinha.toLowerCase();

                            if (textoLinha.includes(textoBusca) && //verifica se o que tem na barra bate com oque tem na descrição da celula 

                                ((!checkEM.checked && !checkEF.checked) || (checkEM.checked && categoriaTexto === "EM") || (checkEF.checked && categoriaTexto === "EF")) && //verifica se check ensino esta checado e se estiver compara com categoria da celula

                                
                                ((!checkGreen.checked && !checkYellow.checked && !checkRed.checked && !checkLaranja.checked) || (checkGreen.checked && verdeStatus) || (checkYellow.checked && amareloStatus) || (checkRed.checked && vermelhoStatus) || (checkLaranja.checked && laranjaStatus)) // verifica se chekc status esta funcionando e se estiver compara com o status da celula

                            ) {
                                element.style.display = '';
                            } else {
                                element.style.display = 'none';
                            }
                        }
                    }

                    
                    var xhttp = new XMLHttpRequest();
                    cont = 0;

                    // Exibe status de avaliação de avaliadores do trabalho em questão
                    function statusAvaliador(id){
                        xhttp.open('GET', './../../Controller/avaliadorController.php?act=status&id=' + id, true);

                        xhttp.onreadystatechange = function(){
                            if (this.readyState === 4 && this.status === 200) {
                                if (cont != id) {
                                    var imprime = document.getElementById('exibe');
                                    imprime.innerHTML = xhttp.responseText;

                                    console.log(imprime);
                                    console.log('Pop-up status funcionando');

                                    cont = id;
                                } else if (cont == id){
                                    fechaPop();
                                }
                                
                            }
                        };

                        xhttp.send();
                    }

                    function fechaPop(){

                        var popID_status = document.getElementById('popUp');

                        if(popID_status.style.display == 'block'){
                            popID_status.style.display = 'none';

                            cont = 0;
                        }
                    }
                </script>

                <?php
                if (isset($_GET['msg']) || !empty($_GET['msg'])) {
                    echo "<script> alert('" . $_GET['msg'] . "'); </script>";
                }
                ?>

                <!-- Contêiner para exibir informações do pop-up -- PopUp vem do avaliadorController - statusDados -->
                <div id="exibe"></div>


                <!-- Legenda dos status (avaliação) dos trabalhos -->
                <div class="alinhamento mt-5 mb-4">
                    <div style="">
                        <!-- Barra de busca -->
                        <input type="text" class="input" id="filtroInput" placeholder="Coloque o que deseja filtrar" onkeypress="filtro(this.value)" onkeyup="filtro(this.value)">
                        <!-- tentando filtrar por categoria e status-->
                        <div style="margin-bottom: 2rem; display:flex; flex-direction: row; justify-content: space-between;">

                            <div>
                                <label class="checkbox" style>
                                    <input type="checkbox" onchange="checkFiltro();" id="checkEM" style="">
                                    Ensino Médio
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox" onchange="checkFiltro();" id="checkEF" style="">
                                    Ensino Fundamental
                                </label>
                            </div>
                            <div>
                                <div style="display:flex; margin-top: 0.2rem; margin-left:2rem;">
                                    <label class="checkbox" style="margin-right: 0.2rem;">
                                        <div class="bolinhaStatus verdeStatus" style="margin-right: 0.2rem;"></div>
                                        <input type="checkbox" onchange="checkFiltro();" id="checkGreen" style="">

                                    </label>
                                    <label class="checkbox" style="margin-right: 0.2rem;">
                                        <div class="bolinhaStatus amareloStatus" style="margin-right: 0.2rem;"></div>
                                        <input type="checkbox" onchange="checkFiltro();" id="checkYellow" style="">

                                    </label>
                                    <label class="checkbox" style="margin-right: 0.2rem;">
                                        <div class="bolinhaStatus laranjaStatus" style="margin-right: 0.2rem;"></div>
                                        <input type="checkbox" onchange="checkFiltro();" id="checkLaranja" style="">

                                    </label>
                                    <label class="checkbox" style="margin-right: 0.2rem;">
                                        <div class="bolinhaStatus vermelhoStatus" style="margin-right: 0.2rem;"></div>
                                        <input type="checkbox" onchange="checkFiltro();" id="checkRed" style="">

                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <script>
                const voltar = () => {
                    event.preventDefault();
                    history.back();
                };

                const redimensionarTexto = function(element) {
                    if (element.innerHTML.length >= 120) {
                        console.log('deu certo!');
                        element.innerHTML = element.innerHTML.slice(0, 120) + '...';
                    }
                };
            </script>

            <div class="table-container" id="divTable" style="margin-top: -40px;">
                <table class="table is-bordered is-striped is-narrow is-hoverable mx-5 mb-2">
                    <!-- Cabeçalho da Tabela -->
                    <thead class="verde">
                        <!-- Linha com Trabalhos | Status -->
                        <tr>
                            <th class="upperFont alinhamento negrito is-size-6 has-text-white">Todos os Trabalhos</th>
                            <th class="upperFont negrito is-size-6 has-text-white">Área</th>
                            <th class="upperFont negrito is-size-6 has-text-white">Orientador</th>
                            <th class="upperFont negrito is-size-6 has-text-white">Nivel</th>
                            <th class="upperFont negrito is-size-6 has-text-white">Status</th>
                            <th class="upperFont negrito is-size-6 has-text-white">Editar</th>
                        </tr>
                    </thead>

                    <!-- Corpo da Tabela -->
                    <tbody class="cinzaTabela">

                        <!-- Repetição para impressão de todas os trabalhos atribuidos a este Avaliador -->
                        <?php //Aqui tem que ter um for de repetição para imprimir os nomes dos trabalhos 
                        ?>

                        <!-- Repetição para impressão de todas os trabalhos e seus atributos -->
                        <?php
                        $trabalhos = buscarTrabalhoSaguao();

                        foreach ($trabalhos as $atributos) {
                        ?>

                            <tr>

                                <td>
                                    <a class="has-text-dark" href="<?php echo absolutePath . 'View/adm/alterarAvaliador.php?id=' . base64_encode($atributos['id']) ?>">
                                        <p>
                                            <?= "<strong>[" . $atributos['id'] . "]</strong> " . $atributos['titulo'] ?>
                                        </p>
                                    </a>
                                </td>

                                <td>
                                    <?= manterPrimeirasTresLetras($atributos['area']) ?>
                                </td>

                                <td>
                                    <?php echo $atributos['nome_orientador'] ?>
                                </td>

                                <td>
                                    <?php echo $atributos['nivel'] ?>
                                </td>

                                <td onclick="statusAvaliador(<?php echo $atributos['id']; ?>);" align="center" style="vertical-align: middle;">

                                    <!-- TRES BOLINHAS COM CADA AVALIADOR -->
                                    <?php $vazio = countAvaliacoes($atributos['id']); ?>

                                    <div  class="bolinhaStatus 
                                        <?php
                                        if ($vazio >= 3) {
                                            echo 'verdeStatus';
                                        } else if ($vazio == 2) {
                                            echo 'amareloStatus';
                                        } else if ($vazio == 1) {
                                            echo 'laranjaStatus';
                                        } else if ($vazio < 1) {
                                            echo 'vermelhoStatus';
                                        }
                                        ?>">
                                    </div>
                                </td>


            </div>
            </td>

            <td>
                <div style="text-align: center;">
                    <a href="<?php echo absolutePath . 'View/adm/alterarAvaliador.php?id=' . base64_encode($atributos['id']) ?>">
                        <img src="<?php echo absolutePathImg . "editicon.png" ?>" alt="Icone edição" width="25px">
                    </a>
                </div>
            </td>
            </tr>

        <?php } ?>

        <?php //Aqui acaba o for 
        ?>

        </tbody>
        </table>

        </div>


        <!-- MODAL -->

        </main>

        <?php
        include __DIR__ . './../fragments/footer.php';
        ?>
    </body>


    </html>

<?php } else {
    echo "Você não tem permissão para acessar esta página.";
    header("Refresh:2; URL=../avaliador/login.php");
}

?>