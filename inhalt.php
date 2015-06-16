<? 

/*---------------------------*/
/*KASSENBUCH BY Tayfun Gülcan*/
/*   www.tayfunguelcan.de    */
/*---------------------------*/

session_start();
  
//Wenn Session aktiv
if( isset( $_GET['page'] ) ) {
	 
	switch( $_GET['page'] ) {
	case 'login': include( kINC . 'login.php' ); break;
	case 'logout': include( kINC . 'logout.php' ); break;    
	case 'kassenbuch': include( kINC . 'kassenbuch.php' ); break; 
	case 'einstellungen': include( kINC . 'einstellungen.php' ); break; 
	case 'statistik': include( kINC . 'statistik.php' ); break;
	case 'betrag_detail': include( kINC . 'detail.php' ); break; 

	case 'detail_delete': include( kINC . 'detail_delete.php' ); break; 
	case 'report': include( kINC . 'report.php' ); break; 
	case 'hinzufuegen': include( kINC . 'hinzufuegen.php' ); break; 	
	case 'pwaendern': include( kINC . 'passwort_aendern.php' ); break; 

	default: include( kINC . 'kassenbuch.php' ); 
	} 
}
else { 
	include( kINC . 'kassenbuch.php' );
}
