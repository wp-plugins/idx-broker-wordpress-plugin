<?php
/*
Plugin Name: IDX Broker
Plugin URI: http://www.idxbroker.com/wordpress/
Description: The IDX Broker plugin gives Realtors&trade; an easier way to add IDX Broker Widgets, Menu links, and Custom Links to any Wordpress blog. 
Version: 1.2.5
Author: IDX, Inc.
Author URI: http://www.idxbroker.com
License: GPL
*/

/*
*	Used for debugging purposes
*/

//ini_set('display_errors', 1);

add_action('admin_menu', 'idx_broker_menu');
add_action('admin_menu', 'idx_broker_options_init' );

/*
*	This function runs on plugin activation.  It sets up all options that will need to be
*	saved that we know of on install, including cid, pass, domain, and main nav links from
* 	the idx broker system.
*/

function idx_broker_options_init(){
	
	//register our settings
	register_setting( 'idx-settings-group', "idx_broker_cid" );		
	register_setting( 'idx-settings-group', "idx_broker_pass" );		
	register_setting( 'idx-settings-group', "idx_broker_domain" );		
	register_setting( 'idx-settings-group', "idx_broker_basicSearchLink" );
	register_setting( 'idx-settings-group', "idx_broker_basicSearchLabel" );
	register_setting( 'idx-settings-group', "idx_broker_advancedSearchLink" );
	register_setting( 'idx-settings-group', "idx_broker_advancedSearchLabel" );
	register_setting( 'idx-settings-group', "idx_broker_mapSearchLink" );
	register_setting( 'idx-settings-group', "idx_broker_mapSearchLabel" );
	register_setting( 'idx-settings-group', "idx_broker_addressSearchLink" );
	register_setting( 'idx-settings-group', "idx_broker_addressSearchLabel" );
	register_setting( 'idx-settings-group', "idx_broker_listingSearchLink" );
	register_setting( 'idx-settings-group', "idx_broker_listingSearchLabel" );
	register_setting( 'idx-settings-group', "idx_broker_featuredLink" );
	register_setting( 'idx-settings-group', "idx_broker_featuredLabel" );
	register_setting( 'idx-settings-group', "idx_broker_soldPendLink" );
	register_setting( 'idx-settings-group', "idx_broker_soldPendLabel" );
	
	/*
	 *	Since we have custom links that can be added and deleted inside
	 *	the IDX Broker admin, we need to grab them and set up the options
	 *	to control them here.  First let's grab them, if the cid is not blank.
	 */
	
	if (get_option('idx_broker_cid') != '') {
	
		$customLinks = idx_getCustomLinks();
	
	}
	
	/*
	 *	Next loop through each one and set up the option.
	 */
	
	foreach($customLinks as $link) {
		
		$tempName = 'idx_custom_'.$link[0];
		register_setting( 'idx-settings-group', "$tempName" );
		
	}
	
}

/*
 *	This adds the options page to the WP admin.
 */

function idx_broker_menu() {

	add_options_page('IDX Broker Plugin Options', 'IDX Broker Plugin', 'administrator', 'idx-broker', 'idx_broker_admin_page');
	
}

/*
 *	This is tiggered and is run by idx_broker_menu, it's the actual IDX Broker Admin page and display.
 */


function idx_broker_admin_page() {
	
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	
?>

<script src="<?php bloginfo('wpurl'); ?>/wp-content/plugins/idx-broker-wordpress-plugin/idxBroker.js" type="text/javascript"></script>

<div class="wrap" style="width: 800px;">
	<h2>IDX Broker Plugin Options</h2>
	<h3 style="border-bottom: 1px solid #ccc;">General Settings</h3>
	
	<form method="post" action="options.php" id="idxOptions">
		<div id="blogUrl" style="display: none;" ajax="<?php bloginfo('wpurl'); ?>"></div>
		<ul>
			<li style="height: 25px;">
				<label for="idx_broker_cid">Customer Identification Number (CID): </label>
				<a href="http://www.idxbroker.com/support/kb/questions/285/" style="font-size: 8pt;">What's this?</a>
				<input style="float: right;" name="idx_broker_cid" type="text" id="idx_broker_cid" value="<?php echo get_option('idx_broker_cid'); ?>" />
			</li>
			<li style="height: 25px;">
				<label for="idx_broker_pass">Your IDX Broker Password:</label>
				<a href="http://www.idxbroker.com/support/kb/questions/285/" style="font-size: 8pt;">What's this?</a>
				<input style="float: right;" name="idx_broker_pass" type="password" id="idx_broker_pass" value="<?php echo get_option('idx_broker_pass'); ?>" />
			</li>
			<li style="height: 25px;">
				<label for="idx_broker_domain">Your Website Domain (subdomain.domain.com):</label>
				<a href="http://www.idxbroker.com/support/kb/questions/285/" style="font-size: 8pt;">What's this?</a>
				<input style="float: right;" name="idx_broker_domain" type="text" id="idx_broker_domain" size="30" value="<?php echo get_option('idx_broker_domain'); ?>" />
			</li>
		</ul>
	
		<h3 style="border-bottom: 1px solid #ccc;">Widgets</h3>
		
		<p><a href="widgets.php">Click here</a> to visit the Widgets page and add IDX Broker widgets to your sidebar(s).</p>
	
		
		<h3 style="border-bottom: 1px solid #ccc;">Menu Links Tool</h3>
		
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
		<p>
			<span style="float: left; color:#21759B; font-weight: bold; " class="status"></span>
			<input style="float: right;" type="submit" value="<?php _e('Save Changes') ?>" id="saveChanges" ajax="<?php bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php" />
			<div style="clear:both;"></div>
		</p>
		<h3 class="expandable" style="cursor: pointer;height: 30px;border-bottom: 1px solid #ccc;">
			<span class="expand">[+]</span> Custom Links
		</h3>
		<div id="customLinks" style="display: none; padding-bottom: 15px;">
			<p>You can add your IDX Broker custom links to your main navigation in this area.  Simply check or uncheck the links to add or remove them, and click the save changes button above. Links can be build in the <a href="http://www.idxco.com/mgmt/">IDX Broker Admin</a>.</p>  
			<ul>
<?php
				/*
				*	We want the client the ability to place any custom built links in the system
				*	in the main navigation.  First lets grab them.
				*/
	
				$customLinks = idx_getCustomLinks();
				
				if(count($customLinks) > 0) {
				
					/*
					*	Now that we have seperated the list into individual array elements, we need to loop
					*	over them and seperate again by the pipe character ->  link_name | http://link.tiny.url
					*/
	
					foreach ($customLinks as $link){
						
						/*
						*	Now we have gathered all our info, now we
						*	need to display the custom link and a checkbox to allow the user to toggle it on
						*	or off.  First we gather the setting, and if it's on then we need to display
						*	checked="checked"
						*/
						
						$checkOption = (get_option("idx_custom_".$link[0]) == 'on')?'checked="checked"':'';
?>
						<li style="height: 20px;">
							<input type="checkbox" name="idx_custom_<? echo $link[0]; ?>" id="idx_custom_<? echo $link[0]; ?>" <? echo $checkOption; ?> class="customLink" url="<? echo $link[1]; ?>" />
							<label for="idx_custom_<? echo $link[0]; ?>" style="padding-left: 2px;">- <? echo str_replace('_', ' ', $link[0]); ?></label>
						</li>
<?php
					}
					
					/*
					*	Ther are no custom links in the system, so just display some text and a link to the admin to
					*	add custom links.
					*/
					
				} else {
?>
					<div>
						<span style="font-weight:bold">You have no custom links created.</span> Log into the <a href="http://www.idxco.com/mgmt">IDX Broker Admin</a> to create custom links.
					</div>
<?php
				}
?>
			</ul>
			<p>If you have removed custom links in the <a href="http://www.idxco.com/mgmt/">IDX Broker Admin</a> that were in your main navigation, you may need to clear them if they remain in your navigation.  Simply click the 'Clear Old Custom Links' to remove them.</p>
			<span style="float: left; color:#21759B; font-weight: bold; " class="status"></span>
			<input style="float: right;" type="submit" value="<?php _e('Clear Old Custom Links') ?>" id="clearLinks" />
			<div style="clear:both;"></div>
		</div>
		<h3 class="expandable" style="cursor: pointer;height: 30px;border-bottom: 1px solid #ccc;">
			<span class="expand">[+]</span> Advanced
		</h3>
		
		<div id="advanced" style="display: none; padding-bottom: 15px;">
			<p>
				For Advanced Users Only: This section provides you with the tools necessary to synchronize your IDX pages with changes made to your theme. Read <a href="http://www.idxbroker.com/support/kb/questions/288/">this article</a> for detailed instructions.
			</p>
			
			<div>
				Step 1: Choose your wrapper update option:
				<select name="wrapperOption" id="wrapperOption">
					<option value="echoCode">Copy and Paste Code</option>
					<option value="writeCode">Write to Include Files</option>
				</select>
			</div>
			
			<div>
				Step 2: <input id="updateWrapper" type="submit" style=''value='<?php _e('Wrap It!') ?>' ajax="<?php bloginfo('wpurl'); ?>" /><span style="color:#21759B; font-weight: bold;" id="wrapperStatus"></span>
			</div>
			
			<div id="echoStep">
				
				<div>
					Step 3: Copy and paste the Header and Footer Code below into your IDX&nbsp;Broker Global HTML Wrapper. <a href="http://www.idxbroker.com/support/kb/questions/291/">How do I do this?</a>
				</div>
				
				<div id="echoedCode"></div>
			</div>
			
			<div id="writeStep" style="display: none;">
				
				<div>
					Step 3: Copy and paste the Header and Footer URLs below into your IDX&nbsp;Broker Global HTML Wrapper. <a href="http://www.idxbroker.com/support/kb/questions/290/">How do I do this?</a>
					<div>
						<p style="font-weight: bold;">Header File:</p>
						<?php bloginfo('wpurl'); ?>/wp-content/plugins/idx-broker-wordpress-plugin/wrapper/header.php
					</div>
					<div>
						<p style="font-weight: bold;">Footer File:</p>
						<?php bloginfo('wpurl'); ?>/wp-content/plugins/idx-broker-wordpress-plugin/wrapper/footer.php
					</div>	
				</div>
			</div>
		</div>
		<?php settings_fields( 'idx-settings-group' ); ?>
	</form>
</div>

<?php

}


/*		idxUpdateLinks();
 *
 *		Manages IDX links in the header nav.
 *		
 */

function idxUpdateLinks() {
	
	/*
	*	The global WP object
	*/
	
	global $wpdb;
	
	/*
	*	 These arrays how the current state of the links in the admin, and also the labels
	*	 of each of the links if the client wants to customize them, passed through a $_GET
	*	 ajax call.  We build these out to easily loop through them all.
	*/
	
	$links = array( 'basic' => $_GET['basicLink'],'advanced' => $_GET['advancedLink'], 'map' => $_GET['mapLink'], 'address' => $_GET['addressLink'], 'listing' => $_GET['listingLink'], 'featured' => $_GET['featuredLink'], 'soldPend' => $_GET['soldPendLink'] );
	$labels = array( 'basic' => $_GET['basicLabel'],'advanced' => $_GET['advancedLabel'], 'map' => $_GET['mapLabel'], 'address' => $_GET['addressLabel'], 'listing' => $_GET['listingLabel'], 'featured' => $_GET['featuredLabel'], 'soldPend' => $_GET['soldPendLabel'] );

	/*
	*	Loop through all the link so we can manage them one by one.
	*/

	foreach($links as $type => $state) {
		
		/*
		*	Were going to add a prefix here so that we can easily distinguish
		*	these links later in the table to clean them out or whatever we
		*	would want to do with them.
		*/
		
		$where = 'idx_main_'.$type;
		
		/*
		*	If the value of the link's checkbox is true.
		*/
		
		if ($state == "true") {
			
			/*
			*	Do different things based on what link we are going to work with.  If a custom label is not set
			*	then we set a default one.  We also need to build out each link URL from the settings in the
			*	admin.
			*/
			
			switch($type){
				
				/*
				* Basic Search Link
				*/
				
				case "basic":
					$label = ($labels[$type] != '')?$labels[$type]:"Basic Search";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/basicSearch.php";
					break;
				
				/*
				*	Advanced Search Link
				*/
				
				case "advanced":
					
					$label = ($labels[$type] != '')?$labels[$type]:"Advanced Search";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/advancedSearch.php";
					break;
				
				/*
				*	Map Search Link
				*/
				
				case "map":
					
					$label = ($labels[$type] != '')?$labels[$type]:"Map Search";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/mapSearch.php";
					break;
				
				/*
				* 	Address Search Link
				*/
				
				case "address":
					
					$label = ($labels[$type] != '')?$labels[$type]:"Address Search";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/addressSearch.php";
					break;
				
				/*
				*	Listing Search Link
				*/
				
				case "listing":
					
					$label = ($labels[$type] != '')?$labels[$type]:"Listing Search";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/listingIDSearch.php";
					break;
				
				/*
				*	Featured Properties Link
				*/
				
				case "featured":
					
					$label = ($labels[$type] != '')?$labels[$type]:"Featured Properties";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/featured.php";
					break;
				
				/*
				* 	Sold and Pending Link
				*/
				
				case "soldPend":
					
					$label = ($labels[$type] != '')?$labels[$type]:"Sold/Pending Properties";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/soldPending.php";
					break;
				
			}
			
			/*
			*	 So in order to know which type of query to do, we need to see if
			*	 the link already exists in the table. If so, then we UPDATE, if not
			*	 then we need to INSERT INTO.
			*/
			
			$current = mysql_query( "SELECT `ID` FROM `wp_posts` WHERE `post_name` = '$where' " );
			$row = mysql_fetch_array($current);
			
			/*
			*	The number of rows returned is more than none, so we do an UPDATE. We need to
			*	write into two tables as required by WP and our filter.
			*/
			
			if(mysql_num_rows($current) > 0){
				
				$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->posts SET post_title = %s, post_type='page', post_name=%s WHERE ID = %d", $label, $where, $row[ID] ) );
				$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_key = '_links_to', meta_value = %s WHERE post_id = %d", $url, $row[ID] ) );
			
			/*
			* 	There are no rows returned, so the links don't exist yet, so we need to INSERT INTO.
			*/
			
			} else {
				
				$wpdb->query( $wpdb->prepare( "INSERT INTO $wpdb->posts SET post_title = %s, post_type='page', post_name=%s", $label, $where ) );
				$wpdb->query( $wpdb->prepare( "INSERT INTO $wpdb->postmeta SET meta_key = '_links_to', meta_value = %s, post_id = %d", $url, mysql_insert_id() ) );
				
			}
			
		/*
		* 	The current state of the checkbox is FALSE, so we need to check if the link
		* 	is inside the table already.
		*/
			
		} else {
			
			/*
			*	Query the table to see if the links already exist.
			*/
			
			$current = mysql_query( "SELECT ID FROM wp_posts WHERE post_name = '$where' " );
			$row = mysql_fetch_array($current);
			
			/*
			*	If the link exists and the client has unchecked it then we know we
			*	need to delete it from both tables.
			*/
			
			if(mysql_num_rows($current) > 0){
				
				mysql_query( "DELETE FROM wp_posts WHERE ID ='$row[ID]'" );
				mysql_query( "DELETE FROM wp_postmeta WHERE post_id = '$row[ID]' " );
				
			}
		}
	}
	
	/*
	*	End without returning anything (AJAX)
	*/
	
	
	die();
	
}

/*
*	This function will allow users to place custom IDX Broker links into their
*	main navigation.  This function is called via the admin page and admin-ajax.php 
*/

function idxUpdateCustomLinks () {
	
	/*
	*	The global wp object
	*/
	
	global $wpdb;
	
	/*
	*	Loop through all the $_GET variables as key -> value pairs
	*/

	foreach($_GET as $key => $value) {
		
		/*
		*	If we find a key whose value is set to true.
		*/
		
		if($value == 'true'){
			
			/*
			*	Take the key and convert all underscores to spaces.  Then we need to cut
			*	off the first 11 characters 'idx_broker_' as that was used as a key
			*	in the admin to save the link states.
			*/
			
			$label = substr(str_replace('_', ' ', $key),11,strlen($key));
			
			/*
			*	Now we can look up the url by using the key with the suffix 'Url' added,
			*	this is also in our $_GET string.
			*/
			
			$url = $_GET[$key.'Url'];
			
			/*
			*	Now we need to look in the table and see if this entry already exists,
			*	if it does then we just need to UPDATE, if not, then we INSERT.
			*/
			
			$current = mysql_query( "SELECT ID FROM wp_posts WHERE post_name = '$key' " );
			$row = mysql_fetch_array($current);

			if(mysql_num_rows($current) > 0){
				
				/*
				*	The entry already exists, so we can just UPDATE with the new information.
				*/
				
				$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->posts SET post_title = %s, post_type='page', post_name=%s WHERE ID = %d", $label, $key, $row[ID] ) );
				$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_key = '_links_to', meta_value = %s WHERE post_id = %d", $url, $row[ID] ) );
				
			} else {
				
				/*
				*	The entry didn't exist, so we will need to INSERT the new entry.
				*/
				
				$wpdb->query( $wpdb->prepare( "INSERT INTO $wpdb->posts SET post_title = %s, post_type='page', post_name=%s", $label, $key ) );
				$wpdb->query( $wpdb->prepare( "INSERT INTO $wpdb->postmeta SET meta_key = '_links_to', meta_value = %s, post_id = %d", $url, mysql_insert_id() ) );
				
			}
			
			/*
			*	If we find a key whose value is false.
			*/
			
		} else {
			
			/*
			*	Lets look up the ID of the entry so we can delete it, if it exists.
			*/
			
			$current = mysql_query( "SELECT ID FROM wp_posts WHERE post_name = '$key' " );
			$row = mysql_fetch_array($current);
			
			/*
			*	We found a matching entry
			*/
			
			if(mysql_num_rows($current) > 0){
				
				/*
				*	Delete the unwanted entry in the table.
				*/
				
				mysql_query( "DELETE FROM wp_posts WHERE ID ='$row[ID]'" );
				mysql_query( "DELETE FROM wp_postmeta WHERE post_id = '$row[ID]' " );

				
			}
		}

		
	}
	
	die();
	
}

/*
*	idx_clearCustomLinks()
*	We need a way to clear out the custom links as they are managed from the middleware.  This is
*	because they may be removed in the middleware, but the settings will still remain in the wp
*	pages, but the controls will disappear in the admin.
*/


function idx_clearCustomLinks () {
	
	/*
	*	First lets get an array of our current custom links, so that we
	*	can compare the current ones, with what is saved in the wp_posts table.
	*/
	
	$currentCustomLinks = idx_getCustomLinks();
	
	/*
	*	All of our custom links in the db are keyed with an idx_custom_ prefix.  So first
	*	lets grab all the links we have placed in the table.
	*/
	
	$links = mysql_query( "SELECT `post_name`, `ID` FROM wp_posts" );
	
	/*
	*	Loop through all the posts
	*/
	
	while ($row = mysql_fetch_array($links)) {
		
		/*
		*	Look at the post name and grab the first 11 characters, if it matches the
		*	key that we have placed on all custom links then we have found one.
		*/
		
		if(substr($row['post_name'], 0, 11) == 'idx_custom_'){
			
			/*
			*	Now that we have found a custom link that has been saved in the table,
			*	we need to compare it with our current custom links.  So we'll loop over the
			*	curretnCustomLinks array and do a comparison.
			*/
			
			foreach($currentCustomLinks as $linkInfo){
				
				/*
				*	The first element in each array element is the link name.  To clean up the
				*	code lets create a variable with the key added to the front for comparison.
				*/
				
				$checkKey = 'idx_custom_' . $linkInfo[0];
				
				/*
				*	Now check the current table custom link with the current links array.  If they
				*	match then we know we need to leave this custom link alone so that the user
				*	can manage it through the WP Plugin Admin
				*/
				
				if($checkKey == $row['post_name']){
					
					/*
					*	Build out an array of links that need to stay after our comparison.
					*/
					
					$leaveCustomLink[] = $row['post_name'];
					
				}
			}
		}
	}
	
	/*
	*	Query for the links in the table again.
	*/
	
	$links = mysql_query( "SELECT `post_name`, `ID` FROM `wp_posts` WHERE `post_name` LIKE 'idx_custom_%'" );
	
	/*
	*	Loop through the results of the query.
	*/
	
	while ($row = mysql_fetch_array($links)) {
		
		echo $row['post_name'];
		
		/*
		*	Check to see if the link is a main link, if not, loop through the custom links that we need to keep,
		*	declare a variable that will tell us if we need to delete the link.
		*/
		
		if(substr($row['post_name'], 0, 9) == 'idx_main_'){
			
			$leaveThisLink = TRUE;
			
		} else {
			
			$leaveThisLink = FALSE;
			
			foreach($leaveCustomLink as $key => $linkName){
			
				/*
				*	Compare what we need to keep to what we have in the table results, and also check to see
				*	if it's a main link, as we want to keep these.
				*
				*/
		
				if($row['post_name'] ==  $linkName){
					
					/*
					*	If we find a match then we set a variable telling us that we don't need
					*	to delete this particular table entry. 
					*/
					
					$leaveThisLink = TRUE;
					
				}
			}
		}
		
		/*
		*	If we didn't find this link in the saved link array, and we didn't set
		*	the leaveThisLink variable to TRUE, then delete the link from both tables.
		*/
		
		if (!$leaveThisLink) {
			
			mysql_query( "DELETE FROM `wp_posts` WHERE `post_name` = '$row[post_name]' " );
			mysql_query( "DELETE FROM `wp_postmeta` WHERE `post_id` = '$row[ID]' " );
			
		}
	}
	
	/*
	*	Done, die without returning anything!
	*/
	
	die();
	
}

/*
*	idx_getCustomLinks()
*	Using our web services function, lets get the custom links built in the middleware,
*	clean and prepare them, and return them in a new array for use.
*/


function idx_getCustomLinks () {

	/*
	*	First we need to grab a string of current custom links
	*	with our web services script.
	*/
	
	$savedSearches = idx_web_services( 'listSavedSearches' );
	
	/*
	*	Build the initial array by seperating by the new link character '\n'
	*/
	
	$lines = explode("\n",$savedSearches);
	
	/*
	*	Loop over the array and seperate the link name and the link url by
	*	the pipe character "|".  We will save all the links and urls in
	*	a new array $customLinks.
	*/

    foreach ($lines as $link) {
			
		$customLinks[] = explode("|", $link);
	
	}
	
	/*
	*	We always have an extra '/n' in the inital array, so we need to
	*	pop it off the end as it's useless.
	*/
	
	array_pop($customLinks);
	
	/*
	*	Return our new array of custom links.
	*/
	
	return $customLinks;
	
}


/*
*	We need to place a flag to let us know where to start the removal of the
*	content area to replace with IDX content.  To do so we just echo an empty
*	div that is set to display: none
*/

function idx_start () {
	
	return '<div id="idxStart" style="display: none;"></div>';

}

/*
*	We need to place a flag to let us know where to end the removal of the
*	content area to replace with IDX content.  To do so we just echo an empty
*	div that is set to display: none
*/

function idx_stop () {
	
	return '<div id="idxStop" style="display: none;"></div>';

}


function idxUpdateWrapper () {
	
	/*
	*	Get the wrapper method
	*/	
	
	$method = $_GET['method'];
	
	/*
	*	Get the raw wrapper string
	*/
	
	$wrapper = getWrapper($_GET['url']);
	
	/*
	*	Parse the wrapper to find the header and footer strings
	*/
	
	$header = parseWrapper($wrapper, 'header');
	$footer = parseWrapper($wrapper, 'footer');
	
	/*
	*	Depending on the method, we will do different things
	*/
	
	if($method == 'echoCode'){
		
		/*
		 *	Return a formated header and footer message
		 */
		
		$returnable = "<div>Header:<textarea cols='100' rows='5'>".$header."</textarea></div><div>Footer:<textarea cols='100' rows='5'>".$footer."</textarea></div>";
		
		echo $returnable;
		
	} elseif($method == 'writeCode') {
		
		/*
		*	Set up our wrapper file paths and file names
		*/
		
		$wrapperDir = '../wp-content/plugins/idx-broker-wordpress-plugin/wrapper';
		$headerFile = $wrapperDir."/header.php";
		$footerFile = $wrapperDir."/footer.php";
		
		/*
		*	Save the header file
		*/
		
		if(file_put_contents($headerFile, $header)) {
			
			/*
			*	Save the footer file
			*/
			
			if(file_put_contents($footerFile, $footer)) {
				
				die('1');
				
				/*
				*	Couldn't save footer, die with false
				*/
				
			} else {
				
				die('0');
				
			}
			
		/*
		*	Couldn't save header, die with false
		*/
			
		} else {
			
			die('0');
			
		}	
		
	} else {
		
		die('0');
		
	}
	
	
}


// curls the full index page code

function getWrapper($url) {
	
	/*
	*	cUrl the index page of the plog to get the raw html code
	*/
	
	$curl_handle = curl_init();
    curl_setopt( $curl_handle, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
    curl_setopt( $curl_handle, CURLOPT_URL, $url );
    curl_setopt( $curl_handle, CURLOPT_ENCODING, "" );
    curl_setopt( $curl_handle, CURLOPT_AUTOREFERER, true );
	curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $curl_handle, CURLOPT_MAXREDIRS, 10 );
	$wrapper = curl_exec($curl_handle);
	curl_close($curl_handle);
	
	/*
	*	check to see if our idx stop and stop functions are present, if so return
	*	the raw wrapper, if not then return false
	*/
	
	if (checkWrapper($wrapper)) {
		return $wrapper;
	} else {
		return false;
	}
	
}

/*
*	Takes full page code and parses out the header and footer code
*/


function parseWrapper($wrapper, $section) {
	
	if ($section == 'header') {
		
		/*
		*	To parse out the string we have to get around earlier versions of php. First we reverse the
		*	string and look for our reversed start flag.  Then we need to reverse the string back to normal
		*	and cut out the actual flag from the code. Return the header.
		*	
		*/
		
		return substr(strrev(stristr(strrev($wrapper), '>vid/<>";enon :yalpsid"=elyts "tratSxdi"=di vid<')), 0, -48); // 48 char
		
	} else if ($section == 'footer') {
		
		/*
		*	This is the same process as returning the header, except we dont need to reverse the string, as
		*	our flag will be at the beginning of the code block. Return the footer.
		*/
		
		return substr(stristr($wrapper, '<div id="idxStop" style="display: none;"></div>'), 47); //47 char
		
	} else {
		
		/*
		*	If the required header/footer parameter is not provided then just die().
		*/
		
		die();
		
	}
	
}

/*
*	Checks to see if wrapper has required stop and start function in place,
*	if so return true, if not return false
*/ 

function checkWrapper($wrapper) {
	
	/*
	*	Check to see if the start flag is present, if so move on
	*/

	if( stristr($wrapper, idx_start() )) {
		
		/*
		*	Check to see if the stop flag is present, if so return true
		*/
		
		if(stristr($wrapper, idx_stop() )) {
			
			return true;
		
		/*
		*	Stop flag is not present, return false
		*/
		
		} else {
			
			return false;
		
		}
		
	/*
	*	Start flag is not present, return false
	*/
		
	} else {
		
		return false;
	
	}
	
}

/*
*	adminCheckWrapper()
*	This function checks to see if we have succesfully added content to
*	the header.php and footer.php files in the wrapper directory.  Returns
*	1 on success, 0 on no change.
*/

function adminCheckWrapper() {
	
	/*
	*	These is the declaration of the wrapper directory, and the file names
	*	of the header and footer files.
	*/
	
	$wrapperDir = '../wp-content/plugins/idx-broker-wordpress-plugin/wrapper';
	$headerFile = $wrapperDir."/header.php";
	$footerFile = $wrapperDir."/footer.php";
	
	/*
	*	If the file size of the header file is greater than 0.
	*/
	
	if(filesize($headerFile) > 0){
		
		/*
		*	If the file size of the footer file is greater than 0.
		*/
		
		if(filesize($footerFile) > 0){
			
			/*
			*	Both the header and the footer have a filesize that
			*	is greater than 0, die and return TRUE.
			*/
			
			die('1');
			
		} else {
			
			die('0');
			
		}
		
	} else {
		
		die('0');
		
	}
	
}


function errorCheck() {
	
	/*
	*	Grab the options for the WP table
	*/
	
	$cid = get_option('idx_broker_cid');
	$domain = get_option('idx_broker_domain');
	
	/*
	*	We will hold our errors in this array.
	*/
	
	$errors = array();
	
	/*
	*	Check to see if the CID is emtpy, if it's numeric, and if
	*	it's comprized of 4 digits.
	*/
	
	if (empty($cid) || !is_numeric($cid) ||  (strlen($cid) != 4)) {
		
		/*
		*	Add a string to the error array as we have something wrong with the CID.
		*/
		
		$errors[] = "Please check your Client Identification (CID) in the IDX Broker Plugin Settings for errors.";
		
	}
	
	/*
	*	Check to see if the domain is empty
	*/
	
	if (empty($domain)) {
		
		/*
		*	Add a string to the error array as the domain string is empty.
		*/
		
		$errors[] = "Please enter the full domain of IDX hosted pages in the IDX Broker Plugin Settings.";
		
	}
	
	/*
	*	Loop over the errors array.
	*/
	
	foreach ($errors as $error){
		
		$errorOutput .= "<div style='color: red; margin: 10px 0; font-weight: bold'>".$error."</div";
		
	}
	
	/*
	*	Echo anything that is in the errors array out.
	*/
	
	echo $errorOutput;
	
}

function idx_web_services( $getService ) {

	// Require the NuSOAP code
	require_once('nusoap.php');
	
	// Create the client instance
	$host = 'https://idxco.com/services/clientWSDL_1-3.php';
	$client = new nusoap_client($host);
	
	// Check for an error
	$err = $client->getError();
	
	if ($err) {
		
		// Display the error
		echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
		// At this point, you know the call that follows will fail
		
	}
	
	// Call the SOAP method
	$result = $client->call($getService, array('cid' => get_option('idx_broker_cid'),'password' => get_option('idx_broker_pass')));
	
	// Check for a fault
	if ($client->fault) {
		
		echo '<h2>Fault</h2><pre>';
		print_r($result);
		echo '</pre>';
		
	} else {
		
		// Check for errors
		$err = $client->getError();
		
		if ($err) {
			
			// Display the error
			echo '<h2>Error</h2><pre>' . $err . '</pre>';
			
		} else {
			
			return $result;
		
		}
	}
}

/*
*	Following three functions mimic the page_links_to plugin and allow the
*	addition of system and custom links to be added to the main navigation
*	area.
*/

function idx_get_post_meta_by_key( $key ) {
	
	global $wpdb;
	return $wpdb->get_results( $wpdb->prepare( "SELECT post_id, meta_value FROM $wpdb->postmeta WHERE meta_key = %s", $key ) );
	
}

function idx_get_page_links_to_meta () {
	
	global $wpdb, $page_links_to_cache, $blog_id;

	if ( !isset( $page_links_to_cache[$blog_id] ) )
		$links_to = idx_get_post_meta_by_key( '_links_to' );
	else
		return $page_links_to_cache[$blog_id];

	if ( !$links_to ) {
		
		$page_links_to_cache[$blog_id] = false;
		return false;
	
	}

	foreach ( (array) $links_to as $link )
		$page_links_to_cache[$blog_id][$link->post_id] = $link->meta_value;

	return $page_links_to_cache[$blog_id];
	
}

function idx_filter_links_to_pages ($link, $post) {
	
	$page_links_to_cache = idx_get_page_links_to_meta();

	// Really strange, but page_link gives us an ID and post_link gives us a post object
	$id = ( $post->ID ) ? $post->ID : $post;

	if ( $page_links_to_cache[$id] )
		$link = esc_url( $page_links_to_cache[$id] );

	return $link;

}

/*
*	--------- IDX Broker Widgets Section -----------
*/


/*		widget_idxLinks();
 *
 *		Provides a widget to place links to various part of the clients idx system including: Basic Search, Advanced Search, Map Search, Address Search,
 *		Featured Properties, Contact Page, User Login Page, User Signup Page, Email Updates Page, and the Agent Roster Page (multiuser account).
 *		
 */

class widget_idxLinks extends WP_Widget {
	
	/*
	*	Constructor for the widget.
	*/
	
	function widget_idxLinks() {
		
		$widget_ops = array( 'classname' => 'widget_idxLinks', 'description' => __( "IDX System Links" ) );
		$this->WP_Widget('idxLinks', __('IDX System Links'), $widget_ops);
		
	}
	
	/*
	*	Widget Code executed on page
	*/
	
	function widget($args, $instance) {
		
		extract($args);
		
		$domain = get_option('idx_broker_domain');
		
		if (empty($domain)) {
			$domain = $_SERVER['HTTP_HOST'];
		}
		
		echo $before_widget;
		echo $before_title;
		if(!empty($instance['title'])) {
			echo $instance['title'];
		} else {
			echo "System Links";
		}
		echo $after_title;
?>
		<ul>
			<?php if ($instance['basicSearch'] == 'on') { ?><li><a href="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/basicSearch.php">Basic Search</a></li><?php } ?>
			<?php if ($instance['advancedSearch'] == 'on') { ?><li><a href="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/advancedSearch.php">Advanced Search</a></li><?php } ?>
			<?php if ($instance['mapSearch'] == 'on') { ?><li><a href="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/mapSearch.php">Map Search</a></li><?php } ?>
			<?php if ($instance['addressSearch'] == 'on') { ?><li><a href="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/addressSearch.php">Address Search</a></li><?php } ?>
			<?php if ($instance['featured'] == 'on') { ?><li><a href="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/featured.php">Featured Properties</a></li><?php } ?>
			<?php if ($instance['contact'] == 'on') { ?><li><a href="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/contact.php">Contact Us</a></li><?php } ?>
			<?php if ($instance['userLogin'] == 'on') { ?><li><a href="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/userLogin.php">User Login</a></li><?php } ?>
			<?php if ($instance['userSignup'] == 'on') { ?><li><a href="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/userSignup.php">User Signup</a></li><?php } ?>
			<?php if ($instance['emailUpdates'] == 'on') { ?><li><a href="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/userSaveUpdates.php">Email Updates</a></li><?php } ?>
			<?php if ($instance['rosterPage'] == 'on') { ?><li><a href="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/roster.php">Roster Page</a></li><?php } ?>
			<?php if ($instance['listingId'] == 'on') { ?><li><a href="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/listingIDSearch.php">Listing ID Search</a></li><?php } ?>
			<?php if ($instance['openHouses'] == 'on') { ?><li><a href="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/featuredOpenHouses.php">Open Houses</a></li><?php } ?>
			<?php if ($instance['suppListings'] == 'on') { ?><li><a href="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/supplemental.php">Supplemental Listings</a></li><?php } ?>
			<?php if ($instance['soldPend'] == 'on') { ?><li><a href="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/soldPending.php">Sold/Pending Listings</a></li><?php } ?>
			<?php if ($instance['mortCalc'] == 'on') { ?><li><a href="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/mortgage.php">Mortgage Calculator</a></li><?php } ?>
			<?php if ($instance['homeVal'] == 'on') { ?><li><a href="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/homeValue.php">Home Valuation Request</a></li><?php } ?>
			<?php if ($instance['agentLogin'] == 'on') { ?><li><a href="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/login.php">Agent Login</a></li><?php } ?>
			<?php if ($instance['idxSitemap'] == 'on') { ?><li><a href="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/sitemap.php">IDX Sitemap</a></li><?php } ?>
			<?php if ($instance['searchCity'] == 'on') { ?><li><a href="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/searchByCity.php">Search by City</a></li><?php } ?>
		</ul>
		<?php echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		
		return $new_instance;
	
	}
	
	function form($instance) {
		
		errorCheck();
		
		echo '<div id="idxQs-admin-panel">';
		echo '<p>Provides links to various parts of the IDX Broker system.</p>';
		echo '<label for="' . $this->get_field_id("title") .'">IDX Broker System Links Title:</label>';
		echo '<input type="text" ';
		echo 'name="' . $this->get_field_name("title") . '" ';
		echo 'id="' . $this->get_field_id("title") . '" ';
		echo 'value="' . $instance["title"] . '" /><br /><br />';
		
		// basic search
		echo '<input type="checkbox" name="' . $this->get_field_name("basicSearch") . '" id="' . $this->get_field_id("basicSearch") . 'value="on" ';
		if ($instance["basicSearch"] == 'on' ) {echo "checked = 'checked'";}
		echo ' /> Basic Search Link<br />';
		
		// advanced search
		echo '<input type="checkbox" name="' . $this->get_field_name("advancedSearch") . '" id="' . $this->get_field_id("advancedSearch") . 'value="on" ';
		if ($instance["advancedSearch"] == 'on' ) {echo "checked = 'checked'";}
		echo ' /> Advanced Search Link<br />';
		
		// map search
		echo '<input type="checkbox" name="' . $this->get_field_name("mapSearch") . '" id="' . $this->get_field_id("mapSearch") . 'value="on" ';
		if ($instance["mapSearch"] == 'on' ) {echo "checked = 'checked'";}
		echo ' /> Map Search Link<br />';
		
		// address search
		echo '<input type="checkbox" name="' . $this->get_field_name("addressSearch") . '" id="' . $this->get_field_id("addressSearch") . 'value="on" ';
		if ($instance["addressSearch"] == 'on' ) {echo "checked = 'checked'";}
		echo ' /> Address Search Link<br />';
		
		// featured properties
		echo '<input type="checkbox" name="' . $this->get_field_name("featured") . '" id="' . $this->get_field_id("featured") . 'value="on" ';
		if ($instance["featured"] == 'on' ) {echo "checked = 'checked'";}
		echo ' /> Featured Properties Link<br />';
		
		// contact page
		echo '<input type="checkbox" name="' . $this->get_field_name("contact") . '" id="' . $this->get_field_id("contact") . 'value="on" ';
		if ($instance["contact"] == 'on' ) {echo "checked = 'checked'";}
		echo ' /> Contact Page Link<br />';
		
		// user login
		echo '<input type="checkbox" name="' . $this->get_field_name("userLogin") . '" id="' . $this->get_field_id("userLogin") . 'value="on" ';
		if ($instance["userLogin"] == 'on' ) {echo "checked = 'checked'";}
		echo ' /> User Login Link<br />';
		
		// user signup
		echo '<input type="checkbox" name="' . $this->get_field_name("userSignup") . '" id="' . $this->get_field_id("userSignup") . 'value="on" ';
		if ($instance["userSignup"] == 'on' ) {echo "checked = 'checked'";}
		echo ' /> User Signup Link<br />';
		
		// email updates
		echo '<input type="checkbox" name="' . $this->get_field_name("emailUpdates") . '" id="' . $this->get_field_id("emailUpdates") . 'value="on" ';
		if ($instance["emailUpdates"] == 'on' ) {echo "checked = 'checked'";}
		echo ' /> Email Updates Link<br />';
		
		// roster page
		echo '<input type="checkbox" name="' . $this->get_field_name("rosterPage") . '" id="' . $this->get_field_id("rosterPage") . 'value="on" ';
		if ($instance["rosterPage"] == 'on' ) {echo "checked = 'checked'";}
		echo ' /> Roster Page Link<br />';
		
		// listing id
		echo '<input type="checkbox" name="' . $this->get_field_name("listingId") . '" id="' . $this->get_field_id("listingId") . 'value="on" ';
		if ($instance["listingId"] == 'on' ) {echo "checked = 'checked'";}
		echo ' /> Listing ID Link<br />';
		
		// open houses
		echo '<input type="checkbox" name="' . $this->get_field_name("openHouses") . '" id="' . $this->get_field_id("openHouses") . 'value="on" ';
		if ($instance["openHouses"] == 'on' ) {echo "checked = 'checked'";}
		echo ' /> Open Houses Link<br />';
		
		// supplemental listings
		echo '<input type="checkbox" name="' . $this->get_field_name("suppListings") . '" id="' . $this->get_field_id("suppListings") . 'value="on" ';
		if ($instance["suppListings"] == 'on' ) {echo "checked = 'checked'";}
		echo ' /> Supplemental Listings Link<br />';
		
		// sold/pending 
		echo '<input type="checkbox" name="' . $this->get_field_name("soldPend") . '" id="' . $this->get_field_id("soldPend") . 'value="on" ';
		if ($instance["soldPend"] == 'on' ) {echo "checked = 'checked'";}
		echo ' /> Sold/Pending Link<br />';
		
		// mortgage calculator
		echo '<input type="checkbox" name="' . $this->get_field_name("mortCalc") . '" id="' . $this->get_field_id("mortCalc") . 'value="on" ';
		if ($instance["mortCalc"] == 'on' ) {echo "checked = 'checked'";}
		echo ' /> Mortgage Calculator Link<br />';
		
		// home valuation
		echo '<input type="checkbox" name="' . $this->get_field_name("homeVal") . '" id="' . $this->get_field_id("homeVal") . 'value="on" ';
		if ($instance["homeVal"] == 'on' ) {echo "checked = 'checked'";}
		echo ' /> Home Valuation Request Link<br />';
		
		// agent login
		echo '<input type="checkbox" name="' . $this->get_field_name("agentLogin") . '" id="' . $this->get_field_id("agentLogin") . 'value="on" ';
		if ($instance["agentLogin"] == 'on' ) {echo "checked = 'checked'";}
		echo ' /> Agent Login Link<br />';
		
		// idx sitemap
		echo '<input type="checkbox" name="' . $this->get_field_name("idxSitemap") . '" id="' . $this->get_field_id("idxSitemap") . 'value="on" ';
		if ($instance["idxSitemap"] == 'on' ) {echo "checked = 'checked'";}
		echo ' /> IDX Sitemap Link<br />';
		
		// search by city
		echo '<input type="checkbox" name="' . $this->get_field_name("searchCity") . '" id="' . $this->get_field_id("searchCity") . 'value="on" ';
		if ($instance["searchCity"] == 'on' ) {echo "checked = 'checked'";}
		echo ' /> Search by City Link<br />';
		
		echo '</div>';
	}
}


/*		widget_idxSlideshow();
 *
 *		Provides a widget to place a rotating slideshow of properites.  This slideshow is controlled by logging into the IDX Admin (http://www.idxco.com/mgmt/)
 *		under Widgets -> Slidewhow Settings
 *		
 */

class widget_idxSlideshow extends WP_Widget {
	
	/*
	*	Constructor for the widget.
	*/
	
	function widget_idxSlideshow() {
		
		$widget_ops = array( 'classname' => 'widget_idxSlideshow', 'description' => __( "IDX Property Slideshow" ) );
		$this->WP_Widget('idxSlideshow', __('IDX Property Slideshow'), $widget_ops);
		
	}
	
	/*
	*	Widget Code executed on page
	*/
	
	function widget($args, $instance) {
		
		extract($args);
		
		$domain = get_option('idx_broker_domain');
		
		echo $before_widget;
		echo $before_title;
		
		if(!empty($instance['title'])) {
			
			echo $instance['title'];
			
		} else {
			
			echo "Property Slideshow";
			
		}
		echo $after_title;
?>
		<script type="text/javascript" src="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/slideshowJS.php"></script>
<?php 	echo $after_widget;

	}
	
	function update($new_instance, $old_instance) {
		
		return $new_instance;
	
	}
	
	function form($instance) {
		
		errorCheck();
		
		echo '<div id="idxSlideshow-admin-panel">';
		echo '<p>Provides a slideshow of properties.  Please log in to your IDX Broker Admin to access slideshow settings under Widgets -> Slideshow Settings.</p>';
		echo '<label for="' . $this->get_field_id("title") .'">Slideshow Title:</label>';
		echo '<input type="text" ';
		echo 'name="' . $this->get_field_name("title") . '" ';
		echo 'id="' . $this->get_field_id("title") . '" ';
		echo 'value="' . $instance["title"] . '" /><br /><br />';
		echo '</div>';
		
	}
}

/*		widget_idxQs();
 *
 *		Provides a widget to place a property Quick Search Form in two customizable formats, narrow and wide.
 *		
 */

class widget_idxQs extends WP_Widget {
	
	/*
	*	Constructor for the widget.
	*/
	
	function widget_idxQs() {
		
		$widget_ops = array( 'classname' => 'widget_idxQs', 'description' => __( "IDX Quick Search" ) );
		$this->WP_Widget('idxQs', __('IDX Quick Search'), $widget_ops);
		
	}
	
	/*
	*	Widget Code executed on page
	*/
	
	function widget($args, $instance) {
		
		extract($args);
		
		$domain = get_option('idx_broker_domain');
		
		echo $before_widget;
		echo $before_title;
		
		if(!empty($instance['title'])) {
			
			echo $instance['title'];
			
		} else {
			
			echo "Property Search";
			
		}
		echo $after_title;
		
		if ($instance['format'] == 'wide') {
			
?>
		<div style="margin: 0 auto; width: 210px;">
			<script type="text/javascript" src="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/customSearchJS.php?QS-minPriceField=92|34|22|100|0|0|100000|0&QS-maxPriceField=92|64|22|100|0|0|500000|0&QS-minSqftField=92|94|22|100|0|0|0|0&QS-minRoomsField=92|124|22|100|0|0|2|0&QS-minBathsField=92|154|22|100|0|0|0|0&QS-labelMaxPrice=12|67|22|70|0|0|Max Price:|0&QS-labelMinPrice=12|37|22|70|0|0|Min Price:|0&QS-labelMinSqft=12|97|22|70|0|0|Min SQFT:|0&QS-labelMinRooms=12|127|22|70|0|0|Min Rooms:|0&QS-labelMinBaths=12|157|22|70|0|0|Min Baths:|0&QS-buttonSearch=70|217|27|70|0|0|Search|0&QS-labelFormTitle=42|11|22|150|0|0|Property Quick Search|0&QS-selectCityList=92|184|22|105|0|0|Property Quick Search|0&QS-labelCityList=12|187|22|100|0|0|Choose a City|0&formContainer=210|250&domain=&cid=4587"></script>
<?php
		} else if($instance['format'] == 'widest') {
?>
			<script type="text/javascript" src="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/customSearchJS.php?QS-minPriceField=105|6|22|100|0|0|200000|0&QS-maxPriceField=105|37|22|100|0|0|800000|0&QS-minSqftField=358|6|22|100|0|0|0|0&QS-minRoomsField=358|37|22|100|0|0|1|0&QS-minBathsField=105|65|22|100|0|0|0|0&QS-labelMaxPrice=25|39|22|70|0|0|Max Price:|0&QS-labelMinPrice=25|8|22|70|0|0|Min Price:|0&QS-labelMinSqft=278|8|22|70|0|0|Min SQFT:|0&QS-labelMinRooms=278|39|22|70|0|0|Min Rooms:|0&QS-labelMinBaths=25|70|22|70|0|0|Min Baths:|0&QS-buttonSearch=209|94|27|70|0|0|Search|0&QS-selectCityList=358|65|22|105|0|0|Search|0&QS-labelCityList=278|70|22|100|0|0|Choose a City|0&formContainer=490|130&domain=&cid=4587"></script>
<?php
		} else {
?>
		<div style="margin: 0 auto; width: 130px;">
			<script type="text/javascript" src="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/customSearchJS.php?QS-minPriceField=12|54|22|100|0|0|200000|0&QS-maxPriceField=12|104|22|100|0|0|800000|0&QS-minSqftField=12|154|22|100|0|0|0|0&QS-minRoomsField=12|204|22|100|0|0|1|0&QS-minBathsField=12|254|22|100|0|0|0|0&QS-labelMaxPrice=12|84|22|70|0|0|Max Price:|0&QS-labelMinPrice=12|34|22|70|0|0|Min Price:|0&QS-labelMinSqft=12|134|22|70|0|0|Min SQFT:|0&QS-labelMinRooms=12|184|22|70|0|0|Min Rooms:|0&QS-labelMinBaths=12|234|22|70|0|0|Min Baths:|0&QS-buttonSearch=28|334|27|70|0|0|Search|0&QS-labelFormTitle=23|11|22|80|0|0|Quick Search|0&QS-selectCityList=12|304|22|105|0|0|Quick Search|0&QS-labelCityList=12|284|22|100|0|0|Choose a City|0&formContainer=130|370&domain=&cid=4538"></script>
<?php
		}
?>
		</div>
<?php
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		
		return $new_instance;
	
	}
	
	function form($instance) {
		
		errorCheck();
		
		echo '<div id="idxQs-admin-panel">';
		echo '<p>Provides a IDX Broker Quick Search Form.</p>';
		echo '<label for="' . $this->get_field_id("title") .'">Quick Search Title:</label>';
		echo '<input type="text" ';
		echo 'name="' . $this->get_field_name("title") . '" ';
		echo 'id="' . $this->get_field_id("title") . '" ';
		echo 'value="' . $instance["title"] . '" /><br /><br />';
		
		if ($instance["format"] == 'narrow') {
			
			$narrow = "selected='selected'";
			
		} else if($instance["format"] == 'wide') {
			
			$wide = "selected='selected'";
			
		} else {
			
			$widest = "selected='selected'";
			
		}
		
		echo '<select name="' . $this->get_field_name("format") . '" id="' . $this->get_field_id("format") . '">';
		echo '<option value="narrow" '.$narrow.'>Narrow</option>';
		echo '<option value="wide" '.$wide.'>Wide</option>';
		echo '<option value="widest" '.$widest.'>Widest</option>';
		echo '</select>';
		echo '</div>';
		
	}
}

/*		widget_idxFeatAgent();
 *
 *		Provides a widget to place a featured agent section.  Most useful in a IDX Broker multiuser account.
 *		
 */

class widget_idxFeatAgent extends WP_Widget {
	
	/*
	*	Constructor for the widget.
	*/
	
	function widget_idxFeatAgent() {
		
		$widget_ops = array( 'classname' => 'widget_idxFeatAgent', 'description' => __( "IDX Featured Agent" ) );
		$this->WP_Widget('idxFeatAgent', __('IDX Featured Agent'), $widget_ops);
		
	}
	
	/*
	*	Widget Code executed on page
	*/
	
	function widget($args, $instance) {
		
		extract($args);
		
		$domain = get_option('idx_broker_domain');
		
		echo $before_widget;
		echo $before_title;
		
		if(!empty($instance['title'])) {
			
			echo $instance['title'];
			
		} else {
			
			echo "Featured Agent";
			
		}
		
		echo $after_title;
?>
			<script type="text/javascript" src="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/agentShowcaseJS.php"></script>
<?php
		echo $after_widget;
		
	}
	
	function update($new_instance, $old_instance) {
		
		return $new_instance;
	
	}
	
	function form($instance) {
		
		errorCheck();

		echo '<div id="idxFeatAgent-admin-panel">';
		echo '<p>The Featured Agent Widget displays a random person from the Roster when the page loads.</p>';
		echo '<label for="' . $this->get_field_id("title") .'">Featured Agent Title:</label>';
		echo '<input type="text" ';
		echo 'name="' . $this->get_field_name("title") . '" ';
		echo 'id="' . $this->get_field_id("title") . '" ';
		echo 'value="' . $instance["title"] . '" /><br /><br />';
		echo '</div>';
		
	}
}

/*		widget_idxWildcardSearch();
 *
 *		Provides a widget to place a wildcard search form.
 *		
 */

class widget_idxWildcardSearch extends WP_Widget {
	
	/*
	*	Constructor for the widget.
	*/
	
	function widget_idxWildcardSearch() {
		
		$widget_ops = array( 'classname' => 'widget_idxWildcardSearch', 'description' => __( "IDX Wildcard Search" ) );
		$this->WP_Widget('widget_idxWildcardSearch', __('IDX Wildcard Search'), $widget_ops);
		
	}
	
	/*
	*	Widget Code executed on page
	*/
	
	function widget($args, $instance) {
		
		extract($args);
		
		$domain = get_option('idx_broker_domain');
		
		echo $before_widget;
		echo $before_title;
		
		if(!empty($instance['title'])) {
			
			echo $instance['title'];
			
		} else {
			
			echo "Wildcard Search";
			
		}
		
		echo $after_title;
?>
		<form action="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/results.php" method="post"><input type="text" size="<?php echo $instance["length"]; ?>" name="wildSearch" id="IDX-wildSearchForm" /><input type="submit" name="submit" value="Search" /></form>
<?php
		echo $after_widget;
		
	}
	function update($new_instance, $old_instance) {
		
		return $new_instance;
	
	}
	
	function form($instance) {
		
		errorCheck();

		echo '<div id="idxWildcardSearch-admin-panel">';
		echo '<p>The Wildcard Search Widget displays a wildcard search form.</p>';
		echo '<label for="' . $this->get_field_id("title") .'">Wildcard Search Title:</label>';
		echo '<input type="text" ';
		echo 'name="' . $this->get_field_name("title") . '" ';
		echo 'id="' . $this->get_field_id("title") . '" ';
		echo 'value="' . $instance["title"] . '" /><br /><br />';
		echo '<label for="' . $this->get_field_id("length") .'">Wildcard Search Character Length:</label>';
		echo '<input type="text" ';
		echo 'name="' . $this->get_field_name("length") . '" ';
		echo 'id="' . $this->get_field_id("length") . '" ';
		echo 'value="' . $instance["length"] . '" /><br /><br />';
		echo '</div>';
		
	}
}

/*		widget_myAgentBadge();
 *
 *		Provides a widget to place a myAgent iphone app badge with embedded agent code.
 *		
 */

class widget_myAgentBadge extends WP_Widget {
		
	/*
	*	Constructor for the widget.
	*/
	
	function widget_myAgentBadge() {
		
		$widget_ops = array( 'classname' => 'widget_myAgentBadge', 'description' => __( "IDX myAgent Badge" ) );
		$this->WP_Widget('myAgentBadge', __('IDX myAgent Badge'), $widget_ops);
		
	}
	
	/*
	*	Widget Code executed on page
	*/
	
	function widget($args, $instance) {
		
		extract($args);
		
		$cid = get_option('idx_broker_cid');
		
		if ($instance["type"] == 'vert') {
			
			$height = "55";
			$padding = "145px 5px 0px 0px;";
			$width = "195";
			
		} else if($instance["type"] == 'horz') {
			
			$height = "23";
			$padding = "57px 0px 0px 40px;";
			$width = "160";
			
		}
		
		echo $before_widget;
		echo $before_title;
		
		if(!empty($instance['title'])) {
			
			echo $instance['title'];
			
		} else {
			
			echo "Property Search";
			
		}
		
		echo $after_title;
		
?>
		<a id="IDX-myAgentBanner" alt="iPhone Enabled. Download my app and enter this code: <?php echo $cid; ?>" href="http://itunes.apple.com/WebObjects/MZStore.woa/wa/viewSoftware?id=336858030&mt=8&s=143441" style="display:block; text-align:center; color: #FFF; font-family:Arial; font-size:14px; font-weight: bold; border:0px; background-image:url('http://www.idxco.com/images/layout/badges/iphone/myAgent_<?php echo $instance['type']; ?>_<?php echo $instance['color']; ?>.png'); width: <?php echo $width; ?>px; height: <?php echo $height; ?>px; padding:<?php echo $padding; ?>; margin: 0 auto;"><?php echo $cid; ?></a>
<?php
		echo $after_widget;
		
	}
	
	function update($new_instance, $old_instance) {
		
		return $new_instance;
	
	}
	
	function form($instance) {
		
		errorCheck();
		
		echo '<div id="myAgentBadge-admin-panel">';
		echo '<p>Provides a badge link to your myAgent iPhone app with your embedded agent code.</p>';
		echo '<label for="' . $this->get_field_id("title") .'">myAgent Badge Title:</label>';
		echo '<input type="text" ';
		echo 'name="' . $this->get_field_name("title") . '" ';
		echo 'id="' . $this->get_field_id("title") . '" ';
		echo 'value="' . $instance["title"] . '" /><br /><br />';
		
		if ($instance["type"] == 'vert') {
			
			$vert = "selected='selected'";
			
		} else if($instance["type"] == 'horz') {
			
			$horz = "selected='selected'";
			
		}
		
		switch ($instance["color"]) {
			
			case 'red':
				
				$red = "selected='selected'";
				break;
			
			case 'orange':
				
				$orange = "selected='selected'";
				break;
			
			case 'green':
				
				$green = "selected='selected'";
				break;
			
			case 'ltblue':
				
				$ltblue = "selected='selected'";
				break;
			
			case 'blue':
				
				$blue = "selected='selected'";
				break;
			
			case 'purple':
				
				$purple = "selected='selected'";
				break;
			
			case 'black':
				
				$black = "selected='selected'";
				break;
			
		}
		
		echo '<select name="' . $this->get_field_name("type") . '" id="' . $this->get_field_id("type") . '">';
		echo '<option value="horz" '.$horz.'>Horizontal</option>';
		echo '<option value="vert" '.$vert.'>Vertical</option>';
		echo '</select>';
		
		echo '<select name="' . $this->get_field_name("color") . '" id="' . $this->get_field_id("color") . '">';
		echo '<option value="red" '.$red.'>Red</option>';
		echo '<option value="orange" '.$orange.'>Orange</option>';
		echo '<option value="green" '.$green.'>Green</option>';
		echo '<option value="ltblue" '.$ltblue.'>Light Blue</option>';
		echo '<option value="blue" '.$blue.'>Blue</option>';
		echo '<option value="purple" '.$purple.'>Purple</option>';
		echo '<option value="black" '.$black.'>Black</option>';
		echo '</select>';
		echo '</div>';
		
	}
}

/*		widget_idxLeadLogin();
 *
 *		Provides a widget for client leads to login to their listings manager account.
 *		
 */

class widget_idxLeadLogin extends WP_Widget {
	
	/*
	*	Constructor for the widget.
	*/
	
	function widget_idxLeadLogin() {
		
		$widget_ops = array( 'classname' => 'widget_idxLeadLogin', 'description' => __( "IDX Lead Login" ) );
		$this->WP_Widget('idxLeadLogin', __('IDX Lead Login'), $widget_ops);
		
	}
	
	/*
	*	Widget Code executed on page
	*/
	
	function widget($args, $instance) {
		
		extract($args);
	
		echo $before_widget;
		echo $before_title;
		
		if(!empty($instance['title'])) {
			
			echo $instance['title'];
			
		} else {
			
			echo "My Listings Manager Login";
			
		}
		
		echo $after_title;
?>
		<div id="IDX-userLogin">
			<form action="http://<?php echo get_option('idx_broker_domain'); ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/userLogin.php" method="post">
				<label for="leadEmail" class="IDX-loginLabel">Email Address:</label>
				<input type="text" name="leadEmail" size="<? echo $instance['inputSize']; ?>" maxlength="255" id="IDX-userLoginEmail" style="float: right;" />
				<div style="clear: both;"></div>
				<div id="IDX-userPassword">
					<label for="password" class="IDX-loginLabel">Password:</label>
					<input type="password" name="password" size="<? echo $instance['inputSize']; ?>" maxlength="32" id="IDX-userLoginPassword" style="float: right;" />
					<div style="clear: both;"></div>
				</div>
				<div style="clear: both;"></div>
				<a href="http://<?php echo get_option('idx_broker_domain'); ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/forgotPass.php" style="float: left; margin-top: 5px;">Forgot your Password?</a>
				<input type="submit" name="submit" id="IDX-userLoginSubmit" value="Log In" id="IDX-userLoginSubmit" style="float: right;" />
				<div style="clear: both;"></div>
			</form>
		</div>
<?php
		echo $after_widget;
		
	}
	
	function update($new_instance, $old_instance) {
		
		return $new_instance;
	
	}
	
	function form($instance) {
		
		errorCheck();
		
		echo '<div id="idxLeadLogin-admin-panel">';
		echo '<p>Provides a form for your leads to login to their listings manager account.</p>';
		echo '<label for="' . $this->get_field_id("title") .'">Lead Login Title:</label>';
		echo '<input type="text" ';
		echo 'name="' . $this->get_field_name("title") . '" ';
		echo 'id="' . $this->get_field_id("title") . '" ';
		echo 'value="' . $instance["title"] . '" /><br /><br />';
		echo '<label for="' . $this->get_field_id("inputSize") .'">Form input character size:</label>';
		echo '<input type="text" ';
		echo 'name="' . $this->get_field_name("inputSize") . '" ';
		echo 'id="' . $this->get_field_id("inputSize") . '" ';
		echo 'value="' . $instance["inputSize"] . '" /><br /><br />';
		echo '</div>';
		
	}
}

/*		widget_idxLeadLogin();
 *
 *		Provides a widget for client leads to login to their listings manager account.
 *		
 */

class widget_idxCustomLinks extends WP_Widget {
	
	function widget_idxCustomLinks() {
		
		$widget_ops = array( 'classname' => 'widget_idxCustomLinks', 'description' => __( "IDX Custom Links" ) );
		$this->WP_Widget('idxCustomLinks', __('IDX Custom Links'), $widget_ops);
		
	}
	
	function widget($args, $instance) {
		
		extract($args);
	
		echo $before_widget;
		echo $before_title;
		
		if(!empty($instance['title'])) {
			
			echo $instance['title'];
			
		} else {
			
			echo "Property Links";
			
		}
		
		echo $after_title;
		
		$savedSearches = idx_web_services( 'listSavedSearches' );
		$lines = explode("\n",$savedSearches);

?>
		<ul id="id">
<?php
        //print_r($lines);
        foreach ($lines as $link) {
			
            $li = explode("|", $link);
			if($li[1] != '')
            echo '<li><a href="' . $li[1] . '">' . str_replace('_', ' ', $li[0]) . '</a></li>';
			
        }

?>
		</ul>
<?php

		echo $after_widget;
		
	}
	
	function update($new_instance, $old_instance) {
		
		return $new_instance;
	
	}
	
	function form($instance) {
		
		errorCheck();
		
		echo '<div id="idxLeadLogin-admin-panel">';
		echo '<p>Provides a list of your custom built links.</p>';
		echo '<label for="' . $this->get_field_id("title") .'">Custom Links Title:</label>';
		echo '<input type="text" ';
		echo 'name="' . $this->get_field_name("title") . '" ';
		echo 'id="' . $this->get_field_id("title") . '" ';
		echo 'value="' . $instance["title"] . '" /><br /><br />';
		echo '</div>';
		
	}
}

/*
*	Add all actions to the WP system that are IDX Broker Widgets
*/

add_action('widgets_init', create_function('', 'return register_widget("widget_idxLinks");'));
add_action('widgets_init', create_function('', 'return register_widget("widget_idxSlideshow");'));
add_action('widgets_init', create_function('', 'return register_widget("widget_idxQs");'));
add_action('widgets_init', create_function('', 'return register_widget("widget_idxFeatAgent");'));
add_action('widgets_init', create_function('', 'return register_widget("widget_idxWildcardSearch");'));
add_action('widgets_init', create_function('', 'return register_widget("widget_myAgentBadge");'));
add_action('widgets_init', create_function('', 'return register_widget("widget_idxLeadLogin");'));
add_action('widgets_init', create_function('', 'return register_widget("widget_idxCustomLinks");'));

/*
*	Add all ajax actions to the WP system.
*/

add_action('wp_ajax_idxUpdateLinks', 'idxUpdateLinks' );
add_action('wp_ajax_idxUpdateCustomLinks', 'idxUpdateCustomLinks' );
add_action('wp_ajax_idx_clearCustomLinks', 'idx_clearCustomLinks' );
add_action('wp_ajax_idxUpdateWrapper', 'idxUpdateWrapper' );
add_action('wp_ajax_adminCheckWrapper', 'adminCheckWrapper' );

/*
*	Add all filters to the WP system.
*/

add_filter( 'page_link', 'idx_filter_links_to_pages', 20, 2 );

?>
