<?php
	// Esta clase es para devolver una instancia de la base de datos con una llamada al método getInstance ()
	class DB {
		
		// Mantenga cualquier objeto PDO instanciado para DB en una instancia $ como parte de una llamada singleton call
		// Establecer el valor predeterminado en nulo
		protected static $instance = null;
		
		protected function __construct() {}
		
		// Método estático de base de datos para obtener Singleton PDO call
		public static function get_instance() {
			// Si $ instancia no se ha configurado
			if(empty(self::$instance)) {
				// Intente crear una nueva conexión PDO
				try {
					// Establecer $ instancia en un nuevo PDO, ya que actualmente no está configurado
					self::$instance = new PDO(DB_TYPE.":host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS);
				} catch(PDOException $error) {
					// Si se ha encontrado un error
					echo $error->getMessage();
				}
			}
			// Devuelve la instancia de $Singleton
			return self::$instance;
		}
		
	}; // Cerrar clase DB
	
// EOF