-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 15 nov. 2023 à 10:47
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `filao`
--

-- --------------------------------------------------------

--
-- Structure de la table `apres_charge`
--

CREATE TABLE `apres_charge` (
  `id` int(11) NOT NULL,
  `num` varchar(255) NOT NULL,
  `id_poisson` varchar(255) NOT NULL,
  `qtt` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `auchambre`
--

CREATE TABLE `auchambre` (
  `id` int(11) NOT NULL,
  `id_poisson` int(11) NOT NULL,
  `NumFac` int(11) NOT NULL,
  `qtt` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `chargement_bac`
--

CREATE TABLE `chargement_bac` (
  `id` int(11) NOT NULL,
  `id_poisson` varchar(255) NOT NULL,
  `qtt` float NOT NULL,
  `bac` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `id_sortie` varchar(50) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cv`
--

CREATE TABLE `cv` (
  `id` int(11) NOT NULL,
  `cv` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `depence`
--

CREATE TABLE `depence` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `cout` varchar(255) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `detailavant`
--

CREATE TABLE `detailavant` (
  `id` int(11) NOT NULL,
  `idfilao` text NOT NULL,
  `id_poisson` varchar(255) NOT NULL,
  `NumFac` varchar(255) NOT NULL,
  `qtt` varchar(255) NOT NULL,
  `lanja` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `detailfilao`
--

CREATE TABLE `detailfilao` (
  `id` int(11) NOT NULL,
  `id_poisson` int(11) NOT NULL,
  `qtt` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `prixUnit` int(50) NOT NULL,
  `NumFac` int(50) NOT NULL,
  `idFournisseur` int(50) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `detailfilaocontre`
--

CREATE TABLE `detailfilaocontre` (
  `id` int(11) NOT NULL,
  `id_poisson` int(11) NOT NULL,
  `NumFac` varchar(255) NOT NULL,
  `qtt` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `detailfilaosortie`
--

CREATE TABLE `detailfilaosortie` (
  `id` int(11) NOT NULL,
  `id_poisson` varchar(255) NOT NULL,
  `sac` varchar(255) NOT NULL,
  `qtt` double NOT NULL,
  `id_sortie` varchar(255) NOT NULL,
  `place` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `factmj`
--

CREATE TABLE `factmj` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE `facture` (
  `id` int(11) NOT NULL,
  `id_fou` int(11) NOT NULL,
  `totalapayee` decimal(10,0) NOT NULL,
  `payee` decimal(10,0) NOT NULL,
  `restapayer` varchar(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `facturesortie`
--

CREATE TABLE `facturesortie` (
  `id` int(11) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `facturetana`
--

CREATE TABLE `facturetana` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `filaolafo`
--

CREATE TABLE `filaolafo` (
  `idc` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `id_poisson` varchar(255) NOT NULL,
  `qtt` varchar(255) NOT NULL,
  `prix` varchar(255) NOT NULL,
  `client` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

CREATE TABLE `fournisseur` (
  `id` int(11) NOT NULL,
  `nomfournisseur` varchar(255) NOT NULL,
  `Adress` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `froid`
--

CREATE TABLE `froid` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `froidf`
--

CREATE TABLE `froidf` (
  `id` int(11) NOT NULL,
  `nomFilao` varchar(255) NOT NULL,
  `qtt` decimal(11,0) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `froidfinal`
--

CREATE TABLE `froidfinal` (
  `id` int(11) NOT NULL,
  `classe` text NOT NULL,
  `qttt` decimal(10,0) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `imgpers`
--

CREATE TABLE `imgpers` (
  `id` int(11) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `observation`
--

CREATE TABLE `observation` (
  `id` int(11) NOT NULL,
  `id_obs` varchar(255) NOT NULL,
  `obs` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `particulier`
--

CREATE TABLE `particulier` (
  `idc` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `id_poisson` varchar(255) NOT NULL,
  `qtt` varchar(255) NOT NULL,
  `prix` varchar(255) NOT NULL,
  `client` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personnel`
--

CREATE TABLE `personnel` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `poste` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `poisson`
--

CREATE TABLE `poisson` (
  `id` int(11) NOT NULL,
  `nomFilao` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `present`
--

CREATE TABLE `present` (
  `id` int(11) NOT NULL,
  `id_personnel` varchar(255) NOT NULL,
  `debut` time NOT NULL,
  `fin` time NOT NULL,
  `suple` time DEFAULT '00:00:00',
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sortie`
--

CREATE TABLE `sortie` (
  `id_sortie` int(11) NOT NULL,
  `sortieqtt` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `id_poisson` varchar(255) NOT NULL,
  `qtt` double NOT NULL,
  `nombre_sac` int(11) NOT NULL,
  `place` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `stockf`
--

CREATE TABLE `stockf` (
  `id` int(11) NOT NULL,
  `nomFilao` varchar(255) NOT NULL,
  `qtt` decimal(11,0) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `stockfinal`
--

CREATE TABLE `stockfinal` (
  `id` int(11) NOT NULL,
  `classe` varchar(11) NOT NULL,
  `poids` decimal(11,0) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `traitement_coms`
--

CREATE TABLE `traitement_coms` (
  `id` int(11) NOT NULL,
  `num_fact` varchar(255) NOT NULL,
  `text` varchar(3000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL DEFAULT '0000',
  `vente` varchar(255) NOT NULL DEFAULT '0',
  `achat` varchar(255) NOT NULL DEFAULT '0',
  `stock` varchar(255) NOT NULL DEFAULT '0',
  `lieukandra` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `vente`, `achat`, `stock`, `lieukandra`) VALUES
(1, 'Nordine', 'nordine', '0', '0', '0', 'tana');

-- --------------------------------------------------------

--
-- Structure de la table `ventetana`
--

CREATE TABLE `ventetana` (
  `id` int(11) NOT NULL,
  `nomFilao` varchar(255) NOT NULL,
  `qtt` decimal(11,0) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `apres_charge`
--
ALTER TABLE `apres_charge`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `chargement_bac`
--
ALTER TABLE `chargement_bac`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cv`
--
ALTER TABLE `cv`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `depence`
--
ALTER TABLE `depence`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `detailavant`
--
ALTER TABLE `detailavant`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `detailfilao`
--
ALTER TABLE `detailfilao`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `detailfilaocontre`
--
ALTER TABLE `detailfilaocontre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `detailfilaosortie`
--
ALTER TABLE `detailfilaosortie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `facturesortie`
--
ALTER TABLE `facturesortie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `filaolafo`
--
ALTER TABLE `filaolafo`
  ADD PRIMARY KEY (`idc`);

--
-- Index pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `froidf`
--
ALTER TABLE `froidf`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `imgpers`
--
ALTER TABLE `imgpers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `observation`
--
ALTER TABLE `observation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `particulier`
--
ALTER TABLE `particulier`
  ADD PRIMARY KEY (`idc`);

--
-- Index pour la table `personnel`
--
ALTER TABLE `personnel`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `poisson`
--
ALTER TABLE `poisson`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `present`
--
ALTER TABLE `present`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `stockf`
--
ALTER TABLE `stockf`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `traitement_coms`
--
ALTER TABLE `traitement_coms`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ventetana`
--
ALTER TABLE `ventetana`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `apres_charge`
--
ALTER TABLE `apres_charge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `chargement_bac`
--
ALTER TABLE `chargement_bac`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `depence`
--
ALTER TABLE `depence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `detailavant`
--
ALTER TABLE `detailavant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `detailfilao`
--
ALTER TABLE `detailfilao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `detailfilaocontre`
--
ALTER TABLE `detailfilaocontre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `detailfilaosortie`
--
ALTER TABLE `detailfilaosortie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `filaolafo`
--
ALTER TABLE `filaolafo`
  MODIFY `idc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `froidf`
--
ALTER TABLE `froidf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `observation`
--
ALTER TABLE `observation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `particulier`
--
ALTER TABLE `particulier`
  MODIFY `idc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `personnel`
--
ALTER TABLE `personnel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `poisson`
--
ALTER TABLE `poisson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `present`
--
ALTER TABLE `present`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `stockf`
--
ALTER TABLE `stockf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `traitement_coms`
--
ALTER TABLE `traitement_coms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `ventetana`
--
ALTER TABLE `ventetana`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
