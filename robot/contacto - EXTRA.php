<?php
$path = "data.txt";
if (file_exists($path))
  $file = fopen($path, "r+");
else
  $file = fopen($path, "a+");
while ($data = fread($file,154)) {
  $array[] = explode('|',$data);
};

if (isset($_GET['get'])) {
  $curr = (int)$_GET['get'];
  $item = $array[$curr];
} else if (isset($_GET['delete'])) {
  $curr = (int)$_GET['delete'];
  fseek($file,$curr*154,SEEK_SET);
  fwrite($file,'');
  $array[$curr][0] = '';
  $item = array('','','','','','');
  $curr = 0;
} else if (isset($_GET['save'])) {
    $curr = (int)$_GET['save'];
    $item = array(str_pad($_GET['Nombre'],30),
                  str_pad($_GET['Cell'],30),
                  str_pad($_GET['WhatsApp'],30),
                  str_pad($_GET['Correo'],30),
                  str_pad($_GET['Direccion'],30));
    fseek($file,$curr*154,SEEK_SET);
    fwrite($file,implode('|',$item));
    $array[$curr] = $item;
} else if (isset($_GET['Agregar'])) {
  $item = array('','','','','','');
  $curr = sizeof($array);
};

fclose($file);

?>

<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//es" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
        <meta http-equiv="Content-Type"  content="text/html; charset=iso-8859-1" />
    <head>
<style>
body  {
  background-image: url("./images/1.png");
  background-repeat: no-repeat;
  background-color: #cccccc;
}
</style>
        <title>Mis Contactos Imborrables inolvidable.</title>
    </head>
    <body>
     <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
      <div style="width: 250px; float: left;">
        <h3>Todos los Contactos</h3>
        <table width="150" border=1>
          <?php
            for ($i=0;$i<sizeof($array);$i++) {
              if (trim($array[$i][0])!="**deleted**")
                echo '<tr><td><a href="?get='.$i.
                     '" style="text-decoration:none;">'.
                     $array[$i][0].'</a></td></tr>';
            }
          ?>
        </table>
        </p>
        <button name="Agregar" value="">+</button>
         <a href="contacto.php?Agregar=&Nombre=&Cell=&WhatsApp=&Correo=&Direccion=" >  <button type="button" borde=0/> Nuevo Contacto </button> </a href>
      </div>
      <div style="margin-left:250px;">
          <table>
            <tr><td>&nbsp;</td></tr>
            <tr><td><label>Nombre</label></td><td>
                <input name="Nombre" size="30" value="<?php echo $item[0]; ?>"/></td></tr>
            <tr><td><label>Cell</label></td><td>
                <input name="Cell" size="30" value="<?php echo $item[1]; ?>"/></td></tr>
            <tr><td><label>WhatsApp</label></td><td>
                <input name="WhatsApp" size="30" value="<?php echo $item[2]; ?>"/></td></tr>
            <tr><td><label>Correo</label></td><td>
                <input name="Correo" size="30" value="<?php echo $item[3]; ?>"/></td></tr>
            <tr><td><label>Direccion</label></td><td>
                <input name="Direccion" size="30" value="<?php echo $item[4]; ?>"/></td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td><a href="contacto.php?Agregar=&Nombre=&Cell=&WhatsApp=&Correo=&Direccion=" >  <button type="button" borde=0/> Actualizar </button> </a href></td>
                <td align="right">
                <button name="save" value="<?php echo $curr; ?>">Guardar</button></td></tr>
          </table>



        </div>
      </form>
    </body> 
</html>