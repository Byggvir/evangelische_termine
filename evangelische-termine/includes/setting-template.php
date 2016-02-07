<?php 
/**
 * @package Evangelische-Termine
 * @version 0.6.2
 * @author Thomas Arend <thomas@arend-rhb.de>
 * @copyright 2014-2015 Thomas Arend Rheinbach Germany
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * Template for the setings pageID
 *
 * Changes 0.6.2
 * First version for github
 *
 */

//Security check!
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
?>

<!-- EKiR Termine Settings -->

  <h1>Evangelische Termine</h1>
  <h2>Beschreibung</h2>
  <p>
  Hier k&ouml;nnen die vorgegebenen Werte des Evangelischen Termine Plugins angepasst / &uuml;berschrieben werden. 
  </p>
  <p>
  Die wesentlichen internen Vorgabewerte sind: 
  </p>
  <ol>
  <li>host=termine.ekir.de</li>
  <li>dir=Veranstalter</li>
  <li>script=xml.php und</li>
  <li>vid=193</li>
  </ol>
  <h3>Liste der Parameter des Shortcodes</h3>

  <p>Folgende Parameter werden unterst&uuml;tzt: channel, count, day, dest, dir, encoding, end, eventtype, highlight, host, ipm, kirchenkreis, menue1, menue2, month, own, pageID, people, person, place, query, script, start, title, vid, year, yesno1, yesno2, zip
  </p>
  <h2>Vorgabewerte<h2>
  
  <form method="post" action="options.php"> 
    <?php @settings_fields('evt-group'); ?>
    <?php @do_settings_fields('evt-group'); ?>
    <?php do_settings_sections('evt_termine'); ?>
    <?php @submit_button(); ?>
  </form>
