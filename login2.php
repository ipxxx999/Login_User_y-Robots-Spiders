<?php
include('header.php');

$msg = "";
$f = 0;
if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $sql = mysqli_query($conn, "SELECT * FROM `users` WHERE `email`='".$email."' ");
    if(mysqli_num_rows($sql) == 1){
        $u = mysqli_fetch_assoc($sql);
        $pass = md5($u['salt'].sha1($password));
        if($pass == $u['password']){
            $f = 1;
            $ip = $_SERVER['REMOTE_ADDR'];
            if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])) //cloudflare cdn detection
                $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
            mysqli_query($conn, "UPDATE `users` SET `log_ip`='".$ip."', `log_time`=NOW() WHERE `id` = '".$u['id']."' ");
            $_SESSION['uid'] = $u['id'];
            if( !headers_sent() && '' == session_id() ) {
                session_start();
                }
        }
    }

    if($f == 0)
        $msg = "<div class='alert alert-danger text-center'>Combinaci&#243n no v&#225;lida, int&#233;ntelo de nuevo.</div>";

}


?>
<div class="container" style="width:80%;margin:auto;">
    <div class="row justify-content-center" style="margin:50px 0px 20px 0px">
        <i class="registro"><h3>Entrar</h3></i>
    </div>
    <?php echo $msg ?>
    <div class="row justify-content-center" style="margin:20px 0px 20px 0px">
        <form class="text-center" action="login.php" method="post">
            <div class="form-group">
                          <i class="fas fa-user icon2"></i> <i class="estrella"> * </a></i>
                <input class="form-control" type="email" placeholder="Tu Correo Registrado" name="email" autofocus/>
                          <i class="fas fa-key icon"></i> <i class="estrella"> * </a></i>
                <input class="form-control" type="password" placeholder="Tu Contrase&#241;a" name="password" />
            </div>
            <div class="form-group">
                <button class="btn btn-primary" name="login" type="submit">INICIAR SESI&#211;N</button>
            </div>
            <p><a href="register.php"> &#191;No tienes cuenta? </a><i class="fas fa-shield-check icon"></i></p></p>
        </form>
    </div>


</div>
<?php include('footer.php') ?>