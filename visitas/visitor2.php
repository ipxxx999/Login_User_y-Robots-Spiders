<?php
//  This transaction lists the details of robots that have fallen into the robot trap. The details 
//  were recorded in the text file 'robotfile.txt'. 
// 
//  See also the script robottrap.php which records the information.
// 
//  Author:       Inoel Garcia 
//  Date:         4th January 2010
//  Last update:  10th January 2020
//
//  Note that you can click on the IP addresses in the report to find out more about them.

//  ************************************************************************************************

//  The following line of code should be modified to reflect your requirements
//  ==========================================================================

//  ============================= ESPAÑOL ====================================
//  ==========================================================================

// Esta transacción enumera los detalles de los robots que han caído en la trampa del robot. Los detalles
// se registraron en el archivo de texto 'robotfile.txt'.
//
// Vea también el script robottrap.php que registra la información.
//
// Autor: John Gardner
// Fecha: 8 de enero de 2007
// Actualizado: 24 de enero de 2012
//
// Tenga en cuenta que puede hacer clic en las direcciones IP en el informe para obtener más información sobre ellas.

// ********************************************** **********************************************

// La siguiente línea de código debe modificarse para reflejar sus requisitos
// ================================================ ==========================

// The location of the robot text file as an offset from your main website directory
// La ubicación del archivo de texto del robot como un desplazamiento del directorio de su sitio web principal
$directory = $_SERVER['DOCUMENT_ROOT'] . '/visitas/';

// *************************************************************************************************

// Extract the records in reverse order from the file and store in an array
// Extraiga los registros en orden inverso del archivo y almacénelos en una matriz
$robots = array_reverse (file ($directory.'robotfile.txt'));

// Count of robots recorded
// Recuento de robots registrados
$no_robots = count ($robots);

?>


<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
<meta http-equiv="Content-Type"  content="text/html; charset=iso-8859-1" />

<head>
   
<style type="text/css">
<!--
body {
  background-color: #d0e7ff;
  color: #000;
  font-family: Arial, Verdana, Sans;
  font-size: 80%;
  margin-left: 20px; margin-right: 20px;
}

em {font-weight: bold;}

h1 {
  font-size: 130%;
  color: #0500ff;
  background-color: inherit;
  font-family: Times Roman, Serif;
  text-align: center;
}

table {
  margin: 10px;
  background-color: #ccc;
  color: inherit;
  font-size: 100%;
  border-color: #ccc;
  border-style: solid;
  border-width: 2px;
}

td {
  padding-left: 5px;
  padding-right: 5px;
  border-color: #ccc;
  border-style: solid;
  border-width: 1px;
  background-color: #fff;
  color: inherit;
  font-size: 90%;
}

.tdright {text-align: right;}
.tdleft {text-align: left;}

.trtitle {background-color: #cfcfff; color: inherit;}

.footer {	
  text-align: center;
  font-size: 12px;
  padding-top: 0px;
  color: #0500ff;
  background-color: inherit;
}
-->
</style>
</head>

<body>
<meta http-equiv="Content-Type"  content="text/html; charset=iso-8859-1" />
<h1>Registro de Visitantes</h1>

<!-- //  ===================== PUEDES BORRAR A PARTIR DE AQUÍ =====================
     //  ========================================================================== -->

<center> 
</p> <strong>Lista de Visitantes </strong> <a href="../visitas/index.php">Regrezar</a> </p> 


</center> 

<!-- //  ==================== PUEDES BORRAR DESDE AQUÍ ARRIBA =====================
     //  ========================================================================== -->


<p><strong>Al hacer clic en la direcci&#243;n IP, aparecer&#225; m&#237;s informaci&#243;n sobre esa IP.</strong></p> 

<div style="text-align: center;">
  <table summary="Lista de robots rebeldes" rules="all">
    <tr style="font-weight: bold"><td>Fecha</td><td>Direcci&#243;n IP</td><td>Nombre de dominio</td><td>User Agent - Agente de usuario</td></tr>
<?php
// Para cada registro, div�dalo en sus campos componentes y visual�celo.
for ($i = 0; $i<$no_robots; $i++) {
  $line = explode ('|', $robots[$i]);
  $line[0] = substr ($line[0],0,19);
  echo "      <tr> \n";
  echo "        <td class=\"tdleft\">$line[0]</td> \n";
  echo "        <td class=\"tdleft\"><a style=\"color: black; text-decoration: none;\" href=\"http://whois.domaintools.com/$line[1]\" target=\"_blank\">$line[1]</a></td> \n";
  echo "        <td class=\"tdleft\">$line[2]</td> \n";
  echo "        <td class=\"tdleft\">".htmlspecialchars($line[3])."</td> \n";
  echo "      </tr> \n";
}
echo "  </table> \n";
echo "</div> \n\n";
$script = $_SERVER["SCRIPT_NAME"];
$break = Explode('/', $script);
$script = $break[count($break) - 1]; 
	// Zona horaria del servidor
        // Server time zone
	date_default_timezone_set("America/New_York");
echo "<p class=\"footer\">&#218;ltima actualizaci&#243;n: ". date("j F Y H:i:s",filemtime($script)) . "</p> \n\n"; 
echo "</body>\n</html>\n";
?>