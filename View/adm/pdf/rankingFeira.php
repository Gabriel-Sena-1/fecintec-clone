<?php
   require_once './../../../Controller/avaliacaoController.php';
   require_once './../../../Controller/trabalhoController.php';

   $ranking = call();
   $areas = buscarAreas();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/IconFCT.png" type="image/x-icon">
    <title> Ranking de Trabalhos</title>

    <!-- Links -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php include './../../fragments/paths.php';
    echo absolutePath . 'View/css/estilo.css' ?>">
    <link rel="stylesheet" href="<?php echo absolutePath . 'View/css/telaAvaliador.css' ?>">
    <style>
        .legendaBorda {
            padding: 8px !important;
        }

        .pagebreak { 
            page-break-before: always; 
        }

    </style>
</head>

<body>

    <main>

        <div class="alinhamento my-5" style="display: flex; text-align: center;">
            <h1 class="title is-5" id="titulo">RANKING FECINTEC - 2023</h1>
        </div>
        <?php 

            $j = 0;
            
            foreach($ranking as $nivel){ ?>

                <div class="alinhamento my-5" style="display: flex; text-align: center;">
                    <h1 class="title is-6" id="titulo"><?php echo "NÍVEL " . (array_keys($ranking)[$j] == 'EM' ? 'ENSINO MÉDIO' : 'ENSINO FUNDAMENTAL') ?></h1>
                </div>

            <?php
                foreach($areas as $area){
                    for($i = 1; $i <= 3; $i++){
                        if(isset($nivel[$area['id']][$i-1])){
            ?>
        <div class="alinhamento mb-4" style="margin: 0px 0px 40px 40px;">

            <div class="alinhamento mb-4">
                <h1 class="legendaTitulo upperFont negrito px-1" style="font-size: 15px; text-align: center;">
                        <?php echo $area['descricao'].' | ' . $i .'° LUGAR' ?>
                </h1>

                <div id="borda" class="legendaBorda mb-4 mt-3">
                    <p class="legendaElementos m-2" style="font-size: 16px!important">
                        Trabalho: <?php echo $nivel[$area['id']][$i-1]['titulo'];?>
                    </p>

                    <p class="legendaElementos m-2" style="font-size: 16px!important">
                        Aluno(s):  <?php echo $nivel[$area['id']][$i-1]['estudantes'];?>
                    </p>

                    <p class="legendaElementos m-2" style="font-size: 16px!important">
                        Orientador: <?php echo $nivel[$area['id']][$i-1]['nome_orientador'];?>
                    </p>
                    <?php if(!empty($nivel[$area['id']][$i-1]['nome_coorientador']) && $nivel[$area['id']][$i-1]['nome_coorientador'] != 'NULL'){?>
                        <p class="legendaElementos m-2" style="font-size: 16px!important">
                            Coorientador: <?php echo $nivel[$area['id']][$i-1]['nome_coorientador'];?>
                        </p>
                    <?php }?>

                    <p class="legendaElementos m-2" style="font-size: 16px!important">
                        Escola: <?php echo $nivel[$area['id']][$i-1]['instituicao'];?>
                    </p>
                </div>
            </div>
        </div>

<?php } else{ break; } } if($area != end($areas) || $nivel != end($ranking)) {?>

        <div class="pagebreak" style="margin-top: 40px"> </div> <!-- Quebra de página -->

<?php } } $j++; } ?>
</body>

</html>