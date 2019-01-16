<?php

/**
 *
 *
 Plugin TA-Evangelische-Termine
 FileName: lib.php

 Author: Thomas Arend
 Version: v2019.0.0
 Date: 04.01.2019
 Author URI: http://byggvir.de/
 License: GPL-3+
*/

//Security check!

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/* Test for UTF-8 encoding. */

require_once plugin_dir_path( __FILE__ ) . 'class_urlloader.php';


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
  // advanced date time syntax for start and end date
  
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
 
  if ( $attr['host'] != '' ) 
  {
    $url = "https://" . $attr['host'] . "/" .$attr['dir'] ."/" . $attr['script'] . "?$queryString";

    $MyLoader = new EvT_URLloader('v2019.0.0');
    
    return $MyLoader->getURL($url) ;

  } 
  else 
    return "<p>Kein Server angegeben:" . $url . "</p>";
 
}

?>
