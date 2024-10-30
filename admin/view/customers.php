<main class="Wlp-app-main bm-outlet ember-view">
<div id="ember25-outlet-menu" class="bm-menu-container"></div>
<div class="bm-content">
<div class="Wlp-Page Wlp-Page--fullWidth __c0475">
<div class="Wlp-Page-Header Wlp-Page-Header__Header--hasSecondaryActions Wlp-Page-Header__Header--hasRollup">
<div class="Wlp-Page-Header__TitleAndRollup">
<div class="Wlp-Page-Header__Title ">
<div>
<div  class="Wlp-Stack Wlp-Stack--spacingTight Wlp-Stack--alignmentBaseline">
<div class="Wlp-Stack__Item" data-test-stack-item="true">
   <h1 id="ember101" class="ember-view Wlp-DisplayText Wlp-DisplayText--sizeLarge " data-test-display-text="">
	  Customers
   </h1>
</div>
</div>
</div>
<div>		 
</div>
</div>
<div class="Wlp-Page-Header__Rollup">
<span></span>
<div aria-owns="ember-basic-dropdown-content-ember104" tabindex="0" data-ebd-id="ember104-trigger" style="
display: inline-block;
overflow: inherit;
border: none;
" role="button" id="ember105" class="ember-basic-dropdown-trigger ember-view">
<button class="Wlp-Button Wlp-Button--plain Wlp-Button--iconOnly" type="button">
<span class="Wlp-Button__Content">
   <span class="Wlp-Button__Icon">
	  <span class="Wlp-Icon" data-test-icon="">
		 <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="Wlp-Icon__Svg" focusable="false" aria-hidden="true" id="ember108-svg">
			<path d="M6 10a2 2 0 11-4.001-.001A2 2 0 016 10zm6 0a2 2 0 11-4.001-.001A2 2 0 0112 10zm6 0a2 2 0 11-4.001-.001A2 2 0 0118 10z" fill="" fill-rule="evenodd"></path>
		 </svg>
	  </span>
   </span>
</span>
</button>
</div>
<div id="ember-basic-dropdown-content-ember104" class="ember-basic-dropdown-content-placeholder" style="display: none;"></div>
</div>
</div>
<div class="Wlp-Page-Header__Actions">
<div class="Wlp-Page-Header__SecondaryActions">
<div class="Wlp-Page-Header__IndividualActions">
<div class="Wlp-Page-Header__IndividualAction">
<button id="exportcustomers" class="Wlp-Header-Action" type="button" onclick="cashtomerexportcsv('customers.csv')">
   <span class="Wlp-Header-Action__ActionContent">
	  <span class="Wlp-Header-Action__ActionIcon ">
		 <span class="Wlp-Icon" data-test-icon="">
			<svg width="20" height="25" viewBox="0 0 20 25" xmlns="http://www.w3.org/2000/svg" class="Wlp-Icon__Svg" focusable="false" aria-hidden="true" id="ember113-svg">
			   <g fill-rule="evenodd">
				  <path d="M8.75 12.434V.716h2.5v11.718l4.116-4.025 1.768 1.729L10 17.114l-7.134-6.976 1.768-1.729zM17.5 19.559v2.444h-15V19.56H0v2.444c0 1.349 1.121 2.445 2.5 2.445h15c1.379 0 2.5-1.096 2.5-2.445V19.56h-2.5z" fill=""></path>
			   </g>
			</svg>
		 </span>
	  </span>
	  <span>Export customers</span>		  
   </span>
</button>
</div>
<div class="Wlp-Page-Header__IndividualAction">
<a href="#TB_inline?width=200&height=300&inlineId=modal-window-id" class="thickbox">
<button id="adjust-points-totals" class="Wlp-Header-Action" type="button">
   <span class="Wlp-Header-Action__ActionContent">
	  <span class="Wlp-Header-Action__ActionIcon ">
		 <span class="Wlp-Icon" data-test-icon="">
			<svg width="22" height="20" viewBox="0 0 22 20" xmlns="http://www.w3.org/2000/svg" class="Wlp-Icon__Svg" focusable="false" aria-hidden="true" id="ember116-svg">
			   <g fill-rule="evenodd">
				  <path d="M8 6c-1.103 0-2 .896-2 2 0 1.103.897 2 2 2s2-.897 2-2c0-1.104-.897-2-2-2m0 6c-2.206 0-4-1.794-4-4s1.794-4 4-4 4 1.794 4 4-1.794 4-4 4M2.159 18h11.683c-.598-1.808-2.834-3-5.842-3-3.008 0-5.243 1.192-5.841 3zm13.84 2H0v-1c0-3.533 3.29-6 8-6 4.712 0 8 2.467 8 6v1zM22 3h-3V0h-2v3h-3v2h3v3h2V5h3z" fill=""></path>
			   </g>
			</svg>
		 </span>
	  </span>
	  <span>Adjust points totals</span>		  
   </span>
</button>
</a>
</div>			 
</div>
</div>	  
</div>
</div>
<?php
if(isset($_POST['save_point']) && $_POST['customerid'] != "" ){
	$customerid = sanitize_text_field($_POST['customerid']);
	$adjust_point = sanitize_text_field($_POST['adjust_point']);
	
	$success = update_user_meta($customerid, 'total_point', $adjust_point);
	
	if($success){
		echo '<div id="setting-error-settings_updated" class="notice notice-success settings-error is-dismissible"><p>Successfully updated!</p></div>';
	}
}
?>
<?php add_thickbox(); ?>
<div id="modal-window-id" style="display:none;">
    <form method="POST" name="adjustpoints" action="" class="adjust-points-form">
		<label>Choose Email:</label><br>
		<select name="customerid" required>
			<option value="">- Select email-</option>
			<?php 
			$args = array(
			'role'    => 'customer',
			'order'   => 'ASC'
			);
			$users = get_users( $args );
			if(!empty($users)){
				
			foreach ( $users as $user ) {
			?>
			<option value="<?php echo $user->ID; ?>"><?php echo $user->user_email; ?></option>
			<?php } } ?>
		</select><br>
		<label>Set new point total: </label><br>
		<input type="text" name="adjust_point" value="" required><br>
		<input type="submit" name="save_point" value="Save" onclick="return confirm('The old points total will be replaced by the new total.');">
	</form>
</div>
<div class="Wlp-Page__Content">
<div id="ember118" class="liquid-animation-fade-in-out liquid-overflow-visible w-100 liquid-container ember-view" style="">
<div id="ember120" class="liquid-child ember-view" style="top: 0px; left: 0px;">
<div class="Wlp-Layout ">
<div class="Wlp-Layout__Section Wlp-liquid-if-empty">
<div id="ember125" class="Wlp-liquid-if-overflow-visible liquid-container ember-view">
</div>
</div>
<div class="Wlp-Layout__Section Wlp-liquid-if-empty">
<div id="ember130" class="Wlp-liquid-if-overflow-visible liquid-container ember-view">
</div>
</div>
<div class="Wlp-Layout__Section Wlp-liquid-if-empty">
<div id="ember135" class="Wlp-liquid-if-overflow-visible liquid-container ember-view">
</div>
</div>
<div class="Wlp-Layout__Section">
<div class="Wlp-Card">
<div id="ember140" class="resource-list-wrapper with-centered-shortcut-actions ember-view">
	  <div  class="Wlp-Stack Wlp-Stack--vertical Wlp-Stack--noWrap">
		 <div data-test-stack-item="" class="Wlp-Stack__Item">
			<div class="Wlp-ResourceList__ResourceListWrapper">
			   <div class="Wlp-ResourceList__FiltersWrapper">
				<table class="wp-list-table widefat fixed striped posts">
				<thead>
					<tr>
						<th>Userid</th>
						<th>Username</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Email</th>
						<th>Balance Points</th>
					</tr>
				</thead>
				<tbody id="the-list">
				<?php
				$args = array(
				'role'    => 'customer',
				'order'   => 'ASC'
				);
				$users = get_users( $args );
				if(!empty($users)){
					foreach ( $users as $user ) {
						
						$total_point = get_user_meta($user->ID, 'total_point', true);
						
						if($total_point){
							$total_point = get_user_meta($user->ID, 'total_point', true);
						}else{
							$total_point = 'No Points Found';
						}
					?>	
					<tr>
						<td><?php echo esc_html( $user->ID ); ?></td>
						<td><?php echo esc_html( $user->display_name ); ?></td>
						<td><?php echo esc_html( $user->first_name ); ?></td>
						<td><?php echo esc_html( $user->last_name ); ?></td>
						<td><?php echo esc_html( $user->user_email ); ?></td>
						<td><?php if($total_point){ echo $total_point; } ?></td>
					</tr>
					<?php } 
				} else { ?>
				<tr>
					<td></td><td></td>
					<td>No customers found</td>
					<td></td><td></td><td></td>
				</tr>
				<?php } ?>
				</tbody>
				</table>
			</div>
		</div>   
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</main>
<script>
function cashtomercustomerdownload(csv, filename) {
    var csvFile;
    var downloadLink;

    csvFile = new Blob([csv], {type: "text/csv"});
    downloadLink = document.createElement("a");
    downloadLink.download = filename;
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
}
function cashtomerexportcsv(filename) {
    var csv = [];
    var rows = document.querySelectorAll("table tr");
    
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length; j++) 
            row.push(cols[j].innerText);
        
        csv.push(row.join(","));        
    }
    cashtomercustomerdownload(csv.join("\n"), filename);
}
</script>