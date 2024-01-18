<?php
require_once __DIR__ . '/../Util/conectaPDO.php';
require_once __DIR__ . '/../Model/Trabalho.php';

// usado no ...
function buscaTrabalhoNotas($idAvaliador)
{
    $conn = conecta();

    try {
        $sql = "SELECT t.id, t.titulo FROM trabalho t 
        INNER JOIN avaliacao a 
        ON t.id = a.id_trabalho 
        INNER JOIN avaliador av 
        ON a.id_avaliador = av.id
        WHERE av.id = '$idAvaliador'
        GROUP BY t.id
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $trabalhos = [];
        $trabalhosENotas = [];

        foreach ($result as $trabalho) {
            $trabalhos[$trabalho['id']] = $trabalho['titulo'];
        }

        foreach ($trabalhos as $id => $trabalho) {
            $sqlNotas = "SELECT GROUP_CONCAT(a.nota) AS nota FROM avaliacao a INNER JOIN questao q ON q.id = a.id_questao
            WHERE a.id_trabalho = '$id' AND a.id_avaliador = '$idAvaliador' AND lower(q.criterio) != 'resumo expandido'";

            $stmt = $conn->prepare($sqlNotas);
            $stmt->execute();
            $result = $stmt->fetchall(PDO::FETCH_ASSOC);

            $trabalhosENotas[$trabalho] = [$result[0]['nota'], $id];
        }

        return $trabalhosENotas;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
};

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// usado na pagina alterarAvaliador.php
function buscarTrabalho($idTrabalho) //! Conferir quando conseguir importar trabalho se esta certo, pq eu acho que não
{
    $conn = conecta();

    try {
        $sql = "SELECT trabalho.titulo, trabalho.nivel,
		o.nome AS nome_orientador, c.nome AS nome_coorientador,
        GROUP_CONCAT(e.nome SEPARATOR ', ') AS nome_estudante,
        area_de_conhecimento.descricao, tipo_de_pesquisa.descricao AS tipo, GROUP_CONCAT(CONCAT(questao.id, ' ',  questao.criterio) SEPARATOR ' / ') AS questoes
        FROM trabalho
        JOIN orientador o ON o.id = trabalho.id_orientador 
        JOIN orientador c ON c.id = trabalho.id_coorientador
        JOIN estudante_trabalho ON estudante_trabalho.id_trabalho = trabalho.id
        JOIN estudante e ON e.id = estudante_trabalho.id_estudante
        JOIN questao ON trabalho.id_tipo_de_pesquisa = questao.id_tipo_de_pesquisa
        JOIN tipo_de_pesquisa ON trabalho.id_tipo_de_pesquisa = tipo_de_pesquisa.id
        JOIN area_de_conhecimento ON trabalho.id_area_de_conhecimento = area_de_conhecimento.id
        WHERE trabalho.id = '" . $idTrabalho . "'
        AND lower(questao.criterio) != 'resumo expandido'
        GROUP BY trabalho.id;";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//* apresenta tabela com todos os trabalhos aprovados na fase online
// usado na pagina tabelaTrabalhos.php
function listarTrabalhosAprovadosPorArea($nivel)
{
    $conn = conecta();

    try {
        $sqlTrabalho = "SELECT trabalho.id, trabalho.nivel, o.cpf AS cpf_orientador, c.cpf AS cpf_coorientador, trabalho.descricaoMDIS, o.email AS email_orientador, c.email AS email_coorientador, o.nome AS nome_orientador, c.nome AS nome_coorientador, trabalho.titulo, trabalho.notaResumo, trabalho.instituicao, trabalho.ativo, trabalho.id_tipo_de_pesquisa, trabalho.id_area_de_conhecimento
        FROM trabalho 
        JOIN orientador o ON o.id = trabalho.id_orientador
        JOIN orientador c ON c.id = trabalho.id_coorientador
        WHERE trabalho.nivel = '" . $nivel . "' AND ativo = 1 ORDER BY trabalho.id";

        $stmt = $conn->prepare($sqlTrabalho);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cria um array associativo para armazenar os trabalhos agrupados por área de conhecimento
        $trabalhosAgrupados = [];

        foreach ($result as $row) {
            // Adicione a área de conhecimento como índice no array
            $areaDeConhecimento = $row['id_area_de_conhecimento'];

            //cria array que contera os valores do trabalho
            $trabalho = [];

            $trabalho['id'] = $row['id'];
            $trabalho['nivel'] = $row['nivel'];
            $trabalho['titulo'] = $row['titulo'];

            $trabalho['nome_orientador'] = $row['nome_orientador'];
            $trabalho['cpf_orientador'] = $row['cpf_orientador'];
            $trabalho['email_orientador'] = $row['email_orientador'];

            $trabalho['nome_coorientador'] = $row['nome_coorientador'];
            $trabalho['cpf_coorientador'] = $row['cpf_coorientador'];
            $trabalho['email_coorientador'] = $row['email_coorientador'];

            $trabalho['tipo'] = $row['id_tipo_de_pesquisa'];

            // Busca os nomes dos estudantes 
            $sqlEstudantes = "SELECT estudante.nome
            FROM estudante 
            JOIN estudante_trabalho ON estudante_trabalho.id_estudante = estudante.id
            WHERE estudante_trabalho.id_trabalho = " . $row['id'];

            $stmt = $conn->prepare($sqlEstudantes);

            $stmt->execute();

            $result2 = $stmt->fetchAll();

            $trabalho['nome_estudante'] = $result2;
            //////////////////////////////////////////////////////////////

            $trabalho['instituicao'] = $row['instituicao'];
            $trabalho['ativo'] = $row['ativo'];

            // Adicione o trabalho ao array da área correspondente
            $trabalhosAgrupados[$areaDeConhecimento][] = $trabalho;
        }

        return $trabalhosAgrupados;
    } catch (\PDOException $e) {
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function buscarNotas($idTrabalho, $idAvaliador)
{
    $conn = conecta();

    try {
        $sql = "SELECT GROUP_CONCAT(CONCAT(id_questao, '-' , nota) SEPARATOR ' / ')  AS notas  FROM avaliacao WHERE id_trabalho = '$idTrabalho' AND id_avaliador = '$idAvaliador'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = explode(" / ", $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['notas']);
        $resultado = [];

        foreach ($result as $nota) {
            $partes = explode("-", $nota);
            $key = floatval($partes[0]);
            $value = floatval($partes[1]);
            $resultado[$key] = $value;
        }

        return $resultado;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//* Função que conta as linhas da tabela avaliação para verificar se a distribuição já aconteceu
function countTrabAvaliadores()
{
    $conn = conecta();

    try {
        $sql = "SELECT * FROM avaliacao";
        $stmt = $conn->prepare($sql);

        $stmt->execute();
        if ($stmt->rowCount() >= 1) {
            return true;
        }
        return false;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// usado no View/adm/resumoTrabalhos.php
function buscarTrabalhoSaguao()
{
    $conn = conecta();

    try {
        $sql = "SELECT 
                    t.id, t.titulo, ac.descricao AS area, orientador.nome, t.nivel 
                FROM 
                    trabalho t 
                JOIN 
                    area_de_conhecimento ac ON t.id_area_de_conhecimento = ac.id
                JOIN 
                    orientador ON t.id_orientador = orientador.id
                WHERE t.ativo = 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $trabalhos = [];

        foreach ($result as $row) {
            $trabalho = [];

            $trabalho['id'] = $row['id'];
            $trabalho['titulo'] = $row['titulo'];
            $trabalho['nome_orientador'] = $row['nome'];
            $trabalho['area'] = $row['area'];
            $trabalho['nivel'] = $row['nivel'];

            $trabalhos[] = $trabalho;
        }
        return $trabalhos;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//* Buscar informações essenciais para a vinculação de um novo avaliador em um trabalho
// usado na pagina alterarAvaliador.php
function buscarInfos($id)
{
    $conn = conecta();

    try {
        $conn->beginTransaction();

        $sqlTrabalho = "SELECT DISTINCT tr.*, ac.descricao, tp.descricao, usuario.nome, av.id id_avaliador FROM trabalho tr 
        JOIN area_de_conhecimento ac
        ON tr.id_area_de_conhecimento = ac.id 
        JOIN tipo_de_pesquisa tp
        ON tp.id = tr.id_tipo_de_pesquisa
        JOIN avaliacao ava
        ON ava.id_trabalho = tr.id
        JOIN avaliador av 
        ON av.id = ava.id_avaliador 
        JOIN usuario
        ON usuario.id = av.id_usuario
        WHERE tr.id = " . $id;
        $stmt = $conn->prepare($sqlTrabalho);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $trabalho = $result;
        return $trabalho;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//* Função para vincular um avaliador em um trabalho
// usado na pagina processaAvaliador.php
function adicionarAvaliador($idTrabalho, $idAvaliador, $idTipo)
{
    // Estabelece uma conexão com o banco de dados
    $conn = conecta();

    try {
        // Inicia uma transação no banco de dados
        $conn->beginTransaction();

        // Executa uma consulta para buscar questões com base no tipo de pesquisa
        $sqlBusca = "SELECT * FROM questao WHERE id_tipo_de_pesquisa = $idTipo";
        $busca = $conn->prepare($sqlBusca);
        $busca->execute();
        $result = $busca->fetchAll();


        $sqlNotaResumo = "SELECT notaResumo FROM trabalho WHERE id = $idTrabalho";
        $busca = $conn->prepare($sqlNotaResumo);
        $busca->execute();
        //por qual razão isso chega como um array?
        $notaResumo = $busca->fetch();
        foreach ($notaResumo as $notas) {
            $nota = $notas;
        }

        $sqlVincula = "INSERT INTO avaliacao(id_avaliador, id_trabalho, id_questao, nota) VALUES (:idAvaliador, :idTrabalho, :idQuestao, :nota)";

        $stmt = $conn->prepare($sqlVincula);

        // Define os valores dos parâmetros e executa a instrução SQL para cada questão encontrada
        $stmt->bindValue(':idTrabalho', $idTrabalho, PDO::PARAM_STR);
        $stmt->bindValue(':idAvaliador', $idAvaliador, PDO::PARAM_STR);

        foreach ($result as $questao) {


            $stmt->bindValue(':idQuestao', $questao['id'], PDO::PARAM_STR);

            // if($questao['id'] == 4 || $questao['id'] == 13){
            //     $notaCriterio = $nota;
            // }
            // else{
            //     $notaCriterio = null;
            // }
            $notaCriterio = ($questao['id'] == 4 || $questao['id'] == 13) ? $nota : null;

            $stmt->bindValue(':nota', $notaCriterio, PDO::PARAM_STR);
            $stmt->execute();
        }
        $resultado = $conn->commit();
        return $resultado;
    } catch (PDOException $e) {
        echo 'Erro na função adicionarAvaliador -- trabalhoController';
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function desclassificarTrabalho($idTrabalho)
{
    $conn = conecta();

    try {
        $conn->beginTransaction();

        $sql = "UPDATE trabalho SET ativo = :ativo
        WHERE id = $idTrabalho";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':ativo', "0", PDO::PARAM_STR);

        $stmt->execute();
        return $conn->commit();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function buscarAtivo($idTrabalho)
{
    $conn = conecta();

    try {
        $conn->beginTransaction();

        $sql = "SELECT ativo FROM trabalho
        WHERE id = $idTrabalho";
        $stmt = $conn->prepare($sql);

        $stmt->execute();
        $conn->commit();

        $result = $stmt->fetch();

        return $result['ativo'];
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//* Função que retorna a quantidade de linhas de avaliações de um trabalho, sem repetir avaliador
function countAvaliacoes($idTrabalho)
{

    $conn = conecta();

    //$sql = "SELECT DISTINCT id_avaliador FROM avaliacao INNER JOIN questao q ON q.id = id_questao WHERE id_trabalho = $idTrabalho AND nota != 'null' AND LOWER(q.criterio) != 'resumo expandido'";
    $sql = "SELECT DISTINCT id_avaliador 
    FROM avaliacao 
    INNER JOIN questao q ON q.id = id_questao 
    WHERE id_trabalho = $idTrabalho AND nota IS NOT NULL AND LOWER(q.criterio) != 'resumo expandido'";
    $busca = $conn->prepare($sql);

    $busca->execute();

    return $busca->rowCount();
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function trabalhosArea($idArea)
{

    $conn = conecta();

    $sqlTrabalho = "SELECT trabalho.id, trabalho.nivel, o.cpf AS cpf_orientador, c.cpf AS cpf_coorientador, trabalho.descricaoMDIS, o.email AS email_orientador, c.email AS email_coorientador, o.nome AS nome_orientador, c.nome AS nome_coorientador, trabalho.titulo, trabalho.notaResumo, trabalho.instituicao, trabalho.ativo, trabalho.id_tipo_de_pesquisa
    FROM trabalho 
    JOIN orientador o ON o.id = trabalho.id_orientador
    JOIN orientador c ON c.id = trabalho.id_coorientador
    WHERE id_area_de_conhecimento = :idArea;";
    $stmt = $conn->prepare($sqlTrabalho);
    $stmt->bindValue(':idArea', $idArea, PDO::PARAM_STR);

    $stmt->execute();

    $result = $stmt->fetchAll();

    $trabalhos = [];

    foreach ($result as $trabalho) {
        $idTrabalho = $trabalho['id'];

        $sqlEstudantes = "SELECT estudante.nome
        FROM estudante 
        JOIN estudante_trabalho ON estudante_trabalho.id_estudante = estudante.id
        WHERE estudante_trabalho.id_trabalho = :idTrabalho";

        $stmt = $conn->prepare($sqlEstudantes);
        $stmt->bindValue(':idTrabalho', $idTrabalho, PDO::PARAM_STR);

        $stmt->execute();

        $result2 = $stmt->fetchAll();

        $trabalho['nome_estudante'] = $result2;



        $trabalhos[] = $trabalho;
    }

    return $trabalhos;
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function buscarTodosOsTrabalhos()
{

    $conn = conecta();

    $sql = "SELECT * FROM trabalho";
    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchAll();

    return $result;
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function trabalhoJaCadastrado($titulo)
{

    $conn = conecta();

    $sql = "SELECT * FROM trabalho WHERE UPPER (titulo) LIKE '" . $titulo . "'";
    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchAll();
    if (empty($result)) {
        return false;
    }
    return true;
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// 
// function buscaCpfOrientador()
// {

//     $conn = conecta();

//     $sql = "SELECT cpf_orientador FROM trabalho";
//     $stmt = $conn->prepare($sql);

//     $stmt->execute();

//     $result = $stmt->fetchAll();

//     return $result;
// }

// TODO não usamos essa função
// function BuscaCpfCoorientador()
// {

//     $conn = conecta();

//     $sql = "SELECT cpf_coorientador FROM trabalho";
//     $stmt = $conn->prepare($sql);

//     $stmt->execute();

//     $result = $stmt->fetchAll();

//     return $result;
// }


function contaTodosTrabalhos()
{
    $conn = conecta();

    $sql = "SELECT COUNT(*) FROM trabalho";
    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchAll();

    return $result;
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function verificaQuestao($idTrabalho)
{
    $conn = conecta();

    $sql = "SELECT q.id FROM questao q 
            INNER JOIN tipo_de_pesquisa tp
            ON q.id_tipo_de_pesquisa = tp.id 
            INNER JOIN trabalho tr
            ON  tr.id_tipo_de_pesquisa = tp.id
            WHERE tr.id = $idTrabalho";
    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchAll();

    return $result;
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function contaDesclassificados()
{
    $conn = conecta();

    $sql = "SELECT COUNT(*) FROM trabalho WHERE ativo = 0";
    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchAll();

    return $result;
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function cadastrarTrabalhoPorPlanilha($trabalho, $areaTrabalho, $pesquisaTrabalho, $idOrientador, $idCoorientador)
{
    $conn = conecta();

    try {
        $conn->beginTransaction();

        $sql = "INSERT INTO trabalho(titulo, notaResumo, nivel,instituicao, ativo, id_area_de_conhecimento, id_tipo_de_pesquisa, id_orientador, id_coorientador) VALUES (:titulo, :notaResumo, :nivel,:instituicao, :ativo, :id_area_de_conhecimento, :id_tipo_de_pesquisa, :id_orientador, :id_coorientador)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':titulo', $trabalho->getTitulo(), PDO::PARAM_STR);
        $stmt->bindValue(':notaResumo', $trabalho->getNotaResumo(), PDO::PARAM_STR);
        $stmt->bindValue(':nivel', $trabalho->getNivel(), PDO::PARAM_STR);
        $stmt->bindValue(':instituicao', $trabalho->getInstituicao(), PDO::PARAM_STR);
        $stmt->bindValue(':ativo', $trabalho->getAtivo(), PDO::PARAM_STR);
        $stmt->bindValue(':id_area_de_conhecimento', $areaTrabalho, PDO::PARAM_STR);
        $stmt->bindValue(':id_tipo_de_pesquisa', $pesquisaTrabalho, PDO::PARAM_STR);
        $stmt->bindValue(':id_orientador', $idOrientador, PDO::PARAM_STR);
        $stmt->bindValue(':id_coorientador', $idCoorientador, PDO::PARAM_STR);

        $stmt->execute();


        // Obtém o ID inserido
        $trabalhoId = $conn->lastInsertId();

        $conn->commit();

        // Retorna o ID do orientador
        return $trabalhoId;
    } catch (PDOException $e) {
        $conn->rollBack();
        echo $e->getMessage();
        die($e);

        // $e = "Não foi possível cadastrar o trabalho!" . $trabalho->getTitulo();
        // header("Location: ../view/adm/saguaoadm.php?msg=$e");
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function verificaAvaliacaoTrabalho($idTrabalho, $idAvaliador)
{
    $conn = conecta();

    try {
        $conn->beginTransaction();

        $sql = "SELECT COUNT(nota) FROM avaliacao WHERE id_trabalho = $idTrabalho AND id_avaliador = $idAvaliador";
        $stmt = $conn->prepare($sql);

        $stmt->execute();

        $result = $stmt->fetchColumn();

        if ($result >= 8) { // if ($result == 9) -> antes estava assim. mas tivemos problema ao vincular um novo avaliador.. a nota do resumo não está indo pra ele.
            return true;
        }

        return false;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function buscarTrabalhoCredenciamento()
{
    $conn = conecta();

    try {
        $sql = "SELECT t.id, t.titulo, t.ativo, GROUP_CONCAT(e.nome SEPARATOR ', ') 
        AS nomes_estudantes
        FROM trabalho t
        JOIN estudante_trabalho et ON t.id = et.id_trabalho
        JOIN estudante e ON et.id_estudante = e.id
        GROUP BY t.id, t.titulo, t.ativo
                ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $trabalhos = [];

        foreach ($result as $trabalho) {
            $trabalho['id'];
            $trabalho['titulo'];
            $trabalho['ativo'];
            $nomes_estudantes = $trabalho['nomes_estudantes'];
            $nomes_estudantes_nao_Concat = [];
            $estudantes = explode(', ', $nomes_estudantes);

            foreach ($estudantes as $estudante) {
                if(verificaPresencaEstudantePorNome($estudante, $trabalho['id'])){
                    $nomes_estudantes_nao_Concat[] = "<p style='color: green;'>$estudante</p>";
                }
                else{
                    $nomes_estudantes_nao_Concat[] = "<p style='color: red;'>$estudante</p>";
                }
            }
            $nomes_estudantes_concatenados = implode(" ", $nomes_estudantes_nao_Concat);
            $trabalho['nomes_estudantes'] = $nomes_estudantes_concatenados;

            $trabalhos[] = $trabalho;
        }
        return $trabalhos;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function presencaTrabalho($idTrabalho)
{
    $conn = conecta();

    try {
        $conn->beginTransaction();

        $sql = "UPDATE trabalho SET ativo = :ativo
        WHERE id = $idTrabalho";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':ativo', "1", PDO::PARAM_STR);

        $stmt->execute();
        return $conn->commit();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//função que retorna a quantidade de instituições participantes sem repetir
function contaInstituicao()
{

    $conn = conecta();

    $sql = "SELECT COUNT(DISTINCT(instituicao)) as totalInstituicao FROM trabalho ";
    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchAll();

    return $result[0]['totalInstituicao'];
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//função gambiarra para remover as letras com acentos e substituir por letras equivalentes mas sem acento(pesquisem sobre preg_replace👍)
function removerAcentos($texto)
{
    return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(Ç)/", "/(ç)/"), explode(" ", "a A e E i I o O u U n N C c"), $texto);
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//*  Essa função pega as instituicoes, percorre todos os nomes e depois trata
//tratamento: chama a função removerAcentos, usa o strlower para deixar tudo minusculo e usa o trim para remover espaços
function contaInstituicao2()
{

    $conn = conecta();

    $sql = "SELECT instituicao FROM trabalho ";
    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $instituicoes = $stmt->fetchAll();

    foreach ($instituicoes as $instituicao) {
        echo "<pre>";
        echo $instituicao['instituicao'];
        $semAcento = removerAcentos($instituicao['instituicao']);
        $formatacao = str_replace('ª', '', $semAcento);
        $formatacao = str_replace('-', '', $formatacao);
        $formatacao = str_replace(')', '', $formatacao);
        $formatacao = str_replace('(', '', $formatacao);
        $nomeInstituicao[] = trim(strtolower(str_replace('.', '', $formatacao)));
    }

    $nomeSeparado = array();

    foreach ($nomeInstituicao as $nomeCorrigido) {
        $aux = explode(" ", $nomeCorrigido);
        $nomeSeparado[] = $aux;
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//* Essa função gera uma lista com todos os "ativos" e faz uma comparação pra saber se é ausente. Se for, adiciona no cont e retorna ele
function trabalhosAusentes()
{

    $conn = conecta();

    $sql = "SELECT ativo FROM trabalho ";
    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchAll();

    $cont = 0;

    foreach ($result as $status) {
        if ($status['ativo'] == 2) {
            $cont++;
        }
    }

    return $cont;
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function contaAlunos()
{

    $conn = conecta();

    $sql = "SELECT COUNT(DISTINCT(cpf)) as cpfAlunos FROM estudante ";
    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchAll();

    return $result;

}


function cadastrarTrabalhoEstudantes($idTrabalho, $idEstudante)
{
    $conn = conecta();

    try {
        $conn->beginTransaction();

        $sql = "INSERT INTO estudante_trabalho(id_estudante,id_trabalho) VALUES (:id_estudante,:id_trabalho)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id_estudante', $idEstudante, PDO::PARAM_STR);
        $stmt->bindValue(':id_trabalho', $idTrabalho, PDO::PARAM_STR);

        $stmt->execute();

        $conn->commit();
    } catch (PDOException $e) {
        echo $e->getMessage();
        die($e);
        header("Location: ../view/adm/saguaoadm.php?msg=$e");
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function organizaTrabsPorAreaNivel(){

    $conn = conecta();

    $sql = "SELECT id FROM trabalho ";
    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchAll();

    $trabalhosID = [];
    $alunos = [];
        

    foreach ($result as $trabalho) {
        $trabalhosID[] = $trabalho['id'];
    }

    foreach ($trabalhosID as $trabalho) {
        $idEstudantes = [];

        $sql = "SELECT id_estudante FROM estudante_trabalho WHERE id_trabalho = $trabalho";
        $stmt = $conn->prepare($sql);
    
        $stmt->execute();
    
        $result = $stmt->fetchAll();

        foreach($result as $resultinho) {
            $idEstudantes[] = $resultinho['id_estudante'];
        }



        foreach ($idEstudantes as $idEstudante) {

            $sql = "SELECT nome, cpf   FROM estudante WHERE id = $idEstudante";
            $stmt = $conn->prepare($sql);
        
            $stmt->execute();
        
            $infosAlunos[] = $stmt->fetchAll();

            $sql = "SELECT t.id_area_de_conhecimento, t.nivel FROM estudante_trabalho et INNER JOIN trabalho t ON t.id = et.id
            WHERE t.id = et.id_trabalho and et.id_estudante = $idEstudante";
           $stmt = $conn->prepare($sql);
       
           $stmt->execute();
       
           $areaNivel = $stmt->fetchAll();
    
           
    
           foreach($areaNivel as $item){ 
               $nivel = $item['nivel'];
               $area = $item['id_area_de_conhecimento'];
           }
        
            foreach ($infosAlunos as $addTrabalho) {
                $alunos[0] = $addTrabalho[0];
                $alunos[0]['id_trabalho'] = $trabalho;
                $alunos[0]['nivel'] = $nivel;
                $alunos[0]['id_area_de_conhecimento'] = $area;
            }
            foreach($alunos as $aluno){
               $finalInfosEstudantes[] = $aluno; 
           }
        }
        
    }
    return $finalInfosEstudantes;
}
