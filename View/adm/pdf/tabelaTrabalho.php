<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <style>
        
        th{
            padding: 0.5rem;
            font-size: 0.9rem;
            text-align: center;
        }
        td{
            text-align:center;
            font-size: 0.7rem;
            padding: 0.7rem;
        }

        .pagebreak { page-break-before: always; }
    </style>
</head>
 
 <?php 
 include_once './../../../Controller/trabalhoController.php';
include_once './../../../Model/Trabalho.php';

// Cria uma variável para armazenar o HTML da tabela
$html = '';

// Cria uma variável para armazenar os trabalhos aprovados
$trabalhosAprovados = [];

// Usa a função listarTrabalhosAprovados da classe trabalhoController para obter os trabalhos aprovados do banco de dados
$trabalhosAprovados = listarTrabalhosAprovadosPorArea('EF');

// Criando array de area de conhecimento
$areas = array(1 => "Ciências Agrárias e Engenharia", 2 => "Ciências Biológicas e da Saúde", 3 => "Ciências Exatas e da Terra", 4 => "Ciências Humanas, Sociais Aplicadas e Linguistica",  5 => "Multidisciplinar");

// Criando array de tipo de pesquisa
$pesquisas = array(1=> "Cientifica", 2=>"Tecnológica");

// Verifica se há trabalhos aprovados
foreach ($trabalhosAprovados as $areaID => $trabalhos) {
    // Obtém o nome da área de conhecimento com base no ID
    $areaNome = $areas[$areaID];

    // Adiciona o titulo da tabela
    $html .= "<table style=\" font-family: 'Roboto Condensed', sans-serif; border: 0.5px solid  #19882c; width: 100vw;\">";
    $html .= "<caption style=\"bold:1rem; padding: 0.7rem; background-color:  #19882c; color: white; text-align:center; font-size: 1.2rem;\">$areaNome</caption>";
    // Adiciona o cabeçalho da tabela com as colunas desejadas
    $html .= "<tr style=\"padding: 0.7rem;font-size: 1rem;text-align: center; width: 100vw;\">";
    $html .= "<th style=\"background-color: #3F924D; color:white;\">ID</th>";
    $html .= "<th style=\"background-color: #3F924D; color:white;\">Nível</th>";
    $html .= "<th style=\"background-color: #3F924D; color:white;\">Título</th>";
    $html .= "<th style=\"background-color: #3F924D; color:white;\">Pesquisa</th>";
    $html .= "</tr>";

    // Loop pelos trabalhos na área de conhecimento atual
    foreach ($trabalhos as $trabalho) {
        // Adiciona uma nova linha na tabela para cada trabalho
        $html .= "<tr style=\"padding: 0.7rem;font-size: 1rem;text-align: center; \">";
        // Adiciona as células com os dados do trabalho
        $html .= "<td style=\"text-align:center;font-size: 0.7rem;padding: 0.7rem;\">" . htmlspecialchars($trabalho['id']) . "</td>";
        $html .= "<td style=\"text-align:center;font-size: 0.7rem;padding: 0.7rem;\">" . htmlspecialchars($trabalho['nivel']) . "</td>";
        $html .= "<td style=\"max-width: 35.5rem;\">" . htmlspecialchars($trabalho['titulo']) . "</td>";
        $html .= "<td style=\"text-align:center;font-size: 0.7rem;padding: 0.7rem;\">" . htmlspecialchars($pesquisas[$trabalho['tipo']]) . "</td>";
        // Fecha a linha da tabela
        $html .= "</tr>";
    }

    $html .= "</table>";

    $html .= "<div class=\"pagebreak\" style=\"margin-top: 40px\"> </div>";
}


$trabalhosAprovados = listarTrabalhosAprovadosPorArea('EM');

// Criando array de area de conhecimento
$areas = array(1 => "Ciências Agrárias e Engenharia", 2 => "Ciências Biológicas e da Saúde", 3 => "Ciências Exatas e da Terra", 4 => "Ciências Humanas, Sociais Aplicadas e Linguistica",  5 => "Multidisciplinar");

// Criando array de tipo de pesquisa
$pesquisas = array(1=> "Cientifica", 2=>"Tecnológica");

// Verifica se há trabalhos aprovados
foreach ($trabalhosAprovados as $areaID => $trabalhos) {
    // Obtém o nome da área de conhecimento com base no ID
    $areaNome = $areas[$areaID];

    // Adiciona o cabeçalho da tabela com as colunas desejadas
    $html .= "<table style=\" font-family: 'Roboto Condensed', sans-serif; border: 0.5px solid  #19882c; width: 100vw;\">";
    $html .= "<caption style=\"bold:1rem; padding: 0.7rem; background-color:  #19882c; color: white; text-align:center; font-size: 1.2rem;\">$areaNome</caption>";
    // Adiciona o cabeçalho da tabela com as colunas desejadas
    $html .= "<tr style=\"padding: 0.7rem;font-size: 1rem;text-align: center; width: 100vw;\">";
    $html .= "<th style=\"background-color: #3F924D; color:white;\">ID</th>";
    $html .= "<th style=\"background-color: #3F924D; color:white;\">Nível</th>";
    $html .= "<th style=\"background-color: #3F924D; color:white;\">Título</th>";
    $html .= "<th style=\"background-color: #3F924D; color:white;\">Pesquisa</th>";
    $html .= "</tr>";

    // Loop pelos trabalhos na área de conhecimento atual
    foreach ($trabalhos as $trabalho) {
        // Adiciona uma nova linha na tabela para cada trabalho
        $html .= "<tr style=\"padding: 0.7rem;font-size: 1rem;text-align: center; \">";
        // Adiciona as células com os dados do trabalho
        $html .= "<td style=\"text-align:center;font-size: 0.7rem;padding: 0.7rem;\">" . htmlspecialchars($trabalho['id']) . "</td>";
        $html .= "<td style=\"text-align:center;font-size: 0.7rem;padding: 0.7rem;\">" . htmlspecialchars($trabalho['nivel']) . "</td>";
        $html .= "<td style=\"max-width: 35.5rem;\">" . htmlspecialchars($trabalho['titulo']) . "</td>";
        $html .= "<td style=\"text-align:center;font-size: 0.7rem;padding: 0.7rem;\">" . htmlspecialchars($pesquisas[$trabalho['tipo']]) . "</td>";
        // Fecha a linha da tabela
        $html .= "</tr>";
    }

    $html .= "</table>";

    $html .= "<div class=\"pagebreak\" style=\"margin-top: 40px\"> </div>";
}




// Mostra o HTML da tabela na tela
echo $html;
?> 
