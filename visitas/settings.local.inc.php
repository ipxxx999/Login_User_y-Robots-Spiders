<?php	
	// La IP / nombre de host del servidor MySQL / TuDB
	defined("DB_SERVER")    	?	null	:	define("DB_SERVER", "fdb30.atspace.me");
	// El nombre de usuario de la cuenta que tiene acceso a la base de datos en el servidor MySQL / TuDB
	defined("DB_USER")			?	null	:	define("DB_USER", "3579670_michat");
	// La contraseña (si la hubiera) asociada con la cuenta DB_USER
	defined("DB_PASS")			?	null	:	define("DB_PASS", "mistica123");
	// El nombre de la base de datos (si importó el archivo sql.sql y no cambió ninguna configuración, entonces será logoip)
	defined("DB_NAME")			?	null	:	define("DB_NAME", "3579670_michat");
	// La URL del sitio: la dirección que debe visitar para acceder al sistema
	defined("SITE_URL")			?	null	:	define("SITE_URL", "http://copen.atspace.tv/visitas/");