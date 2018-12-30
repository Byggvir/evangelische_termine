<?php

/**
 * @package Evangelische-Termine
 * @version 0.6.3
 * @author Thomas Arend <thomas@arend-rhb.de>
 * @copyright 2014-2015 Thomas Arend Rheinbach Germany
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * Changes 0.6.3
 * Small spelling corrections
 *
 */

 /**
 * Changes 0.6.2
 * First version vor github
 *
 */

/**
 * Define a class for the plugin settings
 *
 * The options for the plugin are grouped into three sctions
 * Server settings
 * Clendar settings
 * Query settings
 *  
 * The sever setting defines which server with hosts the database abd the directory and scipt to becalled by the shortcode or widget to get6 the events
 *
 * The calendar settings defines options drive the output
 *
 * The query optipons define default values to the query parameter of the XML interface of the server.
 */

//Security check!
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if(!class_exists('EVT_Termine_Settings'))
{
	class EVT_Termine_Settings
	{
		/**
		 * Construct the plugin object
		 */
	public function __construct()
	{
	// register actions
        	add_action('admin_init', array(&$this, 'admin_init'));
	       	add_action('admin_menu', array(&$this, 'add_menu'));
	} // END public function __construct
		
        /**
         * hook into WP's admin_init action hook
         */
        public function admin_init()
        {

	// global.php must be included here! Don't ask me why!
 
	require_once(sprintf("%s/global.php", dirname(__FILE__)));

      	global
	  $EVT_DefLabels ,
      	  $EVT_CalenderSettingNames, 
      	  $EVT_ServerSettingNames,
      	  $EVT_QuerySettingNames ,
      	  $EVT_DefValues;
      
  
      // register your plugin's settings


	foreach ($EVT_DefValues as $key => $value) {
	       register_setting('evt-group', 'evt_'.$key);
	}
 
        // For each section

        // add your settings section

        // XML section

	add_settings_section(
       	    'evt_CalendarSection', 
       	    'Ev. Termine Kalender Anzeige Einstellungen', 
       	    array(&$this, 'settings_section_calender'), 
       	    'evt_termine'
       	);

       	add_settings_section(
       	    'evt_ServerSection', 
       	    'Ev. Termine Server Einstellungen', 
       	    array(&$this, 'settings_section_server'), 
       	    'evt_termine'
       	);

       	add_settings_section(
       	    'evt_QuerySection', 
       	    'Ev. Termine Vorgabewerte der Abfrage', 
       	    array(&$this, 'settings_section_query'), 
       	    'evt_termine'
       	);



	// add your setting's fields

	// Calender fields

	foreach ($EVT_CalenderSettingNames as $key => $value) {
          add_settings_field(
            'evt_'.$key, 
            $EVT_DefLabels[$key], 
            array(&$this, 'settings_field_input_text'), 
            'evt_termine', 
            'evt_CalendarSection',
             array(
               'field' => 'evt_'.$key
             )
	  );
	}
	
	// Server fields

	foreach ($EVT_ServerSettingNames as $key => $value) {
          add_settings_field(
            'evt_'.$key, 
            $EVT_DefLabels[$key], 
            array(&$this, 'settings_field_input_text'), 
            'evt_termine', 
            'evt_ServerSection',
             array(
               'field' => 'evt_'.$key
             )
	  );
	}

	foreach ($EVT_QuerySettingNames as $key => $value) {
          add_settings_field(
            'evt_'.$key, 
            $EVT_DefLabels[$key], 
            array(&$this, 'settings_field_input_text'), 
            'evt_termine', 
            'evt_QuerySection',
             array(
               'field' => 'evt_'.$key
             )
	  );
	}
      	  
      	// register your plugin's settings
	// XML settings


            // Possibly do additional admin_init tasks
        } // END public static function activate
        
        
        /**
	* This function places a text after the title of the setting section
	* Text for XML Section
	*/
       public function settings_section_calender() 
	{

            // Think of this as help text for the section.
            echo "\n<p>Hier k&ouml;nnen die Vorgabewerte für den Titel der Kalenderanzeige angepasst werden.</p>";
        }

       public function settings_section_server() 
	{

            // Think of this as help text for the section.
            echo "\n<p>Hier k&ouml;nnen die Vorgabewerte des Server angepasst werden.</p>";
        }

	public function settings_section_query() 
	{

            // Think of this as help text for the section.
            echo "\n<p>Hier k&ouml;nnen die Vorgabewerte des Aufrufes des serverseitigen Scripts zur XML-Ausgabe der Events angepasst werden.</p>";
        }
        
        /**
         * This function provides text inputs for settings fields
         */
        public function settings_field_input_text($args)
        {
            // Get the field name from the $args array
            $field = $args['field'];
            // Get the value of this setting
            $value = get_option($field);
            // echo a proper input type="text"
            echo "\n" . sprintf('<input type="text" name="%s" id="%s" value="%s" />', $field, $field, $value);
        } // END public function settings_field_input_text($args)
        
        /**
         * add a menu
         */		
        public function add_menu()
        {
            // Add a page to manage this plugin's settings
        	add_options_page(
        	    'Ev. Termine Settings', 
        	    'Ev. Termine', 
        	    'manage_options', 
        	    'evt_termine', 
        	    array(&$this, 'plugin_settings_page')
        	);
        } // END public function add_menu()
    
        /**
         * Menu Callback
         */		
        public function plugin_settings_page()
        {
        	if(!current_user_can('manage_options'))
        	{
        		wp_die(__('You do not have sufficient permissions to access this page.'));
        	}
	
        	// Render the settings template
        	include(sprintf("%s/setting-template.php", dirname(__FILE__)));
        } // END public function plugin_settings_page()
    } // END class EVT_Termine_Settings
} // END if(!class_exists('EVT_Termine_Settings'))
