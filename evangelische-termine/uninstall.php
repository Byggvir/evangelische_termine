<?php

/**
 * @package Evangelische-Termine
 * @version 0.6.2
 * @author Thomas Arend <thomas@arend-rhb.de>
 * @copyright 2014-2015 Thomas Arend, Rheinbach, Germany 
 *
 * 
 * Plugin Evangelische Termine
 * 
 * Delete all traces of the plugin when the admin is uninstlling the plugin.
 */
 
// If uninstall.php is not called from wordpress exit

//Security check!
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if ( !defined('WP_UNINSTALL_PLUGIN') ) {

?>
<html>
<head>
</head>
<body>
<p>
<strong>Error:</strong> uninstall.php may may not be called directly! 
</p>
</body>
</html>
<?php

exit () ;

}

// Delete options from options table

require_once(sprintf("%s/includes/global.php", dirname(__FILE__)));

global
      	  $EVT_DefValues;

// 
foreach ($EVT_DefValues as $key => $value) {
	       unregister_setting('evt-group', 'evt_'.$key);
	       delete_option('evt_'.$key);
	}

?>  
