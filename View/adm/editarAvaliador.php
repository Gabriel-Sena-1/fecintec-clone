<?php
//session_start();

include_once(dirname(dirname(__DIR__))."/Controller/loginController.php");

if (isset($_SESSION) && !empty($_SESSION) && verificaLogado($_SESSION['usuario'], 1)) //! ARRUMAR PÓS FASE DE TESTES
{ //! SAGUÃO TEM -> TRABALHOS NÃO AVALIADOS / MONITORIA / BOTÃO DISTRIBUIR 

    require_once('../../Controller/AvaliadorController.php');
    require_once('../../Controller/administradorController.php');
    require_once('../../Util/conectaPDO.php');




    if ($_GET['enviarDados'] == 'editar') {

        $avaliador = buscarAvaliadorPeloId($_GET['id']);

    }

    //TODO - ISSO NAO TINHA QUE VIM DO AVALIADOR CONTROLLER? XDD
/*

try{
    $sql = "SELECT id_area_de_conhecimento FROM avaliador_area_de_conhecimento WHERE id_avaliador = ".$_GET['id'];

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    

}catch (PDOException $e) {
    echo $e->getMessage();
}
*/
    $conn = conecta();



    ?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../img/IconFCT.png" type="image/x-icon">
        <title>Editar Avaliador -
            <?php echo $avaliador['nome'] ?>
        </title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet"
            href="<?php include '../fragments/paths.php';
            echo absolutePath . 'View/css/estilo.css';
            $PAGE = 'login.php'; ?>">
        <script>
            const voltar = ()=>{
				event.preventDefault();
                history.back();
            };

            const chamaMascara = (event) => {
                let input = event.target
                input.value = mascaraTelefone(input.value)
            }

            const mascaraTelefone = (value) => {
                if (!value) return ""
                value = value.replace(/\D/g, '')
                value = value.replace(/(\d{2})(\d)/, "($1) $2")
                value = value.replace(/(\d)(\d{4})$/, "$1-$2")
                return value
            }
        </script>
    </head>

    <body>

        <!-- Header -->
        <?php
        include __DIR__ . '/../fragments/header.php';
        ?>

        <?php
        if (isset($_GET['msg']) || !empty($_GET['msg'])) {
            echo "<script> alert('" . $_GET['msg'] . "'); </script>";
        }
        ?>

        <div class="alinhamento">

            <div class="title is-5 my-5" id="fecintec">
                <h1>Editar Avaliador</h1>

                <div class="alinhamento" style="position: absolute; left: 25px; top: 70px;">
                    <a href="#" onclick="voltar()" style="align-items: unset;">
                        <button type="button" class="button verde is-medium" style="color: white;">
                            Voltar
                        </button>
                    </a>
                </div>
            </div>

            <form action="../../Service/ProcessaEditar.php" class="bloco cinza mb-6" method="post">
                <input type="hidden" name="id" value="<?php echo $avaliador['id']; ?>">
                <input name="action" type="hidden" value="editar">


                <div class="field">
                    <label class="label" for="nome">Nome</label>
                    <div class="control">
                        <input class="input" name="nome" type="text" placeholder="nome"
                            value="<?php echo $avaliador['nome']; ?>" required>
                    </div>
                </div>




                <div class="field">
                    <label class="label" for="CPF">CPF</label>
                    <div class="control">
                        <input class="input" name="cpf" type="text" placeholder="cpf"
                            value="<?php echo $avaliador['cpf']; ?>" required>
                    </div>
                </div>



                <div class="field">
                    <label class="label" for="email">Email</label>
                    <div class="control">
                        <input class="input" name="email" type="text" placeholder="email"
                            value="<?php echo $avaliador['email']; ?>" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="telefone">Telefone</label>
                    <div class="control">
                        <input class="input" name="telefone" type="tel" onkeyup="chamaMascara(event)" placeholder="telefone"
                            value="<?php echo $avaliador['telefone']; ?>" maxlength="15">
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="cidade_instituicao">Cidade</label>
                    <div class="control">
                        <input class="input" name="cidade_instituicao" type="text" placeholder="Cidade da Instituição"
                            value="<?php echo $avaliador['cidade_instituicao']; ?>">
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="link_lattes">Lattes</label>
                    <div class="control">
                        <input class="input" name="link_lattes" type="text" placeholder="Link do Currículo Lattes"
                            value="<?php echo $avaliador['link_lattes']; ?>">
                    </div>
                </div>

                <div class="my-2">
                    <input <?php echo verificarAreas($avaliador['id'], 1) ? 'checked' : '' ?> type="checkbox" id="area1"
                        name="1">
                    <label for="1">CAE - Ciências Agrárias e Engenharias:</label>
                </div>

                <div class="my-2">
                    <input <?php echo verificarAreas($avaliador['id'], 2) ? 'checked' : '' ?> type="checkbox" name="2">
                    <label for="2">CBS - Ciências Biológicas e da Saúde</label>
                </div>

                <div class="my-2">
                    <input <?php echo verificarAreas($avaliador['id'], 3) ? 'checked' : '' ?> type="checkbox" name="3">
                    <label for="3">CET - Ciências Exatas e da Terra</label>
                </div>

                <div class="my-2">
                    <input <?php echo verificarAreas($avaliador['id'], 4) ? 'checked' : '' ?> type="checkbox" name="4">
                    <label for="4">CHSAL - Ciências Humanas; Sociais Aplicadas e Linguística</label>
                </div>

                <div class="my-2">
                    <input <?php echo verificarAreas($avaliador['id'], 5) ? 'checked' : '' ?> type="checkbox" name="5">
                    <label for="5">MDIS - Multidisciplinar</label>
                </div>




                <div class="alinhamento mt-5">
                    <button class="button verdeEscuro" style="color: white; font-weight: 600;" name="action" type="submit"
                        value="Editar">Editar</button>
                </div>

                <?php
                if (isset($_GET['mensagem']) || !empty($_GET['mensagem'])) {
                    echo '<h1>' . $_GET['mensagem'] . '</h1>';
                }
                ?>

            </form>
        </div>

    </body>
    <?php
    include absolutePath . 'View/fragments/footer.php';
    ?>

    </html>


    <?php
} else {
    echo "Você não tem permissão para acessar esta página.";
    header("Refresh:2; URL=../avaliador/login.php");
}

?>