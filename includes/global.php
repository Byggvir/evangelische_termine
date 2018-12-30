<?php

/**
 * @package Evangelische-Termine
 * @version 0.6.2
 * @author Thomas Arend <thomas@arend-rhb.de>
 * @copyright 2014-2015 Thomas Arend Rheinbach Germany
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
 
/**
 * 
 * Changes Version 0.6.2
 * First Version vor github 
 *
 * Changes Version 0.6
 *
 * - plugin renamed
 * - plugin prefix evt
 *
 * Changes Version 0.4
 * - harmonized parameter names
 * - New global constant arrays for parameters
 
 ----------------------------------------------------------------
 
 Globale Variablen und 'copy and paste' Code zu vermeiden.
 Um das Teile des Plugins um weiteren Parameteter zu erweitern 
 müssen die Parameter nur den Arrays zugefügt werden.
 
 ----------------------------------------------------------------
 */

$Plugin_Prefix = 'evt_';


/* 
 ----------------------------------------------------------------
 
 Die Labels für die Parameter der Widgets und Einstellungsseite
 
 ----------------------------------------------------------------
*/

$EVT_DefLabels = 
  array ( 
    'channel'		=> 'Kanäle', 	// Kanäle
    'count'		=> 'Anzahl Einträge' ,
    'day'		=> 'Tag (%-d, all,0), Monat muss ebenfalls gesetzt werden!',
    'dest'		=> 'Extern / Intern' ,
    'dir'		=> 'Verzeichnis auf dem Server (= Veranstalter)' ,
    'encoding'		=> 'Codierung, latin1 oder utf8 (= utf8)' ,
    'end'		=> 'Enddatum (%F)' ,
    'eventtype'		=> 'Kategorie des Events' ,
    'highlight'		=> 'Highligh' ,
    'host'		=> 'Server (= termine.ekir.de)',
    'ipm'		=> 'ID des Veranstaltungstyp', 
    'kirchenkreis'	=> 'Kirchenkreis',
    'menue1'		=> 'Menue 1',
    'menue2'		=> 'Menue 2',
    'month'		=> 'Monat (%-m.%y), Tag muss ebenfalls gesetzt werden!',
    'own'		=> 'Eigenen Veranstaltungen', 
    'pageID'		=> 'Seiten ID',
    'people'		=> 'Zielgruppe(n)' ,
    'person'		=> 'Person',
    'place'		=> 'Ort' ,
    'query'		=> 'Abfrage' ,
    'script'		=> 'Script (= xml.php)' ,
    'start'		=> 'Startdatum (%F)' ,
    'title'		=> 'Titel',
    'vid'		=> 'Veranstalter ID, Komma-getrennte Liste (= 193)' ,
    'year'		=> 'Jahr (%Y)',
    'yesno1'		=> 'YesNo 1',
    'yesno2'		=> 'YesNo 2',
    'zip'		=> 'Postleitzahl'     
);

/*
 ----------------------------------------------------------------
 
 Die verschiedenen Schnittstellen des Termin-Servers verwenden
 unterschiedliche Namen für die Parameter. Mit den folgenden
 Arrays werden die Namen vereinheitlicht. Führend ist dabei
 das XML-Interface.
 ----------------------------------------------------------------

*/

/*
 ----------------------------------------------------------------
 Das XML-Script des Termine-Server kennt zahlreiche Parameter.
 
 Das Plugin verwendet längere Namen für die Parameter 
 als die XML_Schnittstelle.
 
 Die folgende Tabelle wird benötigt, um die längeren Parameter in die
 Parameter der XML-Schnittstelle umzusetzen.
 ----------------------------------------------------------------
*/

$EVT_CalenderSettingNames =
  array ( 
    'title'		=> 'title'	// überschrift über Kalender
);

$EVT_ServerSettingNames =
  array ( 
    'host'		=> 'host',	// URL des Server
    'dir'		=> 'dir',	// Verzeichnis auf dem Server
    'script'		=> 'script'	// Sript auf dem Server
);

$EVT_QuerySettingNames =
  array ( 
    'channel'		=> 'cha', 	// Kanäle
    'count' 		=> 'itemsPerPage',	// Veranstaltungen pro Seite
    'day'		=> 'd',
    'dest'		=> 'dest',
    'encoding'		=> 'encoding',	// latin1 | utf8 - für Seiten, die über PHP eingebettet werden, z.B. PHP-Teaser
    'end'		=> 'end',	// Enddatum -	YYYY-MM-DD
    'eventtype'		=> 'eventtype',
    'highlight'		=> 'highlight',
    'ipm'		=> 'ipm',	// ID des Veranstaltungstyp 
    'kirchenkreis'	=> 'kk',
    'menue1'		=> 'menue1',
    'menue2'		=> 'menue2',
    'month'		=> 'month',	// m.YY z.B. 4.14 = April 2014
    'own'		=> 'own', 	// all | own übernommene Veranstaltungen
    'pageID'		=> 'pageID',	// Ort der Veranstaltung
    'people'		=> 'people',
    'person'		=> 'person',
    'place'		=> 'place',	// Ort der Veranstaltung
    'query'		=> 'q',
    'start'		=> 'start',	// Startdatum - YYYY-MM-DD
    'vid'		=> 'vid',
    'year'		=> 'year',	// Jahr YYYY / zB. year=2014, year=none
    'yesno1'		=> 'yesno1',
    'yesno2'		=> 'yesno2',
    'zip'		=> 'zip' 	// Postleitzahl
);


/*
 ----------------------------------------------------------------
 Default Werte für die Widgets und Shortcodes!
  
 ----------------------------------------------------------------
*/

/*  Default Attribute für Calender Widget und Shortcode */

/*
 'script' enthält den Namen des Scriptes für das XML-Interface. 
 
 Ab Version 0.5 erlauben die Parameter 'start' und 'end' für das 
 Anfangs- und Enddatum der Liste der Events eine erweiterte Syntax 
 gegenüber dem strikten Format des XML-Interface.
 Der Parameter wird durch die Funktion 'strtotime' in das vom 
 XML-Interface benötigte Format 'Y-m-d' konvertiert. 

*/

$EVT_DefValues = 
  array ( 
    'channel'		=> '',
    'count'		=> '',
    'day'		=> '',
    'dest'		=> '',
    'dir'		=> 'Veranstalter',
    'encoding'		=> 'latin1',
    'end'		=> '',
    'eventtype'		=> '',
    'highlight'		=> '',	
    'host'		=> 'termine.ekir.de', // Server der EKiR
    'ipm'		=> '',
    'kirchenkreis'	=> '',
    'menue1'		=> '',
    'menue2'		=> '',
    'month'		=> '',
    'own'		=> '',
    'pageID'		=> '',
    'people'		=> '',
    'person'		=> '',
    'place'		=> '',	
    'query'		=> '',
    'script'		=> 'xml.php',
    'start'		=> '',
    'title'		=> 'Termine',
    'vid'		=> '193', // Rheinbach
    'year'		=> '', 
    'yesno1'		=> '',
    'yesno2'		=> '',
    'zip'		=> '' 
  );

?>
