<?php
//session_start();

include_once(dirname(dirname(__DIR__))."/Controller/loginController.php");

if (isset($_SESSION) && !empty($_SESSION) && verificaLogado($_SESSION['usuario'], 1)) {
    ?>
    <!DOCTYPE html>
    <html style="background-color: #f5f5f5" lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../img/IconFCT.png" type="image/x-icon">
        <title>Distribuição - Confirmação</title>
        <!-- Links -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?php include '../fragments/paths.php';
        echo absolutePath . 'View/css/estilo.css';
        $PAGE = 'login.php'; ?>">
        <link rel="stylesheet" href="<?php echo absolutePath . 'View/css/telaAvaliador.css' ?>">
    </head>

    <?php

    include_once __DIR__ . '/../../Controller/trabalhoController.php';
    include_once __DIR__ . '/../../Controller/avaliadorController.php';
    include_once __DIR__ . '/../../Controller/avaliacaoController.php';
    include_once __DIR__ . '/../../Controller/areasController.php';

    $areas = buscarAreas();

    /* echo '<pre>';
    var_dump(buscarAreas());
    echo '</pre>';  */

    //* Verifica se o arquivo infoDistribuicao.json existe
    if (file_exists("../../infoDistribuicao.json")) {
        //* Se existe ele pega o conteúdo que está no arquivo e guarda na $arraySerializada como uma "String", ou seja, é como se estivesse em uma única linha
        $arraySerializada = file_get_contents("../../infoDistribuicao.json");

        //* Meio que "organiza" em formato de array
        $arrayInfo = json_decode($arraySerializada, true);

        //* Separa os arrays de acordo com os identificadores anteriormente definidos
        $arrayAvaliadores = $arrayInfo["avaliadoresPorArea"];
        $mediaPorArea = $arrayInfo["mediaPorArea"];
    }

    /* echo '<pre>';
    print_r($arrayAvaliadores);
    echo '</pre>'; */

    ?>

    <script>

        var xhttp = new XMLHttpRequest();

        // Função para fechar o pop-up
        function fechaPop() {
            var popUp = document.querySelector('#popUp');

            if (popUp.style.display == 'block') {
                popUp.style.display = 'none';
            }

            //* Faz desaparecer a div que escurece o fundo
            document.getElementById('ofuscaTela').style.display = 'none';

        }

        // Função para exibir informações do avaliador
        function popUpInfos(id) {
            xhttp.open('GET', './../../Controller/avaliadorController.php?act=trabVinculados&id=' + id, true);


            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    var imprime = document.getElementById('trabalhosVinculados');
                    imprime.innerHTML = xhttp.responseText;

                    //* Faz aparecer a div que escurece o fundo
                    document.getElementById('ofuscaTela').style.display = 'unset';

                    // console.log(imprime);
                    // console.log('Pop up apresentado.');
                    // location.reload();
                }
            };

            xhttp.send();
        }

    </script>

    <style>
        .ofuscaTela {
            opacity: 0.7;
            background-color: rgba(61, 58, 58, 0.7);
        }
    </style>

    <body>

        <div id="ofuscaTela" style="display: none;">
            <div style="width: 100%; height: 100%; background-color: black; position: fixed; z-index: 1; opacity: 0.4;">
            </div>
        </div>

        <!-- Header -->
        <?php
        include __DIR__ . '/../fragments/header.php';

        if(verificaDistribuicao()){
        ?>

        <!-- Contêiner para exibir informações do pop-up -->
        <div id="trabalhosVinculados"></div>

        <!-- Mensagem caso o login esteja errado -->
        <?php if (isset($_GET['mensagem']) && !empty($_GET['mensagem'])) { ?>

            <div class="alert alert-danger " role="alert">
                <?php echo $_GET['mensagem'] ?>
            </div>

        <?php } ?>

        <main class="mx-auto main">

            <?php
            include absolutePath . "/Util/conectaPDO.php";
            ?>

            <div class="alinhamento">

                <div class="title is-5 my-5" id="fecintec">
                    <h1>Log Distribuição</h1>
                </div>

                <?php
                echo '<div class="mt-5 mb-5">';
                echo '<div class ="alinhamento mb-3">';
                echo '<h1 class="legendaTitulo upperFont negrito px-1" style="font-size: 17px; text-align: center;">Informações Gerais</h1>';
                echo '<div class="legendaBorda mb-4 mt-3">';
                echo '<p class="legendaElementos m-2"> Quantidade total de Trabalhos: ' . contaTodosTrabalhos()[0]['COUNT(*)'] . '</p>';
                echo '<p class="legendaElementos m-2"> Quantidade total de Avaliadores: ' . contaTodosAvaliadores()[0]['COUNT(*)'] . '</p>';
                echo '</div>';
                echo '</div>';

                //TODO: -- Caixa com os desclassificados --
            
                //* Recebe avaliadores desclassificados (que se encaixam nas categoria EF e EM, por isso não podem avaliar
                //* nenhum tipo de trabalho)
                $desclassificados = mostrarDesclassificados();

                echo '<div class ="alinhamento mb-4">';
                echo '<h1 class="legendaTitulo upperFont negrito px-1" style="font-size: 17px; text-align: center;">Desclassificados</h1>';
                echo '<div class="legendaBorda mb-4 mt-3">';

                //* Se vier um array significa que existe(m) avaliador(es) desclassificado(s)
                if (is_array($desclassificados)) {

                    echo '<p class="legendaElementos m-2"> Avaliadores desclassificados: </p>';
                    echo '<ul class="mb-2" style="list-style: unset; margin-left: 40px;">';

                    foreach ($desclassificados as $avaliadores) {
                        echo '<li class="legendaElementos" style="font-size: 14px!important">';
                        echo $avaliadores['nome'];
                        echo '</li>';
                    }

                    echo '</ul>';
                } else { //* Caso contrário apenas mostrará uma mensagem (string) dizendo que não tem avaliadores desclassificados
            
                    echo '<p class="legendaElementos m-2">';
                    echo $desclassificados;
                    echo '</p>';

                }

                echo '</div>';
                echo '</div>';
                echo '</div>';

                //TODO: -- Final da caixa com os desclassificados --
            
                //* Define as arrays especificas, separadas por área e nível
                $trabalhosPorAreaEF = array();
                $trabalhosPorAreaEM = array();

                //* Define uma array que guardará todos os trabalhos separados/organizados por área
                $trabalhosPorArea = array();

                foreach ($areas as $area) {

                    //* Chama a função para encontrar os avaliadores com as maiores e menores quantidades
                    //* Ao chamar essa função deve-se passar como um parametro uma lista de avaliadores (nesse caso por área, já que está pegando esses avaliadores para cada área) e a partir disso será feito uma busca no banco de dados (talvez não seja necessário fazer a busca pelo banco de dados...) para então retornar 4 valores
            
                    /** ----------------------------------------------------------------------------- //
                     * Objeto do avaliador com maior quantidade                                       *
                     * Quantidade de trabalhos atribuídos ao avaliador com a maior quantidade         *
                     * Objeto do avaliador com a segunda maior quantidade                             *
                     * Quantidade de trabalhos atribuídos ao avaliador com a segunda maior quantidade *
                     */// ---------------------------------------------------------------------------- //
            
                    $avaliadorMaisTrab = avaliadorMaisTrab($arrayAvaliadores[$area['id']]);
                    $avaliadorMenosTrab = avaliadorMenosTrab($arrayAvaliadores[$area['id']]);

                    //* Visualização dos avaliadores organizados por área
                    /* echo '<pre>';
                    echo " - ".$area['id']." - ";
                    print_r($arrayAvaliadores[$area['id']]);
                    echo '</pre>'; */

                    /* echo '<pre>';
                    print_r($avaliadorMaisTrab);
                    echo '</pre>'; */

                    //* Chama a função trabalhoArea, que passa por parametro o ID de uma área, para ser feito uma busca no banco de dados de todos os trabalhos da área requerida, guardando no array trabalhosPorArea com a identificação sendo feita pelo ID da área
                    $trabalhosPorArea[$area['id']] = trabalhosArea($area['id']);

                    /* echo '<pre>';
                    print_r($trabalhosPorArea);
                    echo '</pre>'; */

                    //* Roda a lista de $trabalhosPorArea verificando o nível do trabalho de cada área e separando em arrays diferentes (um para EF e outro para EM, dentro dessas arrays serão separados por área)
                    foreach ($trabalhosPorArea[$area['id']] as $trabalho) {
                        if ($trabalho['nivel'] == "EF") {
                            $trabalhosPorAreaEF[$area['id']][] = array(
                                "id_area" => $area['id'],
                                "nivel" => $trabalho['nivel'],
                                "id" => $trabalho["id"],
                                "cpf_coorientador" => $trabalho["cpf_coorientador"],
                                "cpf_orientador" => $trabalho["cpf_orientador"],
                                "descricaoMDIS" => $trabalho["descricaoMDIS"],
                                "email_coorientador" => $trabalho["email_coorientador"],
                                "email_orientador" => $trabalho["email_orientador"],
                                "estudantes" => $trabalho["estudantes"],
                                "nome_coorientador" => $trabalho["nome_coorientador"],
                                "nome_orientador" => $trabalho["nome_orientador"],
                                "titulo" => $trabalho["titulo"],
                                "notaResumo" => $trabalho["notaResumo"],
                                "instituicao" => $trabalho["instituicao"],
                                "ativo" => $trabalho["ativo"],
                                "id_tipo_de_pesquisa" => $trabalho["id_tipo_de_pesquisa"]
                            );
                        } else if ($trabalho['nivel'] == "EM") {
                            $trabalhosPorAreaEM[$area['id']][] = array(
                                "id_area" => $area['id'],
                                "nivel" => $trabalho['nivel'],
                                "id" => $trabalho["id"],
                                "cpf_coorientador" => $trabalho["cpf_coorientador"],
                                "cpf_orientador" => $trabalho["cpf_orientador"],
                                "descricaoMDIS" => $trabalho["descricaoMDIS"],
                                "email_coorientador" => $trabalho["email_coorientador"],
                                "email_orientador" => $trabalho["email_orientador"],
                                "estudantes" => $trabalho["estudantes"],
                                "nome_coorientador" => $trabalho["nome_coorientador"],
                                "nome_orientador" => $trabalho["nome_orientador"],
                                "titulo" => $trabalho["titulo"],
                                "notaResumo" => $trabalho["notaResumo"],
                                "instituicao" => $trabalho["instituicao"],
                                "ativo" => $trabalho["ativo"],
                                "id_tipo_de_pesquisa" => $trabalho["id_tipo_de_pesquisa"]
                            );
                        }

                    }

                    $trabalhosPorNivelArea = array(
                        "EF" => $trabalhosPorAreaEF,
                        "EM" => $trabalhosPorAreaEM
                    );

                    //* Para acessar esse trabalhos que foram organizados, primeiro se identifica o nível (EF ou EM) e depois a área
                    //* Ex de maneira estatica: $trabalhosPorNivelArea['EF'][3]
                    //* Assim acessando os trabalhos da área que possui o ID 3 e do nível Ensino Fundamental
            
                    /* echo '<pre>';
                    print_r($trabalhosPorAreaNivel);
                    echo '</pre>'; */

                    ?>

                    <!-- Informações Gerais das areas -->
                    <div class="alinhamento mb-4">
                        <!-- Título da Caixa -->
                        <h1 class="legendaTitulo upperFont negrito px-1" style="font-size: 17px; text-align: center;">
                            <?php echo $area['descricao']; ?>
                        </h1>

                        <!-- Borda da caixa -->
                        <div id="borda" class="legendaBorda mb-4 mt-3">

                            <div class="m-2">
                                <p class="legendaElementos" style="font-size: 18px!important">Quantidade total de trabalhos da
                                    área:
                                    <?php
                                    //* Conta o total de trabalhos da área a partir da soma da quantidade de trabalhos do EF e do EM
                                    echo (count($trabalhosPorNivelArea['EF'][$area['id']]) + count($trabalhosPorNivelArea['EM'][$area['id']]));
                                    ?>
                                </p>

                                <p class="legendaElementos" style="font-size: 16px!important">Quantidade de trabalhos - Ensino
                                    Fundamental:
                                    <?php
                                    echo count($trabalhosPorNivelArea['EF'][$area['id']]);
                                    ?>
                                </p>

                                <p class="legendaElementos" style="font-size: 16px!important">Quantidade de trabalhos - Ensino
                                    Médio:
                                    <?php
                                    echo count($trabalhosPorNivelArea['EM'][$area['id']]);
                                    ?>
                                </p>
                            </div>

                            <p class="legendaElementos m-2" style="font-size: 18px!important">Quantidade de Avaliadores:
                                <?php
                                echo count($arrayAvaliadores[$area['id']]);
                                ?>
                            </p>

                            <p class="legendaElementos m-2" style="font-size: 18px!important">Média de trabalho(s) por
                                Avaliador:
                                <?php

                                //* Pega as chaves da array MediaPorArea que são os ids das áreas e guarda em uma outra array
                                $arrayChaves = array_keys($mediaPorArea);

                                //* Percorre a array das Chaves pra verificar se são da mesma área
                                for ($i = 0; $i < count($arrayChaves); $i++) {
                                    //* Se for imprime na tela a média de trabalho por área já formatado
                                    if ($area["id"] == $arrayChaves[$i]) {

                                        $media = $mediaPorArea[$arrayChaves[$i]];
                                        //* Média verdadeira por causa que cada trabalho tem que ter no mínimo 3 avaliadores, e cada avaliador
                                        //* pode pegar mais de um trabalho, contanto que não seja repetido
                                        $mediaReal = $media * 3;

                                        //* Imprime a média arredondada
                                        echo ceil($mediaReal);
                                    }
                                }

                                ?>
                            </p>

                            <div class="m-2">
                                <p class="legendaElementos"
                                    onClick="popUpInfos(<?php echo $avaliadorMaisTrab['avaliador']->getId() ?>)"
                                    style="font-size: 18px!important">Avaliador com mais trabalho:
                                    <?php echo $avaliadorMaisTrab['avaliador']->getNome(); ?>
                                </p>
                                <p class="legendaElementos" style="font-size: 16px!important">Quantidade de trabalhos desse
                                    Avaliador:
                                    <?php
                                    echo $avaliadorMaisTrab['qtde'];
                                    ?>
                                </p>
                            </div>

                            <div class="m-2">
                                <p class="legendaElementos"
                                    onClick="popUpInfos(<?php echo $avaliadorMaisTrab['avaliador2']->getId() ?>)"
                                    style="font-size: 18px!important">2° Avaliador com mais trabalho:
                                    <?php
                                    echo $avaliadorMaisTrab['avaliador2']->getNome();
                                    ?>
                                </p>
                                <p class="legendaElementos" style="font-size: 16px!important">Quantidade de trabalhos desse
                                    Avaliador:
                                    <?php
                                    echo $avaliadorMaisTrab['qtde2'];
                                    ?>
                                </p>
                            </div>

                            <div class="m-2">
                                <p class="legendaElementos"
                                    onClick="popUpInfos(<?php echo $avaliadorMenosTrab['avaliador']->getId() ?>)"
                                    style="font-size: 18px!important">Avaliador com menos trabalho:
                                    <?php
                                    echo $avaliadorMenosTrab['avaliador']->getNome();
                                    ?>
                                </p>
                                <p class="legendaElementos" style="font-size: 16px!important">Quantidade de trabalhos desse
                                    Avaliador:
                                    <?php
                                    echo $avaliadorMenosTrab['qtde'];
                                    ?>
                                </p>
                            </div>

                            <div class="m-2">
                                <p class="legendaElementos"
                                    onClick="popUpInfos(<?php echo $avaliadorMenosTrab['avaliador2']->getId() ?>)"
                                    style="font-size: 18px!important">2° Avaliador com menos trabalho:
                                    <?php
                                    echo $avaliadorMenosTrab['avaliador2']->getNome();
                                    ?>
                                </p>
                                <p class="legendaElementos" style="font-size: 16px!important">Quantidade de trabalhos desse
                                    Avaliador:
                                    <?php
                                    echo $avaliadorMenosTrab['qtde2'];
                                    ?>
                                </p>
                            </div>

                            <div class="m-2">

                                <p class="legendaElementos negrito" style="font-size: 18px!important">Observações:</p>

                                <p class="legendaElementos" style="font-size: 16px!important">
                                    - Existem
                                    <?php echo qtdeAvaliadoresMesmaQtde($arrayAvaliadores[$area['id']], $avaliadorMaisTrab['qtde']); ?>
                                    avaliador(es) com
                                    <?php echo $avaliadorMaisTrab['qtde']; ?> trabalho(s) cadastrado(s);
                                </p>

                                <?php if ($avaliadorMaisTrab['qtde'] != $avaliadorMaisTrab['qtde2']) { ?>
                                    <p class="legendaElementos" style="font-size: 16px!important">
                                        - Existem
                                        <?php echo qtdeAvaliadoresMesmaQtde($arrayAvaliadores[$area['id']], $avaliadorMaisTrab['qtde2']); ?>
                                        avaliador(es) com
                                        <?php echo $avaliadorMaisTrab['qtde2']; ?> trabalho(s) cadastrado(s);
                                    </p>
                                <?php } ?>

                                <?php if ($avaliadorMenosTrab['qtde'] != $avaliadorMaisTrab['qtde'] && $avaliadorMenosTrab['qtde'] != $avaliadorMaisTrab['qtde2']) { ?>
                                    <p class="legendaElementos" style="font-size: 16px!important">
                                        - Existem
                                        <?php echo qtdeAvaliadoresMesmaQtde($arrayAvaliadores[$area['id']], $avaliadorMenosTrab['qtde']); ?>
                                        avaliador(es) com
                                        <?php echo $avaliadorMenosTrab['qtde']; ?> trabalho(s) cadastrado(s);
                                    </p>
                                <?php } ?>

                                <?php if ($avaliadorMenosTrab['qtde'] != $avaliadorMenosTrab['qtde2']) { ?>
                                    <p class="legendaElementos" style="font-size: 16px!important">
                                        - Existem
                                        <?php echo qtdeAvaliadoresMesmaQtde($arrayAvaliadores[$area['id']], $avaliadorMenosTrab['qtde2']); ?>
                                        avaliador(es) com
                                        <?php echo $avaliadorMenosTrab['qtde2']; ?> trabalho(s) cadastrado(s);
                                    </p>
                                <?php } ?>

                            </div>

                        </div>
                    </div>

                    <?php
                    //Termina o for
                }
                ?>

                <script>

                    //* Função que ajusta o layout para tornar responsivo
                    function ajustarLayout() {
                        const titulos = document.querySelectorAll('.legendaTitulo');
                        const windowWidth = window.innerWidth;

                        titulos.forEach(h1 => {
                            if (h1.scrollWidth > 320 && windowWidth < 700) {
                                h1.style.width = '280px';
                                h1.style.marginTop = '-12px';
                            }

                            else if (windowWidth >= 700) {
                                h1.style.width = 'unset';
                                h1.style.marginTop = 'unset';
                            }
                        });
                    }

                    //* Chama a função incialmente
                    ajustarLayout();

                    //* Chama a função toda vez que o tamanho da tela mudar
                    window.addEventListener('resize', ajustarLayout);

                    //* Função com ajax para descartar a distribuição
                    function descartarAvaliacao() {
                        var xhttp = new XMLHttpRequest();

                        //* Guarda a resposta da confirmação para ser utilizada como condição depois (true para confirmar e false para cancelar)
                        var confirmed = confirm('Tem certeza que deseja descartar a distribuição?\nApós confirmação NÃO será possível recuperar o mesmo');

                        if (confirmed) {
                            xhttp.open('GET', './../../Controller/avaliacaoController.php?act=excluirAvaliacao', true);
                            console.log(xhttp.readyState, xhttp.status)

                            xhttp.onreadystatechange = function () {
                                if (xhttp.readyState === 4 && xhttp.status === 200) {
                                    var msg = "Distribuição descartada com sucesso!"
                                    window.location.href = "./saguaoAdm.php?msg=" + msg;
                                }
                                else {
                                    console.error("Ocorreu um erro na solicitação.");
                                }
                            };

                            xhttp.send();
                        }
                    }

                </script>

                <!-- Botão para entrar  -->
                <div class="alinhamento my-3" style="flex-direction: row;">
                    <div>
                        <a href="./saguaoAdm.php">
                            <button class="button verdeEscuro" style="color: white">CONFIRMAR</button>
                        </a>
                    </div>

                    <div style="margin-left: 10px;">
                        <button class="button" onclick="descartarAvaliacao()"
                            style="color: white; background-color: #C3291F">DESCARTAR</button>
                    </div>
                </div>

                <script>

                </script>

            </div>

        </main>

    </body>

    <!-- Footer -->
    <?php

    }else{ //* Caso a distribuição ainda não tenha ocorrido será imprimido na tela a mensagem abaixo 
    
    ?>
    
    <style>

        /* Toda vez que entrar nesse else o footer será fixado com position abolute no final da página */
        #footer{
            position: absolute;
        }

    </style>
    
    <?php
        echo "
        <div style=\"display: flex; flex-direction: column; align-items: center; height: 100%;\">
            <h1 class=\"negrito\" style=\"color: red; margin-top: 30px;\"> Distribuição não realizada!!! </h1>
        </div>
        ";
    }

    include absolutePath . 'View/fragments/footer.php';
    ?>

    </style>


<?php

} else {
    echo "Você não tem permissão para acessar esta página.";
    header("Refresh:2; URL=../avaliador/login.php");
}

?>