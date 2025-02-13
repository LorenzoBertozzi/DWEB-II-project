-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05-Fev-2025 às 12:06
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `delas`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cursos`
--

CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` text NOT NULL,
  `imagem` varchar(50) DEFAULT NULL,
  `link_pre_curso` varchar(255) DEFAULT NULL,
  `link_pos_curso` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cursos`
--

INSERT INTO `cursos` (`id`, `nome`, `descricao`, `imagem`, `link_pre_curso`, `link_pos_curso`) VALUES
(1, 'Curso de Interfaces Gráficas', 'Explore ferramentas de design e crie projetos incríveis.', 'curso1.png', NULL, NULL),
(2, 'Mecânica Descomplicada', 'Aprendas fundamentos de Mecânica para não ser enganada.', 'curso2.png', NULL, NULL),
(3, 'Curso Página Web utilizando Canva', 'Explore o Canva e crie projetos incríveis.', 'curso3.png', NULL, NULL),
(4, 'Curso Básico de Informática', 'A Tecnologia ao alcance de todos', 'curso6.png', NULL, NULL),
(5, 'Curso de Robótica', 'Minicurso de Robótica', 'curso4.png', NULL, NULL),
(6, 'Impressão 3D', 'Desvende os segredos da impressora 3D', 'curso5.png', NULL, NULL),
(17, 'teste testewrewerw', 'askdnalsdjasnldjafnlja', 'teste teste', 'adicionando link de teste', 'testando link pos curso');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cursos_realizados`
--

CREATE TABLE `cursos_realizados` (
  `id` int(11) NOT NULL,
  `usuarios_id` int(11) NOT NULL,
  `cursos_id` int(11) NOT NULL,
  `data_conclusao` date NOT NULL,
  `certificado` varchar(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cursos_realizados`
--

INSERT INTO `cursos_realizados` (`id`, `usuarios_id`, `cursos_id`, `data_conclusao`, `certificado`, `status`) VALUES
(1, 7, 4, '2025-01-02', NULL, 'Concluído'),
(3, 7, 2, '2025-01-02', NULL, 'Concluído'),
(4, 7, 6, '0000-00-00', NULL, 'Em Andamento'),
(6, 8, 6, '0000-00-00', NULL, 'Em Andamento'),
(7, 16, 1, '2025-01-01', NULL, 'Concluído'),
(8, 16, 4, '0000-00-00', NULL, 'Concluído');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(40) NOT NULL,
  `data` date DEFAULT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `contato` varchar(15) DEFAULT NULL,
  `perfil` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `data`, `cpf`, `contato`, `perfil`) VALUES
(7, 'marina', 'marina@marina', '4bf541f9d353914327dd963461e8677c', '2002-02-01', '1', '32', 'aluno'),
(8, 'Marcos', 'Marcos@gmail.com', 'c4c62424df7c11291eab30691047315d', '1990-01-16', '001002003', '3288877777', 'aluno'),
(9, 'Tamires', 'tamires@gmail.com', 'e926c25f6d1f25d4e4d7734deca675fd', '1990-03-10', '12345678', '329888888888', 'aluno'),
(10, 'carlos', 'carlos@gmail', '9ad48828b0955513f7cf0f7f6510c8f8', '2025-01-23', '123', '658', 'aluno'),
(11, 'bruna', 'bruna@gmail.com', '72e9dd3113d09603e90072db3efd6e20', '2025-01-31', '122', '856', 'aluno'),
(12, 'julio', 'julio@gmail.com', '62398fb63509f679f2128ea6a44a7f9a', '2025-01-23', '12545587', '125', 'aluno'),
(15, 'Lorenzo Jordani Bertozzi Luz', 'lorenzo@email.com', '81dc9bdb52d04dc20036dbd8313ed055', '2003-03-06', '11049021924', '6999608070', 'Administrador'),
(16, '1234', '1234', '81dc9bdb52d04dc20036dbd8313ed055', '4567-03-12', '1234', '1234', 'aluno'),
(17, '12345', '12345', '827ccb0eea8a706c4c34a16891f84e7b', '4567-03-12', '12345', '12345', 'aluno');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `cursos_realizados`
--
ALTER TABLE `cursos_realizados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuarios_id` (`usuarios_id`),
  ADD KEY `cursos_id` (`cursos_id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `cursos_realizados`
--
ALTER TABLE `cursos_realizados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `cursos_realizados`
--
ALTER TABLE `cursos_realizados`
  ADD CONSTRAINT `cursos_realizados_ibfk_1` FOREIGN KEY (`cursos_id`) REFERENCES `cursos` (`id`),
  ADD CONSTRAINT `cursos_realizados_ibfk_2` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
