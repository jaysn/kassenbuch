<?php

/*---------------------------*/
/*KASSENBUCH BY Tayfun Gülcan*/
/*   www.tayfunguelcan.de    */
/*---------------------------*/

session_start();
define( 'kCWD', dirname( __FILE__ ) );
define( 'kPATH', kCWD . DIRECTORY_SEPARATOR );
define( 'kINC', kPATH . 'includes' . DIRECTORY_SEPARATOR );

//Erstelle Struktur
include( kINC . 'header.html' );

//Prüfe, ob install.php vorhanden ist
if( file_exists( kPATH . 'install.php' ) ) { 
	echo '<div id="meldung">1. Geben Sie Ihre Daten in die config.php ein.
		  <br>2. Führen Sie die install.php aus.
		  <br>3. Löschen sie die install.php!</div>';
	exit();
}

if( !isset( $_SESSION['angemeldet'] ) || !$_SESSION['angemeldet'] ) {
	include( kINC . 'login.php' ); 
	exit;
}

include( kPATH . 'inhalt.php' ); 

include( kINC . 'footer.html' );
?>