<?php
//session_start();

include_once(dirname(dirname(__DIR__))."/Controller/loginController.php");

// $email = $_SESSION['avaliador']['email'];

// echo $email;

//if (!empty($_SESSION) && isset($_SESSION) && isset($_SESSION['avaliador'])) //! ARRUMAR PÓS FASE DE TESTES
if (isset($_SESSION) && !empty($_SESSION) && verificaLogado($_SESSION['usuario'], 3))
{ //! SAGUÃO TEM -> TRABALHOS NÃO AVALIADOS / MONITORIA / BOTÃO DISTRIBUIR 

    // echo '<pre>';
    // print_r($_SESSION);
    // echo '</pre>';
    ?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../img/IconFCT.png" type="image/x-icon">
        <title> Avaliador -
            <?php echo $_SESSION['avaliador']['nome']; ?>
        </title>

        <!-- Links -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?php include '../fragments/paths.php';
        echo absolutePath . 'View/css/estilo.css' ?>">
        <link rel="stylesheet" href="<?php echo absolutePath . 'View/css/telaAvaliador.css' ?>">

    </head>

    <body>

        <!-- Caso exista mensagem -->
        <?php if (isset($_SESSION['msg'])) {
            $msg = $_SESSION['msg'];
            echo "<script>alert('$msg')</script>";
            unset($_SESSION['msg']);
        } ?>

        <!-- Header -->
        <?php
        include __DIR__ . '/../fragments/header.php';
        require_once __DIR__ . '/../../Controller/trabalhoController.php';
        ?>



        <main>
            <?php
            if (isset($_GET['aviso'])) {
                $aviso = $_GET['aviso'];
            }

            if (!empty($aviso) && $aviso != '') { ?>
                <script>alert('<?php echo $aviso ?>')</script>

            <?php }
            //TODO - BUSCAR NO SESSION
            $idAvaliador = $_SESSION['avaliador']['id'];
            $trabalhosNotas = buscaTrabalhoNotas($idAvaliador);
          

            if (empty($trabalhosNotas)) {
                echo '<div style="color: red; font-weight: 600; text-align: center; margin-top: 175px; margin-bottom: 175px;">Sem trabalhos para avaliação.</div>';
            } else {
                ?>

                <!-- Legenda dos status (avaliação) dos trabalhos -->
                <div class="alinhamento mt-5 mb-4">
                    <!-- Título da Caixa -->
                    <h1 class="legendaTitulo upperFont negrito px-1 elementoFonte">Legenda</h1>

                    <!-- Borda da caixa -->
                    <div class="legendaBorda mb-3" style="margin-top: 18px;">
                        <div class="my-2" style="display: flex; flex-direction: row;">
                            <div class="bolinhaStatus bolinhaMaior verdeStatus m-2"></div>
                            <p class="elementoFonte" style="margin-left: 10px;">Avaliado</p>
                        </div>

                        <div class="my-2" style="display: flex; flex-direction: row;">
                            <div class="bolinhaStatus bolinhaMaior vermelhoStatus m-2"></div>
                            <p class="elementoFonte" style="margin-left: 10px;">Não Avaliado</p>
                        </div>
                    </div>
                </div>

                <!-- Título -->
                <div class="alinhamento my-5">
                    <h1 class="negrito upperFont">Avaliações</h1>
                </div>

                <!-- Tabela de trabalhos + status do Avaliador -->
                <div class="alinhamento mb-5">

                    <table class="table mx-5 mb-2">

                        <!-- Cabeçalho da Tabela -->
                        <thead class="verde">
                            <!-- Linha com Trabalhos | Status -->
                            <tr>
                                <th class="upperFont negrito is-size-6 has-text-white">ID</th>
                                <th class="upperFont alinhamento negrito is-size-6 has-text-white">Trabalhos</th>
                                <th class="upperFont negrito is-size-6 has-text-white">Status</th>
                                <th class="upperFont negrito is-size-6 has-text-white">Funções</th>
                            </tr>
                        </thead>

                        <!-- Corpo da Tabela -->
                        <tbody class="cinzaTabela">

                            <!-- Repetição para impressão de todas os trabalhos atribuidos a este Avaliador -->
                            <?php
                            $contVazio = 0;

                            foreach ($trabalhosNotas as $titulo => $notas) {
                                $vazio = empty($notas[0]);

                                /* echo '<pre>';
                                print_r($notas[0]);
                                echo '-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-';
                                print_r($trabalhosNotas);
                                echo '</pre>'; 
                                echo '------------------------------'; */
                                
                                if ($vazio == false) {
                                    $contVazio++;
                                }
                                ?>

                                <tr>
                                    <td><strong><?php echo $trabalhosNotas[$titulo][1]; ?></strong></td>
                                    <td>
                                        <?php echo $titulo; 

                                        //TODO - VERIFICAR CASO A NOTA SEJA ZERO XDD PQ NESSE CASO NENHUMA NOTA É ZERO
                                        //TODO - DESATIVAR TRABALHO QUE JÁ ESTEJA AVALIADO? OU CASO ESTEJA MOSTRAR AS NOTAS?
                                        ?>
                                    </td>

                                    <td align="center" style="vertical-align: middle;">
                                        <div class="bolinhaStatus <?php echo ($vazio ? 'vermelhoStatus' : 'verdeStatus') ?>"></div>
                                    </td>
                                    <td align="center" style="vertical-align: middle;">
                                        <a class="button" 
                                            href="<?php echo absolutePath . 'View/avaliador/telaTrabalho.php?id=' . base64_encode($notas[1]) . '&action=' . ($vazio ? 'avaliar' : 'ver'); ?>"
                                            type="button"
                                            style="background-color: #169c28; color: white; padding: 4px 8px; border: 1px solid black;">
                                            <?php echo ($vazio ? 'Avaliar' : 'Ver Notas') ?> </a>
                                    </td>
                                </tr>

                                <?php
                            }
            }
            //Aqui acaba o for ?>

                    </tbody>

                </table>

            </div>
    
        </main>

    </body>

    <!-- Footer -->
    <?php
    include __DIR__ . './../fragments/footer.php';
    ?>

    </html>

<?php } else {
    echo "Você não tem permissão para acessar esta página.";
    header("Refresh:2; URL=../avaliador/login.php");
}

?>