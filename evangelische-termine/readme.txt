=== Evangelische Termine ===
Contributors: thomasarend
Tags: Termine, Veranstaltuneg, Evangelische Kirche
Donate link: http://byggvir.de/
Requires at least: 4.0.0
Tested up to: 4.2.2
Stable tag: trunk
License: GNU Public License
License URI: http://opensource.org/licenses/gpl-license.php

Plugin for Evangelische Termine the event calender of the Evangelische Kirche in Deutschland

== Description ==
Plugin for displaying evente form the Evangelische Termine event caledar in WordPress. The plugin supports one shortcode in posts or pages and a widget for the sidebars. 

== Installation ==
Copy the zip file evangeliche-termine-0.6.zip to your server and unzip it to the plugin folder of your WordPerss installation.

== Changelog ==
Changes 0.6

Mayor changes after software update of Evangelische Termine at EKiR.de.

    plugin renamed from EKiR Termine to Evangelische Termine
    main.php renamed to eangelische-termine.php
    teaser interface removed shortcode and widget removed
    prefix in plugin changed from ekir to evt
    shortcode ekirevent renamed to evtcalendar
    Added more options for XML-interfaced
    some smaler changes

Changes 0.5

    enhanced date format for start- and end-parameter.
    The date is converted by ‘strtotime’ into ‘Y-m-d’
    option to show only on a singular post

Changes 0.4.1

    utf-8 encode error in lib.inc for query string fixed.

Changes 0.4

    implement additional parameters to XML-Interface
    harmonize parameter names for XML and teaser interface.
    add copyright to output
    add links to events on server
    removed ‘Plugin’ in Plugin Name

Changes 0.3.1

    deleted function tohtml ()
    added param “q=” in evt_xmlliste() to queryString
    Add line feed between date and time in ekirteaser table (postprocess.inc. function postprocess-html)
    changed class dateWith in styles.css

Changes Version 0.3

    implement shorttag “ekirevent” based on xml.php interface
    implement widget based on xmp.php interface
    removed some bugs

Changes Version 0.2

    Added widget support
    Added option evt_host, evt_script
    Renamed shorttag to “ekirteaser”
    Split source into multiple files


== Upgrade Notice ==
Upgrade to 0.6 for support of the new server software.

GenerateWP

    Home
    Blog
    Privacy Policy

    Dashboard
    Generators
    Snippets

Recent Blog Posts

    Embed snippets to your site
    GenerateWP is two years old!
    Introducing oEmbed provider generator

Subscribe to Blog via Email

Enter your email address to subscribe to this blog and receive notifications of new posts.

