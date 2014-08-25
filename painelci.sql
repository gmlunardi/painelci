-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 26-Ago-2014 às 01:48
-- Versão do servidor: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `painelci`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `auditoria`
--

CREATE TABLE IF NOT EXISTS `auditoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(45) NOT NULL,
  `data_hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `operacao` varchar(45) NOT NULL,
  `query` text NOT NULL,
  `observacao` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Extraindo dados da tabela `auditoria`
--

INSERT INTO `auditoria` (`id`, `usuario`, `data_hora`, `operacao`, `query`, `observacao`) VALUES
(1, 'glunardi', '2014-08-25 16:12:58', 'Logout no sistema', '0', 'Logout efetuado com sucesso'),
(2, 'glunardi', '2014-08-25 16:13:01', 'Login no sistema', 'SELECT *\nFROM (`usuarios`)\nWHERE `login` =  ''glunardi''\nLIMIT 1', 'Login efetuado com sucesso'),
(3, 'glunardi', '2014-08-25 16:13:11', 'Logout no sistema', '0', 'Logout efetuado com sucesso'),
(4, 'paula', '2014-08-25 16:13:24', 'Login no sistema', 'SELECT *\nFROM (`usuarios`)\nWHERE `login` =  ''paula''\nLIMIT 1', 'Login efetuado com sucesso'),
(5, 'paula', '2014-08-25 16:13:46', 'Logout no sistema', '0', 'Logout efetuado com sucesso'),
(6, 'paula', '2014-08-25 16:13:53', 'Login no sistema', 'SELECT *\nFROM (`usuarios`)\nWHERE `login` =  ''paula''\nLIMIT 1', 'Login efetuado com sucesso'),
(7, 'paula', '2014-08-25 16:14:04', 'Logout no sistema', '0', 'Logout efetuado com sucesso'),
(8, 'pietro', '2014-08-25 16:14:51', 'Login no sistema', 'SELECT *\nFROM (`usuarios`)\nWHERE `login` =  ''pietro''\nLIMIT 1', 'Login efetuado com sucesso'),
(9, 'pietro', '2014-08-25 16:15:02', 'Logout no sistema', '0', 'Logout efetuado com sucesso'),
(10, 'paula', '2014-08-25 16:16:05', 'Login no sistema', 'SELECT *\nFROM (`usuarios`)\nWHERE `login` =  ''paula''\nLIMIT 1', 'Login efetuado com sucesso'),
(11, 'paula', '2014-08-25 16:16:12', 'Logout no sistema', '0', 'Logout efetuado com sucesso'),
(12, 'elisiane', '2014-08-25 16:16:20', 'Login no sistema', 'SELECT *\nFROM (`usuarios`)\nWHERE `login` =  ''elisiane''\nLIMIT 1', 'Login efetuado com sucesso'),
(13, 'elisiane', '2014-08-25 16:16:28', 'Logout no sistema', '0', 'Logout efetuado com sucesso'),
(14, 'glunardi', '2014-08-25 16:27:17', 'Login no sistema', 'SELECT *\nFROM (`usuarios`)\nWHERE `login` =  ''glunardi''\nLIMIT 1', 'Login efetuado com sucesso'),
(15, 'glunardi', '2014-08-25 17:12:29', 'Logout no sistema', '0', 'Logout efetuado com sucesso'),
(16, 'glunardi', '2014-08-25 17:12:31', 'Login no sistema', 'SELECT *\nFROM (`usuarios`)\nWHERE `login` =  ''glunardi''\nLIMIT 1', 'Login efetuado com sucesso'),
(17, 'glunardi', '2014-08-25 20:28:38', 'Login no sistema', 'SELECT *\nFROM (`usuarios`)\nWHERE `login` =  ''glunardi''\nLIMIT 1', 'Login efetuado com sucesso'),
(18, 'glunardi', '2014-08-25 20:40:38', 'Logout no sistema', '0', 'Logout efetuado com sucesso'),
(19, 'glunardi', '2014-08-25 20:40:42', 'Login no sistema', 'SELECT *\nFROM (`usuarios`)\nWHERE `login` =  ''glunardi''\nLIMIT 1', 'Login efetuado com sucesso'),
(20, 'glunardi', '2014-08-25 21:05:55', 'Logout no sistema', '0', 'Logout efetuado com sucesso'),
(21, 'glunardi', '2014-08-25 21:06:00', 'Login no sistema', 'SELECT *\nFROM (`usuarios`)\nWHERE `login` =  ''glunardi''\nLIMIT 1', 'Login efetuado com sucesso'),
(22, 'glunardi', '2014-08-25 23:46:13', 'Logout no sistema', '0', 'Logout efetuado com sucesso'),
(23, 'glunardi', '2014-08-25 23:46:17', 'Login no sistema', 'SELECT *\nFROM (`usuarios`)\nWHERE `login` =  ''glunardi''\nLIMIT 1', 'Login efetuado com sucesso'),
(24, 'glunardi', '2014-08-25 23:46:41', 'Logout no sistema', '0', 'Logout efetuado com sucesso'),
(25, 'kiko', '2014-08-25 23:46:49', 'Login no sistema', 'SELECT *\nFROM (`usuarios`)\nWHERE `login` =  ''kiko''\nLIMIT 1', 'Login efetuado com sucesso'),
(26, 'kiko', '2014-08-25 23:46:54', 'Logout no sistema', '0', 'Logout efetuado com sucesso');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `login` varchar(45) NOT NULL,
  `senha` varchar(32) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `adm` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `login`, `senha`, `ativo`, `adm`) VALUES
(1, 'Gabriel Machado Lunardi', 'gmlunardi@gmail.com', 'glunardi', '81dc9bdb52d04dc20036dbd8313ed055', 1, 1),
(3, 'Paula Donaduzzi Rigo', 'paula@gmail.com', 'paula', '81dc9bdb52d04dc20036dbd8313ed055', 1, 0),
(6, 'Elisiane Machado Lunardi', 'elisiane.lunardi@gmail.com', 'elisiane', '81dc9bdb52d04dc20036dbd8313ed055', 1, 0),
(10, 'Davi Teixeira Machado', 'davi@mail.com', 'davi', '81dc9bdb52d04dc20036dbd8313ed055', 1, 0),
(14, 'Kiko Machado Lunardi', 'kiko@mail.com', 'kiko', '81dc9bdb52d04dc20036dbd8313ed055', 1, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
