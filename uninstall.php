<?php
/*
Plugin ID: MAP
File: ./my-awesome-plugin/uninstall.php
*/

// If uninstall is not called from WordPress, exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

$delete = get_option( 'map-setting' );
if ( $delete == 'yes' ) {
	// Delete option
	delete_option( 'map-setting' );
	delete_option( 'map-setting-2' );

	// For site options in Multisite
	delete_site_option( 'map-setting' );
	delete_site_option( 'map-setting-2' );

	// Set global
	global $wpdb;

	// Delete query
	$wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "map_customers" );
	$wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "map_product_models" );
	$wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "map_product_brands" );
}
