-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29/06/2023 às 16:16
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `fecintec`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `administrador`
--

CREATE TABLE `administrador` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(100) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `senha` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `administrador`
--

INSERT INTO `administrador` (`id`, `email`, `nome`, `senha`) VALUES
(1, 'wesley@email.com', 'Wesley', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Estrutura para tabela `area_de_conhecimento`
--

CREATE TABLE `area_de_conhecimento` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descricao` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `area_de_conhecimento`
--

INSERT INTO `area_de_conhecimento` (`id`, `descricao`) VALUES
(1, 'CAE - Ciências Agrárias e Engenharias:'),
(2, 'CBS - Ciências Biológicas e da Saúde'),
(3, 'CET - Ciências Exatas e da Terra'),
(4, 'CHSAL - Ciências Humanas; Sociais Aplicadas e Linguística'),
(5, 'MDIS - Multidisciplinar');

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacao`
--

CREATE TABLE `avaliacao` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_avaliador` bigint(20) UNSIGNED NOT NULL,
  `id_trabalho` bigint(20) UNSIGNED NOT NULL,
  `id_questao` bigint(20) UNSIGNED NOT NULL,
  `nota` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliador`
--

CREATE TABLE `avaliador` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cidade_instituicao` varchar(100) DEFAULT NULL,
  `cpf` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `link_lattes` varchar(200) DEFAULT NULL,
  `nome` varchar(200) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `telefone` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `avaliador`
--

INSERT INTO `avaliador` (`id`, `cidade_instituicao`, `cpf`, `email`, `link_lattes`, `nome`, `senha`, `telefone`) VALUES
(1, NULL, '65909862154', 'adilso@email.com', NULL, 'Adilso de Campos Garcia', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(2, NULL, '65286329284', 'adilson@email.com', NULL, 'Adilson Beatriz', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(3, NULL, '57726742500', 'adriana@email.com', NULL, 'Adriana de Melo Miranda', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(4, NULL, '63195286645', 'agnaldo@email.com', NULL, 'Agnaldo de Oliveira', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(5, NULL, '28318727401', 'aline@email.com', NULL, 'Aline Ferreira da Silva Santos', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(6, NULL, '10212212010', 'matheus@email.com', NULL, 'Matheus dos Santos', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(7, NULL, '36797241367', 'julia@email.com', NULL, 'Julia Maria', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(8, NULL, '91262289394', 'helen@email.com', NULL, 'Helen Saria', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(9, NULL, '57796162642', 'cleusa@email.com', NULL, 'Cleusa Silva', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(10, NULL, '45447370108', 'hoshino@email.com', NULL, 'Yuri Hoshino', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(11, NULL, '80730059138', 'carlo@email.com', NULL, 'Carlo Fagundes', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(12, NULL, '86686542920', 'pinto@email.com', NULL, 'Arnaldo da Silva Pinto', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(13, NULL, '13207679315', 'paulo@email.com', NULL, 'Paulo Mendes', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(14, NULL, '21138723665', 'maia@email.com', NULL, 'Gustavo Maia', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(15, NULL, '80878749357', 'diego@email.com', NULL, 'Diego Iudi', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(16, NULL, '61842947419', 'laura@email.com', NULL, 'Laura Menato', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(17, NULL, '93794114485', 'fernando@email.com', NULL, 'Fernando Cristo', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(18, NULL, '18688430250', 'kaio@email.com', NULL, 'Kaio Salvador', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(19, NULL, '15715306574', 'kanashita@email.com', NULL, 'Maria Kanashita', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(20, NULL, '99431772680', 'rodrigo@email.com', NULL, 'Rodrigo Fernandes', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(21, NULL, '72404868691', 'osvaldo@email.com', NULL, 'Osvaldo Ovo', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(22, NULL, '45979411771', 'ferraz@email.com', NULL, 'João Ferraz', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(23, NULL, '55956305665', 'minato@email.com', NULL, 'Luis Minato', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(24, NULL, '03536357822', 'adilso@email.com', NULL, 'Adilso de Campos Garcia', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(25, NULL, '33105302212', 'airton@email.com', NULL, 'Airton Jose Vinholi Junior', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(26, NULL, '83159004392', 'aislan@email.com', NULL, 'Aislan Vieira de Melo', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(27, NULL, '71684434378', 'alexandre@email.com', NULL, 'Alexandre Soares da Silva', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(28, NULL, '89345189793', 'ana@email.com', NULL, 'Ana Claudia Navarrete Menezes', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(29, NULL, '94738033468', 'anderson@email.com', NULL, 'Anderson Martins Corrêa', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(30, NULL, '30109721802', 'anderson1@email.com', NULL, 'Anderson Pereira Tolotti', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(31, NULL, '90809261324', 'andreia@email.com', NULL, 'Andreia Dias de Souza', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(32, NULL, '02392842914', 'andrerika@email.com', NULL, 'Andrerika Vieira Lima Silva', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(33, NULL, '21284357902', 'angelo@email.com', NULL, 'Angelo Cesar de Lourenço', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(34, NULL, '17899480450', 'antonio@email.com', NULL, 'Antonio Leonardo de Araujo Neto', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(35, NULL, '96981829347', 'arnaldo@email.com', NULL, 'Arnaldo Pinheiro Montalvão Júnior', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(36, NULL, '81538652420', 'beatriz@email.com', NULL, 'Beatriz Aparecida Alencar', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(37, NULL, '78296198240', 'carla@email.com', NULL, 'Carla Aluchna Correa', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(38, NULL, '12404281623', 'carla1@email.com', NULL, 'Carla Maria Badin Guizado', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(39, NULL, '34651101372', 'carlos@email.com', NULL, 'Carlos Alberto Midon Silva', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(40, NULL, '11770380051', 'cassima@email.com', NULL, 'Cassima Zatorre Ortegosa', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(41, NULL, '17537475970', 'celeny@email.com', NULL, 'Celeny Fernandes Alves', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(42, NULL, '09494397894', 'celio@email.com', NULL, 'Célio Gianelli Pinheiro', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(43, NULL, '50203281209', 'clarissa@email.com', NULL, 'Clarissa Gomes Pinheiro de Sá', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(44, NULL, '06002504826', 'claudia@email.com', NULL, 'Claudia Santos Fernandes', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(45, NULL, '06016896314', 'danyelle@email.com', NULL, 'Danyelle Almeida Saraiva', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(46, NULL, '50541452304', 'dante@email.com', NULL, 'Dante Alighieri Alves de Mello', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(47, NULL, '05018455349', 'david@email.com', NULL, 'David Denner Dias Quinelato', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(48, NULL, '06347885824', 'dejahyr@email.com', NULL, 'Dejahyr Lopes Junior', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(49, NULL, '63782547020', 'delmir@email.com', NULL, 'Delmir da Costa Felipe', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(50, NULL, '56866824613', 'douglas@email.com', NULL, 'Douglas Buytendorp Bizarro', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(51, NULL, '90563230088', 'edelvan@email.com', NULL, 'Edelvan Hellmann Zanella', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(52, NULL, '28626962347', 'eder@email.com', NULL, 'Eder de Souza Rodrigues', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(53, NULL, '33245350180', 'edi@email.com', NULL, 'Edi Carlos Aparecido Marques', 'e10adc3949ba59abbe56e057f20f883e', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliador_area_de_conhecimento`
--

CREATE TABLE `avaliador_area_de_conhecimento` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_area_de_conhecimento` bigint(20) UNSIGNED NOT NULL,
  `id_avaliador` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `avaliador_area_de_conhecimento`
--

INSERT INTO `avaliador_area_de_conhecimento` (`id`, `id_area_de_conhecimento`, `id_avaliador`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 2, 1),
(7, 2, 2),
(8, 2, 3),
(9, 2, 6),
(10, 2, 7),
(11, 3, 1),
(12, 3, 2),
(13, 3, 3),
(14, 3, 6),
(15, 3, 8),
(16, 4, 1),
(17, 4, 2),
(18, 4, 3),
(19, 4, 9),
(20, 4, 10),
(21, 5, 1),
(22, 5, 2),
(23, 5, 3),
(24, 5, 11),
(25, 5, 12),
(26, 1, 13),
(27, 1, 14),
(28, 1, 15),
(29, 1, 16),
(30, 1, 17),
(31, 2, 13),
(32, 2, 14),
(33, 2, 15),
(34, 2, 18),
(35, 2, 19),
(36, 3, 13),
(37, 3, 14),
(38, 3, 15),
(39, 3, 20),
(40, 3, 21),
(41, 4, 13),
(42, 4, 14),
(43, 4, 15),
(44, 4, 22),
(45, 4, 23),
(46, 5, 13),
(47, 5, 14),
(48, 5, 15),
(49, 5, 24),
(50, 5, 25),
(51, 1, 26),
(52, 1, 27),
(53, 1, 28),
(54, 1, 29),
(55, 1, 30),
(56, 2, 26),
(57, 2, 27),
(58, 2, 28),
(59, 2, 31),
(60, 2, 32),
(61, 3, 26),
(62, 3, 27),
(63, 3, 28),
(64, 3, 33),
(65, 3, 34),
(66, 4, 26),
(67, 4, 27),
(68, 4, 28),
(69, 4, 35),
(70, 4, 36),
(71, 5, 26),
(72, 5, 27),
(73, 5, 28),
(74, 5, 37),
(75, 5, 38),
(76, 1, 39),
(77, 1, 40),
(78, 1, 41),
(79, 1, 42),
(80, 1, 43),
(81, 2, 39),
(82, 2, 40),
(83, 2, 41),
(84, 2, 44),
(85, 2, 45),
(86, 3, 39),
(87, 3, 40),
(88, 3, 41),
(89, 3, 46),
(90, 3, 47),
(91, 4, 39),
(92, 4, 40),
(93, 4, 41),
(94, 4, 48),
(95, 4, 49),
(96, 5, 39),
(97, 5, 40),
(98, 5, 41),
(99, 5, 50),
(100, 5, 51),
(101, 1, 52),
(102, 1, 53),
(103, 2, 52),
(104, 2, 53),
(105, 3, 52),
(106, 4, 52),
(107, 5, 52),
(108, 5, 53);

-- --------------------------------------------------------

--
-- Estrutura para tabela `questao`
--

CREATE TABLE `questao` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `criterio` varchar(200) NOT NULL,
  `id_tipo_de_pesquisa` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `questao`
--

INSERT INTO `questao` (`id`, `criterio`, `id_tipo_de_pesquisa`) VALUES
(1, 'Problema / Hipótese', 1),
(2, 'Coleta de Dados / Metodologia', 1),
(3, 'Considerações Finais', 1),
(4, 'Resumo Expandido', 1),
(5, 'Banner', 1),
(6, 'Relatório do Trabalho', 1),
(7, 'Caderno de Campo / Diário de Bordo', 1),
(8, 'Apresentação Oral', 1),
(9, 'Apresentação Visual', 1),
(10, 'Problema', 2),
(11, 'Elaboração do Projeto / Metodologia', 2),
(12, 'Produto / Processo', 2),
(13, 'Resumo Expandido', 2),
(14, 'Banner', 2),
(15, 'Relatório do Trabalho', 2),
(16, 'Caderno de Campo / Diário de Bordo', 2),
(17, 'Apresentação Oral', 2),
(18, 'Apresentação Visual', 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipo_de_pesquisa`
--

CREATE TABLE `tipo_de_pesquisa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descricao` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `tipo_de_pesquisa`
--

INSERT INTO `tipo_de_pesquisa` (`id`, `descricao`) VALUES
(1, 'Científica'),
(2, 'Tecnológica');

-- --------------------------------------------------------

--
-- Estrutura para tabela `trabalho`
--

CREATE TABLE `trabalho` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `cpf_coorientador` varchar(11) DEFAULT NULL,
  `cpf_orientador` varchar(11) NOT NULL,
  `descricaoMDIS` varchar(200) DEFAULT NULL,
  `email_coorientador` varchar(50) DEFAULT NULL,
  `email_orientador` varchar(50) NOT NULL,
  `estudantes` varchar(300) NOT NULL,
  `nome_coorientador` varchar(100) DEFAULT NULL,
  `nome_orientador` varchar(100) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `id_area_de_conhecimento` bigint(20) UNSIGNED NOT NULL,
  `id_tipo_de_pesquisa` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `trabalho`
--

INSERT INTO `trabalho` (`id`, `categoria`, `cpf_coorientador`, `cpf_orientador`, `descricaoMDIS`, `email_coorientador`, `email_orientador`, `estudantes`, `nome_coorientador`, `nome_orientador`, `titulo`, `id_area_de_conhecimento`, `id_tipo_de_pesquisa`) VALUES
(1, 'EM', NULL, '11770380051', NULL, NULL, 'emailOrientador1@email.com', 'Aluno1', NULL, 'Orientador1', 'T1', 1, 2),
(2, 'EF', NULL, '06016896314', NULL, NULL, 'emailOrientador2@email.com', 'Aluno2', NULL, 'Orientador2', 'T2', 2, 1),
(3, 'EM', NULL, '00000000003', NULL, NULL, 'emailOrientador3@email.com', 'Aluno3', NULL, 'orientador3', 'T3', 3, 1),
(4, 'EM', NULL, '00000000004', NULL, NULL, 'emailOrientador4@email.com', 'Aluno4', NULL, 'orientador4', 'T4', 4, 2),
(5, 'EM', NULL, '00000000005', NULL, NULL, 'emailOrientador5@email.com', 'Aluno5', NULL, 'orientador5', 'T5', 5, 2),
(6, 'EM', NULL, '06016896314', NULL, NULL, 'emailOrientador6@email.com', 'Aluno6', NULL, 'orientador6', 'T6', 2, 1),
(7, 'EM', NULL, '00000000007', NULL, NULL, 'emailOrientador7@email.com', 'Aluno7', NULL, 'orientador7', 'T7', 3, 2),
(8, 'EM', NULL, '00000000008', NULL, NULL, 'emailOrientador8@email.com', 'Aluno8', NULL, 'orientador8', 'T8', 4, 1),
(9, 'EF', NULL, '00000000009', NULL, NULL, 'emailOrientador9@email.com', 'Aluno9', NULL, 'orientador9', 'T9', 5, 1),
(10, 'EM', NULL, '11770380051', NULL, NULL, 'emailOrientador10@email.com', 'Aluno10', NULL, 'orientador10', 'T10', 1, 1),
(11, 'EM', NULL, '00000000011', NULL, NULL, 'emailOrientador11@email.com', 'Aluno11', NULL, 'orientador11', 'T11', 2, 1),
(12, 'EM', NULL, '00000000012', NULL, NULL, 'emailOrientador12@email.com', 'Aluno12', NULL, 'orientador12', 'T12', 4, 2),
(13, 'EM', NULL, '00000000013', NULL, NULL, 'emailOrientador13@email.com', 'Aluno13', NULL, 'orientador13', 'T13', 4, 1),
(14, 'EM', NULL, '00000000014', NULL, NULL, 'emailOrientador14@email.com', 'Aluno14', NULL, 'orientador14', 'T14', 5, 1),
(15, 'EF', NULL, '00000000015', NULL, NULL, 'emailOrientador15@email.com', 'Aluno15', NULL, 'orientador15', 'T15', 3, 2),
(16, 'EM', NULL, '00000000016', NULL, NULL, 'emailOrientador16@email.com', 'Aluno16', NULL, 'orientador16', 'T16', 2, 2),
(17, 'EM', NULL, '91262289394', NULL, NULL, 'emailOrientador17@email.com', 'Aluno17', NULL, 'orientador17', 'T17', 3, 2),
(18, 'EM', NULL, '52830676378', NULL, NULL, 'emailOrientador18@email.com', 'Aluno18', NULL, 'orientador18', 'T18', 1, 1),
(19, 'EM', NULL, '61842947419', NULL, NULL, 'emailOrientador19@email.com', 'Aluno19', NULL, 'orientador19', 'T19', 1, 1),
(20, 'EM', NULL, '23093903645', NULL, NULL, 'emailOrientador20@email.com', 'Aluno20', NULL, 'orientador20', 'T20', 2, 1),
(21, 'EF', NULL, '00000000021', NULL, NULL, 'emailOrientador21@email.com', 'Aluno21', NULL, 'orientador21', 'T21', 4, 2),
(22, 'EM', NULL, '00000000022', NULL, NULL, 'emailOrientador22@email.com', 'Aluno22', NULL, 'orientador22', 'T22', 5, 1),
(23, 'EM', NULL, '91262289394', NULL, NULL, 'emailOrientador23@email.com', 'Aluno23', NULL, 'orientador23', 'T23', 3, 1),
(24, 'EM', NULL, '00000000024', NULL, NULL, 'emailOrientador24@email.com', 'Aluno24', NULL, 'orientador24', 'T24', 3, 2),
(25, 'EF', NULL, '10212212010', NULL, NULL, 'emailOrientador25@email.com', 'Aluno25', NULL, 'orientador25', 'T25', 2, 1),
(26, 'EM', NULL, '18391650650', NULL, NULL, 'emailOrientador26@gmail.com', 'Aluno26', NULL, 'Orientador26', 'T26', 1, 2),
(27, 'EF', NULL, '00000000027', NULL, NULL, 'emailOrientador27@gmail.com', 'Aluno27', NULL, 'Orientador27', 'T27', 4, 1),
(28, 'EM', NULL, '00000000028', NULL, NULL, 'emailOrientador28@gmail.com', 'Aluno28', NULL, 'Orientador28', 'T28', 5, 2),
(29, 'EF', NULL, '00000000029', NULL, NULL, 'emailOrientador29@gmail.com', 'Aluno29', NULL, 'Orientador29', 'T29', 5, 1),
(30, 'EM', NULL, '00000000030', NULL, NULL, 'emailOrientador30@gmail.com', 'Aluno30', NULL, 'Orientador30', 'T30', 5, 2),
(31, 'EF', NULL, '00000000031', NULL, NULL, 'emailOrientador31@gmail.com', 'Aluno31', NULL, 'Orientador31', 'T31', 3, 1),
(32, 'EM', NULL, '00000000032', NULL, NULL, 'emailOrientador32@gmail.com', 'Aluno32', NULL, 'Orientador32', 'T32', 2, 2),
(33, 'EF', NULL, '00000000033', NULL, NULL, 'emailOrientador33@gmail.com', 'Aluno33', NULL, 'Orientador33', 'T33', 3, 1),
(34, 'EM', NULL, '00000000034', NULL, NULL, 'emailOrientador34@gmail.com', 'Aluno34', NULL, 'Orientador34', 'T34', 3, 2),
(35, 'EF', NULL, '00000000035', NULL, NULL, 'emailOrientador35@gmail.com', 'Aluno35', NULL, 'Orientador35', 'T35', 2, 1),
(36, 'EM', NULL, '10212212010', NULL, NULL, 'emailOrientador36@gmail.com', 'Aluno36', NULL, 'Orientador36', 'T36', 2, 2),
(37, 'EF', NULL, '00000000037', NULL, NULL, 'emailOrientador37@gmail.com', 'Aluno37', NULL, 'Orientador37', 'T37', 2, 1),
(38, 'EM', NULL, '00000000038', NULL, NULL, 'emailOrientador38@gmail.com', 'Aluno38', NULL, 'Orientador38', 'T38', 1, 2),
(39, 'EF', NULL, '00000000039', NULL, NULL, 'emailOrientador39@gmail.com', 'Aluno39', NULL, 'Orientador39', 'T39', 1, 1),
(40, 'EM', NULL, '00000000040', NULL, NULL, 'emailOrientador40@gmail.com', 'Aluno40', NULL, 'Orientador40', 'T40', 3, 2),
(41, 'EF', NULL, '00000000041', NULL, NULL, 'emailOrientador41@gmail.com', 'Aluno41', NULL, 'Orientador41', 'T41', 4, 1),
(42, 'EM', NULL, '00000000042', NULL, NULL, 'emailOrientador42@gmail.com', 'Aluno42', NULL, 'Orientador42', 'T42', 5, 2),
(43, 'EF', '33105302212', '00000000043', NULL, NULL, 'emailOrientador43@gmail.com', 'Aluno43', NULL, 'Orientador43', 'T43', 5, 1),
(44, 'EM', '03536357822', '00000000044', NULL, NULL, 'emailOrientador44@gmail.com', 'Aluno44', NULL, 'Orientador44', 'T44', 5, 2),
(45, 'EF', NULL, '00000000045', NULL, NULL, 'emailOrientador45@gmail.com', 'Aluno45', NULL, 'Orientador45', 'T45', 4, 1),
(46, 'EM', NULL, '00000000046', NULL, NULL, 'emailOrientador46@gmail.com', 'Aluno46', NULL, 'Orientador46', 'T46', 4, 2),
(47, 'EF', NULL, '00000000000', NULL, NULL, 'emailOrientador47@gmail.com', 'Aluno47', NULL, 'Orientador47', 'T47', 4, 1),
(48, 'EM', NULL, '00000000048', NULL, NULL, 'emailOrientador48@gmail.com', 'Aluno48', NULL, 'Orientador48', 'T48', 3, 2),
(49, 'EF', NULL, '00000000049', NULL, NULL, 'emailOrientador49@gmail.com', 'Aluno49', NULL, 'Orientador49', 'T49', 3, 1),
(50, 'EM', NULL, '00000000050', NULL, NULL, 'emailOrientador50@gmail.com', 'Aluno50', NULL, 'Orientador50', 'T50', 2, 2),
(51, 'EM', NULL, '00000000005', NULL, NULL, 'emailOrientador51@email.com', 'Aluno51', NULL, 'Orientador51', 'T51', 1, 2),
(52, 'EF', NULL, '00000000005', NULL, NULL, 'emailOrientador52@email.com', 'Aluno52', NULL, 'Orientador52', 'T52', 1, 1),
(53, 'EF', NULL, '00000000005', NULL, NULL, 'emailOrientador53@email.com', 'Aluno53', NULL, 'Orientador53', 'T53', 1, 1),
(54, 'EF', NULL, '00000000005', NULL, NULL, 'emailOrientador54@email.com', 'Aluno54', NULL, 'Orientador54', 'T54', 2, 2),
(55, 'EF', NULL, '00000000005', NULL, NULL, 'emailOrientador55@email.com', 'Aluno55', NULL, 'Orientador55', 'T55', 2, 2),
(56, 'EF', NULL, '00000000005', NULL, NULL, 'emailOrientador56@email.com', 'Aluno56', NULL, 'Orientador56', 'T56', 2, 2),
(57, 'EF', NULL, '00000000005', NULL, NULL, 'emailOrientador57@email.com', 'Aluno57', NULL, 'Orientador57', 'T57', 2, 2),
(58, 'EF', NULL, '00000000005', NULL, NULL, 'emailOrientador58@email.com', 'Aluno58', NULL, 'Orientador58', 'T58', 2, 2),
(59, 'EF', NULL, '00000000005', NULL, NULL, 'emailOrientador59@email.com', 'Aluno59', NULL, 'Orientador59', 'T59', 3, 2),
(60, 'EF', NULL, '00000000006', NULL, NULL, 'emailOrientador60@email.com', 'Aluno60', NULL, 'Orientador60', 'T60', 3, 2),
(61, 'EF', NULL, '00000000006', NULL, NULL, 'emailOrientador61@email.com', 'Aluno61', NULL, 'Orientador61', 'T61', 1, 2),
(62, 'EF', NULL, '00000000006', NULL, NULL, 'emailOrientador62@email.com', 'Aluno62', NULL, 'Orientador62', 'T62', 3, 2),
(63, 'EF', NULL, '00000000006', NULL, NULL, 'emailOrientador63@email.com', 'Aluno63', NULL, 'Orientador63', 'T63', 1, 2),
(64, 'EF', NULL, '00000000006', NULL, NULL, 'emailOrientador64@email.com', 'Aluno64', NULL, 'Orientador64', 'T64', 1, 2),
(65, 'EF', NULL, '00000000006', NULL, NULL, 'emailOrientador65@email.com', 'Aluno65', NULL, 'Orientador65', 'T65', 5, 2),
(66, 'EF', NULL, '00000000006', NULL, NULL, 'emailOrientador66@email.com', 'Aluno66', NULL, 'Orientador66', 'T66', 3, 2),
(67, 'EF', NULL, '00000000006', NULL, NULL, 'emailOrientador67@email.com', 'Aluno67', NULL, 'Orientador67', 'T67', 3, 2),
(68, 'EF', NULL, '00000000006', NULL, NULL, 'emailOrientador68@email.com', 'Aluno68', NULL, 'Orientador68', 'T68', 4, 2),
(69, 'EF', NULL, '00000000006', NULL, NULL, 'emailOrientador69@email.com', 'Aluno69', NULL, 'Orientador69', 'T69', 5, 2),
(70, 'EF', NULL, '00000000007', NULL, NULL, 'emailOrientador70@email.com', 'Aluno70', NULL, 'Orientador70', 'T70', 5, 2),
(71, 'EF', NULL, '00000000007', NULL, NULL, 'emailOrientador71@email.com', 'Aluno71', NULL, 'Orientador71', 'T71', 1, 2),
(72, 'EF', NULL, '00000000007', NULL, NULL, 'emailOrientador72@email.com', 'Aluno72', NULL, 'Orientador72', 'T72', 5, 2),
(73, 'EF', NULL, '00000000007', NULL, NULL, 'emailOrientador73@email.com', 'Aluno73', NULL, 'Orientador73', 'T73', 5, 2),
(74, 'EF', NULL, '00000000007', NULL, NULL, 'emailOrientador74@email.com', 'Aluno74', NULL, 'Orientador74', 'T74', 5, 2),
(75, 'EF', NULL, '00000000007', NULL, NULL, 'emailOrientador75@email.com', 'Aluno75', NULL, 'Orientador75', 'T75', 1, 2),
(76, 'EF', NULL, '00000000007', NULL, NULL, 'emailOrientador76@email.com', 'Aluno76', NULL, 'Orientador76', 'T76', 3, 2),
(77, 'EF', NULL, '00000000007', NULL, NULL, 'emailOrientador77@email.com', 'Aluno77', NULL, 'Orientador77', 'T77', 2, 2),
(78, 'EF', NULL, '00000000007', NULL, NULL, 'emailOrientador78@email.com', 'Aluno78', NULL, 'Orientador78', 'T78', 5, 2),
(79, 'EF', NULL, '93794114485', NULL, NULL, 'emailOrientador79@email.com', 'Aluno79', NULL, 'Orientador79', 'T79', 1, 2),
(80, 'EF', NULL, '00000000008', NULL, NULL, 'emailOrientador80@email.com', 'Aluno80', NULL, 'Orientador80', 'T80', 2, 2),
(81, 'EF', NULL, '00000000008', NULL, NULL, 'emailOrientador81@email.com', 'Aluno81', NULL, 'Orientador81', 'T81', 4, 2),
(82, 'EF', NULL, '00000000008', NULL, NULL, 'emailOrientador82@email.com', 'Aluno82', NULL, 'Orientador82', 'T82', 2, 2),
(83, 'EF', NULL, '00000000008', NULL, NULL, 'emailOrientador83@email.com', 'Aluno83', NULL, 'Orientador83', 'T83', 5, 2),
(84, 'EF', NULL, '00000000008', NULL, NULL, 'emailOrientador84@email.com', 'Aluno84', NULL, 'Orientador84', 'T84', 2, 2),
(85, 'EF', NULL, '00000000008', NULL, NULL, 'emailOrientador85@email.com', 'Aluno85', NULL, 'Orientador85', 'T85', 5, 2),
(86, 'EF', NULL, '00000000008', NULL, NULL, 'emailOrientador86@email.com', 'Aluno86', NULL, 'Orientador86', 'T86', 5, 2),
(87, 'EF', NULL, '00000000008', NULL, NULL, 'emailOrientador87@email.com', 'Aluno87', NULL, 'Orientador87', 'T87', 3, 2),
(88, 'EF', NULL, '00000000008', NULL, NULL, 'emailOrientador88@email.com', 'Aluno88', NULL, 'Orientador88', 'T88', 2, 2),
(89, 'EF', NULL, '00000000008', NULL, NULL, 'emailOrientador89@email.com', 'Aluno89', NULL, 'Orientador89', 'T89', 2, 2);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices de tabela `area_de_conhecimento`
--
ALTER TABLE `area_de_conhecimento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices de tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD PRIMARY KEY (`id`,`id_avaliador`,`id_trabalho`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_avaliador` (`id_avaliador`),
  ADD KEY `id_trabalho` (`id_trabalho`),
  ADD KEY `id_questao` (`id_questao`);

--
-- Índices de tabela `avaliador`
--
ALTER TABLE `avaliador`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices de tabela `avaliador_area_de_conhecimento`
--
ALTER TABLE `avaliador_area_de_conhecimento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_area_de_conhecimento` (`id_area_de_conhecimento`),
  ADD KEY `id_avaliador` (`id_avaliador`);

--
-- Índices de tabela `questao`
--
ALTER TABLE `questao`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_tipo_de_pesquisa` (`id_tipo_de_pesquisa`);

--
-- Índices de tabela `tipo_de_pesquisa`
--
ALTER TABLE `tipo_de_pesquisa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices de tabela `trabalho`
--
ALTER TABLE `trabalho`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_area_de_conhecimento` (`id_area_de_conhecimento`),
  ADD KEY `id_tipo_de_pesquisa` (`id_tipo_de_pesquisa`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `area_de_conhecimento`
--
ALTER TABLE `area_de_conhecimento`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `avaliador`
--
ALTER TABLE `avaliador`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT de tabela `avaliador_area_de_conhecimento`
--
ALTER TABLE `avaliador_area_de_conhecimento`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT de tabela `questao`
--
ALTER TABLE `questao`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `tipo_de_pesquisa`
--
ALTER TABLE `tipo_de_pesquisa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `trabalho`
--
ALTER TABLE `trabalho`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD CONSTRAINT `avaliacao_ibfk_1` FOREIGN KEY (`id_avaliador`) REFERENCES `avaliador` (`id`),
  ADD CONSTRAINT `avaliacao_ibfk_2` FOREIGN KEY (`id_trabalho`) REFERENCES `trabalho` (`id`),
  ADD CONSTRAINT `avaliacao_ibfk_3` FOREIGN KEY (`id_questao`) REFERENCES `questao` (`id`);

--
-- Restrições para tabelas `avaliador_area_de_conhecimento`
--
ALTER TABLE `avaliador_area_de_conhecimento`
  ADD CONSTRAINT `avaliador_area_de_conhecimento_ibfk_1` FOREIGN KEY (`id_area_de_conhecimento`) REFERENCES `area_de_conhecimento` (`id`),
  ADD CONSTRAINT `avaliador_area_de_conhecimento_ibfk_2` FOREIGN KEY (`id_avaliador`) REFERENCES `avaliador` (`id`);

--
-- Restrições para tabelas `questao`
--
ALTER TABLE `questao`
  ADD CONSTRAINT `questao_ibfk_1` FOREIGN KEY (`id_tipo_de_pesquisa`) REFERENCES `tipo_de_pesquisa` (`id`);

--
-- Restrições para tabelas `trabalho`
--
ALTER TABLE `trabalho`
  ADD CONSTRAINT `trabalho_ibfk_1` FOREIGN KEY (`id_area_de_conhecimento`) REFERENCES `area_de_conhecimento` (`id`),
  ADD CONSTRAINT `trabalho_ibfk_2` FOREIGN KEY (`id_tipo_de_pesquisa`) REFERENCES `tipo_de_pesquisa` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
