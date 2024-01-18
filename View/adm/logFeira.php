<?php
// session_start();

require_once __DIR__ . '/../../Controller/logController.php';
include_once(dirname(dirname(__DIR__))."/Controller/loginController.php");

// if (isset($_SESSION) && !empty($_SESSION) && verificaLogado($_SESSION['adm'], 1)) //* Valor 1 para admin, 2 para monitor, 3 para avaliador, escolhe o que desejar :)
// {

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/IconFCT.png" type="image/x-icon">
    <title>Log FECINTEC</title>

    <!-- Links -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php include '../fragments/paths.php';
                                    echo absolutePath . 'View/css/estilo.css'; ?>">

    <style>
        #divTable {
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin: 2vw 4vw 4vw 4vw;
        }
    </style>

    <script>
        function filtro(textoFiltro) {

            // Obtem todas as linhas da tabela 
            var lista = document.querySelectorAll('tbody tr');



            for (let i = 0; i < lista.length; i++) {
                const element = lista[i];
                var textoLinha = element.innerText;
                element.style.display = '';

                textoLinha = textoLinha.toLowerCase();
                var filt = textoFiltro.toLowerCase();


                if (textoLinha.includes(filt) || filt === ''){
                    element.style.display = '';
                } else {
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
        <div class="table-container" id="divTable">
            <div style="margin: 20px;">
                <input type="text" class="input" id="filtroInput" placeholder="Coloque o que deseja filtrar" onkeypress="filtro(this.value)" onkeyup="filtro(this.value)">
            </div>

            <table class="table is-bordered is-striped is-narrow is-hoverable">
                <!-- Cabeçalho da Tabela -->
                <thead class="verde">
                    <!-- Linha com Trabalhos | Status -->
                    <tr>
                        <th class="upperFont alinhamento negrito is-size-6 has-text-white">Comentário</th>
                        <th align="center" class="upperFont negrito is-size-6 has-text-white">Horário</th>
                    </tr>
                </thead>

                <!-- Corpo da Tabela -->
                <tbody class="cinzaTabela">
                    <?php
                    $log = listarLog(); //! DEVE-SE FAZER UMA FUNCAO EM LOG CONTROLLER QUE RETORNA A LISTA COMPLETA
                    //! ENTAO COLOCA ESSA FUNCAO DENTRO DE UM AJAX
                    //! APOS ISSO INVOCA O AJAX COM SET TIMEOUT
                    foreach ($log as $logs) {
                    ?>

                        <tr>
                            <td>
                                <?= $logs['comentario'] ?>
                            </td>

                            <td align="center">
                                <?= $logs['horario'] ?>
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


<?php
// } else {
//     echo "Você não tem permissão para acessar esta página.";
//     header("Refresh:2; URL=../avaliador/login.php");
// }

?>