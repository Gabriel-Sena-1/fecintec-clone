<?php

// Inicia a sessão
//session_start();

include_once(dirname(dirname(__DIR__))."/Controller/loginController.php");

// Verifica se há uma sessão ativa e se o usuário é um administrador
if (isset($_SESSION) && !empty($_SESSION) && verificaLogado($_SESSION['usuario'], 1)) {

    // Inclui os arquivos necessários
    require_once('../fragments/paths.php');
    require_once(__DIR__ . '/../../Controller/trabalhoController.php');
    require_once(__DIR__ .'/../../Controller/avaliadorController.php');

    // Obtém o ID do trabalho a ser alterado a partir dos parâmetros da URL
    $id = base64_decode($_GET['id']);

    // Obtém informações sobre o trabalho e avaliadores

    
    $trabalho = buscarTrabalho($id)[0];
    $informacao = buscarInfos($id);
    $idTipo = $informacao[0]['id_tipo_de_pesquisa'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
         <meta charset="UTF-8">
         <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <link rel="icon" href="../img/IconFCT.png" type="image/x-icon">
         <title><?php echo $id . " - " .  $trabalho['titulo'] ?></title>

         <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
         <link rel="stylesheet" href=<?php echo absolutePath . "View/css/estilo.css" ?>>

         <!-- Estilos CSS -->
         <style>
             .red {
                 background-color: red;
             }

             .dnone {
                 display: none;
             }

             .dblock {
                 display: block;
             }

             .reduzOp {
                 opacity: 0.3;
             }

             .ofuscaTela {
                 opacity: 0.7;
                 background-color: rgba(61, 58, 58, 0.7);
             }

             @media screen and (max-width: 850px) {
                 #divResponsiva {
                     width: 100% !important;
                 }

                 #popUp {
                     width: 100% !important;
                     left: unset !important;
                     height: 190px !important;
                 }
             }
         </style>

         <script>
            const voltar = ()=>{
				event.preventDefault();
                history.go(-2);
            };

             var xhttp = new XMLHttpRequest();

             // Função para filtrar os avaliadores
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
                 xhttp.open('GET', './../../Controller/avaliadorController.php?act=exibe&id=' + id, true);


                 xhttp.onreadystatechange = function () {
                     if (this.readyState === 4 && this.status === 200) {
                         var imprime = document.getElementById('exibe');
                         imprime.innerHTML = xhttp.responseText;

                         //* Faz aparecer a div que escurece o fundo
                        //  document.getElementById('ofuscaTela').style.display = 'unset';

                         console.log(imprime);
                         console.log('Pop up apresentado.');
                         // location.reload();
                     }
                 };

                 // Não vai funcionar :/
                 xhttp.send();
             }

         </script>

     </head>

<body>

<?php
    if (isset($_GET['dados'])) {
        echo $_GET['dados'];
    }
?>

    <!-- Contêiner para exibir informações do pop-up -->
    <div id="exibe"></div>

    <!-- Corpo da página -->
    <?php

    // Inclui o cabeçalho da página
    include __DIR__ . '/../fragments/header.php';

    // Exibe informações sobre os avaliadores e a área de conhecimento do trabalho
    echo '<div style="text-align: center; margin: 30px;">';
    echo '<p style="font-size: 25px; font-weight: 600;">Avaliadores: </p>';

    // Loop para exibir nomes dos avaliadores --- $informacao[$j]['id_avaliador']
    for ($j = 0; $j < sizeof($informacao); $j++) {
        echo '<div style="display: flex; text-align: center; justify-content: center; ' . (verificaAvaliacaoDoAvaliador($informacao[$j]['id_avaliador'], $id) ? "color: #169c28!important;" : "color: red!important;") . '">';
        echo '<h1>' . $informacao[$j]['nome'] . '</h1>';
        // Link para mostrar notas do avaliador
        echo '<a href="./mostraNotasAvaliador.php?idAvaliador=' . $informacao[$j]['id_avaliador'] . '&idTrabalho=' . $id . '"><img src="' . absolutePathImg . '/eyeicon.png' . '" alt="ícone olho" width="20px" style="margin-left: 10px;"></a>';
        echo '</div>';
    }
    echo '<p style="font-size: 25px; font-weight: 600; margin-top: 20px;">Área de conhecimento do Trabalho: </p>';
    echo '<h1>';
    // Converte ID da área de conhecimento em descrição
    if ($informacao[0]['id_area_de_conhecimento'] == 1) {
        echo 'CAE - Ciências Agrárias e Engenharias';
    } else if ($informacao[0]['id_area_de_conhecimento'] == 2) {
        echo 'CBS - Ciências Biológicas e da Saúde';
    } else if ($informacao[0]['id_area_de_conhecimento'] == 3) {
        echo 'CET - Ciências Exatas e da Terra';
    } else if ($informacao[0]['id_area_de_conhecimento'] == 4) {
        echo 'CHSAL - Ciências Humanas; Sociais Aplicadas e Linguística';
    } else {
        echo 'MDIS - Multidisciplinar';
    }
    echo '</h1>';
    echo '</div>';

    // Verifica se a distribuição foi realizada
    if ($informacao == null) {
        echo "<div style='color: red; font-weight: 600; margin: 23vw; text-align: center;'>A distribuição não foi realizada.</div>";
    } else {
        // Obtém e exibe formulário para vincular avaliador ao trabalho
        $idTipo = $informacao[0]['id_tipo_de_pesquisa'];
        echo vincularAvaliador($id, $idTipo);
    }

    // Inclui o rodapé da página
    include __DIR__ . '/../fragments/footer.php';
?>

</body>

</html>

<?php
} else {
    // Se o usuário não é um administrador, exibe uma mensagem de erro e redireciona para a página de login
    echo "Você não tem permissão para acessar esta página.";
    header("Refresh:2; URL=../avaliador/login.php");
    }

?>