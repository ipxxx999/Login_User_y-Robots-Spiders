<?php
$images = array(
                '../visitas/bandera/Canada.gif',
                '../visitas/bandera/Bolivia.gif',
                '../visitas/bandera/Brasil.gif',
                '../visitas/bandera/Argentina.gif',
                '../visitas/bandera/Francia.gif',
                '../visitas/bandera/Grecia.gif',
                '../visitas/bandera/Guatemala.gif',
                '../visitas/bandera/Honduras.gif',
                '../visitas/bandera/Jamaica.gif',
                '../visitas/bandera/Japon.gif',
                '../visitas/bandera/Mexico.gif',
                '../visitas/bandera/Nicaragua.gif',
                '../visitas/bandera/Panama.gif',
                '../visitas/bandera/Peru.gif',
                '../visitas/bandera/bandera.gif',
                '../visitas/bandera/Chile.gif'
        );
        	// Zona horaria del servidor
	date_default_timezone_set("America/New_York");
$jour = (int)date('Ymd');
$count = count($images)-1;
srand($jour);
echo 'Bandera del D&#237;a:<br /><img src="'.$images[rand(0,$count)].'" title="Bandera de Paises Participantes" alt="Bandera de Paises Participantes" />';

?>