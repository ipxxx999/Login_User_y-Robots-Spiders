<?php
  include('db.php');
  session_start();
  $is_online = false;
  if(isset($_SESSION['uid'])){
    $sql = mysqli_query($conn, "SELECT * FROM `users` WHERE `id` = '".$_SESSION['uid']."' ");
    if(mysqli_num_rows($sql) == 1){
      $is_online = true;
      $udata = mysqli_fetch_assoc($sql);
      mysqli_query($conn, "UPDATE `users` SET `log_time`=NOW() WHERE `id` = '".$udata['id']."' ");
    }else
      session_destroy();
  }


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0, maximum-scale=3.0, minimum-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./css_js/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css_js/css/estilos.css">
    <link rel="stylesheet" href="./css_js/css/pro.min.css" >


    <title> [ Iniciar sesi&#243;n Registrarse ] - </title>
    <link rel="shortcut icon" href="./css_js/ico/favicon.ico" />
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="index2.php"><i class="fas fa-home-alt icon2"></i> Entrar o/Registrarse </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMarkup" aria-controls="navbarMarkup" aria-expanded="false">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarMarkup">
        <div class="navbar-nav">

            
          <?php if(!$is_online){ ?>
          <a class="nav-item nav-link" href="login2.php"> <i class="fas fa-user icon5"> </i>INICIAR SESI&#211;N</a>
          <a class="nav-item nav-link" href="register.php"><i class="fas fa-key icon3"></i>REG&#205;STRATE</a>

          <?php }else{ ?>
          <a class="nav-item nav-link" href="logout.php"><i class="fas fa-portal-exit icon6"></i>Cerrar Sesi&#243;n</a>
          <a class="navbar-brand" href="./visitas/index.php" target="_blank"> <i class="fas fa-check-circle icon7"></i> <?php echo $udata['name'] ?><i class="fas fa-portal-enter icon5"></i> Entra Aqu&#237;</a>
          <?php } ?>
        </div>
      </div>
    </nav>

