<?php

include_once '../Util/conectaPDO.php';



function backupDatabase($conexao, $output_filename)
{
    $backupDir = 'C:\xampp\mysql\data\fecintec'; // Substitua pelo caminho do diretório desejado
    $tables = array();
    $result = $conexao->query("SHOW TABLES");
    while ($row = $result->fetch(PDO::FETCH_NUM)) {
        $tables[] = $row[0];
    }

    $zip = new ZipArchive();
    if ($zip->open($backupDir . $output_filename, ZipArchive::CREATE) === true) {
        foreach ($tables as $table) {
            $result = $conexao->query('SELECT * FROM ' . $table);
            $output = "";
            $output .= 'DROP TABLE IF EXISTS ' . $table . ';';
            $row2 = $conexao->query('SHOW CREATE TABLE ' . $table)->fetch();
            $output .= "\n\n" . $row2[1] . ";\n\n";

            foreach ($result as $row) {
                $output .= 'INSERT INTO ' . $table . ' VALUES(';
                foreach ($row as $item) {
                    $output .= '"' . $item . '",';
                }
                $output = rtrim($output, ",");
                $output .= ");\n";
            }
            $zip->addFromString($table . '.sql', $output);
        }
        $zip->close();

        // Inicie o download do arquivo
        if (file_exists($backupDir . $output_filename)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename=' . basename($backupDir . $output_filename));
            header('Content-Length: ' . filesize($backupDir . $output_filename));
            readfile($backupDir . $output_filename);
            exit;
        } else {
            echo 'O arquivo de backup não foi encontrado.';
        }
    } else {
        echo 'Falha ao criar o arquivo de backup.';
    }
}

//*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Chamando a função de backup após a conexão com o banco de dados
$conexao = conecta(); // Chamando a função para obter a conexão

if ($conexao) {
    $output_filename = date('d-m-Y') . '.zip'; // Nome do arquivo de backup
    backupDatabase($conexao, $output_filename); // Passando a conexão para a função de backup
}




