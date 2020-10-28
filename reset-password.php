<?php
  include('db.php');
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

    $sql = mysqli_query($conn, "SELECT `id` FROM `users` WHERE `email` = '".$email."' ") or die (mysqli_error($conn));
    if(mysqli_num_rows($sql) > 0){
  }

?>

<?php 

    function ___onTarget()
    {
        if ($_REQUEST['action'] == 'register') {
            $GLOBALS['core']->event('register');
            //validation
            if (empty($_REQUEST['name'])) {
                $GLOBALS['err']->add("Name can't be blank.", array('name', 'register'));
            }
            if (user::exists($_REQUEST['name'])) {
                $GLOBALS['err']->add("Name already exists. choose another.", array('name', 'register'));
            }
            if (empty($_REQUEST['password1'])) {
                $GLOBALS['err']->add("Password can't be blank.", array('password1', 'register'));
            } elseif ($_REQUEST['password1'] != $_REQUEST['password2']) {
                $GLOBALS['err']->add("Passwords don't match.", array('password2', 'register'));
            } elseif ($_REQUEST['password1'] == $_REQUEST['password2'] && $GLOBALS['err']->none()) {
                //logout first, just in case
                if (user::whoAmI() == 'temp') {
                    user::logout();
                }
                if (user::register($_REQUEST['name'], $_REQUEST['password1'])) {
                    session_regenerate_id();
                    //sort of prevent session-hijacking
                    $_REQUEST['password'] = $_REQUEST['password1'];
                    $_REQUEST['action'] = 'login';
                    $GLOBALS['state'] = 'successful registration';
                    $GLOBALS['core']->event('registrationSuccess');
                } else {
                    $GLOBALS['err']->add("Unable to register for some reason. Please let us know about it.", 'registration');
                    $GLOBALS['core']->event('registrationFailure');
                }
            }
        }
        if ($_REQUEST['action'] == 'login') {
            $GLOBALS['core']->event('login');
            if (empty($_REQUEST['name'])) {
                $GLOBALS['err']->add("You left out the name.", array('name', 'login'));
            }
            if (empty($_REQUEST['password'])) {
                $GLOBALS['err']->add("You left out the password.", array('password', 'login'));
            }
            if (!empty($_REQUEST['name']) && !empty($_REQUEST['password'])) {
                if (!user::login($_REQUEST['name'], $_REQUEST['password'])) {
                    $GLOBALS['err']->add("Wrong.", 'login');
                } else {
                    $loginSuccess = true;
                    session_regenerate_id();
                    //prevent session hijacking.
                }
            }
            $GLOBALS['core']->event($loginSuccess ? 'loginSuccess' : 'loginFailure');
        }
        if ($_REQUEST['action'] == 'logout') {
            $GLOBALS['core']->event('logout');
            session_regenerate_id(true);
            //kill old session.
            user::logout();
            header("Location: /");
            exit;
        }
        if (!user::loggedIn()) {
            //login as temp user
            //user::loginTemp();
        }
    }


$msg = "";

if(isset($_POST['cpass'])){
    $currpass = mysqli_real_escape_string($conn, $_POST['pass']);
    $currpass = md5($udata['salt'].sha1($currpass));
    $pass1 = mysqli_real_escape_string($conn, $_POST['pass1']);
    $pass2 = mysqli_real_escape_string($conn, $_POST['pass2']);

    if($currpass != $udata['password']){
        $msg = "<div class='alert alert-danger text-center'>Contrase&#241;a actual no v&#225;lida, int&#233;ntelo de nuevo.</div>";
    }else if($pass1 != $pass2){
        $msg = "<div class='alert alert-danger text-center'>Las nuevas Contrase&#241;as no coinciden. Int&#233;ntelo de nuevo.</div>";
    }else{
        $salt = rand(1000000, 99999999);
        $pass1 = md5($salt.sha1($pass1));  
        mysqli_query($conn, "UPDATE `users` SET `password`='".$pass1."', `salt`='".$salt."'  WHERE `id`='".$udata['id']."' ");
        $msg = "<div class='alert alert-success text-center'>Contrase&#241;a cambiada con &#233;xito.</div>";
    }
}



?>
<div class="container" style="width:80%;margin:auto;">
    <div class="row justify-content-center" style="margin:50px 0px 20px 0px">
        <h3>BIENVENID@, <?php echo $udata['name'] ?>!</h3>
    </div>
    <?php echo $msg ?>
    <div class="row justify-content-center" style="border: 1px solid #555;padding:20px;text-align:center;border-radius:5px;">
        <form action="reset-password.php" method="post" style="width:70%;margin:auto;">
            <span style="font-size:21px;">Change Password</span>
            <div class="form-group" style="margin-top:15px;">
                <input class="form-control" type="password" name="pass" placeholder="Enter Current Password" required/>
            </div>
            <div class="form-group">
                <input class="form-control" type="password" name="pass1" placeholder="Enter New Password" required/>
                <input class="form-control" type="password" name="pass2" placeholder="Re-Enter New Password" required/>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit" name="cpass" />
            </div>
        </form>
    </div>
</div>
<?php include('footer.php') ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./css_js/css/bootstrap.min.css">