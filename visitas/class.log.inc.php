<?php
	// Esta clase se utiliza para registrar las acciones del usuario en la base de datos en la tabla de visitas.
	class Log {
		
		private $db = null; // Se utiliza para almacenar una instancia de la base de datos.
		
		// Constructor
		public function __construct($action = null, $additional_message = null) {
			// Obtenga una instancia de la base de datos
			$this->db = DB::get_instance();
			
			// Si se envió una acción, procese una nueva acción para agregarla a la base de datos
			if($action) {
				// $se ha enviado la acción, agregar a la base de datos
				$this->action($action, $additional_message);
			}
		}
		
		// Encuentra todos los registros de la base de datos
		public function find_all() {
			// Devolver todo 
			return $this->all = $this->db->query('SELECT * FROM visitas', PDO::FETCH_ASSOC);
		}
		
		// Método para agregar una nueva entrada a la tabla de registros en la base de datos
		public function action($action = null, $additional_message = null) {
			global $user;
			
			// Definir el SQL que se utilizará para realizar cambios en la base de datos.
			$sql = '
				INSERT INTO visitas ( 
					datetime, 
					action, 
					url, 
					user, 
					ip, 
					user_agent 
				) VALUES ( 
					:datetime, 
					:action, 
					:url, 
					:user, 
					:ip, 
					:user_agent 
				)
			';
			
			// Comience una declaración preparada usando el anterior $sql
			$stmt = $this->db->prepare($sql);
			
			// Vincular valores a la declaración preparada
			$datetime = $this->current_mysql_datetime();
			$stmt->bindParam(':datetime', $datetime);
			$action = $this->get_action($action, $additional_message);
			$stmt->bindParam(':action', $action);
			$url = site_url() . $_SERVER['REQUEST_URI'];
			$stmt->bindParam(':url', $url);
			$name = $user->username ? $user->name . ' [' . $user->username . ']' : 'Nuevo Visitante';
			$stmt->bindParam(':user', $name);
			$stmt->bindParam(':ip', $_SERVER['REMOTE_ADDR']);
			$stmt->bindParam(':user_agent', $_SERVER['HTTP_USER_AGENT']);
			
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
		}
		
		// Devuelve una cadena de una acción, basada en una entrada.
		private function get_action($action = null, $additional_message = null) {
			// Ejecute una instrucción de cambio para especificar una acción y regresar
			switch($action) {
				case 'view' : // Para visitas a la página
					$action = 'Pagina Vista: (' . page_name() . ')'; // Utilice la función page_name para especificar qué página ha visitado un usuario
					break;
				case 'not_found' : // Para acceder a páginas que no se pudieron encontrar, como valores $ _GET no válidos o valores que no se pudieron encontrar en la base de datos
					$action = "Result Not Found: (" . page_name() . ')';
					break;
				case 'login_failed' :
					$action = 'Login Failed';
					if($additional_message) {
						$action .= ': ' . $additional_message;
					};
					break;
				case 'login_success' :
					$action = 'Login Success';
					break;
				case 'login_redirect' :
					$action = 'User redirected from login page due to already being logged in';
					break;
				case 'logout_success' :
					$action = 'Logout Success';
					break;
				case 'logout_security' :
					$action = 'Automatic logout due to a failed security check';
					break;
				case 'not_authenticated' :
					$action = 'Unauthenticated User Attempted Accessing Page: (' . page_name() . ')';
					break;
				case 'user_add_failed' :
					$action = 'User Add Failed';
					if($additional_message == 'database') {
						$action .= ': There was an error making changes to the database.';
					} elseif($additional_message) {
						$action .= ': ' . $additional_message;
					}
					break;
				case 'user_add_success' :
					$action = 'User Add Success';
					if($additional_message) {
						$action .= ': ' . $additional_message;
					};
					break;
				case 'user_delete_failed' :
					$action = 'User Delete Failed';
					if($additional_message == 'database') {
						$action .= ': There was an error making changes to the database.';
					} elseif($additional_message) {
						$action .= ': ' . $additional_message;
					}
					break;
				case 'user_delete_success' :
					$action = 'User Delete Success';
					if($additional_message) {
						$action .= ': ' . $additional_message;
					};
					break;
				case 'user_update_failed' :
					$action = 'User Update Failed';
					if($additional_message == 'database_password') {
						$action .= ': There was an error making changes to the database to update password.';
					} elseif($additional_message == 'database_details') {
						$action .= ': There was an error making changes to the database to update details.';
					} elseif($additional_message) {
						$action .= ': ' . $additional_message;
					}
					break;
				case 'user_update_success' :
					$action = 'User Update Success';
					if($additional_message) {
						$action .= ': ' . $additional_message;
					};
					break;
				case 'contact_add_failed' :
					$action = 'Contact Add Failed';
					if($additional_message == 'database') {
						$action .= ': There was an error making changes to the database.';
					} elseif($additional_message) {
						$action .= ': ' . $additional_message;
					}
					break;
				case 'contact_add_success' :
					$action = 'Contact Add Success';
					if($additional_message) {
						$action .= ': ' . $additional_message;
					};
					break;
				case 'contact_delete_failed' :
					$action = 'Contact Delete Failed';
					if($additional_message == 'database') {
						$action .= ': There was an error making changes to the database.';
					} elseif($additional_message) {
						$action .= ': ' . $additional_message;
					}
					break;
				case 'contact_delete_success' :
					$action = 'Contact Delete Success';
					if($additional_message) {
						$action .= ': ' . $additional_message;
					};
					break;
				case 'contact_update_failed' :
					$action = 'Contact Update Failed';
					if($additional_message == 'database') {
						$action .= ': There was an error making changes to the database.';
					} elseif($additional_message) {
						$action .= ': ' . $additional_message;
					}
					break;
				case 'contact_update_success' :
					$action = 'Contact Update Success';
					if($additional_message) {
						$action .= ': ' . $additional_message;
					};
					break;
				case 'api_call_success' :
					$action = 'API Call Success';
					if($additional_message) {
						$action .= ': ' . $additional_message;
					};
					break;
				case 'api_call_failed' :
					$action = 'API Call Failed';
					if($additional_message) {
						$action .= ': ' . $additional_message;
					};
					break;
				case 'api_add_failed' :
					$action = 'API Token Add Failed';
					if($additional_message == 'database') {
						$action .= ': There was an error making changes to the database.';
					} elseif($additional_message) {
						$action .= ': ' . $additional_message;
					}
					break;
				case 'api_add_success' :
					$action = 'API Token Add Success';
					if($additional_message) {
						$action .= ': ' . $additional_message;
					};
					break;
				case 'api_delete_failed' :
					$action = 'API Token Delete Failed';
					if($additional_message == 'database') {
						$action .= ': There was an error making changes to the database.';
					} elseif($additional_message) {
						$action .= ': ' . $additional_message;
					}
					break;
				case 'api_delete_success' :
					$action = 'API Token Delete Success';
					if($additional_message) {
						$action .= ': ' . $additional_message;
					};
					break;
				case 'api_update_failed' :
					$action = 'API Token Update Failed';
					if($additional_message == 'database') {
						$action .= ': There was an error making changes to the database.';
					} elseif($additional_message) {
						$action .= ': ' . $additional_message;
					}
					break;
				case 'api_update_success' :
					$action = 'API Token Update Success';
					if($additional_message) {
						$action .= ': ' . $additional_message;
					};
					break;
				default :
					$action = 'Action Unspecified!';
					break;
			}
			
			// Devuelve la $acción
			return $action;
		}
		
		// Método para obtener la fecha y hora actual en formato MySQL
		private function current_mysql_datetime() {
			// Devuelve la hora actual en formato de fecha y hora de MySQL 
			return date('Y-m-d H:i:s', time());
		}
		
	}; // Cerrar registro de clase
// EOF