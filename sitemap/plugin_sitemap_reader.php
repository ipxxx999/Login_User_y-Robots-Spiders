<?php

// Desactivar toda notificaci�n de error
error_reporting(0);

// Notificar solamente errores de ejecuci�n
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Notificar E_NOTICE tambi�n puede ser bueno (para informar de variables
// no inicializadas o capturar errores en nombres de variables ...)
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

// Notificar todos los errores excepto E_NOTICE
error_reporting(E_ALL ^ E_NOTICE);

// Notificar todos los errores de PHP (ver el registro de cambios)
error_reporting(E_ALL);

// Notificar todos los errores de PHP
error_reporting(-1);

// Lo mismo que error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

error_reporting(E_ERROR | E_PARSE);

class RSSFeed {
	var $title;						    // Alle Titel
	var $link;						    // Alle Links
	var $description;					// Alle Beschreibungen	
	var $newscount;						// Anzahl der Elemente
	var $xml;						    // Plaintext XML Dokument
	var $trans_tbl;						// HTML-Konvert-Tabelle
	
	var $feedurl="";					// Feed-URL
	var $cachefile="cache.txt";				// Lokaler Cache
	var $bulletfile;					// Bullet-Grafik
	
	var $expire=300;					// Refresh-Zeit in Sekunden
	var $maxnewscount=-1;					// Maximale Anzahl von Eintr�gen
	var $footer="";						// Text unterhalb des Feeds
	var $errortext="Error accessing Feed";	                // Fehlermeldung
	var $showdescription=1;					// Description anzeigen
	var $sidebarmode=0;					// Sidebar-Modus
	
	function RSSFeed() {
		// Klassen-Konstruktor
	
		// Die unhtmlentities-Funktion vorbereiten
		$this->trans_tbl = get_html_translation_table(HTML_ENTITIES);
	   	$this->trans_tbl = array_flip($this->trans_tbl);
	}
	
	function file_is_uptodate() {
		// Datei-Zeit checken

		if (file_exists($this->cachefile)) {
			if (time()-filemtime($this->cachefile)<$this->expire) {
				return TRUE;
			}
		} 
		return FALSE;
	}
	
	function read_file() {
		// Cache-File lesen
		
		unset($this->xml);
		$handle = fopen($this->cachefile, "r");
		if ($handle) {
			flock($handle, LOCK_SH);
			$this->xml = fread($handle, filesize($this->cachefile));
			flock($handle, LOCK_UN);
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function write_file() {
		// Cache-File schreiben
		
		$handle = fopen($this->cachefile, "w+");
		flock($handle, LOCK_EX);
		fwrite($handle, $this->xml);
		flock($handle, LOCK_UN);
		fclose($handle);
	}
	
	function read_url() {
		// URL lesen
		
		unset ($this->xml);
		
		$handle = fopen($this->feedurl, 'r');
		if ($handle) {
			while (!feof($handle)) {
				$this->xml .= fread($handle, 128);
			}
			fclose($handle);
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function find_tag($string, $tag) {
		// Tag finden
		
		$tmpval = array();
		$preg = "|<$tag.*?>(.*?)</$tag>|s";

		preg_match_all($preg, $string, $tags);
		foreach ($tags[1] as $tmpcont){
			$tmpval[] = $tmpcont;
		}
		return $tmpval;
	}
	
	function unhtmlentities($string) {
		// entfernt HTML-Entitites	
		
	   	return strtr($string, $this->trans_tbl);
	}
	
	function remove_cdata($text,$removeentities) {
		// Die CDATA-Tags entfernen
	
		$text=str_replace("<![CDATA[","",$text);
		$text=str_replace("]]>","",$text);
		if ($removeentities) {
			$text=$this->unhtmlentities($text);
		}
		return $text;
	}

	function parse_feed() {	
		// Den Feed interpretieren

		// Alles auf Null
		$this->newscount=0;
		unset($this->title);
		unset($this->link);
		unset($this->description);
		
		// Ist es ein UTF-8-Feed?		
		$utf=preg_match('|<\?xml.*?encoding\s*?=\s*?"\s*?UTF-8\s*?".*?>|i',$this->xml);
		
		// Alle Items finden
		$items = $this->find_tag($this->xml, 'item');
		
		// Die Items durchlaufen
		foreach ($items as $item) {
			$this->newscount++;

			// Titel, Link und Beschreibung extrahieren
			$title=$this->find_tag($item, 'title');
			$link=$this->find_tag($item, 'link');
			$description=$this->find_tag($item, 'description');
			
			// In Array schreiben und ggf. UFT-8 transformieren
			if ($utf) {
				$this->title[$this->newscount] = $this->remove_cdata(utf8_decode($title[0]),true);
			} else {
				$this->title[$this->newscount] = $this->remove_cdata($title[0],true);
			}
			if ($utf) {
				$this->description[$this->newscount] = $this->remove_cdata(utf8_decode($description[0]),true);
			
				$this->description[$this->newscount] = $this->remove_cdata($description[0],true);
			}
			$this->link[$this->newscount] = $this->remove_cdata($link[0],false);
			
			// Hat da einer den Titel vergessen?
			if ($this->title[$this->newscount]=="") {
				$this->title[$this->newscount]=$this->link[$this->newscount];
			}
		}
	}

	function print_html() {
		// Als HTML ausgeben
		
		if ($this->sidebarmode) {
			for ($i=1;(($i<=$this->newscount) && (($i<=$this->maxnewscount) || ($this->maxnewscount<=0)));$i++) {
				echo('<p>');
				echo('<a target="_blank" href="'.$this->link[$i].'">'.$this->title[$i].'</a>');
				echo('</p>');
				if ($this->description[$i] && $this->showdescription) {
					echo ('<p>'.$this->description[$i].'<br></p>');
				}
			}
			if ($this->footer) {
				echo('<p align="right">'.$this->footer.'</p>');
			}
		} else {
			echo('<table width="100%" border="0" cellpadding="0" cellspacing="0">');
			for ($i=1;(($i<=$this->newscount) && (($i<=$this->maxnewscount) || ($this->maxnewscount<=0)));$i++) {
				echo('<tr>');
				echo('<td><img src="'.$this->bulletfile.'" border=0 alt=""></td>');
				echo('<td width=100%>');
				echo('<a class="s2d" target="_blank" href="'.$this->link[$i].'">'.$this->title[$i].'</a>');
				echo('</td></tr>');
				if ($this->description[$i] && $this->showdescription) {
					echo ('<tr><td></td><td>');
					echo ('<p>'.$this->description[$i].'<br></p>');
					echo ('</td></tr>');
				}
			}
			if ($this->footer) {
				echo('<tr><td></td><td><p align="right">'.$this->footer.'</p></td></tr>');
			}
			echo('</table>');
		}
	}
	
	function process_feed() {
		// All in one: Den Feed lesen, cachen, ausgeben
		
		$valid=FALSE;
			
		if ($this->file_is_uptodate()) {
			// Cache war nach aktuell
			$valid=($this->read_file());
		} else {
			// Nicht mehr aktuell
			if ($this->read_url()) {
				// URL lesen und schreiben
				$this->write_file();
				$valid=TRUE;
			}
		}
		
		if ($valid) {
			// Wenn alles o.k. ausgeben
			$this->parse_feed();
			$this->print_html();
		} else {
			echo ("<p>".$this->errortext."</p>");
		}
	}
}
?>