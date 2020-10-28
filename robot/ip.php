<?php
	// Requerir información relevante para config.inc.php, incluidas funciones y acceso a la base de datos
	require_once("settings.config.inc.php");
	
	// Establezca $ page_name para que el título de cada página sea correcto
	$page_name = PAGENAME_LOGIN;
	
	// Cree una nueva instancia de registro y registre la vista de página en la base de datos
	$log = new Log('view');
	


	?>

	<body>
<a href="http://copen.atspace.tv/mail/index.php"><img src="http://copen.atspace.tv/spacer.gif" alt="Spider Robot" width="1" height="1"><a/>


