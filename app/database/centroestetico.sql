-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 30, 2021 alle 22:41
-- Versione del server: 5.7.17
-- Versione PHP: 7.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `centroestetico`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `account`
--

CREATE TABLE `account` (
  `nome` char(30) DEFAULT NULL,
  `cognome` char(30) DEFAULT NULL,
  `citta` char(30) DEFAULT NULL,
  `CAP` int(11) DEFAULT NULL,
  `via` char(30) DEFAULT NULL,
  `numeroCivico` int(11) DEFAULT NULL,
  `ruolo` char(20) DEFAULT NULL,
  `email` char(40) NOT NULL,
  `password` char(255) DEFAULT NULL,
  `salt` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dump dei dati per la tabella `account`
--

INSERT INTO `account` (`nome`, `cognome`, `citta`, `CAP`, `via`, `numeroCivico`, `ruolo`, `email`, `password`, `salt`) VALUES
('admin', 'test', 'Merate', 11111, 'admin', 1, 'admin', 'admin@test.com', 'b43fe7a5dc5ad54994c4b31d927d6fda06f01c57fada6803f8ebff7c46b2f92555e9326bfba6c2bc98dff56e528a199afc4e86918d5df13c94ee8870bb6bf2f2', 'bb745af2762c2d5fd18c502a3307fce40f38f0a3afb3114ff09c1356f0a1ba5bf075b70b5a0332063aca10e6675c9f6a8883e9457c3f6cf46fc21c01f3ec861d'),
('user', 'example', 'Merate', 23807, 'Pascoli', 3, 'user', 'test@example.com', 'b03adc62aa9e215a21c4c5a7c00c333f38122c0dc732d7c781690705cfcbf522bc5adb78a338f727bd98c48095c0ca4d7625dc273004f68c911e259e8e7e99b2', 'a9b7ba536a9de8fcb2e78252cf9a0c9626a89dcbf80815e40a1018301cdbdcc6edd343711f22279bc1f4d0cc914b333d41a7c13981dbd8a96f1168e50857dd59');

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

CREATE TABLE `categoria` (
  `nome` char(30) DEFAULT NULL,
  `codCategoria` int(11) NOT NULL,
  `sponsor` int(11) NOT NULL DEFAULT '0',
  `nomeFoto` char(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `categoria`
--

INSERT INTO `categoria` (`nome`, `codCategoria`, `sponsor`, `nomeFoto`) VALUES
('Latte detergente', 1, 0, 'latte-detergente.jpg'),
('Tonico', 2, 1, 'tonico.jpg'),
('Creme', 3, 1, 'creme.jpg'),
('Make-up', 4, 0, 'make up copeertina.jpg');

-- --------------------------------------------------------

--
-- Struttura della tabella `compra`
--

CREATE TABLE `compra` (
  `email` char(40) DEFAULT NULL,
  `codProdotto` int(11) DEFAULT NULL,
  `codAcquisto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `compra`
--

INSERT INTO `compra` (`email`, `codProdotto`, `codAcquisto`) VALUES
('test@example.com', 7, 1),
('test@example.com', 6, 2),
('test@example.com', 7, 3),
('test@example.com', 7, 4),
('test@example.com', 6, 5),
('test@example.com', 8, 6);

-- --------------------------------------------------------

--
-- Struttura della tabella `fotoprodotto`
--

CREATE TABLE `fotoprodotto` (
  `nomeFoto` char(30) NOT NULL,
  `codProdotto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `fotoprodotto`
--

INSERT INTO `fotoprodotto` (`nomeFoto`, `codProdotto`) VALUES
('latte detergente foto 2.jpg', 1),
('latte detregente 3.jpg', 1),
('latte-detergente.jpg', 1),
('detergente pelli grasse 2.jpg', 2),
('detergente pelli grasse 3.jpg', 2),
('detergente pelli grasse.jpg', 2),
('tonico pelli secche 1.jpg', 3),
('tonico pelli secche 3.jpg', 3),
('tonico_pelli_secche_2.jpg', 3),
('tonico  miste secche 1.jpg', 4),
('tonico miste grasse 3.jpg', 4),
('tonico-miste-grasse-2.jpg', 4),
('crema secca 2.jpg', 5),
('crema secca 3.jpg', 5),
('crema secca 4.jpg', 5),
('cremma secca 1.jpg', 5),
('crema nnotte 2.jpg', 6),
('crema notte 1.jpg', 6),
('crema notte 3.jpg', 6),
('crema giorno 1.jpg', 7),
('crema giorno 2.jpg', 7),
('crema giorno 3.jpg', 7),
('crema pelli norm 2.jpg', 8),
('crema pelli norm 3.jpg', 8),
('crema pelli norm 4.jpg', 8),
('creme pelli norm 1.jpg', 8),
('mascara 1.jpg', 9),
('mascara 2.jpg', 9),
('mascara 3.jpg', 9),
('mascara 4.jpg', 9),
('mascara 5.jpg', 9),
('TERRA 1.jpg', 10),
('TERRA 2.jpg', 10);

-- --------------------------------------------------------

--
-- Struttura della tabella `login`
--

CREATE TABLE `login` (
  `email` char(40) DEFAULT NULL,
  `codLogin` int(11) NOT NULL,
  `tempo` varchar(30) NOT NULL,
  `esito` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `login`
--

INSERT INTO `login` (`email`, `codLogin`, `tempo`, `esito`) VALUES
('admin@test.com', 1, '1620740700', 1),
('test@example.com', 2, '1620826612', 1),
('admin@test.com', 3, '1620828110', 1),
('test@example.com', 4, '1620828136', 1),
('test@example.com', 5, '1620828816', 1),
('test@example.com', 6, '1620839231', 1),
('admin@test.com', 7, '1620839295', 1),
('test@example.com', 8, '1620839423', 1),
('test@example.com', 9, '1621233945', 1),
('admin@test.com', 13, '1621234039', 1),
('admin@test.com', 15, '1621246836', 1),
('admin@test.com', 16, '1621587540', 1),
('test@example.com', 17, '1621589165', 1),
('admin@test.com', 18, '1621589357', 1),
('test@example.com', 19, '1621589601', 1),
('admin@test.com', 20, '1621590148', 1),
('test@example.com', 21, '1621859598', 1),
('admin@test.com', 22, '1621859674', 1),
('admin@test.com', 23, '1621859767', 1),
('admin@test.com', 24, '1621863559', 1),
('test@example.com', 25, '1622042703', 1),
('admin@test.com', 26, '1622043903', 1),
('admin@test.com', 27, '1622057892', 1),
('admin@test.com', 28, '1622290916', 1),
('admin@test.com', 29, '1622292918', 1),
('test@example.com', 30, '1622363048', 1),
('admin@test.com', 31, '1622367244', 1),
('test@example.com', 32, '1622369143', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `patologia`
--

CREATE TABLE `patologia` (
  `nomePatologia` char(30) NOT NULL,
  `descrizione` text,
  `controindicazioni` char(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `patologia`
--

INSERT INTO `patologia` (`nomePatologia`, `descrizione`, `controindicazioni`) VALUES
('Acne', 'presenza di comedoni sul viso.\r\npelle arrossata.\r\nviene sopratto ai soggetti con pelle grassa.', 'evitare di usare scrub \r\nevitare di schiacciare i comedoni'),
('Dermatite', 'malattia infiammatoria della cute.\r\npuò verificarsi con utilizzo di prodotti non adatti al tipo di pelle, oppure può avvenire se si è allergici a un determinato prodotto.', 'non può essere sottoposto al massaggio\r\n'),
('Psoriasi', 'malattia infiammatoria della pelle, caratterizzata da chiazze eritematose.\r\ngeneralmente localizzate su gomiti e ginocchia', 'non grattarsi'),
('Rosacea', 'forma di dermatite cronica caratterizzata dalla vaso dilatazione dei capillari che colpisce sopratutto le carnagioni chiare.', 'stare attenti ai cambi di temperatura');

-- --------------------------------------------------------

--
-- Struttura della tabella `personapatologia`
--

CREATE TABLE `personapatologia` (
  `email` char(40) DEFAULT NULL,
  `nomePatologia` char(30) DEFAULT NULL,
  `codPersonaPatologia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `prenota`
--

CREATE TABLE `prenota` (
  `email` char(40) DEFAULT NULL,
  `codTrattamento` int(11) DEFAULT NULL,
  `codPrenotazione` int(11) NOT NULL,
  `data` date NOT NULL,
  `oraInizio` time NOT NULL,
  `oraFine` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `prenota`
--

INSERT INTO `prenota` (`email`, `codTrattamento`, `codPrenotazione`, `data`, `oraInizio`, `oraFine`) VALUES
('test@example.com', 1, 8, '2021-05-11', '09:50:00', '10:25:00'),
('test@example.com', 1, 9, '2021-05-11', '10:55:00', '11:30:00'),
('test@example.com', 1, 10, '2021-05-11', '11:35:00', '12:10:00'),
('test@example.com', 3, 11, '2021-05-11', '14:50:00', '15:50:00'),
('test@example.com', 4, 12, '2021-05-11', '16:50:00', '17:10:00'),
('test@example.com', 3, 13, '2021-05-11', '15:50:00', '16:50:00'),
('test@example.com', 1, 14, '2021-05-13', '09:30:00', '10:05:00'),
('test@example.com', 3, 15, '2021-05-13', '10:05:00', '11:05:00'),
('test@example.com', 5, 16, '2021-05-22', '13:30:00', '14:05:00'),
('test@example.com', 3, 19, '2021-05-26', '18:35:00', '19:35:00'),
('test@example.com', 5, 20, '2021-05-28', '16:25:00', '17:00:00'),
('test@example.com', 6, 21, '2021-05-31', '13:10:00', '14:10:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotto`
--

CREATE TABLE `prodotto` (
  `nome` char(50) DEFAULT NULL,
  `codProdotto` int(11) NOT NULL,
  `marca` char(30) DEFAULT NULL,
  `prezzo` float DEFAULT NULL,
  `descrizione` text NOT NULL,
  `quantita` int(11) NOT NULL,
  `codCategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `prodotto`
--

INSERT INTO `prodotto` (`nome`, `codProdotto`, `marca`, `prezzo`, `descrizione`, `quantita`, `codCategoria`) VALUES
('Latte detergente pelli secche/normali', 1, 'Clarins', 24, 'Questo latte vellutato, arricchito con il complesso emolliente del Domaine Clarins (genziana maggiore biologica e melissa biologica) strucca e restituisce comfort nel rispetto del microbiota cutaneo. Per l\'applicazione, vedere il nostro metodo di maquillage su Internet. Completare con un tonico. Latte Detergente Comfort, frutto del Domaine Clarins, nel cuore delle Alpi.\r\nBENEFICI\r\n Elimina i residui di make-up e le particelle di inquinamento\r\n Preserva il microbiota cutaneo\r\n', 30, 1),
('Latte detergente pelli grasse/miste', 2, 'Clarins', 24, 'Il prodotto preferito della pelle mista e grassa. Il prodotto è arricchito con il complesso emolliente della tenuta Clarins (genziana gialla biologica e melissa biologica) e con estratto di regina dei prati (pianta biologica) e derivato di acido salicilico. Lascia la pelle pulita, strucca con delicatezza, purifica e favorisce una grana della pelle affinata. Grazie a tensioattivi delicati, deterge contribuendo a preservare l\'equilibrio del microbiota cutaneo.\r\nBENEFICI\r\nDeterge\r\nPurifica\r\n', 30, 1),
('Tonico pelli secche/normali', 3, 'Clarins', 24, 'Questo tonico senza alcol, arricchito con estratti di aloe vera biologica e di fico biologico, idrata e ammorbidisce la pelle. Arricchito con [Microbiote Complex], favorisce l\'equilibrio naturale della flora cutanea.\r\nBENEFICI\r\nPreserva il microbiota cutaneo', 30, 1),
('Tonico pelli grasse/miste', 4, 'Clarins', 24, 'Questo tonico senza alcol, arricchito con estratti di regina dei prati biologica e di amamelide biologica, purifica la pelle e restringe i pori. Arricchito con [Microbiote Complex], favorisce l\'equilibrio naturale della flora cutanea.\r\nBENEFICI\r\nPreserva il microbiota cutaneo', 30, 2),
('Crema viso pelli secche', 5, 'Clarins', 48, 'La ricchezza di un balsamo in una texture leggerissima che non unge la pelle. La formula cremosa e impalpabile avvolge la pelle restituendole immediatamente una sensazione di comfort. La pelle ritrova la sua capacità  di trattenere l\'acqua. Resta intensamente idratata in ogni occasione. Il suo segreto è l\'estratto della pianta di Goethe biologica, potente attivatore d\'idratazione naturale che stimola la produzione di acido ialuronico* da parte della pelle. La pelle, immediatamente idratata e nutrita, è luminosa e avvolta da comfort. *\"Molecola spugna\" che trattiene l\'acqua della pelle\r\nBENEFICI\r\nUna pelle intensamente idratata, fresca e levigata. Luminosità  ravvivata. Grana cutanea affinata.', 10, 3),
('Crema notte', 6, 'Clarins', 128, 'Innovazione Clarins Pro Aging Nutrition. I Laboratori Clarins hanno sviluppato due principi attivi ultra potenti che risvegliano tutta la luminosità  della pelle. L\'estratto di fiori d\'ippocastano biologico e l\'escina, una molecola attiva estratta dal frutto, migliorano il funzionamento della rete micronutriente della pelle. Un duo vitalità  che nasce dal savoir faire dei Laboratori Clarins e favorisce la diffusione dei nutrienti nella pelle. Nutrita, la pelle ritrova tutta la sua luminosità . Nutri Lumière Notte è il trattamento rigenerante dalla texture cremosa che si fonde all\'applicazione, ideale per una pelle rivitalizzata, nutrita e luminosa al risveglio\r\nAdatta a tutti i tipi di pelle.\r\nBENEFICI\r\nRivitalizza\r\nNutre\r\nRisveglia la luminosità  della pelle', 10, 3),
('Crema giorno', 7, 'Clarins', 128, 'Innovazione Clarins Pro-Aging Nutrition. I Laboratori Clarins hanno sviluppato due principi attivi ultra potenti che risvegliano tutta la luminosità  della pelle. L\'estratto di fiori d\'ippocastano biologico e l\'escina, una molecola attiva estratta dal frutto, migliorano il funzionamento della rete micronutriente della pelle. Un duo vitalità  che nasce dal savoir-faire dei Laboratori Clarins e favorisce la diffusione dei nutrienti nella pelle. Nutrita, la pelle ritrova tutta la sua luminosità . Nutri-Lumière Giorno è la crema in olio dalla texture fondente e sensoriale ideale per rivitalizzare, nutrire intensamente e risvegliare la luminosità  della pelle denutrita. Si adatta a tutti i tipi di pelle.\r\nBENEFICI\r\nRivitalizza\r\nNutre intensamente\r\nRisveglia la luminosità  della pelle', 10, 3),
('Crema per pelli normali/miste', 8, 'Clarins', 48, 'Questo gel idratante fresco e non grasso agisce come una crema: trattamento viso a tutti gli effetti, permette di restituire luminosità  e comfort alla pelle in ogni occasione. La pelle ritrova la capacità  di trattenere l\'acqua grazie all\'estratto di pianta di Goethe biologica, potente attivatore d\'idratazione naturale che stimola la produzione di acido ialuronico* da parte della pelle. Dissetata in profondità , la pelle ritrova tono e freschezza.\r\n*\"Molecola spugna\" che trattiene l\'acqua della pelle\r\nBENEFICI\r\nPelle perfettamente idratata. Pelle fresca e opacizzata. Luminosità  ravvivata. Complesso antinquinamento Clarins.', 20, 3),
('Mascara', 9, 'Clarins', 28, 'Le 4 dimensioni di uno sguardo perfetto: volume, lunghezza, curvatura, alta definizione. \r\nBENEFICI\r\nVolume travolgente\r\nLunghezza estrema\r\nCurvatura da sogno\r\nAlta definizione', 20, 4),
('Terra', 10, 'Clarins', 38, 'La terra \"Duo Bronze\" ravviva delicatamente il colorito offrendo un\'abbronzatura dorata e naturale, tutto l\'anno. La texture leggera regala una bella pelle abbronzata effetto nude per tutto il giorno. La formula associa gli effetti benefici delle sostanze vegetali alla purezza dei minerali per un\'armonia perfetta con la pelle. Le due tonalità  complementari permettono di sfumare sul viso i colori giocando con luci ed ombre per modulare l\'effetto pelle sana.\r\nBENEFICI\r\nScalda l\'incarnato.\r\nUniforma.', 20, 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `recensione`
--

CREATE TABLE `recensione` (
  `codRecensione` int(11) NOT NULL,
  `descrizione` tinytext NOT NULL,
  `valutazione` float NOT NULL,
  `codProdotto` int(11) NOT NULL,
  `email` char(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `recensione`
--

INSERT INTO `recensione` (`codRecensione`, `descrizione`, `valutazione`, `codProdotto`, `email`) VALUES
(1, 'ottima crema', 4, 6, 'test@example.com');

-- --------------------------------------------------------

--
-- Struttura della tabella `trattamento`
--

CREATE TABLE `trattamento` (
  `codTrattamento` int(11) NOT NULL,
  `nome` char(30) DEFAULT NULL,
  `durata` time NOT NULL,
  `prezzo` float NOT NULL,
  `nomeFoto` char(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `trattamento`
--

INSERT INTO `trattamento` (`codTrattamento`, `nome`, `durata`, `prezzo`, `nomeFoto`) VALUES
(1, 'Pedicure', '00:35:00', 40, 'pedicure.jpg'),
(3, 'Massaggio', '01:00:00', 90, 'massaggio.jpg'),
(4, 'Ceretta gambe', '00:20:00', 30, 'ceretta_gambe.jpg'),
(5, 'Manicure', '00:35:00', 30, 'manicure.jpg'),
(6, 'Viso', '01:00:00', 60, 'pul viso.jpg'),
(7, 'Manicure semipermanente', '00:30:00', 50, 'semi_mani_3.jpg'),
(8, 'Pedicure semipermanente', '00:35:00', 50, 'semipermanente-piediart-.jpg');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`email`);

--
-- Indici per le tabelle `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`codCategoria`);

--
-- Indici per le tabelle `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`codAcquisto`),
  ADD KEY `email` (`email`),
  ADD KEY `codProdotto` (`codProdotto`);

--
-- Indici per le tabelle `fotoprodotto`
--
ALTER TABLE `fotoprodotto`
  ADD PRIMARY KEY (`nomeFoto`),
  ADD KEY `fotoProdotto_prodotto` (`codProdotto`);

--
-- Indici per le tabelle `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`codLogin`),
  ADD KEY `email` (`email`);

--
-- Indici per le tabelle `patologia`
--
ALTER TABLE `patologia`
  ADD PRIMARY KEY (`nomePatologia`);

--
-- Indici per le tabelle `personapatologia`
--
ALTER TABLE `personapatologia`
  ADD PRIMARY KEY (`codPersonaPatologia`),
  ADD KEY `email` (`email`),
  ADD KEY `nomePatologia` (`nomePatologia`);

--
-- Indici per le tabelle `prenota`
--
ALTER TABLE `prenota`
  ADD PRIMARY KEY (`codPrenotazione`),
  ADD KEY `email` (`email`),
  ADD KEY `codTrattamento` (`codTrattamento`);

--
-- Indici per le tabelle `prodotto`
--
ALTER TABLE `prodotto`
  ADD PRIMARY KEY (`codProdotto`),
  ADD KEY `prodotto_categoria` (`codCategoria`);

--
-- Indici per le tabelle `recensione`
--
ALTER TABLE `recensione`
  ADD PRIMARY KEY (`codRecensione`),
  ADD KEY `recensione_account` (`email`),
  ADD KEY `recensione_prodotto` (`codProdotto`);

--
-- Indici per le tabelle `trattamento`
--
ALTER TABLE `trattamento`
  ADD PRIMARY KEY (`codTrattamento`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `categoria`
--
ALTER TABLE `categoria`
  MODIFY `codCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT per la tabella `compra`
--
ALTER TABLE `compra`
  MODIFY `codAcquisto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT per la tabella `login`
--
ALTER TABLE `login`
  MODIFY `codLogin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT per la tabella `personapatologia`
--
ALTER TABLE `personapatologia`
  MODIFY `codPersonaPatologia` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `prenota`
--
ALTER TABLE `prenota`
  MODIFY `codPrenotazione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT per la tabella `prodotto`
--
ALTER TABLE `prodotto`
  MODIFY `codProdotto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT per la tabella `recensione`
--
ALTER TABLE `recensione`
  MODIFY `codRecensione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT per la tabella `trattamento`
--
ALTER TABLE `trattamento`
  MODIFY `codTrattamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_account` FOREIGN KEY (`email`) REFERENCES `account` (`email`) ON DELETE SET NULL,
  ADD CONSTRAINT `compra_prodotto` FOREIGN KEY (`codProdotto`) REFERENCES `prodotto` (`codProdotto`) ON DELETE NO ACTION;

--
-- Limiti per la tabella `fotoprodotto`
--
ALTER TABLE `fotoprodotto`
  ADD CONSTRAINT `fotoProdotto_prodotto` FOREIGN KEY (`codProdotto`) REFERENCES `prodotto` (`codProdotto`) ON DELETE CASCADE;

--
-- Limiti per la tabella `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_persona` FOREIGN KEY (`email`) REFERENCES `account` (`email`) ON DELETE SET NULL;

--
-- Limiti per la tabella `personapatologia`
--
ALTER TABLE `personapatologia`
  ADD CONSTRAINT `personapatologia_account` FOREIGN KEY (`email`) REFERENCES `account` (`email`) ON DELETE CASCADE,
  ADD CONSTRAINT `personapatologia_patologia` FOREIGN KEY (`nomePatologia`) REFERENCES `patologia` (`nomePatologia`) ON DELETE CASCADE;

--
-- Limiti per la tabella `prenota`
--
ALTER TABLE `prenota`
  ADD CONSTRAINT `prenota_persona` FOREIGN KEY (`email`) REFERENCES `account` (`email`) ON DELETE SET NULL,
  ADD CONSTRAINT `prenota_trattamento` FOREIGN KEY (`codTrattamento`) REFERENCES `trattamento` (`codTrattamento`) ON DELETE CASCADE;

--
-- Limiti per la tabella `prodotto`
--
ALTER TABLE `prodotto`
  ADD CONSTRAINT `prodotto_categoria` FOREIGN KEY (`codCategoria`) REFERENCES `categoria` (`codCategoria`) ON UPDATE CASCADE;

--
-- Limiti per la tabella `recensione`
--
ALTER TABLE `recensione`
  ADD CONSTRAINT `recensione_account` FOREIGN KEY (`email`) REFERENCES `account` (`email`) ON DELETE CASCADE,
  ADD CONSTRAINT `recensione_prodotto` FOREIGN KEY (`codProdotto`) REFERENCES `prodotto` (`codProdotto`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
