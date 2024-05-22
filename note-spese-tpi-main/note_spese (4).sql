-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 04, 2024 alle 11:00
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `note_spese`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `descrizione`
--

CREATE TABLE `descrizione` (
  `id` int(11) NOT NULL,
  `descrizione` varchar(30) DEFAULT NULL,
  `sottocategoria` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `descrizione`
--

INSERT INTO `descrizione` (`id`, `descrizione`, `sottocategoria`) VALUES
(4, 'Trasporto', 'Treno');

-- --------------------------------------------------------

--
-- Struttura della tabella `nota`
--

CREATE TABLE `nota` (
  `id` int(11) NOT NULL,
  `fkUtente` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `costo` float DEFAULT NULL,
  `motivazione` varchar(20) DEFAULT NULL,
  `fkDescrizione` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `nota`
--

INSERT INTO `nota` (`id`, `fkUtente`, `data`, `costo`, `motivazione`, `fkDescrizione`) VALUES
(35, 2, '2024-04-25', 43, 'cacca', 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `id` int(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `pw` varchar(100) DEFAULT NULL,
  `nome` varchar(20) DEFAULT NULL,
  `cognome` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`id`, `email`, `pw`, `nome`, `cognome`) VALUES
(2, 'stefanopezzetta05@gmail.com', '$2y$10$B0YBV1kGvNqRwx0By17htuMFlE7PuOQ8bIFHns5/Xff.FmuTmg0ea', 'Stefano', 'Pezzetta'),
(5, 'cristianacavallini70@gmail.com', '$2y$10$pd75RKRyVLztnX5d285o0.7fpgCh.1.hA8TKPuMuKsFPeGFBVDIHa', 'Cristiana', 'Cavallini'),
(7, 'marianopezzetta@libero.it', '$2y$10$T04waG/VgSj2LghgrGb8uuaTzEiXwd8rWWN30KX1HkBqMTIDqbQLa', 'Mariano', 'Pezzetta'),
(8, 'riccardo05@gmail.com', '$2y$10$PdcA2kxhjdwh1bW8nw.A2OMv9UNp1uBfJs7BlL4WcYwkZErBe0QiC', 'ricks', 'rasors');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `descrizione`
--
ALTER TABLE `descrizione`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `nota`
--
ALTER TABLE `nota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkUtente` (`fkUtente`),
  ADD KEY `fkDescrizione` (`fkDescrizione`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `descrizione`
--
ALTER TABLE `descrizione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `nota`
--
ALTER TABLE `nota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `nota`
--
ALTER TABLE `nota`
  ADD CONSTRAINT `fkDescrizione` FOREIGN KEY (`fkDescrizione`) REFERENCES `descrizione` (`id`),
  ADD CONSTRAINT `nota_ibfk_1` FOREIGN KEY (`fkUtente`) REFERENCES `utente` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
