<?php
include_once '../Util/conectaPDO.php';

$conn = conecta();
try {
    $conn->beginTransaction();

    // Consulta SQL para obter os IDs das areas de conhecimento
    $sqlArea = "SELECT area_de_conhecimento.id FROM area_de_conhecimento";

    $stmt = $conn->prepare($sqlArea);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $conn->commit();

    $avaliadoresPorArea = array();
    $trabalhosPorArea = array();
    $mediaPorArea  = array();

    //* Inicializa os arrays com IDs das áreas de conhecimento como chaves e valores iniciais
    foreach ($result as $id => $key) {
        $avaliadoresPorArea[$key['id']] = null;
        $trabalhosPorArea[$key['id']] = null;
        $mediaPorArea[$key['id']] = 0;
    }
} catch (PDOException $e) {
    $conn->rollBack();
    echo "Erro ao executar a consulta: " . $e->getMessage();
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

try {
    $conn->beginTransaction();

    // cria variavel para a lista orientadores - é usada em avaliador controler
    $listaOrientadores = array();

     // Consulta SQL para obter dados dos avaliadores e suas áreas de conhecimento
    $sqlAvaliadores = "SELECT avaliador.id, usuario.nome, avaliador.cpf, GROUP_CONCAT(area_de_conhecimento.id SEPARATOR ' / ') as AREA
                        FROM avaliador
                        JOIN usuario ON avaliador.id_usuario = usuario.id
                        JOIN avaliador_area_de_conhecimento ON avaliador.id = avaliador_area_de_conhecimento.id_avaliador
                        JOIN area_de_conhecimento ON avaliador_area_de_conhecimento.id_area_de_conhecimento = area_de_conhecimento.id
                        GROUP BY avaliador.id";

    $stmt = $conn->prepare($sqlAvaliadores);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $conn->commit();

    $hibridos = [];

    // Loop para processar os resultados da consulta aos avaliadores
    foreach ($result as $row) {
        // Inicializa um array para armazenar informações do avaliador atual
        $avaliador = array(
            'id' => $row['id'],
            'nome' => $row['nome'],
            'cpf' => $row['cpf'],
            'areas' => array_map('intval', explode(" / ", $row["AREA"])),
            'orienta' => false,
            'trabalhos' => []
        );

        // Consulta SQL para contar os níveis de orientação do avaliador (orientador ou coorientador)
        $sqlOrienta = "SELECT res.nome, COUNT(res.nome) AS qtdeNiveis FROM 
        (
                SELECT DISTINCT orientador.nome, trabalho.nivel
                FROM orientador
                JOIN avaliador ON avaliador.cpf = orientador.cpf -- conferir se isso confere
                JOIN trabalho ON (orientador.id = trabalho.id_orientador OR orientador.id = trabalho.id_coorientador) 
            	WHERE orientador.cpf = '" . $row['cpf'] . "'
        ) AS res 
        GROUP BY res.nome";

        $stmt = $conn->prepare($sqlOrienta);
        $stmt->execute();

        $avaliadorOrientacao = $stmt->fetchAll(PDO::FETCH_ASSOC);


        // Verifica se o avaliador não tem mais de um nível de orientação
        if (empty($avaliadorOrientacao) || $avaliadorOrientacao[0]['qtdeNiveis'] < 2 ) {

             // Consulta SQL para obter informações sobre a categoria do avaliador
            $sqlCategoria = "SELECT DISTINCT orientador.nome, trabalho.nivel
            FROM orientador
            JOIN avaliador ON avaliador.cpf = orientador.cpf -- conferir se isso confere
            JOIN trabalho ON (orientador.id = trabalho.id_orientador OR orientador.id = trabalho.id_coorientador) 
            WHERE orientador.cpf = '" . $row['cpf'] . "''";

            $stmt = $conn->prepare($sqlCategoria);
            $stmt->execute();

            $avaliadorCategoria = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Verifica a categoria do avaliador e atribui ao array de avaliador
            if(!empty($avaliadorOrientacao) && $avaliadorOrientacao[0]['qtdeNiveis'] == 1){
                $avaliador['orienta'] = $avaliadorCategoria[0]['nivel'];  

                // Se entrar significa que o bendito avaliador orienta/coorienta
                if((!empty($avaliador['orienta']) && $avaliador['orienta'] != '' && $avaliador['orienta'] != false)){
                        $listaOrientadores[] = array(
                            'id' => $avaliador['id'],
                            'nome' => $avaliador['nome'],
                            'cpf' => $avaliador['cpf'],
                            'areas' => $avaliador['areas'],
                            'orienta' => $avaliador['orienta'],
                            'trabalhos' => []
                        );  
                }
            }   

             // Verifica o número de áreas do avaliador
            if (count($avaliador['areas']) > 1) {  
                // Se o avaliador tem mais de uma área, adiciona ao array de híbridos
                $hibridos[] = $avaliador;
            } else {
                // Se o avaliador tem apenas uma área, associa ao array de avaliadores por área
                foreach ($avaliador['areas'] as $area) {
                    $avaliadoresPorArea[$area][] = $avaliador;
                }
            }
        }
    }
} catch (PDOException $e) {
    //$conn->rollBack();
    echo "Erro ao executar a consulta: " . $e->getMessage();
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

try {
    $conn->beginTransaction();
    $sqlTrabalhos = " SELECT trabalho.id, trabalho.titulo, trabalho.id_orientador, trabalho.id_coorientador, trabalho.nivel,
                                trabalho.id_area_de_conhecimento AS id_area, GROUP_CONCAT(questao.id SEPARATOR ' / ') AS questoes
                                FROM trabalho
                                JOIN questao ON trabalho.id_tipo_de_pesquisa = questao.id_tipo_de_pesquisa
                                GROUP BY trabalho.id";
    $stmt = $conn->prepare($sqlTrabalhos);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn->commit();


    foreach ($result as $row) {

        $trabalho = array(
            'id' => $row['id'],
            'titulo' => $row['titulo'],
            'id_area' => $row['id_area'],
            'nivel' => $row['nivel'],
            'id_orientador' => $row['id_orientador'],
            'id_coorientador' => $row['id_coorientador'],
            'questoes' => array_map('intval', explode(" / ", $row["questoes"])),
            'avaliadores' => []
        );
        $trabalhosPorArea[$trabalho["id_area"]][] = $trabalho;
    }
} catch (PDOException $e) {
    $conn->rollBack();
    echo "Erro ao executar a consulta: " . $e->getMessage();
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//TODO - caso a distribuição quebre os hibridos terão que ser distribuidos considerando a regra de conflito de interesse
//seria interessante até mesmo começar a separar os trabalhos e avaliadores por nivel caso isso acontecesse
//assim os hibridos que teriam conflito de interesse com certa nivel seriam priorizados em outra 

function distribuiHibridos(&$hibridos, &$mediaPorArea, &$trabalhosPorArea, &$avaliadoresPorArea)
{
    
    foreach ($hibridos as $hibrido) {
        
        // calcula a média de todas as áreas a cada interação
        foreach ($mediaPorArea as $area => $media) {
            $mediaPorArea[$area] = round((count($trabalhosPorArea[$area]) / count($avaliadoresPorArea[$area])), 4);
        }

        $hibridoSelecionado = null;

        // procura o hibrido com menos áreas na área que tem a maior média

        foreach ($hibridos as $index => $hibrido) {
            /* echo '<pre>';
            print_r($hibrido);
            echo '</pre>';
            die();  */
            if (in_array(array_search(max($mediaPorArea), $mediaPorArea),  $hibrido['areas']) && ($hibridoSelecionado === null || count($hibridoSelecionado['areas']) > count($hibrido['areas']))) {
                $hibridoSelecionado = $hibrido;
            }
        }

        if ($hibridoSelecionado !== null) {
            $avaliadoresPorArea[array_search(max($mediaPorArea), $mediaPorArea)][] = $hibridoSelecionado;
            unset($hibridos[array_search($hibridoSelecionado, $hibridos)]);
        } else {
            // caso a área que tenha maior média não tenha mais hibridos disponiveis, o codigo tenta cadastrar esse hibrido em uma das áreas que ele é cadastrado e que tenha a maior média

            $maiorMedia = array_reduce($hibrido['areas'], function ($carry, $area) use ($mediaPorArea) {
                return max($carry, $mediaPorArea[$area]);
            }, 0);

            $areasComMaiorMedia = array_keys($mediaPorArea, $maiorMedia);

            $avaliadoresPorArea[$areasComMaiorMedia[0]][] = $hibrido;

            unset($hibridos[$index]);
        }
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function distribuiTrabalho(&$trabalhos, &$avaliadores, $media)
{
    //distribuição seguindo a média e as regras de negocio
    //TODO - avaliadores orientadores etc etc...
    foreach ($trabalhos as &$trabalho) {
        foreach ($avaliadores as &$avaliador) {
            if (!in_array($trabalho['id_area'], $avaliador['areas'])) {
                continue;
            }
            if ($trabalho['nivel'] == $avaliador['orienta']) {
                continue;
            }
            if (count($trabalho['avaliadores']) >= 3) {
                continue;
            }
            if (count($avaliador['trabalhos']) > $media) {
                continue;
            }
            if (in_array($avaliador['id'], $trabalho['avaliadores']) ||  in_array($trabalho['id'], $avaliador['trabalhos'])) {
                continue;
            }
            $trabalho['avaliadores'][] = $avaliador['id'];
            $avaliador['trabalhos'][] = $trabalho['id'];
            //  //print_r($avaliador);
            //  //echo '<br>';
            //  //print_r($trabalho);
        }
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

distribuiHibridos($hibridos, $mediaPorArea, $trabalhosPorArea, $avaliadoresPorArea);

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// foreach ($avaliadoresPorArea as $area => &$avaliadoresArea) {
//     foreach ($avaliadoresArea as &$avaliador) {
//         foreach ($trabalhosPorArea[$area] as $trabalho) { 
//             if (($trabalho['cpf_coorientador'] == '00000000147')) {
//                 echo "aaa";
//                 echo "<br>";
//                 // $avaliador['orienta'] = $trabalho['categoria'];
//                 break;
//             }
//         }
//     }
// }

//echo json_encode($trabalhosPorArea, JSON_UNESCAPED_UNICODE);
//echo json_encode($avaliadoresPorArea, JSON_UNESCAPED_UNICODE);
//echo json_encode($mediaPorArea, JSON_UNESCAPED_UNICODE);


//TODO - alguns avaliadores VAO ficar com poucos trabalhos, nao tem o que fazer!!! imagine a situação em que
//uma area em especifico tem bem mais trabalhos do ensino médio, a chance de um avaliador daquela area 
//ser um orientador é alta! entao logicamente ele vai ter que avaliar os trabalhos do ensino fundamental
// que sao poucos!


//TODO - CASO PRECISE AUMENTAR O NUMERO DE AVALIADORES POR TRABALHO
$numeroMaximoAvaliadoresPorTrabalhos = 3;
// $contador = -1;


foreach ($mediaPorArea as $area => $med) {
    $totalAvaliadores = count(array_merge(...array_column($trabalhosPorArea[$area], 'avaliadores')));
    //TODO - ???????????? CASO A DISTRIBUIÇÃO PARE PRECISARIA DE TER UM BREAK MAS ISSO QUEBRA O CODIGO XDD
    // if($totalAvaliadores > $contador){
    //     $contador = $totalAvaliadores;
    // } else {
    //     break;
    //     //TODO BREAK PARA CASO TENHA PARADO DE AVALIAR?
    //     //acho que nunca vai chegar aqui, caso o while fique infinito o php vai para a aplicação.
    // }
    //linha de código em questão está calculando o número total de avaliadores para os trabalhos associados a uma área.
    // basicamente ela pega a coluna 'avaliadores' da area especifica (que ta sendo rodada no foreach) no array $trabalhosporarea, pega cada avaliador (...) adiciona eles em um array (array_merge) e depois faz o count desse array. (dicks: leia ela do final para o começo!!)
    $media = intdiv(count($trabalhosPorArea[$area]), count($avaliadoresPorArea[$area]));

    while ($totalAvaliadores < ((count($trabalhosPorArea[$area])) * $numeroMaximoAvaliadoresPorTrabalhos)) {
        distribuiTrabalho($trabalhosPorArea[$area], $avaliadoresPorArea[$area], $media);
        $totalAvaliadores = count(array_merge(...array_column($trabalhosPorArea[$area], 'avaliadores')));
        $media++;
        //na primeira interação ele distribui baseado na média (mais ou menos uns 2? sei la) ai entao ele conta o total de avaliadores distribuidos nos trabalhos e como cada trabalho tem que ter no minimo 3 avaliadores o numero total de avaliadores distribuidos tem que ser o total de trabalhos * 3, para atingir essa meta a cada interação a média é subida em um até o valor do total de avaliadores seja atingido xdding
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function cadastrarDistribuicao($conn, $mediaPorArea, $trabalhosPorArea)
{
    //banco de dados n preciso expligar YEP
    $sql = "INSERT INTO avaliacao(id_avaliador, id_trabalho, id_questao, nota) VALUES (:idAvaliador, :idTrabalho, :idQuestao, :nota)";
    $stmt = $conn->prepare($sql);

    foreach ($mediaPorArea as $area => $med) {
        foreach ($trabalhosPorArea[$area] as $trabalho) {
            $stmt->bindValue(':idTrabalho', $trabalho['id'], PDO::PARAM_STR);
            foreach ($trabalho['avaliadores'] as $idAvaliador) {
                $stmt->bindValue(':idAvaliador', $idAvaliador, PDO::PARAM_STR);
                foreach ($trabalho['questoes'] as $idQuestao) {
                    $stmt->bindValue(':idQuestao', $idQuestao, PDO::PARAM_STR);
                    $stmt->bindValue(':nota', null, PDO::PARAM_STR);
                    $stmt->execute();
                }
            }
        }
    }
}


//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

foreach ($mediaPorArea as $area => $media) {
    echo "=============================={AREA'$area'}==============================";
    echo "<br>";
    echo "Total de " . count($trabalhosPorArea[$area]) .
        " trabalhos e " . count($avaliadoresPorArea[$area]) . " avaliadores";
    echo '<br>';
    $ids = array_merge(array_column($avaliadoresPorArea[$area], 'trabalhos'));
    $relatorio = array();


    foreach ($ids as $id) {
        $num_trabalhos = count($id);
        if (array_key_exists($num_trabalhos, $relatorio)) {
            $relatorio[$num_trabalhos]++;
        } else {
            $relatorio[$num_trabalhos] = 1;
        }
    }

    foreach ($relatorio as $num_trabalhos => $num_avaliadores) {
        echo "Existem {$num_avaliadores} avaliadores que têm {$num_trabalhos} trabalhos cadastrados.\n";
    }
    echo '<br>';
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//echo json_encode($avaliadoresPorArea, JSON_UNESCAPED_UNICODE);

/* echo '<pre>';
print_r($mediaPorArea);
die(); */

//TODO CADASTRA NO BANCO XDD

cadastrarDistribuicao($conn, $mediaPorArea, $trabalhosPorArea);

//* Cria um objeto JSON com chaves distintas para cada array
$infoDistribuicao = [
    "avaliadoresPorArea" => $avaliadoresPorArea, 
    "mediaPorArea" => $mediaPorArea,
    "listaOrientadores" => $listaOrientadores
];

//* Meio que "formata" o array $infoDistribuicao e guarda na variável $arraySerializada
$arraySerializada = json_encode($infoDistribuicao);

//* Pega os dados da $arraySerializada e guarda/salva/escreve no arquivo infoDistribuicao.json, se ainda não tiver o arquivo
//* Ele cria um novo, e se já tiver e for guardar novamente, sobrescreve
file_put_contents("../infoDistribuicao.json", $arraySerializada);

//* Direcionamento para a página do logDistriuicao.php
return header('Location: ./../view/adm/logDistribuicao.php');

// echo "eu odeio php";