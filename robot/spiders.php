<?php
	// Requerir información relevante para settings.config.inc.php, incluidas funciones y acceso a la base de datos
	require_once("settings.config.inc.php");
	
	// Establezca $ page_name para que el título de cada página sea correcto
	$page_name = PAGENAME_LOGS;

	
	// establecer $ datatables_required en 1 asegurará que esté incluido en el <head> en layout.head.inc.php y así el <script> se llama en el layout.footer.inc.php
	$datatables_required = 1;
	// ID de tabla para relacionarse con la tabla de datos, como se identifica en la <tabla> y en el <script>, necesario para identificar qué tablas convertir en tablas de datos
	$datatables_table_id = "bad_boot";
	// Configure la opción de tabla de datos para ordenar la primera columna en orden descendente
	// ascendente "asc" ASC 
	// descendente "desc" DESC
	$datatables_option = '"order": [[ 0, "desc" ]]';
	
	// Cree una nueva instancia de registro y registre la vista de página en la base de datos
	$log = new Log('view');
	
	// Obtenga todos los registros, utilizando solo los campos obligatorios, que se utilizarán para completar la tabla
	$bad_boot = $log->find_all();
	


?>
<!DOCTYPE html>

<html lang="es"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="http://copen.atspace.tv/ico/favicon.ico">
		<![endif]-->
    <head>
<style>
body  {
  background-image: url("./images/1.png");
  background-repeat: no-repeat;
  background-color: #cccccc;
}
</style>

<title>Robot Spam Blacklist - User Agent Strings - List of Crawler - Lista negra de robots spam - y Cadena de agente usuario - Lista de rastreadores</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="apple-mobile-web-app-title" content="Robot Spam" />
<meta property="article:published_time" content="2020-09-10T09:56:53-04:00" />
<meta property="article:modified_time" content="2020-09-10T09:56:53-04:00" />
<a href="http://copen.atspace.tv/mail/index.php"><img src="http://copen.atspace.tv/spacer.gif" alt="Spider Robot" width="1" height="1"></a>

<center>
<select name="forma" onchange="location = this.value;">
    <option value="index.php">Seleccionar</option>
    <option value="../visitas/index.php"> - Visitantes - </option>
    <option value="../robot/index.php"> - Babt-Boot - </option>
</select>
</center>

<p style="color: #000000; font-weight: bold; padding: 15px; border: 2px solid #000000; border-radius: 6px;"> <?php require_once("bandera.php");?> Localizar IP en un mapa </a>
<a class="nav-item nav-link" href="http://copen.atspace.tv/index.php" target="_blank">Geolocalizar IP</a> - Lista de rastreadores - </a>
<a class="nav-item nav-link" href="../robot/download.php?download_txt=1">Descargar htaccess</a> -  IP Address Block List - 
<a class="nav-item nav-link" href="../host.txt" target="_blank"> Ver host-txt </a> - Ver - </a>

			<!-- COMENTARIO -->
<!-- //  Hay varias formas de hacer eso, la que yo uso la uso porque es compatible con los buscadores de Internet (Google, Yahoo!, etc...):
<!- // <a href="ventana.php" target="_blank" onClick="window.open(this.href, this.target); return false;">Click aquí</a>

<!- // o bién:
<!- // <a href="ventana.php" target="_blank" onClick="window.open(this.href, this.target, 'width=XXX,height=YYY'); return false;">Click Aquí</a>
<!- // donde XXX es el ancho en pixels de la ventana que se abrirá e YYY es el alto.
			<!-- COMENTARIO FIN -->
<?php
?>
<a href="ver_htaccess-y-host.php" target="_blank" onClick="window.open(this.href, this.target, 'width=550,height=100'); return false;">&#218;tima Modificaci&#243;n</a> </p>
			

			<!-- CONTENT -->
			<?php $session->output_message(); ?>
			
			<table id="<?php echo $datatables_table_id; ?>">
				<thead>
					<tr>
					<table width="100%" border=1> 
					    <th>Fecha</th>
						<th>Acción</th>
						<th>Usuario</th>
						<th>Dirección IP</th>
						<th>PÁGINA RASTREADOR MALO</th>
						<th>Agente de Usuario o User Agent Strings</th>
					</tr>
				</thead>
				<tbody>
<?php
				// Recorra cada elemento obtenido de $ log-> find_all () y muéstrelos en el DataTable
				foreach($bad_boot as $log){
				?>

					<tr>
						<td><?php echo htmlentities($log["datetime"]); ?></td>
						<td><?php echo htmlentities($log["action"]); ?></td>
						<td><?php echo htmlentities($log["user"]); ?></td>
						<td>Verificar <a href="https://ip.openadmintools.com/en/<?php echo htmlentities($log["ip"]); ?>"  target=_blank><?php echo htmlentities($log["ip"]); ?></td>
						<td><?php echo htmlentities($log["url"]); ?></td>
						<td><?php echo htmlentities($log["user_agent"]); ?></td>
					</tr>
<?php
				// Cerrar el bucle foreach una vez que se haya mostrado el elemento final en $ bad_boot
				};
					?>
				</tbody>
			</table>
			<!-- /CONTENT -->


<?php include("visitor3.php"); ?>