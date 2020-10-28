<?php
  include('../db.php');
  if( !headers_sent() && '' == session_id() ) {
    session_start();
    }
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

