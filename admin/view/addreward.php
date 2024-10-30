<?php
global $wpdb;
$table = $wpdb->prefix.'coupon_reward_programs';

if( isset($_POST['reward_submit']) ){
	
	$coupon_code = substr( "abcdefghijklmnopqrstuvwxyz123456789", mt_rand(0, 50) , 1) .substr( md5( time() ), 1);
	$coupon_code = substr( $coupon_code, 0,10);
	
	$data = array('rewardtype' => sanitize_text_field($_GET['id']), 'points_cost' => sanitize_text_field($_POST['points_cost']), 'discount_value' => sanitize_text_field($_POST['discount_value']), 'min_requirement' => sanitize_text_field($_POST['min_requirement']), 'coupon_code' => $coupon_code, 'status' => sanitize_text_field($_POST['status']) );
	$format = array('%s','%d');
	$wpdb->insert($table,$data,$format);
	$my_id = $wpdb->insert_id;
	
    $sql = $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type = 'shop_coupon' AND post_status = 'publish' ORDER BY post_date DESC LIMIT 1", $code );
    $coupon_id = $wpdb->get_var( $sql );	
	$discountvalue = sanitize_text_field($_POST['discount_value']);
	
    if ( empty( $coupon_id ) && $_GET['id'] == 'amountdiscount' ) {
        
		$minspend = sanitize_text_field($_POST['min_requirement']);
		if($minspend > 0){
			$minspend = sanitize_text_field($_POST['min_requirement']);
		}else{
			$minspend = '';
		}
        $data = array(
			'discount_type'  => 'fixed_cart',
			'coupon_amount'  => sanitize_text_field($_POST['discount_value']),
			'individual_use' => 'no',
			'usage_limit_per_user'=> '1',
			'free_shipping'  => 'no',
			'minimum_amount' => $minspend
		); 
        $coupon = array(
            'post_title' => $coupon_code,
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'shop_coupon'
        );
        $new_coupon_id = wp_insert_post( $coupon );
        foreach ($data as $key => $value) {
            update_post_meta( $new_coupon_id, $key, $value );
        }
    }
	if ( empty( $coupon_id ) && $_GET['id'] == 'percentageoff' ) {
        $minspend = sanitize_text_field($_POST['min_requirement']);
		if($minspend > 0){
			$minspend = sanitize_text_field($_POST['min_requirement']);
		}else{
			$minspend = '';
		}
        $data = array(
			'discount_type'  => 'percent',
			'coupon_amount'  => sanitize_text_field($_POST['discount_value']),
			'individual_use' => 'no',
			'usage_limit_per_user'=> '1',
			'free_shipping'  => 'no',
			'minimum_amount' => $minspend	
		); 
        $coupon = array(
            'post_title' => $coupon_code,
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'shop_coupon'
        );
        $new_coupon_id = wp_insert_post( $coupon );
        foreach ($data as $key => $value) {
            update_post_meta( $new_coupon_id, $key, $value );
        }
    }
	if ( empty( $coupon_id ) && $_GET['id'] == 'freeshipping' ) {
		$minspend = sanitize_text_field($_POST['min_requirement']);
		if($minspend > 0){
			$minspend = sanitize_text_field($_POST['min_requirement']);
		}else{
			$minspend = '';
		}
        $data = array(
			'discount_type'  => 'fixed_cart',
			'coupon_amount'  => sanitize_text_field($_POST['discount_value']),
			'individual_use' => 'no',
			'usage_limit_per_user'=> '1',
			'free_shipping'  => 'yes',
			'minimum_amount' => $minspend			
		); 
        $coupon = array(
            'post_title' => $coupon_code,
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'shop_coupon'
        );
        $new_coupon_id = wp_insert_post( $coupon );
        foreach ($data as $key => $value) {
            update_post_meta( $new_coupon_id, $key, $value );
        }
    }
	$pointsurl = admin_url().'admin.php?page=points';
	header('Location: '.$pointsurl.'');
	exit;
}

if( isset($_POST['edit_reward_submit']) && isset($_GET['editid']) ){
	$minspend = sanitize_text_field($_POST['min_requirement']);
	if($minspend > 0){
		$minspend = sanitize_text_field($_POST['min_requirement']);
	}else{
		$minspend = '';
	}
	$wpdb->update( 
		$table, 
		array( 
			'rewardtype' => sanitize_text_field($_GET['id']),
			'points_cost' => sanitize_text_field($_POST['points_cost']),
			'discount_value' => sanitize_text_field($_POST['discount_value']),
			'min_requirement' => $minspend,			
			'status' => sanitize_text_field($_POST['status'])
		), 
		array( 'id' => sanitize_text_field($_GET['editid']) )
	);
	
	$results = $wpdb->get_results("SELECT coupon_code FROM $table WHERE id = ".sanitize_text_field($_GET['editid'])."");
	$post = get_page_by_title( $results['0']->coupon_code, OBJECT, 'shop_coupon' );
	$couponid = $post->ID;
	
	if ( !empty( $couponid ) && $_GET['id'] == 'amountdiscount' ) {
		update_post_meta( $couponid, 'discount_type', 'fixed_cart' );
		update_post_meta( $couponid, 'coupon_amount', sanitize_text_field($_POST['discount_value']) );
		update_post_meta( $couponid, 'individual_use', 'no' );
		update_post_meta( $couponid, 'free_shipping', 'no' );
		update_post_meta( $couponid, 'minimum_amount', $minspend );
	}
	if ( !empty( $couponid ) && $_GET['id'] == 'percentageoff' ) {
		update_post_meta( $couponid, 'discount_type', 'percent' );
		update_post_meta( $couponid, 'coupon_amount', sanitize_text_field($_POST['discount_value']) );
		update_post_meta( $couponid, 'individual_use', 'no' );
		update_post_meta( $couponid, 'free_shipping', 'no' );
		update_post_meta( $couponid, 'minimum_amount', $minspend );		
	}
	if ( !empty( $couponid ) && $_GET['id'] == 'freeshipping' ) {
		update_post_meta( $couponid, 'discount_type', 'fixed_cart' );
		update_post_meta( $couponid, 'coupon_amount', sanitize_text_field($_POST['discount_value']) );
		update_post_meta( $couponid, 'individual_use', 'no' );
		update_post_meta( $couponid, 'free_shipping', 'yes' );
		update_post_meta( $couponid, 'minimum_amount', $minspend );
	}	
}
if( isset( $_GET['delid'] ) ){
	$wpdb->delete( $table, array( 'id' => sanitize_text_field($_GET['delid']) ) );
	
	$pointsurl = admin_url().'admin.php?page=points';
	header('Location: '.$pointsurl.'');
	exit;
}
$results = $wpdb->get_results("SELECT * FROM $table WHERE id = ".sanitize_text_field($_GET['editid'])."");
if($results){
	$discount_value = array();
	$status = array();
	foreach($results as $result){
		$points_cost[] = $result->points_cost;
		$discount_value[] = $result->discount_value;
		$coupon_code[] = $result->coupon_code;
		$status[] = $result->status;
		$min_requirement[] = $result->min_requirement;
	}
}
?>
<main style="" id="ember92" class="Wlp-app-main bm-outlet ember-view">
   <div id="ember25-outlet-menu" class="bm-menu-container"></div>
   <form method = "post" action = "" name="add-reward-points">
   <div class="bm-content">
      <div class="Wlp-Page">
         <div class="Wlp-Page-Header Wlp-Page-Header__Header--hasBreadcrumbs Wlp-Page-Header__Header--hasSecondaryActions Wlp-Page-Header__Header--hasRollup">
            <div class="Wlp-Page-Header__Navigation">
               <nav role="navigation">                  
				  <a href="<?php echo admin_url(); ?>admin.php?page=points" class="Wlp-Breadcrumbs__Breadcrumb">
                     <span class="Wlp-Breadcrumbs__Icon">
                        <span class="Wlp-Icon" data-test-icon="">
                           <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="Wlp-Icon__Svg" focusable="false" aria-hidden="true" id="ember2546-svg">
                              <path d="M12 16a.997.997 0 01-.707-.293l-5-5a.999.999 0 010-1.414l5-5a.999.999 0 111.414 1.414L8.414 10l4.293 4.293A.999.999 0 0112 16" fill="" fill-rule="evenodd"></path>
                           </svg>
                        </span>
                     </span>
                     <span class="Wlp-Breadcrumbs__Content">
                     Rewards
                     </span>
                  </a>
               </nav>
               <div class="Wlp-Page-Header__Rollup">
                  <span></span>
                  <div aria-owns="ember-basic-dropdown-content-ember2549" tabindex="0" data-ebd-id="ember2549-trigger" style="display: inline-block;overflow: inherit;
                     border: none;" role="button" id="ember2550" class="ember-basic-dropdown-trigger ember-view">
                     <button class="Wlp-Button Wlp-Button--plain Wlp-Button--iconOnly" type="button">
                        <span class="Wlp-Button__Content">
                           <span class="Wlp-Button__Icon">
                              <span class="Wlp-Icon">
                                 <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="Wlp-Icon__Svg" focusable="false" aria-hidden="true" id="ember2553-svg">
                                    <path d="M6 10a2 2 0 11-4.001-.001A2 2 0 016 10zm6 0a2 2 0 11-4.001-.001A2 2 0 0112 10zm6 0a2 2 0 11-4.001-.001A2 2 0 0118 10z" fill="" fill-rule="evenodd"></path>
                                 </svg>
                              </span>
                           </span>
                        </span>
                     </button>
                  </div>
                  <div id="ember-basic-dropdown-content-ember2549" class="ember-basic-dropdown-content-placeholder" style="display: none;"></div>
               </div>
            </div>
            <div id="ember2556" class="ember-view Wlp-Page-Header__MainContent">
               <div id="ember2557" class="ember-view Wlp-Page-Header__TitleAndActions">
                  <div class="Wlp-Page-Header__TitleAndRollup">
                     <div class="Wlp-Page-Header__Title ">
                        <div>
                           <div class="Wlp-Stack Wlp-Stack--spacingTight Wlp-Stack--alignmentBaseline">
                              <div class="Wlp-Stack__Item" data-test-stack-item="true">
                                 <h1 id="ember2560" class="ember-view Wlp-DisplayText Wlp-DisplayText--sizeLarge " data-test-display-text="">
                                    <?php 
									if( $_GET['id'] == 'amountdiscount' && isset($_GET['editid']) ){
										echo get_woocommerce_currency_symbol().$discount_value[0].' off coupon';
									}else if($_GET['id'] == 'amountdiscount'){
										echo esc_html( __( 'Amount discount', 'cashtomer') );
									}
									
									if( $_GET['id'] == 'percentageoff' && isset($_GET['editid']) ){
										echo ''.$discount_value[0].' % Off coupon';
									}else if($_GET['id'] == 'percentageoff'){
										echo esc_html( __( 'Percentage off', 'cashtomer') );
									}
									
									if( $_GET['id'] == 'freeshipping' && isset($_GET['editid']) ){
										echo get_woocommerce_currency_symbol().$discount_value[0].' off coupon';
									}else if($_GET['id'] == 'freeshipping'){
										echo esc_html( __( 'Free shipping', 'cashtomer') );
									}									
									?>
                                 </h1>
                              </div>
                           </div>
                        </div>
                        <div>         
                        </div>
                     </div>      
                  </div>                  
               </div>
               <div class="Wlp-Page-Header__PrimaryAction">
				  <?php if(isset($_GET['editid'])) { ?>
				  <button class="Wlp-Button Wlp-Button--primary" type="submit" name="edit_reward_submit">
					<span class="Wlp-Button__Content">
					   <span class="Wlp-Button__Text">
						Update
					   </span>
					 </span>
					</button>
				  <?php } else { ?>
                  <button class="Wlp-Button Wlp-Button--primary" type="submit" name="reward_submit">
                     <span class="Wlp-Button__Content">
                        <span class="Wlp-Button__Text">
                        Save
                        </span>
                     </span>
                  </button>
				  <?php } ?>
               </div>
            </div>
         </div>
         <div class="Wlp-Page__Content">
            <div class="Wlp-Layout ">
               <div class="Wlp-Layout__Section">
                  <div class="Wlp-Card  ">
                     <div class="Wlp-Card__Header">
                        <h2 id="ember2590" class="ember-view Wlp-Heading">
                           Reward value
                        </h2>
                     </div>
                     <div class="Wlp-Card__Section">
                        <div class="Wlp-Stack Wlp-Stack--vertical">
                           <div class="Wlp-Stack__Item">
                                 <div class="Wlp-FormLayout">
                                    <div class=" Wlp-FormLayout--grouped" role="group">
                                       <div class="Wlp-FormLayout__Items">
                                          <div class="Wlp-FormLayout__Item">
                                             <div data-test-labelled="points-price">
                                                <div class="Wlp-Labelled__LabelWrapper">
                                                   <div data-test-label="" class="Wlp-Label ">
                                                      <label id="TextField-ember2596Label" for="TextField-ember2596" class="Wlp-Label__Text">
                                                      Points cost
                                                      </label>
                                                   </div> 
                                                </div>
                                                <div class="Wlp-TextField Wlp-TextField--hasValue">
                                                   <input id="TextField-ember2596" class="ember-view Wlp-TextField__Input Wlp-TextField__Input--suffixed" type="number" name="points_cost" value="<?php if($points_cost){echo $points_cost[0]; } ?>" required>
                                                   <div class="Wlp-TextField__Backdrop"></div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="Wlp-FormLayout__Item">
                                             <div data-test-labelled="reward-value">
                                                <div class="Wlp-Labelled__LabelWrapper">
                                                   <div class="Wlp-Label ">
                                                      <label id="TextField-ember2606Label" for="TextField-ember2606" class="Wlp-Label__Text">
                                                      Discount value
                                                      </label>
                                                   </div>    
                                                </div>
                                                <div class="Wlp-TextField Wlp-TextField--hasValue">
                                                   <div class="Wlp-TextField__Prefix" id="TextField-ember2606Prefix">
												   <?php
													if( $_GET['id'] == 'amountdiscount'){ echo get_woocommerce_currency_symbol(); }
													if( $_GET['id'] == 'percentageoff'){ echo '%'; }
													?>
													</div>
                                                   <input id="TextField-ember2606" class="ember-view Wlp-TextField__Input" type="number" name="discount_value" value="<?php if($discount_value){echo $discount_value[0]; } ?>" required>
                                                   <div class="Wlp-TextField__Backdrop"></div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="Wlp-Card">
                     <div class="Wlp-Card__Header">
                        <h2 id="ember2633" class="ember-view Wlp-Heading">
                           Minimum requirement
                        </h2>
                     </div>
                     <div class="Wlp-Card__Section">
                           <fieldset id="ember2636" class="Wlp-ChoiceList">
                              <ul class="Wlp-ChoiceList__Choices">
                                 <li>
                                    <label for="Wlp-radio-button-ember2637" class="Wlp-Choice">
                                    <span class="Wlp-Choice__Control">
                                    <span class="Wlp-RadioButton">
                                    <input class="Wlp-RadioButton__Input" id="Wlp-radio-button-ember2637" name="min_requirement" type="radio" value="0" <?php if($min_requirement[0] == 0){echo 'checked'; } ?>>
                                    <span class="Wlp-RadioButton__Backdrop"></span>
                                    <span class="Wlp-RadioButton__Icon"></span>
                                    </span>
                                    </span>
                                    <span class="Wlp-Choice__Label">None</span>									
                                    </label>
                                 </li>
                                 <li>
                                    <label for="Wlp-radio-button-ember2641" class="Wlp-Choice">
                                    <span class="Wlp-Choice__Control">
                                    <span class="Wlp-RadioButton">
                                    <input class="Wlp-RadioButton__Input" id="Wlp-radio-button-ember2641" name="min_requirement" type="radio" value="amount" <?php if($min_requirement[0] > 0){echo 'checked'; } ?>>
									<span class="Wlp-RadioButton__Backdrop"></span>
                                    <span class="Wlp-RadioButton__Icon"></span>
                                    </span>
                                    </span>
                                    <span class="Wlp-Choice__Label">
                                    Minimum purchase amount
									</span>
                                    </label>
									<div id="amount">Minimum spend : <input type="text" name="min_requirement" id="min_requirement" value="<?php echo $min_requirement[0]; ?>"></div>
                                 </li>
                              </ul>
                           </fieldset>                        
                     </div>
                  </div>
               </div>
               <div class="Wlp-Layout__Section Wlp-Layout__Section--secondary">
                  <div class="Wlp-Card  ">
                     <div class="Wlp-Card__Section">
                        <div data-test-stack="" class="Wlp-Stack Wlp-Stack--spacingLoose Wlp-Stack--vertical">
                           <div class="Wlp-Stack__Item" data-test-stack-item="true">
                              <div data-test-stack="" class="Wlp-Stack Wlp-Stack--alignmentCenter Wlp-Stack--distributionEqualSpacing">
                                 <div class="Wlp-Stack__Item" data-test-stack-item="true">
                                    <h2 id="ember2683" class="ember-view Wlp-Heading " data-test-Wlp-heading="">
                                       Summary
                                    </h2>
                                 </div>
                                 <div data-test-stack-item="" class="Wlp-Stack__Item">
                                    <span class="Wlp-Badge Wlp-Badge--statusSuccess   ">
                                       <span class="Wlp-VisuallyHidden ">
                                       Success
                                       </span>
                                       <?php echo $status[0]; ?>
                                    </span>
                                 </div>
                              </div>
                           </div>
                           <div class="Wlp-Stack__Item" data-test-stack-item="true">
                              <ul id="ember2688" class="ember-view Wlp-List Wlp-List--typeBullet">
                                 <li class="Wlp-List__Item ">
                                    <div id="ember2690" class="ember-view">
									<?php if( $_GET['id'] == 'amountdiscount' && isset($_GET['editid']) ){ ?>
                                       <?php echo get_woocommerce_currency_symbol(); ?><?php if($discount_value){echo $discount_value[0]; } ?> off entire order
									<?php } ?>  
									<?php if( $_GET['id'] == 'percentageoff' && isset($_GET['editid']) ){ ?>
                                       <?php if($discount_value){echo $discount_value[0]; } ?> % off entire order
									<?php } ?>
                                    </div>
                                 </li>
                                 <li class="Wlp-List__Item ">
                                    <div id="ember2692" class="ember-view">
                                       Applies to all orders
                                    </div>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                     <div class="Wlp-Card__Section Wlp-Card__Section--subdued">
                        <div class="Wlp-Card__SectionHeader ">
                           <h3 id="ember2696" class="ember-view Wlp-Subheading" aria-label="Status">
                              Status
                           </h3>
                        </div>
                        <div class="Wlp-FormLayout">
                           <div class="Wlp-FormLayout__Item" data-test-form-layout-item="">
                              <fieldset id="ember2698" aria-describedby="ember2698Error" class="Wlp-ChoiceList">
                                 <ul data-test-choice-list-choices="" class="Wlp-ChoiceList__Choices">
                                    <li>
                                       <label for="Wlp-radio-button-ember2699" class="Wlp-Choice">
                                       <span class="Wlp-Choice__Control">
                                       <span class="Wlp-RadioButton">
                                       <input class="Wlp-RadioButton__Input" id="Wlp-radio-button-ember2699" name="status" type="radio" value="active" <?php if($status[0] == 'active'){echo 'checked'; } ?>>
                                       <span data-test-radio-button-backdrop="true" class="Wlp-RadioButton__Backdrop"></span>
                                       <span data-test-radio-button-icon="true" class="Wlp-RadioButton__Icon"></span>
                                       </span>
                                       </span>
                                       <span class="Wlp-Choice__Label">
                                       Active
                                       </span>
                                       </label>
                                    </li>
                                    <li>
                                       <label for="Wlp-radio-button-ember2703" class="Wlp-Choice">
                                       <span class="Wlp-Choice__Control">
                                       <span class="Wlp-RadioButton">
                                       <input class="Wlp-RadioButton__Input" id="Wlp-radio-button-ember2703" name="status" type="radio" value="disabled" <?php if($status[0] == 'disabled'){echo 'checked'; } ?>>
                                       <span data-test-radio-button-backdrop="true" class="Wlp-RadioButton__Backdrop"></span>
                                       <span data-test-radio-button-icon="true" class="Wlp-RadioButton__Icon"></span>
                                       </span>
                                       </span>
                                       <span class="Wlp-Choice__Label">
                                       Disabled
                                       </span>
                                       </label>
                                    </li>
                                 </ul>
                              </fieldset>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="Wlp-Layout__Section">
                  <div class="Wlp-PageActions ">
                     <div class="Wlp-Stack Wlp-Stack--spacingTight Wlp-Stack--distributionEqualSpacing">
                        <div class="Wlp-Stack__Item" data-test-stack-item="true">
                           <div class="Wlp-ButtonGroup">
                              <div class="Wlp-ButtonGroup__Item" data-test-button-group-item="true">
							     <a href="?page=add-reward-point&id=<?php echo sanitize_text_field($_GET['id']); ?>&delid=<?php echo sanitize_text_field($_GET['editid']); ?>">
                                 <button class="Wlp-Button Wlp-Button--destructive" type="button">
                                    <span class="Wlp-Button__Content">
                                       <span class="Wlp-Button__Text">
                                       Delete
                                       </span>
                                    </span>
                                 </button>
								 </a>
                              </div>
                           </div>
                        </div>
                        <div class="Wlp-Stack__Item" data-test-stack-item="true">
						  <?php if(isset($_GET['editid'])) { ?>
						  <button class="Wlp-Button Wlp-Button--primary" type="submit" name="edit_reward_submit">
							 <span class="Wlp-Button__Content">
								<span class="Wlp-Button__Text">
								Update
								</span>
							 </span>
						  </button>
						  <?php } else { ?>
                           <button class="Wlp-Button Wlp-Button--primary" type="submit" name="reward_submit">
                              <span class="Wlp-Button__Content">
                                 <span class="Wlp-Button__Text">
                                 Save
                                 </span>
                              </span>
                           </button>
						  <?php } ?>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>      
   </div>
   </form>
</main>
<script>
jQuery(document).ready(function() {	
	var amountval = '<?php echo $min_requirement[0]; ?>';	
	if(amountval > 0){
		jQuery("#amount").show();
		jQuery("#min_requirement").val(amountval);
	}else{		
		jQuery("#amount").hide();
	}	
    jQuery("input[name='min_requirement']").click(function() {
        var minval = jQuery(this).val();
		if(minval == 'amount'){			
			jQuery("#amount").show();
			jQuery("#min_requirement").val(amountval);
		}
		if(minval == 0){
			jQuery("#min_requirement").val(0);
        }
    });
});
</script>