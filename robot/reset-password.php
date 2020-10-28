﻿<?php
// Initialize the session
// Inicializar la sesión
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
// Verifique si el usuario ha iniciado sesión; de lo contrario, redirija a la página de inicio de sesión
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
// Incluir archivo de configuración
require_once "../config.php";
 
// Define variables and initialize with empty values
// Definir variables e inicializar con valores vacíos
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
// Procesando los datos del formulario cuando se envía el formulario
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    // Validar nueva contraseña
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "La contrase&#241;a al menos debe tener 6 caracteres.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    // Validar confirmar contraseña
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Por favor confirme la contrase&#241;a.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Las contrase&#241;as no coinciden.";
        }
    }
        
    // Check input errors before updating the database
    // Verifique los errores de entrada antes de actualizar la base de datos
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        // Preparar una declaración de actualización
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            // Vincular variables a la declaración preparada como parámetros
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            // Establecer parámetros
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            // Intente ejecutar la declaración preparada
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                // Contraseña actualizada exitosamente. Destruye la sesión y redirige a la página de inicio de sesión
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Algo saliÃ³ mal, por favor vuelva a intentarlo.";
            }
        }
        
        // Close statement
        // Cerrar declaración
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    // fin de conexión
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cambia tu contrase&#241;a¡</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<center>
<body>
    <div class="wrapper">
        <h2>Cambias tu contrase&#241;a </h2>
        <p>Complete este formulario para restablecer su contrase&#241;a.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>Nueva contrase&#241;a</label>
                <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>"  placeholder="Ingresa Nueva contrase&#241;a" autofocus>
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirmar contrase&#241;a</label>
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirmar Nueva contrase&#241;a">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Cambio">
                <a class="btn btn-link" href="index.php">Cancelar</a>
            </div>
        </form>
    </div> 
</center>   
</body>
</html>