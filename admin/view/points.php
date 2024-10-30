<main id="ember4" class="Wlp-app-main bm-outlet ember-view">
<div id="ember3-outlet-menu" class="bm-menu-container"></div>
<div class="bm-content">
<div class="Wlp-Page">
<div class="Wlp-Page-Header">
	<div class="Wlp-Page-Header__TitleAndRollup">
		<div class="Wlp-Page-Header__Title Wlp-Page-Header__Title--alignmentCenter">
			<div>
				<div data-test-stack="" class="Wlp-Stack Wlp-Stack--spacingTight Wlp-Stack--alignmentBaseline">
					<div class="Wlp-Stack__Item" data-test-stack-item="true">
						<h1 id="ember1737" class="ember-view Wlp-DisplayText Wlp-DisplayText--sizeLarge " data-test-display-text="">
							Points
						</h1>
					</div>
				</div>
			</div>			
		</div>
		<div class="save-changes-button">
			<?php submit_button(); ?>
		</div>
	</div>
</div>
<div class="Wlp-Page__Content">
	<div class="Wlp-Layout ">
		<div class="Wlp-Layout__Section Wlp-liquid-if-empty">
			<div id="ember1746" class="Wlp-liquid-if-overflow-visible liquid-container ember-view">
			</div>
		</div>
		
		<div class="Wlp-Layout__AnnotatedSection ">
			<div class="Wlp-Layout__AnnotationWrapper">
				<div class="Wlp-Layout__Annotation ">
					<div class="Wlp-TextContainer  ">
						<h2 id="ember1794" class="ember-view Wlp-Heading">
							Points branding
						</h2>
						<div data-test-annotation-description="" class="Wlp-Layout__AnnotationDescription">
							Give a good name to your points currency matching your brand. Also, name your loyalty program							
						</div>
					</div>
				</div>
				<div class="Wlp-Layout__AnnotationContent">
					<div class="Wlp-Card  ">
						<div class="Wlp-Card__Header">
							<div data-test-stack="" class="Wlp-Stack Wlp-Stack--alignmentBaseline">
								<div data-test-stack-item="" class="Wlp-Stack__Item Wlp-Stack__Item--fill">
									<h2 id="ember1804" class="ember-view Wlp-Heading">
										Points currency
									</h2>
								</div>								
							</div>
						</div>
						<div class="Wlp-Card__Section">
							<div data-test-stack="" class="Wlp-Stack Wlp-Stack--vertical">
								<div class="Wlp-Stack__Item" data-test-stack-item="true">
										<div>
											<div class="Wlp-TextField">
												<input class="ember-view Wlp-TextField__Input" placeholder="e.g. Shekels" type="text" value="<?php echo esc_attr( get_option('boxcoins') ); ?>" name="boxcoins">
												<div class="Wlp-TextField__Backdrop"></div>
											</div>
											<div class="Wlp-Labelled__HelpText" id="TextField-ember1812HelpText">
												An example message: You've won 10 shekels
											</div>
										</div>
								</div>
								<div class="Wlp-Stack__Item Wlp-liquid-if-empty">
									<div id="ember1820" class="Wlp-liquid-if-overflow-visible liquid-container ember-view">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<br>
			<div class="Wlp-Layout__AnnotationWrapper">
				<div class="Wlp-Layout__Annotation ">
					<div class="Wlp-TextContainer  ">
						<div class="Wlp-Layout__AnnotationDescription">							
						</div>
					</div>
				</div>
				<div class="Wlp-Layout__AnnotationContent">
					<div class="Wlp-Card  ">
						<div class="Wlp-Card__Header">
							<div class="Wlp-Stack Wlp-Stack--alignmentBaseline">
								<div class="Wlp-Stack__Item Wlp-Stack__Item--fill">
									<h2 id="ember1804" class="ember-view Wlp-Heading">
										Name of your loyalty program
									</h2>
								</div>								
							</div>
						</div>
						<div class="Wlp-Card__Section">
							<div class="Wlp-Stack Wlp-Stack--vertical">
								<div class="Wlp-Stack__Item" data-test-stack-item="true">
										<div>
											<div class="Wlp-TextField">
												<input class="ember-view Wlp-TextField__Input" placeholder="e.g. Acme Rewards" type="text" value="<?php echo esc_attr( get_option('nameofprogram') ); ?>" name="nameofprogram">
												<div class="Wlp-TextField__Backdrop"></div>
											</div>
											<div class="Wlp-Labelled__HelpText" id="TextField-ember1812HelpText">												
											</div>
										</div>
								</div>
								<div class="Wlp-Stack__Item Wlp-liquid-if-empty">
									<div id="ember1820" class="Wlp-liquid-if-overflow-visible liquid-container ember-view">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>			
		</div>
		<div class="Wlp-Layout__AnnotatedSection ">
			<div class="Wlp-Layout__AnnotationWrapper">
				<div class="Wlp-Layout__Annotation ">
					<div class="Wlp-TextContainer  ">
						<h2 id="ember1752" class="ember-view Wlp-Heading " data-test-Wlp-heading="">
							Earn points
						</h2>
						<div data-test-annotation-description="" class="Wlp-Layout__AnnotationDescription">
							<div data-test-stack="" class="Wlp-Stack Wlp-Stack--vertical">
								<div data-test-stack-item="" class="Wlp-Stack__Item">
									Create various ways your customers can earn points.
								</div>
								<div class="Wlp-Stack__Item" data-test-stack-item="true">
									<button id="myBtn" class="Wlp-Button" type="button">
										<span class="Wlp-Button__Content">
											<span class="Wlp-Button__Text">
											Add ways to earn
											</span>
										</span>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="Wlp-Layout__AnnotationContent ">
					<div class="Wlp-Card __a8e31 ">
						<div class="Wlp-Card__Section">							
							<h3 id="ember1897" class="ember-view Wlp-Subheading " aria-label="Ways to earn">
								Ways to earn
							</h3>
						</div>
						<?php 
						global $wpdb;
						$table = $wpdb->prefix.'reward_programs';
						$result = $wpdb->get_results("SELECT * FROM $table");
						foreach($result as $row){
							if($row->earntype == 'placeorder'){
								$label_name = 'Place an order';	
								$icon = plugin_dir_url( __FILE__ ) . 'images/order-online.svg';	
							} 
							if($row->earntype == 'signup'){
								$label_name = 'Signup';
								$icon = plugin_dir_url( __FILE__ ) . 'images/signup.svg';								
							}
						?>
						<div class="Wlp-Card__Section">							
							<div class="__447dd ember-view">
								<div class="reward-details">
									<div style="height: 50px;min-width: 50px;width: 50px;background-size: 50%;background-position: center;background-repeat: no-repeat;
										background-image: url(<?php echo $icon; ?>); background-color: #EDF1F9;" class="reward-image-container __ee0e1 ember-view">
									</div>
									<div class="reward-name">
										<?php echo $label_name; ?>
										<div>
											<span id="ember1909" class="ember-view Wlp-TextStyle--variationSubdued">
											<?php echo $row->points; ?> Points <?php if($row->earntype == 'placeorder'){ ?>for every <?php echo get_woocommerce_currency_symbol(); ?>1 spent <?php } ?>
											</span>
										</div>
									</div>
								</div>
								<div class="reward-cta">
									<a href="?page=add-earn-point&id=<?php echo $row->earntype; ?>&editid=<?php echo $row->id; ?>">
									<button class="Wlp-Button Wlp-Button--plain" type="button">
										<span class="Wlp-Button__Content">
											<span class="Wlp-Button__Text">
											Edit
											</span>
										</span>
									</button>
									</a>
								</div>
							</div>
						</div>
						<?php } ?>
						<?php 
						global $wpdb;
						$table1 = $wpdb->prefix.'social_reward_programs';
						$result = $wpdb->get_results("SELECT * FROM $table1");
						foreach($result as $row){
							if($row->socialtype == 'facebookshare'){
								$label_name = 'Facebook Share';
								$icon = plugin_dir_url( __FILE__ ) . 'images/facebook-share.svg';
							}
							if($row->socialtype == 'instagramfollow'){
								$label_name = 'Instagram Follow';
								$icon = plugin_dir_url( __FILE__ ) . 'images/instagram-follow.svg';								
							}
							if($row->socialtype == 'twittershare'){
								$label_name = 'Twitter Share';
								$icon = plugin_dir_url( __FILE__ ) . 'images/twitter-share.svg';								
							}
							if($row->socialtype == 'twitterfollow'){
								$label_name = 'Twitter  Follow';
								$icon = plugin_dir_url( __FILE__ ) . 'images/twitter-follow.svg';								
							}
						?>
						<div class="Wlp-Card__Section">							
							<div class="__447dd ember-view">
								<div class="reward-details">
									<div style="height: 50px;min-width: 50px;width: 50px;background-size: 50%;background-position: center;background-repeat: no-repeat;
										background-image: url(<?php echo $icon; ?>); background-color: #EDF1F9;" class="reward-image-container __ee0e1 ember-view">
									</div>
									<div class="reward-name">
										<?php echo $label_name; ?>
										<div>
											<span id="ember1909" class="ember-view Wlp-TextStyle--variationSubdued">
											<?php echo $row->points; ?> Points
											</span>
										</div>
									</div>
								</div>
								<div class="reward-cta">
									<a href="?page=add-social-point&id=<?php echo $row->socialtype; ?>&editid=<?php echo $row->id; ?>">
									<button class="Wlp-Button Wlp-Button--plain" type="button">
										<span class="Wlp-Button__Content">
											<span class="Wlp-Button__Text">
											Edit
											</span>
										</span>
									</button>
									</a>
								</div>
							</div>
						</div>
						<?php } ?>						
					</div>
				</div>
			</div>
		</div>
		<div class="Wlp-Layout__AnnotatedSection ">
			<div class="Wlp-Layout__AnnotationWrapper">
				<div class="Wlp-Layout__Annotation ">
					<div class="Wlp-TextContainer  ">
						<h2 id="ember1773" class="ember-view Wlp-Heading" data-test-Wlp-heading="">
							Unlock coupons
						</h2>
						<div data-test-annotation-description="" class="Wlp-Layout__AnnotationDescription">
							<div data-test-stack="" class="Wlp-Stack Wlp-Stack--vertical">
								<div data-test-stack-item="" class="Wlp-Stack__Item">
									Create coupons your customers can unlock with the points they’ve earned.
								</div>
								<div class="Wlp-Stack__Item" data-test-stack-item="true">
									<button id="myBtn2" class="Wlp-Button" type="button">
										<span class="Wlp-Button__Content">
											<span class="Wlp-Button__Text">
											Add ways to redeem
											</span>
										</span>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="Wlp-Layout__AnnotationContent ">
					<div class="Wlp-Card __a8e31">
						<div class="Wlp-Card__Section">							
							<h3 id="ember1863" class="ember-view Wlp-Subheading" aria-label="Ways to redeem">
								Ways to redeem
							</h3>
						</div>
						<?php
						$table2 = $wpdb->prefix.'coupon_reward_programs';
						$result2 = $wpdb->get_results("SELECT * FROM $table2");
						foreach($result2 as $row){
						?>
						<div class="Wlp-Card__Section">							
							<div id="ember1865" class="__447dd ember-view">
								<div class="reward-details">
									<div style="height: 50px;min-width: 50px;width: 50px;background-size: 50%;background-position: center;background-repeat: no-repeat;background-image: url(<?php echo plugin_dir_url( __FILE__ ) . 'images/fixed-amount.svg'; ?>);
;background-color: #EDF1F9;" id="ember1866" class="reward-image-container __ee0e1 ember-view">										
									</div>
									<?php if($row->rewardtype == 'amountdiscount'){ ?>
									<div class="reward-name">
										<?php echo get_woocommerce_currency_symbol(); ?><?php echo $row->discount_value; ?> off coupon
										<div>
											<span class="ember-view Wlp-TextStyle--variationSubdued">
											<?php echo $row->points_cost; ?> Points
											</span>
										</div>
									</div>
									<?php } ?>
									
									<?php if($row->rewardtype == 'percentageoff'){ ?>
									<div class="reward-name">
										<?php echo $row->discount_value; ?> % off coupon
										<div>
											<span class="ember-view Wlp-TextStyle--variationSubdued">
											<?php echo $row->points_cost; ?> Points
											</span>
										</div>
									</div>
									<?php } ?>
								</div>
								<div class="reward-cta">
									<a href="?page=add-reward-point&id=<?php echo $row->rewardtype; ?>&editid=<?php echo $row->id; ?>">
									<button class="Wlp-Button Wlp-Button--plain" type="button">
										<span class="Wlp-Button__Content">										
											<span class="Wlp-Button__Text">
											Edit
											</span>										
										</span>
									</button>
									</a>
								</div>
							</div>
						</div>
						<?php } ?>						
					</div>
				</div>
			</div>
		</div>
		
	</div>
</main>

<div id="myModal" tabindex="-1" role="dialog" aria-hidden="true" class="Wlp-modal-liquid-container liquid-container ember-view">
<div class="liquid-child ember-view" style="top: 0px; left: 0px;">
<div class="Wlp-modal-container">
 <div class="Wlp-modal-overlay" role="button"></div>
 <div class="Wlp-modal-dialog ">
	<div id="ember3255" class="Wlp-modal-content-container __6b4d8 with-centered-content ember-view">
	   <div class="Wlp-Card   __6b4d8">		  
		  <div class="Wlp-Card__Section">			 
			 <div class="Wlp-Stack Wlp-Stack--alignmentCenter">
				<div class="Wlp-Stack__Item Wlp-Stack__Item--fill">
				   <p id="ember3261" class="ember-view Wlp-DisplayText Wlp-DisplayText--sizeSmall">
					  Ways to earn
				   </p>
				</div>
				<div class="Wlp-Stack__Item">
				   <button class="Wlp-Link close" type="button">
					  <span class="Wlp-Icon" data-test-icon="">
						 <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="Wlp-Icon__Svg" focusable="false" aria-hidden="true" id="ember3264-svg">
							<path d="M11.414 10l6.293-6.293a.999.999 0 10-1.414-1.414L10 8.586 3.707 2.293a.999.999 0 10-1.414 1.414L8.586 10l-6.293 6.293a.999.999 0 101.414 1.414L10 11.414l6.293 6.293a.997.997 0 001.414 0 .999.999 0 000-1.414L11.414 10z" fill="" fill-rule="evenodd"></path>
						 </svg>
					  </span>
				   </button>
				</div>
			 </div>
		  </div>
		  <div class="Wlp-Card__Section card-section-title">
			 <div class="Wlp-Card__SectionHeader ">
				<h3 id="ember3277" class="ember-view Wlp-Subheading " aria-label="Social">
				   Online Store
				</h3>
			 </div>
		  </div>
		  <?php
		  $table2 = $wpdb->prefix.'reward_programs';
		  $result2 = $wpdb->get_results("SELECT earntype,status FROM $table2");
		  $type = array();
		  $status = array();
		  foreach($result2 as $row){
			  $type[] = $row->earntype;
			  $status[] = $row->status;
		  }
		  
		  $socialtable = $wpdb->prefix.'social_reward_programs';
		  $socialresult = $wpdb->get_results("SELECT socialtype,status FROM $socialtable");
		  $socialtype = array();
		  $socialstatus = array();
		  foreach($socialresult as $row){
			  $socialtype[] = $row->socialtype;
			  $socialstatus[] = $row->status;
		  }
		  
		  ?>
		  <div class="Wlp-ResourceList__ResourceListWrapper">
			 <ul class="Wlp-ResourceList" aria-live="polite">
			 <?php if( !in_array('placeorder', $type)){ ?>
			 <li class="Wlp-ResourceList__ItemWrapper" data-test-item-id="0">
				   <div id="place-an-order" class="__1094d ember-view">
					  <div data-test-id="item-wrapper" class="Wlp-ResourceList-Item Wlp-ResourceList-Item--focusedInner __1094d ">
						 <button class="Wlp-ResourceList-Item__Button" tab-index="0" type="button"></button>
						 <div data-test-id="item-content" class="Wlp-ResourceList-Item__Container">
							<div class="Wlp-ResourceList-Item__Owned">							   
							   <div class="Wlp-ResourceList-Item__Media" data-test-id="media">
								<span class="Wlp-Thumbnail  Wlp-Thumbnail--sizeSmall">
								<img class="Wlp-Thumbnail__Image" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/order-online.svg'; ?>">
								</span>
								</div>
							</div>
							<div class="Wlp-ResourceList-Item__Content">
							   <a href="?page=add-earn-point&id=placeorder">	
							   <div id="place-an-order" class="Wlp-ResourceList-Row Wlp-ResourceList-Row--alignmentCenter ember-view">
								  <div style="flex-basis: 100%;text-align: inherit;" id="ember3286" class="Wlp-ResourceList-Cell ember-view">
									 <div data-test-stack="" class="Wlp-Stack Wlp-Stack--spacingNone Wlp-Stack--vertical">
										<div data-test-stack-item="" class="Wlp-Stack__Item">
										   Place an order
										</div>										        
									 </div>
								  </div>
							   </div>
							   </a>
							</div>							  
						 </div>
					  </div>
				   </div>
				</li>
			 <?php } ?>
				<?php if( !in_array('signup', $type)){ ?>
				<li class="Wlp-ResourceList__ItemWrapper" data-test-item-id="0">
				   <div id="signup" class="__1094d ember-view">
					  <div data-test-id="item-wrapper" class="Wlp-ResourceList-Item Wlp-ResourceList-Item--focusedInner __1094d ">
						 <button class="Wlp-ResourceList-Item__Button" tab-index="0" type="button"></button>
						 <div data-test-id="item-content" class="Wlp-ResourceList-Item__Container">
							<div class="Wlp-ResourceList-Item__Owned">
							   
							   <div class="Wlp-ResourceList-Item__Media" data-test-id="media">
								<span class="Wlp-Thumbnail  Wlp-Thumbnail--sizeSmall">
								<img class="Wlp-Thumbnail__Image" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/signup.svg'; ?>">
								</span>
								</div>
							</div>
							<div class="Wlp-ResourceList-Item__Content">
							   <a href="?page=add-earn-point&id=signup">
							   <div id="signup" class="Wlp-ResourceList-Row Wlp-ResourceList-Row--alignmentCenter ember-view">
								  <div style="flex-basis: 100%;text-align: inherit;" id="ember3286" class="Wlp-ResourceList-Cell ember-view">
									 <div data-test-stack="" class="Wlp-Stack Wlp-Stack--spacingNone Wlp-Stack--vertical">
										<div data-test-stack-item="" class="Wlp-Stack__Item">
										   Signup
										</div>      
									 </div>
								  </div>
							   </div>
							   </a>
							</div>
						 </div>
					  </div>
				   </div>
				</li>
				<?php } ?>	
			 <ul>
		  </div>	

		  <div class="Wlp-Card__Section card-section-title">
			 <div class="Wlp-Card__SectionHeader ">
				<h3 id="ember3277" class="ember-view Wlp-Subheading">
				   Social
				</h3>
			 </div>
		  </div>
		  <div class="Wlp-ResourceList__ResourceListWrapper">		 
			 <ul class="Wlp-ResourceList " aria-live="polite">
				<?php if( !in_array('facebookshare', $socialtype)){ ?>
				<li class="Wlp-ResourceList__ItemWrapper">
				   <div id="ember3289" class="__1094d ember-view">
					  <div data-test-id="item-wrapper" class="Wlp-ResourceList-Item __1094d ">
						 <button class="Wlp-ResourceList-Item__Button" tab-index="0" type="button"></button>
						 <div data-test-id="item-content" class="Wlp-ResourceList-Item__Container">
							<div class="Wlp-ResourceList-Item__Owned">							   
							   <div class="Wlp-ResourceList-Item__Media" data-test-id="media">
								  <span class="Wlp-Thumbnail  Wlp-Thumbnail--sizeSmall">
								  <img class="Wlp-Thumbnail__Image" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/facebook-share.svg'; ?>">
								  </span>
							   </div>
							</div>
							<div class="Wlp-ResourceList-Item__Content">
							   <a href="?page=add-social-point&amp;id=facebookshare">	
							   <div id="ember3293" class="Wlp-ResourceList-Row Wlp-ResourceList-Row--alignmentCenter ember-view">
								  <div style="flex-basis: 100%;text-align: inherit;" id="ember3294" class="Wlp-ResourceList-Cell ember-view">
									 <div class="Wlp-Stack Wlp-Stack--spacingNone Wlp-Stack--vertical">
										<div class="Wlp-Stack__Item">
										   Facebook share
										</div>										        
									 </div>
								  </div>
							   </div>
							   </a>
							</div>							  
						 </div>
					  </div>
				   </div>
				</li>
				<?php } ?>
				<?php if( !in_array('instagramfollow', $socialtype)){ ?>
				<li class="Wlp-ResourceList__ItemWrapper">
				   <div id="ember3297" class="__1094d ember-view">
					  <div class="Wlp-ResourceList-Item __1094d">
						 <button class="Wlp-ResourceList-Item__Button" tab-index="0" type="button"></button>
						 <div data-test-id="item-content" class="Wlp-ResourceList-Item__Container">
							<div class="Wlp-ResourceList-Item__Owned">							   
							   <div class="Wlp-ResourceList-Item__Media" data-test-id="media">
								  <span class="Wlp-Thumbnail  Wlp-Thumbnail--sizeSmall">
								  <img class="Wlp-Thumbnail__Image" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/instagram-follow.svg'; ?>">
								  </span>
							   </div>
							</div>
							<div class="Wlp-ResourceList-Item__Content">
							<a href="?page=add-social-point&amp;id=instagramfollow">
							   <div id="ember3301" class="Wlp-ResourceList-Row Wlp-ResourceList-Row--alignmentCenter ember-view">
								  <div style="flex-basis: 100%;text-align: inherit;" id="ember3302" class="Wlp-ResourceList-Cell ember-view">
									 <div class="Wlp-Stack Wlp-Stack--spacingNone Wlp-Stack--vertical">
										<div data-test-stack-item="" class="Wlp-Stack__Item">
										   Instagram follow
										</div>										        
									 </div>
								  </div>
							   </div>
							   </a>
							</div>							  
						 </div>
					  </div>
				   </div>
				</li>
				<?php } ?>
				<?php if( !in_array('twittershare', $socialtype)){ ?>
				<li class="Wlp-ResourceList__ItemWrapper">
				   <div id="ember3305" class="__1094d ember-view">
					  <div data-test-id="item-wrapper" class="Wlp-ResourceList-Item __1094d ">
						 <button class="Wlp-ResourceList-Item__Button" tab-index="0" type="button"></button>
						 <div data-test-id="item-content" class="Wlp-ResourceList-Item__Container">
							<div class="Wlp-ResourceList-Item__Owned">							   
							   <div class="Wlp-ResourceList-Item__Media" data-test-id="media">
								  <span class="Wlp-Thumbnail  Wlp-Thumbnail--sizeSmall">
								  <img class="Wlp-Thumbnail__Image" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/twitter-share.svg'; ?>">
								  </span>
							   </div>
							</div>
							<div class="Wlp-ResourceList-Item__Content">
							<a href="?page=add-social-point&amp;id=twittershare">
							   <div id="ember3309" class="Wlp-ResourceList-Row Wlp-ResourceList-Row--alignmentCenter ember-view">
								  <div style="flex-basis: 100%;text-align: inherit;" id="ember3310" class="Wlp-ResourceList-Cell ember-view">
									 <div class="Wlp-Stack Wlp-Stack--spacingNone Wlp-Stack--vertical">
										<div data-test-stack-item="" class="Wlp-Stack__Item">
										   Twitter share
										</div>										        
									 </div>
								  </div>
							   </div>
							   </a>
							</div>							  
						 </div>
					  </div>
				   </div>
				</li>
				<?php } ?>
				<?php if( !in_array('twitterfollow', $socialtype)){ ?>
				<li class="Wlp-ResourceList__ItemWrapper" data-test-item-id="4">
				   <div id="ember3313" class="__1094d ember-view">
					  <div data-test-id="item-wrapper" class="Wlp-ResourceList-Item __1094d ">
						 <button class="Wlp-ResourceList-Item__Button" tab-index="0" type="button"></button>
						 <div data-test-id="item-content" class="Wlp-ResourceList-Item__Container">
							<div class="Wlp-ResourceList-Item__Owned">							   
							   <div class="Wlp-ResourceList-Item__Media" data-test-id="media">
								  <span class="Wlp-Thumbnail  Wlp-Thumbnail--sizeSmall">
								  <img class="Wlp-Thumbnail__Image" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/twitter-follow.svg';  ?>">
								  </span>
							   </div>
							</div>
							<div class="Wlp-ResourceList-Item__Content">
							   <a href="?page=add-social-point&amp;id=twitterfollow">
							   <div id="ember3317" class="Wlp-ResourceList-Row Wlp-ResourceList-Row--alignmentCenter ember-view">
								  <div style="flex-basis: 100%;text-align: inherit;" id="ember3318" class="Wlp-ResourceList-Cell ember-view">
									 <div data-test-stack="" class="Wlp-Stack Wlp-Stack--spacingNone Wlp-Stack--vertical">
										<div data-test-stack-item="" class="Wlp-Stack__Item">
										   Twitter follow
										</div>										        
									 </div>
								  </div>
							   </div>
							   </a>
							</div>							  
						 </div>
					  </div>
				   </div>
				</li>
				<?php } ?>
			 </ul>			     
		  </div>
		  <div class="Wlp-Card__Section button-group-section">			 
			 <div data-test-stack="" class="Wlp-Stack Wlp-Stack--distributionTrailing">
				<div class="Wlp-Stack__Item" data-test-stack-item="true">
				   <button class="Wlp-Button close1" type="button">
					  <span class="Wlp-Button__Content">						 
						 <span class="Wlp-Button__Text">
						 Cancel
						 </span>						 
					  </span>
				   </button>
				</div>
			 </div>
		  </div>		  
	   </div>
	</div>
 </div>
</div>
</div>
</div>

<div id="myModal2" class="Wlp-modal-liquid-container liquid-container ember-view" style="">
<div class="liquid-child ember-view" style="top: 0px; left: 0px;">
<div class="Wlp-modal-container">
 <div class="Wlp-modal-overlay" role="button"></div>
 <div class="Wlp-modal-dialog ">
	<div id="ember3744" class="Wlp-modal-content-container __7cd1d with-centered-content ember-view">
	   <div class="Wlp-Card   __7cd1d">		  
		  <div class="Wlp-Card__Section">			 
			 <div data-test-stack="" class="Wlp-Stack Wlp-Stack--alignmentCenter">
				<div data-test-stack-item="" class="Wlp-Stack__Item Wlp-Stack__Item--fill">
				   <p id="ember3750" class="ember-view Wlp-DisplayText Wlp-DisplayText--sizeSmall " data-test-display-text="">
					  Ways to redeem
				   </p>
				</div>
				<div data-test-stack-item="" class="Wlp-Stack__Item">
				   <button class="Wlp-Link close2" type="button">
					  <span class="Wlp-Icon" data-test-icon="">
						 <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="Wlp-Icon__Svg" focusable="false" aria-hidden="true" id="ember3753-svg">
							<path d="M11.414 10l6.293-6.293a.999.999 0 10-1.414-1.414L10 8.586 3.707 2.293a.999.999 0 10-1.414 1.414L8.586 10l-6.293 6.293a.999.999 0 101.414 1.414L10 11.414l6.293 6.293a.997.997 0 001.414 0 .999.999 0 000-1.414L11.414 10z" fill="" fill-rule="evenodd"></path>
						 </svg>
					  </span>
				   </button>
				</div>
			 </div>
		  </div>
		  <div class="Wlp-Card__Section card-section-title">
			 <div class="Wlp-Card__SectionHeader ">
				<h3 id="ember3770" class="ember-view Wlp-Subheading" aria-label="Online Store">
				   Online Store
				</h3>
			 </div>
		  </div>
		  <div class="Wlp-ResourceList__ResourceListWrapper">		 
			  <ul class="Wlp-ResourceList" aria-live="polite">				
				<li class="Wlp-ResourceList__ItemWrapper" data-test-item-id="0">
				   <div id="ember3774" class="__b67d2 ember-view">
					  <div data-test-id="item-wrapper" class="Wlp-ResourceList-Item __b67d2 ">
						 <button class="Wlp-ResourceList-Item__Button" tab-index="0" type="button"></button>
						 <div data-test-id="item-content" class="Wlp-ResourceList-Item__Container">
							<div class="Wlp-ResourceList-Item__Owned">							   
							   <div class="Wlp-ResourceList-Item__Media" data-test-id="media">
								  <span class="Wlp-Thumbnail  Wlp-Thumbnail--sizeSmall">
								  <img class="Wlp-Thumbnail__Image" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/fixed-amount.svg'; ?>">
								  </span>
							   </div>
							</div>
							<div class="Wlp-ResourceList-Item__Content">
							   <a href="?page=add-reward-point&id=amountdiscount">
							   <div id="ember3779" class="Wlp-ResourceList-Row Wlp-ResourceList-Row--alignmentCenter ember-view">
								  <div style="flex-basis: 60%;text-align: inherit;" id="ember3780" class="reward-definition-listing-title Wlp-ResourceList-Cell ember-view">  
									 Amount discount
								  </div>
								  <div style="flex-basis: 40%;text-align: right;" id="ember3781" class="Wlp-ResourceList-Cell ember-view">									       
								  </div>
							   </div>
							   </a>
							</div>							  
						 </div>
					  </div>					  
				   </div>
				</li>
				<li class="Wlp-ResourceList__ItemWrapper" data-test-item-id="1">
				   <div id="ember3783" class="__b67d2 ember-view">
					  <div data-test-id="item-wrapper" class="Wlp-ResourceList-Item __b67d2 ">
						 <button class="Wlp-ResourceList-Item__Button" tab-index="0" type="button"></button>
						 <div data-test-id="item-content" class="Wlp-ResourceList-Item__Container">
							<div class="Wlp-ResourceList-Item__Owned">							   
							   <div class="Wlp-ResourceList-Item__Media" data-test-id="media">
								  <span class="Wlp-Thumbnail  Wlp-Thumbnail--sizeSmall">
								  <img class="Wlp-Thumbnail__Image" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/percentage-coupon.svg'; ?>">
								  </span>
							   </div>
							</div>
							<div class="Wlp-ResourceList-Item__Content">
							   <a href="?page=add-reward-point&id=percentageoff">
							   <div id="ember3788" class="Wlp-ResourceList-Row Wlp-ResourceList-Row--alignmentCenter ember-view">
								  <div style="flex-basis: 60%;text-align: inherit;" id="ember3789" class="reward-definition-listing-title Wlp-ResourceList-Cell ember-view">  
									 Percentage off
								  </div>
								  <div style="flex-basis: 40%;text-align: right;" id="ember3790" class="Wlp-ResourceList-Cell ember-view">									       
								  </div>
							   </div>
							   </a>
							</div>							  
						 </div>
					  </div>					  
				   </div>
				</li>							
			 </ul>			     
		  </div>
		  <div class="Wlp-Card__Section button-group-section">			 
			 <div class="Wlp-Stack Wlp-Stack--alignmentCenter">
				<div class="Wlp-Stack__Item Wlp-Stack__Item--fill">
				</div>
				<div class="Wlp-Stack__Item" data-test-stack-item="true">
				   <button class="Wlp-Button Wlp-Button--primary close4" type="button">
					  <span class="Wlp-Button__Content">						 
						 <span class="Wlp-Button__Text">
						 Cancel
						 </span>						 
					  </span>
				   </button>
				</div>
			 </div>
		  </div>		  
	   </div>
	</div>
 </div>
</div>
</div>
</div>
<script>
var modal = document.getElementById("myModal");
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close")[0];
var span1 = document.getElementsByClassName("close1")[0];
btn.onclick = function() {
modal.style.display = "block";
}
span.onclick = function() {
modal.style.display = "none";
}
span1.onclick = function() {
modal.style.display = "none";
}
window.onclick = function(event) {
if (event.target == modal) {
modal.style.display = "none";
}
}

var modal2 = document.getElementById("myModal2");
var btn2 = document.getElementById("myBtn2");
var span2 = document.getElementsByClassName("close2")[0];
var span4 = document.getElementsByClassName("close4")[0];
btn2.onclick = function() {
modal2.style.display = "block";
}
span2.onclick = function() {
modal2.style.display = "none";
}
span4.onclick = function() {
modal2.style.display = "none";
}
window.onclick = function(event) {
if (event.target == modal2) {
modal2.style.display = "none";
}
}
</script>