<?php
/*
Plugin ID: MAP
File: ./my-awesome-plugin/map-activation.php
*/

// disable direct access
defined( 'MAP_VERSION' ) or die();

// Plugin Activation
function map_activation() {
  global $wpdb;
  $charset_collate = $wpdb->get_charset_collate();

  $sql_brands = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "map_brands (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(64) NOT NULL,
    created_at DATETIME,
    deleted_at DATETIME
  ) $charset_collate;";

  $sql_models = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "map_models (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    brand_id INT NOT NULL,
    name VARCHAR(64) NOT NULL,
    created_at DATETIME,
    deleted_at DATETIME,
    FOREIGN KEY (brand_id) REFERENCES " . $wpdb->prefix . "map_brands(id)
  ) $charset_collate;";

	$sql_customers = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "map_customers (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		name VARCHAR(32) NOT NULL,
		email VARCHAR(64) NOT NULL,
		model_id INT NOT NULL,
		count TINYINT(3) DEFAULT 0,
		mark_as_read TINYINT(1) DEFAULT 0,
    created_at DATETIME,
    deleted_at DATETIME,
    FOREIGN KEY (model_id) REFERENCES " . $wpdb->prefix . "map_models(id)
  ) $charset_collate;";

  $wpdb->query($sql_brands);
  $wpdb->query($sql_models);
  $wpdb->query($sql_customers);

	// Insert data brands
	$brand_csv = MAP_PLUGIN_DIR . 'data/brand.csv';
	if (file_exists($brand_csv)) {
		if ($file = fopen($brand_csv, "r")) {
			while(!feof($file)) {
				$line = fgets($file);
				$data = explode(',', $line);
				if (strlen($data[0]) && strlen($data[1])) {
					$id = (int) $data[0];
					$name = sanitize_text_field($data[1]);
          $exists = $wpdb->get_row(
            $wpdb->prepare("SELECT id, COUNT(`id`) as 'count' FROM " . $wpdb->prefix . "map_brands WHERE id = %d LIMIT 1", $id)
          );
        	if ((int) $exists->count === 0) {
  					$wpdb->query(
  						$wpdb->prepare("INSERT INTO " . $wpdb->prefix . "map_brands (id, name, created_at) VALUES (%d, %s, %s)", $id, $name, date('Y-m-d H:i:s'))
  					);
          }
				}
			}
			fclose($file);
		}
	}

	// Insert data models
	$model_csv = MAP_PLUGIN_DIR . 'data/model.csv';
	if (file_exists($model_csv)) {
		if ($file = fopen($model_csv, "r")) {
			while(!feof($file)) {
				$line = fgets($file);
				$data = explode(',', $line);
				if (strlen($data[0]) && strlen($data[1]) && strlen($data[2])) {
					$id = (int) $data[0];
					$brand_id = (int) $data[1];
					$name = sanitize_text_field($data[2]);
          $exists = $wpdb->get_row(
            $wpdb->prepare("SELECT id, COUNT(`id`) as 'count' FROM " . $wpdb->prefix . "map_models WHERE id = %d LIMIT 1", $id)
          );
        	if ((int) $exists->count === 0) {
  					$wpdb->query(
  						$wpdb->prepare("INSERT INTO " . $wpdb->prefix . "map_models (id, brand_id, name, created_at) VALUES (%d, %d, %s, %s)", $id, $brand_id, $name, date('Y-m-d H:i:s'))
  					);
          }
				}
			}
			fclose($file);
		}
	}

}
