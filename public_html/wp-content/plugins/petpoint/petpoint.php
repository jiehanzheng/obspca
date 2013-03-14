<?php
/*
Plugin Name: The PetPoint Loop
Description: Provide WordPress Loop-like interface to PetPoint APIs.
Version: 0.1
Author: Jiehan Zheng
Author URI: http://jiehan.org/
License: MIT
*/

require 'petpoint-api.php';


function petpoint_install() {
  global $wpdb;

  $table_name = $wpdb->prefix . "petpoint_cache";

  $sql = <<<SQL
    CREATE TABLE $table_name (
      query varchar(255) NOT NULL,
      retrieved_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      data longtext NOT NULL,
      UNIQUE KEY query (query),
      KEY retrieved_at (retrieved_at)
    );
SQL;
  
  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  dbDelta($sql);

  update_option("petpoint_db_version", "1.0");
}
register_activation_hook(__FILE__, 'petpoint_install');


function query_pets($params = array()) {
  global $petpoint;
  $petpoint = new PetPoint_API("search", $params);
}


function query_pet($params) {
  global $petpoint;
  $petpoint = new PetPoint_API("detail", $params);
}


function have_pets() {
  global $petpoint;
  return $petpoint->has_next();
}


function the_pet() {
  global $petpoint;
  $petpoint->next();
}


function rewind_pets() {
  global $petpoint;
  $petpoint->rewind();
}


function the_pet_object() {
  global $petpoint;
  return $petpoint->current();
}


function test_pet() {
  global $petpoint;
  $petpoint->next();
  print_r(the_pet_object());
  $petpoint->next();
  print_r(the_pet_object());
  $petpoint->next();
  print_r(the_pet_object());
  $petpoint->next();
  print_r(the_pet_object());
  $petpoint->next();
  print_r(the_pet_object());
  $petpoint->next();
  print_r(the_pet_object());
}


function the_pet_image() {

}


function the_pet_species() {

}


function the_pet_sex() {

}


function the_pet_primary_breed() {

}


function the_pet_age() {

}


function the_pet_no_dogs() {

}


function the_pet_no_cats() {

}


function the_pet_no_kids() {

}


function the_pet_behavior_result() {

}


function the_pet_memo_list() {

}


function the_pet_arn() {

}


function the_pet_behavior_test_list() {

}


function the_pet_stage() {

}


function the_pet_animal_type() {

}


function the_pet_age_group() {

}


function the_pet_wildlife_intake_injury() {

}


function the_pet_wildlife_intake_cause() {

}


function the_pet_buddy_id() {

}


function petpoint_settings_api_init() {
  // deal with $_POSTed data
  if (isset($_POST['petpoint_authkey']))
    update_option('petpoint_authkey', $_POST['petpoint_authkey']);

  add_settings_section('petpoint',
    'PetPoint API',
    'petpoint_setting_section_callback_function',
    'media');
  
  add_settings_field('petpoint_authkey',
    'Authentication key',
    'petpoint_setting_callback_function',
    'media',
    'petpoint');
  
  register_setting('media','petpoint_setting_callback_function');
}
add_action('admin_init', 'petpoint_settings_api_init');


function petpoint_setting_section_callback_function() {}

 
function petpoint_setting_callback_function() {
  echo '<input name="petpoint_authkey" id="petpoint_authkey" type="text" 
           class="code" size=50 value="' . get_option('petpoint_authkey'). '" />';
}

?>
