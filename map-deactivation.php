<?php
/*
Plugin ID: MAP
File: ./my-awesome-plugin/map-deactivation.php
*/

// disable direct access
defined( 'MAP_VERSION' ) or die();

// Plugin Deactivation
function map_deactivation() {
  global $wpdb;
}
