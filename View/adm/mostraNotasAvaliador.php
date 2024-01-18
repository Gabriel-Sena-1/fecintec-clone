<?php
//session_start();

include_once(dirname(dirname(__DIR__))."/Controller/loginController.php");

if(isset($_SESSION) && !empty($_SESSION) && verificaLogado($_SESSION['usuario'], 1)) 
{ 
	?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/IconFCT.png" type="image/x-icon">
    <title>
        <?php
        require_once __DIR__ . '/../../Controller/trabalhoController.php';
        $idAvaliador = $_GET['idAvaliador'];
        $idTrabalho = $_GET['idTrabalho'];
        $trabalho = buscarTrabalho($idTrabalho)[0];
        $questoes = array_map(null, explode(" / ", $trabalho["questoes"]));
        echo $trabalho['titulo'];
        ?>
    </title>

    <!-- Links -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php include '../fragments/paths.php';
    echo absolutePath . 'View/css/estilo.css' ?>">
    <link rel="stylesheet" href="<?php echo absolutePath . 'View/css/telaAvaliador.css' ?>">
    <style>
        .dnone {
            display: none;
        }
    </style>
    <script>

        function formatarNumero(input) {
            // Substitui "," por "."
            input.value = input.value.replace(/,/g, '.');

            // Limpa qualquer valor não numérico, exceto ponto
            input.value = input.value.replace(/[^0-9.]/g, '');

            // Remove pontos duplicados
            input.value = input.value.replace(/(\..*)\./g, '$1');

            // Garante que o valor esteja entre 0 e 10
            var numero = parseFloat(input.value);
            if (isNaN(numero) || numero < 0) {
                input.value = '';
            } else if (numero > 10) {
                alert('A nota deve ser menor que 10');
                input.value = '';
            }

            // Limita a duas casas decimais
            if (input.value.includes('.')) {
                var partes = input.value.split('.');
                if (partes[1].length > 2) {
                    partes[1] = partes[1].substring(0, 2);  // Pega apenas os dois primeiros dígitos da parte decimal
                    input.value = partes.join('.');  // Atualiza o valor do input com a parte decimal limitada
                }
            }


        }


    </script>
    </body>

</html>






</script>

</head>

<body>

    <!-- Header -->
    <?php
    include __DIR__ . '/../fragments/header.php';
    require_once __DIR__ . '/../../Controller/trabalhoController.php';

    if(verificaAvaliacaoTrabalho($idTrabalho, $idAvaliador)){
        $notas = buscarNotas($idTrabalho, $idAvaliador);
        $acao = 'ver';
    }else{
        $acao = '';
    }
?>

    <!-- Título -->
    <div class="alinhamento m-5">

        <!-- Função para imprimir o nome do trabalho? -->
        <h1 class="negrito upperFont has-text-centered">
            <?php
            echo $trabalho['titulo']
                ?>
        </h1>
    </div>

    <!-- Informações Gerais do Trabalho -->
    <div class="alinhamento mb-4">
        <!-- Título da Caixa -->
        <h1 class="legendaTitulo upperFont negrito px-1">Informações Gerais</h1>

        <!-- Borda da caixa -->
        <div class="legendaBorda mb-3">
            <p class="legendaElementos">Aluno(s):
                <?php
                echo $trabalho['estudantes']
                    ?>
            </p>
            <p class="legendaElementos">Orientador(es):
                <?php
                echo $trabalho['nome_orientador'] . ($trabalho['nome_coorientador'] !== null ? ', ' . $trabalho['nome_coorientador'] : '');

                ?>
            </p>
            <p class="legendaElementos">Nivel:
                <?php
                echo $trabalho['nivel']
                    ?>
            </p>
            <p class="legendaElementos">Tipo de Pesquisa:
                <?php
                echo $trabalho['tipo']
                    ?>
            </p>
            <p class="legendaElementos">Área de Conhecimento:
                <?php
                echo $trabalho['descricao']
                    ?>
            </p>
        </div>
    </div>

    <span class="alinhamento mb-4" style="color: red; display: none;" id="spanNota">
        <h1>A nota de cada CRITÉRIO deve ser entre 0 e 10</h1>
    </span> <!-- SPAN CASO A NOTA QUE O USUARIO INSIRA SEJA MAIOR QUE 10 -->
    <!-- Formulário para inserir as notas de cada critério -->
    <form action="../../Service/processaAvaliacao.php" method="post">
        <input type="hidden" name="act" value="nota">
        <input type="hidden" name="idTrabalho" value="<?php echo $idTrabalho; ?>">
        <input type="hidden" name="idAvaliador" value="<?php echo $idAvaliador; ?>">
        <!-- Tabela de trabalhos + status do Avaliador -->
        <div class="alinhamento mb-5">

            <table class="table mx-5 mb-2">

                <!-- Cabeçalho da Tabela -->
                <thead class="verde">
                    <!-- Linha com Critérios | Nota -->
                    <tr>
                        <th class="upperFont alinhamento negrito is-size-6 has-text-white">Critérios</th>
                        <th class="upperFont negrito is-size-6 has-text-white" style="width: 90px; text-align: center;">
                            Nota</th>
                    </tr>
                </thead>

                <!-- Corpo da Tabela -->
                <tbody class="cinzaTabela">

                    <!-- Repetição para impressão de todas os critérios desse tipo de trabalho -->
                    <?php //Aqui tem que ter um for de repetição para imprimir os critérios 
                    foreach ($questoes as $questao) {
                        ?>

                        <!--   -->
                        <tr>
                            <td style="vertical-align: middle;">
                                <?php echo preg_replace("/[0-9]/", "", $questao) ?>
                            </td>
                            <td class="tdNota px-4">
                            <input <?php echo $acao == 'ver' ? 'disabled' : 'required'; ?>
                                    class="input is-small inputNota px-2" type="text" style="text-align: center;"
                                    name="<?php echo preg_replace("/[^0-9.]/", "", $questao); ?>"
                                    oninput="formatarNumero(this)" maxlength="4"
                                    value="<?php echo $acao == 'ver' ? $notas[preg_replace("/[^0-9.]/", "", $questao)] : null; ?>">
                                <hr class="notaTraco">
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>

        </div>

        <div class="alinhamento">
            <?php if ($acao == 'ver') {
               $id = base64_encode($idTrabalho);
               ?>
               <a href="./alterarAvaliador.php?id=<?php echo $id; ?>">
                   <button type="button" class="button verde has-text-light negrito">Voltar</button>
               </a>
            <?php } else { ?>
                <button class="button verde has-text-light negrito" type="submit"
                    onclick="return confirm('Tem certeza que deseja submeter essas notas?\nApós confirmação NÃO será possível alterar')">Salvar</button>
            <?php } ?>
        </div>
    </form>
</body>

<!-- Footer -->
<?php
// echo "<div style='color: red; font-weight: 600; margin: 23vw; text-align: center;'>A distribuição não foi realizada.</div>";

include __DIR__ . '/../fragments/footer.php';
?>

</html>

<?php } else {
echo "Você não tem permissão para acessar esta página.";
header("Refresh:2; URL=../avaliador/login.php");
}

?>