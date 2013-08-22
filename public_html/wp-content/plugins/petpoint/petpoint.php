<?php
/*
Plugin Name: The PetPoint Loop
Description: Provide the WordPress Loop-like interface to PetPoint APIs.  Set your authentication key under "Settings" > "Media".
Version: 0.1
Author: Jiehan Zheng
Author URI: http://jiehan.org/
License: MIT
*/

require 'api.php';


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

function the_pet_debug() {
  global $petpoint;
  return $petpoint->dump();
}

function get_the_pet_path() {
  global $petpoint;
  return "/pet?animalID=" . get_the_pet_id();
}

function get_the_pet_id() {
  global $petpoint;
  return $petpoint->get_id();
}
function the_pet_id() { echo esc_html(get_the_pet_id()); }


function get_the_pet_name() {
  global $petpoint;
  return $petpoint->get_name();
}
function the_pet_name() { echo esc_html(get_the_pet_name()); }


function the_pet_has_images() {
  global $petpoint;
  return (boolean) $petpoint->get_image();
}


function get_the_pet_image() {
  global $petpoint;
  return $petpoint->get_image();
}
function the_pet_image() { echo esc_html(get_the_pet_image()); }


function get_the_pet_image2() {
  global $petpoint;
  return $petpoint->get_image2();
}
function the_pet_image2() { echo esc_html(get_the_pet_image2()); }


function get_the_pet_image3() {
  global $petpoint;
  return $petpoint->get_image3();
}
function the_pet_image3() { echo esc_html(get_the_pet_image3()); }


function get_the_pet_species() {
  global $petpoint;
  return $petpoint->get_species();
}
function the_pet_species() { echo esc_html(get_the_pet_species()); }


function get_the_pet_breed() {
  global $petpoint;
  return $petpoint->get_breed();
}
function the_pet_breed() { echo esc_html(get_the_pet_breed()); }


function get_the_pet_secondary_breed() {
  global $petpoint;
  return $petpoint->get_secondary_breed();
}
function the_pet_secondary_breed() { echo esc_html(get_the_pet_secondary_breed()); }


function get_the_pet_color() {
  global $petpoint;
  return $petpoint->get_color();
}
function the_pet_color() { echo esc_html(get_the_pet_color()); }


function get_the_pet_secondary_color() {
  global $petpoint;
  return $petpoint->get_secondary_color();
}
function the_pet_secondary_color() { echo esc_html(get_the_pet_secondary_color()); }


function get_the_pet_sex() {
  global $petpoint;
  return $petpoint->get_sex();
}
function the_pet_sex() { echo esc_html(get_the_pet_sex()); }


function get_the_pet_primary_breed() {

}


function get_the_pet_age() {

}


function get_the_pet_no_dogs() {

}


function get_the_pet_no_cats() {

}


function get_the_pet_no_kids() {

}


function get_the_pet_behavior_result() {

}


function get_the_pet_memo_list() {

}


function get_the_pet_arn() {

}


function get_the_pet_behavior_test_list() {

}


function get_the_pet_stage() {

}


function get_the_pet_animal_type() {

}


function get_the_pet_age_group() {

}


function get_the_pet_wildlife_intake_injury() {

}


function get_the_pet_wildlife_intake_cause() {

}


function get_the_pet_buddy_id() {

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
