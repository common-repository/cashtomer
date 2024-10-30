<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wordpress.org
 * @since             1.0.0
 * @package           Cashtomer
 *
 * @wordpress-plugin
 * Plugin Name:       Cashtomer
 * Plugin URI:        https://wordpress.org
 * Description:       A simple Woocommerce Loyalty Plugin to boost your brand growth
 * Version:           1.0.0
 * Author:            Cashtomer
 * Author URI:        https://wordpress.org
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cashtomer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'Cashtomer_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cashtomer-points-activator.php
 */
function activate_Cashtomer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cashtomer-points-activator.php';
	Cashtomer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woocommerce-cashtomer-deactivator.php
 */
function deactivate_Cashtomer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cashtomer-points-deactivator.php';
	Cashtomer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Cashtomer' );
register_deactivation_hook( __FILE__, 'deactivate_Cashtomer' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cashtomer-points.php';
require plugin_dir_path( __FILE__ ) . 'includes/cashtomer-points-function.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_Cashtomer() {
	$plugin = new Cashtomer();
	$plugin->run();
}
run_Cashtomer();

function cashtomer_personal_email_from( $from_email ) {
	$sitename = strtolower( $_SERVER['SERVER_NAME'] );
	if ( 'www.' === substr( $sitename, 0, 4 ) ) {
		$sitename = substr( $sitename, 4 );
	}
	if ( 'wordpress@' . $sitename === $from_email ) {
		//$from_email = get_bloginfo( 'admin_email' );
		$from_email = 'no-reply@' . $sitename;
	}
	return $from_email;
}
add_filter( 'wp_mail_from', 'cashtomer_personal_email_from' );
function cashtomer_personal_email_from_name( $from_name ) {
	if ( 'WordPress' === $from_name ) {
		//$from_name = get_bloginfo( 'name' );
		$from_name = 'rewards';
	}
	return $from_name;
}
add_filter( 'wp_mail_from_name', 'cashtomer_personal_email_from_name' );

add_action("wp_ajax_cashtomer_total_coins", "cashtomer_total_coins");
add_action("wp_ajax_nopriv_cashtomer_total_coins", "cashtomer_total_coins");

function cashtomer_total_coins(){
	$customer_user_id = get_current_user_id();
	
	$spent_point = sanitize_text_field($_POST['total_coins']);	
	$coupon_code = sanitize_text_field($_POST['coupon_code']);
	$rewardtype = sanitize_text_field($_POST['rewardtype']);
	
	$total_point = get_user_meta($customer_user_id, 'total_point', true);
	$updated_points = $total_point - $spent_point;
	
	update_user_meta($customer_user_id, 'total_point', $updated_points);
	$new_point = get_user_meta($customer_user_id, 'total_point', true);
	
	global $wpdb;
	$table = $wpdb->prefix.'customer_redeem_details';
	
	$wpdb->insert($table, array(
		'customer_id' => $customer_user_id,
		'coupon_code' => $coupon_code,
		'rewardtype' => $rewardtype,
		'coupon_status' => 'true'
	));	
	echo $new_point;
	
	die();
}

add_action("wp_ajax_cashtomer_social_coins", "cashtomer_social_coins");
add_action("wp_ajax_nopriv_cashtomer_social_coins", "cashtomer_social_coins");

function cashtomer_social_coins(){
	$customer_user_id = get_current_user_id();
	
	$social_coins = sanitize_text_field($_POST['social_coins']);	
	$socialtype = sanitize_text_field($_POST['socialtype']);
	
	$total_point = get_user_meta($customer_user_id, 'total_point', true);
	$updated_points = $total_point + $social_coins;
	
	update_user_meta($customer_user_id, 'total_point', $updated_points);
	$new_point = get_user_meta($customer_user_id, 'total_point', true);
	
	if(get_option('boxcoins')){ 
		$pointcurrency = get_option('boxcoins'); 
	}
	else
	{ 
		$pointcurrency = 'Boxcoins'; 
	}
	
	$current_user = wp_get_current_user();
	$to = $current_user->user_email;
	$message = '
	Hi '.$current_user->user_firstname.',
	<br>
	<p>For completing activity '.$socialtype.' on '.get_bloginfo( 'name' ).', you’ve won '.$social_coins.' '.$pointcurrency.'!</p>
	<p>Now, you can redeem these points as a coupon or save it for winning big rewards later.</p>
	<p>Thanks.</p>';

	$email = get_option('admin_email');
	$subject = "Congratulations! You’ve earned ".$social_coins.' '.$pointcurrency;
	$headers = 'Reply-To: ' . $email . "\r\n";
	
	$headers .= array('Content-Type: text/html; charset=UTF-8');
	$sent = wp_mail($to, $subject, strip_tags($message), $headers);
	
	global $wpdb;
	$table = $wpdb->prefix.'customer_redeem_details';
	
	$wpdb->insert($table, array(
		'customer_id' => $customer_user_id,
		'coupon_code' => '',
		'rewardtype' => $socialtype,
		'coupon_status' => 'true'
	));	
	echo $new_point;
	die();
}