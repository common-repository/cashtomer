<?php
/**
 * Fired during plugin activation
 *
 * @link       https://wordpress.org
 * @since      1.0.0
 *
 * @package    Cashtomer
 * @subpackage Cashtomer/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Cashtomer
 * @subpackage Cashtomer/includes
 * @author     Sasi Dharan <tellsasidharan@gmail.com>
 */
class Cashtomer_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $table_prefix, $wpdb;
		$table_name = 'reward_programs';
		$wp_track_table = $table_prefix . "$table_name";

		if($wpdb->get_var( "show tables like '$wp_track_table'" ) != $wp_track_table) 
		{
			$sql = "CREATE TABLE $wp_track_table (
			  id int(11) NOT NULL AUTO_INCREMENT,
			  earntype varchar(255) NOT NULL,
			  points varchar(255) NOT NULL,
			  status varchar(100) NOT NULL,
			  PRIMARY KEY (id)
			) $charset_collate;";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
		
		$table_name1 = 'coupon_reward_programs';
		$wp_track_table1 = $table_prefix . "$table_name1";

		if($wpdb->get_var( "show tables like '$wp_track_table1'" ) != $wp_track_table1) 
		{
			$sql = "CREATE TABLE $wp_track_table1 (
			  id int(11) NOT NULL AUTO_INCREMENT,
			  rewardtype varchar(255) NOT NULL,
			  points_cost varchar(255) NOT NULL,
			  discount_value varchar(255) NOT NULL,
			  min_requirement varchar(255) NOT NULL,
			  coupon_code varchar(255) NOT NULL,
			  status varchar(100) NOT NULL,
			  PRIMARY KEY (id)
			) $charset_collate;";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
		
		$table_name2 = 'social_reward_programs';
		$wp_track_table2 = $table_prefix . "$table_name2";

		if($wpdb->get_var( "show tables like '$wp_track_table2'" ) != $wp_track_table2) 
		{
			$sql = "CREATE TABLE $wp_track_table2 (
			  id int(11) NOT NULL AUTO_INCREMENT,
			  socialtype varchar(255) NOT NULL,
			  socialurl varchar(255) NOT NULL,
			  points varchar(255) NOT NULL,
			  status varchar(100) NOT NULL,
			  PRIMARY KEY (id)
			) $charset_collate;";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
		
		$table_name3 = 'customer_redeem_details';
		$wp_track_table3 = $table_prefix . "$table_name3";

		if($wpdb->get_var( "show tables like '$wp_track_table3'" ) != $wp_track_table3) 
		{
			$sql = "CREATE TABLE $wp_track_table3 (
			  id int(11) NOT NULL AUTO_INCREMENT,
			  customer_id varchar(255) NOT NULL,
			  coupon_code varchar(255) NOT NULL,
			  rewardtype varchar(255) NOT NULL,
			  coupon_status varchar(255) NOT NULL,
			  PRIMARY KEY (id)
			) $charset_collate;";
			
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
	}
}