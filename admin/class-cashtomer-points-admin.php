<?php

/**
* The admin-specific functionality of the plugin.
*
* @link       https://wordpress.org
* @since      1.0.0
*
* @package    Cashtomer
* @subpackage Cashtomer/admin
*/

/**
* The admin-specific functionality of the plugin.
*
* Defines the plugin name, version, and two examples hooks for how to
* enqueue the admin-specific stylesheet and JavaScript.
*
* @package    Cashtomer
* @subpackage Cashtomer/admin
* @author     Sasi Dharan <tellsasidharan@gmail.com>
*/
class Cashtomer_Admin {

/**
* The ID of this plugin.
*
* @since    1.0.0
* @access   private
* @var      string    $plugin_name    The ID of this plugin.
*/
private $plugin_name;

/**
* The version of this plugin.
*
* @since    1.0.0
* @access   private
* @var      string    $version    The current version of this plugin.
*/
private $version;

/**
* Initialize the class and set its properties.
*
* @since    1.0.0
* @param      string    $plugin_name       The name of this plugin.
* @param      string    $version    The version of this plugin.
*/
public function __construct( $plugin_name, $version ) {

$this->plugin_name = $plugin_name;
$this->version = $version;

add_action( 'admin_menu', array( $this, 'points_add_plugin_page' ) );
add_action( 'admin_init', array( $this, 'points_page_init' ) );
}
/**
* Register the stylesheets for the admin area.
*
* @since    1.0.0
*/
public function enqueue_styles() {

/**
* This function is provided for demonstration purposes only.
*
* An instance of this class should be passed to the run() function
* defined in Cashtomer_Loader as all of the hooks are defined
* in that particular class.
*
* The Cashtomer_Loader will then create the relationship
* between the defined hooks and the functions defined in this
* class.
*/
if ( isset( $_GET['page'] ) && $_GET['page'] == 'points' || isset( $_GET['page'] ) && $_GET['page'] == 'customers' || isset( $_GET['page'] ) && $_GET['page'] == 'add-earn-point' || isset( $_GET['page'] ) && $_GET['page'] == 'add-reward-point' || isset( $_GET['page'] ) && $_GET['page'] == 'add-social-point' ) {
	wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cashtomer-points-admin.css', array(), $this->version, 'all' );
}

}
/**
* Register the JavaScript for the admin area.
*
* @since    1.0.0
*/
public function enqueue_scripts() {

/**
* This function is provided for demonstration purposes only.
*
* An instance of this class should be passed to the run() function
* defined in Cashtomer_Loader as all of the hooks are defined
* in that particular class.
*
* The Cashtomer_Loader will then create the relationship
* between the defined hooks and the functions defined in this
* class.
*/

wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cashtomer-points-admin.js', array( 'jquery' ), $this->version, false );

}	
public function points_add_plugin_page() {
	add_submenu_page(
		'woocommerce',
		'Cashtomer',
		'Cashtomer',
		'manage_options',
		'points',
		array( $this, 'points_create_admin_page' )
	);
	add_submenu_page(
		'woocommerce',
		'Adjust Points', // page_title
		'Adjust Points', // menu_title
		'manage_options', // capability
		'customers', // menu_slug
		array( $this, 'customers_admin_page' ) // function
	);
	add_submenu_page(
		'options-writing.php',
		'Add ways to earn', // page_title
		'', // menu_title
		'manage_options', // capability
		'add-earn-point', // menu_slug
		array( $this, 'add_ways_to_earn' ) // function
	);
	add_submenu_page(
		'options-writing.php',
		'Add ways to earn', // page_title
		'', // menu_title
		'manage_options', // capability
		'add-social-point', // menu_slug
		array( $this, 'add_social_point' ) // function
	);
	add_submenu_page(
		'options-writing.php',
		'Add ways to redeem', // page_title
		'', // menu_title
		'manage_options', // capability
		'add-reward-point', // menu_slug
		array( $this, 'add_ways_to_reward' ) // function
	);
}
public function add_social_point() {
	include('view/socialadd.php');
}
public function add_ways_to_reward() {
	include('view/addreward.php');
}
public function add_ways_to_earn() {
	include('view/add.php');
}
public function customers_admin_page() {
	include('view/customers.php');
}   
public function points_create_admin_page() {
$this->points_options = get_option( 'points_option_name' ); 
?>
<?php settings_errors(); ?>
<form method="post" action="options.php" class="my-custom-form">
	<?php
		settings_fields( 'points_option_group' );
		do_settings_sections( 'points-admin' );		
		include('view/points.php');		
		submit_button();
	?>
</form>
<?php }
public function points_page_init() {
	register_setting( 'points_option_group', 'boxcoins' );
	register_setting( 'points_option_group', 'nameofprogram' );
	register_setting( 'points_option_group', 'pointdescription' );	
}
}