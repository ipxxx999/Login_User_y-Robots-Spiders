<?php
$images = array(
                '../../robot/bandera/Canada.gif',
                '../../robot/bandera/Bolivia.gif',
                '../../robot/bandera/Brasil.gif',
                '../../robot/bandera/Argentina.gif',
                '../../robot/bandera/Francia.gif',
                '../../robot/bandera/Grecia.gif',
                '../../robot/bandera/Guatemala.gif',
                '../../robot/bandera/Honduras.gif',
                '../../robot/bandera/Jamaica.gif',
                '../../robot/bandera/Japon.gif',
                '../../robot/bandera/Mexico.gif',
                '../../robot/bandera/Nicaragua.gif',
                '../../robot/bandera/Panama.gif',
                '../../robot/bandera/Peru.gif',
                '../../robot/bandera/bandera.gif',
                '../../robot/bandera/Chile.gif'
        );
        	// Zona horaria del servidor
	date_default_timezone_set("America/New_York");
$jour = (int)date('Ymd');
$count = count($images)-1;
srand($jour);
echo 'Bandera del D&#237;a:<br /><img src="'.$images[rand(0,$count)].'" title="Bandera de Paises Participantes" alt="Bandera de Paises Participantes" />';

?>