<?php

require_once(__DIR__ . '/../Util/conectaPDO.php');
require_once(__DIR__ . '/../Controller/trabalhoController.php');
require_once(__DIR__ . '/../Controller/usuarioController.php');
require_once(__DIR__ . '/../Controller/estudanteController.php');


function planilhaCertificadosTrabalhos()
{
    $conn = conecta();

    $sql = $sql = "SELECT t.id, t.titulo, GROUP_CONCAT(e.nome SEPARATOR ', ') 
    AS nomes_estudantes
    FROM trabalho t
    JOIN estudante_trabalho et ON t.id = et.id_trabalho
    JOIN estudante e ON et.id_estudante = e.id
    GROUP BY t.id, t.titulo";
    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchAll();

    $listaTrabalhos = [];

    $planilhas = [];

    foreach ($result as $trabalhos) {

        $trabalho = array(
            'id' => $trabalhos['id'],
            'titulo' => $trabalhos['titulo'],
            'alunos' => $trabalhos['nomes_estudantes']
        );
        $listaTrabalhos[] = $trabalho;
    }

    foreach ($listaTrabalhos as $t) {
        $idtrabalho = $t['id'];

        $sql = "SELECT nome, email FROM orientador ori INNER JOIN trabalho t on ori.id = t.id_orientador WHERE t.id = $idtrabalho";

        $stmt = $conn->prepare($sql);

        $stmt->execute();

        $orientadorInfos = $stmt->fetchAll();

        $orientadorNome = null;
        $orientadorEmail = null;

        foreach($orientadorInfos as $orientador){
            $orientadorNome = $orientador['nome'];
            $orientadorEmail = $orientador['email'];
        }

        $nomeCoorientador = null;

        $sql = "SELECT nome FROM orientador ori INNER JOIN trabalho t on ori.id = t.id_coorientador WHERE t.id = $idtrabalho";

        $stmt = $conn->prepare($sql);

        if($stmt->execute() != null){
        $coorientadornome = $stmt->fetch();
        $nomeCoorientador = $coorientadornome['nome'];
        }

        $planilha = array(
            'titulo' => $t['titulo'],
            'alunos' => $t['alunos'],
            'nomeCoorientador' => $nomeCoorientador,
            'emailOrientador' => $orientadorEmail,
            'nomeOrientador' => $orientadorNome
        );

        $planilhas[] = $planilha;
       
    }
    return $planilhas;
}

//planilhaCertificadosTrabalhos();

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function planilhaCertificadosAvaliadores(){
    $conn = conecta();

    $sql = "SELECT nome, email FROM usuario WHERE id_tipo = 3";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $infosAvaliador = $stmt->fetchAll();

    $sql = "SELECT COUNT (DISTINCT id_avaliador, id_trabalho) FROM `avaliacao` WHERE id_avaliador = 1";
}

planilhaCertificadosAvaliadores();
