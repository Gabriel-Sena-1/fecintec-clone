<?php
require_once(__DIR__ . '/../Util/conectaPDO.php');

function criarDB()
{

    $conn = conecta();

    try {

        $sql = "DROP TABLE log;
                DROP TABLE avaliacao;
                DROP TABLE estudante_trabalho;
                DROP TABLE estudante;
                DROP TABLE trabalho;
                DROP TABLE orientador;
                DROP TABLE avaliador_area_de_conhecimento;
                DROP TABLE avaliador;
                DROP TABLE questao;
                DROP TABLE tipo_de_pesquisa;
                DROP TABLE area_de_conhecimento;
                DROP TABLE usuario;
                DROP TABLE tipo_de_usuario;
                DROP TABLE evento;";

        $stmt = $conn->prepare($sql);

        $stmt->execute();

        $sql = "CREATE TABLE evento (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            nome varchar(100) COLLATE utf8_unicode_ci NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        
            INSERT INTO `evento` (`id`, nome) VALUES
            (1, 'fecintec 2023');
            
            CREATE TABLE tipo_de_usuario (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            tipo varchar(100) COLLATE utf8_unicode_ci NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

            INSERT INTO tipo_de_usuario (id, tipo) VALUES
            (1, 'administrador'),
            (2, 'monitor'),
            (3, 'avaliador');

            CREATE TABLE `usuario` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `email` varchar(100) NOT NULL,
            `nome` varchar(200) NOT NULL,
            `senha` varchar(100) NOT NULL,
            id_evento bigint UNSIGNED NOT NULL,
            id_tipo bigint UNSIGNED NOT NULL,
            UNIQUE(email),
            FOREIGN KEY (id_tipo) REFERENCES tipo_de_usuario (id),
            FOREIGN KEY (id_evento) REFERENCES evento (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

            INSERT INTO `usuario` (`id`, `email`, `nome`, `senha`, id_evento, id_tipo) VALUES
            (1, 'wesley@email.com', 'Wesley', 'e10adc3949ba59abbe56e057f20f883e', 1,1);

            CREATE TABLE `area_de_conhecimento` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `descricao` varchar(200) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

            INSERT INTO `area_de_conhecimento` (`id`, `descricao`) VALUES
            (1, 'CAE - Ciências Agrárias e Engenharias:'),
            (2, 'CBS - Ciências Biológicas e da Saúde'),
            (3, 'CET - Ciências Exatas e da Terra'),
            (4, 'CHSAL - Ciências Humanas; Sociais Aplicadas e Linguística'),
            (5, 'MDIS - Multidisciplinar');

            CREATE TABLE `tipo_de_pesquisa` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `descricao` varchar(60) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

            INSERT INTO `tipo_de_pesquisa` (`id`, `descricao`) VALUES
            (1, 'Científica'),
            (2, 'Tecnológica');

            CREATE TABLE `questao` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `criterio` varchar(200) NOT NULL,
            `id_tipo_de_pesquisa` bigint(20) UNSIGNED NOT NULL,
            FOREIGN KEY (id_tipo_de_pesquisa) REFERENCES tipo_de_pesquisa (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

            INSERT INTO `questao` (`id`, `criterio`, `id_tipo_de_pesquisa`) VALUES
            (1, 'Problema - Hipótese', 1),
            (2, 'Coleta de Dados - Metodologia', 1),
            (3, 'Considerações Finais', 1),
            (4, 'Resumo Expandido', 1),
            (5, 'Banner', 1),
            (6, 'Relatório do Trabalho', 1),
            (7, 'Caderno de Campo - Diário de Bordo', 1),
            (8, 'Apresentação Oral', 1),
            (9, 'Apresentação Visual - Estande', 1),
            (10, 'Problema', 2),
            (11, 'Elaboração do Projeto - Metodologia', 2),
            (12, 'Produto - Processo', 2),
            (13, 'Resumo Expandido', 2),
            (14, 'Banner', 2),
            (15, 'Relatório do Trabalho', 2),
            (16, 'Caderno de Campo - Diário de Bordo', 2),
            (17, 'Apresentação Oral', 2),
            (18, 'Apresentação Visual - Estande', 2);

            CREATE TABLE `avaliador` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `cidade_instituicao` varchar(100) DEFAULT NULL,
            `cpf` varchar(11) NOT NULL,
            `link_lattes` varchar(200) DEFAULT NULL,
            `presenca` boolean DEFAULT FALSE NOT NULL ,  
            `orienta` boolean DEFAULT FALSE NOT NULL ,  
            `telefone` varchar(50) DEFAULT NULL,
            id_usuario bigint UNSIGNED not NULL,
            FOREIGN KEY (id_usuario)  REFERENCES usuario(id),
            UNIQUE (cpf)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

            CREATE TABLE avaliador_area_de_conhecimento (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            id_area_de_conhecimento bigint UNSIGNED NOT NULL, 
            id_avaliador bigint UNSIGNED NOT NULL, 
            FOREIGN KEY (id_area_de_conhecimento) REFERENCES area_de_conhecimento (id), 
            FOREIGN KEY (id_avaliador)  REFERENCES avaliador (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

            CREATE TABLE orientador (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            nome varchar(100) COLLATE utf8_unicode_ci NOT NULL,
            email varchar(50) COLLATE utf8_unicode_ci,
            presenca boolean COLLATE utf8_unicode_ci NOT NULL DEFAULT FALSE,
            cpf varchar(11) COLLATE utf8_unicode_ci NOT NULL,
            UNIQUE (cpf)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

            CREATE TABLE trabalho (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            nivel varchar(50) COLLATE utf8_unicode_ci NOT NULL,
            descricaoMDIS varchar(200) COLLATE utf8_unicode_ci,
            titulo varchar(500) COLLATE utf8_unicode_ci NOT NULL,
            notaResumo double NOT NULL,
            instituicao varchar(300) COLLATE utf8_unicode_ci,
            ativo boolean COLLATE utf8_unicode_ci NOT NULL DEFAULT true,
            id_area_de_conhecimento bigint UNSIGNED NOT NULL, 
            id_orientador bigint UNSIGNED NOT NULL, 
            id_coorientador bigint UNSIGNED, 
            id_tipo_de_pesquisa bigint UNSIGNED NOT NULL, 
            FOREIGN KEY (id_area_de_conhecimento)  REFERENCES area_de_conhecimento (id), 
            FOREIGN KEY (id_orientador) REFERENCES orientador (id), 
            FOREIGN KEY (id_coorientador) REFERENCES orientador (id), 
            FOREIGN KEY (id_tipo_de_pesquisa)  REFERENCES tipo_de_pesquisa (id) 
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

            CREATE TABLE estudante (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            nome varchar(100) COLLATE utf8_unicode_ci NOT NULL,
            presenca boolean COLLATE utf8_unicode_ci NOT NULL DEFAULT FALSE,
            kit boolean COLLATE utf8_unicode_ci NOT NULL DEFAULT FALSE,
            `cpf` varchar(11) NOT NULL,
            UNIQUE (cpf)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

            CREATE TABLE estudante_trabalho (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `id_estudante` bigint UNSIGNED NOT NULL,
            id_trabalho bigint UNSIGNED NOT NULL,
            FOREIGN KEY (id_estudante) REFERENCES estudante (id),
            FOREIGN KEY (id_trabalho) REFERENCES trabalho (id),
            CONSTRAINT idet UNIQUE (id_estudante,id_trabalho)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

            CREATE TABLE `avaliacao` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `id_avaliador` bigint(20) UNSIGNED NOT NULL,
            `id_trabalho` bigint(20) UNSIGNED NOT NULL,
            `id_questao` bigint(20) UNSIGNED NOT NULL,
            status boolean DEFAULT true NOT NULL,
            `nota` double DEFAULT NULL,
            CONSTRAINT ida UNIQUE (id_avaliador,id_trabalho,id_questao)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

            CREATE TABLE log (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            comentario varchar(100) COLLATE utf8_unicode_ci NOT NULL,
            horario TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

        ";

        $stmt = $conn->prepare($sql);

        $stmt->execute();

    } catch (PDOException $e) {
        echo $e->getMessage();
        echo "<br> Erro na função criarDB";
    }

}

if (!empty($_GET['action']) && $_GET['action'] == 'criarDB') {
    criarDB();

    $msg = "Resetado com sucesso!!";
    header("Location: ./../View/adm/saguaoAdm.php?msg=$msg");
}

?>