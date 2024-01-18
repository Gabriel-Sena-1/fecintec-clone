<?php
//session_start();

include_once(dirname(dirname(__DIR__))."/Controller/loginController.php");

if (isset($_SESSION) && !empty($_SESSION) && verificaLogado($_SESSION['usuario'], 1)) 
{ 
    ?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Relatório</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?php include '../fragments/paths.php';
            echo absolutePath . 'View/css/estilo.css';
            $PAGE = 'login.php'; ?>">
        <link rel="stylesheet" href="<?php echo absolutePath . 'View/css/telaAvaliador.css' ?>">
    </head>

         <!-- Header -->
        <?php
            include __DIR__ . '/../fragments/header.php';
            
            include_once __DIR__ . './../../Controller/trabalhoController.php';
            include_once __DIR__ . './../../Controller/avaliadorController.php';
            include_once __DIR__ . './../../Controller/areasController.php';
            include_once __DIR__ . './../../Controller/areasController.php';

            $areas = buscarAreas();

            $trabalhosPorAreaEF = array();
            $trabalhosPorAreaEM = array();

            $trabalhosPorArea = array();

        ?>

    <div class="alinhamento">

            <!-- Título da Página -->
            <div class="title is-5 my-5" id="relatorio">
                <h1>Relatório Geral</h1>
            </div>

                <div class="alinhamento mt-5 mb-4">
                    <!-- Título da Caixa -->
                    <h1 class="legendaTitulo upperFont negrito px-1 elementoFonte">Informações Gerais</h1>

                    <!-- Borda da caixa -->
                    <div class="legendaBorda mb-3" style="margin-top: 18px;">

                            <!-- Dados das informações gerais -->
                            <div class="m-2">                                
                                <p class="legendaElementos" style="font-size: 18px!important">Quantidade total de trabalhos: 
                                    <?php
                                        $totalTrabalhos = buscarTodosOsTrabalhos();
                                        echo count($totalTrabalhos);
                                    ?>
                                </p>
                            </div>

                        <div class = m-2>
                                <p class="legendaElementos" style="font-size: 18px!important">Quantidade total de trabalhos desclassificados: 
                                    <?php
                                        $totalDesclassificados = contaDesclassificados();
                                        echo count($totalDesclassificados);
                                    ?>
                                </p>
                        </div>

                        <div class = m-2>
                                <p class="legendaElementos" style="font-size: 18px!important">Quantidade total de avaliadores: 
                                    <?php
                                        $totalAvaliadores = contaTodosAvaliadores();
                                        echo ($totalAvaliadores[0][0]);
                                    ?>
                                </p>
                        </div>

                        <div class = m-2>
                                <p class="legendaElementos" style="font-size: 18px!important">Quantidade total de instituições: 
                                    <?php      
                                    //echo "<pre>"; 
                                        echo (contaInstituicao());      
                                        
                                        //TODO arrumar essa bomba atomica depois ** 
                                        //TODO att: vai ter padrão de cadastro no nome das instituições 🙌🙌🙏🙏                   
                                    ?>
                                </p>
                        </div>

                        <div class = m-2>
                                <p class="legendaElementos" style="font-size: 18px!important">Quantidade total de trabalhos ausentes:
                                    <?php
                                        echo (trabalhosAusentes());                                  
                                    ?>
                                </p>
                        </div>

                        <div class = m-2>
                                <p class="legendaElementos" style="font-size: 18px!important">Quantidade total de alunos: 
                                    <?php
                                        $contaAlunos = contaAlunos();
                                        echo ($contaAlunos[0][0]);
                                    ?>
                                </p>
                        </div>

                    <!-- //TODO -- A FAZER/ADICIONAR --

                    //* Quantidade Total de Alunos
                    //* Quantidade Total de Alunos por Nível -->
                    

                </div>

                <!-- Legenda das áreas dos trabalhos -->
                <div class="alinhamento mt-5 mb-4">
                    <!-- Título da Caixa -->
                    <h1 class="legendaTitulo upperFont negrito px-1 elementoFonte">Total de Trabalhos por Área e Nível:</h1>

                    <!-- Borda da caixa -->
                    <div class="legendaBorda mb-3" style="margin-top: 18px;">
                    
                        <!-- Para organizar as informações dos trabalhos por área e nível -->            
                        <?php
                            foreach($areas as $area){

                                $trabalhosPorArea[$area['id']] = trabalhosArea($area['id']); 

                                foreach($trabalhosPorArea[$area['id']] as $trabalho){
                                    if($trabalho['nivel'] == "EF"){
                                        $trabalhosPorAreaEF[$area['id']][] = array(
                                            "id_area" => $area['id'],
                                            "nivel" => $trabalho['nivel'],
                                            "id" => $trabalho["id"],
                                            "cpf_coorientador"=> $trabalho["cpf_coorientador"],
                                            "cpf_orientador"=> $trabalho["cpf_orientador"],
                                            "descricaoMDIS"=> $trabalho["descricaoMDIS"],
                                            "email_coorientador"=> $trabalho["email_coorientador"],
                                            "email_orientador"=> $trabalho["email_orientador"],
                                            "nome_estudante"=> $trabalho["nome_estudante"],
                                            "nome_coorientador"=> $trabalho["nome_coorientador"],
                                            "nome_orientador"=> $trabalho["nome_orientador"],
                                            "titulo"=> $trabalho["titulo"],
                                            "notaResumo"=> $trabalho["notaResumo"],
                                            "instituicao"=> $trabalho["instituicao"],
                                            "ativo"=> $trabalho["ativo"],
                                            "id_tipo_de_pesquisa"=> $trabalho["id_tipo_de_pesquisa"]
                                        );
                                    }
                                    else if($trabalho['nivel'] == "EM"){
                                        $trabalhosPorAreaEM[$area['id']][] = array(
                                            "id_area" => $area['id'],
                                            "nivel" => $trabalho['nivel'],
                                            "id" => $trabalho["id"],
                                            "cpf_coorientador"=> $trabalho["cpf_coorientador"],
                                            "cpf_orientador"=> $trabalho["cpf_orientador"],
                                            "descricaoMDIS"=> $trabalho["descricaoMDIS"],
                                            "email_coorientador"=> $trabalho["email_coorientador"],
                                            "email_orientador"=> $trabalho["email_orientador"],
                                            "nome_estudante"=> $trabalho["nome_estudante"],
                                            "nome_coorientador"=> $trabalho["nome_coorientador"],
                                            "nome_orientador"=> $trabalho["nome_orientador"],
                                            "titulo"=> $trabalho["titulo"],
                                            "notaResumo"=> $trabalho["notaResumo"],
                                            "instituicao"=> $trabalho["instituicao"],
                                            "ativo"=> $trabalho["ativo"],
                                            "id_tipo_de_pesquisa"=> $trabalho["id_tipo_de_pesquisa"]
                                        );
                                    }
                                }

                            $trabalhosPorAreaNivel = array(
                                "EF" => $trabalhosPorAreaEF,
                                "EM"=> $trabalhosPorAreaEM
                            );                           
                            ?>

                            <div class="m-2">       
                                <p class="legendaElementos" style="font-size: 18px!important">Quantidade total de trabalhos da
                                <?php echo $area['descricao']; ?>:
                                    <?php
                                    $contador = 0;

                                    if(!empty($trabalhosPorAreaNivel['EF'][$area['id']])){
                                        $contador =  count($trabalhosPorAreaNivel['EF'][$area['id']]);
                                    }
                                    if(!empty($trabalhosPorAreaNivel['EM'][$area['id']])){
                                        $contador = count($trabalhosPorAreaNivel['EM'][$area['id']]);
                                    }
                                    if(!empty($trabalhosPorAreaNivel['EM'][$area['id']]) && !empty($trabalhosPorAreaNivel['EF'][$area['id']]) ){
                                        $contador = (count($trabalhosPorAreaNivel['EF'][$area['id']]) + count($trabalhosPorAreaNivel['EM'][$area['id']]));
                                    }    
                                    
                                    echo $contador;
                                    ?>
                                </p>
                                
                                <p class="legendaElementos" style="font-size: 16px!important">Ensino
                                    Fundamental:
                                    <?php
                                           if(!empty($trabalhosPorAreaNivel['EF'][$area['id']])){
                                            echo count($trabalhosPorAreaNivel['EF'][$area['id']]);
                                        }
                                            ?>
                                </p>

                                <p class="legendaElementos" style="font-size: 16px!important">Ensino
                                    Médio:
                                    <?php
                                    if(!empty($trabalhosPorAreaNivel['EM'][$area['id']])){
                                        echo count($trabalhosPorAreaNivel['EM'][$area['id']]);
                                    }
                                            ?>
                                </p>
                            </div>

                        <?php
                            }
                        ?>

                        </div>
                    </div>
                </div>

                
    </div>

        <?php
		include __DIR__ . './../fragments/footer.php';
		?>

</html>

<?php
} else {
    echo "Você não tem permissão para acessar esta página.";
    header("Refresh:2; URL=../avaliador/login.php");
}

?>