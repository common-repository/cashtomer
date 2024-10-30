<?php
global $wpdb;
$table = $wpdb->prefix.'social_reward_programs';

if( isset($_POST['social_submit']) ){
	$data = array('socialtype' => sanitize_text_field($_GET['id']), 'socialurl' => sanitize_text_field($_POST['socialurl']), 'points' => sanitize_text_field($_POST['points']), 'status' => sanitize_text_field($_POST['status']) );
	$format = array('%s','%s','%d');
	$wpdb->insert($table,$data,$format);
	$my_id = $wpdb->insert_id;
	
	$pointsurl = admin_url().'admin.php?page=points';
	header('Location: '.$pointsurl.'');
	exit;
}
if( isset($_POST['edit_social_submit']) && isset($_GET['editid']) ){
	$wpdb->update( 
		$table, 
		array( 
			'socialtype' => sanitize_text_field($_GET['id']),
			'socialurl' => sanitize_text_field($_POST['socialurl']),
			'points' => sanitize_text_field($_POST['points']), 
			'status' => sanitize_text_field($_POST['status'])
		), 
		array( 'id' => sanitize_text_field($_GET['editid']) )
	);
	$pointsurl = admin_url().'admin.php?page=points';
}
if( isset( $_GET['delid'] ) ){
	$wpdb->delete( $table, array( 'id' => sanitize_text_field($_GET['delid']) ) );
	
	$pointsurl = admin_url().'admin.php?page=points';
	header('Location: '.$pointsurl.'');
	exit;
}

$results = $wpdb->get_results("SELECT * FROM $table WHERE id = ".sanitize_text_field($_GET['editid'])."");
if($results){
	$points = array();
	$status = array();
	foreach($results as $result){
		$points[] = $result->points;
		$socialurl[] = $result->socialurl;
		$status[] = $result->status;
	}
}
?>

<main style="" id="ember92" class="Wlp-app-main bm-outlet ember-view">
   <div id="ember25-outlet-menu" class="bm-menu-container"></div>
   <form method = "post" action = "" name="add-points">
   <div class="bm-content">
      <div class="Wlp-Page">
         <div class="Wlp-Page-Header Wlp-Page-Header__Header--hasBreadcrumbs Wlp-Page-Header__Header--hasSecondaryActions Wlp-Page-Header__Header--hasRollup">
            <div class="Wlp-Page-Header__Navigation">
               <nav role="navigation">
				  <a href="<?php echo admin_url(); ?>admin.php?page=points" class="Wlp-Breadcrumbs__Breadcrumb">
                  <button class="Wlp-Breadcrumbs__Breadcrumb" type="button">
                     <span data-test-breadcrumb-icon="" class="Wlp-Breadcrumbs__Icon">
                        <span class="Wlp-Icon" data-test-icon="">
                           <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="Wlp-Icon__Svg" focusable="false" aria-hidden="true" id="ember2037-svg">
                              <path d="M12 16a.997.997 0 01-.707-.293l-5-5a.999.999 0 010-1.414l5-5a.999.999 0 111.414 1.414L8.414 10l4.293 4.293A.999.999 0 0112 16" fill="" fill-rule="evenodd"></path>
                           </svg>
                        </span>
                     </span>
                     <span class="Wlp-Breadcrumbs__Content">
                     Actions
                     </span>
                  </button>
				  </a>
               </nav>
               <div class="Wlp-Page-Header__Rollup">
                  <span></span>
                  <div aria-owns="ember-basic-dropdown-content-ember2040" tabindex="0" data-ebd-id="ember2040-trigger" style="
                     display: inline-block;
                     overflow: inherit;
                     border: none;
                     " role="button" id="ember2041" class="ember-basic-dropdown-trigger ember-view">
                     <button class="Wlp-Button Wlp-Button--plain Wlp-Button--iconOnly" type="button">
                        <span class="Wlp-Button__Content">
                           <span class="Wlp-Button__Icon">
                              <span class="Wlp-Icon" data-test-icon="">
                                 <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="Wlp-Icon__Svg" focusable="false" aria-hidden="true" id="ember2044-svg">
                                    <path d="M6 10a2 2 0 11-4.001-.001A2 2 0 016 10zm6 0a2 2 0 11-4.001-.001A2 2 0 0112 10zm6 0a2 2 0 11-4.001-.001A2 2 0 0118 10z" fill="" fill-rule="evenodd"></path>
                                 </svg>
                              </span>
                           </span>
                        </span>
                     </button>
                  </div>
                  <div id="ember-basic-dropdown-content-ember2040" class="ember-basic-dropdown-content-placeholder" style="display: none;"></div>
               </div>
            </div>
            <div id="ember2047" class="ember-view Wlp-Page-Header__MainContent">
               <div id="ember2048" class="ember-view Wlp-Page-Header__TitleAndActions">
                  <div class="Wlp-Page-Header__TitleAndRollup">
                     <div class="Wlp-Page-Header__Title ">
                        <div>
                           <div class="Wlp-Stack Wlp-Stack--spacingTight Wlp-Stack--alignmentBaseline">
                              <div class="Wlp-Stack__Item" >
                                 <h1 id="ember2051" class="ember-view Wlp-DisplayText Wlp-DisplayText--sizeLarge">
									<?php 
									if($_GET['id'] == 'facebooklike'){ echo esc_html( __( 'Facebook Like', 'cashtomer') ); }
									if($_GET['id'] == 'facebookshare'){ echo esc_html( __( 'Facebook Share', 'cashtomer') ); }
									if($_GET['id'] == 'instagramfollow'){ echo esc_html( __( 'Instagram Follow', 'cashtomer') ); }
									if($_GET['id'] == 'twittershare'){ echo esc_html( __( 'Twitter Share', 'cashtomer') ); }
									if($_GET['id'] == 'twitterfollow'){ echo esc_html( __( 'Twitter Follow', 'cashtomer') ); }
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
                  <button class="Wlp-Button Wlp-Button--primary" type="submit" name="edit_social_submit">
                     <span class="Wlp-Button__Content">
                        <span class="Wlp-Button__Text">
                        Update
                        </span>
                     </span>
                  </button>
				  <?php } else { ?>
				  <button class="Wlp-Button Wlp-Button--primary" type="submit" name="social_submit">
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
            <div class="Wlp-Layout">
               <div class="Wlp-Layout__Section">
				   <?php 
				   if($_GET['id'] == 'facebooklike' || $_GET['id'] == 'facebookshare' || $_GET['id'] == 'instagramfollow' || $_GET['id'] == 'twittershare' || $_GET['id'] == 'twitterfollow'){
				   ?>
					<div class="Wlp-Card">
					<div class="Wlp-Card__Header">
					<h2 class="ember-view Wlp-Heading">
					Social link
					</h2>
					</div>
					<div class="Wlp-Card__Section">
					<div class="Wlp-FormLayout" data-test-form-layout="">
					<div class="Wlp-FormLayout__Item" data-test-form-layout-item=""><div data-test-labelled="text-field">
					<div class="Wlp-Labelled__LabelWrapper">
					<div data-test-label="" class="Wlp-Label ">
					<label id="TextField-ember721Label" for="TextField-ember721" class="Wlp-Label__Text">
					<?php 
					if($_GET['id'] == 'facebooklike'){ echo esc_html( __( 'Facebook page URL', 'cashtomer') ); }
					if($_GET['id'] == 'facebookshare'){ echo esc_html( __( 'URL to share', 'cashtomer') ); }
					if($_GET['id'] == 'instagramfollow'){ echo esc_html( __( 'Instagram username', 'cashtomer') ); }
					if($_GET['id'] == 'twittershare'){ echo esc_html( __( 'URL to share', 'cashtomer') ); }
					if($_GET['id'] == 'twitterfollow'){ echo esc_html( __( 'Twitter username', 'cashtomer') ); }
					?>
					</label>
					</div>
					</div>
					<div class="Wlp-TextField">
					<input class="ember-view Wlp-TextField__Input" type="text" name="socialurl" value="<?php if($points){echo $socialurl[0]; } ?>" required>
					<div class="Wlp-TextField__Backdrop"></div>
					</div>
					<div>
					</div>
					</div>
					</div>
					</div>
					</div>
					</div>
                    <?php } ?>
				  <div class="Wlp-Card">
                     <div class="Wlp-Card__Header">
                        <h2 id="ember2078" class="ember-view Wlp-Heading" >
                           Earning value
                        </h2>
                     </div>
                     <div class="Wlp-Card__Section">
                        <div class="Wlp-FormLayout">
                           <div class="Wlp-FormLayout__Item" data-test-form-layout-item="">
                              <div data-test-labelled="text-field">
                                 <div class="Wlp-Labelled__LabelWrapper">
                                    <div data-test-label="" class="Wlp-Label ">
                                       <label id="TextField-ember2081Label" for="TextField-ember2081" class="Wlp-Label__Text">
                                       Points awarded
                                       </label>
                                    </div>                                        
                                 </div>
                                 <div class="Wlp-TextField Wlp-TextField--hasValue">
                                    <input class="ember-view Wlp-TextField__Input" type="number" name="points" value="<?php if($points){echo $points[0]; } ?>" required>
                                 </div>
                              </div>
                           </div>                               
                        </div>
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
                                    <h2 id="ember2108" class="ember-view Wlp-Heading">
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
							<?php 
							if($_GET['id'] == 'placeorder'){ 
							?>
							<ul id="ember2113" class="ember-view Wlp-List Wlp-List--typeBullet">
							<li class="Wlp-List__Item">
							<div class="ember-view">
							Customers earn <?php if($points){echo $points[0]; } ?> points for every $1 spent
							</div>
							</li>
							</ul>
							<?php
							}
							if($_GET['id'] == 'birthday'){ ?> 
							<ul class="ember-view Wlp-List Wlp-List--typeBullet">
							<li class="Wlp-List__Item ">
							<div id="ember1570" class="ember-view">
							<?php if($points){echo $points[0]; } ?> points for completing action
							</div>
							</li>
							<li class="Wlp-List__Item ">
							<div id="ember1572" class="ember-view">Limit of 1 per year</div>
							</li>
							<li class="Wlp-List__Item ">
							<div id="ember1574" class="ember-view">Customers must enter their birthday in Smile UI at least 30 days in advance to be rewarded</div>
							</li>
							</ul>
							<?php
							}
							if($_GET['id'] == 'signup'){ ?>
							<ul id="ember2113" class="ember-view Wlp-List Wlp-List--typeBullet">
							<li class="Wlp-List__Item">
							<div class="ember-view">
							<?php if($points){echo $points[0]; } ?> points for completing action 
							</div>
							</li>
							</ul>										
							<?php
							}
							?>							
                           </div>
                        </div>
                     </div>
                     <div class="Wlp-Card__Section Wlp-Card__Section--subdued">                        
                        <div class="Wlp-Card__SectionHeader ">                           
                           <h3 id="ember2119" class="ember-view Wlp-Subheading" aria-label="Status">
                              Status
                           </h3>
                        </div>
                        <div class="Wlp-FormLayout">                           
                           <div class="Wlp-FormLayout__Item">
                              <fieldset class="Wlp-ChoiceList">                                 
                                 <ul class="Wlp-ChoiceList__Choices">
                                    <li>
                                       <label for="Wlp-radio-button-ember2122" class="Wlp-Choice">
                                       <span class="Wlp-Choice__Control">
                                       <span class="Wlp-RadioButton">
                                       <input class="Wlp-RadioButton__Input" id="Wlp-radio-button-ember2122" name="status" type="radio" value="active"<?php if($status[0] == 'active'){echo 'checked'; } ?> required>
                                       <span class="Wlp-RadioButton__Backdrop"></span>
                                       <span class="Wlp-RadioButton__Icon"></span>
                                       </span>
                                       </span>
                                       <span class="Wlp-Choice__Label">
                                       Active
                                       </span>
                                       </label>                                               
                                    </li>
                                    <li>
                                       <label for="Wlp-radio-button-ember2126" class="Wlp-Choice" data-test-choice-label="">
                                       <span class="Wlp-Choice__Control">
                                       <span class="Wlp-RadioButton">
                                       <input class="Wlp-RadioButton__Input" id="Wlp-radio-button-ember2126" name="status" type="radio" value="disabled"<?php if($status[0] == 'disabled'){echo 'checked'; } ?> required>
                                       <span class="Wlp-RadioButton__Backdrop"></span>
                                       <span class="Wlp-RadioButton__Icon"></span>
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
                  <div class="Wlp-Card">
                     <div class="Wlp-Card__Header">
                        <h2 id="ember2133" class="ember-view Wlp-Heading">
                           Icon
                        </h2>
                     </div>
                     <div class="Wlp-Card__Section">                        
                        <fieldset class="Wlp-ChoiceList">                           
                           <ul class="Wlp-ChoiceList__Choices">
                              <li>
                                 <label for="Wlp-radio-button-ember2136" class="Wlp-Choice">
                                 <span class="Wlp-Choice__Control">
                                 <span class="Wlp-RadioButton">
                                 <input class="Wlp-RadioButton__Input" id="Wlp-radio-button-ember2136" name="ember2135" type="radio" value="default" checked>
                                 <span class="Wlp-RadioButton__Backdrop"></span>
                                 <span class="Wlp-RadioButton__Icon"></span>
                                 </span>
                                 </span>
                                 <span class="Wlp-Choice__Label">
                                 Default
                                 </span>
                                 </label>
                                 <div class="Wlp-ChoiceList__ChoiceChildren">
                                    <span class="Wlp-Thumbnail  Wlp-Thumbnail--sizeMedium">									
									<?php if($_GET['id'] == 'facebooklike'){ ?>
									<img class="Wlp-Thumbnail__Image" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/facebook-like.svg'; ?>">
									<?php } ?>
									
									<?php if($_GET['id'] == 'facebookshare'){ ?>
									<img class="Wlp-Thumbnail__Image" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/facebook-share.svg'; ?>">
									<?php } ?>
									
									<?php if($_GET['id'] == 'twittershare'){ ?>
									<img class="Wlp-Thumbnail__Image" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/twitter-share.svg'; ?>">
									<?php } ?>
									
									<?php if($_GET['id'] == 'twitterfollow'){ ?>
									<img class="Wlp-Thumbnail__Image" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/twitter-follow.svg'; ?>">
									<?php } ?>
									
									<?php if($_GET['id'] == 'instagramfollow'){ ?>
									<img class="Wlp-Thumbnail__Image" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/instagram-follow.svg'; ?>">
									<?php } ?>
                                    
                                    </span>
                                 </div>
                              </li>                              
                           </ul>                           
                        </fieldset>
                     </div>
                  </div>
               </div>
               <div class="Wlp-Layout__Section">
                  <div class="Wlp-PageActions ">
                     <div class="Wlp-Stack Wlp-Stack--spacingTight Wlp-Stack--distributionEqualSpacing">
                        <div class="Wlp-Stack__Item">
                           <div class="Wlp-ButtonGroup">
                              <div class="Wlp-ButtonGroup__Item">
							     <a href="?page=add-social-point&id=<?php echo sanitize_text_field($_GET['id']); ?>&delid=<?php echo sanitize_text_field($_GET['editid']); ?>">
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
                        <div class="Wlp-Stack__Item">
                          <?php if(isset($_GET['editid'])) { ?>
						  <button class="Wlp-Button Wlp-Button--primary" type="submit" name="edit_social_submit">
							 <span class="Wlp-Button__Content">
								<span class="Wlp-Button__Text">
								Update
								</span>
							 </span>
						  </button>
						  <?php } else { ?>
						  <button class="Wlp-Button Wlp-Button--primary" type="submit" name="social_submit">
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