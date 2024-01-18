<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>

<?php 
 include_once './../../../Controller/avaliadorController.php';
 include_once './../../../Model/Avaliador.php';

// Cria uma variável para armazenar o HTML da tabela
$html = '';

// Cria uma variável para armazenar os trabalhos aprovados
$avaliadores = [];

// Usa a função listarAvaliaodores
$avaliadores = listarAvaliadoresTabela();

if (count($avaliadores) > 0) {
    // Inicia o HTML da tabela com borda
    $html .= "<table  style=\"font-size: 1rem; font-family: 'Roboto Condensed', sans-serif; border: 0.5px solid  #19882c;  \">";
    $html .= "<caption style=\"background-color: #19882c; font-size: 1.5rem; color: white; font-family: 'Roboto Condensed', sans-serif; border-bottom: none; margin-bottom:none;\">AVALIADORES FECINTEC</caption>";
    // Adiciona o cabeçalho da tabela com as colunas desejadas
    $html .= "<tr style=\"background-color: #3F924D; color:white; margin-top: none;\">";
    $html .= "<th style=\"padding:0.5rem; \">ID</th>";
    $html .= "<th  style=\"padding: 0.5rem; \">Nome</th>";
    $html .= "<th  style=\"padding: 0.5rem; \">Email</th>";
    $html .= "<th  style=\"padding: 0.9rem; \">CPF</th>";
    $html .= "</tr>";

    foreach ($avaliadores as $avaliador) {
        // Adiciona uma nova linha na tabela para cada trabalho
        $html .= "<tr style=\"text-align:center;\">";
        // Adiciona as células com os dados do trabalho, usando a função htmlspecialchars para evitar injeção de código
        $html .= "<td style=\"padding: 0.9rem;\">" . htmlspecialchars($avaliador['id']) . "</td>";
        $html .= "<td style=\"padding: 0.9rem; font-size:0.7rem; max-width: 14.8rem;\">" . htmlspecialchars($avaliador['nome']) . "</td>";
        // Usa os atributos area e pesquisa do trabalho para obter os nomes das áreas e das pesquisas
        $html .= "<td style=\"padding: 0.9rem; font-size:0.7rem; width: 5.5rem;\">" . htmlspecialchars($avaliador['email']) . "</td>";
        $html .= "<td style=\"padding: 0.9rem; font-size:0.7rem; max-width: 7.5rem;\">" . htmlspecialchars($avaliador['cpf']) . "</td>";
        // Fecha a linha da tabela
        $html .= "</tr>";
    }
    // Fecha o HTML da tabela
    $html .= "</table>";
} else {
    // Se não há trabalhos aprovados, mostra uma mensagem de aviso
    $html .= "<p>Não há avaliadores.</p>";
}

// Mostra o HTML da tabela na tela
echo $html;
?> 