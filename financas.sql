-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 26/07/2017 às 18:57
-- Versão do servidor: 10.1.19-MariaDB
-- Versão do PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `financas`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `Contas`
--

CREATE TABLE `Contas` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `descricao` varchar(255) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_vencimento` date DEFAULT NULL,
  `data_referencia` date DEFAULT NULL,
  `tipo` tinyint(4) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Lancamentos`
--

CREATE TABLE `Lancamentos` (
  `id` int(11) NOT NULL,
  `conta_id` int(11) DEFAULT NULL,
  `tipo_lancamento` tinyint(4) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `data` date DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gatilhos `Lancamentos`
--
DELIMITER $$
CREATE TRIGGER `updateSaldo` AFTER INSERT ON `Lancamentos` FOR EACH ROW BEGIN
    UPDATE Contas
    SET valor = (NEW.valor * NEW.tipo_lancamento) + Contas.valor
    WHERE Contas.id = NEW.conta_id;
  END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updateSaldoDelete` AFTER DELETE ON `Lancamentos` FOR EACH ROW BEGIN
    UPDATE Contas
    SET valor = (OLD.valor * OLD.tipo_lancamento) - Contas.valor
    WHERE Contas.id = OLD.conta_id;
  END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `Contas`
--
ALTER TABLE `Contas`
  ADD UNIQUE KEY `Contas_id_uindex` (`id`),
  ADD KEY `Contas_Users_id_fk` (`user_id`);

--
-- Índices de tabela `Lancamentos`
--
ALTER TABLE `Lancamentos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Lancamentos_id_uindex` (`id`),
  ADD KEY `Lancamentos_Contas_id_fk` (`conta_id`);

--
-- Índices de tabela `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `Contas`
--
ALTER TABLE `Contas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18721;
--
-- AUTO_INCREMENT de tabela `Lancamentos`
--
ALTER TABLE `Lancamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de tabela `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `Contas`
--
ALTER TABLE `Contas`
  ADD CONSTRAINT `Contas_Users_id_fk` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`);

--
-- Restrições para tabelas `Lancamentos`
--
ALTER TABLE `Lancamentos`
  ADD CONSTRAINT `Lancamentos_Contas_id_fk` FOREIGN KEY (`conta_id`) REFERENCES `Contas` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
