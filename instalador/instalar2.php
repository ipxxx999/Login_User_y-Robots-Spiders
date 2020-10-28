<?php 
$mensaje="";
function crear_db($DBname, $sqlfile='bdcodeka.sql') {
	mysql_select_db($DBname);
	$mqr = @get_magic_quotes_runtime();
	@set_magic_quotes_runtime(0);
	$query = fread(fopen("./".$sqlfile, "r"), filesize("./".$sqlfile));
	@set_magic_quotes_runtime($mqr);
	$pieces  = split_sql($query);
	$errors = array();
	for ($i=0; $i<count($pieces); $i++) {
		$pieces[$i] = trim($pieces[$i]);
		if(!empty($pieces[$i]) && $pieces[$i] != "#") {
			if (!$result = mysql_query ($pieces[$i])) {
				$errors[] = array ( mysql_error(), $pieces[$i] );
			}
		}
	}
}

function split_sql($sql) {
	$sql = trim($sql);
	$sql = ereg_replace("\n#[^\n]*\n", "\n", $sql);

	$buffer = array();
	$ret = array();
	$in_string = false;

	for($i=0; $i<strlen($sql)-1; $i++) {
		if($sql[$i] == ";" && !$in_string) {
			$ret[] = substr($sql, 0, $i);
			$sql = substr($sql, $i + 1);
			$i = 0;
		}

		if($in_string && ($sql[$i] == $in_string) && $buffer[1] != "\\") {
			$in_string = false;
		}
		elseif(!$in_string && ($sql[$i] == '"' || $sql[$i] == "'") && (!isset($buffer[0]) || $buffer[0] != "\\")) {
			$in_string = $sql[$i];
		}
		if(isset($buffer[1])) {
			$buffer[0] = $buffer[1];
		}
		$buffer[1] = $sql[$i];
	}

	if(!empty($sql)) {
		$ret[] = $sql;
	}
	return($ret);
}

$DBhostname = trim($_POST[DBhostname]);
$DBusername = trim($_POST[DBusername]);
$DBpassword = trim($_POST[DBpassword]);
$DBname  	= trim($_POST[DBname]);
$correcto="si";
if (!($mysql_link = @mysql_connect( $DBhostname, $DBusername, $DBpassword ))) {
		$mensaje= "El usuario y la clave introducida son incorrectos<br>";
		$correcto="no"; }

if ($correcto=="si") {
	$var=$DBname.".*";
	$var2=$DBusername."@".$DBhostname;
	$consulta2="GRANT ALL PRIVILEGES ON $var TO $var2 IDENTIFIED BY $DBpassword WITH GRANT";
	$query2=mysql_query($consulta2);
	$consulta = "CREATE DATABASE $DBname";
	$query = mysql_query($consulta);
	$test = mysql_errno();

	if ($test <> 0 && $test <> 1007) {
		$mensaje= $mensaje."Error creando la base de datos. Error nº: ".$test."<br>";
		$correcto="no";
	}
	if ($correcto=="si")
	{
		if ($prueba==true) { crear_db($DBname,'bdcodeka.sql'); } else { crear_db($DBname,'bdcodeka.sql'); }
		$mensaje=$mensaje."La instalaci&#243;n de Code Anti-Robot 1.0 se ha realizado con &#233;xito. elimine los archivos de instalaci&#243;n";
		$fp = fopen("config.php", "w"); 
		if (!$fp)
			die(" ERROR: No se tiene acceso a fichero de configuracion: config.php. Instalacion a medias");
		fputs ($fp, "<?php\r\n"); 
		fputs ($fp, "\$Usuario=\"$DBusername\";\r\n");
		fputs ($fp, "\$Password=\"$DBpassword\";\r\n");
		fputs ($fp, "\$Servidor=\"$DBhostname\";\r\n"); 
		fputs ($fp, "\$BaseDeDatos=\"$DBname\";\r\n"); 
		fputs ($fp, "?>\r\n"); 

		fclose($fp);
		chmod("../config.php",0777);
	}
	else
	{
		$mensaje= $mensaje."Error la base de datos ya existe. Error nº: ".$test."<br>";
		$correcto="no";
	}
	}
	
if ($correcto=="si") { $img="cabcorrecto.jpg"; } else { $img="caberror.jpg"; }	
?>
<html>
<head>
<title>Code Anti-Robot 1.0</title>
    <link rel="shortcut icon" href="../instalador/images/favicon.png">
<link href="./css/estilos.css" type="text/css" rel="stylesheet">
<script language="javascript">

var cursor;
if (document.all) {
// Está utilizando EXPLORER
cursor='hand';
} else {
// Está utilizando MOZILLA/NETSCAPE
cursor='pointer';
}
						
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
}
.Estilo2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color:#FFFFFF;
	text-align:right;
}
-->
</style>
</head>
<body bgcolor="whitesmoke" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	  <div align="center">
			<table class="fuente8" width="100%" cellspacing=0 cellpadding=0 border=0 ID="Table1">
				<tr>
					<td width="35px" height="0" background="images/fondo.jpg"><div align="left"><img src="images/cabecera.jpg" width="438" height="35"></div></td>
				</tr>
				<tr>
					<td width="10px" height="0" background="images/fondo2.jpg"></td>
				</tr>
			</table>
		    <br>
		    <br>
	  </div>
		<div align="center">
			<table width="60%" class="fuente8" width="100%" cellspacing="0" cellpadding="0" bgcolor="ghostwhite" border="0" style="border-bottom-width:thin; border-right-width:thin">
			  <tr>
				  <td><img src="images/<? echo $img?>" align="left"></td>
			  </tr>
			  <tr>
				  <td width="10px" height="0" background="images/fondo2.jpg"></td>
			  </tr>			  
			  <tr>
				<td><br><p class="Estilo1"><? echo $mensaje; ?></p>
				<br></td>
			  </tr>
			  <tr>
				  <td width="10px" height="0" background="images/fondo2.jpg" class="estilo2">Version 1.0</td>
			  </tr>
			</table>									
		</div>
	</div>
  </div>			
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <? if ($correcto=="no") { ?>
  	 <td align="center"><img src="./images/botonatras.jpg" title="Atras" border="1" onClick="javascript:location.href='requisitos.php'" onMouseOver="style.cursor=cursor"></td>
<? } else { ?>
    <td align="center"><img src="./images/boton.jpg" title="Ejecutar Code Anti-Robot 1.0" border="1" onClick="javascript:location.href='instalar3.php'" onMouseOver="style.cursor=cursor"></td>
<? } ?>
  </tr>
</table>
</body>
</html>
