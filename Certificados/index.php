        <?php

        include_once './lib/vendor/autoload.php';
        require_once(__DIR__ . '/../Util/conectaPDO.php');
        require_once(__DIR__ . '/../Controller/avaliacaoController.php');

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;




        $emails = array("gabrielmirandasena11@gmail.com", "thiago.silva17@estudante.ifms.edu.br", "vinicius.ferreira6@estudante.ifms.edu.br");


        try {


            echo "<pre>";
            $conn = conecta();

            // cria variavel para a lista orientadores - é usada em avaliador controler
            $listaOrientadores = array();

            try {
                // Inicia uma transação no banco de dados
                $conn->beginTransaction();

                // Executa uma consulta para buscar todos os avaliadores ordenados por ID
                $sqlListar = "SELECT * FROM avaliador ORDER BY id";
                $stmt = $conn->prepare($sqlListar);
                $stmt->execute();

                // Obtém os resultados da consulta como um array associativo
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                // Em caso de erro, captura a exceção do PDO e imprime a mensagem de erro
                echo "ERRO";
                echo $e->getMessage();
            }

            $j = 0;

            foreach ($result as $avaliador) {

                $mail = new PHPMailer(true);
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->CharSet = 'UTF-8';
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'gabriel.sena@estudante.ifms.edu.br';
                $mail->Password = 'adywakxwdjfqyczz';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->setFrom('gabriel.sena@estudante.ifms.edu.br', 'FECINTEC 2023');
                $mail->Subject = 'Certificado FECINTEC 2023';

                $trabalhosAvaliados = trabalhosAvaliadosAvaliador($avaliador['id']);
                
                
                $mail->addAddress($emails[$j], $emails[$j]);

                $mail->Body = "Olá " . $avaliador['nome'] . " aqui está o seu certificado da FECINTEC 2023.";

                foreach ($trabalhosAvaliados as $trabalho) {

                    // GERAR O PDF
                    $nomeArquivo = "Certificado Trabalho - " . $trabalho['titulo'];


                    // COLOCAR CAMINHO PARA O PDF
                    // echo "<pre>";
                    // echo $avaliador['nome'];
                    // echo "<br>";
                    // echo $trabalho['titulo'];
                    // echo "<br>";
                    // echo $avaliador['email'];
                    // echo "<br>";
                    // echo $nomeArquivo;
                    // echo "</pre>";


                    $mail->addAttachment("./../CertificadoAvaliadoresTrabalhos/TrabalhosPDF.pdf", $nomeArquivo . ".pdf"); // 


                }

                $mail->send();
                echo 'E-mail enviado com sucesso!<br>';

                $j++;
                if ($j == 3) {
                    break;
                }
                echo "<br>";
            }
        } catch (Exception $e) {
            echo "Erro: E-mail não enviado com sucesso. Error PHPMailer: {$mail->ErrorInfo}";
            //echo "Erro: E-mail não enviado com sucesso.<br>";
        }
