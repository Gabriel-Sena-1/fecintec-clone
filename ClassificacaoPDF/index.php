<?php

// Carregar o Composer
require './vendor/autoload.php';

// Referenciar o namespace Dompdf
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->setChroot(__DIR__);

$options->setIsRemoteEnabled(true);

try {

    $ch = curl_init();

    
    if (isset($_REQUEST['action'])) {//* Verifica se existe uma variável $_REQUEST['action'] definida
    
        $action = trim(strtolower($_REQUEST['action']));

        $nome = '';
        
        switch ($action) { //* Define a URL do arquivo PHP que você deseja carregar de acordo com o valor da variável $action
            case 'avaliadorpdf':
                curl_setopt($ch, CURLOPT_URL, "http://localhost/fecintec/View/adm/pdf/tabelaAvaliador.php");
                $nome = "AvaliadoresPDF";
                break;
            case 'trabalhopdf':
                curl_setopt($ch, CURLOPT_URL, "http://localhost/fecintec/View/adm/pdf/tabelaTrabalho.php");
                $nome = "TrabalhosPDF";
                break;
            case 'classificacaopdf':
                curl_setopt($ch, CURLOPT_URL, "http://localhost/fecintec/View/adm/pdf/rankingFeira.php");
                $nome = "ClassificaçãoPDF";
                break;
            default:
                echo "Ação inválida!";
                exit;
        }

        // Retorna a transferência como uma string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contém a saída em string
        $output = curl_exec($ch);

        // Fecha a sessão cURL para liberar recursos do sistema
        curl_close($ch);

        // Agora você pode carregar a string HTML no domPDF
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($output);
        $dompdf->render();
        $dompdf->stream($nome);
        header('Content-type: application/pdf');
        echo $dompdf->output();
    } else {
        echo "Não existe ação action";
    }
    
} catch (\Exception $e) {
    echo $e->getMessage();
}
 
    
    

?>

// Carregar o Composer
// require './vendor/autoload.php';

// // Referenciar o namespace Dompdf
// use Dompdf\Dompdf;
// use Dompdf\Options;

// $options = new Options();
// $options->setChroot(__DIR__);

// $options->setIsRemoteEnabled(true);

// // Cria uma nova instância cURL
// $ch = curl_init();

// // Define a URL do arquivo PHP que você deseja carregar
// curl_setopt($ch, CURLOPT_URL, "http://localhost/fecintec/View/adm/rankingFeira.php");

// // Retorna a transferência como uma string
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// // $output contém a saída em string
// $output = curl_exec($ch);

// // Fecha a sessão cURL para liberar recursos do sistema
// curl_close($ch);


// // Agora você pode carregar a string HTML no domPDF




// $dompdf = new Dompdf($options);

// $dompdf->loadHtml($output);

// $dompdf->render();

// $dompdf->stream('ClassificaçãoFeiraPDF');

// header('Content-type: application/pdf');
// echo $dompdf->output(); 