<?php

/*****
Plugin Name: TA Evangelische Termine
Plugin URI: http://byggvir.de/wordpress-plugin-evt-veranstaltungen/
Description: Dieses Plugin stellt eine Schnittstelle zu den Termindatenbanken der evangelischen Landeskirchen und angeschlossenen Organisationen bereit, die die Datenbank "Evangelische Termine" im Internet nutzen. Die Termine können mit dem Shortcode evtcalendar in Seiten und Artikel eingebunden werden. Daneben steht ein Widget für die Anzeige der Termine in den Seitenleisten zur Verfügung. 

Author: Thomas Arend
Version: 0.6.2
Date: 07.02.2016
Author URI: http://byggvir.de/
License: GPL 2 or later

This plugin is based on 

	* http://termine.ekir.de
	  xml.php interface example code
	* http://codex.wordpress.org/Widgets_API
	  example Widget plugin
	* https://codex.wordpress.org/Writing_a_Plugin
	  description and examples
*/

/**
 * @package TA-Evangelische-Termine
 * @version 0.6.2
 * @author Thomas Arend <thomas@arend-rhb.de>
 * @copyright 2014-2016 Thomas Arend Rheinbach Germany
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 *
 *
 * Change log: http://byggvir.de/wordpress/wordpress-plugin-evangelische-veranstaltungen-beispiele/wordpress-plugin-evangelische-termine-change-log/
 */

// Security check: Exit if scipt is called direcktly

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*****
 * Define a prefix for EVT
 */

define ("EVT", 'EVT_');

if(!class_exists(EVT . 'Termine'))
{
  class EVT_Termine
  {
  /**
  * Construct the plugin object
  */
    public function __construct()
    {
    // Initialize Settings
    require_once(sprintf("%s/includes/settings.php", dirname(__FILE__)));
    $EVT_Termine_Settings = new EVT_Termine_Settings();
    
    } // END public function __construct
	    
  /**
  * Activate the plugin
  */
    public static function activate()
    {
    // Do nothing
    } // END public static function activate
	
    /**
    * Deactivate the plugin
    */		
    public static function deactivate()
    {
    // Do nothing
    } // END public static function deactivate
	
  } // END class EVT_Termine

  } // END if(!class_exists(EVT.'Termine'))


if (class_exists( EVT . 'Termine'))
{

  // Installation and uninstallation hooks
  register_activation_hook(__FILE__, array(EVT.'Termine', 'activate'));
  register_deactivation_hook(__FILE__, array(EVT.'Termine', 'deactivate'));

  // Instantiate the plugin class
  
  $evt_termine = new EVT_Termine();
  
  // Add a link to the settings page onto the plugin page
  
  if (isset($evt_termine))
  {
    // Add the settings link to the plugins page
    function EVT_settings_link($links)
    { 
    
      $settings_link = '<a href="options-general.php?page=evt_termine">Settings</a>'; 
      array_unshift($links, $settings_link); 
      return $links;
    
    }

    $plugin = plugin_basename(__FILE__); 
    add_filter("plugin_action_links_$plugin", EVT.'settings_link');
  
  }

}

// Include files

require_once(sprintf("%s/includes/global.php", dirname(__FILE__)));
require_once(sprintf("%s/includes/postprocess.php", dirname(__FILE__)));
require_once(sprintf("%s/includes/lib.php", dirname(__FILE__)));
require_once(sprintf("%s/includes/shortcode_calendar.php", dirname(__FILE__)));
require_once(sprintf("%s/includes/widget.php", dirname(__FILE__)));

// We need some CSS to format the calender 

function add_evt_stylesheet()
{
  wp_register_style( EVT . 'StyleSheets', plugins_url('css/styles.css',__FILE__));
  wp_enqueue_style( EVT . 'StyleSheets');
}

// Add the EVTStyleSheets

add_action('wp_print_styles', 'add_evt_stylesheet');

// Add the shortcode
// Old shortcodes for comptibility only

//add_shortcode('ekirteaser', 'evt_calendar');
//add_shortcode('ekirevent', 'evt_calendar');

//Prefered shortcode

add_shortcode('evtcalendar', 'evt_calendar');

?>
