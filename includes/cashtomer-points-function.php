<?php
add_action('show_user_profile', 'cashtomer_user_profile_edit_action');
add_action('edit_user_profile', 'cashtomer_user_profile_edit_action');
function cashtomer_user_profile_edit_action($user) {

$signuppoints = get_user_meta($user->ID, 'signup_point', true);
$total_point = get_user_meta($user->ID, 'total_point', true);
?>
<table class="form-table">
	<tr>
		<th><label for="signup_point">Signup Points</label></th>
		<td><input name="signup_point" type="type" id="signup_point" value="<?php if($signuppoints){ echo $signuppoints; } ?>"></td>
	</tr>
	<tr>
		<th><label for="signup_point">Total Points</label></th>
		<td><input name="total_point" type="type" id="total_point" value="<?php if($total_point){ echo $total_point; } ?>"></td>
	</tr>
</table>
<?php 
}
add_action('personal_options_update', 'cashtomer_user_profile_update_action');
add_action('edit_user_profile_update', 'cashtomer_user_profile_update_action');
function cashtomer_user_profile_update_action($user_id) {
  update_user_meta($user_id, 'signup_point', sanitize_text_field($_POST['signup_point']));
  update_user_meta($user_id, 'total_point', sanitize_text_field($_POST['total_point']));
}
add_action( 'user_register', 'cashtomer_registration_save', 10, 1 );
function cashtomer_registration_save( $user_id ) {

global $wpdb;
$table = $wpdb->prefix.'reward_programs';
$results = $wpdb->get_results("SELECT points FROM $table WHERE earntype = 'signup' AND status = 'active' ");

$defaultsignuppoints =  $results['0']->points;
update_user_meta($user_id, 'signup_point', $defaultsignuppoints);

$args = array(
	'customer_id' => $user_id,
	'return' => 'ids',
);
$orders = wc_get_orders($args);
if($orders){
	$placeorder_points = get_post_meta( $orders['0'], '_points' );
	$total_point = $defaultsignuppoints + $placeorder_points['0'];
}else if($defaultsignuppoints){
	$total_point = $defaultsignuppoints;
}else{
	$total_point = '';
}
update_user_meta($user_id, 'total_point', $total_point);

}

function cashtomer_save_extra_checkout_fields( $order_id, $posted ){
	
	global $wpdb;
	$table = $wpdb->prefix.'reward_programs';
	$results = $wpdb->get_results("SELECT points FROM $table WHERE earntype = 'placeorder' AND status = 'active' ");
	
	$order_total = get_post_meta ($order_id , '_order_total', true);
	
	$defaultplaceorderpoints =  $results['0']->points;	
	$defaultplaceorderpoints = $order_total * $defaultplaceorderpoints;

    if( isset( $defaultplaceorderpoints ) ) {
        update_post_meta( $order_id, '_points', sanitize_text_field( $defaultplaceorderpoints ) );
    }
	
	$current_user = wp_get_current_user();
	$current_user_id = $current_user->ID;
	
	$signuppoints = get_user_meta( $current_user_id, 'signup_point', true);
	$total_point_old = get_user_meta($current_user_id, 'total_point', true);

	$order = wc_get_order( $order_id );
	
	if($order->get_used_coupons()){
		foreach( $order->get_used_coupons() as $coupon_code ){

			$coupon_post_obj = get_page_by_title($coupon_code, OBJECT, 'shop_coupon');
			$coupon_id       = $coupon_post_obj->ID;
			$coupon = new WC_Coupon($coupon_id);
			$couponcode = get_the_title($coupon_id);
			
			global $wpdb;
			$table = $wpdb->prefix.'coupon_reward_programs';	
			$results = $wpdb->get_results("SELECT * FROM $table WHERE coupon_code = '".$couponcode."'");
			$points_cost = $results[0]->points_cost;
			$total_point = $total_point_old + $defaultplaceorderpoints;
		}
	}else{	
		$total_point = $total_point_old + $defaultplaceorderpoints;
	}
	update_user_meta($current_user_id, 'total_point', $total_point);
}
add_action( 'woocommerce_checkout_update_order_meta', 'cashtomer_save_extra_checkout_fields', 10, 2 );

function cashtomer_display_order_data_in_admin( $order ){  ?>
    <div class="order_data_column">
        <h4><?php _e( 'Loyalty Points Information', 'woocommerce' ); ?><a href="#" class="edit_address"><?php _e( 'Edit', 'woocommerce' ); ?></a></h4>
        <div class="address">
        <?php
            echo '<p><strong>' . __( 'Points' ) . ':</strong>' . get_post_meta( $order->id, '_points', true ) . '</p>';
		?>	
        </div>
        <div class="edit_address">
            <?php woocommerce_wp_text_input( array( 'id' => '_points', 'label' => __( 'Points' ), 'wrapper_class' => '_billing_company_field' ) ); ?>
        </div>
    </div>
<?php 
}
add_action( 'woocommerce_admin_order_data_after_order_details', 'cashtomer_display_order_data_in_admin' );

function cashtomer_save_extra_details( $post_id, $post ){
    update_post_meta( $post_id, '_points', wc_clean( $_POST[ '_points' ] ) );
}
add_action( 'woocommerce_process_shop_order_meta', 'cashtomer_save_extra_details', 45, 2 );

function cashtomer_email_order_meta_fields( $fields, $sent_to_admin, $order ) {
    $fields['instagram'] = array(
                'label' => __( 'Points' ),
                'value' => get_post_meta( $order->id, '_points', true ),
            );
    return $fields;
}
add_filter('woocommerce_email_order_meta_fields', 'cashtomer_email_order_meta_fields', 10, 3 );

function cashtomer_show_email_order_meta( $order, $sent_to_admin, $plain_text ) {
    $points = get_post_meta( $order->id, '_points', true );

    if( $plain_text ){
        echo 'The value for point is ' . $points;
    } else {
        echo '<p>The value for <strong>point</strong> is ' . $points. '</p>';
    }
}
add_action('woocommerce_email_customer_details', 'cashtomer_show_email_order_meta', 30, 3 );

function cashtomer_display_order_data( $order_id ){  ?>
    <h2><?php _e( 'Loyalty Points Information' ); ?></h2>
    <table class="shop_table shop_table_responsive additional_info">
        <tbody>
            <tr>
                <th><?php _e( 'Loyalty Points:' ); ?></th>
                <td><?php echo get_post_meta( $order_id, '_points', true ); ?></td>
            </tr>
        </tbody>
    </table>
<?php
$placeorderpoints = get_post_meta( $order_id, '_points', true );
$current_user = wp_get_current_user();
$to = $current_user->user_email;

if(get_option('boxcoins')){ 
	$pointcurrency = get_option('boxcoins'); 
}
else
{ 
	$pointcurrency = 'Boxcoins'; 
}

$message = '
Hi '.$current_user->user_firstname.',
<br>
<p>For completing activity <strong>place order</strong> on '.get_bloginfo( 'name' ).', you’ve won '.$placeorderpoints.' '.$pointcurrency.'!</p>
<p>Now, you can redeem these points as a coupon or save it for winning big rewards later.</p><br>
<p>Thanks.</p>';

$email = get_option('admin_email');
$subject = "Congratulations! You’ve earned ".$placeorderpoints.' '.$pointcurrency;

$headers = 'From: '. $email . "\r\n" .
'Reply-To: ' . $email . "\r\n";

$headers .= array('Content-Type: text/html; charset=UTF-8');
$sent = wp_mail($to, $subject, strip_tags($message), $headers);

$subject2 = "Hurray! You’ve unlocked a coupon";

global $wpdb;
$table = $wpdb->prefix.'coupon_reward_programs';
$customer_user_id = get_current_user_id();
$total_point = get_user_meta($customer_user_id, 'total_point', true);

$results2 = $wpdb->get_results("SELECT * FROM $table WHERE points_cost <= ".$total_point."");
if($results2):
foreach($results2 as $result){
	
$message2 = '
Hi '.$current_user->user_firstname.',
<br>
<p>You have redeemed your points and unlocked a new coupon.</p>
<p>Now, you can redeem these points as a coupon or save it for winning big prizes later.</p><br>		
<p>The coupon code is <strong>'.$result->coupon_code.'</strong></p>
<p>This code is one-time usable and please keep this code secret.</p><br>
<p>Thank you so much.</p>
<div style="text-align:center;">
<p>Sent to '.$to.' From <a href="'.site_url().'">'.site_url().'</a></p>
<p>Email preferences</p>
</div>
';
	
}
endif;

$sent = wp_mail($to, $subject2, strip_tags($message2), $headers);

}
add_action( 'woocommerce_thankyou', 'cashtomer_display_order_data', 20 );
add_action( 'woocommerce_view_order', 'cashtomer_display_order_data', 20 );

function send_welcome_email_to_new_user($user_id) {
    $user = get_userdata($user_id);
    $user_email = $user->user_email;
    $user_full_name = $user->user_firstname . $user->user_lastname;
	$signuppoints = get_user_meta($user_id, 'signup_point', true);
    $to = $user_email;
	if(get_option('boxcoins')){ 
	$pointcurrency = get_option('boxcoins'); 
	}
	else
	{ 
		$pointcurrency = 'Boxcoins'; 
	}
	$subject = "Congratulations! You’ve earned ".$signuppoints.' '.$pointcurrency;
    
	$body = '
	Hi '.$current_user->user_firstname.',
	<br>
	<p>For completing activity <strong>signup</strong> on '.get_bloginfo( 'name' ).', you’ve won '.$signuppoints.' '.$pointcurrency.'!</p>
	<p>Now, you can redeem these points as a coupon or save it for winning big rewards later.</p><br>
	<p>Thanks.</p>';
	
    $headers = array('Content-Type: text/html; charset=UTF-8');
    if (wp_mail($to, $subject, $body, $headers)) {
      error_log("email has been successfully sent to user whose email is " . $user_email);
    }else{
      error_log("email failed to sent to user whose email is " . $user_email);
    }
  }
add_action('user_register', 'send_welcome_email_to_new_user');

add_shortcode( 'cashtomer-points-details', 'cashtomer_points_details' );
function cashtomer_points_details() {
	ob_start();
	
	$current_user = wp_get_current_user();
	
	if ( in_array( 'customer', (array) $current_user->roles ) ) {
		
	$customer_user_id = get_current_user_id();
	$total_point = get_user_meta($customer_user_id, 'total_point', true);
	
	global $wpdb;
	$table = $wpdb->prefix.'coupon_reward_programs';
	?>
	<button class="chatbox-open my-rewards">
	My Rewards
	</button>
	<button class="chatbox-close">
	<i class="fa fa-close fa-2x" aria-hidden="true"></i>
	</button>
	<section class="chatbox-popup">
	<header class="chatbox-popup__header">
	<aside style="flex:12">
	<a href="javascript:void(0);" class="chatbox-close"><i class="fa fa-close fa-2x" aria-hidden="true"></i></a>
	<p class="point-title">
	<span id="prev-cd">&lt;</span> 
	<span id="prev-rd">&lt;</span>
	<span id="prev-rr">&lt;</span>
	<span id="prev">&lt;</span> 
	<span id="new-prev">&lt;</span>
	<?php if(get_option('nameofprogram')){ echo get_option('nameofprogram'); }else { echo esc_html( __( 'Acme Rewards', 'cashtomer') ); } ?></p>
	<span class="total-points"><?php if($total_point){ echo $total_point; }?> <?php if(get_option('boxcoins')){ echo get_option('boxcoins'); } else { echo esc_html( __( 'Cashtomer Coins', 'cashtomer') ); } ?></span>
	</aside>
	</header>
	<main class="chatbox-popup__main">
		<div class="main-box all-reward">
			<div class="box reward-box reward-1">
			<div class="list-point reward-new">
			<a href="javascript:void(0);" id="next-rd">
			<p class="way-to">Unlocked Rewards <span>&gt;</span></p>			
			</a>
			</div>
			</div>
			<div class="box reward-box reward-2">
				<div class="coupon-list">
				<?php
				$order_statuses = array('wc-on-hold', 'wc-processing', 'wc-completed');
				$customer_user_id = get_current_user_id();
				$customer_orders = wc_get_orders( array(
					'meta_key' => '_customer_user',
					'meta_value' => $customer_user_id,
					'post_status' => $order_statuses,
					'numberposts' => -1
				) );
				$couponarray = array();
				foreach($customer_orders as $order ){
					$order_id = method_exists( $order, 'get_id' ) ? $order->get_id() : $order->id;
					$order = wc_get_order( $order_id );
					if($order->get_used_coupons()){
						foreach( $order->get_used_coupons() as $coupon_code ){
							$couponarray[] = $coupon_code;
						}	
					}
				} 
				$results2 = $wpdb->get_results("SELECT * FROM $table WHERE status = 'active'");				
				foreach($results2 as $result){
				global $wpdb;
				if($result->rewardtype == 'amountdiscount'){
				
				$coupon_code = $result->coupon_code;
				$rewardtype = $result->rewardtype;
				$table3 = $wpdb->prefix.'customer_redeem_details';
				$result3 = $wpdb->get_results("SELECT * FROM $table3 WHERE customer_id = ".get_current_user_id()." AND coupon_code = '".$coupon_code."' AND rewardtype = '".$rewardtype."'");
				foreach($result3 as $customer_redem){	
					$coupon_status = $customer_redem->coupon_status;
					$coupon_code = $customer_redem->coupon_code;
					$rewardtype = $customer_redem->rewardtype;
				
				if($rewardtype == 'amountdiscount' && $coupon_status == true){
				?>
				<div class="coupon <?php if(in_array($result->coupon_code, $couponarray)){ echo esc_html( __( 'used-coupon', 'cashtomer') ); } ?>">
					<div class="coupon-left">
					<img class="list-item-image" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/fixed-amount.svg'; ?>">
						<p class="coipon-text_my_<?php echo $result->id; ?>"><?php echo $result->discount_value .get_woocommerce_currency_symbol(); ?> Off Coupon <br>
						<?php echo $result->points_cost; ?> <?php if(get_option('boxcoins')){ echo get_option('boxcoins'); }else{ echo esc_html( __( 'Cashtomer Coins', 'cashtomer') ); } ?></p>
						<span class="code-show" id="my_<?php echo $result->id; ?>">
							<strong><?php echo $result->coupon_code; ?></strong>
						</span>
					</div>
					<div class="coupon-right">
					<a href="javascript:void(0);" id="coupon_<?php echo $result->id; ?>" class="button code-view">View</a>
					</div>					
				</div>
				<?php } } }
				
				if($result->rewardtype == 'percentageoff'){ 
				
				$coupon_code = $result->coupon_code;
				$rewardtype = $result->rewardtype;
				$table3 = $wpdb->prefix.'customer_redeem_details';
				$result3 = $wpdb->get_results("SELECT * FROM $table3 WHERE customer_id = ".get_current_user_id()." AND coupon_code = '".$coupon_code."' AND rewardtype = '".$rewardtype."'");
				foreach($result3 as $customer_redem){	
					$ncoupon_status = $customer_redem->coupon_status;
					$ncoupon_code = $customer_redem->coupon_code;
					$nrewardtype = $customer_redem->rewardtype;
				
				if($nrewardtype == 'percentageoff' && $ncoupon_status == true){
				?>
				<div class="coupon <?php if(in_array($result->coupon_code, $couponarray)){ echo 'used-coupon'; } ?>">
					<div class="coupon-left">
					<img class="list-item-image" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/fixed-amount.svg'; ?>">
					<p class="coipon-text_my_<?php echo $result->id; ?>"><?php echo $result->discount_value; ?> % Off Coupon <br>
					<?php echo $result->points_cost; ?> <?php if(get_option('boxcoins')){ echo get_option('boxcoins'); }else{ echo esc_html( __( 'Cashtomer Coins', 'cashtomer') ); } ?></p>
					</div>
					<div class="coupon-right">
					<a href="javascript:void(0);" id="coupon_<?php echo $result->id; ?>" class="button code-view">View</a>
					</div>					
				</div>
				<?php } } } } ?>
				<?php if($coupon_status  != true && $ncoupon_status != true){ ?>	
				<div class="no-rewards">	
				<strong>No rewards yet.</strong>
				<p>When you unlock any coupon, you'll see them here</p><br>
				<a href="javascript:void(0);" id="go-back">Go back</a>
				</div>
				<?php } ?>
				</div>
			</div>			
			<div class="box reward-box reward-3">
				<?php foreach($results2 as $result){ ?>
				<?php if($result->rewardtype == 'amountdiscount'){ ?>
				<div class="list-point default-hide rshow<?php echo $result->id; ?>" >
					<img class="list-item-image" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/fixed-amount.svg'; ?>">
					<?php echo get_woocommerce_currency_symbol(); ?><?php echo $result->discount_value; ?> off your next order
					<p>
					<?php echo $result->points_cost; ?>&nbsp;<?php if(get_option('boxcoins')){ echo get_option('boxcoins'); }else{ echo esc_html( __( 'Cashtomer Coins', 'cashtomer') ); } ?></a> 
					</p>
					<p>This coupon offers <?php echo get_woocommerce_currency_symbol(); ?><?php echo $result->discount_value; ?> off on the total price of your next order.</p>
					<div class="final-code <?php if(in_array($result->coupon_code, $couponarray)){ echo esc_html( __( 'used-coupon', 'cashtomer') ); } ?>">
						<?php echo $result->coupon_code; ?>
					</div>	
				</div>					
				<?php } ?>
				<?php if($result->rewardtype == 'percentageoff'){ ?>								
				<div class="list-point default-hide rshow<?php echo $result->id; ?>" >
				<img class="list-item-image" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/fixed-amount.svg'; ?>">
				<?php echo $result->discount_value; ?> % off your next order
				<p>
				<?php echo $result->points_cost; ?>&nbsp;<?php if(get_option('boxcoins')){ echo get_option('boxcoins'); }else{ echo esc_html( __( 'Cashtomer Coins', 'cashtomer') ); } ?> 
				</p>
				<p>This coupon offers <?php echo $result->discount_value; ?> % off on the total price of your next order.</p>
				<div class="final-code <?php if(in_array($result->coupon_code, $couponarray)){ echo esc_html( __( 'used-coupon', 'cashtomer') ); } ?>">
					<?php echo $result->coupon_code; ?>
				</div>
				</div>
				<?php } ?>				
				<?php } ?>
			</div>			
		</div>		
		<div class="chatbox-popup__main join-now-box redeem-now-box divs">
			<div class="main-box">
				<div class="box box-2">
					<span><?php if(get_option('boxcoins')){ echo get_option('boxcoins'); }else{ echo esc_html( __( 'Cashtomer Coins', 'cashtomer') ); } ?></span>
					<p><?php echo 'Earn more '.get_option('boxcoins').' For Different Actions, And Unlock Coupons Using Those '.get_option('boxcoins').''; ?></p>
					<div class="list-point">
						<a href="javascript:void(0);" id="next1">
						<img class="list-item-image" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/coupon.png'; ?>">
						<p>Ways to earn <span>&gt;</span></p>			
						</a>
					</div>
					<div class="list-point">
						<a href="javascript:void(0);" id="next2">
						<img class="list-item-image" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/percentage.png'; ?>">
						<p>Ways To Unlock <span>&gt;</span></p>			
					</a>
					</div>
				</div>
			</div>
			<div class="main-box">		
				<div class="main-box1">
					<p class="way-to">Ways to earn</p>
						<div class="box-new box-2">
						<?php 
						global $wpdb;
						$table = $wpdb->prefix.'reward_programs';
						$table2 = $wpdb->prefix.'coupon_reward_programs';
						$result = $wpdb->get_results("SELECT * FROM $table WHERE status = 'active'");
						$current_user = wp_get_current_user();
						foreach($result as $row){
							if($row->earntype == 'placeorder'){
								$label_name = 'Place an order';	
								$icon = plugin_dir_url( __FILE__ ) . 'images/order-online.svg';
								$numorders = wc_get_customer_order_count( $current_user->ID );
								if($numorders){
									$finished = "<div class='process-right'>&#10004;</div>";
								}else{
									$finished = "<div class='process-right'><a href='".site_url()."/shop'>&gt;</a></div>";
								}
							} 					
							if($row->earntype == 'signup'){
								$label_name = 'Signup';
								$icon = plugin_dir_url( __FILE__ ) . 'images/signup.svg';								
								$signuppoints = get_user_meta($current_user->ID, 'signup_point', true);
								if($signuppoints){
									$finished = "<div class='process-right'>&#10004;</div>";
								}else{
									$finished = "<div class='process-right'><a href='".site_url()."/my-account'>&gt;</a></div>";
								}
							}
						?>
						<div class="list-point process-main">
							<div class="process-left">
							<a href="javascript:void(0);">
								<img class="list-item-image" src="<?php echo $icon; ?>">
								<p><?php echo $row->earntype; ?><br><?php echo $row->points; ?>&nbsp;<?php if(get_option('boxcoins')){ echo get_option('boxcoins'); }else{ echo esc_html( __( 'Cashtomer Coins', 'cashtomer') ); } ?> <?php if($row->earntype == 'placeorder'){ ?>for every <?php echo get_woocommerce_currency_symbol(); ?>1 spent<?php } ?></p>								
							</a>
							</div>
							<?php if($finished){ echo $finished; } ?>							
						</div>
						<?php } ?>
						<?php 
						$socialtable = $wpdb->prefix.'social_reward_programs';
						$socialresult = $wpdb->get_results("SELECT * FROM $socialtable WHERE status = 'active'");
						foreach($socialresult as $row){ 
						if($row->socialtype == 'facebookshare'){
							$label_name = 'Share '.get_option( 'blogname' ).' on Facebook';
							$icon = plugin_dir_url( __FILE__ ) . 'images/facebook-share.svg';
						}
						if($row->socialtype == 'instagramfollow'){
							$label_name = 'Follow '.get_option( 'blogname' ).' on Instagram';
							$icon = plugin_dir_url( __FILE__ ) . 'images/instagram-follow.svg';
						}
						if($row->socialtype == 'twittershare'){
							$label_name = 'Share '.get_option( 'blogname' ).' on Twitter';
							$icon = plugin_dir_url( __FILE__ ) . 'images/twitter-share.svg';
						}
						if($row->socialtype == 'twitterfollow'){
							$label_name = 'Follow '.get_option( 'blogname' ).' on Twitter';
							$icon = plugin_dir_url( __FILE__ ) . 'images/twitter-follow.svg';
						}
						
						$socialstatuss = $wpdb->get_results("SELECT * FROM $table3 WHERE customer_id = ".get_current_user_id()." AND rewardtype = '".$row->socialtype."'");
						?>
						<div class="list-point process-main">
						<div class="coupon-left">
						<a href="javascript:void(0);">
							<img class="list-item-image social" src="<?php echo $icon; ?>">
							<p><?php echo $label_name; ?><br><?php echo $row->points; ?>&nbsp;<?php if(get_option('boxcoins')){ echo get_option('boxcoins'); }else{ echo esc_html( __( 'Cashtomer Coins', 'cashtomer') ); } ?></p>
							<input type="hidden" id="social_<?php echo $row->id; ?>" value="<?php echo $row->points; ?>">
							<input type="hidden" id="socialtype_<?php echo $row->id; ?>" value="<?php echo $row->socialtype; ?>">
						</a>
						</div>
						<?php if($row->socialtype == 'facebookshare'){ 
						if($socialstatuss):
						$facebooksharestatus = array();
						foreach($socialstatuss as $socialstatus){
							$facebooksharestatus[] = $facebooksharesocialstatus->coupon_status;
						}
						endif;
						if($facebooksharestatus == true){
						?>
						<div class="coupon-right">
						<div class='process-right'>&#10004;</div>
						</div>
						<?php						
						}else{
						?>	
						<div class="coupon-right">
						<a href="javascript:void(0);" id="button_<?php echo $row->id; ?>" class="button code-view" onclick="share_fb('<?php echo $row->socialurl; ?>');return false;" rel="nofollow" share_url="<?php echo $row->socialurl; ?>" target="_blank">
						Share</a>
						</div>
						<?php } ?>	
						<?php } ?>
						<?php if($row->socialtype == 'instagramfollow'){ 
						if($socialstatuss):
						$instagramfollowstatus = array();
						foreach($socialstatuss as $socialstatus){
							$instagramfollowstatus[] = $socialstatus->coupon_status;
						}
						endif;
						if($instagramfollowstatus == true){
						?>
						<div class="coupon-right">
						<div class='process-right'>&#10004;</div>
						</div>
						<?php						
						}else{
						?>						
						<div class="coupon-right">
						<a href="https://www.instagram.com/<?php echo $row->socialurl; ?>" id="button_<?php echo $row->id; ?>" class="button code-view" target="_blank">Follow</a>
						</div>	
						<?php } ?>
						<?php } ?>
						<?php if($row->socialtype == 'twittershare'){ 
						if($socialstatuss):
						$twittersharestatus = array();
						foreach($socialstatuss as $socialstatus){
							$twittersharestatus[] = $socialstatus->coupon_status;
						}
						endif;
						if($twittersharestatus == true){
						?>
						<div class="coupon-right">
						<div class='process-right'>&#10004;</div>
						</div>
						<?php						
						}else{
						?>	
						<div class="coupon-right">						
						<a href="https://twitter.com/share?url=<?php echo $row->socialurl; ?>" id="button_<?php echo $row->id; ?>" class="button code-view" target="_blank">Share</a>
						</div>
						<?php }	?>
						<?php }	?>
						<?php if($row->socialtype == 'twitterfollow'){ 
						if($socialstatuss):
						$twitterfollowstatus = array();
						foreach($socialstatuss as $socialstatus){
							$twitterfollowstatus[] = $socialstatus->coupon_status;
						}
						endif;
						if($twitterfollowstatus == true){
						?>
						<div class="coupon-right">
						<div class='process-right'>&#10004;</div>
						</div>
						<?php						
						}else{
						?>
						<div class="coupon-right">
						<a href="https://twitter.com/<?php echo $row->socialurl; ?>?ref_src=twsrc%5Etfw" id="button_<?php echo $row->id; ?>" class="button code-view" data-show-count="false" target="_blank">Follow</a>
						<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
						</div>
						<?php }	?>
						<?php }	?>
						</div>	
						<script>
						jQuery(document).ready(function(){
							jQuery("#button_<?php echo $row->id; ?>").click(function(){
							    var social_coins = jQuery('#social_<?php echo $row->id; ?>').val();
								var socialtype = jQuery('#socialtype_<?php echo $row->id; ?>').val();			
								
								jQuery.ajax({
									 type : "post",
									 url  : "<?php echo admin_url( 'admin-ajax.php' ); ?>",
									 data : {action: "cashtomer_social_coins", social_coins : social_coins, socialtype : socialtype },
									 success: function(response) {
										 jQuery(".total-points").text(response);
										 window.location.href = "<?php echo site_url(); ?>";
									 }
								});  
							});
						});
						</script>
						<?php }	?>
						</div>
						<script>
						function share_fb(url) {
						  window.open('https://www.facebook.com/sharer/sharer.php?u='+url,'facebook-share-dialog',"width=626, height=436")
						}
						</script>
				</div>
				<div class="main-box2">
					<p class="way-to">Ways To Unlock</p>
						<div class="box-new box-2">
						<?php 
						global $wpdb;
						$table = $wpdb->prefix.'reward_programs';						
						$table2 = $wpdb->prefix.'coupon_reward_programs';
						$result2 = $wpdb->get_results("SELECT * FROM $table2 WHERE status = 'active'");						
						$table3 = $wpdb->prefix.'customer_redeem_details';						
						foreach($result2 as $row){	
						?>
						<div class="list-point">							
								<img class="list-item-image" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/fixed-amount.svg'; ?>">
								<?php if($row->rewardtype == 'amountdiscount'){ ?>								
								<?php echo get_woocommerce_currency_symbol(); ?><?php echo $row->discount_value; ?> off coupon								
								<?php if($row->points_cost <= $total_point){ ?>
								<a id="cnext<?php echo $row->id; ?>" href="javascript:void(0);" class="button code-view">View</a>
								<?php } ?>								
								<p>
								<?php echo $row->points_cost; ?> <?php if(get_option('boxcoins')){ echo get_option('boxcoins'); }else{ echo esc_html( __( 'Cashtomer Coins', 'cashtomer') ); } ?></a> 
								</p>
								<?php } ?>								
								<?php if($row->rewardtype == 'percentageoff'){ ?>								
								<?php echo $row->discount_value; ?> % off coupon								
								<?php if($row->points_cost <= $total_point){ ?>
								<a id="cnext<?php echo $row->id; ?>" href="javascript:void(0);" class="button code-view">View</a>
								<?php } ?>								
								<p>
								<?php echo $row->points_cost; ?>&nbsp;<?php if(get_option('boxcoins')){ echo get_option('boxcoins'); }else{ echo esc_html( __( 'Cashtomer Coins', 'cashtomer') ); } ?> 
								</p>
								<?php } ?>
						</div>
						<?php } ?>						
						</div>
				</div>
			</div>
			<div class="main-box">				
				<div class="main-box3">
				<?php foreach($result2 as $row){ ?>
					<div class="list-point default-hide show<?php echo $row->id; ?>" >						
						<img class="list-item-image" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/fixed-amount.svg'; ?>">
						<?php if($row->rewardtype == 'amountdiscount'){ ?>								
						<?php echo get_woocommerce_currency_symbol(); ?><?php echo $row->discount_value; ?> off your next order
						<p>
						<?php echo $row->points_cost; ?>&nbsp;<?php if(get_option('boxcoins')){ echo get_option('boxcoins'); }else{ echo esc_html( __( 'Cashtomer Coins', 'cashtomer') ); } ?></a> 
						</p>
						<p>This coupon offers <?php echo get_woocommerce_currency_symbol(); ?><?php echo $row->discount_value; ?> off on the total price of your next order.</p>						
						<?php 
						$oldcoupon_code = $row->coupon_code;
						$rewardtype = $row->rewardtype;
						$result3 = $wpdb->get_results("SELECT * FROM $table3 WHERE customer_id = ".get_current_user_id()." AND coupon_code = '".$oldcoupon_code."' AND rewardtype = '".$rewardtype."'");
							
							if($result3){
							foreach($result3 as $customer_redem){	
								$coupon_status = $customer_redem->coupon_status;
								$coupon_code = $customer_redem->coupon_code;
								$trewardtype = $customer_redem->rewardtype;
								$customer_id = $customer_redem->customer_id;
								
								if($coupon_status == true){	
								?>
								<div class="final-code">
									<?php echo $coupon_code; ?>
								</div>						
								<?php }
							} 
							}else{
								?>
								<div class="text-center">
									<a href="javascript:void(0);" id="final-redeem-<?php echo $row->id; ?>" class="button code-view final-redeem">Unlock</a>
									<input type="hidden" id="total_coins_<?php echo $row->id; ?>" name="total_coins" value="<?php echo $row->points_cost; ?>">
									<input type="hidden" id="rewardtype_<?php echo $row->id; ?>" name="rewardtype" value="<?php echo $row->rewardtype; ?>">
								</div>
								<?php
							}
						} 
						?>						
						<?php if($row->rewardtype == 'percentageoff'){ ?>								
						<?php echo $row->discount_value; ?> % off your next order
						<p>
						<?php echo $row->points_cost; ?>&nbsp;<?php if(get_option('boxcoins')){ echo get_option('boxcoins'); }else{ echo esc_html( __( 'Cashtomer Coins', 'cashtomer') ); } ?> 
						</p>
						<p>This coupon offers <?php echo $row->discount_value; ?> % off on the total price of your next order.</p>
						<?php 
						$oldncoupon_code = $row->coupon_code;
						$nrewardtype = $row->rewardtype;
						$nresult3 = $wpdb->get_results("SELECT * FROM $table3 WHERE customer_id = ".get_current_user_id()." AND coupon_code = '".$oldncoupon_code."' AND rewardtype = '".$nrewardtype."'");
						if($nresult3){
						foreach($nresult3 as $ncustomer_redem){	
							$ncoupon_status = $ncustomer_redem->coupon_status;
							$ncoupon_code = $ncustomer_redem->coupon_code;
							$nrewardtype = $ncustomer_redem->rewardtype;
								
						if($ncoupon_status == true){
						?>
						<div class="final-code">
							<?php echo $ncoupon_code; ?>
						</div>
						<?php }
						}
						}else{
						?>
						<div class="text-center">
							<a href="javascript:void(0);" id="final-redeem-<?php echo $row->id; ?>" class="button code-view final-redeem">Unlock</a>
							<input type="hidden" id="total_coins_<?php echo $row->id; ?>" name="total_coins" value="<?php echo $row->points_cost; ?>">
							<input type="hidden" id="rewardtype_<?php echo $row->id; ?>" name="rewardtype" value="<?php echo $row->rewardtype; ?>">
						</div>
						<?php							
						}
						} 
						?>
					</div>
					<span class="default-hide code-show-new-<?php echo $row->id; ?>" id="my_<?php echo $row->id; ?>">
						<strong><?php echo $row->coupon_code; ?></strong>
						<input type="hidden" id="coupon_code_<?php echo $row->id; ?>" name="coupon_code" value="<?php echo $row->coupon_code; ?>">
					</span>
				<?php } ?>	
			</div>
		</div>
	</main>
	</section>
	
	<?php foreach($result2 as $row){ ?>
	<script>
	jQuery(document).ready(function(){
		jQuery("#final-redeem-<?php echo $row->id; ?>").click(function(){
			var total_coins = jQuery('#total_coins_<?php echo $row->id; ?>').val();
			var coupon_code = jQuery('#coupon_code_<?php echo $row->id; ?>').val();
			var rewardtype = jQuery('#rewardtype_<?php echo $row->id; ?>').val();			
			
			jQuery.ajax({
				 type : "post",
				 url  : "<?php echo admin_url( 'admin-ajax.php' ); ?>",
				 data : {action: "cashtomer_total_coins", total_coins : total_coins, coupon_code : coupon_code, rewardtype : rewardtype },
				 success: function(response) {
					 jQuery(".total-points").text(response);
					 jQuery(".show<?php echo $row->id; ?>").hide();
					 jQuery(".code-show-new-<?php echo $row->id; ?>").show();
					 window.location.href = "<?php echo site_url(); ?>";
				 }
			});  
		});
	});	
	
	jQuery(document).ready(function(){
	jQuery("#new-prev").hide();	
	jQuery("#prev-rr").hide();
	jQuery("#prev").hide();
	jQuery("#prev-cd").hide();
	jQuery(".default-hide").hide();	
	
    jQuery(".divs .main-box").each(function(e) {
        if (e != 0)
            jQuery(this).hide();
    });	
	jQuery("#cnext<?php echo $row->id; ?>").click(function(){
		jQuery(".main-box1").hide();
		jQuery(".main-box2").hide();
		jQuery(".main-box3").show();
		jQuery(".show<?php echo $row->id; ?>").show();
		jQuery(".all-reward").hide();
		jQuery("#prev").hide();
		jQuery("#prev-cd").show();
		jQuery("#new-prev").hide();
		
		if (jQuery(".divs .main-box:visible").next().length != 0)
			jQuery(".divs .main-box:visible").next().show().prev().hide();
		else {
			jQuery(".divs .main-box:visible").hide();
			jQuery(".divs .main-box:first").show();
		}
		return false;
	});
		
	jQuery("#prev-cd").click(function(){
		jQuery("#prev-cd").hide();
		jQuery("#new-prev").show();
		jQuery(".divs .main-box:nth-child(3)").show();
		jQuery(".divs .main-box:nth-child(1)").hide();
		jQuery(".all-reward").hide();
		
		jQuery(".divs .main-box:nth-child(2)").show();
		jQuery(".main-box2").show();
		
		jQuery(".show<?php echo $row->id; ?>").hide();
		jQuery(".code-show-new-<?php echo $row->id; ?>").hide();
		return false;
    });
	
	jQuery("#coupon_<?php echo $row->id; ?>").click(function(){		
		jQuery(".reward-2").hide();
		jQuery(".reward-3").show();
		jQuery("#prev-rr").show();
		jQuery(".rshow<?php echo $row->id; ?>").show();
		jQuery("#prev").hide();
		jQuery("#prev-cd").hide();
		jQuery("#prev-rd").hide();
		return false;
	});	
	
	jQuery("#prev-rr").click(function(){
		jQuery(".reward-2").show();
		jQuery(".reward-3").hide();
		jQuery("#prev-rr").hide();
		jQuery("#prev-rd").show();
		jQuery(".reward-3 .default-hide").hide();
	});
	
	jQuery("#new-prev").click(function(){
		jQuery(".divs .main-box:nth-child(3)").hide();
		jQuery(".divs .main-box:nth-child(2)").hide();
		jQuery(".divs .main-box:nth-child(1)").show();
		jQuery(".all-reward").show();
		jQuery("#new-prev").hide();
	});
	
	});
	</script>
	<?php } ?>
	<script>
	jQuery(document).ready(function(){
		jQuery(".code-show").hide();
		jQuery("#prev-rd").hide();
		jQuery("#prev-cd").hide();
		jQuery("#prev-rr").hide();
		jQuery("#new-prev").hide();
		
	jQuery(".all-reward .reward-box").each(function(e) {
	if (e != 0)
		jQuery(this).hide();
	}); 
	jQuery("#next-rd").click(function(){		
		jQuery("#prev-rd").show();
		jQuery(".redeem-now-box").hide();
		jQuery("#new-prev").hide();
		
        if (jQuery(".all-reward .reward-box:visible").next().length != 0)
            jQuery(".all-reward .reward-box:visible").next().show().prev().hide();
        else {
            jQuery(".all-reward .reward-box:visible").hide();
            jQuery(".all-reward .reward-box:first").show();
        }
        return false;
    });
    jQuery("#prev-rd").click(function(){
		jQuery("#prev-rd").hide();
		jQuery(".redeem-now-box").show();
        if (jQuery(".all-reward .reward-box:visible").prev().length != 0)
            jQuery(".all-reward .reward-box:visible").prev().show().next().hide();
        else {
            jQuery$(".all-reward .reward-box:visible").hide();
            jQuery(".all-reward .reward-box:last").show();
        }
        return false;
    });
	
	jQuery("#go-back").click(function(){
		jQuery("#prev-rd").hide();
		jQuery(".redeem-now-box").show();
        if (jQuery(".all-reward .reward-box:visible").prev().length != 0)
            jQuery(".all-reward .reward-box:visible").prev().show().next().hide();
        else {
            jQuery$(".all-reward .reward-box:visible").hide();
            jQuery(".all-reward .reward-box:last").show();
        }
        return false;
    });
	
	});
	
	jQuery(document).ready(function(){
	jQuery("#prev").hide();
	
    jQuery(".divs .main-box").each(function(e) {
        if (e != 0)
            jQuery(this).hide();
    });    
    jQuery("#next1").click(function(){
		jQuery(".main-box2").hide();
		jQuery(".main-box3").hide();
		jQuery("#new-prev").hide();
		jQuery(".main-box1").show();
		jQuery(".all-reward").hide();
		jQuery("#prev").show();

        if (jQuery(".divs .main-box:visible").next().length != 0)
            jQuery(".divs .main-box:visible").next().show().prev().hide();
        else {
            jQuery(".divs .main-box:visible").hide();
            jQuery(".divs .main-box:first").show();
        }
        return false;
    });
	jQuery("#next2").click(function(){
		jQuery(".main-box1").hide();
		jQuery(".main-box3").hide();
		jQuery(".main-box2").show();
		jQuery("#prev").show();
		jQuery(".all-reward").hide();
		
        if (jQuery(".divs .main-box:visible").next().length != 0)
            jQuery(".divs .main-box:visible").next().show().prev().hide();
        else {
            jQuery(".divs .main-box:visible").hide();
            jQuery(".divs .main-box:first").show();
        }
        return false;
    });	

    jQuery("#prev").click(function(){
		jQuery("#prev").hide();
		jQuery(".all-reward").show();
        if (jQuery(".divs .main-box:visible").prev().length != 0)
            jQuery(".divs .main-box:visible").prev().show().next().hide();
        else {
            jQuery(".divs .main-box:visible").hide();
            jQuery(".divs .main-box:last").show();
        }
        return false;
    });	
	
	});
	
	jQuery(".my-rewards").click(function(){
	  jQuery(".my-rewards").hide();
	});
	jQuery(".chatbox-close").click(function(){
	  jQuery(".my-rewards").show();
	});
	</script>
	
	<?php
	}else{
	?>
	<button class="chatbox-open my-rewards">
	My Rewards
	</button>
	<button class="chatbox-close">
	<i class="fa fa-close fa-2x" aria-hidden="true"></i>
	</button>
	<section class="chatbox-popup">
	<header class="chatbox-popup__header">
	<aside style="flex:12">
	<a href="javascript:void(0);" class="chatbox-close"><i class="fa fa-close fa-2x" aria-hidden="true"></i></a>
	<h1 class="point-title"> <span id="prev">&lt;</span> <?php if(get_option('nameofprogram')){ echo get_option('nameofprogram'); }else{ echo esc_html( __( 'Welcome to our site', 'cashtomer') ); } ?></h1>
	</aside>
	</header>
	<main class="chatbox-popup__main join-now-box divs">
		<div class="main-box">
			<div class="box box-1">
			<span>Become a member</span>
			<p>Create Your Account And Start Unlocking Your Rewards.</p>
			<a href="<?php echo site_url(); ?>/my-account" class="button join-now">Join now</a>
			<p class="already-acc">Already have an account? <a href="<?php echo site_url(); ?>/my-account">Sign in</a></p>
			</div>	
			<div class="box box-2">
			<span><?php if(get_option('boxcoins')){ echo get_option('boxcoins'); }else{ echo esc_html( __( 'Cashtomer Coins', 'cashtomer') ); } ?></span>
			<p><?php echo 'Earn more '.get_option('boxcoins').' For Different Actions, And Unlock Coupons Using Those '.get_option('boxcoins').''; ?></p>
			<div class="list-point">
			<a href="javascript:void(0);" id="next1">
			<img class="list-item-image" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/coupon.png'; ?>">
			<p>Ways to earn <span>&gt;</span></p>			
			</a>
			</div>
			<div class="list-point">
			<a href="javascript:void(0);" id="next2">
			<img class="list-item-image" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/percentage.png'; ?>">
			<p>Ways To Unlock <span>&gt;</span></p>			
			</a>
			</div>
			</div>
		</div>
		<div class="main-box">		
				<div class="main-box1">
				<p class="way-to">Ways to earn</p>
				<div class="box-new box-2">
				<?php 
				global $wpdb;
				$table = $wpdb->prefix.'reward_programs';				
				$result = $wpdb->get_results("SELECT * FROM $table WHERE status = 'active'");
				
				foreach($result as $row){
					if($row->earntype == 'placeorder'){
						$label_name = esc_html( __( 'Place an order', 'cashtomer') );
						$icon = plugin_dir_url( __FILE__ ) . 'images/order-online.svg';
					} 
					if($row->earntype == 'signup'){
						$label_name = esc_html( __( 'Signup', 'cashtomer') );
						$icon = plugin_dir_url( __FILE__ ) . 'images/signup.svg';
					}
				?>
				<div class="list-point">
				<a href="javascript:void(0);">
					<img class="list-item-image" src="<?php echo $icon; ?>">
					<p><?php echo $row->earntype; ?><br><?php echo $row->points; ?>&nbsp;<?php if(get_option('boxcoins')){ echo get_option('boxcoins'); }else{ echo esc_html( __( 'Cashtomer Coins', 'cashtomer') ); } ?> <?php if($row->earntype == 'placeorder'){ ?>for every <?php echo get_woocommerce_currency_symbol(); ?>1 spent <?php } ?></p>
				</a>				
				</div>
				<?php } ?>
				<?php 
				$socialtable = $wpdb->prefix.'social_reward_programs';
				$socialresult = $wpdb->get_results("SELECT * FROM $socialtable WHERE status = 'active'");
				foreach($socialresult as $row){ 
				if($row->socialtype == 'facebookshare'){
					$label_name = 'Share '.get_option( 'blogname' ).' on Facebook';
					$icon = plugin_dir_url( __FILE__ ) . 'images/facebook-share.svg';
				}
				if($row->socialtype == 'instagramfollow'){
					$label_name = 'Follow '.get_option( 'blogname' ).' on Instagram';
					$icon = plugin_dir_url( __FILE__ ) . 'images/instagram-follow.svg';
				}
				if($row->socialtype == 'twittershare'){
					$label_name = 'Share '.get_option( 'blogname' ).' on Twitter';
					$icon = plugin_dir_url( __FILE__ ) . 'images/twitter-share.svg';
				}
				if($row->socialtype == 'twitterfollow'){
					$label_name = 'Follow '.get_option( 'blogname' ).' on Twitter';
					$icon = plugin_dir_url( __FILE__ ) . 'images/twitter-follow.svg';
				}
				?>
				<div class="list-point">
				<a href="javascript:void(0);">
					<img class="list-item-image social" src="<?php echo $icon; ?>">
					<p><?php echo $label_name; ?><br><?php echo $row->points; ?>&nbsp;<?php if(get_option('boxcoins')){ echo get_option('boxcoins'); }else{ echo esc_html( __( 'Cashtomer Coins', 'cashtomer') ); } ?></p>
				</a>				
				</div>	
				<?php }	?>
				</div>
				</div>
			
				<div class="main-box2">
				<p class="way-to">Ways To Unlock</p>
				<div class="box-new box-2">
				<?php 
				global $wpdb;
				$table = $wpdb->prefix.'reward_programs';
				
				$table2 = $wpdb->prefix.'coupon_reward_programs';
				$result2 = $wpdb->get_results("SELECT * FROM $table2 WHERE status = 'active'");
				foreach($result2 as $row){	
				?>
				<div class="list-point">
				<a href="javascript:void(0);">
				<img class="list-item-image" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/fixed-amount.svg'; ?>">
				<?php if($row->rewardtype == 'amountdiscount'){ ?>
				<p><?php echo get_woocommerce_currency_symbol(); ?><?php echo $row->discount_value; ?> off coupon<br><?php echo $row->points_cost; ?>&nbsp;<?php if(get_option('boxcoins')){ echo get_option('boxcoins'); }else{ echo esc_html( __( 'Cashtomer Coins', 'cashtomer') ); } ?></p>
				<?php } ?>
				<?php if($row->rewardtype == 'percentageoff'){ ?>
				<p><?php echo $row->discount_value; ?> % off coupon<br><?php echo $row->points_cost; ?>&nbsp;<?php if(get_option('boxcoins')){ echo get_option('boxcoins'); }else{ echo esc_html( __( 'Cashtomer Coins', 'cashtomer') );  } ?></p>
				<?php } ?>
				</a>
				</div>
				<?php } ?>
				</div>
				</div>				
		</div>
		</main>
		<div class="new-join join-now-box">
		<a href="<?php echo site_url(); ?>/my-account" class="button join-now">Join now</a>
		<p>Already have an account? <a href="<?php echo site_url(); ?>/my-account">Sign in</a></p>
		</div>	
	</section>
	<script>
	jQuery(document).ready(function(){
		
	jQuery(".new-join").hide();	
	jQuery("#prev").hide();
	
    jQuery(".divs .main-box").each(function(e) {
        if (e != 0)
            jQuery(this).hide();
    });    
    jQuery("#next1").click(function(){
		jQuery(".main-box2").hide();
		jQuery(".main-box1").show();
		jQuery(".new-join").show();		
		jQuery("#prev").show();
        if (jQuery(".divs .main-box:visible").next().length != 0)
            jQuery(".divs .main-box:visible").next().show().prev().hide();
        else {
            jQuery(".divs .main-box:visible").hide();
            jQuery(".divs .main-box:first").show();
        }
        return false;
    });
	jQuery("#next2").click(function(){
		jQuery(".main-box1").hide();
		jQuery(".main-box2").show();
		jQuery("#prev").show();
		jQuery(".new-join").show();
        if (jQuery(".divs .main-box:visible").next().length != 0)
            jQuery(".divs .main-box:visible").next().show().prev().hide();
        else {
            jQuery(".divs .main-box:visible").hide();
            jQuery(".divs .main-box:first").show();
        }
        return false;
    });
    jQuery("#prev").click(function(){
		jQuery("#prev").hide();
		jQuery(".new-join").hide();
        if (jQuery(".divs .main-box:visible").prev().length != 0)
            jQuery(".divs .main-box:visible").prev().show().next().hide();
        else {
            jQuery$(".divs .main-box:visible").hide();
            jQuery(".divs .main-box:last").show();
        }
        return false;
    });
	});
	jQuery(".my-rewards").click(function(){
	  jQuery(".my-rewards").hide();
	});
	jQuery(".chatbox-close").click(function(){
	  jQuery(".my-rewards").show();
	});
	</script>
	<?php			
	}
    return ob_get_clean();
}
function cashtomer_shortcode() { 
    echo do_shortcode('[cashtomer-points-details]');
} 
add_action( 'get_footer', 'cashtomer_shortcode' ); 