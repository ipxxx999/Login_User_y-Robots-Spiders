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
				
function enviar() {
	var mensaje="";
	if (document.getElementById("DBhostname").value=="") { mensaje= mensaje + " - Nombre del servidor\n"; }
	if (document.getElementById("DBusername").value=="") { mensaje= mensaje +" - Nombre del usuario\n"; }
	//if (document.getElementById("DBpassword").value=="") { mensaje= mensaje +" - Contraseña\n"; }
	if (document.getElementById("DBname").value=="") { mensaje= mensaje +" - Nombre de la base de datos\n"; }
	
	if (mensaje=="") {
		document.getElementById("form").submit();
	} else {
		alert ("Debe rellenar todos los campos. Ha dejado en blanco los siguientes valores:\n" + mensaje);
	}
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
				  <td><img src="images/cab3.jpg" align="left"></td>
			  </tr>
			  <tr>
				  <td width="10px" height="0" background="images/fondo2.jpg"></td>
			  </tr>			  
			  <tr>
				<td><form action="instalar2.php" method="post" name="form" id="form">
<table width="609" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td><br><table width="100%" border="0" align="center" cellpadding="0" cellspacing="4">
              <tr> 
                <td colspan="2"><p class="Estilo1">Para el funcionamiento de Code Anti-Robot 1.0 debe rellenar correctamente el siguiente formulario:
                <a " href="ejemplo.html" target="_blank"><strong>ver ejemplo</strong></a>
              </p></td>
              </tr>
              <tr> 
                <td width="35%" class="Estilo1">Servidor 
                  de Base de Datos</td>
                <td width="65%" align="left"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                  <input class="inputbox" type="text" name="DBhostname" id="DBhostname" placeholder="localhost"/>
                  </font></td>
              </tr>
              <tr> 
                <td class="Estilo1">Usuario 
                  MySQL</td>
                <td align="left"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                  <input name="DBusername" type="text" class="inputbox" id="DBusername" placeholder="3579670_pepe"/>
                  </font></td>
              </tr>
              <tr> 
                <td class="Estilo1">Contrase&ntilde;a 
                  MySQL</td>
                <td align="left"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                  <input class="inputbox" type="password" name="DBpassword" id="DBpassword" placeholder="Tu-password"/>
                  </font></td>
              </tr>
              <tr> 
                <td class="Estilo1">Nombre 
                  de la BD MySQL</td>
                <td align="left"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                  <input class="inputbox" type="text" name="DBname" id="DBname" placeholder="3579670_pepe" />
                  </font></td>
              </tr>
			</td>
        </tr>
      </table>
      <p></p>
</td>
  </tr>
</table>
</form></td>
			  </tr>
			  <tr>
				  <td width="10px" height="0" background="images/fondo2.jpg" class="estilo2">Version 1.0</td>
			  </tr>
			</table>									
  </div>			
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	 <td align="right"><img src="./images/botonatras.jpg" title="Atras" border="1" onClick="javascript:location.href='requisitos.php'" onMouseOver="style.cursor=cursor"></td>
    <td align="left"><img src="./images/boton.jpg" title="Siguiente" border="1" onClick="enviar()" onMouseOver="style.cursor=cursor"></td>
  </tr>
</table>
</body>
