<?php
	// Requerir información relevante para settings.config.inc.php, incluidas funciones y acceso a la base de datos
	require_once("settings.config.inc.php");
	
	// Establezca $ page_name para que el título de cada página sea correcto
	$page_name = PAGENAME_LOGS;

	
	// establecer $ datatables_required en 1 asegurará que esté incluido en el <head> en layout.head.inc.php y así el <script> se llama en el layout.footer.inc.php
	$datatables_required = 1;
	// ID de tabla para relacionarse con la tabla de datos, como se identifica en la <tabla> y en el <script>, necesario para identificar qué tablas convertir en tablas de datos
	$datatables_table_id = "logs";
	// Configure la opción de tabla de datos para ordenar la primera columna en orden descendente
	$datatables_option = '"order": [[ 0, "desc" ]]';
	
	// Cree una nueva instancia de registro y registre la vista de página en la base de datos
	$log = new Log('view');
	
	// Obtenga todos los registros, utilizando solo los campos obligatorios, que se utilizarán para completar la tabla
	$logs = $log->find_all();
	


?>

<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//es" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
        <meta http-equiv="Content-Type"  content="text/html; charset=iso-8859-1" />
    <head>
<style>
body  {
  background-image: url("./images/1.jpg");
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


<p style="color: #ffffff; font-weight: bold; padding: 15px; border: 2px solid #000000; border-radius: 6px;">Lista negra de robots spam y cadena de agente usuario. - Lista de rastreadores -- Robot Spam Blacklist - User Agent Strings - List of Crawler</p>
			

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
						<th>Agente de Usuario o User Agent Strings</th>
					</tr>
				</thead>
				<tbody>
<?php
				// Recorra cada elemento obtenido de $ log-> find_all () y muéstrelos en el DataTable
				foreach($logs as $log){
				?>

					<tr>
						<td><?php echo htmlentities($log["datetime"]); ?></td>
						<td><?php echo htmlentities($log["action"]); ?></td>
						<td><?php echo htmlentities($log["user"]); ?></td>
						<td><a href="https://ip.openadmintools.com/en/<?php echo htmlentities($log["ip"]); ?>"  target=_blank><?php echo htmlentities($log["ip"]); ?></td>
						<td><?php echo htmlentities($log["user_agent"]); ?></td>
					</tr>
<?php
				// Cerrar el bucle foreach una vez que se haya mostrado el elemento final en $ logs
				};
					?>
				</tbody>
			</table>
			<!-- /CONTENT -->

