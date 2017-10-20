-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 20-Out-2017 às 16:36
-- Versão do servidor: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sitemonitoramento`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cargas`
--

CREATE TABLE `cargas` (
  `cod` int(11) NOT NULL,
  `placa_veiculo` varchar(10) NOT NULL,
  `cpf_motorista` varchar(12) NOT NULL,
  `destino` varchar(20) NOT NULL,
  `inicio` varchar(20) NOT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cargas`
--

INSERT INTO `cargas` (`cod`, `placa_veiculo`, `cpf_motorista`, `destino`, `inicio`, `status`) VALUES
(1, 'dfa-2662', '1234', '1', '2', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoriaocorrencias`
--

CREATE TABLE `categoriaocorrencias` (
  `cod` int(11) NOT NULL,
  `descricao` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categoriaocorrencias`
--

INSERT INTO `categoriaocorrencias` (`cod`, `descricao`) VALUES
(2, 'acidentes'),
(3, 'quebrou veiculo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoriasveiculo`
--

CREATE TABLE `categoriasveiculo` (
  `cod` int(11) NOT NULL,
  `descricao` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categoriasveiculo`
--

INSERT INTO `categoriasveiculo` (`cod`, `descricao`) VALUES
(4, 'romeu e julieta'),
(3, 'truck');

-- --------------------------------------------------------

--
-- Estrutura da tabela `empresas`
--

CREATE TABLE `empresas` (
  `cnpj` varchar(20) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `seguimento` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `empresas`
--

INSERT INTO `empresas` (`cnpj`, `nome`, `seguimento`) VALUES
('3333', 'syngenta', 1),
('54543', 'citrosuco', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `enderecos`
--

CREATE TABLE `enderecos` (
  `rua` varchar(100) NOT NULL,
  `numero` varchar(8) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `cep` varchar(100) NOT NULL,
  `entidade` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `motoristas`
--

CREATE TABLE `motoristas` (
  `cpf` varchar(20) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `agregado` int(11) DEFAULT NULL,
  `moip` int(11) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `vencimento_cnh` varchar(12) NOT NULL,
  `numregistro_cnh` varchar(40) NOT NULL,
  `categoria_cnh` varchar(4) NOT NULL,
  `fone1` varchar(20) NOT NULL,
  `fone2` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `motoristas`
--

INSERT INTO `motoristas` (`cpf`, `nome`, `agregado`, `moip`, `email`, `vencimento_cnh`, `numregistro_cnh`, `categoria_cnh`, `fone1`, `fone2`) VALUES
('1234', 'joao melao', 1, 0, 'joao@joao.com', '', '', '', '', ''),
('2132', 'mary', 1, 1, 'mari@mari.com', '', '', '', '', ''),
('45678', 'mimoza', 1, 1, 'email@email.com', '', '', '', '', ''),
('545433', 'rambo', 1, 1, 'email@email.com', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ocorrencias`
--

CREATE TABLE `ocorrencias` (
  `cod` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `relatorio` longtext,
  `date_time` varchar(18) DEFAULT NULL,
  `carga` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `ocorrencias`
--

INSERT INTO `ocorrencias` (`cod`, `tipo`, `relatorio`, `date_time`, `carga`) VALUES
(1, 1, 'guariba sÃ£o paulo', '20/10/2017 01:56', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `seguimentoempresa`
--

CREATE TABLE `seguimentoempresa` (
  `cod` int(11) NOT NULL,
  `descricao` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `seguimentoempresa`
--

INSERT INTO `seguimentoempresa` (`cod`, `descricao`) VALUES
(1, 'milho'),
(2, 'laranja');

-- --------------------------------------------------------

--
-- Estrutura da tabela `telefones`
--

CREATE TABLE `telefones` (
  `cod` int(11) NOT NULL,
  `numero` varchar(50) NOT NULL,
  `entidade` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `veiculos`
--

CREATE TABLE `veiculos` (
  `placa` varchar(10) NOT NULL,
  `chassi` varchar(40) NOT NULL,
  `categoria` int(11) DEFAULT NULL,
  `tara` varchar(20) DEFAULT NULL,
  `anofabricacao` varchar(20) DEFAULT NULL,
  `anomodelo` varchar(20) DEFAULT NULL,
  `meslicenciamento` varchar(20) DEFAULT NULL,
  `statuslicenciamento` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `veiculos`
--

INSERT INTO `veiculos` (`placa`, `chassi`, `categoria`, `tara`, `anofabricacao`, `anomodelo`, `meslicenciamento`, `statuslicenciamento`) VALUES
('dfa-2662', '5435 4b435345hytht', 5, '13900', '1999', '2000', '8', 1),
('abcd-2321', '5435 4sjtjtyj45hytht', 4, '13501', '1999', '2000', '8', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cargas`
--
ALTER TABLE `cargas`
  ADD PRIMARY KEY (`cod`),
  ADD KEY `fk_carga_moto` (`cpf_motorista`);

--
-- Indexes for table `categoriaocorrencias`
--
ALTER TABLE `categoriaocorrencias`
  ADD PRIMARY KEY (`cod`);

--
-- Indexes for table `categoriasveiculo`
--
ALTER TABLE `categoriasveiculo`
  ADD PRIMARY KEY (`cod`);

--
-- Indexes for table `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`cnpj`),
  ADD KEY `fk_segui` (`seguimento`);

--
-- Indexes for table `motoristas`
--
ALTER TABLE `motoristas`
  ADD PRIMARY KEY (`cpf`);

--
-- Indexes for table `ocorrencias`
--
ALTER TABLE `ocorrencias`
  ADD PRIMARY KEY (`cod`),
  ADD KEY `fk_ocor_carg` (`carga`);

--
-- Indexes for table `seguimentoempresa`
--
ALTER TABLE `seguimentoempresa`
  ADD PRIMARY KEY (`cod`);

--
-- Indexes for table `telefones`
--
ALTER TABLE `telefones`
  ADD PRIMARY KEY (`cod`);

--
-- Indexes for table `veiculos`
--
ALTER TABLE `veiculos`
  ADD PRIMARY KEY (`placa`),
  ADD KEY `fk_veicu_cate` (`categoria`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cargas`
--
ALTER TABLE `cargas`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `categoriaocorrencias`
--
ALTER TABLE `categoriaocorrencias`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `categoriasveiculo`
--
ALTER TABLE `categoriasveiculo`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ocorrencias`
--
ALTER TABLE `ocorrencias`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `seguimentoempresa`
--
ALTER TABLE `seguimentoempresa`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
