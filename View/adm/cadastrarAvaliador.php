<?php
//session_start();

include_once(dirname(dirname(__DIR__)) . "/Controller/loginController.php");

if (isset($_SESSION) && !empty($_SESSION) && verificaLogado($_SESSION['usuario'], 1)) //! ARRUMAR PÓS FASE DE TESTES
{ //! SAGUÃO TEM -> TRABALHOS NÃO AVALIADOS / MONITORIA / BOTÃO DISTRIBUIR 

    require_once('../fragments/paths.php');
    require_once(absolutePath . 'Controller/AvaliadorController.php');
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../img/IconFCT.png" type="image/x-icon">
        <title>Cadastro de Avaliador</title>
        <script>
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

            function trocarCadastro(secao, event) {
                event.preventDefault();
                if (secao === 1) {
                    document.getElementById('tipoUsuario').value = '3';

                    document.getElementById('apareceSenha').style = 'display: none!important;';
                    document.getElementById('divMonitor').style = 'margin-left: 10px; padding: 15px!important; box-shadow: unset!important; border-radius: 6px 6px 0px 0px!important; background-color: #adacac!important; opacity: 0.8;';
                    document.getElementById('divAvaliador').style = 'padding: 15px!important; box-shadow: unset!important; border-radius: 6px 6px 0px 0px!important; background-color: #D9D9D9!important; opacity: unset!important;';
                    document.getElementById('removeCampos').style.display = 'unset';
                    document.getElementsByClassName('field:not(:last-child)').style = 'margin-bottom: .75rem;';

                    // Seleciona todos os elementos com a classe "exemplo"
                    var elementos = document.querySelectorAll('#removeCampos');

                    // Aplica um estilo a todos os elementos
                    elementos.forEach(function(elemento) {
                        elemento.style = 'display: block!important;'; // Exemplo de estilo a ser aplicado
                    });


                } else if (secao === 2) {

                    document.getElementById('tipoUsuario').value = '2';

                    document.getElementById('apareceSenha').style = 'unset!important';
                    document.getElementById('divAvaliador').style = 'padding: 15px!important; box-shadow: unset!important; border-radius: 6px 6px 0px 0px!important; background-color: #adacac!important; opacity: 0.8;';
                    document.getElementById('divMonitor').style = 'margin-left: 10px; padding: 15px!important; box-shadow: unset!important; border-radius: 6px 6px 0px 0px!important; background-color: #D9D9D9!important; opacity: unset!important;';

                    // Seleciona todos os elementos com a classe "exemplo"
                    var elementos = document.querySelectorAll('#removeCampos');

                    // Aplica um estilo a todos os elementos
                    elementos.forEach(function(elemento) {
                        elemento.style = 'display: none!important;'; // Exemplo de estilo a ser aplicado
                    });

                }
            }
        </script>
        <!-- Links -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo absolutePath . "View/css/estilo.css" ?>">
        <style>
            .fonteFecintec{
                width: unset!important;
            }
        </style>
    </head>

    <body>

        <?php
        if (isset($_GET['msg']) || !empty($_GET['msg'])) {
            echo "<script> alert('" . $_GET['msg'] . "'); </script>";
        }
        ?>

        <!-- Header -->
        <?php include __DIR__ . "./../fragments/header.php" ?>

        <main>

            <div class="alinhamento">

                <div class="title is-5 my-5" id="fecintec">
                    <h1>Feira de Ciência e Tecnologia de Campo Grande</h1>

                    <div class="alinhamento" style="position: absolute; left: 25px; top: 15px;">
                        <a href="./saguaoAdm.php" style="align-items: unset;">
                            <button type="button" class="button verde is-medium" style="color: white;">
                                Voltar
                            </button>
                        </a>
                    </div>
                </div>



                <div class="title" id="fecintec" style="text-align: center;">
                    <h1>Cadastro</h1>
                </div>



                <div>
                    <div style="display: flex; width: 100px!important; align-items: unset!important;">
                        <div class="bloco cinza negrito fonteFecintec" style="padding: 15px!important;; box-shadow: unset!important; border-radius: 6px 6px 0px 0px!important;" onclick="trocarCadastro(1, event)" id="divAvaliador">
                            <h1 style="font-size: 14px;">Avaliador</h1>
                        </div>

                        <div class="bloco cinza negrito fonteFecintec" style="margin-left: 10px; padding: 15px!important; box-shadow: unset!important; border-radius: 6px 6px 0px 0px!important; background-color: #adacac!important; opacity: 0.8;" onclick="trocarCadastro(2, event)" id="divMonitor">
                            <h1 style="font-size: 14px;">Monitor</h1> 
                        </div>
                    </div>

                    <form class="bloco cinza mb-6" action="./../../Service/processaUsuario.php" method="post" style="border-radius: 0px 6px 6px 6px!important;">

                        <input type="hidden" name="tipoUsuario" id="tipoUsuario" value="3">
                        <input name="action" type="hidden" value="cadastrar">

                        <div class="field">
                            <label class="label" for="nome">Nome</label>
                            <div class="control">
                                <input class="input" type="text" name="nome" placeholder="Insira seu nome" required>
                            </div>
                        </div>

                        <div class="field" id="removeCampos">
                            <label class="label" for="cpf">CPF</label>
                            <div class="control">
                                <input class="input" type="text" name="cpf" placeholder="Insira seu CPF">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label" for="email">Email</label>
                            <div class="control">
                                <input class="input" type="email" name="email" placeholder="Insira seu E-mail" required>
                            </div>
                        </div>

                        <div class="field" id="removeCampos">
                            <label class="label" for="telefone">Telefone</label>
                            <div class="control">
                                <input class="input" type="tel" maxlength="15" onkeyup="chamaMascara(event)" name="telefone" placeholder="Insira seu telefone">
                            </div>
                        </div>

                        <div class="field" id="removeCampos">
                            <label class="label" for="cidade_instituicao">Cidade</label>
                            <div class="control">
                                <input class="input" type="text" name="cidade_instituicao" placeholder="Insira a cidade do seu campus">
                            </div>
                        </div>

                        <div class="field" id="removeCampos">
                            <label class="label" for="link_lattes">Lattes</label>
                            <div class="control">
                                <input class="input" type="text" name="link_lattes" placeholder="Insira seu Lattes">
                            </div>
                        </div>
                        
                        <div class="field" id="apareceSenha" style="display: none;">
                            <label class="label" for="senha">Senha</label>
                            <div class="control">
                                <input class="input" type="password" name="senha" placeholder="Insira sua senha">
                            </div>
                        </div>

                        <!-- Áreas de Conhecimento -->
                        <div class="my-5" id="removeCampos">
                            <div class="my-2">
                                <input type="checkbox" id="area1" name="1">
                                <label for="1">CAE - Ciências Agrárias e Engenharias:</label>
                            </div>

                            <div class="my-2">
                                <input type="checkbox" name="2">
                                <label for="2">CBS - Ciências Biológicas e da Saúde</label>
                            </div>

                            <div class="my-2">
                                <input type="checkbox" name="3">
                                <label for="3">CET - Ciências Exatas e da Terra</label>
                            </div>

                            <div class="my-2">
                                <input type="checkbox" name="4">
                                <label for="4">CHSAL - Ciências Humanas; Sociais Aplicadas e Linguística</label>
                            </div>

                            <div class="my-2">
                                <input type="checkbox" name="5">
                                <label for="5">MDIS - Multidisciplinar</label>
                            </div>
                        </div>

                        <!-- Botão -->
                        <div style="text-align:center;">
                            <button class="button verdeEscuro" id="btnLogar" type="submit">Cadastrar</button>
                        </div>

                    </form>

                </div>

                <!-- Botão para caso já exista cadastro -->
                <!-- <div class="mt-5">
                <a class="is-size-7" style="color: rgb(0, 0, 0)"
                    href="<?php /* echo absolutePath."View/avaliador/login.php"; */ ?>">Já tenho cadastro!</a>
            </div> -->

            </div>

        </main>

    </body>

    <!-- Footer -->
    <?php include absolutePath . "View/fragments/footer.php" ?>

    </html>

<?php
} else {
    echo "Você não tem permissão para acessar esta página.";
    header("Refresh:2; URL=../avaliador/login.php");
}

?>