<?php include("visitor2.php"); ?>"
<?php
//  Author:       Inoel Garcia 
//  Date:         4th January 2010
//  Last update:  10th January 2020
//
//  This transaction is intended to trap software agents (robots) that do not obey the rules defined 
//  in the robots.txt file (see http://www.robotstxt.org/). It records the details of the event; 
//  updates the .htaccess to bar access to the web site from the invoking IP address; and sends a
//  message to a given email address giving details of the event.
//
//  The robot trap is set by including a line in the robots.txt file which disallows access to a 
//  special directory, say robottrap.
//
//    User-agent: *
//    Disallow: /mail/
//    Disallow: /robot/mail/
//
//  See http://copen.atspace.tv/robots.txt for an example. Note that the new robots.txt file 
//  should be uploaded at tleast 24 hours before setting the trap as described below, to allow valid
//  robots to clear their cache of the old version. 
//
//  This transaction (robottrap.php) should be stored in the /robot/mail/ directory, and invoked,
//  preferably as both the first link and the last link, from the main page of your entry page in 
//  the form:
// 
//    <a href="/robot/mail/robottrap.php"></a> 
//
//  Note that there is no link text between <a> and </a>, meaning that only robots will find the 
//  link (although some so-called web accelerators may do so as well). 
//
//  Once the robot has invoked the transaction, the transaction first records the details of the 
//  in a text file located in a directory of your choice. The following details are stored:
// 
//    Date and time accessed
//    IP address
//    Domain name resolution of IP address
//    User agent 
//
//  You may need first to create an file called robotfile.txt in your chosen directory, and give it  
//  write access. Note, it is assumed that the directory is somewhere below the man website 
//  directory in the hierarchy. T
//
//  The transaction then updates the Apache .htaccess file to deny further access to the web site 
//  from that IP address. It assumes that the last lines of the Apache file are in the following 
//  format, and the new IP address is added to the end:
//
//    # Deny access to sites who have repeatedly broken the robot rules (automatically updated)
//    Order Allow,Deny
//    Allow from All
//    Deny from 173.227.230.236
//    Deny from 38.100.21.19
//
//  See http://copen.atspace.tv/mail/htaccess.shtml for an example of an .htaccess file.
//
//  You may need to give the .htaccess file write access first.
//
//  The transaction finally sends an email to the specified email address to report that a robot has
//  been trapped.
//
//  See also the script index2.php which issues a report of trapped robots, listed from the 
//  text file discussed above. An example of its use can be found here:
//
//    http://copen.atspace.tv/mail/index2.php
//
//  You can test the functionality of this script by invoking the transaction directly, but you will 
//  have to edit your .htaccess file afterwards, as your IP address will now be banned!
// 
//  ************************************************************************************************
// ESPANOL
// 
// 
// Esta transacción está destinada a atrapar agentes de software (robots) que no obedecen las reglas definidas
// en el archivo robots.txt (consulte http://www.robotstxt.org/). Registra los detalles del evento;
// actualiza el .htaccess para prohibir el acceso al sitio web desde la dirección IP que lo invoca; y envía un
// mensaje a una dirección de correo electrónico determinada dando detalles del evento.
//
// La trampa del robot se establece al incluir una línea en el archivo robots.txt que no permite el acceso a un
// directorio especial, digamos robottrap.
//
//    User-agent: *
//    Disallow: /mail/
//    Disallow: /robot/mail/
//
// Consulte http://copen.atspace.tv/robots.txt para ver un ejemplo. Tenga en cuenta que el nuevo archivo robots.txt
// debe cargarse al menos 24 horas antes de establecer la trampa como se describe a continuación, para permitir
// robots para borrar su caché de la versión anterior.
//
// Esta transacción (robottrap.php) debe almacenarse en el directorio /robot/mail/ e invocarse,
// preferiblemente como primer enlace y último enlace, desde la página principal de su página de entrada en
//  la forma:
//
// <a href="/robot/mail/robottrap.php"> </a>
//
// Tenga en cuenta que no hay texto de enlace entre <a> y </a>, lo que significa que solo los robots encontrarán el
// enlace (aunque algunos de los denominados aceleradores web también pueden hacerlo).
//
// Una vez que el robot ha invocado la transacción, la transacción primero registra los detalles del
// en un archivo de texto ubicado en un directorio de su elección. Se almacenan los siguientes detalles:
//
// Fecha y hora de acceso
//    Dirección IP
// Resolución de nombre de dominio de la dirección IP
//    Agente de usuario
//
// Es posible que primero deba crear un archivo llamado robotfile.txt en el directorio elegido y darle
// acceso de escritura. Tenga en cuenta que se supone que el directorio está en algún lugar debajo del sitio web man
// directorio en la jerarquía. T
//
// La transacción luego actualiza el archivo .htaccess de Apache para denegar más acceso al sitio web
// desde esa dirección IP. Asume que las últimas líneas del archivo Apache están en lo siguiente
// formato, y la nueva dirección IP se agrega al final:
//
// # Denegar el acceso a sitios que hayan infringido repetidamente las reglas del robot (actualizado automáticamente)
// Orden Permitir, Denegar
// Permitir de todos
// Denegar desde 173.227.230.236
// Denegar desde 38.100.21.19
//
// Consulte http://copen.atspace.tv/mail/htaccess.shtml para ver un ejemplo de un archivo .htaccess.
//
// Es posible que primero deba otorgar acceso de escritura al archivo .htaccess.
//
// La transacción finalmente envía un correo electrónico a la dirección de correo electrónico especificada para informar que un robot ha
// ha sido atrapado.
//
// Vea también el script index2.php que emite un informe de robots atrapados, enumerados en el
// archivo de texto discutido anteriormente. Un ejemplo de su uso se puede encontrar aquí:
//
// http://copen.atspace.tv/mail/index2.php
//
// Puede probar la funcionalidad de este script invocando la transacción directamente, pero lo hará
// tienes que editar tu archivo .htaccess después, ¡ya que tu dirección IP ahora estará prohibida!
//
//  ************************************************************************************************

//  The following lines of code should be modified to reflect your requirements
//  ===========================================================================

//  Las siguientes líneas de código deben modificarse para reflejar sus requisitos
// ================================================ ===========================

//  The mail address to which details of the naughty robots should be sent. replace with your email address
//  La dirección de correo electrónico a la que se deben enviar los detalles de los traviesos robots. reemplazar con su dirección de correo electrónico


//  The location of the robot text file as an offset from your root. It should match the same 
//  directory specified in the index2.php transaction. To place the data file in the home 
//  directory leave it as '/'. The directory should have write acesss. You may need first to create  
//  an empty file called robotfile.txt in this directory and give it write access.

// La ubicación del archivo de texto del robot como un desplazamiento de su raíz. Debería coincidir con el mismo
// directorio especificado en la transacción index2.php. Para colocar el archivo de datos en el hogar
// directorio déjelo como '/'. El directorio debe tener accesos de escritura. Es posible que primero necesite crear
// un archivo vacío llamado robotfile.txt en este directorio y darle acceso de escritura.

$directory = $_SERVER['DOCUMENT_ROOT'] . '/robot/';

// *************************************************************************************************

// Establish file path and name of the text file
// Establecer la ruta del archivo y el nombre del archivo de texto
$filename1 = $directory . 'robotfile.txt';


 
//  Extract the details of the the rogue robot hit 
//  Extrae los detalles del golpe del robot rebelde
$useragent = getenv("HTTP_USER_AGENT");
if ($useragent == "") { $useragent = "** unspecified **"; }
$ipaddress = getenv("REMOTE_ADDR");
$domainname = GetHostByAddr($ipaddress);
if ($domainname == "") {$domainname = "** unresolved **";}

//  Get the current date and time details
//  Obtener los detalles de fecha y hora actuales
	// Zona horaria del servidor
	date_default_timezone_set("America/New_York");
$date = date ('d/m/Y H:i:s');

//  Append the information to the robot file with the fields separated by a "|" character
//  Añade la información al archivo del robot con los campos separados por "|" carácter
$fp = fopen ($filename1, 'a+'); 
fwrite ($fp, "$date|$ipaddress|$domainname|$useragent|\n"); 
fclose ($fp);



//  Disabled Send the mail message to say that a robot has been trapped.
//  Desactivado Envía el mensaje de correo para decir que un robot ha sido atrapado.
$message  = "The following user agent has fallen into the robot trap: \n\n";
$message  = "  Date:           $date \n";
$message .= "  IP address:     $ipaddress \n";
$message .= "  Domain name:    $domainname \n";
$message .= "  User agent :    $useragent \n";


// Exit the transaction
exit;
?>
