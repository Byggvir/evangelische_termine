<?php

/**
 *
 *
 Plugin TA-Evangelsiche-Termine
 FileName: lib.php

 Author: Thomas Arend
 Version: 0.6.2
 Date: 07.02.2016
 Author URI: http://byggvir.de/
 License: GPL3


 Changes .6.2
 First version vor github

 Changes 0.6

 - renamed plugin and prefixes
 
 Changes 0.5
 - enhanced date format for start and end parameter in event widget and shortcode.
   the string is now converted by 'strtotime' into the format 'Y-m-d' which is required by the xml interface. 
 - new function 'converttoxmldate'

 Changes 0.4.1
 - utf-8 encode error for query string fixed. The servers uses ISO 8859-1 encoding. Wordpress uses UTF-8 encoding. So we have to convert the query string to ISO 8859-1.

 Changes 0.4
 - Renamed parameter kat to eventtype
 - changes functions parameter to array $atts  

 Changes 0.3.1
 - deleted function tohtml ()
 - added param "q=" in evt_xmlliste() to queryString

 Changes 0.3
 - Added XML Interface
 - Added functions get_withcurl and get_withoutcurl for retrieving the web pages
 
 ----------------------------------------------------------------
*/

/* Test for UTF-8 encoding. */


function is_utf8($string) 
{
  return preg_match('/(
    [\xC2-\xDF][\x80-\xBF]            # non-overlong 2-byte
    |    \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
    |    [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}    # straight 3-byte
    |    \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
    |    \xF0[\x90-\xBF][\x80-\xBF]{2}        # planes 1-3
    |    [\xF1-\xF3][\x80-\xBF]{3}        # planes 4-15
    |    \xF4[\x80-\x8F][\x80-\xBF]{2}        # plane 16
    )/x', $string);

}

/* Get list of events if CURL is not available.  */

function get_withoutcurl ( $url ) 
{

  $page='';
  $fd = fopen($url,"r");
  $returned = "";
  if ($fd) 
  {
    while(!feof($fd))
    {
      $line = fgets($fd,4096);
      $returned .= $line;
    }
    fclose($fd);
  } 
  else
  {
    $returned = "<p class=\"evt-warning\">Der Terminkalender ist derzeit nicht erreichbar!</p>";
  }
  return $returned;
}

/* Get list of events if CURL is available.  */

function get_withcurl ( $url, $agent = 'Veranstalter-Script' )
{
  // use curl
  $sobl = curl_init($url);

  curl_setopt($sobl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($sobl, CURLOPT_USERAGENT, $agent);
  curl_setopt($sobl, CURLOPT_REFERER, $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
  # timeout max 2 Sek.
  curl_setopt($sobl, CURLOPT_CONNECTTIMEOUT, 1);
  
  $pageContent = curl_exec ($sobl);
  
  $sobl_info = curl_getinfo ($sobl);
	
  if($sobl_info['http_code'] == '200')
  {
    $returned = $pageContent;
	
  } 
  else 
  {
    # Fehlermeldung:
    $returned = "<p class=\"evt-warning\">Der Terminkalender ist derzeit nicht erreichbar!</p>";
  }
  return $returned;

} 

/****
  
  Version 0.5

  Convert date to 'Y-m-d' for XML-Script

*/

function converttoxmldate ( $datestr ) 
{
  date_default_timezone_set('UTC');
  if ($datestr != '') 
    return date ('Y-m-d' , strtotime ( $datestr )) ; 
  else 
    return '';
}

/*****
 ----------------------------------------------------------------

  Get dates from a Termine-server
 
 ----------------------------------------------------------------
*/

function evt_getevents($attr, $QueryNames , $agent = 'WordPressPlugin' ) 

{

  // Version 0.5
  // advanced date time sysntax for start and end date
  
  $attr['start'] = converttoxmldate ($attr['start']);
  $attr['end'] = converttoxmldate ($attr['end']);


  // Fixed for utf-8 encoding
  
  if ( is_utf8($attr['query'])) 
    $attr['query'] = utf8_decode($attr['query']);
  $atts['query'] = urlencode( $attr['query']) ;

  $queryString = '';

  foreach ($QueryNames as $key => $value) 
  {
    if ( $attr[$key] != '') 
      $queryString .= "&". $value . "=" . $attr[$key];
  }

  if (substr($queryString,0,1) == "&" ) 
    $queryString = substr($queryString,1);
 
// Uncommment next line for debugging
//echo "<p>QueryString=$queryString</p>";

  if ( $attr['host'] != '' ) 
  {
    $url = "http://" . $attr['host'] . "/" .$attr['dir'] ."/" . $attr['script'] . "?$queryString";
    //echo "<p>http://" . $attr['host'] . "/" .$attr['dir'] ."/" . $attr['script'] . "?$queryString</p>";

    if (function_exists('curl_init'))
      $evliste = get_withcurl ($url );
    else 
      $evliste = get_withoutcurl($url);

    return $evliste ;

  } 
  else 
    return "<p>Kein Server angegeben:" . $url . "</p>";
 
}

?>
