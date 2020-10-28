<?php
	class Session {
		// Constructor
		public function __construct() {
			// Registre los detalles de los usuarios
			$this->obtain_user_details();
		}
		
		// Se utiliza con fines de prueba para generar el contenido de la matriz $ _SESSION
		public function debug() {
			echo '<pre>';
			print_r($_SESSION);
			echo '</pre>';
		}
		
		// Establecer una clave de sesión con un valor
		public function set($key, $value) {
			if(isset($_SESSION[$key]) || !empty($_SESSION[$key])) {
				// Concatenar si el valor ya está presente
				$_SESSION[$key] .= $value;
			} else {
				// De lo contrario, establezca como un nuevo valor
				$_SESSION[$key] = $value;
			}
		}
		
		// Recuperar una clave de sesión
		public function get($key) {
			if(isset($_SESSION[$key])) {
				return $_SESSION[$key];
			} else {
				return false;
			}
		}
		
		// Eliminar una clave de sesión en particular
		public function remove($key) {
			$_SESSION[$key] = '';
			unset($_SESSION[$key]);
		}
		
		// Destruye todos los datos de la sesión y luego destruye el contenido de la sesión
		public function destroy() {
			// Desarmar todas las claves de sesión
			session_unset();
			// Establecer $ _SESSION como una matriz vacía
			$_SESSION = array();
			// Destruye la sesión
			session_destroy();
		}
		
		// Se usa para generar un mensaje único desde $ _SESSION ['mensaje'] y luego eliminarlo para evitar la replicación
		public function output_message() {
			// Primero verifique si hay un mensaje
			if($this->get('message')) {
				// Salida del contenido del la $_SESSION['message']
				echo $this->get('message');
				// Elimina cualquier contenido del mensaje para evitar la duplicación.
				$this->remove('message');
			}
		}
		
		// Construya una alerta de Bootstrap usando un mensaje y un tipo de mensaje para determinar el color / tipo de mensaje
		public function message_alert($message_content = 'An alert has been called, but not specified!', $message_type = 'warning') {
			// The type of message, determining the colour/type of the alert
			switch($message_type){
				case "success":
					$message = "<div class=\"alert alert-success\" role=\"alert\">";
					break;
				case "info":
					$message = "<div class=\"alert alert-info\" role=\"alert\">";
					break;
				case "warning":
					$message = "<div class=\"alert alert-warning\" role=\"alert\">";
					break;
				case "danger":
				default:
					$message = "<div class=\"alert alert-danger\" role=\"alert\">";
					break;
			};
			
			// Agrega el contenido del mensaje
			$message .= $message_content;
			$message .= "</div>";
			
			// Establecer el mensaje en la sesión
			$this->set('message', $message);
		}
		
		// Construya una alerta de Bootstrap usando una serie de errores para generar un mensaje de falla de validación
		public function message_validation($errors = array()) {
			// Recorra una serie de errores de validación para mostrar un mensaje de validación fallida en la pantalla.
			$alert = "<div class=\"alert alert-danger\" role=\"alert\">";
			$alert .= "<p>No se pudo enviar el formulario debido a los siguientes errores:<p>";
			$alert .= "<ol>";
			foreach($errors as $error) {
				$alert .= "<li>" . $error . "</li>";
			}
			$alert .= "</ol>";
			$alert .= "<p>Corrija estos errores y vuelva a intentarlo.</p>";
			$alert .= "</div>";
			
			// Establecer los errores de validación en la sesión
			$this->set('message', $alert);
		}
		
		// Se utiliza para almacenar detalles particulares sobre el usuario en la sesión.
		private function obtain_user_details() {
			// Compruebe si se ha registrado la dirección IP de los usuarios
			if(!$this->get('user_ip')) {
				// Registre la dirección IP de los usuarios
				$this->set('user_ip', $_SERVER['REMOTE_ADDR']);
			}
			// Compruebe si el agente HTTP del usuario se ha registrado
			if(!$this->get('user_agent')) {
				// Registrar el agente HTTP de los usuarios
				$this->set('user_agent', $_SERVER['HTTP_USER_AGENT']);
			}
		}
		
	}; // Cerrar sesión de clase
	
// EOF