-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 12, 2025 alle 15:38
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wallpapers`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

CREATE TABLE `categoria` (
  `nome` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `categoria`
--

INSERT INTO `categoria` (`nome`) VALUES
('Linux'),
('Mac'),
('Mobile'),
('Template'),
('VM'),
('Windows');

-- --------------------------------------------------------

--
-- Struttura della tabella `downloads`
--

CREATE TABLE `downloads` (
  `id` int(10) NOT NULL,
  `fk_utente` varchar(30) NOT NULL,
  `fk_idFoto` int(11) NOT NULL,
  `data_ora` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `downloads`
--

INSERT INTO `downloads` (`id`, `fk_utente`, `fk_idFoto`, `data_ora`) VALUES
(1, 'Kilian', 3, '2025-11-21'),
(2, 'Kilian', 4, '2025-11-28'),
(3, 'Kilian', 4, '2025-11-28'),
(4, 'Ciao', 2, '2025-11-28'),
(5, 'Ciao', 3, '2025-11-28'),
(6, 'Kilian', 100, '2025-12-05'),
(7, 'nical', 100, '2025-12-12');

-- --------------------------------------------------------

--
-- Struttura della tabella `foto`
--

CREATE TABLE `foto` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `nome_file` varchar(50) NOT NULL,
  `nome_autore` varchar(30) NOT NULL,
  `nome_categoria` varchar(40) NOT NULL,
  `nome_tag` varchar(20) NOT NULL,
  `larghezza` int(5) NOT NULL,
  `altezza` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `foto`
--

INSERT INTO `foto` (`id`, `nome`, `nome_file`, `nome_autore`, `nome_categoria`, `nome_tag`, `larghezza`, `altezza`) VALUES
(100, 'volpe', 'volpe.png', 'Kilian', 'Linux', 'Animali', 1400, 695),
(101, 'Lugano buia', 'lugano_buia.jpg', 'Test1', 'Windows', 'Città', 1920, 1080),
(102, 'Template VM Valsangiacomo', 'templateVM_Valsa2.jpg', 'Test2', 'VM', 'Tecnologia', 2560, 1600),
(103, 'Spazio Profondo', 'cool_space.jpg', 'Kilian', 'Windows', 'Spazio', 1920, 1079),
(104, 'Sfondo x telefono con Giaguaro', 'giaguaro.jpg', 'Test1', 'Mobile', 'Animali', 642, 1243),
(105, 'Sfondo minimal con foresta', 'minimalist_forest.jpg', 'Test1', 'Mac', 'Minimalistico', 1920, 1200),
(106, 'Minimal black wallpaper', 'minimalist2.jpg', 'Kilian', 'Linux', 'Minimalistico', 1920, 1080),
(107, 'Sfondo montagne e cielo blu', 'mountain_blue_sky.jpg', 'Test2', 'Mobile', 'Natura', 1290, 2093),
(108, 'Notte Stellata', 'notte_stellata.jpg', 'Kilian', 'Mac', 'Artistico', 1920, 1200),
(109, 'Tecnologia', 'tech.jpg', 'WallPaper_Admin', 'VM', 'Tecnologia', 450, 252),
(110, 'Tecnologia numero 2 con dati', 'tech2.jpg', 'Test1', 'Template', 'Tecnologia', 2250, 1450),
(111, 'Spazio Profondo v2', 'spazio_profondo.jpg', 'Kilian', 'Mac', 'Spazio', 1049, 699),
(112, 'Immagine di test 1', 'test.png', 'Kilian', 'Windows', 'Tecnologia', 1024, 576),
(113, 'Immagine di test 2', 'test2.png', 'Kilian', 'Windows', 'Tecnologia', 1024, 576),
(114, 'Sfondo', 'bg.jpeg', 'Kilian', 'Linux', 'Artistico', 1920, 1080),
(124, 'aaaaaa', 'Tst1KilianRighetti.zip', 'Kilian', 'Linux', 'AI', 0, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `tag`
--

CREATE TABLE `tag` (
  `nome` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tag`
--

INSERT INTO `tag` (`nome`) VALUES
('AI'),
('Animali'),
('Artistico'),
('Città'),
('Minimalistico'),
('Natura'),
('Pattern'),
('Spazio'),
('Tecnologia');

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `nome_utente` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`nome_utente`, `password`) VALUES
('Ciao', 'A'),
('Kilian', '123'),
('nical', 'Nical081!'),
('Test1', 'password2'),
('Test2', 'password3'),
('WallPaper_Admin', 'P@$$w0rd_ADMIN');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`nome`);

--
-- Indici per le tabelle `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_utente` (`fk_utente`),
  ADD KEY `fk_foto` (`fk_idFoto`);

--
-- Indici per le tabelle `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`),
  ADD KEY `fk_nome_autore` (`nome_autore`),
  ADD KEY `fk_nome_categoria` (`nome_categoria`),
  ADD KEY `fk_nome_tag` (`nome_tag`);

--
-- Indici per le tabelle `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`nome`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`nome_utente`) USING BTREE;

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `downloads`
--
ALTER TABLE `downloads`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `foto`
--
ALTER TABLE `foto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `downloads`
--
ALTER TABLE `downloads`
  ADD CONSTRAINT `fk_utente` FOREIGN KEY (`fk_utente`) REFERENCES `utente` (`nome_utente`);

--
-- Limiti per la tabella `foto`
--
ALTER TABLE `foto`
  ADD CONSTRAINT `fk_nome_autore` FOREIGN KEY (`nome_autore`) REFERENCES `utente` (`nome_utente`),
  ADD CONSTRAINT `fk_nome_categoria` FOREIGN KEY (`nome_categoria`) REFERENCES `categoria` (`nome`),
  ADD CONSTRAINT `fk_nome_tag` FOREIGN KEY (`nome_tag`) REFERENCES `tag` (`nome`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
