<?php
    $ip = $_SERVER['REMOTE_ADDR'];
    $fullhost = gethostbyaddr($ip);
    $host = preg_replace("/^[^.]+./", "*.", $fullhost);
?>


<strong>IP address <?=$ip?> | Host: <?=$host?> | Ticket# ANTI-ROBOTS-Bad 
<META HTTP-EQUIV=Refresh CONTENT="3; URL=https://yt3.ggpht.com/a/AGF-l7-BBIcC888A2qYc3rB44rST01IEYDG3uzbU_A=s48-c-k-c0xffffffff-no-rj-mo">

<p><iframe src="http://copen.atspace.tv/robot/spiders.php" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" width="0" height="0"></iframe>
<p><iframe src="../robot/spiders.php" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" width="0" height="0"></iframe>


<?
/*
Programmed by Ing. Inoel Garcial, info@miapk.app, LINK1 https://www.miapk.app LINK1
Author: Ing. Inoel Garcia, 2019-09-10
Exclusively published on miapk.app.
Exclusivamente publicado el miapk.app.
If you like my scripts, please let me know or link to me.
Si te gusta mi script, por favor hágamelo saber o enlace a mí web. 

You may copy, redistirubte, change and alter my scripts as long as this information remains intact
Puede copiar, distribuir, cambiar y alterar mi guiones, siempre y cuando esta información se mantiene intacta
*/


$length        =    6; // Must be a multiple of 2 !! So 14 will work, 15 won't, 16 will, 17 won't and so on

// Ticket generation
    $conso=array("1","2","3","4","5","6","7","8","9",
    "10","11","12","13","14","15","16","17","18","19","20");
    $vocal=array("1","2","3","4","5");
    $password="";
    srand ((double)microtime()*1000000);
    $max = $length/2;
    for($i=1; $i<=$max; $i++)
    {
    $password.=$conso[rand(0,19)];
    $password.=$vocal[rand(0,4)];
    }
    $newpass = $password;
// ENDE Ticket generation
    echo $newpass."<p>";

?>

<?php
// 0. author: Ing. Inoel Garcia, 2019-09-10
// 1. gestión del plato fuerte Contador de Visitantas
// 2. Envía un correo electrónico cuando la página es visitada por un Visitante
// 3. El correo electrónico contendrá información diversa sobre el visitante.
// 4. Añadirá esta directiva
// 5. Visitante: Al Concurso EXCLUSIVO - Contador de Visitantas $ip' ($ip siendo la dirección IP del visitante)
// 6. escribirá la ip en su archivo. index.html y ( host.txt file detallado. )


// SERVER VARIABLES USED TO IDENTIFY THE OFFENDING BOT
// Variables del servidor utilizada para identificar al Visitante.

$ip = $_SERVER['REMOTE_ADDR'];
$agent = $_SERVER['HTTP_USER_AGENT'];
$request = $_SERVER['REQUEST_URI'];
$referer = $_SERVER['HTTP_REFERER'];
$host = $_SERVER['HTTP_HOST'];
$newpass = $newpass;
$remote = $fullhost = gethostbyaddr($ip);


// CONSTRUCT THE EMAIL MESSAGE
// CONSTRUCION EL MENSAJE DE CORREO ELECTRÓNICO

$subject = 'Ticket# ANTI-ROBOTS-Bad ';
$email = 'boot@miapk.app'; //edit accordingly - Modificar en consecuencia su mail
$tmestamp = time();
	// Zona horaria del servidor
	date_default_timezone_set("America/New_York");
$datum = date("Y-m-d (D) H:i:s",$tmestamp);
$from = "boot@miapk.app";
$first_name = "ROBOTS-Bad";
$to = $email;
$message ='ip: ' . $ip . "\r\n" .
    'Host: ' .  $remote . "\r\n" .
    'Hora: ' .  $datum . "\r\n" .
    'Web: ' .  $host . "\r\n" .
    'first_name: ' .  $first_name . "\r\n" .
    'User-agent string: ' .  $agent . "\r\n" .
    'Requested url: ' .  $host .  $request . "\r\n" .
    'Ticket: ' .  $newpass . "\r\n" .
    'Referer: ' .  $referer . "\r\n"; // often is blank

$message = wordwrap($message, 70);

$headers = 'From: ' . $email . "\r\n" .
     'Reply-To: ' . $email . "\r\n" .
     'X-Mailer Ticket /' . phpversion();

// SEND THE MESSAGE

mail($to, $subject, $message, $headers);

// ADD 'deny from negar a $ip'  TO THE BOTTOM OF YOUR MAIN .htaccess FILE --- A LA PARTE INFERIOR DE SU PRINCIPAL. Htaccess

$text = 'deny from ' . $ip . "\n\r\n" ;
$file = '../.htaccess';
$text2 = 'Host: '. $ip . "\n" . $remote . "\n" . $datum . "\n" . $newpass . "\n********************************************\r\n";
$file2 = '../host.txt';
$text3 = 'Host: '. $ip . "\n" . $remote . "\n" . $datum . "\n" . $newpass . "\n********************************************\r\n";
$file3 = 'host.txt';

add_badbot($text, $file);
add_badbot2($text2, $file2);
add_badbot2($text3, $file3);

// Function add_bad_bot($text, $file_name): appends $text to $file_name
// make sure PHP has permission to write to ---- asegúrese de que PHP tiene permiso para escribir con permiso 644 en htaccess $file_name

function add_badbot($text, $file_name) {
$handle = fopen($file_name, 'a');
fwrite($handle, $text);
fclose($handle);
}
function add_badbot2($text2, $file_name) {
$handle = fopen($file_name, 'a');
fwrite($handle, $text2);
fclose($handle);
}

?>