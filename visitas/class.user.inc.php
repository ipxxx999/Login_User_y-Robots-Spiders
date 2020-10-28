<?php
	class User {
		// Clase de usuario utilizada para manipular usuarios y para verificar si el usuario está conectado / autenticado
		
		private $db = null; // Se utiliza para almacenar una instancia de la base de datos.
		
		public 	$authenticated = false, // Se utiliza para saber si el usuario está autenticado o no.
				$details = false, // Se utiliza para almacenar todos los detalles sobre el usuario en una matriz.
				$name = false, // El nombre de los usuarios recuperado de la base de datos
				$username = false; // El nombre de usuario de los usuarios recuperado de la base de datos
				
		// Constructor
		public function __construct() {
			// Obtenga una instancia de la base de datos
			$this->db = DB::get_instance();
			// Compruebe que el usuario ha sido autenticado
			$this->is_authenticated();
			// Compruebe que la configuración de seguridad comprobada de los usuarios no haya cambiado
			$this->check_security();
		}
		
		// Se utiliza para comprobar si el usuario ha sido autenticado
		public function is_authenticated() {
			// Tire en global $session
			global $session;
			// Compruebe si el usuario está autenticado
			if($session->get('authenticated_user') == 1) {
				
				// Compruebe si se ha enviado la identificación de usuario
				if($session->get('authenticated_user_id')) {
					// Busque el user_id en la base de datos
					$result = $this->find_id($session->get('authenticated_user_id'));
					
					// Verifique si el ID de usuario es válido en la base de datos
					if($result) {
						// El usuario ha iniciado sesión
						$this->authenticated = true;
						
						// Pasar los detalles del $ result en formato raw al objeto
						$this->details = $result;
						
						// Cree el nombre completo de los usuarios para facilitar el futuro
						$this->name = $result['full_name'];
						
						// Establecer la instancia con el nombre de usuario de los usuarios
						$this->username = $result['username'];
					} else {
						// El usuario no existe en la base de datos: elimine toda la autenticación como a prueba de fallas
						$this->remove_authenticated();
					}
				} else {
					// El usuario no se ha autenticado correctamente: user_id no está presente, elimine toda la autenticación como a prueba de fallas
					$this->remove_authenticated();
				}
			} else {
				// El usuario no ha sido autenticado, elimine toda la autenticación como a prueba de fallas
				$this->remove_authenticated();
			}
		}
		
		// Se usa para verificar si los detalles de los usuarios han cambiado en algún momento y para cerrar la sesión de un usuario automáticamente si han cambiado
		private function check_security() {
			// Tire en global $session
			global $session;
			
			// Compruebe que la dirección IP de los usuarios no haya cambiado
			if(($_SERVER['REMOTE_ADDR'] != $session->get('user_ip'))) {
				// Elimine $ session-> get ('user_ip') para evitar redireccionamientos
				$session->remove('user_ip');
				// Salir del usuario
				$this->logout('security_failed');
			};
				
			// Compruebe que el agente HTTP de los usuarios no ha cambiado
			if(($_SERVER['HTTP_USER_AGENT'] != $session->get('user_agent'))) {
				// Delete the $session->get('user_agent') to avoid redirects
				$session->remove('user_agent');
				// Salir del usuario
				$this->logout('security_failed');
			};
				
			// Verifique los detalles si el usuario ha sido autenticado
			if($this->authenticated) {
				// Compruebe que la dirección IP de los usuarios sea la misma que cuando iniciaron sesión
				if(($_SERVER['REMOTE_ADDR'] != $session->get('authenticated_user_ip'))) {
					// Elimine $ session-> get ('authenticated_user_ip') para evitar redireccionamientos
					$session->remove('authenticated_user_ip');
					// Salir del usuario
					$this->logout('security_failed');
				}
				// Compruebe que el agente HTTP de los usuarios es el mismo que cuando iniciaron sesión
				if(($_SERVER['HTTP_USER_AGENT'] != $session->get('authenticated_user_agent'))) {
					// Elimine $ session-> get ('authenticated_user_agent') para evitar redireccionamientos
					$session->remove('authenticated_user_agent');
					// Salir del usuario
					$this->logout('security_failed');
				}
			}
		}
		
		// Se utiliza para intentar un inicio de sesión basado en un nombre de usuario / contraseña pasado
		public function attempt_login($username = null, $password = null) {
			// Compruebe si se han configurado $ username y $ password
			if(isset($username) && isset($password) && !empty($username) && !empty($password)) {
				// $ nombre de usuario y $ contraseña establecidos
				// Busque el $ username
				$user = $this->find_username($username);
				
				// Compruebe si se pudo encontrar el nombre de usuario
				if($user) {
					// Nombre de usuario encontrado
					// Comprueba que la contraseña sea correcta
					$result = $this->password_check($password, $user['hashed_password']);
					
					// Comprueba que la contraseña coincida
					if($result) {
						// Coincidencias de nombre de usuario y contraseña
						// devolver los $ detalles de usuario
						return $user;
					} else {
						// La contraseña no coincide
						return false;
					}
				} else {
					// usuario no encontrado
					return false;
				}
			} else {
				// $nombre de usuario y $ contraseña no establecidos
				return false;
			} // Close if(isset($username) && isset($password) && !empty($username) && !empty($password))
		}
		
		// Used to remove any authenticated user 
		public function remove_authenticated() {
			// Llame a la sesión $ según sea necesario
			global $session;
			
			// Eliminar primero los valores de sesión
			$session->remove('authenticated_user');
			$session->remove('authenticated_user_ip');
			$session->remove('authenticated_user_agent');
			$session->remove('authenticated_user_time');
			$session->remove('authenticated_user_id');
			$session->remove('authenticated_user_username');
			
			// Eliminar cualquier propiedad establecida en esta instancia
			$this->authenticated = false;
			$this->details = false;
			$this->name = false;
		}
		
		// Se utiliza para establecer varios valores de sesión que se utilizarán para verificar que el usuario haya iniciado sesión correctamente
		// Llamado después de que un usuario haya iniciado sesión correctamente
		public function set_logged_in($user = null) {
			// Llame a la sesión $ según sea necesario
			global $session; 
			
			// Verifique que se haya enviado la información relevante
			if(isset($user) && !empty($user)) {
				// Eliminar cualquier configuración preexistente
				$this->remove_authenticated();
				
				// Establecer valor para notificar que el usuario ha sido autenticado
				$session->set('authenticated_user', '1');
				$this->authenticated = true;
				
				// Establecer los detalles recopilados sobre la sesión desde que se autenticó al usuario
				// Eliminar cualquier detalle preexistente
				$session->set('authenticated_user_ip', $_SERVER['REMOTE_ADDR']);
				$session->set('authenticated_user_agent', $_SERVER['HTTP_USER_AGENT']);
				$session->set('authenticated_user_time', time());
				
				// Set details gathered about the user
				$session->set('authenticated_user_id', $user['user_id']);
				$session->set('authenticated_user_username', $user['username']);
				
				// Set user name and username
				$this->name = $user['full_name'];
				$this->username = $user['username'];
			}
		}
		
		// Se utiliza para verificar que las contraseñas proporcionadas por los usuarios coincidan
		private function password_check($password, $existing_hash) {
			// El hash existente contiene formato y sal al inicio
			$hash = crypt($password, $existing_hash);
			// Verifique que las contraseñas sean correctas
			if($hash === $existing_hash) {
				// Las contraseñas coinciden
				return true;
			} else {
				// Las contraseñas no coinciden
				return false;
			}
		}
	
		// Método para encontrar un nombre de usuario específico
		public function find_username($username = null) {
			// Si se ha enviado el $ username
			if(!empty($username)) {
				// Prepare una consulta SQL para buscar un nombre de usuario en la base de datos
				$sql = "
					SELECT * FROM users 
					WHERE username = :username
				";
				$stmt = $this->db->prepare($sql);
				
				// Pase el $ username en la declaración preparada y ejecute
				$stmt->bindParam(':username', $username);
				
				// Ejecuta la consulta
				$stmt->execute();
				
				// Obtenga los resultados de la declaración preparada
				$result = $stmt->fetch();
				
				// Compruebe si se pudo encontrar un nombre de usuario
				if($result) {
					// Nombre de usuario encontrado, devuelve todos los detalles
					return $result;
				} else {
					// Nombre de usuario no encontrado, devuelva falso
					return false;
				}
			} else {
				// $el nombre de usuario no ha sido enviado
				return false;
			}
		}
		
		// Método para encontrar un usuario específico por su user_id
		public function find_id($id = null) {
			// Si se ha enviado el $ id
			if(!empty($id)) {
				// Prepare una consulta SQL para buscar una identificación en la base de datos
				$sql = "
					SELECT * FROM users 
					WHERE user_id = :user_id
				";
				$stmt = $this->db->prepare($sql);
				
				// Pase el $ id a la declaración preparada y ejecute
				$stmt->bindParam(':user_id', $id);
				
				// Ejecuta la consulta
				$stmt->execute();
				
				// Obtenga los resultados de la declaración preparada
				$result = $stmt->fetch();
				
				// Compruebe si se pudo encontrar un usuario
				if($result) {
					// Usuario encontrado, devolver todos los detalles
					return $result;
				} else {
					// Usuario no encontrado, devuelva falso
					return false;
				}
			} else {
				// $id no ha sido enviado
				return false;
			}
		}
		
		// Se utiliza para desconectar a una usuario.
		public function logout($message = null) {
			// Traiga la sesión global
			global $session;
			// Traiga la matriz de notificación $ para que se traigan mensajes estándar
			global $notification;
			
			// Eliminar elementos autenticados
			$this->remove_authenticated();
			
			// Utilice la declaración de cambio para determinar si el usuario se desconectó automáticamente debido a que no pasó una verificación de seguridad
			switch($message) {
				case 'not_authenticated' :
					// Registra que el usuario no está autenticado para ver una página en particular
					// Cree una nueva instancia de registro y registre la acción en la base de datos
					$log = new Log('not_authenticated');
					// Establecer mensaje de sesión
					$session->message_alert($notification['authenticate']['not_authenticated'], 'danger');
					break;
				case 'security_failed' :
					// Registre que el usuario se ha desconectado automáticamente debido a una falla de seguridad
					// Cree una nueva instancia de registro y registre la acción en la base de datos
					$log = new Log('logout_security');
					// Establecer mensaje de sesión
					$session->message_alert($notification['logout']['security_failed'], 'danger');
					break;
				default :
					// No $mensaje ha sido enviado, use el mensaje de cierre de sesión predeterminado
					$session->message_alert($notification['logout']['success'], 'success');
			}
			
			// Redirigir usuario
			Redirect::to(PAGELINK_LOGIN);
		}
		
		// Method to find all users in the database
		public function find_all() {
			// Return all 
			return $this->all = $this->db->query('SELECT * FROM users', PDO::FETCH_ASSOC);
		}
		
		// Método para eliminar un usuario en particular
		public function delete($id = null) {
			// Si se ha enviado el $ id
			if(!empty($id)) {	
				// Comience la declaración preparada para eliminar una sola ID de la base de datos
				$sql = '
					DELETE FROM users 
					WHERE user_id = :user_id 
					LIMIT 1
				';
				$stmt = $this->db->prepare($sql);

				// Pase el $ id a la declaración preparada y ejecute
				$stmt->bindParam(':user_id', $id);

				// Ejecute la declaración preparada
				$result = $stmt->execute();

				if($result) {
					// Eliminar fue exitoso
					return true;
				} else {
					// Error al eliminar
					return false;
				}
			} else {
				// $id no ha sido enviado
				return false;
			}
		}
		
		// Método para actualizar a un usuario en particular
		public function update($values = array(), $id = null) {
			// Este método funciona aceptando una matriz de $ valores que contiene los detalles de los campos que se actualizarán
			// Verifique que la matriz $ values y $ id no estén vacías
			if(!empty($values) && !empty($id)) {
				// La matriz tiene valores, comience a construir la consulta SQL que se usará para actualizar al usuario
				$sql = "UPDATE users SET ";
				
				// Cuente el número de valores en la matriz para que se agregue una coma (,) después de cada sección del ciclo, aparte de la última
				$i = 0;
				$c = count($values);
				
				// Recorre cada valor de la matriz
				foreach($values as $key => $value) {
					if($i++ < $c - 1) {
						// Agregue a $ sql e incluya una coma
						$sql .= $key . " = :" . $key . ", ";
					} else {
						// Agregue al $ sql, pero deje la coma
						$sql .= $key . " = :" . $key . " ";
					}
				}
				
				// Especifique qué usuario actualizar y limitar para actualizar solo 1 registro como a prueba de fallas
				$sql .= "WHERE user_id = :user_id ";
				$sql .= "LIMIT 1";
				
				// Comience una declaración preparada usando el $ sql anterior
				$stmt = $this->db->prepare($sql);
				
				// Pase los valores de la matriz de $ valores para completar la declaración preparada
				foreach($values as $key => &$value) {
					$stmt->bindParam(':' . $key, $value);
				}
				// Vincular el ID de usuario a la declaración preparada
				$stmt->bindParam(':user_id', $id);
				
				// Ejecute la declaración preparada
				$result = $stmt->execute();
				
				// Compruebe si tiene éxito
				if($result) {
					// Actualización exitosa
					return true;
				} else {
					// Actualización fallida
					return false;
				}
			} else {
				// $la matriz de valores o $ id estaba vacía estaba vacía
				return false;
			}
		}
		
		// Método para crear un nuevo usuario
		public function create($values = array()) {
			// Este método funciona aceptando una matriz de $ valores que contiene los detalles de los campos que se van a insertar
			// Verifique que la matriz no esté vacía
			if(!empty($values)) {
				// Obtenga una instancia de base de datos
				$db = DB::get_instance();
				
				// La matriz tiene valores, comience a construir la consulta SQL que se utilizará para crear el usuario
				$sql = "INSERT INTO users (";
				
				// Agregue el user_id ya que no se enviará como parte de la matriz $ values
				$sql .= "user_id, ";
				
				// Cuente el número de valores en la matriz para que se agregue una coma (,) después de cada sección del ciclo, aparte de la última
				$i = 0;
				$c = count($values);
				
				// Cycle through each value in the array
				foreach($values as $key => $value) {
					if($i++ < $c - 1) {
						// Append to the $sql, and include a comma
						$sql .= $key . ", ";
					} else {
						// Agregue al $ sql, pero deje la coma
						$sql .= $key . " ";
					}
				}
				
				$sql .= ") VALUES (";
				
				// Agregue el user_id ya que no se enviará como parte de la matriz $ values
				$sql .= ":user_id, ";
				
				//Restablecer contadores
				// Cuente el número de valores en la matriz para que se agregue una coma (,) después de cada sección del ciclo, aparte de la última
				$i = 0;
				$c = count($values);
				
				// Recorra cada valor en la matriz, esta vez especificando las claves para insertar como parte de la declaración preparada
				foreach($values as $key => $value) {
					if($i++ < $c - 1) {
						// Agregue a $ sql e incluya una coma
						$sql .= ":" . $key . ", ";
					} else {
						// Agregue al $ sql, pero deje la coma
						$sql .= ":" . $key . " ";
					}
				}
				// Termina el $ sql
				$sql .= ")";
				
				// Comience una declaración preparada usando el anterior $sql
				$stmt = $db->prepare($sql);
				
				// Genere una identificación con una longitud de 12
				$id = $this->generate_id(12);
				$stmt->bindParam(':user_id', $id);
				
				// Pase los valores de la matriz de $ valores para completar la declaración preparada
				foreach($values as $key => &$value) {
					$stmt->bindParam(':' . $key, $value);
				}
				
				// Ejecute la declaración preparada
				$result = $stmt->execute();
				
				// Compruebe si tiene éxito
				if($result) {
					// Insertado exitoso
					return true;
				} else {
					// Insertado falló
					return false;
				}
			} else {
				// Matriz estaba vacía
				return false;
			}
		}
		
		// Genere una identificación para usar como la clave única asociada con un nuevo contacto que se está creando
		private function generate_id($token_length) {
			// Usado para generar un token
			// Inicializar una variable utilizada para almacenar el token
			$token = null;
			// Crea una sal de personajes aceptados
			$salt = "abcdefghjkmnpqrstuvxyzABCDEFGHIJKLMNOPQRSTUVXYZ0123456789";
			
			srand((double)microtime()*1000000);
			$i = 0;
			while ($i < $token_length) {
				$num = rand() % strlen($salt);
				$tmp = substr($salt, $num, 1);
				$token = $token . $tmp;
				$i++;
			}
			// Devuelve el token
			return $token;
		}
		
		// Método estático para permitir que las contraseñas sean encriptadas y saladas usando el método Blowfish
		// Requiere que se pase una contraseña $
		public function password_encrypt($password = null) {
			// Dile a PHP que use el formato de contraseña Blowfish ($2y) with a "cost" of 10 ($10$)
			$hash_format = "$2y$10$";
			// Especifique una longitud de sal: las sales de pez globo deben tener 22 caracteres de longitud
			// http://php.net/manual/en/function.crypt.php
			$salt_length = 22;
			// Generate the salt passing in the length from the $salt_length
			$salt = $this->generate_salt($salt_length);
			// Concatenate the $hash_format with the $salt
			$format_and_salt = $hash_format . $salt;
			
			// Check that a password has been sent
			if(!empty($password)) {
				// Cifre la $ contraseña con $ format_and_salt para devolver una contraseña cifrada
				return $encrypted_password = crypt($password, $format_and_salt);
			} else {
				// No se envió la contraseña
				return false;
			};
		}
		
		// Generate a salt for used in password encryption
		private function generate_salt($length) {
			// A continuación no es 100% único o 100% aleatorio; sin embargo, está perfectamente bien para una sal
			
			// Devuelve 32 caracteres usando MD5
			$unique_random_string = md5(uniqid(mt_rand(), true));
			
			// Especifique los caracteres válidos para la sal - [a-zA-Z0-9./]
			$base64_string = base64_encode($unique_random_string);
			
			// El uso de base64_encode también incluirá caracteres '+'; estos deben eliminarse
			$modified_base64_string = str_replace('+', '.', $base64_string);
			
			// Truncar la cadena a la longitud correcta y volver
			return $salt = substr($modified_base64_string, 0, $length);
		}
		
	} // Cerrar clase Usuario
// EOF