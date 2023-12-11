-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 11 déc. 2023 à 19:24
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET foreign_key_checks = 0;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `booktracker`
--

--
-- Déchargement des données de la table `book_genre`
--

INSERT INTO `book_genre` (`id`, `label`) VALUES
(1, 'Roman'),
(2, 'Tragédie'),
(3, 'Roman historique'),
(4, 'Roman à thèse'),
(5, 'Shōnen manga'),
(6, 'Bande dessinée'),
(7, 'Fantastique'),
(8, 'Éthique');

--
-- Déchargement des données de la table `author`
--

INSERT INTO `author` (`id`, `name`, `description`, `birth_day`, `death_date`, `picture`, `last_edit_at`) VALUES
(1, 'Victor Hugo', '<div>Victor Hugo est un poète, dramaturge, écrivain, romancier et dessinateur romantique français. Il est considéré comme l\'un des écrivains de la langue française et de la littérature mondiale les plus importants. Il est également une personnalité politique et un intellectuel engagé qui a un rôle idéologique majeur et occupe une place marquante dans l\'histoire des lettres françaises au XIXe siècle.</div>', '1802-02-26', '1885-05-22', 'victor-hugo-6575a5d8d620b409317305.jpg', '2023-12-10 13:44:56'),
(2, 'Jean de La Fontaine', '<div>Jean de La Fontaine est un homme de lettres du Grand siècle et l\'un des principaux représentants du classicisme français. Outre ses <em>Fables</em> et ses Contes libertins, qui ont établi sa célébrité dès les années 1660. On lui doit divers poèmes, pièces de théâtre et livrets d\'opéra qui confirment son ambition de moraliste.&nbsp;</div>', '1621-07-08', '1695-04-13', 'jean-de-la-fontaine-6575b447d898d843645259.jpg', '2023-12-10 13:51:19'),
(3, 'Molière', '<div>Molière, de son vrai nom Jean-Baptiste Poquelin, est un célèbre comédien et dramaturge de la langue française.</div>', '1622-01-15', '1673-02-17', 'moliere-6575c6c261e1e835487934.jpg', '2023-12-10 15:10:10'),
(4, 'Jean-Jacques Rousseau', '<div>Jean-Jacques Rousseau est un écrivain, philosophe et musicien genevois. Orphelin de mère très jeune, sa vie est marquée par l\'errance. Si ses livres et lettres connaissent à partir de 1749 un fort succès, ils lui valent aussi des conflits avec l\'Église catholique et la République de Genève qui l\'obligent à changer souvent de résidence et alimentent son sentiment de persécution.</div>', '1712-06-28', '1778-07-02', 'jean-jacques-rousseau-6575c7ffd8614543108416.jpg', '2023-12-10 15:15:27'),
(5, 'Émilie Zola', '<div>Émilie Zola est un écrivain et journaliste français. Il est considéré comme le chef de file du naturalisme. Il est l\'un des romanciers français les plus populaires, les plus publiés, traduits et commentés dans le monde entier. Il a durablement marqué de son empreinte le monde littéraire français.&nbsp;</div>', '1840-04-02', '1902-09-29', 'emile-zola-6575c93261b5f156449256.jpg', '2023-12-10 15:33:38'),
(6, 'Masashi Kishimoto', '<div>Masashi Kishimoto est un mangaka et un scénariste japonais. Il est notamment connu pour être l\'auteur du manga Naruto, publié entre 1999 et 2014 avec un total de 700 chapitres collectés en 72 volumes.</div>', '1974-11-08', NULL, 'masashi-kishimoto-6575cd2ca9cd3624904270.jpg', '2023-12-10 15:49:16'),
(7, 'Albert Uderzo', '<div>Albert Uderzo de son vrai nom, Alberto Aleandro Uderzo est un auteur de bande dessinée française, éditeur et homme d\'affaires. Il crée avec René Goscinny, la série de bande dessinée Astérix notamment en 1959.</div>', '1927-04-25', '2020-03-24', 'albert-uderzo-6575d326a6050668014529.jpg', '2023-12-10 17:04:50'),
(8, 'René Goscinny', '<div><strong>René Goscinny</strong> est un scénariste de bande dessinée, journaliste, écrivain et humoriste français, également producteur, réalisateur et scénariste de films. Il est le créateur d\'Astérix avec Albert Uderzo en 1959. Il est aussi l\'auteur du Petit Nicolas et le scénariste de nombreux albums de Lucky Luke.</div>', '1926-08-14', '1977-11-05', 'rene-goscinny-6575d456b245e295247046.jpg', '2023-12-10 17:04:50'),
(9, 'Jean-Yves Ferri', '<div>Jean-Yves Ferri ou simplement Ferri, est un auteur de bande dessinée français. Il est le scénariste de Le Retour à la terre et est le créateur d\'Aimé Lacapelle. Il est choisi par Albert Uderzo pour lui succéder en tant que scénariste de la célèbre bande déssinée Astérix.</div>', '1959-04-20', NULL, 'jean-yves-ferri-6575d5ec5ecdb912480596.jpg', '2023-12-10 16:56:23'),
(10, 'Didier Conrad', '<div>Didier Conrad, dit Conrad est un dessinateur et scénariste de bande dessinée français. Il dessine la jeunesse de Lucky Luke avec Kid Lucky (deux tomes en 1994 et 1997), puis Marsu Kids (deux tomes en 2011 et 2013). En 2013, il devient le dessinateur officiel de la série Astérix, succédant à Albert Uderzo sur des scénarios de Jean-Yves Ferri et Fabcaro.<br><br></div>', '1959-05-06', NULL, 'didier-conrad-6575dc2ce3819444891271.jpg', '2023-12-10 17:04:50'),
(11, 'Fabcaro', '<div>Fabrice Caro, dit Fabcaro, est un auteur de bande dessinée, romancier et musicien français.</div>', '1973-08-10', NULL, 'fabcaro-6575dd57c04c5457178257.jpg', '2023-12-10 17:04:50'),
(12, 'J. K. Rowling', '<div>Joanne Rowling plus connue sous le nom de J. K. Rowling ou encore Robert Galbraith, est une romancière et scénariste britannique. Elle doit sa notoriété mondiale à la série de livres Harry Potter.</div>', '1965-07-31', NULL, 'j-k-rowling-6575e60d7ce7e775887359.jpg', '2023-12-10 17:23:41'),
(13, 'Hergé', '<div>Georges Remi, dit Hergé,est un auteur de bande dessinée belge, principalement connu pour Les Aventures de Tintin, l\'une des bandes dessinées européennes les plus populaires du XXe siècle.</div>', '1907-05-22', '1983-03-03', 'herge-6575ea8be1794663202603.jpg', '2023-12-10 17:50:27'),
(14, 'Antoine de Saint-Exupéry', '<div>Antoine de Saint-Exupéry est un écrivain, poète, aviateur et reporter français.</div>', '1900-06-29', '1944-07-31', 'antoine-de-saint-exupery-6575ee4acf494267210908.jpg', '2023-12-10 18:03:07'),
(15, 'Anne Robillard', '<div><strong>Anne Robillard</strong> est une écrivaine québécoise de fantasy.&nbsp;</div>', '1955-02-09', NULL, 'anne-robillard-6575f3eec317f516955336.jpg', '2023-12-10 18:22:54'),
(16, 'Sigmund Freud', '<div>Sigmund Freud, né le 6 mai 1856 à Freiberg et mort le 23 septembre 1939 à Londres, est un neurologue autrichien, fondateur de la psychanalyse.&nbsp;</div>', '1856-05-06', '1939-09-23', 'sigmund-freud-6575f69b0174b167751473.jpg', '2023-12-10 18:34:19');

--
-- Déchargement des données de la table `book`
--

INSERT INTO `book` (`id`, `added_by_id`, `last_edit_by_id`, `genre_id`, `title`, `description`, `isbn`, `publication`, `cover_picture`, `editor`, `added_at`, `last_edit_at`) VALUES
(1, NULL, NULL, 1, 'Les Misérables', '<div>Les Misérables est un roman de Victor Hugo publié en 1862, l’un des plus vastes et des plus notables de la littérature du XIXe siècle. Il décrit la vie de pauvres gens dans Paris et la France provinciale du premier tiers du XIXe siècle.&nbsp; C\'est un roman historique, social et philosophique dans lequel on retrouve les idéaux du romantisme et ceux de Victor Hugo concernant la nature humaine.&nbsp;<br><br></div>', '978-2-7011-64', '1862-04-03', 'les-miserables-6575ab77b1374705956668.jpg', 'Belin - Gallimard', '2023-12-10 13:13:43', '2023-12-10 13:16:37'),
(2, NULL, NULL, 3, 'Notre-Dame de Paris', '<div>Notre-Dame de Paris est un roman historique. Le titre fait référence à la cathédrale Notre-Dame de Paris, qui est un des lieux principaux de l\'intrigue du roman.<br><br></div>', '978-2-07-0663', '1831-03-16', 'notre-dame-de-paris-6575ae77bb2a5770566733.jpg', 'Gallimard jeunesse', '2023-12-10 13:26:31', '2023-12-10 13:26:31'),
(3, NULL, NULL, 4, 'Le Dernier Jour d\'un condamné', '<div>Le Dernier Jour d’un condamné est un roman de Victor Hugo qui constitue un plaidoyer politique pour l\'abolition de la peine de mort.&nbsp;</div>', '978-226619605', '1829-02-01', 'le-dernier-d-un-condamne-6575b2c8b05b1924439759.jpg', 'Pocket', '2023-12-10 13:44:56', '2023-12-10 13:45:57'),
(4, NULL, NULL, 1, 'Germinal', '<div>Germinal<strong><em> </em></strong>est un roman d\'Émile Zola publié en 1885. Écrit d\'avril 1884 à janvier 1885, le treizième roman de la série des Rougon-Macquart paraît d\'abord en feuilleton entre novembre 1884 et février 1885. Après sa première édition en mars 1885, le roman a été publié dans plus d\'une centaine de pays et adapté pour le cinéma et la télévision.&nbsp;</div>', '978-221076271', '1884-11-26', 'germinal-6575cc42b3374521193377.jpg', 'MAGNARD', '2023-12-10 15:33:38', '2023-12-10 15:33:38'),
(5, NULL, NULL, 5, 'Naruto tome 1', '<div>Naruto est un shōnen manga écrit et dessiné par Masashi Kishimoto. Naruto a été prépublié dans l\'hebdomadaire Weekly Shōnen Jump de l\'éditeur Shūeisha entre septembre 1999 et novembre 2014. La série a été compilée en 72 tomes. La version française du manga est publiée par Kana entre mars 2002 et novembre 2016.&nbsp;</div>', '978-2-87129-4', '2002-03-07', 'naruto-tome-1-6575cfeca0605974989854.jpg', 'Kana', '2023-12-10 15:49:16', '2023-12-10 15:49:16'),
(6, NULL, NULL, 6, 'Adtérix le Gaulois', '<div>Astérix le Gaulois est le premier album de la bande dessinée Astérix, publié en octobre 1961, scénarisé par René Goscinny et dessiné par Albert Uderzo.</div>', '978-201210133', '1959-10-29', 'asterix-le-gaulois-6575da2b5a6f6398007749.jpg', 'Dargaud', '2023-12-10 16:32:59', '2023-12-10 16:32:59'),
(7, NULL, NULL, 6, 'Astérix chez les Pictes', '<div>Astérix chez les Pictes est le trente-cinquième album de la bande dessinée Astérix, publié le 24 octobre 2013, scénarisé par Jean-Yves Ferri et dessiné par Didier Conrad.&nbsp;</div>', '978-286497266', '2013-10-24', 'axterix-chez-les-pictes-6575dfa70f289408951118.jpg', 'Les Éditions Albert René', '2023-12-10 16:56:23', '2023-12-10 16:56:23'),
(8, NULL, NULL, 6, 'L\'Iris blanc', '<div>L\'Iris blanc est le quarantième album de la bande dessinée Astérix, publié le 26 octobre 2023, scénarisé, pour la première fois, par Fabcaro et dessiné par Didier Conrad.&nbsp;</div>', '978-201400133', '2023-10-26', 'l-iris-blanc-6575e1a2daadb922773028.jpg', 'Les Éditions Albert René', '2023-12-10 17:04:50', '2023-12-10 17:04:50'),
(9, NULL, NULL, 1, 'Harry Potter à l\'école des sorciers', '<div>Harry Potter à l\'école des sorciers est le premier roman de la série littéraire centrée sur le personnage de Harry Potter, créé par J. K. Rowling. Sorti à Londres le 26 juin 1997. En 2000, le volume est adapté au cinéma.&nbsp;</div>', '978-207062452', '1998-10-09', 'harry-potter-a-l-ecole-des-sorciers-6575e4bd53185310226616.jpg', 'Gallimard Jeunesse', '2023-12-10 17:18:05', '2023-12-10 17:18:05'),
(10, NULL, NULL, 6, 'Les Aventures de Tintin - Le Secret de La Licorne', '<div>Le Secret de La Licorne est un album de bande dessinée, le onzième des <em>Aventures de Tintin</em>, créées par le dessinateur belge Hergé. Il constitue la première partie d\'un diptyque qui s\'achève avec Le Trésor de Rackham le Rouge.&nbsp;</div>', '978-220300110', '1943-10-05', 'le-secret-de-la-licorne-6575ec5337670698420727.jpg', 'Casterman', '2023-12-10 17:50:27', '2023-12-10 17:50:27'),
(11, NULL, NULL, 1, 'Le Petit Prince', '<div>Le Petit Princ<strong><em>e</em></strong> est une œuvre de langue française, la plus connue d\'Antoine de Saint-Exupéry. Publié 6 avril 1943 à New York simultanément à sa traduction anglaise, c\'est une œuvre poétique et philosophique sous l\'apparence d\'un conte pour enfants.</div>', '978-207075589', '1943-04-06', 'le-petit-prince-6575f0b6e2c98559893156.jpg', 'Gallimard', '2023-12-10 18:03:07', '2023-12-10 18:09:10'),
(12, NULL, NULL, NULL, 'Les Chevaliers d\'Émeraude - Le Journal d’Onyx', '<div>Le Journal d’Onyx est le sixième tome de la série fantasy d’Anne Robillard, Les Chevaliers d\'Émeraude. Il est paru le 20 octobre 2004 aux éditions Mortagne au Canada puis le 23 octobre 2008 aux éditions Michel Lafon en France.</div>', '979-102240026', '2004-10-20', 'le-journal-d-onyx-6575f34402448873732197.jpg', 'Michel Lafon Poche', '2023-12-10 18:20:03', '2023-12-10 18:20:04');

--
-- Déchargement des données de la table `author_book`
--

INSERT INTO `author_book` (`author_id`, `book_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(5, 4),
(6, 5),
(7, 6),
(7, 7),
(7, 8),
(8, 6),
(8, 7),
(8, 8),
(9, 7),
(10, 7),
(10, 8),
(11, 8),
(12, 9),
(13, 10),
(14, 11),
(15, 12);

--
-- Déchargement des données de la table `emotion`
--

INSERT INTO `emotion` (`id`, `label`, `emoji`) VALUES
(1, 'Happiness', ':)'),
(2, 'Sad', ':\'('),
(3, 'Choke', ':o'),
(4, 'Fear', ':o'),
(5, 'Unknown', '❔'),
(6, 'Bored', ':|'),
(7, 'Loved', ':)');

--
-- Déchargement des données de la table `reading_status`
--

INSERT INTO `reading_status` (`id`, `status`) VALUES
(1, 'Plan to Read'),
(2, 'Reading'),
(3, 'Drop'),
(4, 'Pause'),
(5, 'Completed');

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `username`, `blocked`, `registration_date`, `last_login_date`, `description`, `profile_picture`, `profile_picture_update`, `public`) VALUES
(12, 'root@root.root', '[\"ROLE_ADMIN\"]', '$2y$13$dc6jKveWT/3McIygsVzk0uMITKg/xqGT14ZObE9GyVU9N6ZgZ1R4C', 'Administrator', 0, '2023-12-11 14:44:12', '2023-12-11 14:44:12', NULL, '65771ae25a04d390138901.png', '2023-12-11 15:21:22', 0),
(16, 'john.doe@example.com', '[]', '$2y$13$FoBMTCn26j4xLbTidqtviOGC6q8nVwsrmzwOTxrkfRWneLVSkPWsS', 'John Smith', 0, '2023-12-11 15:08:47', '2023-12-11 15:08:47', 'Une desciption.', '657739844f510743989010.jpg', '2023-12-11 17:32:04', 0),
(17, 'contributor@example.com', '[\"ROLE_CONTRIBUTOR\"]', '$2y$13$wvDAjpIupfsDFRYMx/N4oumOZQnk8AKX713XmvwMppf0KeInaQUEa', 'Contributor', 0, '2023-12-11 15:09:49', '2023-12-11 15:09:49', NULL, NULL, NULL, 0),
(18, 'moderator@example.com', '[\"ROLE_MODERATOR\"]', '$2y$13$AjIFeLZAUvRV3UB3bsZBL.yLBbRgh3RUdD2CLo2AjhF2X9Lx/kmx.', 'Moderator', 0, '2023-12-11 15:17:11', '2023-12-11 15:17:11', NULL, NULL, NULL, 0);
COMMIT;

SET foreign_key_checks = 1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
