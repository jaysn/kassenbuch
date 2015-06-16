<?php
/*
 * KASSENBUCH BY Tayfun Gülcan
 * www.tayfunguelcan.de
 * */
/* DO NOT EDIT THESE LINES */
define( 'KB_DB_MYSQL', 1 );
define( 'KB_DB_SQLITE', 2 );

/* Happy Editing */
 
//DB TYPE (ONE OF THE PREDEFINED KB_DB_* CONSTANTS
define( 'DB_TYPE', 'KB_DB_SQLITE' );

// Datenbank-Datei wenn SQLITE
define( 'DB_FILENAME', 'kassenbuch.sq3' );

// Datenbank Server wenn MYSQL
define ( 'MYSQL_HOST', '' ); //FILE/HOST (Meist 'localhost')
 
// Datenbank Benutzer und Passwort
define ( 'MYSQL_BENUTZER',  '' ); //Benutzername
define ( 'MYSQL_KENNWORT',  '' ); //Kennwort
define ( 'MYSQL_DATENBANK', '' ); //Datenbank


//Standardwerte Minimum und Maximum für die angezeigten Datensätze in der Blätterfunktion
$min_anzahl = 10;
$max_anzahl = 99;

//Minimum und Maximum für den Textbegrenzer
$min_textbegrenzer = 10;
$max_textbegrenzer = 30;

/*------ HIER NICHTS EINSTELLEN ------*/

//Verbindung aufbauen
switch( DB_TYPE ) {
	case 2:
		$oCon = new \PDO( 'sqlite:' . DB_FILENAME );
	break;
	case 1:
		$oCon = new \PDO( 'mysql:dbname=' . MYSQL_DATENBANK . ';host=' . MYSQL_HOST, MYSQL_BENUTZER, MYSQL_KENNWORT );
	break;
	default:
		/* $oCon = mysql_connect (MYSQL_HOST, MYSQL_BENUTZER, MYSQL_KENNWORT) && mysql_select_db(MYSQL_DATENBANK)
	or  */die ("<div id='meldung'><div id='meldung'>Datenbankverbindung Fehlgeschlagen<br /> Bitte ueberpruefen Sie die Einstellungen in der config.php .</div></div>");
}
$oCon->setAttribute( \PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ );
