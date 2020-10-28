SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

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


CREATE TABLE users (
  id int(11) NOT NULL,
  email varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  password varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


ALTER TABLE `bad_boot`
  ADD PRIMARY KEY (boot_id);

ALTER TABLE visitas
  ADD PRIMARY KEY (vis_id);

ALTER TABLE users
  ADD PRIMARY KEY (id);


ALTER TABLE `bad_boot`
  MODIFY boot_id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE visitas
  MODIFY vis_id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE users
  MODIFY id int(11) NOT NULL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
