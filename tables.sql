-- Adminer 4.8.1 MySQL 5.5.5-10.6.16-MariaDB-0ubuntu0.22.04.1 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `etat`;
CREATE TABLE `etat` (
  `ETA_ID` char(2) NOT NULL,
  `ETA_LIB` varchar(30) NOT NULL,
  PRIMARY KEY (`ETA_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `etat` (`ETA_ID`, `ETA_LIB`) VALUES
('CL',	'Saisie clôturée'),
('CR',	'Fiche créée, saisie en cours'),
('RB',	'Remboursée'),
('VA',	'Validée et mise en paiement');

DROP TABLE IF EXISTS `fiche_frais`;
CREATE TABLE `fiche_frais` (
  `FFR_ID` int(2) NOT NULL,
  `VIS_ID` char(4) CHARACTER SET utf16 COLLATE utf16_general_ci NOT NULL,
  `ETA_ID` char(2) NOT NULL,
  `FFR_ANNEE` year(4) NOT NULL,
  `FFR_MOIS` enum('JANVIER','FEVRIER','MARS','AVRIL','MAI','JUIN','JUILLET','AOUT','SEPTEMBRE','OCTOBRE','NOVEMBRE','DECEMBRE') NOT NULL,
  `FFR_MONTANT_VALIDE` decimal(10,2) NOT NULL,
  `FFR_NB_JUSTIFICATIFS` int(11) NOT NULL,
  `FFR_DATE_MODIF` date NOT NULL DEFAULT '0000-00-00',
  KEY `FFR_ID` (`FFR_ID`),
  KEY `VIS_ID` (`VIS_ID`),
  KEY `ETA_ID` (`ETA_ID`),
  CONSTRAINT `fiche_frais_ibfk_2` FOREIGN KEY (`VIS_ID`) REFERENCES `visiteur` (`VIS_ID`),
  CONSTRAINT `fiche_frais_ibfk_3` FOREIGN KEY (`ETA_ID`) REFERENCES `etat` (`ETA_ID`),
  CONSTRAINT `fiche_frais_ibfk_4` FOREIGN KEY (`FFR_ID`) REFERENCES `ligne_frais_forfait` (`FFR_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `fiche_frais` (`FFR_ID`, `VIS_ID`, `ETA_ID`, `FFR_ANNEE`, `FFR_MOIS`, `FFR_MONTANT_VALIDE`, `FFR_NB_JUSTIFICATIFS`, `FFR_DATE_MODIF`) VALUES
(2,	'ED',	'CL',	'2024',	'AVRIL',	2156.20,	10,	'2024-02-15'),
(3,	'ED',	'CR',	'2024',	'FEVRIER',	3144.62,	5,	'2024-03-14'),
(7,	'ED',	'CR',	'2022',	'MARS',	4312.40,	20,	'2024-03-14'),
(8,	'ED',	'CR',	'2035',	'JUILLET',	338478.90,	2343,	'2024-03-19'),
(9,	'JD',	'CR',	'2023',	'AOUT',	1509.34,	7,	'2024-03-25'),
(10,	'ED',	'CR',	'2021',	'OCTOBRE',	6883.34,	42,	'2024-03-30'),
(11,	'ED',	'CR',	'2004',	'FEVRIER',	819660.04,	4242,	'2024-03-30'),
(16,	'ED',	'CR',	'2023',	'MAI',	41272.28,	44,	'2024-03-30'),
(17,	'ED',	'CR',	'2007',	'JUIN',	2012.44,	12,	'2024-04-09'),
(18,	'ED',	'CR',	'2009',	'DECEMBRE',	18395.62,	1,	'2024-04-09'),
(19,	'JD',	'CR',	'2024',	'OCTOBRE',	42756.82,	231,	'2024-04-10');

DROP TABLE IF EXISTS `frais_forfait`;
CREATE TABLE `frais_forfait` (
  `FOR_ID` char(3) NOT NULL,
  `FOR_LIB` char(20) NOT NULL,
  `FOR_MONTANT` decimal(5,2) NOT NULL,
  PRIMARY KEY (`FOR_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `frais_forfait` (`FOR_ID`, `FOR_LIB`, `FOR_MONTANT`) VALUES
('ETP',	'Forfait Etape',	110.00),
('KM',	'Frais Kilométrique',	0.62),
('NUI',	'Nuitée Hôtel',	80.00),
('REP',	'Repas Restaurant',	25.00);

DROP TABLE IF EXISTS `ligne_frais_forfait`;
CREATE TABLE `ligne_frais_forfait` (
  `FFR_ID` int(2) NOT NULL,
  `FOR_ID` char(3) NOT NULL,
  `LIG_QTE` int(2) NOT NULL,
  PRIMARY KEY (`FFR_ID`,`FOR_ID`),
  KEY `FOR_ID` (`FOR_ID`),
  CONSTRAINT `ligne_frais_forfait_ibfk_2` FOREIGN KEY (`FOR_ID`) REFERENCES `frais_forfait` (`FOR_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `ligne_frais_forfait` (`FFR_ID`, `FOR_ID`, `LIG_QTE`) VALUES
(2,	'ETP',	10),
(2,	'KM',	10),
(2,	'NUI',	10),
(2,	'REP',	10),
(3,	'ETP',	5),
(3,	'KM',	1201),
(3,	'NUI',	20),
(3,	'REP',	10),
(4,	'ETP',	2424),
(4,	'KM',	4101),
(4,	'NUI',	12),
(4,	'REP',	21),
(5,	'ETP',	22),
(5,	'KM',	222),
(5,	'NUI',	12),
(5,	'REP',	21),
(6,	'ETP',	22),
(6,	'KM',	222),
(6,	'NUI',	12),
(6,	'REP',	21),
(7,	'ETP',	20),
(7,	'KM',	20),
(7,	'NUI',	20),
(7,	'REP',	20),
(8,	'ETP',	2343),
(8,	'KM',	2345),
(8,	'NUI',	234),
(8,	'REP',	2423),
(9,	'ETP',	7),
(9,	'KM',	7),
(9,	'NUI',	7),
(9,	'REP',	7),
(10,	'ETP',	42),
(10,	'KM',	457),
(10,	'NUI',	21),
(10,	'REP',	12),
(11,	'ETP',	4242),
(11,	'KM',	4242),
(11,	'NUI',	4242),
(11,	'REP',	442),
(12,	'ETP',	44524),
(12,	'KM',	452452),
(12,	'NUI',	424242),
(12,	'REP',	24524),
(13,	'ETP',	4),
(13,	'KM',	4),
(13,	'NUI',	4),
(13,	'REP',	4),
(14,	'ETP',	4),
(14,	'KM',	4),
(14,	'NUI',	4),
(14,	'REP',	4),
(15,	'ETP',	44),
(15,	'KM',	44),
(15,	'NUI',	441),
(15,	'REP',	45),
(16,	'ETP',	44),
(16,	'KM',	44),
(16,	'NUI',	441),
(16,	'REP',	45),
(17,	'ETP',	12),
(17,	'KM',	12),
(17,	'NUI',	2),
(17,	'REP',	21),
(18,	'ETP',	1),
(18,	'KM',	1),
(18,	'NUI',	222),
(18,	'REP',	21),
(19,	'ETP',	231),
(19,	'KM',	11),
(19,	'NUI',	213),
(19,	'REP',	12);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `US_ID` char(4) NOT NULL,
  `US_LOG` varchar(255) NOT NULL,
  `US_PAS` varchar(255) NOT NULL,
  `US_DTCO` date NOT NULL,
  `US_ROLE` int(11) NOT NULL,
  PRIMARY KEY (`US_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `visiteur`;
CREATE TABLE `visiteur` (
  `VIS_ID` char(4) NOT NULL,
  `VIS_NOM` char(60) NOT NULL,
  `VIS_PRENOM` char(60) NOT NULL,
  `VIS_ADRESSE` char(60) NOT NULL,
  `VIS_CP` char(5) NOT NULL,
  `VIS_VILLE` char(60) NOT NULL,
  `VIS_DATE_EMBAUCHE` date NOT NULL,
  PRIMARY KEY (`VIS_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

INSERT INTO `visiteur` (`VIS_ID`, `VIS_NOM`, `VIS_PRENOM`, `VIS_ADRESSE`, `VIS_CP`, `VIS_VILLE`, `VIS_DATE_EMBAUCHE`) VALUES
('CL',	'Lebrun\r\n',	'Corentin\r\n',	'6 sq Le Gal La Salle \r\n',	'29800',	'LANDERNEAU',	'2005-02-07'),
('DM',	'Marchal\r\n',	'Diego\r\n',	'17 r Lyon \r\n',	'29800',	'LANDERNEAU',	'2005-02-07'),
('ED',	'Dufour',	'Renaud',	'22 rue des champignons',	'29200',	'Brest',	'2024-01-15'),
('EL',	'Leclercq\r\n',	'Enzo\r\n',	'1 r Michel Ollivier\r\n',	'29800',	'LANDERNEAU',	'2005-02-07'),
('FB',	'Blanc\r\n',	'Fabrice\r\n',	'10 r Doct Roux \r\n',	'29800',	'LANDERNEAU',	'2005-02-07'),
('FR',	'Remy\r\n',	'F?lix\r\n',	'17 r Lyon \r\n',	'29800',	'LANDERNEAU',	'2005-02-07'),
('GC',	'Collin\r\n',	'Gaspard\r\n',	'83 r Suzanne Guiganton \r\n',	'29800',	'LANDERNEAU',	'2005-02-07'),
('JD',	'Dominique',	'José',	'35 avenue Gilbert',	'29200',	'Brest',	'2023-08-19'),
('JR',	'Roussel\r\n',	'Julien\r\n',	'8 r Navarin \r\n',	'29800',	'LANDERNEAU',	'2005-02-07'),
('LM',	'Mathieu\r\n',	'Lucas\r\n',	'22 r Berthollet \r\n',	'29800',	'LANDERNEAU',	'2005-02-07'),
('MP',	'Paul\r\n',	'Maxime\r\n',	'6 r Fr?d?ric Le Guyader\r\n',	'29800',	'LANDERNEAU',	'2005-02-07'),
('PD',	'Dupre\r\n',	'Paul\r\n',	'3 sq Mac?doine  \r\n',	'29800',	'LANDERNEAU',	'2005-02-07'),
('RB',	'Barre\r\n',	'R?mi\r\n',	'2 r G?n Margueritte \r\n',	'29800',	'LANDERNEAU',	'2005-02-07'),
('RD',	'Deschamps\r\n',	'R?mi\r\n',	'3 r Georges Brassens \r\n',	'29800',	'LANDERNEAU',	'2005-02-07'),
('SC',	'Clement\r\n',	'Samuel\r\n',	'92 r Richelieu \r\n',	'29800',	'LANDERNEAU',	'2005-02-07'),
('SL',	'Laporte\r\n',	'Simon\r\n',	'175 r Marr?gu?s\r\n',	'29800',	'LANDERNEAU',	'2005-02-07'),
('SR',	'Riou\r\n',	'Samuel\r\n',	'4 r Yves Collet \r\n',	'29800',	'LANDERNEAU',	'2005-02-07'),
('TB',	'Barbier\r\n',	'Thomas\r\n',	'36 r Champagne \r\n',	'29800',	'LANDERNEAU',	'2005-02-07'),
('TG',	'Guillon\r\n',	'Titouan\r\n',	'18 bd Jacques Cartier \r\n',	'29800',	'LANDERNEAU',	'2005-02-07'),
('TSS',	'Daniel\r\n',	'Noah\r\n',	'3 r Kersaint \r\n',	'NULL',	'NULL',	'2023-03-03');

-- 2024-04-10 10:10:50