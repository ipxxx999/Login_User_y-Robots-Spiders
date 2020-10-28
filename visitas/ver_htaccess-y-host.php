<?php

// muestra, p.ej.  La última modificación de htaccess.txt fue: December 29 2002 22:16:23.

$nombre_archivo = '../robot/.htaccess';
if (file_exists($nombre_archivo)) {
        	// Zona horaria del servidor
	date_default_timezone_set("America/New_York");
    echo "La &#250;ltima modificaci&#243;n de $nombre_archivo fue: " . date("F d Y H:i:s.", filectime($nombre_archivo));
}

?>
<P>
<?php

// muestra, p.ej.  La última modificación de host.txt fue: December 29 2002 22:16:23.

$nombre_archivo = '../robot/host.txt';
if (file_exists($nombre_archivo)) {
        	// Zona horaria del servidor
	date_default_timezone_set("America/New_York");
    echo "La &#250;ltima modificaci&#243;n de $nombre_archivo fue: " . date("F d Y H:i:s.", filectime($nombre_archivo));
}

?>


<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

		<meta http-equiv="X-UA-Compatible" content="chrome=1">
<center>
    <script charset="utf-8" src="./most/anima.js"></script></head>
    <body>
	
<canvas id="world" width="1235" height="820" style="position: absolute; left: 0px; top: 0px;"></canvas>

</div>
<script src="./most/bakemono.js"></script>