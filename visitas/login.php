<?php
// Initialize the session
// Inicializar la sesión
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
// Verifique si el usuario ya ha iniciado sesión, si es así, rediríjalo a la página de bienvenida
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: index.php");
  exit;
}
 
// Include config file
require_once "../config.php";
 
// Define variables and initialize with empty values
// Definir variables e inicializar con valores vacíos
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
// Procesando los datos del formulario cuando se envía el formulario
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    // Comprueba si el nombre de usuario está vacío
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor ingrese su usuario.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    // Comprueba si la contraseña está vacía
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor, introduzca su contrase&#241;a.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        // Preparar una declaración de selección
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            // Vincular variables a la declaración preparada como parámetros
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            // Establecer parámetros
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            // Intenta ejecutar la declaración preparada
            if(mysqli_stmt_execute($stmt)){
                // Store result
                // Almacenar resultado
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                // Verifique si existe el nombre de usuario, si es así, verifique la contraseña
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    // Vincular variables de resultado
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            // La contraseña es correcta, así que inicie una nueva sesión
                            session_start();
                            
                            // Store data in session variables
                            // Almacenar datos en variables de sesión
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            // Redirigir al usuario a la página de bienvenida
                            header("location: index.php");
                        } else{
                            // Display an error message if password is not valid
                            // Muestra un mensaje de error si la contraseña no es válida
                            $password_err = "La contrase&#241;a que ha introducido no es v&#225;lida.";
                        }
                    }
                } else{
                    // Show an error message if the username does not exist
                    // Muestra un mensaje de error si el nombre de usuario no existe
                    $username_err = "No existe cuenta registrada con ese nombre de usuario.";
                }
            } else{
                echo "Algo sali&#243; mal. Por favor, vuelva a intentarlo.";
            }
        }
        
        // Declaración de cierre
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
<center>
    <div class="wrapper">
        <h2>Cambio de contrase&#241;a con exito</h2>
        <p>Introduzca sus credenciales para iniciar sesi&#243;n.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Usuario</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" placeholder="Introduce tu correo electr&#243;nico" autofocus>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Contrase&#241;a</label>
                <input type="password" name="password" class="form-control"  placeholder="Ingresa tu contrase&#241;a">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Ingresar">
            </div>
            <p>¿No tienes una cuenta? <a href="../register.php">Reg&#237;strate ahora</a>.</p>
        </form>
    </div>    
</center>
</body>
</html>