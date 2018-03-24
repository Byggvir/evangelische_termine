<?php
/**
 * @package Evangelische-Termine
 * @version 0.6.2
 * @author Thomas Arend <thomas@arend-rhb.de>
 * @copyright 2014-2015 Thomas Arend Rheinbach Germany
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * Changes 06.3
 * Include evt-day-holiday when LITURG_BEZ not blank
 *
 * Changes 0.6.2
 * First version for github
 *
 * Changes 0.6
 * - renamed plugin an prefixes
 */

//Security check!
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once(sprintf("%s/lib.php", dirname(__FILE__)));

/* Funktionen um die Daten des Veranstaltungsservers für WordPress aufzubereiten.

*/

function htmlmakelink ( $content , $url ) {

 if ($url != '') {
   return "<a href=\"" . $url . "\" target=\"_blank\">" . $content . "</a>";
   }
 else
   return $content ;
}

function postprocess_xml ( $inxml , $codeplace = 'article' ) {

  
  $xml = simplexml_load_string($inxml);
  if ( $xml ) { 
  
  $outhtml = "\n<!-- Beginn des Evangelischen Terminkalenders -->\n";
  if ( $xml->count() !== 0 )
  { 
  // Debug
  //  $outhtml .=  "<!-- $inxml -->";
  $outhtml .= "<div class=\"evt-$codeplace\">\n";
  $outhtml .= "<table>\n";
  $oldDay = '';
  $i=1;

  foreach($xml->Export->Veranstaltung as $vera)
  {
 
    $i++; $i%2==0 ? $colorswitch = 'White' : $colorswitch = 'Grey';

    if ((string)$vera->monthbar != '0') 
      $outhtml .= "\n<tr><th class=\"evt-monthbar\" colspan=\"3\">" . (string)$vera->monthbar . "</th></tr>";
    // Prüfen, ob der Termin an einem neuen Tag beginnt
    if ( $oldDay != (string)$vera->START_DATUM ) 
    {
      // Tag über die Breite der Tabelle ausgeben.
      // class= bestimmt die Darstellung es Tages
      // evt-day : allgemeine Formatierung 
      // evt-day-Mo .. evt-day-So : Formatierung für den Wochentag
   
      if ((string) $vera->LITURG_BEZ !='' ) { $holiday=" evt-day-holiday"; }
      eles
      {
         $holiday="";
      };
      
      $oldDay = (string) $vera->START_DATUM;
      $outhtml .= "<!-- $oldDay -->" ;
  
      $outhtml .= "\n<tr>\n<td class=\"evt-daybar evt-day-"
	. (string) $vera->WOCHENTAG_START_KURZ . $holiday
	. "\" colspan=\"3\" >" . (string) $vera->WOCHENTAG_START_LANG . ", "
	. (string) $vera->START_DATUM;
      if ((string) $vera->LITURG_BEZ !='' ) 
	$outhtml .= "<br />" . (string) $vera->LITURG_BEZ ;
	
      $outhtml .= "\n</td>\n</tr>\n" ;
    }	
    // Ausgabe der Veranstaltung
    // Beginn und Ende Uhrzeit
    $outhtml .= "\n<tr class=\"$colorswitch\" itemscope itemtype=\"http://schema.org/Event\">\n" ;
    $outhtml .= "\n<td class=\"evt-startend\">\n" . (string) $vera->START_UHRZEIT;
    if ((string)$vera->END_UHRZEIT !='')
      $outhtml .= "<br /> bis <br />" . (string)$vera->END_UHRZEIT ;
	
    $outhtml .= "\n</td>\n";

    // Beschreibung ausgeben: Titel, Kurzbeschreibung, Person, Ort.
    $outhtml .= "\n<td class=\"evt-title\">";
    $outhtml .= "<span class=\"evt-span-title\" itemprop=\"name\">" . htmlmakelink((string) $vera->_event_TITLE, (string) $vera->_event_LINK) . "</span><br />";
    
    if ((string)$vera->_event_SHORT_DESCRIPTION !='') 
      $outhtml .= "<span class=\"evt-span-description\">" . (string)$vera->_event_SHORT_DESCRIPTION . "</span><br />";

    if ((string)$vera->_person_NAME !='') 
      $outhtml .= "<span class=\"evt-span-person\">" . (string)$vera->_person_NAME . "</span>";
    
    $outhtml .= "\n</td>\n<td class=\"evt-place\" itemprop=\"location\" itemscope itemtype=\"http://schema.org/Place\"><span itemprop=\"name\">" 
      . (string)$vera->_place_NAME 
      . "</span><br />" 
      . (string)$vera->_place_CITY . "</br />" ; 
    $outhtml .= htmlmakelink("weitere Infos", "http://". get_option('evt_host') . "/veranstaltung_im_detail" . (string) $vera->ID .".html");  
    $outhtml .= "\n</td>\n</tr>\n" ;
  
  }
  // Ende der Tabelle!
  $outhtml .= "</table>\n"; 
  $outhtml .= "</div>\n"; 
  
  }
  else
    $outhtml .= "<p>Schade. Derzeit ist der Terminkalender nicht verfügbar.</p>";
  $outhtml .= "<!-- Ende des Evangelischen Terminkalenders -->\n"; 
  return $outhtml;
  }
  else
    return $inxml;

}
?>
