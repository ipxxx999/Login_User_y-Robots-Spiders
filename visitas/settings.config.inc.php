<?php
	
	// Compruebe si se ha creado un archivo de configuración personalizada con todas las constantes relevantes
	if(!file_exists("settings.local.inc.php")) {
		// Salida a la pantalla de que falta el archivo y no vaya más allá
		echo 'A config file could not be found. Please create a file inside the logos/ directory called "settings.local.inc.php".';
		echo '<br>';
		echo 'For an example file simply create a copy of the "settings.local.inc.php" and rename it to "settings.local.inc.php", you can then input the details relating to your set up.';
		die();
	};
	
	// Requiere el localsetting.inc.php
	require_once('settings.local.inc.php');
	
	// Compruebe que se hayan definido los ajustes necesarios para el funcionamiento del sistema.
	// Inicialice una matriz $ errors para almacenar cualquier error
	$errors = array();
	
	// Verifique que las constantes estén definidas
	if(!defined('DB_SERVER')) 	{ $errors[] = "DB_SERVER no está definido. Agregue lo siguiente como una nueva línea a sus logotipos/settings.local.inc.php file: <b>define('DB_SERVER', 'YOUR DATABASE IP/HOSTNAME');</b>"; };
	if(!defined('DB_USER')) 	{ $errors[] = "DB_USER no está definido. Agregue lo siguiente como una nueva línea a sus logotipos/settings.local.inc.php file: <b>define('DB_USER', 'YOUR DATABASE USERNAME');</b>"; };
	if(!defined('DB_PASS')) 	{ $errors[] = "DB_PASS no está definido. Agregue lo siguiente como una nueva línea a sus logotipos/settings.local.inc.php file: <b>define('DB_PASS', 'YOUR DATABASE USER PASSWORD');</b>"; };
	if(!defined('DB_NAME')) 	{ $errors[] = "DB_NAME no está definido. Agregue lo siguiente como una nueva línea a sus logotipos/settings.local.inc.php file: <b>define('DB_NAME', 'YOUR DATABASE NAME');</b>"; };
	if(!defined('SITE_URL')) 	{ $errors[] = "SITE_URL no está definido. Agregue lo siguiente como una nueva línea a sus logotipos/settings.local.inc.php file: <b>define('SITE_URL', 'YOUR SITE URL');</b>"; };

	// Envíe los errores a la pantalla si alguno está presente
	if(!empty($errors)) {
		echo '<p>Parece haber algunos problemas con su configuración. Revise los siguientes errores:</p>';
		echo '<ul>';
		foreach($errors as $error) {
			echo '- '. $error . '<br>';
		};
		echo '</ul>';
		echo '<p>Recuerde incluir toda la línea de ejemplo, pero reemplazando la información clave con la que se relacione con su sistema. También asegúrese de que el archivo settings.local.inc.php comience con la primera línea con <b>' . htmlspecialchars("<?php ") . '</b>. Sin esto, cualquier configuración que establezca ganó\'¡Funciona!</p>';
		die();
	}; // Cerrar si (! Vacío($errors))
	
	// Configure el controlador de la base de datos en MySQL
	define("DB_TYPE", "mysql");

	// Establecer nombres de página
	defined("PAGENAME_INDEX")						?	null	:	define("PAGENAME_INDEX", "Address Book");
	defined("PAGENAME_LOGIN")						?	null	:	define("PAGENAME_LOGIN", "Log In");
	defined("PAGENAME_LOGOUT")						?	null	:	define("PAGENAME_LOGOUT", "Log Out");
	defined("PAGENAME_USERS")						?	null	:	define("PAGENAME_USERS", "Users");
	defined("PAGENAME_USERSADD")					?	null	:	define("PAGENAME_USERSADD", "Add User");
	defined("PAGENAME_USERSDELETE")					?	null	:	define("PAGENAME_USERSDELETE", "Delete User");
	defined("PAGENAME_USERSUPDATE")					?	null	:	define("PAGENAME_USERSUPDATE", "Update User");
	defined("PAGENAME_LOGS")						?	null	:	define("PAGENAME_LOGS", "logos");
	defined("PAGENAME_CONTACTS")					?	null	:	define("PAGENAME_CONTACTS", "Contacts");
	defined("PAGENAME_CONTACTSADD")					?	null	:	define("PAGENAME_CONTACTSADD", "Add Contact");
	defined("PAGENAME_CONTACTSDELETE")				?	null	:	define("PAGENAME_CONTACTSDELETE", "Delete Contact");
	defined("PAGENAME_CONTACTSUPDATE")				?	null	:	define("PAGENAME_CONTACTSUPDATE", "Update Contact");
	defined("PAGENAME_CONTACTSVIEW")				?	null	:	define("PAGENAME_CONTACTSVIEW", "View Contact");
	defined("PAGENAME_API")							?	null	:	define("PAGENAME_API", "API");
	defined("PAGENAME_APIADD")						?	null	:	define("PAGENAME_APIADD", "Add API Token");
	defined("PAGENAME_APIDELETE")					?	null	:	define("PAGENAME_APIDELETE", "Delete API Token");
	defined("PAGENAME_APIUPDATE")					?	null	:	define("PAGENAME_APIUPDATE", "Update API Token");
	
	// Establecer enlaces de página
	defined("PAGELINK_INDEX")						?	null	:	define("PAGELINK_INDEX", "index.php");
	defined("PAGELINK_LOGIN")						?	null	:	define("PAGELINK_LOGIN", "login.php");
	defined("PAGELINK_LOGOUT")						?	null	:	define("PAGELINK_LOGOUT", "logout.php");
	defined("PAGELINK_USERS")						?	null	:	define("PAGELINK_USERS", "users.php");
	defined("PAGELINK_USERSDELETE")					?	null	:	define("PAGELINK_USERSDELETE", "delete-user.php");
	defined("PAGELINK_USERSUPDATE")					?	null	:	define("PAGELINK_USERSUPDATE", "update-user.php");
	defined("PAGELINK_LOGS")						?	null	:	define("PAGELINK_LOGS", "logs.php");
	defined("PAGELINK_CONTACTSADD")					?	null	:	define("PAGELINK_CONTACTSADD", "add-contact.php");
	defined("PAGELINK_CONTACTSDELETE")				?	null	:	define("PAGELINK_CONTACTSDELETE", "delete-contact.php");
	defined("PAGELINK_CONTACTSUPDATE")				?	null	:	define("PAGELINK_CONTACTSUPDATE", "update-contact.php");
	defined("PAGELINK_CONTACTSVIEW")				?	null	:	define("PAGELINK_CONTACTSVIEW", "view-contact.php");
	defined("PAGELINK_API")							?	null	:	define("PAGELINK_API", "api.php");
	defined("PAGELINK_APIADD")						?	null	:	define("PAGELINK_APIADD", "add-api.php");
	defined("PAGELINK_APIDELETE")					?	null	:	define("PAGELINK_APIDELETE", "delete-api.php");
	defined("PAGELINK_APIUPDATE")					?	null	:	define("PAGELINK_APIUPDATE", "update-api.php");
	
	// Zona horaria del servidor
	date_default_timezone_set("America/New_York");
	
	// Clases de carga automática para que se llamen cuando se requieran
	spl_autoload_register(function($class_name) { 
		$class_name = strtolower($class_name);
		include('class.' . $class_name . '.inc.php');
	});
	
	// Comience a ejecutar la sesión, ya que se requieren elementos en el constructor para que el sistema funcione correctamente
	$session = new Session();
	
	// Comience una nueva instancia de usuario, ya que verificará automáticamente los detalles del usuario si está conectado, etc.
	$user = new User();
	
	// Funciones del sitio
	require_once("functions.inc.php");
	
	


?>