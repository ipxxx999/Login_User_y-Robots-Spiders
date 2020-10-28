SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


-- --------------------------------------------------------

CREATE TABLE `bad_boot` (
  boot_id int(11) NOT NULL,
  datetime datetime DEFAULT NULL,
  action longblob,
  url varchar(200) DEFAULT NULL,
  user varchar(200) DEFAULT NULL,
  ip varchar(200) DEFAULT NULL,
  user_agent varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE visitas (
  vis_id int(11) NOT NULL,
  datetime datetime DEFAULT NULL,
  action longblob,
  url varchar(200) DEFAULT NULL,
  user varchar(200) DEFAULT NULL,
  ip varchar(200) DEFAULT NULL,
  user_agent varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


ALTER TABLE `bad_boot`
  ADD PRIMARY KEY (boot_id);

ALTER TABLE visitas
  ADD PRIMARY KEY (vis_id);


ALTER TABLE `bad_boot`
  MODIFY boot_id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE visitas
  MODIFY vis_id int(11) NOT NULL AUTO_INCREMENT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

