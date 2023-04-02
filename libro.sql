-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 02, 2023 alle 18:09
-- Versione del server: 10.4.27-MariaDB
-- Versione PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `libreria`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `libro`
--

CREATE TABLE `libro` (
  `ISBN` varchar(13) NOT NULL,
  `autore` varchar(50) NOT NULL,
  `titolo` varchar(50) NOT NULL,
  `trama` varchar(50) NOT NULL,
  `numero_letture` int(10) NOT NULL,
  `Data_aggiunta` date NOT NULL,
  `Data_eliminazione` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `libro`
--

INSERT INTO `libro` (`ISBN`, `autore`, `titolo`, `trama`, `numero_letture`, `Data_aggiunta`, `Data_eliminazione`) VALUES
('1234567891230', 'Tom Clancy\'s', 'Sfida Totale', 'Trama di prova', 4, '2023-03-23', NULL),
('1928374659823', 'J. K. Rowling', 'Harry Potter il principe mezzosangue', 'Trama di prova 2', 20, '2023-03-27', NULL);

--
-- Trigger `libro`
--
DELIMITER $$
CREATE TRIGGER `Elimina_libro` BEFORE DELETE ON `libro` FOR EACH ROW INSERT INTO libro (ISBN,autore,titolo,trama,numero_letture,data_aggiunta,Data_eliminazione)
VALUES (old.ISBN,old.autore,old.titolo,old.trama,old.numero_letture,old.data_aggiunta,CURRENT_TIMESTAMP())
$$
DELIMITER ;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`ISBN`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
