<?php
//session_start();

// include_once(dirname(dirname(__DIR__))."/Controller/loginController.php");

// if (isset($_SESSION) && !empty($_SESSION) && verificaLogado($_SESSION['usuario'], 1)) //* Valor 1 para admin, 2 para monitor, 3 para avaliador, escolhe o que desejar :)
// {

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/IconFCT.png" type="image/x-icon">
    <title>Quem somos?</title>

    <!-- Links -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php include '../fragments/paths.php';
                                    echo absolutePath . 'View/css/estilo.css'; ?>">
    <style>
        .divGrid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }


        .coluna {
            padding: 20px;
            border: 1px solid #ccc;
        }

        .divConteudo {
            text-align: justify;
        }

        .card{
            display: flex; 
            margin: 30px;
        }

        .fonteFecintec{
            width: unset!important;
        }

        .mini-titulo{
            font-family: "Varela round", sans-serif;
            font-size: 25px;
            color: #ACACAC;
        }

        #caixa-equipe div:hover{
            transform: scale(1.028);
            transition: transform 250ms cubic-bezier(0.1, 0, 0.05, 0.8);
        }

        @media screen and (max-width: 850px) {
            .divGrid {
                grid-template-columns: 1fr;
            }

        }

        @import url("https://fonts.googleapis.com/css2?family=Oswald:wght@500&family=Varela+Round&display=swap");
        @import url("https://fonts.googleapis.com/css2?family=Anton&display=swap");
    </style>

</head>

<body style="background-color: #f5f5f5">

    <!-- Header -->
    <?php
    include __DIR__ . '/../fragments/header.php';
    ?>

    <main class="mx-auto main">
        <div class="divGrid">
            <div class="coluna m-3">
                <div class="divConteudo alinhamento">
                    <h1 class="fonteFecintec">Front-end</h1>
                    <p>O front-end refere-se à parte de um site ou aplicativo que os usuários interagem diretamente. É a interface com a qual os usuários interagem e inclui elementos visíveis, como layouts, botões, formulários e qualquer outro conteúdo que os usuários veem e interagem diretamente no navegador. As tecnologias comuns no front-end incluem HTML, CSS e JavaScript.</p>
                </div>
            </div>
            <div class="coluna m-3">
                <div class="divConteudo alinhamento">
                    <h1 class="fonteFecintec">Back-end</h1>
                    <p>O back-end é a parte não visível do desenvolvimento, responsável pelo processamento dos dados e pela lógica de negócios por trás de um site ou aplicativo. Os desenvolvedores back-end trabalham com servidores, bancos de dados e aplicam lógica para garantir que as funcionalidades do front-end funcionem corretamente.</p>
                </div>
            </div>
        </div>

        <div id="equipe" style="border-top:0.5px solid silver;">
            <h1 style="font-size: 135%;margin-top: 2%; font-family: 'Varela Round', sans-serif;text-align: center;">EQUIPE</h1>

            <div id="caixa-equipe" style="display: flex;justify-content: space-around;flex-wrap: wrap; flex-direction: row; padding: 2%;">
                <div style="background-color: white;margin: 0.2rem;width: 18rem;padding: 3%;box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;transition: 0.7s; margin-bottom:1%;">
                    <div style="width:100%; text-align:center; border">
                        <h2 style="margin-bottom: 25px;">Desenvolvedor Front-End (Full Stack)</h2>
                        <img  src="<?php echo absolutePathImg . 'thiagoFernandes.jfif' ?>" alt="Imagem desenvolvedor thaigo" style="border-radius: 50%;width: 10rem;height: 10rem;border: 5px solid silver; margin-bottom:2%;">
                        <h2 style="font-family: 'Anton', sans-serif;">Amanda<br><div class="mini-titulo">KIKUTA</div></h2>
                        <div style="border-top:0.5px solid silver;">
                            <p style="margin-top:2%;"> "Deixa para a próxima equipe" - Amanda, 2023</p>
                        </div>
                    </div>
                </div>

                <div style="background-color: white;margin: 0.2rem;width: 18rem;padding: 3%;box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;transition: 0.7s; margin-bottom:2%;">
                    <div style="width:100%; text-align:center; border">
                        <h2 style="margin-bottom: 25px;">Desenvolvedor Front-End (Full Stack)</h2>
                        <img  src="<?php echo absolutePathImg . 'sena.jpeg' ?>" alt="Imagem desenvolvedor thaigo" style="border-radius: 50%;width: 10rem;height: 10rem;border: 5px solid silver;">
                        <h2 style="font-family: 'Anton', sans-serif;">Gabriel<br><div class="mini-titulo">SENA</div></h2>
                        <div style="border-top:0.5px solid silver;">
                            <p style="margin-top:2%;">"Se fosse a gente desenvolvendo..." - Sena, 2023.</p>
                        </div>
                    </div>
                </div>

                <div style="background-color: white;margin: 0.2rem;width: 18rem;padding: 3%;box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;transition: 0.7s; margin-bottom:2%;  text-align:center;">
                <h2 style="margin-bottom: 25px;">Desenvolvedor Back-End (Full Stack)</h2>
                    <div style="width:100%; text-align:center; border">
                        <img  src="<?php echo absolutePathImg . 'thiagoFernandes.jfif' ?>" alt="Imagem desenvolvedor thaigo" style="border-radius: 50%;width: 10rem;height: 10rem;border: 5px solid silver;">
                        <h2 style="font-family: 'Anton', sans-serif;">Giovana<br><div class="mini-titulo">FARIAS</div></h2>
                        <div style="border-top:0.5px solid silver;">
                            <p style="margin-top:2%;"> BLA BLA BLA</p>
                        </div>
                    </div>
                </div>

                <div style="background-color: white;margin: 0.2rem;width: 18rem;padding: 3%;box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;transition: 0.7s; margin-bottom:2%; text-align:center;">
                    <h2 style="margin-bottom: 25px;">Desenvolvedor Front-End (Full Stack)</h2>
                    <div style="width:100%; text-align:center; border">
                        
                        <img  src="<?php echo absolutePathImg . 'thiagoFernandes.jfif' ?>" alt="Imagem desenvolvedor thaigo" style="border-radius: 50%;width: 10rem;height: 10rem;border: 5px solid silver;">
                        <h2 style="font-family: 'Anton', sans-serif;">Paloma<br><div class="mini-titulo">GREGOL</div></h2>
                        <div style="border-top:0.5px solid silver;">
                            <p style="margin-top:2%;"> BLA BLA BLA</p>
                        </div>
                    </div>
                </div>

                <div style="background-color: white;margin: 0.2rem;width: 18rem;padding: 3%;box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;transition: 0.7s; margin-bottom:2%; text-align:center;">
                <h2 style="margin-bottom: 25px;">Desenvolvedor Front-End (Full Stack)</h2>
                    <div style="width:100%; text-align:center; border">
                        <img  src="<?php echo absolutePathImg . 'thiagoFernandes.jfif' ?>" alt="Imagem desenvolvedor thaigo" style="border-radius: 50%;width: 10rem;height: 10rem;border: 5px solid silver;">
                        <h2 style="font-family: 'Anton', sans-serif;">Samira<br><div class="mini-titulo">GARCIA</div></h2>
                        <div style="border-top:0.5px solid silver;">
                            <p style="margin-top:2%;"> BLA BLA BLA</p>
                        </div>
                    </div>
                </div>

                <div style="background-color: white;margin: 0.2rem;width: 18rem;padding: 3%;box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;transition: 0.7s; margin-bottom:2%;  text-align:center;">
                <h2 style="margin-bottom: 25px;">Desenvolvedor Back-End (Full Stack)</h2>
                    <div style="width:100%; text-align:center; border">
                        <img  src="<?php echo absolutePathImg . 'thiagoFernandes.jfif' ?>" alt="Imagem desenvolvedor thaigo" style="border-radius: 50%;width: 10rem;height: 10rem;border: 5px solid silver;">
                        <h2 style="font-family: 'Anton', sans-serif;">Thiago<br><div class="mini-titulo">FERNANDES</div></h2>
                        <div style="border-top:0.5px solid silver;">
                            <p style="margin-top:2%;"> BLA BLA BLA</p>
                        </div>
                    </div>
                </div>

                <div style="background-color: white;margin: 0.2rem;width: 18rem;padding: 3%;box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;transition: 0.7s; margin-bottom:2%;  text-align:center;">
                <h2 style="margin-bottom: 25px;">Desenvolvedor Back-End (Full Stack)</h2>
                    <div style="width:100%; text-align:center; border">
                        <img  src="<?php echo absolutePathImg . 'thiagoFernandes.jfif' ?>" alt="Imagem desenvolvedor thaigo" style="border-radius: 50%;width: 10rem;height: 10rem;border: 5px solid silver;">
                        <h2 style="font-family: 'Anton', sans-serif;">Vinicius<br><div class="mini-titulo">VICTOR</div></h2>
                        <div style="border-top:0.5px solid silver;">
                            <p style="margin-top:2%;"> BLA BLA BLA</p>
                        </div>
                    </div>
                </div>

                <div style="background-color: white;margin: 0.2rem;width: 18rem;padding: 3%;box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;transition: 0.7s; margin-bottom:2%;  text-align:center;">
                <h2 style="margin-bottom: 25px;">Desenvolvedor Back-End (Full Stack)</h2>
                    <div style="width:100%; text-align:center; border">
                        <img  src="<?php echo absolutePathImg . 'thiagoFernandes.jfif' ?>" alt="Imagem desenvolvedor thaigo" style="border-radius: 50%;width: 10rem;height: 10rem;border: 5px solid silver;">
                        <h2 style="font-family: 'Anton', sans-serif;">Victor<br><div class="mini-titulo">DEDOJA</div></h2>
                        <div style="border-top:0.5px solid silver;">
                            <p style="margin-top:2%;"> BLA BLA BLA</p>
                        </div>
                    </div>
                </div>

                <div style="background-color: white;margin: 0.2rem;width: 18rem;padding: 3%;box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;transition: 0.7s; margin-bottom:2%; text-align:center;">
                <h2 style="margin-bottom: 25px;">Desenvolvedor Back-End (Full Stack)</h2>
                    <div style="width:100%; text-align:center; border">
                        <img  src="<?php echo absolutePathImg . 'thiagoFernandes.jfif' ?>" alt="Imagem desenvolvedor thaigo" style="border-radius: 50%;width: 10rem;height: 10rem;border: 5px solid silver;">
                        <h2 style="font-family: 'Anton', sans-serif;">Gabriel<br><div class="mini-titulo">SANTANA</div></h2>
                        <div style="border-top:0.5px solid silver;">
                            <p style="margin-top:2%;"> BLA BLA BLA</p>
                        </div>
                    </div>
                </div>

                
            </div>

            </div>
           
        </div>

        <!-- <div class="divDesenvolvedores">
            <div class="coluna m-3">
                <div class="divConteudo">
                    <h1 class="upperFont fonteFecintec" style="text-align: center;">Desenvolvedores</h1>

                    <div>
                        <div class="card">
                            <img src="<?php echo absolutePathImg . 'thiagoFernandes.jfif' ?>" alt="Imagem desenvolvedor thaigo" width="300px">
                            <div style="margin: 20px;">
                                <h1 class="negrito">DESENVOLVEDOR BACK-END</h1>
                                <h1 class="negrito">Thiago Fernandes</h1>
                                <p>Estudante.</p>
                            </div>
                        </div>
                    </div>


                    <div>
                        <div class="card">
                            <img src="<?php echo absolutePathImg . 'thiagoFernandes.jfif' ?>" alt="Imagem desenvolvedor thaigo" width="300px">
                            <div style="margin: 20px;">
                                <h1 class="negrito">DESENVOLVEDOR BACK-END</h1>
                                <h1 class="negrito">Vinicius Victor</h1>
                                <p>Estudante.</p>
                            </div>
                        </div>
                    </div>


                    <div>
                        <div class="card">
                            <img src="<?php echo absolutePathImg . 'thiagoFernandes.jfif' ?>" alt="Imagem desenvolvedor thaigo" width="300px">
                            <div style="margin: 20px;">
                                <h1 class="negrito">DESENVOLVEDOR FRONT-END</h1>
                                <h1 class="negrito">Gabriel Sena</h1>
                                <p>Estudante.</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="card">
                            <img src="<?php echo absolutePathImg . 'thiagoFernandes.jfif' ?>" alt="Imagem desenvolvedor thaigo" width="300px">
                            <div style="margin: 20px;">
                                <h1 class="negrito">DESENVOLVEDOR FRONT-END</h1>
                                <h1 class="negrito">Amanda Ayumi</h1>
                                <p>Estudante.</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="card">
                            <img src="<?php echo absolutePathImg . 'thiagoFernandes.jfif' ?>" alt="Imagem desenvolvedor thaigo" width="300px">
                            <div style="margin: 20px;">
                                <h1 class="negrito">DESENVOLVEDOR FRONT-END</h1>
                                <h1 class="negrito">Paloma Gregol</h1>
                                <p>Estudante.</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="card">
                            <img src="<?php echo absolutePathImg . 'thiagoFernandes.jfif' ?>" alt="Imagem desenvolvedor thaigo" width="300px">
                            <div style="margin: 20px;">
                                <h1 class="negrito">DESENVOLVEDOR FRONT-END</h1>
                                <h1 class="negrito">Giovanna Farias</h1>
                                <p>Estudante.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
         </div> -->
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