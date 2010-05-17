<?php
function idx_broker_admin_page() {
?>

<script src="<?php bloginfo('wpurl'); ?>/wp-content/plugins/idx-broker-wordpress-plugin/idxBroker.js" type="text/javascript"></script>

<div class="wrap" style="width: 700px;">
	<h2>IDX Broker Plugin Options</h2>
	
	<h3>General Settings</h3>
	
	<form method="post" action="options.php" id="idxOptions">
		<?php wp_nonce_field('update-options'); ?>
		<ul>
			<li style="height: 25px;">
				<label for="idx_broker_cid">Customer Identification Number (CID): </label><a href="http://www.idxbroker.com/support/kb/questions/285/" style="font-size: 8pt;">What's this?</a>
				<input style="float: right;" name="idx_broker_cid" type="text" id="idx_broker_cid" value="<?php echo get_option('idx_broker_cid'); ?>" />
			</li>
			<li style="height: 25px;">
				<label for="idx_broker_pass">Your IDX Broker Password:</label> <a href="http://www.idxbroker.com/support/kb/questions/285/" style="font-size: 8pt;">What's this?</a>
				<input style="float: right;" name="idx_broker_pass" type="password" id="idx_broker_pass" value="<?php echo get_option('idx_broker_pass'); ?>" />
			</li>
			<li style="height: 25px;">
				<label for="idx_broker_domain">Your Website Domain (subdomain.domain.com):</label> <a href="http://www.idxbroker.com/support/kb/questions/285/" style="font-size: 8pt;">What's this?</a>
				<input style="float: right;" name="idx_broker_domain" type="text" id="idx_broker_domain" size="30" value="<?php echo get_option('idx_broker_domain'); ?>" />
			</li>
		</ul>
	
		<h3>Widgets</h3>
		
		<p><a href="widgets.php">Click here</a> to visit the Widgets page and add IDX Broker widgets to your sidebar(s).</p>
	
		
		<h3>Menu Links Tool</h3>
		
		<p>Many Realtors&reg; add 2-3 links to their site or blog.  Often it's basic or map search, followed by a link to your active listings (Featured Properties).</p>
		
		<p>IDX Broker generates the content for these pages automatically using MLS data that is updated every 24 hours. To see if IDX Broker offers coverage in your area, <a href="http://www.idxbroker.com">click here</a>. </p>
		
		<p>Use the tool below to add IDX Broker links as Pages in your navigation.  When you are done entering your information and choosing/renaming your links, simply hit the "Save Changes" button to apply your settings.</p>
		
		<span style="float:left; font-weight:bold;">Activate -</span>
		<span style="float:left; font-weight:bold; margin-left: 7px;">IDX Broker Page Link</span>
		<span style="float:right; font-weight:bold; margin-right: 6px;">Rename Page Link</span>
		<div style="clear: both;"></div>
		
		<ul>
			<li style="height: 20px;">
				<?php $basicCheck = (get_option('idx_broker_basicSearchLink') == 'on')?'checked="checked"':''; ?>
				<input type="checkbox" name="idx_broker_basicSearchLink" id="idx_broker_basicSearchLink" <? echo $basicCheck; ?>" class="idx_broker_basicSearchLink" />
				<label for="idx_broker_basicSearchLink" style="padding-left:2px;">- Basic Search</label>
				<input style="float: right;" class="idx_broker_basicSearchLabel" name="idx_broker_basicSearchLabel" type="text" id="idx_broker_basicSearchLabel" value="<?php echo get_option('idx_broker_basicSearchLabel'); ?>" />
			</li>
			<li style="height: 20px;">
				<?php $advancedCheck = (get_option('idx_broker_advancedSearchLink') == 'on')?'checked="checked"':''; ?>
				<input type="checkbox" name="idx_broker_advancedSearchLink" id="idx_broker_advancedSearchLink" <? echo $advancedCheck; ?> class="idx_broker_advancedSearchLink" />
				<label for="idx_broker_advancedSearchLink" style="padding-left: 2px;">- Advanced Search</label>
				<input style="float: right;" class="idx_broker_advancedSearchLabel" name="idx_broker_advancedSearchLabel" type="text" id="idx_broker_advancedSearchLabel" value="<?php echo get_option('idx_broker_advancedSearchLabel'); ?>" />
			</li>
			<li style="height: 20px;">
				<?php $mapCheck = (get_option('idx_broker_mapSearchLink') == 'on')?'checked="checked"':''; ?>
				<input type="checkbox" name="idx_broker_mapSearchLink" id="idx_broker_mapSearchLink" <? echo $mapCheck; ?> class="idx_broker_mapSearchLink" />
				<label for="idx_broker_mapSearchLink" style="padding-left: 2px;">- Map Search</label>
				<input style="float: right;" class="idx_broker_mapSearchLabel" name="idx_broker_mapSearchLabel" type="text" id="idx_broker_mapSearchLabel" value="<?php echo get_option('idx_broker_mapSearchLabel'); ?>" />
			</li>
			<li style="height: 20px;">
				<?php $addressCheck = (get_option('idx_broker_addressSearchLink') == 'on')?'checked="checked"':''; ?>
				<input type="checkbox" name="idx_broker_addressSearchLink" id="idx_broker_addressSearchLink" <? echo $addressCheck; ?> class="idx_broker_addressSearchLink" />
				<label for="idx_broker_addressSearchLink" style="padding-left: 2px;">- Address Search</label>
				<input style="float: right;" class="idx_broker_addressSearchLabel" name="idx_broker_addressSearchLabel" type="text" id="idx_broker_addressSearchLabel" value="<?php echo get_option('idx_broker_addressSearchLabel'); ?>" />
			</li>
			<li style="height: 20px;">
				<?php $listingCheck = (get_option('idx_broker_listingSearchLink') == 'on')?'checked="checked"':''; ?>
				<input type="checkbox" name="idx_broker_listingSearchLink" id="idx_broker_listingSearchLink" <? echo $listingCheck; ?> class="idx_broker_listingSearchLink" />
				<label for="idx_broker_listingSearchLink" style="padding-left: 2px;">- Listing Search</label>
				<input style="float: right;" class="idx_broker_listingSearchLabel" name="idx_broker_listingSearchLabel" type="text" id="idx_broker_listingSearchLabel" value="<?php echo get_option('idx_broker_listingSearchLabel'); ?>" />
			</li>
			<li style="height: 20px;">
				<?php $featuredCheck = (get_option('idx_broker_featuredLink') == 'on')?'checked="checked"':''; ?>
				<input type="checkbox" name="idx_broker_featuredLink" id="idx_broker_featuredLink" <? echo $addressCheck; ?> class="idx_broker_featuredLink" />
				<label for="idx_broker_featuredLink" style="padding-left: 2px;">- Featured Properties</label>
				<input style="float: right;" class="idx_broker_featuredLabel" name="idx_broker_featuredLabel" type="text" id="idx_broker_featuredLabel" value="<?php echo get_option('idx_broker_featuredLabel'); ?>" />
			</li>
			<li style="height: 20px;">
				<?php $soldPendCheck = (get_option('idx_broker_soldPendLink') == 'on')?'checked="checked"':''; ?>
				<input type="checkbox" name="idx_broker_soldPendLink" id="idx_broker_soldPendLink" <? echo $soldPendCheck; ?> class="idx_broker_soldPendLink" />
				<label for="idx_broker_soldPendLink" style="padding-left: 2px;">- Sold/Pending Properties</label>
				<input style="float: right;" class="idx_broker_soldPendLabel" name="idx_broker_soldPendLabel" type="text" id="idx_broker_soldPendLabel" value="<?php echo get_option('idx_broker_soldPendLabel'); ?>" />
			</li>
		</ul>
		
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="idx_broker_cid,idx_broker_pass,idx_broker_domain,idx_broker_basicSearchLink,idx_broker_basicSearchLabel,idx_broker_advancedSearchLink,idx_broker_advancedSearchLabel,idx_broker_mapSearchLink,idx_broker_mapSearchLabel,idx_broker_addressSearchLink,idx_broker_addressSearchLabel,idx_broker_listingSearchLink,idx_broker_listingSearchLabel,idx_broker_featuredLink,idx_broker_featuredLabel,idx_broker_soldPendLink,idx_broker_soldPendLabel" />		
		<p>
			<span style="float: left; color:#21759B; font-weight: bold; " id="status"></span>
			<input style="float: right;" type="submit" value="<?php _e('Save Changes') ?>" id="saveChanges" ajax="<?php bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php" />
			<div style="clear:both;"></div>
		</p>	
	
	</form>
	
	
</div>

<?php
}
?>