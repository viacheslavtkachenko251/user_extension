<?php 
/* 
 * Plugin name: user-extension
 * Description: test
 * */
define('UE_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('UE_PLUGIN_URL', plugin_dir_url(__FILE__)); 
 
require_once UE_PLUGIN_DIR . 'includes/ue-encoding.php';
require_once UE_PLUGIN_DIR . 'includes/ue-meta-manipulations.php';

/* init keys*/
register_activation_hook( __FILE__, 'ue_csr_generator' ); 

/* registration */
add_filter( 'registration_errors', 'add_registration_errors' );
add_action( 'register_form', 'register_form_add_field' );
add_filter( 'insert_user_meta', 'ue_user_registration_meta', 10, 3 );

/* show user meta from admin */
add_action('show_user_profile', 'ue_profile_new_fields_add');
add_action('edit_user_profile', 'ue_profile_new_fields_add');

/* update user meta from admin */
add_action('personal_options_update', 'ue_update_user_meta');
add_action('edit_user_profile_update', 'ue_update_user_meta');

add_filter('template_include', 'ue_tpl_include');

add_shortcode( 'users', 'shortcode_users' );
