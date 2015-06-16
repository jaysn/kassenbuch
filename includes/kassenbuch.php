<?php

/*---------------------------*/
/*KASSENBUCH BY Tayfun Gülcan*/
/*   www.tayfunguelcan.de    */
/*---------------------------*/

//Lade Config Datei
include("config.php");
$seite = $_GET["seite"];  //Abfrage auf welcher Seite man ist 

//Einstellung laden
$oStmtSettings = $oDb->prepare( 'SELECT * FROM einstellungen' ); 
$e_ergebnis = $oStmtSettings->execute();
$oSettings = $oStmtSettings->fetchObject(); 

//Einträge pro Seite ermitteln
$per_page = $oSettings->eintraege;
$betragseinheit = $oSettings->betragseinheit;

//Lade Einstellungen für den Textbegrenzer
$textbegrenzer = $oSettings->textbegrenzer;

//Soritierungseinstellungen
if ($oSettings->sortierung == 1 ) {
	$order = 'ORDER BY id DESC';
}
else {
	$order = '';
}
//Wenn man keine Seite angegeben hat, ist man automatisch auf Seite 1 
if( !isset( $seite ) ) { 
	$seite = 1; 
}

//Ausrechen welche Spalte man zuerst ausgeben muss: 
$start = ( $seite -1 ) * $per_page;
/* $start = $seite  * $per_page - $per_page; */

//SQL Abfrage
$oStmtEintraege = $oDb->prepare( 'SELECT * FROM betraege' . $order . ' LIMIT :nStart, :nLimit' );
$oStmtEintraege->bindValue( ':nStart', $start, \PDO::PARAM_INT );
$oStmtEintraege->bindValue( ':nLimit', $per_page, \PDO::PARAM_INT );

/* $sqlabfrage = "SELECT * FROM betraege $order LIMIT $start, $per_page"; */
/* $sqlergebnis = mysql_query($sqlabfrage); */
$oStmtEintraege->execute();

$aBetraege = $oStmtEintraege->fetchAll();

echo '<h2>Übersicht<div style="float: right;"> <a href="?page=hinzufuegen"><img src="img/write.png"><a/></div></h2>';
echo '<table class="tabelle">
<tr>
<th width="6%">ID</th>
<th>Verwendungszweck</th>
<th align="right">Betrag</th>
</tr>';

/* $result = mysql_query("SELECT id FROM betraege"); 
$menge = mysql_num_rows($result);  */

$oQueryMenge = $oDb->prepare( 'SELECT COUNT(*) FROM betraege' );
$oQueryMenge->execute();

$menge = $oQueryMenge->fetchColumn();

//Abfrage von V von Betraege und addiere
$oStmtSumme = $oDb->prepare( 'SELECT SUM(`gesamt`) AS gesamt FROM `betraege`' ); 
$oStmtSumme->execute();
/* $sresult = mysql_query($query); // Wobei $link die mit mysqli_connect() aufgerufene Verbindung ist  */
$oSumme = $oStmtSumme->fetchObject(); 

//Aussage, Anzahl der Datensätze
if( $oSettings->datensaetze == 1 ) {
	//Wenn nur ein Datensatz gegeben ist
	if( $menge == 0 ) {
		echo "Keine Datensätze vorhanden.";
	}
	elseif( $menge == 1 ) {
		echo "Ein Datensatz gefunden.";
	}
	else {
		echo '<div style="width: 100%; text-align: left;"><strong>' . $menge . '</strong> Datensätze gefunden.</div>';	
	}
}
else {
	echo '';
}

//Ausgabe der Datensätze in Tabelle
/* while( $row = mysql_fetch_array( $sqlergebnis ) ) { */
foreach( $aBetraege as $oEintrag ) {
	$gesamt = $row->betrag * $row->anzahl;
	//Textbegrenzer für den Verwendungszweck	
	if( strlen( $row->verwendungszweck ) >= $textbegrenzer ) {
		$row->verwendungszweck = substr( $row->verwendungszweck, 0, $textbegrenzer ) . '...';
	}
	//Tabellenausgabe
	echo '
	<tr>
	<td style="border-right: 1px solid #d8d8d8;">' . $row->id . '</td>
	<td style="border-right: 1px solid #d8d8d8;"><a href="index.php?page=betrag_detail&id=' . $row->id . '">' . $row->verwendungszweck . '</a></td>
	<td align="right">' . $gesamt . '</td>
	</tr>';
}
 
 //Ausgabe der addierten Datensätze
echo '
	<tr>
	<td style="border-bottom: none;"></td>
	<td align="right" style="border-bottom: none;">Summe in '. $betragseinheit . ':</td>
	<td align="right" style="border-bottom: none;"><font style="border-bottom: #000000 double; font-weight: 700;">' . number_format( $oSumme->gesamt, 2, ',', '.' ) . '</font></td>
	</tr>
</table>';

// Meldung der Datensaetze unter Einstellungen
if( $per_page == '' ) {
	echo '<div style="width: 100%; text-align: center;">Fehler: <font color="red">Bitte unter Einstellungen die Anzahl der Datensätze angeben.</font></div>';		
}
else {
	//Errechnen wieviele Seiten es geben wird 
	$num_pages = $menge / $per_page;
}
//Ausgabe der Seitenlinks: 
echo '<div align="center">';
echo '<strong>Seite:</strong> '; 

//Ausgabe der Links zu den Seiten 
for( $a=0; $a < $num_pages; $a++ ) { 
   $b = $a + 1; 
   //Wenn der User sich auf dieser Seite befindet, keinen Link ausgeben 
   if( $seite == $b ) { 
      echo ' <strong>' . $b . '</strong> '; 
   } 
   //Auf dieser Seite ist der User nicht, also einen Link ausgeben 
   else { 
      echo '  <a href="?seite=' . $b . '">$b</a> '; 
   }
}
echo '</div>'; 
