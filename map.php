<?php
/*
 * Plugin Name: My Awesome Plugin
 * Description: Sample plugin for Wordpress. It shows you how a Wordpress plugin works. It contains CRUD process and option/setting form in admin page, and shortcode.
 * Version: 1.0
 * Author: Andi Prianto
 * Author URI: https://github.com/prianto
 * License: MIT License
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: my-awesome-plugin
 * Domain Path: /translation
 */

 // Make sure we don't expose any info if called directly
 if ( !function_exists( 'add_action' ) ) {
   exit('Hi there!  I\'m just a plugin, not much I can do when called directly.');
 }

 define( 'MAP_VERSION', '1.0' );
 define( 'MAP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
 define( 'MAP_PLUGIN_URI', plugin_dir_url( __FILE__ ) );
 define( 'MAP_SLUG', plugin_basename( dirname(__FILE__) ) );

 include_once MAP_PLUGIN_DIR . 'map-helper.php';
 include_once MAP_PLUGIN_DIR . 'map-menu.php';
 include_once MAP_PLUGIN_DIR . 'map-form.php';
 include_once MAP_PLUGIN_DIR . 'map-options.php';

 include_once MAP_PLUGIN_DIR . 'map-activation.php';
 register_activation_hook( __FILE__, 'map_activation' );

 include_once MAP_PLUGIN_DIR . 'map-deactivation.php';
 register_deactivation_hook( __FILE__, 'map_deactivation' );

 function map_action_links ( $links ) {
   $map_settings = array( '<a href="'. admin_url( 'options-general.php?page=map' ) .'">Settings</a>' );
   return array_merge( $links, $map_settings );
 }
 add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'map_action_links' );
