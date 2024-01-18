<?php
include_once '../Controller/trabalhoController.php';
include_once '../Controller/estudanteController.php';
include_once '../Controller/avaliadorController.php';
include_once '../Controller/orientadorController.php';
include_once '../Model/Trabalho.php';
include_once '../Model/Estudante.php';
include_once '../Model/Orientador.php';

//$url = "https://script.google.com/macros/s/AKfycbxYrVJkwwkiOWpKmVDZdXzUnswlolUmeFHxG_S6_w8XnDG8V7FhJV33AU6i4hUXWnt1mg/exec";
//$url = "https://script.google.com/macros/s/AKfycbwtmiQQpIgsoWquKp6qBKyl6-lWRaSbphS8vQVy3SUQH7OkcZDcXq7_L80KA2O7RyNWGw/exec";
// $url = "https://script.google.com/macros/s/AKfycbwKU9NERJMXEat-SHgbRTC_qc0JQpoyZzWkf4cfEQSWG9LMNUxJkIpsTp8GpYn0ruZvYA/exec";
$url = "https://script.google.com/macros/s/AKfycbw_i86vrpFOwEHEEaNWHtSMcti6EQiC1ldx6teY4HqUR7K_Qc5leA4nRlxHANxDaUo0/exec";

$result = json_decode(file_get_contents($url));

$trabalhoReprovados = [];

//if($result['status'])
$cpfteste = 12345678900;

foreach ($result as $key => $trabalho) {
    if ($trabalho->Status == 'Reprovado' || $trabalho->Status == 'Recusado') {
        $trabalhoReprovados[] = $trabalho;
    } else {
        $idsEstudantes = [];

        //! !!!!!
        //fazer busca igual trabalho/avaliador

        $estudantes = trim($trabalho->Estudantes);
        //!descomentar essa linha tbm 
        //$cpfs = $trabalho->CPF;
        $nomesEstudante = explode(";", $estudantes);
        //!descomentar essa linha tbm 
        //$cpfsEstudantes = explode(";", $cpfs);


        for ($i = 0; $i < sizeof($nomesEstudante); $i++) {
            $_estudante = new Estudante(
                $nome = trim($nomesEstudante[$i]),
                $kit = 1,
                // $cpfEstudante = trim($cpfsEstudantes[$i])
                //!remover a linha abaixo e descomentar a linha acima!!!!!
                $cpfEstudante = $cpfteste
            );

            if (!estudanteJaCadastrado($cpfEstudante)) {
                $idsEstudantes[] = cadastraEstudante($_estudante);
            } else {
                $idsEstudantes[] = buscaIdEstudante($cpfEstudante);
            }

            //! REMOVER CPF TESTE QUANDO HOUVER CPF NA PLANILHA!!!!!!!!!!!!!
            $cpfteste++;

        }

        //cadastraEstudante($_estudante);        
        $_orientador = new Orientador(
            $nome = $trabalho->Nome_Orientador,
            $email = $trabalho->Email_Orientador,
            $cpf = $trabalho->CPF_Orientador
        );

        $idOrientador;
        if (!orientadorJaCadastrado($cpf)) {
            $idOrientador = cadastraOrientador($_orientador);
            if (verificaOrientacao($cpf) == false) {
                if (statusOrientacao($cpf) == 0) {
                    updateOrientacao($cpf);
                }
            }
        } else {
            $idOrientador = buscaIdOrientador($cpf);

        }
       

        $_coorientador = new Orientador(
            $nome = $trabalho->Nome_Coorientador,
            $email = $trabalho->Email_Coorientador,
            $cpf = $trabalho->CPF_Coorientador
        );


        $idCoorientador = null;
        $caracteresEspeciais = array("/","#","%");
        //echo $cpf ."<br>";
        if(!ctype_alpha(str_replace($caracteresEspeciais, "", $cpf))){
            if (!orientadorJaCadastrado($cpf)) {
                $idCoorientador = cadastraOrientador($_coorientador);
                if (verificaOrientacao($cpf) == false) {
                    if (statusOrientacao($cpf) == 0) {
                        updateOrientacao($cpf);
                    }
                }
            } else {
                $idCoorientador = buscaIdOrientador($cpf);
            }
        }

        $_trabalho = new Trabalho(
            $nivel = $trabalho->Nivel,
            $titulo = strtoupper($trabalho->Titulo),
            $instituicao = $trabalho->Instituicao,
            $ativo = 1,
            $notaResumo = $trabalho->notaResumo
        );


        $areaTrabalho = 0;
        //pega a area do trabalho
        if (str_contains($trabalho->Area, 'CAE')) {
            $areaTrabalho = 1;
        }
        if (str_contains($trabalho->Area, 'CBS')) {
            $areaTrabalho = 2;
        }
        if (str_contains($trabalho->Area, 'CET')) {
            $areaTrabalho = 3;
        }
        if (str_contains($trabalho->Area, 'CHSAL')) {
            $areaTrabalho = 4;
        }
        if (str_contains($trabalho->Area, 'MDIS')) {
            $areaTrabalho = 5;
        }

        $pesquisaTrabalho = 0;
        //pega o tipo de pesquisa do trabalho
        if (str_contains($trabalho->Pesquisa, 'cientifico')) {
            $pesquisaTrabalho =  1;
        }
        if (str_contains($trabalho->Pesquisa, 'tecnologico')) {
            $pesquisaTrabalho =  2;
        }


        //pega o nivel do trabalho
        if (str_contains($nivel, 'Ensino fundamental')) {
            $_trabalho->setNivel('EF');
        } else {
            $_trabalho->setNivel('EM');
        }

        $_trabalho->setNotaResumo(str_replace(',', '.', $notaResumo));
        $idTrabalho;
        if (!trabalhoJaCadastrado($titulo)) {
            $idTrabalho = cadastrarTrabalhoPorPlanilha($_trabalho, $areaTrabalho, $pesquisaTrabalho, $idOrientador, $idCoorientador);


            foreach ($idsEstudantes as $idEstudante) {

                cadastrarTrabalhoEstudantes($idTrabalho, $idEstudante);
            }

        }
    }
}


$msg = 'Trabalhos cadastrados com sucesso!!';
header("Location: ../view/adm/saguaoadm.php?msg=$msg");
?>