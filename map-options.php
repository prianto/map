<?php
/*
Plugin ID: MAP
File: ./my-awesome-plugin/map-options.php
*/

// Disable direct access
defined( 'MAP_VERSION' ) or die();

// Add admin options page
function map_menu_page() {
  add_options_page( 'MAP Plugin', 'MAP Plugin', 'manage_options', 'map', 'map_options_page' );
}
add_action( 'admin_menu', 'map_menu_page' );

// add admin settings and such
function map_admin_init() {
  add_settings_section( 'map-section', 'General', '', 'map' );

  add_settings_field( 'map-field-2', 'Form Name', 'map_field_callback_2', 'map', 'map-section' );
  register_setting( 'map-options', 'map-setting-2', 'sanitize_text_field' );

  add_settings_field( 'map-field', 'Uninstall', 'map_field_callback', 'map', 'map-section' );
  register_setting( 'map-options', 'map-setting', 'sanitize_key' );
}
add_action( 'admin_init', 'map_admin_init' );

function map_field_callback_2() {
  $map_setting_2 = esc_attr( get_option( 'map-setting-2' ) );
  echo "<input type='text' size='40' maxlength='50' name='map-setting-2' value='$map_setting_2' />";
}

function map_field_callback() {
  $value = esc_attr( get_option( 'map-setting' ) );
  ?>
  <input type='hidden' name='map-setting' value='no'>
  <label><input type='checkbox' name='map-setting' <?php checked( $value, 'yes' ); ?> value='yes'> Delete all data</label>
  <?php
}

// display admin options page
function map_options_page() {
?>
<div class="wrap">
  <h1>MAP Plugin - Settings</h1>
  <form action="options.php" method="POST">
    <?php settings_fields( 'map-options' ); ?>
    <?php do_settings_sections( 'map' ); ?>
    <?php submit_button(); ?>
  </form>
  <p>After installing, please insert shortcode <code>[map_form]</code> to any page.</p>
</div>
<?php
}
