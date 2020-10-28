<?php
include('header.php');
if($is_online){
    header("Location:index.php");
    exit();
}

$msg = "";
if(isset($_POST['reg'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);
    $pass1 = $_POST['pass1'];

    $sql = mysqli_query($conn, "SELECT `id` FROM `users` WHERE `email` = '".$email."' ") or die (mysqli_error($conn));
    if(mysqli_num_rows($sql) > 0)
        $msg = "<div class='alert alert-danger text-center'>Correo electr&#243;nico ya registrado, int&#233;ntelo de nuevo.</div>";
    else if($pass != $pass1)
        $msg = "<div class='alert alert-danger text-center'>Las Contrase&#241;a no coinciden. Int&#233;ntelo de nuevo.</div>";
    else{
        $ip = $_SERVER['REMOTE_ADDR'];
        if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])) //cloudflare cdn detection
            $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        $salt = rand(1000000, 99999999);
        $pass = md5($salt.sha1($pass));      
        mysqli_query($conn, "INSERT INTO users(`name`,`email`,`password`,`reg_ip`,`salt`) VALUES('".$name."', '".$email."', '".$pass."', '".$ip."', '".$salt."') ") or die (mysqli_error($conn));
        $msg = "<div class='alert alert-success text-center'>Registrado exitosamente, puede iniciar sesi&#243;n ahora. </div>";
    }

}

?>
<div class="container" style="width:80%;margin:auto;">
    <div class="row justify-content-center" style="margin:50px 0px 20px 0px">
        <i class="registro"><h3>Registrarse</h3></i>
        
    </div>
    <?php echo $msg ?>
    <div class="row justify-content-center" style="margin:20px 0px 20px 0px">
        <form class="text-center" action="register.php" method="post">
            <div class="form-group">

                          <i class="fas fa-user icon2"></i> <i class="estrella"> * </a></i>
                <input class="form-control" type="text" placeholder="Tu Nombre" name="name" required autofocus/> 

                          <i class="fas fa-envelope icon2"></i> <i class="estrella"> * </a></i>
                <input class="form-control" type="email" placeholder="Tu Direcci&#243;n de Correo" name="email" required/> 

                          <i class="fas fa-key icon3"></i> <i class="estrella"> * </a></i>
                <input class="form-control" type="password" placeholder="Tu Contrase&#241;a" name="pass" required/> 

                          <i class="fas fa-eye-slash icon4"></i> <i class="estrella"> * </a></i>
                <input class="form-control" type="password" placeholder="Confirma Contrase&#241;a" name="pass1" required/> 
            </div>

            <div class="form-group">
                <button class="btn btn-primary" name="reg" type="submit"> REGISTRARME</button>
                <input type="reset" class="btn btn-default" value="Borrar">
            </div>
            <p><a href="login2.php"> &#191;Ya tienes cuenta? </a><i class="fas fa-shield-check icon"></i></p>.</p>
        </form>
    </div>


</div>
<?php include('footer.php') ?>