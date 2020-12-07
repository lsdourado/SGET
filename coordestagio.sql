-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 26-Out-2018 às 15:58
-- Versão do servidor: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coordestagio`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `acesso`
--

CREATE TABLE `acesso` (
  `id` int(11) NOT NULL,
  `tipo` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `acesso`
--

INSERT INTO `acesso` (`id`, `tipo`, `login`, `senha`) VALUES
(1, 'coordenador', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
--

CREATE TABLE `aluno` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `id_curso` int(11) NOT NULL,
  `periodo` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `matricula` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `data_nascimento` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `rg` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `cpf` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `sexo` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `telefone` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `por_deficiencia` tinyint(1) NOT NULL,
  `id_endereco` int(11) NOT NULL,
  `id_acesso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacao_empresa`
--

CREATE TABLE `avaliacao_empresa` (
  `id` int(11) NOT NULL,
  `id_estagio` int(11) NOT NULL,
  `encerrado` tinyint(1) DEFAULT NULL,
  `av_profissional_1` float DEFAULT NULL,
  `av_profissional_2` float DEFAULT NULL,
  `av_profissional_3` float DEFAULT NULL,
  `av_profissional_4` float DEFAULT NULL,
  `av_profissional_5` float DEFAULT NULL,
  `nota_profissional` float DEFAULT NULL,
  `av_humano_1` float DEFAULT NULL,
  `av_humano_2` float DEFAULT NULL,
  `av_humano_3` float DEFAULT NULL,
  `av_humano_4` float DEFAULT NULL,
  `av_humano_5` float DEFAULT NULL,
  `nota_humano` float DEFAULT NULL,
  `nota_final` float DEFAULT NULL,
  `observacao` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacao_entrevista`
--

CREATE TABLE `avaliacao_entrevista` (
  `id` int(11) NOT NULL,
  `id_estagio` int(11) NOT NULL,
  `encerrado` tinyint(1) DEFAULT NULL,
  `av_criterio_1` float DEFAULT NULL,
  `av_criterio_2` float DEFAULT NULL,
  `av_criterio_3` float DEFAULT NULL,
  `av_criterio_4` float DEFAULT NULL,
  `av_criterio_5` float DEFAULT NULL,
  `nota` float DEFAULT NULL,
  `observacao` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `boletim`
--

CREATE TABLE `boletim` (
  `id` int(11) NOT NULL,
  `id_estagio` int(11) NOT NULL,
  `encerrado` tinyint(1) DEFAULT NULL,
  `id_entrevista_1` int(11) DEFAULT NULL,
  `id_entrevista_2` int(11) DEFAULT NULL,
  `id_av_empresa` int(11) DEFAULT NULL,
  `situacao` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nota_relatorio` float DEFAULT NULL,
  `nota_orientacao` float DEFAULT NULL,
  `nota_empresa` float DEFAULT NULL,
  `nota_final` float DEFAULT NULL,
  `observacao` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `coordenador`
--

CREATE TABLE `coordenador` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso`
--

CREATE TABLE `curso` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `empresa`
--

CREATE TABLE `empresa` (
  `id` int(11) NOT NULL,
  `razao_social` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nome_fantasia` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tipo_empregador` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `cnpj` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `representante_legal` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `telefone` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `id_endereco` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `endereco`
--

CREATE TABLE `endereco` (
  `id` int(11) NOT NULL,
  `cidade` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `rua` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `bairro` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `numero` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `cep` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `entrevista_final`
--

CREATE TABLE `entrevista_final` (
  `id` int(11) NOT NULL,
  `id_estagio` int(11) NOT NULL,
  `av_estagio_1` int(11) DEFAULT NULL,
  `av_estagio_2` int(11) DEFAULT NULL,
  `av_estagio_3` int(11) DEFAULT NULL,
  `av_estagio_4` int(11) DEFAULT NULL,
  `av_estagio_5` int(11) DEFAULT NULL,
  `av_empresa_1` int(11) DEFAULT NULL,
  `av_empresa_2` int(11) DEFAULT NULL,
  `av_empresa_3` int(11) DEFAULT NULL,
  `av_empresa_4` int(11) DEFAULT NULL,
  `av_empresa_5` int(11) DEFAULT NULL,
  `coment` text COLLATE utf8_unicode_ci,
  `encerrado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estagio`
--

CREATE TABLE `estagio` (
  `id` int(11) NOT NULL,
  `id_aluno` int(11) NOT NULL,
  `id_professor` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_supervisor` int(11) NOT NULL,
  `obrigatorio` tinyint(1) NOT NULL,
  `data_inicio` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `data_fim` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `carga_semanal` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `horario_inicio` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `horario_fim` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `apolice_seguro` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nome_seguradora` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `valor_seguro` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `bolsa_auxilio` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `auxilio_transporte` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `instituicao`
--

CREATE TABLE `instituicao` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cnpj` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `telefone` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `diretor` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `portaria` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `id_endereco` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `plano_trabalho`
--

CREATE TABLE `plano_trabalho` (
  `id` int(11) NOT NULL,
  `id_estagio` int(11) NOT NULL,
  `encerrado` tinyint(1) DEFAULT NULL,
  `objetivo` text COLLATE utf8_unicode_ci,
  `atividade` text COLLATE utf8_unicode_ci,
  `crono_entrevista` text COLLATE utf8_unicode_ci,
  `instrumento_av` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `primeira_entrevista`
--

CREATE TABLE `primeira_entrevista` (
  `id` int(11) NOT NULL,
  `id_estagio` int(11) NOT NULL,
  `id_av_entrevista` int(11) DEFAULT NULL,
  `encerrado` tinyint(1) DEFAULT NULL,
  `atv_desenvolvida` text COLLATE utf8_unicode_ci,
  `treinamento` tinyint(1) DEFAULT NULL,
  `desc_treinamento` text COLLATE utf8_unicode_ci,
  `adaptacao` text COLLATE utf8_unicode_ci,
  `acompanhamento_emp` text COLLATE utf8_unicode_ci,
  `exec_trabalhos` text COLLATE utf8_unicode_ci,
  `coment_aluno` text COLLATE utf8_unicode_ci,
  `coment_professor` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `professor`
--

CREATE TABLE `professor` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `siape` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `data_nascimento` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `sexo` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `telefone` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `id_endereco` int(11) NOT NULL,
  `id_acesso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `relatorio_final`
--

CREATE TABLE `relatorio_final` (
  `id` int(11) NOT NULL,
  `id_estagio` int(11) NOT NULL,
  `encerrado` tinyint(1) DEFAULT NULL,
  `desc_empresa` text COLLATE utf8_unicode_ci,
  `desc_atividade` text COLLATE utf8_unicode_ci,
  `conclusao` text COLLATE utf8_unicode_ci,
  `nota` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `segunda_entrevista`
--

CREATE TABLE `segunda_entrevista` (
  `id` int(11) NOT NULL,
  `id_estagio` int(11) NOT NULL,
  `id_av_entrevista` int(11) DEFAULT NULL,
  `encerrado` tinyint(1) DEFAULT NULL,
  `atv_desenvolvida` text COLLATE utf8_unicode_ci,
  `desc_treinamento` text COLLATE utf8_unicode_ci,
  `treinamento` tinyint(1) DEFAULT NULL,
  `desc_dificuldade_ant` text COLLATE utf8_unicode_ci,
  `dif_superada` tinyint(1) DEFAULT NULL,
  `desc_nova_dificuldade` text COLLATE utf8_unicode_ci,
  `nova_dificuldade` tinyint(1) DEFAULT NULL,
  `desc_acompanhamento` text COLLATE utf8_unicode_ci,
  `acomp_mantido` tinyint(1) DEFAULT NULL,
  `desc_relacao` text COLLATE utf8_unicode_ci,
  `coment_aluno` text COLLATE utf8_unicode_ci,
  `coment_professor` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `supervisor`
--

CREATE TABLE `supervisor` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `num_reg_prof` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `orgao_emissor` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `cargo` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `formacao` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `token_acesso` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `byPass_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acesso`
--
ALTER TABLE `acesso`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `avaliacao_empresa`
--
ALTER TABLE `avaliacao_empresa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `avaliacao_entrevista`
--
ALTER TABLE `avaliacao_entrevista`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `boletim`
--
ALTER TABLE `boletim`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coordenador`
--
ALTER TABLE `coordenador`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `entrevista_final`
--
ALTER TABLE `entrevista_final`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estagio`
--
ALTER TABLE `estagio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instituicao`
--
ALTER TABLE `instituicao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plano_trabalho`
--
ALTER TABLE `plano_trabalho`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `primeira_entrevista`
--
ALTER TABLE `primeira_entrevista`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `relatorio_final`
--
ALTER TABLE `relatorio_final`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `segunda_entrevista`
--
ALTER TABLE `segunda_entrevista`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supervisor`
--
ALTER TABLE `supervisor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acesso`
--
ALTER TABLE `acesso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `aluno`
--
ALTER TABLE `aluno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `avaliacao_empresa`
--
ALTER TABLE `avaliacao_empresa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `avaliacao_entrevista`
--
ALTER TABLE `avaliacao_entrevista`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `boletim`
--
ALTER TABLE `boletim`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coordenador`
--
ALTER TABLE `coordenador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `curso`
--
ALTER TABLE `curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `endereco`
--
ALTER TABLE `endereco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entrevista_final`
--
ALTER TABLE `entrevista_final`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estagio`
--
ALTER TABLE `estagio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instituicao`
--
ALTER TABLE `instituicao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plano_trabalho`
--
ALTER TABLE `plano_trabalho`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `primeira_entrevista`
--
ALTER TABLE `primeira_entrevista`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `professor`
--
ALTER TABLE `professor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `relatorio_final`
--
ALTER TABLE `relatorio_final`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `segunda_entrevista`
--
ALTER TABLE `segunda_entrevista`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supervisor`
--
ALTER TABLE `supervisor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
