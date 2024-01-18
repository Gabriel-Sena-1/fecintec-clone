<?php
require_once(__DIR__ . '/../Util/conectaPDO.php');
//echo '<pre>';

// function ordenaCriterios(){
    
//     $conn = conecta();

//     /*                          TIPO DE PESQUISA 1                                       */

//     $sql = "SELECT * FROM questao WHERE id_tipo_de_pesquisa = 1";

//     $stmt = $conn->prepare($sql);
//     $stmt->execute();

//     $criterios1 = array();
//     $criterios1 = $stmt->fetchAll();

//     $criterios1Ordenado = array();


//     $criterios1Ordenado[] = array(
//         'id' => $criterios1[7]['id'],
//         'criterio' => $criterios1[7]['criterio']
//     );

//     $criterios1Ordenado[] = array(
//         'id' => $criterios1[8]['id'],
//         'criterio' => $criterios1[8]['criterio']
//     );

//     $criterios1Ordenado[] = array(
//         'id' => $criterios1[3]['id'],
//         'criterio' => $criterios1[3]['criterio']
//     );

//     $criterios1Ordenado[] = array(
//         'id' => $criterios1[4]['id'],
//         'criterio' => $criterios1[4]['criterio']
//     );

//     $criterios1Ordenado[] = array(
//         'id' => $criterios1[5]['id'],
//         'criterio' => $criterios1[5]['criterio']
//     );

//     /*                          TIPO DE PESQUISA 2                                       */

//     $sql = "SELECT * FROM questao WHERE id_tipo_de_pesquisa = 2";

//     $stmt = $conn->prepare($sql);
//     $stmt->execute();

//     $criterios2 = array();
//     $criterios2 = $stmt->fetchAll();

//     $criterios2Ordenado = array();


//     $criterios2Ordenado[] = array(
//         'id' => $criterios2[7]['id'],
//         'criterio' => $criterios2[7]['criterio']
//     );

//     $criterios2Ordenado[] = array(
//         'id' => $criterios2[8]['id'],
//         'criterio' => $criterios2[8]['criterio']
//     );

//     $criterios2Ordenado[] = array(
//         'id' => $criterios2[3]['id'],
//         'criterio' => $criterios2[3]['criterio']
//     );

//     $criterios2Ordenado[] = array(
//         'id' => $criterios2[4]['id'],
//         'criterio' => $criterios2[4]['criterio']
//     );

//     $criterios2Ordenado[] = array(
//         'id' => $criterios2[5]['id'],
//         'criterio' => $criterios2[5]['criterio']
//     );

//     $final['1'] = $criterios1Ordenado;
//     $final['2'] = $criterios2Ordenado;

//     return $final;
// }

// function desempataAvaliadores($avaliacao){
//     $criterios = ordenaCriterios();
//     $aux = [];
//     $final = array(
//         'id' => null,
//         'peso' => 0
//     );

//     foreach($criterios as $criterio){
//         foreach($criterio as $item){
//             foreach($avaliacao as $key){
//                 if($key['id_questao'] == $item['id']){
//                     $aux[] = $key;
//                 }
//                 if(count($aux) > 1){
//                     if($aux[0]['nota'] > $aux[1]['nota']){
//                         $final['id'] = $aux[0]['id_avaliador'];
//                         $final['peso']++;
//                     }else if($aux[0]['nota'] < $aux[1]['nota']){
//                         $final['id'] = $aux[1]['id_avaliador'];
//                         $final['peso']++;
//                     }
//                     $aux = [];
//                 }               
//             }   
//         }
//     }

//     return $final;

// }

//TODO função onde é buscado no banco de dados os dados: nota, id do trabalho, tipo de pesquisa e o id avaliador. 
function queryBusca($trabalhos) 
{
    $conn = conecta(); //TODO conexão do banco de dados!!!
    $media = array();
    foreach ($trabalhos as $trabalho) {
        $nota = 0;
        $idt = $trabalho['id'];


        $sql = "SELECT a.nota, a.id_trabalho, t.id_tipo_de_pesquisa, a.id_avaliador, a.id_questao FROM avaliacao a, trabalho t
        WHERE a.id_trabalho = :idt
        AND a.nota is not null
        AND a.status = 1
        AND t.id = a.id_trabalho
        AND t.ativo = true
        ORDER BY id_avaliador DESC";


        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':idt', $idt, PDO::PARAM_STR);
        $stmt->execute();


        $avaliacoes = array();
        $avaliacoes = $stmt->fetchAll(); //TODO busca e colocando os dados da busca na variavel avaliacoes


        // if (count($avaliacoes) > 27) { //TODO verificação se tem mais de 3 avaliações ou seja mais de 27 notas...
        //     $somatorioAvaliacoes = 0;
        //     $somatorioAux = [];
        //     $somatorioFinal = [];
        //     for ($i = 0; $i < count($avaliacoes); $i++) { //TODO reordena e calcula o somatorio de cada avaliação!!!
        //         if (isset($avaliacoes[$i + 1]['id_avaliador']) && $avaliacoes[$i]['id_avaliador'] == $avaliacoes[$i + 1]['id_avaliador']) {
        //             $somatorioAvaliacoes += $avaliacoes[$i]['nota']; //TODO basicamente estou fazendo um somatorio de notas 
        //         } else if (!isset($avaliacoes[$i + 1]['id_avaliador']) || $avaliacoes[$i]['id_avaliador'] != $avaliacoes[$i + 1]['id_avaliador']) { //TODO quando o proximo avaliador não for o que esta sendo contado ele irá guardar o valor do somatorio e salvar o id do avaliador indicando ser dele..
        //             $somatorioAvaliacoes += $avaliacoes[$i]['nota'];
        //             $somatorioAux['nota'] = $somatorioAvaliacoes;
        //             $somatorioAux['id_avaliador'] = $avaliacoes[$i]['id_avaliador'];
        //             $somatorioFinal[] = $somatorioAux;
        //             $somatorioAvaliacoes = 0;
        //         }
        //     }
        //     $minimo = [];

        //     while (count($somatorioFinal) > 3) {
        //         $aux = [];

        //         foreach($somatorioFinal as $item1){
        //             foreach($somatorioFinal as $item2){
        //                 if($item1['nota'] == $item2['nota'] && $item1['id_avaliador'] != $item2['id_avaliador']){//TODO se entrar aqui é pq existe duas notas iguais(empatadas) ou seja DESEMPATEEE
        //                     foreach($avaliacoes as $avaliacao){
        //                         if($item1['id_avaliador'] == $avaliacao['id_avaliador']){
        //                             $aux[] = $avaliacao;
        //                         }
        //                     }
        //                     if(count($aux) > 9){
        //                         $desempatado = desempataAvaliadores($aux);

        //                         if($desempatado['id'] == null){
                                    
        //                         }else{
        //                             print_r($somatorioFinal);
        //                             for($i = 0; $i < count($somatorioFinal); $i++){
        //                                 if($somatorioFinal[$i]['id_avaliador'] == $desempatado['id']){
        //                                     $somatorioFinal[$i]['nota'] += 0.1;
        //                                 }
        //                             }
        //                         }
        //                     }
        //                 }
        //             }
        //         }
        //         echo '________________________<br>';
        //         print_r($somatorioFinal);
                
        //         $auxiliar = min($somatorioFinal);//!alfinetar aqui, fds os maiores o bglh é retirar o minimo
        //         $minimo[] = $auxiliar;

        //         for($i = 0; $i < count($somatorioFinal); $i++){     //TODO sempre sera retirado a menor nota (seja la ela empatada ou n), até que fique apenas 3 avaliações!!!
        //             if($somatorioFinal[$i] == $auxiliar){                    
        //                 array_splice($somatorioFinal, $i, 1);
        //             }
        //         }
                

        //     }

        //     for($i = 0; $i < count($minimo); $i++){                 //TODO esses for's percorrer e comparam retirando os avaliadores com as menores avalições!!
        //         for($j = 0; $j < count($avaliacoes); $j++){
        //             if($avaliacoes[$j]['id_avaliador'] == $minimo[$i]['id_avaliador']){
        //                 array_splice($avaliacoes, $j, 1);
        //                 $j--;
        //             }
        //         }
        //     }
        // }

        if($avaliacoes != null){                                    //TODO condição para tirar os trabalhos não avaliados
            print_r($avaliacoes);
            $valores = [];                                          //TODO array para colocar a media das notas e jogar dentro do outro array $media
            
            $tipo = 0;
            
            foreach ($avaliacoes as $avaliacao) {                   //TODO distribuindo e fazendo o somatorio das notas
                $nota += $avaliacao['nota'];
                $valores['nota'] = $nota;
                $tipo = $avaliacao['id_tipo_de_pesquisa'];
            }
                       
            $valores['nota'] = $valores['nota'] / 27;               //TODO calculando a media do trabalho, sendo: 9 notas de cada avaliador(3 avaliadores), logo 3*9 = 27


            foreach ($valores as $item) {                           //TODO colocando o somatorio das notas no array media
                $media[] = array(
                    'id' => $idt,
                    'nota' => $item,
                    'tipo' => $tipo
                );
            }


            usort($media, function($a, $b) {                        //TODO ordena as notas do array media de forma decrescente!!

                if ($a['nota'] == $b['nota']) {
                    return 0;
                }
                return ($a['nota'] > $b['nota']) ? -1 : 1;
            });
        }
    }

    return $media;
}

function buscaNota($ida, $nivel)
{
    $conn = conecta();

    $sqlTrabalho = "SELECT id FROM trabalho WHERE id_area_de_conhecimento = :ida and nivel = :nivel"; //TODO busca do id e do tipo de pesquisa de todos os trabalhos
    $stmt = $conn->prepare($sqlTrabalho);
    $stmt->bindValue(':ida', $ida, PDO::PARAM_STR);
    $stmt->bindValue(':nivel', $nivel, PDO::PARAM_STR);
    $stmt->execute();
    $trabalhos = array();
    $trabalhos = $stmt->fetchAll();
    
    return queryBusca($trabalhos);
}


function procuraEmpate($ida, $nivel)
{
    $notas = buscaNota($ida, $nivel);
    $empatados = array();
    $aux = null;
    $rankingAux = $notas;


    for ($i = 0; $i < count($notas); $i++) {
        if ($i + 1 == count($notas)) {
            break;
        } else {
            if ($notas[$i]['nota'] == $notas[$i + 1]['nota']) {

                if ($aux != $notas[$i]['id'] || $aux == null) {
                    $empatados[] = array(
                        'id' => $notas[$i]['id'],
                        'nota' => $notas[$i]['nota'],
                        'tipo' => $notas[$i]['tipo']
                    );
                }
                $empatados[] = array(
                    'id' => $notas[$i + 1]['id'],
                    'nota' => $notas[$i + 1]['nota'],
                    'tipo' => $notas[$i + 1]['tipo']
                );


                $aux = $notas[$i + 1]['id'];
            } else if ($notas[$i]['nota'] != $notas[$i + 1]['nota']) {
                if ($empatados != []) {
                    $retorno = [];
                    $retorno1 = [];
                    $retorno = desempate($empatados);


                    foreach($retorno as $value){
                        $retorno1[] = $value[0];                            //TODO limpa os array de array.
                    }

                    $empatadosNotas = queryBusca($retorno1);                //TODO busca as medias certas dos trabalhos ja desempatados.
               
                    
                    for($l = 0; $l < count($empatadosNotas); $l++){
                        if($empatadosNotas[$l]['nota'] == null){
                            array_splice($empatadosNotas, $l, 1);            //TODO apenas para tirar uns malcriado q estava com a nota nula.

                            $l = 0;
                        }
                    }

                    for ($v = 0; $v < count($empatadosNotas); $v++) {
                        $aux2 = false;

                        for($m = 0; $m < count($rankingAux); $m++){
                            if($rankingAux[$m] == $empatadosNotas[$v]){      //TODO aqui é retirado e colocado em ordem correta no rankingFinal

                                array_splice($rankingAux, $m, 1);
                                $aux = $m;
                                $m--;
                                $aux2 = true;
                            }
                        }
                        if ($aux2 == true) {
                            $rankingAux = array_merge(array_slice($rankingAux, 0, $aux), $empatadosNotas, array_slice($rankingAux, $aux));
                        }

                        while (count($rankingAux) != count($notas)) {
                            foreach ($rankingAux as $key => $value) {
                                foreach ($empatadosNotas as $key2) {
                                    if ($value['id'] == $key2['id']) {
                                        array_splice($rankingAux, $key, 1);
                                    }
                                }
                                if (count($rankingAux) == count($notas)) {
                                    break;
                                }
                            }
                        }
                    }
                    $empatados = [];
                } else if ($i == count($notas) - 2 && $empatados == []) {
                    return $notas;
                }
            }
        }
    }
    return $rankingAux;
}



function descartarAvaliacao()
{
    $conn = conecta();

    $sql = "DELETE FROM avaliacao";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();

    return $result;
}

if (isset($_GET['act']) && $_GET['act'] == 'excluirAvaliacao') {
    descartarAvaliacao();
}

function DesempataCritério($trabalhos)
{
    $rankingAux = [];

    for ($t = 0; $t < count($trabalhos); $t++) {
        for ($c = 0; $c < 5; $c++) {
            if (isset($trabalhos[$t])) {
                if ($t == count($trabalhos) - 1) {
                    break;
                } else if ($trabalhos[$t][$c]['nota'] > $trabalhos[$t + 1][$c]['nota'] && $trabalhos[$t][$c]['id'] != $trabalhos[$t + 1][$c]['id']) {
                    if (!empty($trabalhos[$t + 1])) {
                        $trabalhos[$t]['peso']++; 
                        array_push($rankingAux, $trabalhos[$t]);
                    }
                    break;
                } else if ($trabalhos[$t][$c]['nota'] < $trabalhos[$t + 1][$c]['nota'] && $trabalhos[$t][$c]['id'] != $trabalhos[$t + 1][$c]['id']) {
                    if ($rankingAux != $trabalhos[$t + 1]) {
                        $trabalhos[$t + 1]['peso']++;
                        array_push($rankingAux, $trabalhos[$t + 1]);
                    }
                    break;
                }
            }
        }
    }

    if ($rankingAux == null) {
        $id1 = $trabalhos[0][0]['id'];
        $id2 = $trabalhos[1][0]['id'];
        $msg = "Desempate impossivel de ser realizado!!/nID trabalhos com problema de Desempate: $id1 e $id2.";
        header('Location: ../View/adm/saguaoAdm.php?msg=' . $msg . '&trabalho1=' . $id1 . '&trabalho2=' . $id2);
        die($msg);
    }

    return $rankingAux;
}


function desempate($empatados)
{
    $conn = conecta();

    /*                          TIPO DE PESQUISA 1                                       */

    $sql = "SELECT * FROM questao WHERE id_tipo_de_pesquisa = 1";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $criterios1 = array();
    $criterios1 = $stmt->fetchAll();

    $criterios1Ordenado = array();


    $criterios1Ordenado[] = array(
        'id' => $criterios1[7]['id'],
        'criterio' => $criterios1[7]['criterio']
    );

    $criterios1Ordenado[] = array(
        'id' => $criterios1[8]['id'],
        'criterio' => $criterios1[8]['criterio']
    );

    $criterios1Ordenado[] = array(
        'id' => $criterios1[3]['id'],
        'criterio' => $criterios1[3]['criterio']
    );

    $criterios1Ordenado[] = array(
        'id' => $criterios1[4]['id'],
        'criterio' => $criterios1[4]['criterio']
    );

    $criterios1Ordenado[] = array(
        'id' => $criterios1[5]['id'],
        'criterio' => $criterios1[5]['criterio']
    );

    /*                          TIPO DE PESQUISA 2                                       */

    $sql = "SELECT * FROM questao WHERE id_tipo_de_pesquisa = 2";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $criterios2 = array();
    $criterios2 = $stmt->fetchAll();

    $criterios2Ordenado = array();


    $criterios2Ordenado[] = array(
        'id' => $criterios2[7]['id'],
        'criterio' => $criterios2[7]['criterio']
    );

    $criterios2Ordenado[] = array(
        'id' => $criterios2[8]['id'],
        'criterio' => $criterios2[8]['criterio']
    );

    $criterios2Ordenado[] = array(
        'id' => $criterios2[3]['id'],
        'criterio' => $criterios2[3]['criterio']
    );

    $criterios2Ordenado[] = array(
        'id' => $criterios2[4]['id'],
        'criterio' => $criterios2[4]['criterio']
    );

    $criterios2Ordenado[] = array(
        'id' => $criterios2[5]['id'],
        'criterio' => $criterios2[5]['criterio']
    );

    $notasTrabalhos = [];
    $trabalhoAux = [];
    $rankingAux = [];
    $ranking = [];

    for($i = 0; $i < count($empatados); $i++){           //TODO roda o id dos trabalhos
        for($j = 0; $j < 5; $j++){                       //TODO roda o id dos criterios e busca a nota do criterio

            $somatorio = 0;
            $sql = "SELECT a.nota FROM avaliacao a 
            WHERE id_questao = :idq
            AND a.nota is not null
            AND a.status = 1
            AND id_trabalho = :idt
            ORDER BY nota DESC
            LIMIT 3";

            $stmt = $conn->prepare($sql);
            if ($empatados[$i]['tipo'] == 1) {
                $stmt->bindValue(':idq', $criterios1Ordenado[$j]['id'], PDO::PARAM_STR);
            } else {
                $stmt->bindValue(':idq', $criterios2Ordenado[$j]['id'], PDO::PARAM_STR);
            }
            $stmt->bindValue(':idt', $empatados[$i]['id'], PDO::PARAM_STR);
            $stmt->execute();

            $notas = array();
            $notas = $stmt->fetchAll();

            foreach ($notas as $nota) {
                $somatorio += $nota['nota'];
            }

            $notasTrabalhos[] = array(
                'id' => $empatados[$i]['id'],
                'nota' => $somatorio / 3
            );
        }

        $trabalhoAux[] = $notasTrabalhos;
        for ($l = 0; $l < count($trabalhoAux); $l++) {
            $trabalhoAux[$l]['peso'] = 0;
        }
        $notasTrabalhos = [];
    }

    for ($t = 0; $t < count($trabalhoAux); $t++) {
        for ($u = $t; $u < count($trabalhoAux); $u++) {
            if ($u == count($trabalhoAux)) {
                break;
            } else {
                $trabalhos = [];
                if ($trabalhoAux[$t] != $trabalhoAux[$u]) {

                    $trabalhos[] = $trabalhoAux[$t];
                    $trabalhos[] = $trabalhoAux[$u];


                    if (count($empatados) == 2 && count($trabalhoAux) == 2) {     //TODO se for um empate de 2, ja é guardado a maior nota no ranking final, porque é a maior nota definitivamente
                        $rankingAux[] = DesempataCritério($trabalhos);

                        if ($trabalhoAux[0][0]['id'] == $rankingAux[0][0][0]['id']) {
                            array_splice($trabalhoAux, 0, 1);
                        } else {
                            array_splice($trabalhoAux, 1, 1);
                        }
                        $rankingAux[] = $trabalhoAux;


                        foreach($rankingAux as $key => $value){
                            $ranking[] = $value[0];                             //TODO limpa os array de array.
                        }

                        return $ranking;
                    } else {
                        $rankingAux = DesempataCritério($trabalhos);

                        foreach ($trabalhoAux as $key => $value) {
                            foreach ($rankingAux as $key2 => $value2) {
                                if ($value[0]['id'] == $value2[0]['id']) {
                                    $trabalhoAux[$key] = $rankingAux[$key2];
                                }
                            }
                        }
                    }
                }
            }
        }
    }


    usort($trabalhoAux, function($a, $b) {              //TODO ordena o array do bloco de empatados de forma decrescente de acordo com o peso!!!
        if ($a['peso'] == $b['peso']) {
            return 0;
        }
        return ($a['peso'] > $b['peso']) ? -1 : 1;
    });

    return $trabalhoAux;
}
function primeirosColocados($rankingEM)
{
    $conn = conecta();

    foreach ($rankingEM as $key => $value) {

        for ($i = 0; $i < 3; $i++) {
            if (!isset($value[$i]['id']) || empty($value[$i]['id'])) {
                break;
            }
            $sql = "SELECT t.titulo, e.nome, t.nome_orientador, t.nome_coorientador, t.instituicao FROM trabalho t, estudante_trabalho et, estudante e where t.id = :id AND et.id_trabalho = :id AND e.id = et.id_estudante";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $value[$i]['id'], PDO::PARAM_STR);
            $stmt->execute();
            $ranking[] = $stmt->fetchAll();
        }
        $rankingAux = [];

        foreach($ranking as $key2 => $value){
            $rankingAux[] = $value[0];                  //TODO limpa os array de array.

        }
        $ranking = [];


        $rankingFinal[$key] = $rankingAux;
    }
    return $rankingFinal;
};

function call()
{

    $nivel = 'EM';
    $rankingEM = [];
    $rankingEF = [];

    for ($i = 1; $i < 6; $i++) {
        $rankingEM[$i] = procuraEmpate($i, $nivel);
    }

    $nivel = 'EF';

    for ($i = 1; $i < 6; $i++) {
        $rankingEF[$i] = procuraEmpate($i, $nivel);
    }

    $arrayFinal['EM'] = primeirosColocados($rankingEM);
    $arrayFinal['EF'] = primeirosColocados($rankingEF);

    return $arrayFinal;
}

//call();


function trabalhosAvaliadosAvaliador($idAvaliador)
{
    $conn = conecta();

    try {
        $sql = "SELECT a.id_trabalho, t.titulo 
        FROM avaliacao a, trabalho t 
        WHERE id_avaliador = $idAvaliador 
        AND a.id_trabalho = t.id 
        AND a.nota != 0 
        AND a.nota IS NOT NULL
        GROUP BY id_trabalho";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $trabalhos = [];


        foreach ($result as $trabalho) {
            $trabalho['id_trabalho'];
            $trabalho['titulo'];

            $trabalhos[] = $trabalho;
        }
        return $trabalhos;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function verificaDistribuicao(){

	$conn = conecta();

	try{

		$sql = "SELECT * FROM avaliacao";
		$stmt = $conn->prepare($sql);
		
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		//* Se não estiver vazio significa que a distribuição foi feita
		if(!empty($result)){
			return true;
		}
		else{ //* Caso contrário significa que a distribuição ainda não foi realizada
			return false;
		}

	}catch (PDOException $e){
		echo $e->getMessage();
		echo "<br> Erro na função verificaDistribuicao";
	}

}




    /*
    *+---------------------------------------------------------+
    *|                // Tabela de critérios                   |
    *+---------------------------------------------------------+
    *|/////////////////////////////////////////////////////////|
    *+---------------------------------------------------------+
    *|  I          Maior nota na apresentação oral             |
    *+---------------------------------------------------------+
    *|  II           Maior nota na apresentação visual         |
    *+---------------------------------------------------------+
    *|  III         Maior nota no resumo expandido             |
    *+---------------------------------------------------------+
    *|  IV                 Maior nota banner                   |
    *+---------------------------------------------------------+
    *|  V          Maior nota no relatório de trabalho         |
    *+---------------------------------------------------------+
    */
