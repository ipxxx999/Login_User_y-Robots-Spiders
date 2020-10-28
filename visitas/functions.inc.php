<?php
	// Todas las funciones del sitio están en este archivo que no se pueden atribuir a una clase
	
	// Función para devolver el nombre de página correcto de las variables $ page_name y $ subpage_name
	function page_name() {
		// Traiga $ page_name y $ subpage_name si está configurado
		global $page_name;
		global $subpage_name;
		
		// Si se establecen $ subpage_name y $ page_name, devuelva ambos
		if(isset($page_name) && isset($subpage_name)) {
			return $subpage_name . " - " . $page_name;
		} else { // De lo contrario, devuelva $ page_name
			return $page_name;
		};
	}; // Cerrar la función page_name ()

	// Función para verificar si SITE_URL tiene una barra diagonal al final para asegurarse de que se usa el formato de URL correcto
	function site_url() {
		// Recorta las barras diagonales al final
		return rtrim(SITE_URL, '/');
	}

// EOF