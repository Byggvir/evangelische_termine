<?php
/**
 * public/class_urlloder.php
 *
 * @link              http://byggvir.de
 * @since             2019.0.0
 * @version 2019.1.0
 * @copyright 2019 Thomas Arend Rheinbach Germany
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @plugin-wordpress
 *
 *
 *
 * API zur Web-Seitehttps://liturgischer-kalender.bayern-evangelisch.de/widget/widget.php
 *
 * @author Thomas Arend <thomas@arend-rhb.de>
 * @package  EvT
 */


/**
 * Security check: Exit if script is called directly
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define('EvTURLloader', 'Installed');

define('EvT_URLloaderVERSION', 'v2019.0.0');


/**
 * Define class
 *
 * @class EvT_URLloader
 *
 */
class EvT_URLloader {

	private $yr_version;
	private $my_version;

	/**
	 * constructor
	 *
	 * @param unknown $version (optional)
	 */
	function __construct($version = 'unknown') {

		$this->yr_version = $version;
		$this->my_version = EvT_URLloaderVERSION;

	}



	/**
	 *
	 * @return unknown
	 */
	public function getversion() {

		return $this->my_version;
	}


	/**
	 *
	 * @param unknown $date (optional)
	 * @return unknown
	 */
	private function convertDate( $date = '') {

		if (($timestamp = strtotime($date)) === false) {
			return date('Y-m-d');
		} else {
			return date('Y-m-d', $timestamp);
		}

	}



	/**
	 *
	 * @param unknown $url
	 * @return unknown
	 */
	private function get_withoutcurl( $url ) {

		$page='';
		$fd = fopen($url, "r");

		$returned = "";

		if ($fd) {
            while (!feof($fd)) {
				$line = fgets($fd, 4096);
				$returned .= $line;
			}
			fclose($fd);
		}
		else {
			$returned = "<p class=\"evkj-warning\">Der Liturgische Kalender ist nicht erreichbar!</p>";;
		}
	return $returned;

	}


	/**
	 *
	 * @param unknown $url
	 * @param unknown $agent (optional)
	 * @return unknown
	 */
	private function get_withcurl( $url, $agent = 'PHP 7.0 LoadURL v2019.0.0 - (c) Thomas Arend - https://byggvir.de') {

		// use curl
        $sobl = curl_init($url);

		curl_setopt($sobl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($sobl, CURLOPT_USERAGENT, $agent);
		curl_setopt($sobl, CURLOPT_REFERER, $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
		// timeout max 2 Sek.
		curl_setopt($sobl, CURLOPT_CONNECTTIMEOUT, 5);

		$pageContent = curl_exec ($sobl);
		$sobl_info = curl_getinfo ($sobl);
		if ($sobl_info['http_code'] == '200') {
			$returned = $pageContent;
		}
		else {
			// Fehlermeldung:
			$returned = "<p class=\"evkj-warning\">Der Liturgische Kalender ist nicht erreichbar! $url</p>";
		}

        return $returned;

	}
	
	public function getURL($url) {

		if (preg_match('/(Googlebot|bingbot)/', $_SERVER['HTTP_USER_AGENT']) or WP_DEBUG) {
            return '
<?xml version="1.0" encoding="UTF-8"?>
<root><Export><meta><totalItems>531</totalItems><activeParams>vid=193|region=all|own=all|d=all|m=01|y=2019|start=|end=|date=|until=yes|past=1|year=none|q=|highlight=all|eventtype=all|people=0|menue1=all|menue2=all|ipm=all|place=all|person=all|cha=all|res=all|dest=extern|pageID=1|itemsPerPage=0</activeParams>
<eventtypes><eventtype key="1">Gottesdienste</eventtype></eventtypes>
<peoples><people key="0">Alle Zielgruppen</people></peoples>
<months><month key="all">alle Termine</month></months><headline>Veranstaltungen</headline></meta></Export></root>
';


		}
		else {

            if (function_exists('curl_init')) {
                return $this->get_withcurl($url) ;
            }
            else {
                return $this->get_withoutcurl($url) ;
            }
        }
    }

} // End of class

?>
