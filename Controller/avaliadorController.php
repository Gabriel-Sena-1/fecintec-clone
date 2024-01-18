<?php

use LDAP\Result;

require_once(__DIR__ . '/../Util/conectaPDO.php');
require_once(__DIR__ . '/../Model/Avaliador.php');
require_once(__DIR__ . '/trabalhoController.php');
require_once(__DIR__ . '/usuarioController.php');

// Usado no saguaoAdm - botão cadastrar Avaliador
function cadastrarAvaliador($avaliador, $areas, $idUsuario)
{
    $conn = conecta();

    try {

        if (empty($areas) || empty($avaliador)) {
            echo "NÃO!!!!!!!";
            throw new Exception("Area ou Avaliador nulo");
        }

        $conn->beginTransaction();

            $sql = "INSERT INTO avaliador(id, cidade_instituicao, cpf, link_lattes, presenca, orienta, telefone, id_usuario) VALUES (default, :cidadeInstituicao, :cpf, :lattes, default, default, :telefone, :idUsuario)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':cidadeInstituicao', $avaliador->getCidadeInstituicao(), PDO::PARAM_STR);
            $stmt->bindValue(':cpf', $avaliador->getCpf(), PDO::PARAM_STR);
            $stmt->bindValue(':lattes', $avaliador->getLinkLattes(), PDO::PARAM_STR);
            $stmt->bindValue(':telefone', $avaliador->getTelefone(), PDO::PARAM_STR);
            $stmt->bindValue(':idUsuario', $idUsuario);

            $stmt->execute();

            $sqlAvaliadorID = "SELECT id FROM avaliador WHERE cpf = " . $avaliador->getCpf();

            $stmt = $conn->prepare($sqlAvaliadorID);
            $stmt->execute();
            $idAvaliador = $stmt->fetch(PDO::FETCH_ASSOC)['id'];

            foreach ($areas as $area) {
                $sqlInsertArea = "INSERT INTO avaliador_area_de_conhecimento(id, id_area_de_conhecimento, id_avaliador) VALUES (default, :idArea, :idAvaliador)";
                $stmt = $conn->prepare($sqlInsertArea);
                $stmt->bindValue(':idArea', $area, PDO::PARAM_STR);
                $stmt->bindValue(':idAvaliador', $idAvaliador, PDO::PARAM_STR);
                $stmt->execute();
            }

            $dados = $conn->commit();
            if ($dados == true) {
                $msg = "Avaliador cadastrado com sucesso!!!!";
                header("Location: ../view/adm/listarAvaliador.php?msg=" . $msg);
            }
        else{
            $msg = "Usuário não encontrado!";
            header("Location: ../view/adm/cadastrarAvaliador.php?msg=" . $msg);
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        $e = "Não foi possível cadastrar o avaliador!";
        header("Location: ../view/adm/cadastrarAvaliador.php?msg=$e");
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//* Importa a planilha dos trabalhos no BD
// Usado no saguaoAdm - botão importar
function cadastrarAvaliadorPorPlanilha($avaliador, $areas,$idUsuario) //!preciso de ajuda para fazer as alterações aqui
{
    $conn = conecta();

    try {
        if (empty($areas) || empty($avaliador)) {
            echo "NÃO!!!!!!!";
            throw new Exception("Area ou Avaliador nulo");
        }
        $conn->beginTransaction();

        $sql = "INSERT INTO avaliador(cidade_instituicao, cpf, link_lattes, orienta, telefone, id_usuario) VALUES (:cidadeAvaliador, :cpfAvaliador, :lattesAvaliador, :orientaAvaliador, :telefoneAvaliador, :idUsuario)";
        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':cidadeAvaliador', $avaliador->getCidadeInstituicao(), PDO::PARAM_STR);
        $stmt->bindValue(':cpfAvaliador', $avaliador->getCpf(), PDO::PARAM_STR);
        $stmt->bindValue(':lattesAvaliador', $avaliador->getLinkLattes(), PDO::PARAM_STR);
        $stmt->bindValue(':orientaAvaliador', $avaliador->getOrienta(), PDO::PARAM_STR);
        $stmt->bindValue(':telefoneAvaliador', $avaliador->getTelefone(), PDO::PARAM_STR);
        $stmt->bindValue(':idUsuario',$idUsuario, PDO::PARAM_STR);


        $stmt->execute();


        echo $sqlAvaliadorID = "SELECT id FROM avaliador WHERE cpf = '" . $avaliador->getCpf() . "'";


        $stmt = $conn->prepare($sqlAvaliadorID);
        $stmt->execute();
        $idAvaliador = $stmt->fetch(PDO::FETCH_ASSOC)['id'];

        foreach ($areas as $area) {
            $sqlInsertArea = "INSERT INTO avaliador_area_de_conhecimento(id_area_de_conhecimento, id_avaliador) VALUES (:idArea, :idAvaliador)";
            $stmt = $conn->prepare($sqlInsertArea);
            $stmt->bindValue(':idArea', $area, PDO::PARAM_STR);
            $stmt->bindValue(':idAvaliador', $idAvaliador, PDO::PARAM_STR);
            $stmt->execute();
        }

        $dados = $conn->commit();
        if ($dados == true) {
            $msg = "Avaliadores cadastrados com sucesso.";
            header("Location: ../view/adm/listarAvaliador.php?msg=$msg");
        }
    } catch (PDOException $e) {
        $conn->rollBack();
        echo $e->getMessage();
        die($e);
        $e = "Não foi possível cadastrar o avaliador!";
        header("Location: ../view/adm/saguaoAdm.php?msg=$e");
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Usado no processa Avaliador e no processa tabela Avaliador
function buscarEmail()
{
    $conn = conecta();

    try {

        $sqlListar = "SELECT usuario.email FROM usuario
            JOIN avaliador ON usuario.id = avaliador.id_usuario
        ";
        $stmt = $conn->prepare($sqlListar);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        echo "Erro na função buscar email - avaliador controller";
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Usado no processa Avaliador e no processa tabela Avaliador
function buscarCPF()
{
    $conn = conecta();

    try {

        $sqlListar = "SELECT cpf FROM avaliador";
        $stmt = $conn->prepare($sqlListar);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        echo "Erro na função buscarCPF - avaliador controller";
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Usado no processa tabela Avaliador
function avaliadorJaCadastrado($email, $cpf)
{

    $conn = conecta();

    $sql = "SELECT usuario.nome, usuario.email, avaliador.telefone, avaliador.cidade_instituicao, avaliador.link_lattes, avaliador.id_usuario, usuario.senha, avaliador.cpf, avaliador.id FROM avaliador
    JOIN usuario ON avaliador.id_usuario = usuario.id
    WHERE UPPER(usuario.email) = UPPER('".$email."')  AND avaliador.cpf ='".$cpf."'";
    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchAll();
    if (empty($result)) {
        return false;
    }
    return true;
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//* Apresenta os trabalhos do avaliadores 
// Usado 
function listarTrabalhosPorAvaliador($idAvaliador)
{
    $conn = conecta();

    try {

        $sql = "SELECT DISTINCT
                    t.titulo, t.id_orientador, t.id_coorientador, t.nivel, t.id
                FROM 
                    trabalho t, avaliacao av, avaliador a
                WHERE 
                    t.id = av.id_trabalho AND 
                    av.id_avaliador = a.id AND 
                    a.id = " . $idAvaliador;

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $trabalhos = [];

        foreach ($result as $row) {
            $trabalhos[] = $row;
        }

        return $trabalhos;
    } catch (PDOException $e) {
        echo "Erro na função listar trabalho por avaliador - avaliador controller";
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//* Cria tabela que sera apresentada no PDF do avaliador
// Usado no View/pdf/tabelaAvaliador.php
function listarAvaliadoresTabela()
{
    $conn = conecta();

    try {

        $sql = "SELECT a.id, u.nome, u.email, a.telefone, a.cidade_instituicao, a.link_lattes, a.cpf  FROM avaliador a 
        JOIN usuario u ON a.id_usuario = u.id
        ORDER BY a.id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $avaliadores = [];

        foreach ($result as $row) {
            $avaliador = [];

            $avaliador['id'] = $row['id'];
            $avaliador['nome'] = $row['nome'];
            $avaliador['email'] = $row['email'];
            $avaliador['telefone'] = $row['telefone'];
            $avaliador['cidade_instituicao'] = $row['cidade_instituicao'];
            $avaliador['link_lattes'] = $row['link_lattes'];
            $avaliador['cpf'] = $row['cpf'];

            array_push($avaliadores, $avaliador);
        }

        return $avaliadores;
    } catch (PDOException $e) {
        echo "Erro na função listar avaliadores tabela - avaliador controller";
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//* Apresenta lista de avaliadores com botão que apresenta trabalhos e botão que permite editar o avaliador
// Usado no View/adm/saguaoAdm - botao Listar | pagina adm/listarAvaliador.php
function listarAvaliadores()
{
    $conn = conecta();

    try {
        $conn->beginTransaction();

        $sqlListar = "SELECT usuario.nome, usuario.email, avaliador.telefone, avaliador.cidade_instituicao, avaliador.link_lattes, avaliador.id_usuario, usuario.senha, avaliador.cpf, avaliador.id 
        FROM avaliador
        JOIN usuario ON usuario.id = avaliador.id_usuario";
        $stmt = $conn->prepare($sqlListar);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $conn->commit();

        $html = '';

            if ($stmt->rowCount() == 1) {
                $result = $result[0];
    
                $_SESSION['nome'] = $result['nome'];
                $_SESSION['email'] = $result['email'];
                $_SESSION['telefone'] = $result['telefone'];
                $_SESSION['cidade_instituicao'] = $result['cidade_instituicao'];
                $_SESSION['link_lattes'] = $result['link_lattes'];
                $_SESSION['id_usuario'] = $result['id_usuario'];
                $_SESSION['senha'] = $result['senha'];
                $_SESSION['cpf'] = $result['cpf'];
                $_SESSION['id'] = $result['id'];
            }

            foreach ($result as $dados) {
    
                $html .= '<tr><td>' . $dados['id'] . '</td>
                <td style="' . (verificaAvaliacoesPorAvaliador($dados['id']) ? "color: #169c28!important;" : "color: red!important;") . '"> ' . $dados['nome'] . '</td>
                <td><a href="./visualizarTrabalhosAvaliador.php?id=' . $dados['id'] . '"><img src="' . absolutePathImg . '/livrosicon.png' . '" alt="Icone livro" width="25px" style="margin-left: 10px;"></a></td>
                <td class="negrito">
                <a href="./editarAvaliador.php?enviarDados=editar&id=' . $dados['id'] . '"><img src="' . absolutePathImg . "editicon.png" . '" alt="Icone edição" width="25px"></a>
                </td>
                </tr>';
            }
    
            return '
            <div style="display: flex; flex-direction: column; align-items: center; margin-top: 40px;">
    
            <div style="color: white; font-weight: 600; display: flex; flex-direction: column; align-items: center;">
    
            <div style="color: white; font-weight: 600; flex-direction: column; align-items: center;">
    
                                <div style="display: flex; flex-direction: row-reverse; justify-content: space-between;">
                                    <div>
                                        <a href="./saguaoAdm.php" style="align-items: unset; ">
                                            <button type="button" class="button verde" style="margin-bottom: 20px; color: white; font-weight: 400;">
                                                Voltar
                                            </button>
                                        </a>
                                    </div>
    
                                    <div style="width: 80%;">
                                        <input type="text" class="input" id="filtroInput" placeholder="Coloque o que deseja filtrar" onkeypress="filtro(this.value)" onkeyup="filtro(this.value)" style="">
                                    </div>
                                </div>
          
          <div><table class="table is-striped is-hoverable" style="text-align: center; width: 600px;" id="responsivo">
            <thead style="background-color: #82c282">
              <tr>
                <th style="text-align: center;">ID</th>
                <th style="text-align: center;">Nome</th>
                <th style="text-align: center;">Trabalhos</th>
                <th style="text-align: center;">Editar</th>
              </tr>
            </thead>
            <tbody class="cinzaTabela">
              ' . $html . '
              </tbody>
              </table></div></div></div>';
    } catch (PDOException $e) {
        echo "Erro na função listar avaliadores - avaliador controller";
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Usado na função avalaidorMaisTrab e avaliadorMenosTrab - avaliadorController 736
// Usado no Service/processaEditar.php e View/editarAvaliador.php
function buscarAvaliadorPeloId($id)
{
    $conn = conecta();
    try {
        $conn->beginTransaction();

        $sqlBuscarAvaliador = "SELECT usuario.nome, usuario.email, avaliador.telefone, avaliador.cidade_instituicao, avaliador.link_lattes, avaliador.id_usuario, usuario.senha, avaliador.cpf, avaliador.id
        FROM avaliador
        JOIN usuario ON usuario.id = avaliador.id_usuario 
        WHERE avaliador.id = :id";

        $stmt = $conn->prepare($sqlBuscarAvaliador);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = $result[0];

        $conn->commit();

        $avaliador = [];

        $avaliador['id'] = $result['id'];
        $avaliador['senha'] = $result['senha'];
        $avaliador['id_usuario'] = $result['id_usuario'];
        $avaliador['cidade_instituicao'] = $result['cidade_instituicao'];
        $avaliador['cpf'] = $result['cpf'];
        $avaliador['email'] = $result['email'];
        $avaliador['link_lattes'] = $result['link_lattes'];
        $avaliador['nome'] = $result['nome'];
        $avaliador['telefone'] = $result['telefone'];

        return $avaliador;


    } catch (PDOException $e) {
        echo "Erro na função buscar avaliador pelo id - avaliador controller";
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function editarAvaliador($avaliador, $areas)
{
    $conn = conecta();

    try {
        if (empty($areas) || empty($avaliador)) {
            $msg = 'Selecione uma area de conhecimento!';

            header('Location: ./../View/adm/editarAvaliador.php?enviarDados=editar&id=' . $_POST['id'] . '&msg=' . $msg);
            throw new Exception("Area ou Avaliador nulo");
        }
        $conn->beginTransaction();

        // atualiza valores na tabela avaliador
        $sqlUpdateAvaliador = "UPDATE avaliador a
        SET  a.telefone = :telefone, a.cidade_instituicao = :cidade, a.link_lattes = :lattes, a.cpf = :cpf
        WHERE a.id = :id";

        $stmt = $conn->prepare($sqlUpdateAvaliador);
        
        $stmt->bindValue(':telefone', $avaliador['telefone'], PDO::PARAM_STR);
        $stmt->bindValue(':cidade', $avaliador['cidade_instituicao'], PDO::PARAM_STR);
        $stmt->bindValue(':lattes', $avaliador['link_lattes'], PDO::PARAM_STR);
        $stmt->bindValue(':cpf', $avaliador['cpf'], PDO::PARAM_STR);
        $stmt->bindValue(':id', $avaliador['id'], PDO::PARAM_STR);

        $teste1 = $stmt->execute();

        //atualiza valores na tabela usuario
        $sqlUpdateUsuario = "UPDATE usuario u JOIN avaliador ON u.id = avaliador.id_usuario 
        SET u.nome = :nome, u.email = :email,u.senha = :senha
        WHERE avaliador.id = :id";

        $stmt = $conn->prepare($sqlUpdateUsuario);

        $stmt->bindValue(':nome', $avaliador['nome'], PDO::PARAM_STR);
        $stmt->bindValue(':email', $avaliador['email'], PDO::PARAM_STR);
        $stmt->bindValue(':senha', $avaliador['senha'], PDO::PARAM_STR);
        $stmt->bindValue(':id', $avaliador['id'], PDO::PARAM_STR);

        $teste2 = $stmt->execute();

        $sql = "DELETE FROM avaliador_area_de_conhecimento WHERE id_avaliador = :idAvaliador";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':idAvaliador', $avaliador['id'], PDO::PARAM_STR);
        $stmt->execute();

        foreach ($areas as $area) {
            $sqlInsertArea = "INSERT INTO avaliador_area_de_conhecimento(id_area_de_conhecimento, id_avaliador) VALUES (:idArea, :idAvaliador)";
            $stmt = $conn->prepare($sqlInsertArea);
            $stmt->bindValue(':idArea', $area, PDO::PARAM_STR);
            $stmt->bindValue(':idAvaliador', $avaliador['id'], PDO::PARAM_STR);
            $stmt->execute();
        }

        $dados = $conn->commit();
        if ($dados == true) {
            $msg = "Avaliador cadastrado com sucesso!!!!";
            header("Location: ../view/adm/listarAvaliador.php?msg=" . $msg);
        }
    } catch (PDOException $e) {
        echo "Erro na função editar avaliador - avaliador controller";
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//* Cria a lista de avaliadores para ser usada na pagina de alterar avaliador que permite vincular ou não ao trabalho
// usada na pagina de alterar avaliador
function vincularAvaliador($id, $idTipo)
{
    $conn = conecta();

    $listaOrientadores = array();

    try {
        // Executa uma consulta para buscar todos os avaliadores ordenados por ID
        $sqlListar = "SELECT usuario.nome, usuario.email, avaliador.telefone, avaliador.cidade_instituicao, avaliador.link_lattes, avaliador.id_usuario, usuario.senha, avaliador.cpf, avaliador.id 
        FROM avaliador
        JOIN usuario ON usuario.id = avaliador.id_usuario ORDER BY avaliador.id";
        $stmt = $conn->prepare($sqlListar);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Inicializa uma string vazia para armazenar o HTML da tabela de avaliadores
        $html = '';

        // Se houver apenas um avaliador encontrado, armazena suas informações na sessão
        if ($stmt->rowCount() == 1) {
            $result = $result[0];
            $_SESSION['nome'] = $result['nome'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['telefone'] = $result['telefone'];
            $_SESSION['cidade_instituicao'] = $result['cidade_instituicao'];
            $_SESSION['link_lattes'] = $result['link_lattes'];
            $_SESSION['senha'] = $result['senha'];
            $_SESSION['cpf'] = $result['cpf'];
            $_SESSION['id'] = $result['id'];
        }


        // Verifica o nivel do trabalho
        $sqlTrabalhoNivel = "SELECT trabalho.nivel FROM trabalho WHERE id = $id";
        $trabalhoNivel = $conn->prepare($sqlTrabalhoNivel);
        $trabalhoNivel->execute();
        $resultNivel = $trabalhoNivel->fetchAll();

        //* Verifica se o arquivo infoDistribuicao.json existe
        if (file_exists("../../infoDistribuicao.json")) {
            //* Se existe ele pega o conteúdo que está no arquivo e guarda na $arraySerializada
            $arraySerializada = file_get_contents("../../infoDistribuicao.json");

            //* Meio que "desformata" para array
            $arrayInfo = json_decode($arraySerializada, true);

            //* Separa os arrays
            $listaOrientadores = $arrayInfo["listaOrientadores"];

            
             // Loop através dos resultados da consulta para construir as linhas da tabela HTML
            foreach ($result as $dados) { 
                $contador = 0;

                foreach ($listaOrientadores as $orientadores) { 
                    // Verifica se o nivel do avaliador é o mesmo do trabalho
                    if ($orientadores['id'] == $dados['id'] && $orientadores['orienta'] == $resultNivel[0]['nivel']) {
                            $contador = 1; 
                            $html .= '<tr >
                                <td>' . $dados['id'] . '</td>
                                <td>' . $dados['nome'] . '</td>
                                <td>
                                    <button class="button is-warning" style="display: none;">
                                        <a  href="./../../Service/processaAvaliador.php?action=vincular&id=' . $dados['id'] . '&idt=' . $id . '&idp=' . $idTipo . '">
                                            Vincular
                                        </a>
                                    </button>
                                </td>
                                <td>
                                    <button class="button is-success" onclick="popUpInfos(' . $dados['id'] . ')">
                                        <a style="color: white!important;">
                                            Mais +
                                        </a>
                                    </button>
                                </td>
                            </tr>';
                        } else{
                        } 
                    }
                    if($contador == 0){ // Se não é do mesmo nivel o botão vincular aparece normalmente
                            $html .= '<tr>
    
                            <td>' . $dados['id'] . '</td>
                            <td>' . $dados['nome'] . '</td>
                            <td>
                                <button class="button is-warning">
                                    <a style="color: white!important;" href="./../../Service/processaAvaliador.php?action=vincular&id=' . $dados['id'] . '&idt=' . $id . '&idp=' . $idTipo . '">
                                        Vincular
                                    </a>
                                </button>
                            </td>
                            <td>
                                <button class="button is-success" onclick="popUpInfos(' . $dados['id'] . ')">
                                    <a style="color: white!important;">
                                        Mais +
                                    </a>
                                </button>
                            </td>
                        </tr>';
                }
            }      
        } else{
            echo "Arquivo json não encontrado ou não existe!";
        }
        // Condição para gerar o botão de "Desclassificar" ou uma mensagem indicando que o trabalho foi desclassificado

        $html .= '<tr ><td>' . $dados['id'] . '</td>
            <td> ' . $dados['nome'] . '</td>
            <td>
            <button class="button is-warning" style=""><a style="color: white!important;" href="./../../Service/processaAvaliador.php?action=vincular&id=' . $dados['id'] . '&idt=' . $id . '&idp=' . $idTipo . '">
            Vincular</a></button>
            </td>
            </tr>';


        if (buscarAtivo(base64_decode($_GET['id']))) {
            $resultado = "<a href=\"./../../Service/processaTrabalho.php?act=desclassifica&id=" . $_GET['id'] . "\" style=\"align-items: unset;\">
                            <button type=\"button\" class=\"button is-medium\" style=\"margin-bottom: 20px; color: white; background-color: #e00007; float: right;\">
                                Desclassificar
                            </button>
                        </a>";
        } else {
            $resultado = "<div style=\"color: red; float: right; margin-top: 16px;\">Trabalho desclassificado.</div>";
        }

        // Retorna o HTML da tabela de avaliadores com os botões e informações correspondentes
        return '<!--Tabela esta em avaliadorController - funcao vincular avaliador -->
        <div style="display: flex; flex-direction: column; align-items: center;">
                    <div style="color: white; font-weight: 600; padding: 3vh; flex-direction: column; width: 800px; align-items: center;" id="divResponsiva">
                        <a href="#" onclick="voltar()" style="align-items: unset;">
                            <button type="button" class="button verde is-medium" style="margin-bottom: 20px; color: white;">
                                Voltar
                            </button>
                        </a> 
                        ' . $resultado . '
                        <input type="text" class="input" id="filtroInput" placeholder="Coloque o que deseja filtrar" onkeypress="filtro(this.value)" onkeyup="filtro(this.value)" style="">
                    </div>
                    <div class="table-container">
                        <table class="table is-striped is-hoverable" style="text-align: center; width: 750px;" id="tabelaAlterarAvaliador">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">ID</th>
                                    <th style="text-align: center;">Nome</th>
                                    <th style="text-align: center;">Vincular</th>
                                </tr>
                            </thead>
                            <tbody class="cinzaTabela">
                                ' . $html . '
                            </tbody>
                        </table>
                    </div>
                </div>';
    } catch (PDOException $e) {
        echo "Erro na função vincular avaliador - avaliador controller";
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//* Apresenta os avaliadores responsavei por um trabalho em um pop up
// Usado no View/adm/resumoTrabalhos
function statusDados($id_trabalho){

    $conn = conecta();

    try {
            // Busca todos os avaliadores e suas notas ao trabalho
            $sqlBuscarAvaliadores = "SELECT avaliacao.id_avaliador, usuario.nome, usuario.email, COUNT(avaliacao.nota) AS qtd_notas 
            FROM avaliacao 
            JOIN avaliador ON avaliador.id = avaliacao.id_avaliador 
            JOIN usuario ON usuario.id = avaliador.id_usuario 
            WHERE avaliacao.id_trabalho = :id_trabalho 
            GROUP BY usuario.nome ";
    
            $stmt = $conn->prepare($sqlBuscarAvaliadores);
            $stmt->bindValue(':id_trabalho', $id_trabalho);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $avaliador = $result;

        // Cria pop up com os avaliadores e suas notas
        echo "
            <div onclick=\"fechaPop();\" class=\"notification bloco\" style=\"margin: auto; margin-top: 20px;display:block; width: 45%; 
            position: fixed; height: 25%; z-index: 2; left: 25%; top: 30%; padding: 3%;\" id=\"popUp\">";
                
            //Enquanto existirem avaliadores do trabalho, sera gerada linhas
            foreach ($avaliador as $ava) {
                $nome = $ava['nome']; 
                $classe = $ava['qtd_notas'] != 0 ? 'verdeStatus' : 'vermelhoStatus';  
                $email = $ava['email'];
                
                echo"
                <div style=\" display:flex; flex-direction: row; justify-content:space-between; margin-bottom: 5%; margin-left: 0;\">
                    <p>$nome | $email</p><div class=\" bolinhaStatus $classe\"></div>
                </div>";
            } 

            echo "</div>"; 
             
 

    } catch (PDOException $e) {
        echo "Erro na função statusDados - avaliador controller";
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//* Apresenta nome de avalidores e area de conhecimento de um trabalho 
// Usado no View/adm/alterarAvaliador.php 
function exibirDados($id)
{
    $conn = conecta();


    try { {
            $conn->beginTransaction();

            $sqlBuscarAvaliador = "SELECT ac.descricao, u.nome
            FROM area_de_conhecimento ac
            JOIN avaliador_area_de_conhecimento avac ON ac.id = avac.id_area_de_conhecimento
            JOIN usuario u ON u.id = avac.id_avaliador
            JOIN avaliador av ON avac.id_avaliador = av.id
            JOIN avaliacao ava ON ava.id_avaliador = av.id
            WHERE av.id = " . $id;

            $stmt = $conn->prepare($sqlBuscarAvaliador);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $result[0];


            $areaConhecimentoAvaliador = $result['descricao'];
            $nomeAvaliador = $result['nome'];
        } {

            $sqlTrabalhosVinculados = "SELECT COUNT(DISTINCT id_trabalho) AS totalTrabalhos FROM `avaliacao` WHERE id_avaliador =" .  $id;

            $stmt2 = $conn->prepare($sqlTrabalhosVinculados);
            $stmt2->execute();

            $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            $result2 = $result2[0];


            $trabalhosVinculados = $result2['totalTrabalhos'];
        } {

            $sqlTrabalhosNaoAvaliados = "SELECT COUNT(DISTINCT id_trabalho) totalTrabalhosNaoAvaliados FROM `avaliacao` WHERE nota IS NULL AND id_avaliador = " . $id;

            $stmt3 = $conn->prepare($sqlTrabalhosNaoAvaliados);
            $stmt3->execute();

            $result3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
            $result3 = $result3[0];

            $conn->commit();

            $trabalhosNaoAvaliados = $result3['totalTrabalhosNaoAvaliados'];
        }



        echo "
        <div onmouseleave=\"fechaPop()\" class=\"notification bloco\" style=\"margin: auto; margin-top: 20px; display: block; width: 500px; 
        position: fixed; height: 150px; z-index: 2; left: 33%; top: 30%;\" id=\"popUp\">
            <ul align=\"middle\">
                <li class=\"info-av\" style=\"font-weight: 600;\">Nome do Avaliador: $nomeAvaliador</li>
                <li class=\"info-av\">Área de conhecimento: $areaConhecimentoAvaliador</li>
                <li class=\"info-av\">Trabalhos vinculados: $trabalhosVinculados</li>
                <li class=\"info-av\">Trabalhos não avaliados: $trabalhosNaoAvaliados</li>
            </ul>
        </div>
        ";
        // return $avaliador;
    } catch (PDOException $e) {
        echo "Erro na função exibir dados - avaliador controller";
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (!empty($_GET['act']) && $_GET['act'] == 'exibe') {
    exibirDados($_GET['id']);
} else if(!empty($_GET['act']) && $_GET['act'] == 'status'){
    statusDados($_GET['id']);
} 


//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//* Função que retorna o avaliador com mais trabalhos
// Usado no logDistribuição
function avaliadorMaisTrab($listaAvaliadores)
{

    $conn = conecta();
    $qtdeMaior = 0;
    $qtdeMaior2 = 0;
    $idAvaliador = 0;
    $idAvaliador2 = 0;

    //* Foreach que roda a lista de avaliadores passado por parametro, pegando os IDs dos avaliadores e fazendo uma busca no banco de dados
    foreach ($listaAvaliadores as $avaliador) {
        $sql = "SELECT COUNT(DISTINCT id_trabalho) FROM avaliacao WHERE id_avaliador = :idAvaliador ";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':idAvaliador', $avaliador['id'], PDO::PARAM_INT);

        $stmt->execute();

        $result = $stmt->fetch();
       
        //* Compara a quantidade salva na variável qtdeMaior/qtdeMaior2 com o resultado da busca no banco (que é quantidade de trabalhos atribuídos ao avaliador) e se for maior salva o ID desse avaliador e sobreescreve a quantidade na variável qtdeMaior/qtdeMaior2 para continuar a comparação
        if ($result[0] > $qtdeMaior) {
            $qtdeMaior = $result[0];
            $idAvaliador = $avaliador['id'];
        } else if ($result[0] > $qtdeMaior2) {
            $qtdeMaior2 = $result[0];
            $idAvaliador2 = $avaliador['id'];
        }
    }

    //* Salva todas as informações (avaliador, quantidade de trabalhos atribuídos e id dos trabalhos) em uma única array para retornar
    $result = array(
        "qtde" => $qtdeMaior,
        "avaliador" => buscarAvaliadorPeloId($idAvaliador),
        "qtde2" => $qtdeMaior2,
        "avaliador2" => buscarAvaliadorPeloId($idAvaliador2)
    );

    return $result;
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//* Função que retorna o avaliador com menos trabalhos
// Usado no View/adm/logDistribuição
function avaliadorMenosTrab($listaAvaliadores)
{

    $conn = conecta();
    $qtdeMenor = 100;
    $qtdeMenor2 = 100;

    //* Foreach que roda a lista de avaliadores passado por parametro, pegando os IDs dos avaliadores e fazendo uma busca no banco de dados
    foreach ($listaAvaliadores as $avaliador) {
        $sql = "SELECT COUNT(DISTINCT id_trabalho) FROM avaliacao WHERE id_avaliador = :idAvaliador";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':idAvaliador', $avaliador['id'], PDO::PARAM_STR);

        $stmt->execute();
        
        $result = $stmt->fetch();


        //* Compara a quantidade salva na variável qtdeMenor/qtdeMenor2 com o resultado da busca no banco (que é quantidade de trabalhos atribuídos ao avaliador) e se for menor salva o ID desse avaliador e sobreescreve a quantidade na variável qtdeMenor/qtdeMenor2 para continuar a comparação
        if ($result[0] < $qtdeMenor) {
            $qtdeMenor = $result[0];
            $idAvaliador = $avaliador['id'];
        } else if ($result[0] < $qtdeMenor2) {
            $qtdeMenor2 = $result[0];
            $idAvaliador2 = $avaliador['id'];
        }
    }

    $result = array(
        "qtde" => $qtdeMenor,
        "avaliador" => buscarAvaliadorPeloId($idAvaliador),
        "qtde2" => $qtdeMenor2,
        "avaliador2" => buscarAvaliadorPeloId($idAvaliador2)
    );

    return $result;
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//* Função que retorna a qtde de avaliadores que possuem a mesma quantidade de trabalhos
// Usado no View/adm/logDistribuição
function qtdeAvaliadoresMesmaQtde($listaAvaliadores, $qtde)
{

    $conn = conecta();
    $msmQtde = 0;

    foreach ($listaAvaliadores as $avaliador) {
        $sql = "SELECT COUNT(DISTINCT id_trabalho) FROM avaliacao WHERE id_avaliador = :idAvaliador";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':idAvaliador', $avaliador['id'], PDO::PARAM_STR);

        $stmt->execute();

        $result = $stmt->fetch();

        if ($result[0] === $qtde) {
            $msmQtde++;
        }
    }

    return $msmQtde;
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//* Função que retorna a qtde total de avaliadores
// Usado no View/adm/logDistribuição
function contaTodosAvaliadores()
{
    $conn = conecta();

    $sql = "SELECT COUNT(*) FROM avaliador";
    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchAll();

    return $result;
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//* Função cadastra a avalaiação de um avaliador
// Usado no View/avaliador/telaTrabalho
function cadastrarAvaliacao($nota, $idAvaliador, $id, $idTrabalho)
{
    $conn = conecta();
    try {
        $conn->beginTransaction();

        $sql = "UPDATE avaliacao SET nota = :nota
        WHERE id_avaliador = :idAvaliador AND id_questao = :id AND id_trabalho = :id_trabalho";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':nota', $nota, PDO::PARAM_STR);
        $stmt->bindValue(':idAvaliador', $idAvaliador, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);
        $stmt->bindValue(':id_trabalho', $idTrabalho, PDO::PARAM_STR);

        $stmt->execute();
        if ($conn->commit()) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//* Retorna qtd de desclassificado
// Usado no View/adm/logDistribuição
function mostrarDesclassificados()
{
    $conn = conecta();
    try {
        $sqlDesclassificados = "SELECT res.nome, COUNT(res.nome) AS qtdeNiveis FROM 
        (
            SELECT DISTINCT avaliador.nome, trabalho.nivel
            FROM avaliador
            JOIN trabalho 
            ON (avaliador.cpf = trabalho.cpf_orientador OR avaliador.cpf = trabalho.cpf_coorientador) 
        ) AS res 
           
        GROUP BY res.nome HAVING qtdeNiveis = 2";
        $stmt = $conn->prepare($sqlDesclassificados);
        $stmt->execute();
        $desclassificados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($desclassificados)) {
            return "Não há avaliadores desclassificados, que avaliam em 2 niveis *EM ou EF*";
        } else {
            /* foreach($desclassificados as $avaliadoresDesclassificado){
                    echo $avaliadoresDesclassificado['nome'] . "<br>";
                } */

            return $desclassificados;
        }
    } catch (PDOException $e) {
        echo "Erro ao executar a consulta: " . $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//* Verifica se um avaliador é orientador/coorientador
// Usado no ...
function verificarOrientador($idAvaliador){
    $conn = conecta();

    try {
        $sql = "SELECT cpf FROM avaliador WHERE id = :idAvaliador";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':idAvaliador', $idAvaliador, PDO::PARAM_STR);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $cpfAvaliador = $result;

        $sql = "SELECT DISTINCT avaliador.id id_avaliador, avaliador.cpf, trabalho.nivel nivel FROM avaliador JOIN trabalho ON avaliador.cpf = trabalho.cpf_orientador OR avaliador.cpf = trabalho.cpf_coorientador WHERE avaliador.cpf = :cpf AND (trabalho.cpf_orientador = :cpf OR trabalho.cpf_coorientador = :cpf)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':cpf', $cpfAvaliador['cpf'], PDO::PARAM_STR);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($result)) {
            return null;
        } else {
            return $result;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function encontrarTrabalhoVinculado($idAvaliador)
{

    $areas = buscarAreas();

    //* Verifica se o arquivo infoDistribuicao.json existe
    if (file_exists("../infoDistribuicao.json")) {
        //* Se existe ele pega o conteúdo que está no arquivo e guarda na $arraySerializada
        $arraySerializada = file_get_contents("../infoDistribuicao.json");

        //* Meio que "desformata" para array
        $arrayInfo = json_decode($arraySerializada, true);

        //* Separa os arrays
        $arrayAvaliadores = $arrayInfo["avaliadoresPorArea"];
    }

    $infosAvaliador = array();

    $trabalhosVinculados = array();

    //* Foreach de áreas necessário por causa que o array de Avaliadores está organizado por área
    foreach ($areas as $area) {

        //* For que roda os avaliadores de determinada área, identificando os avaliadores por $i, lembrando também que os avaliadores também são formados por array
        for ($i = 0; $i < count($arrayAvaliadores[$area['id']]); $i++) {

            //* Verifica avaliador por avaliador (pelo id dele) até encontrar na lista de avaliadores o avaliador no qual se foi pedido as informações ( que é o avaliador com o id que veio por parâmetro )
            if ($idAvaliador == $arrayAvaliadores[$area['id']][$i]['id']) {

                //* Se entrar no if, significa que encontrou o avaliador no meio da lista de avaliadores dessa área e então salvará em outras variáveis as informações pedidas, que no caso é os trabalhos com o qual está vinculado e suas áreas
                $trabalhosVinculados = $arrayAvaliadores[$area['id']][$i]['trabalhos'];
                $areas = $arrayAvaliadores[$area['id']][$i]['areas'];
                break;
            }
        }
    }

    $trabalhosInfos = array();

    //* Foreach que roda os trabalhos vinculados que até então só tem os id dos trabalhos, para pegar as informações desses trabalhos
    foreach ($trabalhosVinculados as $trabalho) {
        $trabalhosInfos[$trabalho] = buscarTrabalho($trabalho)[0];
    }

    //* Salva as informações em uma única array para retornar ela
    $infosAvaliador = array(
        'trabalhos' => $trabalhosInfos,
        'areas' => $areas
    );

    return $infosAvaliador;
}


?>

<script>
    //* A variável idSalvo serve para salvar o id do último trabalho que foi marcado para mostrar informações, assim que na próxima vez que um trabalho for marcado e este for diferente do anterior, as informações do anterior desaparecerão com o display none e as informações do atual trabalho requerido serão mostradas no lugar com o display unset
    idSalvo = null;

    function infoTrab(idTrabalho) {

        //* Condição para que as informações do antigo trabalho desapareçam
        //* Se idSalvo for diferente de null significa que já foi mostrado as informações de um trabalho anteriormente, caso contrário significa que esse foi o primeiro trabalho a ser pedido as informações dele
        //* E document.getElementById(idSalvo) TEM que ser diferente de null por causa que essa é a validação para saber se o id que está salvo pertence ao mesmo avaliador, porque as informações dos trabalhos já existem, elas somente estão "invisiveis", o que significa que se esse valor for nulo, o trabalho que está sendo pedido para as informações desaparecerem pertence a outro avaliador e portanto não tem como fazer desaparer algo que não existe para ele ( tudo isso em caso de que o admin clique para mostrar as informações dos trabalhos de mais de um avaliador, se quiser testar só retirar essa condição pra ver os warnings )

        if (idSalvo != null && document.getElementById(idSalvo) != null) {
            divDadosAntigos = document.getElementById(idSalvo);
            divDadosAntigos.style.display = 'none';

            //TODO: Isso que está comentado foi uma tentativa de fazer algo bunitin em relação ao front-end, para tipo, quando clicar para mostrar as informações de um determinado trabalho, esse trabalho ficará marcado em verde para saber a qual trabalho as informações mostradas pertence, só que tem um leve problema, tipo, isso ta funcionando, o problema é que toda vez que tira o mouse, a coloração volta ao normal por causa do onmouseout ( eu ACHO que o problema é esse )
            //* Esse id com título é para identificar o título de trabalho da lista que está disponível para clicar e mostrar as informações a fim de mudar a cor do background como se tivesse selecionado, mas tem o problema que está descrito em cima ;u;

            /* idTituloAntigo = idSalvo+'Titulo';
            document.getElementById(idTituloAntigo).style.backgroundColor = 'unset'; */
        }

        /* idTitulo = idTrabalho+'Titulo';
        console.log(idTitulo);
        document.getElementById(idTitulo).style.backgroundColor = '#169c28'; */

        divDados = document.getElementById(idTrabalho);
        divDados.style.display = 'unset';

        idSalvo = idTrabalho;
        console.log(idSalvo);
    }
</script>

<?php

//* Função que a partir do id do avaliador encontra os trabalhos com os quais ele está vinculado (possibilitando a visualização das informações de cada trabalho) e também verifica se ele orienta
//* Quando a função é chamada ela imprimirá as informações que está em html por causa do echo
function mostrarDados($idAvaliador)
{
    $trabalhosOrientados = verificarOrientador($idAvaliador);
    //print_r($trabalhosOrientados);

    //* Sequência de ifs apenas para identificar e definir o conteúdo
    //* Caso a função verificarOrientador retorne null, significa que a busca no banco de dados não retornou nada, ou seja, null
    if ($trabalhosOrientados == null) {
        $orientador = 'Não orienta trabalhos';
    }
    //* Se retornar algum valor (sendo apenas um único valor) ele pega o retorno da função que será um array ( que tem identificar por 0 nesse caso, sendo o equivalente a linha 0 no banco de dados, e por retornar uma única linha não é necessário dinamizar ) de array ( depois de acessar o array 0, será necessário informar o nome do dado que desejamos pegar, que no banco de dados é o equivalente a coluna, e como apenas retornamos um único dado, deverá apenas identificá-lo, nesse caso, nivel )
    else if (count($trabalhosOrientados) == 1) {
        $orientador = $trabalhosOrientados[0]['nivel'];
    }
    //* Se retornar mais de uma linha, valor, significa que ele orienta nos dois níveis
    else if (count($trabalhosOrientados) == 2) {
        $orientador = 'Orienta os dois níveis (EF e EM)';
    }

    //* Pega os trabalhos (já com as informações dos mesmos) e as áreas desse avaliador
    $trabalhos = encontrarTrabalhoVinculado($idAvaliador)['trabalhos'];
    $areasAvaliador = encontrarTrabalhoVinculado($idAvaliador)['areas'];

    $areas = buscarAreas();
    $htmlAreas = null;

    //* A explicação disso ta embaixo
    $contador = 0;

    //* Roda a array de áreas (que tem 5 arrays, cada array possui duas informações, os id da área e sua descricao, que é o nome)
    foreach ($areas as $area) {

        //* Verifica se as áreas com o qual o avalidor se inscreveu está na formatação de uma array, porque se estiver tem que rodar um foreach e caso não esteje, não pode odar um foreach
        // Na teoria, nunca se entrará no else, pois as áreas estão organizadas como uma array mesmo que seja apenas uma área, só que isso foi feito por garantia, mas tipo, serve de nada :)

        if (is_array($areasAvaliador)) {

            //* Por se tratar de uma array é necessário rodar um foreach, principalmente no caso em que o avaliador seja híbrido
            foreach ($areasAvaliador as $areaAvaliador) {

                //* Verifica área por área até encontar uma das áreas do avaliador apenas para pegar o nome ( descricao ) da área e adicionar uma variável que armazena os nomes das áreas, para imprimir depois no lugar adequado com as informações organizadas e completas
                if ($area['id'] == $areaAvaliador) {
                    $htmlAreas .= ' ' . $area['descricao'];
                    $contador++;

                    //* If que serve apenas como uma maneira de organizar e deixar bunitin o html das áreas, no caso de exitir mais de uma área (avaliador híbrido)
                    //* Resumidamente, o contador inicia no 0 e incrementa em 1 toda vez que for adicionado uma área no html, para que quando chegar na última área a ser adicionado, ele não adicionar essa "/" no final, porque ela está sendo usada para separar as áreas e não é necessário ter uma "/" no final se não tiver uma continuação (próxima área)
                    if ($contador != count($areasAvaliador)) {
                        $htmlAreas .= ' /';
                    }
                }
            }
        } else {
            $htmlAreas = ' ' . $area['descricao'];
        }
    }

    //print_r($trabalhos);

    //* Seguinte, tudo isso é o pop up, quando chama essa função por meio do ajax, ele salva na variável imprime pra ficar brincando de aparece e desaparece com a estilização do display
    //* Adicionalmente, não pergunte ou peça uma explicação de como está funcionando a estilização, ela só funciona

    echo "
    <div style=\"display: flex; flex-direction: column; align-items: center;\">
        <div class=\"notification bloco\" style=\"margin: auto; margin-top: 20px; display: block; width: 800px; 
        position: fixed; z-index: 2; top: 16%; height: 500px; overflow-y: scroll;\" id=\"popUp\">
            <a class=\"delete\" onclick=\"fechaPop()\"></a>
            <div>
                <p align=\"middle\" class=\"info-av upperFont negrito\">Clique para mostrar informações do trabalho</p>
                <hr class=\"verde\" style=\"margin: 10px!important;\">
                <div style=\"display: flex; flex-direction: row;\">
                <div style=\"display: flex; flex-direction: column; width: 380px;\">";

    //* Foreach que roda os trabalhos desse avaliador, identificando a chave/index como $chave, que será necessário por que os trabalhos anteriormente foram identificados pelos seus ids na array, e o $trabalho é o conteúdo da array que está sendo identificado pela $chave
    //* Os ids são necessários por causa que todas as funções trabalham por meio do id, se não tiver o id, as funções vão com Deus ;w;
    //* A explicação do por que existe um id (do html) que não está sendo usado para nada está explicado na função js "infoTrab"

    foreach ($trabalhos as $chave => $trabalho) {
        echo "<p id=\"" . $chave . "Titulo\" class=\"info-av\" onclick=\"infoTrab(" . $chave . ")\" style=\"padding: 5px; padding-right: 10px; padding-left: 10px; border-radius: 2px; text-align: justify;\" onmouseover=\"this.style.backgroundColor='#169c28'; this.style.color='white';\" onmouseout=\"this.style.backgroundColor='unset'; this.style.color='unset';\">" . $trabalho['titulo'] . "</p>";
    }

    echo "</div>";

    //* Foreach para imprimir as informações de todos os trabalhos desse avaliador, mas que estarão invisíveis com o display none e somente aparecerão com a função js "infoTrab", identificando esses blocos de informação com o id do html que será o id do trabalho

    foreach ($trabalhos as $chave => $trabalho) {
        echo "<div id=\"" . $chave . "\" style=\"display: none; width: 360px; margin-left: 10px; border-width: 1px; border-style: solid;  border-color: black; border-radius: 10px; padding: 10px;\">
                        <p class=\"negrito\">Título: " . $trabalho['titulo'] . "</p>
                        <p style=\"margin-top: 8px;\">Aluno(s): " . $trabalho['estudantes'] . "</p>
                        <p>Orientador: " . $trabalho['nome_orientador'] . "</p>";

        //* Só imprime o coorientador se existir
        if (!empty($trabalho['nome_coorientador'])) {
            echo "<p>Coorientador: " . $trabalho['nome_coorientador'] . "</p>";
        }
        echo "
                        <p>Nível: " . $trabalho['nivel'] . "</p>
                        <p>Tipo de Pesquisa: " . $trabalho['tipo'] . "</p>
                        <p>Área de Conhecimento: " . $trabalho['descricao'] . "</p>
                        </div>";
    }

    echo "
                </div>
                <hr class=\"verde\" style=\"margin: 10px!important;\">
                <p class=\"info-av\" style=\"margin: 10px!important; margin-bottom: 0px!important\">Área(s) inscrita(s): " . $htmlAreas . "</p>
                <p class=\"info-av\" style=\"margin-left: 10px!important; margin-rigth: 10px!important;\">Níveis em que orienta: " . $orientador . "</p>
            </div>
        </div>
    </div>
    ";
}

//* Coisa do ajax
if (!empty($_GET['act']) && $_GET['act'] == 'trabVinculados') {
    mostrarDados($_GET['id']);
}

function verificaAvaliacaoDoAvaliador($idAvaliador, $idTrabalho){
    $conn = conecta();

    $sql = "SELECT count(nota) FROM avaliacao WHERE id_avaliador = $idAvaliador && id_trabalho = $idTrabalho and nota is not null";
    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchColumn();

    if($result != 9){
        return false;
    }
    return true;
}


function verificaOrientacao($cpf)
{
    $conn = conecta();

    try {
        $sql = "SELECT * FROM avaliador WHERE cpf = $cpf";
        $stmt = $conn->prepare($sql);

        return $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
        die($e);
    }
}

function updateOrientacao($cpf)
{
    $conn = conecta();

    try {
        $sql ="UPDATE avaliador SET orienta = 1 WHERE cpf = $cpf";
        $stmt = $conn->prepare($sql);
       
        return $stmt->execute();
    } catch (PDOException $e) {
        $conn->rollBack();
        echo $e->getMessage();
        die($e);
    }
}

function statusOrientacao($cpf)
{
    $conn = conecta();

    try {
        $sql = "SELECT orienta FROM avaliador WHERE cpf = $cpf";
        $stmt = $conn->prepare($sql);
        
        return $stmt->execute();
    } catch (PDOException $e) {
        $conn->rollBack();
        echo $e->getMessage();
        die($e);
    }
}

function verificaAvaliacoesPorAvaliador($idAvaliador){
    $conn = conecta();

    $sql = "SELECT count(nota) FROM avaliacao WHERE id_avaliador = $idAvaliador and nota is not null";
    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchColumn();

    if($result != 36){
        return false;
    }
    return true;
}













function listarAvaliadoresCredenciamento(){
    
    $conn = conecta();

    try {
        $conn->beginTransaction();

        $sqlListar = "SELECT avaliador.id, usuario.nome, avaliador.presenca
        FROM avaliador
        JOIN usuario 
        ON usuario.id = avaliador.id_usuario";
        $stmt = $conn->prepare($sqlListar);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $avaliadores = [];

        foreach ($result as $avaliador) {
            $avaliador['id'];
            $avaliador['nome'];
            $avaliador['presenca'];
            

            $avaliadores[] = $avaliador;
        }
        return $avaliadores;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


function updateLogPresencaAvaliador($nome){
    $conn = conecta();

    try {
        $conn->beginTransaction();

        $sql = "INSERT INTO `log` (comentario) VALUES ('Presença atribuida ao avaliador $nome.') ";
        $stmt = $conn->prepare($sql);

        
        $stmt->execute();
        return $conn->commit();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function presencaAvaliador($idAvaliador, $nome)
{
    if(verificaPresencaAvaliador($idAvaliador)){
        return;
    }else
    
    try {
        $conn = conecta();
        
        $conn->beginTransaction();

        $sql = "UPDATE avaliador SET presenca = :presenca WHERE id = :idAvaliador";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':presenca', 1, PDO::PARAM_INT); // Use 1 em vez de "1" para presenca
        $stmt->bindValue(':idAvaliador', $idAvaliador, PDO::PARAM_INT); // Associe o ID do estudante


        $result = $stmt->execute();

        if ($result) {
            updateLogPresencaAvaliador($nome);
            return $conn->commit();
        } else {
            echo "Erro ao atribuir presença para o avaliador.";
        }
    } catch (PDOException $e) {
        throw new Exception("Erro na consulta SQL: " . $e->getMessage());
    }
}




function verificaPresencaAvaliador($idAvaliador)
{
    $conn = conecta();

    try {
        $sql = "SELECT a.presenca
        FROM avaliador a
        WHERE a.id = $idAvaliador
                ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($result['presenca'] == 1) {
            return true;
        }
        return false;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function contaAdm()
{
    $conn = conecta();

    try {
        $sql = "SELECT COUNT(id_tipo) FROM usuario WHERE id_tipo = 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['COUNT(id_tipo)'];
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
