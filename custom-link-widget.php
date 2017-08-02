<?php
/*
Plugin Name: Custom link widget
Plugin URI:
Description: Custom link widget
Version: 9.9.9
Author: eKreative
Author URI: ekreative.com
License:
Text Domain: clw
*/
defined('ABSPATH') or die('No script kiddies please!');

require_once (__DIR__ . '/includes/CLW_Widget.php');

//register widget
add_action('widgets_init', 'clw_register_widget' );
function clw_register_widget() {
    register_widget( 'CLWWidget' );
}