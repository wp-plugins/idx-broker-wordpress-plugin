<?php
/*
Plugin Name: IDX Broker
Plugin URI: http://www.idxbroker.com/wordpress/
Description: The IDX Broker plugin gives Realtors&trade; an easier way to add IDX Broker Widgets, Menu links, and Custom Links to any Wordpress blog. 
Version: 1.3.1
Author: IDX, Inc.
Author URI: http://www.idxbroker.com
License: GPL
*/

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

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
	register_setting( 'idx-settings-group', "idx_broker_advancedSearchLink" );
	register_setting( 'idx-settings-group', "idx_broker_mapSearchLink" );
	register_setting( 'idx-settings-group', "idx_broker_addressSearchLink" );
	register_setting( 'idx-settings-group', "idx_broker_listingSearchLink" );
	register_setting( 'idx-settings-group', "idx_broker_featuredLink" );
	register_setting( 'idx-settings-group', "idx_broker_soldPendLink" );
	register_setting( 'idx-settings-group', "idx_broker_openHousesLink" );
	register_setting( 'idx-settings-group', "idx_broker_contactLink" );
	register_setting( 'idx-settings-group', "idx_broker_rosterLink" );
	register_setting( 'idx-settings-group', "idx_broker_listManLink" );
	register_setting( 'idx-settings-group', "idx_broker_homeValLink" );

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
	
	if (count($customLinks) > 0){
	
		foreach($customLinks as $link) {
			
			$tempName = 'idx_custom_'.$link[0];
			register_setting( 'idx-settings-group', "$tempName" );
			
		}
		
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

<style type="text/css">

#idxPluginWrap {
	font-family: Verdana, Helvetica, sans-serif;
	width: 900px;
}
#idxPluginWrap h2, #idxPluginWrap h3 {
	font-family: Arial, Helvetica, sans-serif;
}
#idxPluginWrap h3 {
	border-bottom: 1px solid #ccc;
}
#logo {
	background-image: url(../wp-content/plugins/idx-broker-wordpress-plugin/images/logoSmEmail.png);
	background-repeat: no-repeat;
	background-position: bottom;
	width: 100px;
	height: 58px;
	float: right;
}
.helpIcon{
	background-image: url(../wp-content/plugins/idx-broker-wordpress-plugin/images/helpIcon.png);
	width: 20px;
	height: 20px;
	display:inline-block;
}
.ajax{
	background-image: url(../wp-content/plugins/idx-broker-wordpress-plugin/images/ajax-loader.gif);
	width: 15px;
	height: 15px;
	display:inline-block;
}
#gen_settings li {
	height: 25px;
}
#gen_settings li input {
	float: right;
}
.link_header {
	font-weight:bold;
	margin-bottom: 5px;
}
.link_list li {
	float: left;
	height: 20px;
	width: 225px;
}
.link_label {
	padding-left: 2px;
}
.status {
	float: left;
	color:#21759B;
	font-weight: bold;
	margin-top: 15px;
}
#saveChanges {
	float: right;
	margin-top: 15px;
}
.save_footer{
	border-top: 1px solid #ccc;
}
.clear {
	clear: both;
}
</style>

<div id="idxPluginWrap" class="wrap">
	<br class="clear" />
	<div id="logo"></div>
	<h2 style="float: left;">IDX Broker Plugin Options</h2>
	<br class="clear" />
	<h3>General Settings<a href="http://www.idxbroker.com/support/kb/questions/285/" class="helpIcon" target="_blank"></a></h3>
	
	<form method="post" action="options.php" id="idxOptions">
		<div id="blogUrl" style="display: none;" ajax="<?php bloginfo('wpurl'); ?>"></div>
		<ul id="gen_settings">
			<li>
				<label for="idx_broker_cid">Customer Identification Number (CID): </label>
				<input name="idx_broker_cid" type="text" id="idx_broker_cid" value="<?php echo get_option('idx_broker_cid'); ?>" />
			</li>
			<li>
				<label for="idx_broker_pass">Your IDX Broker Password:</label>
				<input name="idx_broker_pass" type="password" id="idx_broker_pass" value="<?php echo get_option('idx_broker_pass'); ?>" />
			</li>
			<li>
				<label for="idx_broker_domain">Your Website Domain (subdomain.domain.com):</label>
				<input name="idx_broker_domain" type="text" id="idx_broker_domain" size="30" value="<?php echo get_option('idx_broker_domain'); ?>" />
			</li>
		</ul>
	
		<h3>Sidebar Widgets<a href="http://www.idxbroker.com/support/kb/questions/313/" class="helpIcon" target="_blank"></a></h3>
		
		<p><a href="widgets.php">Click here</a> to visit the Widgets page and add IDX Broker widgets to your sidebar(s).</p>
	
		
		<h3>Navigation Links<a href="http://www.idxbroker.com/support/kb/questions/314/" class="helpIcon" target="_blank"></a></h3>
		
		<p>Many Realtors&reg; add 2-3 navigation links to their site or blog, although you may choose to add more. The most common links are to the Basic Search, Map Search, and the Featured Properties Pages.</p>
		<p>Use the boxes below to Add or Remove MLS/IDX pages from your navigation. Each page will maintain the look and feel of your blog or site. Once you have decided upon the pages that you want in your navigation, click the "Save Changes" button. To customize your IDX page link titles, or to manage the menu order of your new IDX pages, simply visit <a href="edit.php?post_type=page">Pages</a>.</p>
		
		<div class="link_header" style="float: left;">Add/Remove Core Page Links</div>
		
		<ul class="link_list">
			<div style="float: right; font-weight: bold;">
				<input type="checkbox" name="idx_ml_group" id="idx_ml_group" />
				<label for="idx_ml_group" class="link_label">Select/Deselect All</label>	
			</div>
			<br class="clear" />
			<li>
				<input type="checkbox" name="idx_broker_basicSearchLink" id="idx_broker_basicSearchLink" <?=(get_option('idx_broker_basicSearchLink')=='on')?'checked="checked"':'';?> class="idx_broker_basicSearchLink idx_ml" />
				<label for="idx_broker_basicSearchLink" class="link_label">- Basic Search</label>
			</li>
			<li>
				<input type="checkbox" name="idx_broker_advancedSearchLink" id="idx_broker_advancedSearchLink" <?=(get_option('idx_broker_advancedSearchLink')=='on')?'checked="checked"':'';?> class="idx_broker_advancedSearchLink idx_ml" />
				<label for="idx_broker_advancedSearchLink" class="link_label">- Advanced Search</label>
			</li>
			<li>
				<input type="checkbox" name="idx_broker_mapSearchLink" id="idx_broker_mapSearchLink" <?=(get_option('idx_broker_mapSearchLink') == 'on')?'checked="checked"':'';?> class="idx_broker_mapSearchLink idx_ml" />
				<label for="idx_broker_mapSearchLink" class="link_label">- Map Search</label>
			</li>
			<li>
				<input type="checkbox" name="idx_broker_addressSearchLink" id="idx_broker_addressSearchLink" <?=(get_option('idx_broker_addressSearchLink') == 'on')?'checked="checked"':'';?> class="idx_broker_addressSearchLink idx_ml" />
				<label for="idx_broker_addressSearchLink" class="link_label">- Address Search</label>
			</li>
			<li>
				<input type="checkbox" name="idx_broker_listingSearchLink" id="idx_broker_listingSearchLink" <?=(get_option('idx_broker_listingSearchLink') == 'on')?'checked="checked"':'';?> class="idx_broker_listingSearchLink idx_ml" />
				<label for="idx_broker_listingSearchLink" class="link_label">- Listing Search</label>
			</li>
			<li>
				<input type="checkbox" name="idx_broker_featuredLink" id="idx_broker_featuredLink" <?=(get_option('idx_broker_featuredLink') == 'on')?'checked="checked"':'';?> class="idx_broker_featuredLink idx_ml" />
				<label for="idx_broker_featuredLink" class="link_label">- Featured Properties</label>
			</li>
			<li>
				<input type="checkbox" name="idx_broker_soldPendLink" id="idx_broker_soldPendLink" <?=(get_option('idx_broker_soldPendLink') == 'on')?'checked="checked"':'';?> class="idx_broker_soldPendLink idx_ml" />
				<label for="idx_broker_soldPendLink" class="link_label">- Sold/Pending Properties</label>
			</li>
			<li>
				<input type="checkbox" name="idx_broker_openHousesLink" id="idx_broker_openHousesLink" <?=(get_option('idx_broker_openHousesLink') == 'on')?'checked="checked"':'';?> class="idx_broker_openHousesLink idx_ml" />
				<label for="idx_broker_openHousesLink" class="link_label">- Open Houses</label>
			</li>
			<li>
				<input type="checkbox" name="idx_broker_contactLink" id="idx_broker_contactLink" <?=(get_option('idx_broker_contactLink') == 'on')?'checked="checked"':'';?> class="idx_broker_contactLink idx_ml" />
				<label for="idx_broker_contactLink" class="link_label">- Contact Page</label>
			</li>
			<li>
				<input type="checkbox" name="idx_broker_rosterLink" id="idx_broker_rosterLink" <?=(get_option('idx_broker_rosterLink') == 'on')?'checked="checked"':'';?> class="idx_broker_rosterLink idx_ml" />
				<label for="idx_broker_rosterLink" class="link_label">- Roster Page (multi only)</label>
			</li>
			<li>
				<input type="checkbox" name="idx_broker_listManLink" id="idx_broker_listManLink" <?=(get_option('idx_broker_listManLink') == 'on')?'checked="checked"':'';?> class="idx_broker_listManLink idx_ml" />
				<label for="idx_broker_listManLink" class="link_label">- Listing Manager</label>
			</li>
			<li>
				<input type="checkbox" name="idx_broker_homeValLink" id="idx_broker_homeValLink" <?=(get_option('idx_broker_homeValLink') == 'on')?'checked="checked"':'';?> class="idx_broker_homeValLink idx_ml" />
				<label for="idx_broker_homeValLink" class="link_label">- Home Valuation</label>
			</li>
		</ul>
		<br class="clear" />

		<div class="link_header" style="float: left;">Custom Links</div>
		<ul class="link_list">
			<div style="float: right; font-weight: bold;">
				<input type="checkbox" name="idx_cl_group" id="idx_cl_group" />
				<label for="idx_cl_group" class="link_label">Select/Deselect All</label>	
			</div>
			<br class="clear" />

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
					<li>
						<input type="checkbox" name="idx_custom_<? echo $link[0]; ?>" id="idx_custom_<? echo $link[0]; ?>" <? echo $checkOption; ?> class="customLink idx_cl" url="<? echo $link[1]; ?>" />
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
					<span style="font-weight:bold">You have no custom links created.</span> Log into the <a href="http://www.idxco.com/mgmt" target="_blank">IDX Broker Admin</a> to create custom links.
				</div>
<?php
			}
?>
		</ul>
		<br class="clear" />
		<div class="save_footer">
			<span class="status"></span>
			<input type="submit" value="<?php _e('Save Changes') ?>" id="saveChanges" ajax="<?php bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php" />
			<br class="clear" />
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
	
	$links = array( 'basic' => $_GET['basicLink'],'advanced' => $_GET['advancedLink'], 'map' => $_GET['mapLink'], 'address' => $_GET['addressLink'], 'listing' => $_GET['listingLink'], 'featured' => $_GET['featuredLink'], 'soldPend' => $_GET['soldPendLink'], 'openHouse' => $_GET['openHouseLink'], 'contact' => $_GET['contactLink'], 'roster' => $_GET['rosterLink'], 'listingManager' => $_GET['listManLink'], 'homeValuation' => $_GET['homeValLink'] );

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
					$label = "Basic Search";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/basicSearch.php";
					break;
				
				/*
				*	Advanced Search Link
				*/
				
				case "advanced":
					
					$label = "Advanced Search";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/advancedSearch.php";
					break;
				
				/*
				*	Map Search Link
				*/
				
				case "map":
					
					$label = "Map Search";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/mapSearch.php";
					break;
				
				/*
				* 	Address Search Link
				*/
				
				case "address":
					
					$label = "Address Search";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/addressSearch.php";
					break;
				
				/*
				*	Listing Search Link
				*/
				
				case "listing":
					
					$label = "Listing Search";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/listingIDSearch.php";
					break;
				
				/*
				*	Featured Properties Link
				*/
				
				case "featured":
					
					$label = "Featured Properties";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/featured.php";
					break;
				
				/*
				* 	Sold and Pending Link
				*/
				
				case "soldPend":
					
					$label = "Sold/Pending Properties";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/soldPending.php";
					break;
				
				case "openHouse":
					
				/**
				 *	Open Houses
				 */
					
					$label = "Open Houses";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/featuredOpenHouses.php";
					break;
				
				case "contact":
					
				/**
				 *	Contact Page
				 */
					
					$label = "Contact Us";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/contact.php";
					break;
				
				case "roster":
					
				/**
				 *	Roster Page
				 */
					
					$label = "Roster";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/roster.php";
					break;
				
				case"listingManager":
					
				/**
				 *	Listing Manager
				 */
					
					$label = "Listing Manager";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/userSignup.php";
					break;
				
				case "homeValuation":
					
				/**
				 *	Home Valuation
				 */
					
					$label = "Home Valuation";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/homeValue.php";
					break;
				
			}
			
			/*
			*	 So in order to know which type of query to do, we need to see if
			*	 the link already exists in the table. If so, then we UPDATE, if not
			*	 then we need to INSERT INTO.
			*/
			
			$current = mysql_query( "SELECT `ID` FROM `wp_posts` WHERE `post_name` = '$where' " );
			$row = @mysql_fetch_array($current);
			
			/*
			*	The number of rows returned is more than none, so we do an UPDATE. We need to
			*	write into two tables as required by WP and our filter.
			*/
			
			if(@mysql_num_rows($current) > 0){
				
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
			$row = @mysql_fetch_array($current);
			
			/*
			*	If the link exists and the client has unchecked it then we know we
			*	need to delete it from both tables.
			*/
			
			if(@mysql_num_rows($current) > 0){
				
				mysql_query( "DELETE FROM wp_posts WHERE ID ='$row[ID]'" );
				mysql_query( "DELETE FROM wp_postmeta WHERE post_id = '$row[ID]' " );
				
			}
		}
	}
	
	/*
	*	End without returning anything (AJAX)
	*/
	
	echo json_encode(array('response'=>'ok'));
	
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
	
	/**
	 *	Simplify the $_GET variable references.
	 */
	
	$linkName = $_GET['name'];
	$linkState = $_GET['state'];
	$linkUrl = $_GET['url'];

	/*
	*	If we find a link whose checkbox value is set to true.
	*/
	
	if($linkState == 'true'){
		
		/*
		*	Take the key and convert all underscores to spaces.  Then we need to cut
		*	off the first 11 characters 'idx_custom_' as that was used as a key
		*	in the admin to save the link states.
		*/
		
		
		$label = substr(str_replace('_', ' ', $linkName),11,strlen($linkName));
		
		/*
		*	Now we need to look in the table and see if this entry already exists,
		*	if it does then we just need to UPDATE, if not, then we INSERT.
		*/
		
		$current = mysql_query( "SELECT ID FROM wp_posts WHERE post_name = '$linkName' " );
		$row = @mysql_fetch_array($current);
	
		if(@mysql_num_rows($current) > 0){
			
			/*
			*	The entry already exists, so we can just UPDATE with the new information.
			*/
			
			$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->posts SET post_title = %s, post_type='page', post_name=%s WHERE ID = %d", $label, $linkName, $row[ID] ) );
			$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_key = '_links_to', meta_value = %s WHERE post_id = %d", $linkUrl, $row[ID] ) );
			
		} else {
			
			/*
			*	The entry didn't exist, so we will need to INSERT the new entry.
			*/
			
			$wpdb->query( $wpdb->prepare( "INSERT INTO $wpdb->posts SET post_title = %s, post_type='page', post_name=%s", $label, $linkName ) );
			$wpdb->query( $wpdb->prepare( "INSERT INTO $wpdb->postmeta SET meta_key = '_links_to', meta_value = %s, post_id = %d", $linkUrl, mysql_insert_id() ) );
			
		}
		
		/*
		*	If we find a key whose value is false.
		*/
		
	} else {
		
		/*
		*	Lets look up the ID of the entry so we can delete it, if it exists.
		*/
		
		$current = mysql_query( "SELECT ID FROM wp_posts WHERE post_name = '$linkName' " );
		$row = @mysql_fetch_array($current);
		
		/*
		*	We found a matching entry
		*/
		
		if(@mysql_num_rows($current) > 0){
			
			/*
			*	Delete the unwanted entry in the table.
			*/
			
			mysql_query( "DELETE FROM wp_posts WHERE ID ='$row[ID]'" );
			mysql_query( "DELETE FROM wp_postmeta WHERE post_id = '$row[ID]' " );
	
			
		}
	}
	
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

/**
 * Check the CID, Password, and domain option for errors
 * @return string - Echos the errors
 */

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
*	--------- IDX Broker Widgets Section -----------
*/

/*		widget_idxUserSignup();
 *
 *		Provides a widget that displays a form for leads to signup
 *		
 */

class widget_idxUserSignup extends WP_Widget {
	
	/*
	*	Constructor for the widget.
	*/
	
	function widget_idxUserSignup() {
		
		$widget_ops = array( 'classname' => 'widget_idxUserSignup', 'description' => __( "IDX Lead Signup" ) );
		$this->WP_Widget('idxUserSignup', __('IDX Lead Signup'), $widget_ops);
		
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
			
			echo "User Signup";
			
		}
		echo $after_title;
?>
		<style type="text/css">
			#IDX-userSignup {list-style: none;}
			#IDX-userSignup input[type=text], #IDX-userSignup input[type=password] {float: right; height: 14px;}
			#IDX-userSignup input[type=submit], #IDX-userSignup input[type=checkbox] {float: right;}
			#IDX-userSignup li {height: 23px; font-size: 8pt;}
			#IDX-leadPhoneBlock {display: block; float: right;}
		</style>
		
		<form name="newLead" class="IDX-spaceless" action="http://<?php echo $domain; ?>/idx/<?php echo get_option('idx_broker_cid'); ?>/userSignup.php" method="post">
			<input name="hint" type="hidden" value="newUser" />
			<input name="action" type="hidden" value="add" />
			<input name="phoneNumberRequired" type="hidden" value="n" />
			<input name="passwordRequired" type="hidden" value="n" />
			<input name="leadAddressRequired" type="hidden" value="n" />
			<input name="addEmailRequired" type="hidden" value="n" />
			
			<ul id="IDX-userSignup">
				<li>
					<label id="IDX-nameLabel" for="leadFirstName">First Name:</label>
					<input name="leadFirstName" type="text" size="15" maxlength="180" value="" id="IDX-userSignupName" />
				</li>
				<li>
					<label id="IDX-nameLabel" for="leadLastName">Last Name:</label>
					<input name="leadLastName" type="text" size="15" maxlength="180" value="" id="IDX-userSignupName" />
				</li>
				<li>
					<label id="IDX-emailLabel" for="leadEmail">Email Address:</label>
					<input name="leadEmail" type="text" size="15" maxlength="180" value="" id="IDX-userSignupEmail" />
				</li>
				<li>
					<label id="IDX-phoneLabel" for="leadPhoneArea" style="float: left;">Phone:</label>
					<span id="IDX-leadPhoneBlock">
						<input style="float: none;" name="leadPhoneArea" type="text" size="3" maxlength="3" value="" id="IDX-userSignupPhone1" />
						<input style="float: none;" name="leadPhonePrefix" type="text" size="3" maxlength="3" value="" id="IDX-userSignupPhone2" />
						<input style="float: none;" name="leadPhoneSuffix" type="text" size="4" maxlength="4" value="" id="IDX-userSignupPhone3"/>
					</span>
				</li>
				<li>
					<label id="IDX-addressLabel" for="leadAddress">Address:</label>
					<input name="leadAddress" type="text" size="15" maxlength="180" value="" id="IDX-userSignupAddress" />
				</li>
				<li>
					<label id="IDX-addressCityLabel" for="leadCity">City:</label>
					<input name="leadCity" type="text" size="15" maxlength="180" value="" id="IDX-userSignupCity" />
				</li>
				<li>
					<label id="IDX-addressStateLabel" for="leadState">State:</label>
					<input name="leadState" type="text" size="2" maxlength="2" value="" id="IDX-userSignupState" />
				</li>
				<li>
					<label id="IDX-addressZipLabel" for="leadZip">Zip:</label>
					<input name="leadZip" type="text" size="5" maxlength="5" value="" id="IDX-userSignupZip" />
				</li>
				<li>
					<label id="IDX-passwordLabel">Password:</label>
					<input name="password" type="password" maxlength="32" size="15" id="IDX-userSignupPassword"/>
				</li>
				<li>
					<label id="leadReceiveEmailUpdatesTd" for="leadReceiveEmailUpdates">Would you like to receive email updates?</label>
					<input type="checkbox" id="leadReceiveEmailUpdates" name="leadReceiveEmailUpdates" value="y" checked/>
				</li>
				<li style="list-style: none;">
					<input name="submit" id="IDX-formSubmit" type="submit" value="Sign Up!" id="IDX-userSignupSubmit"/>
				</li>
				<br style="clear:both;" />
			</ul>
		</form>

<?php 	echo $after_widget;

	}
	
	function update($new_instance, $old_instance) {

		return $new_instance;
	
	}
	
	function form($instance) {
		
		errorCheck();
		
		echo '<div id="idxUserSignup-admin-panel">';
		echo '<p>Provides a widget that displays a form for leads to signup for email update services.</p>';
		echo '<label for="' . $this->get_field_id("title") .'">User Signup Title:</label>';
		echo '<input type="text" ';
		echo 'name="' . $this->get_field_name("title") . '" ';
		echo 'id="' . $this->get_field_id("title") . '" ';
		echo 'value="' . $instance["title"] . '" /><br /><br />';
		echo '</div>';
		
	}
}


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
add_action('widgets_init', create_function('', 'return register_widget("widget_idxUserSignup");'));

/*
*	Add all ajax actions to the WP system.
*/

add_action('wp_ajax_idxUpdateLinks', 'idxUpdateLinks' );
add_action('wp_ajax_idxUpdateCustomLinks', 'idxUpdateCustomLinks' );
add_action('wp_ajax_idx_clearCustomLinks', 'idx_clearCustomLinks' );

/**
 *	Page links to plugin code, to make our navigation links work correctly
 */

// Compat functions for WP < 2.8
if ( !function_exists( 'esc_attr' ) ) {
	function esc_attr( $attr ) {
		return attribute_escape( $attr );
	}

	function esc_url( $url ) {
		return clean_url( $url );
	}
}

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

function idx_get_page_links_to_targets () {
	global $wpdb, $page_links_to_target_cache, $blog_id;

	if ( !isset( $page_links_to_target_cache[$blog_id] ) )
		$links_to = idx_get_post_meta_by_key( '_links_to_target' );
	else
		return $page_links_to_target_cache[$blog_id];

	if ( !$links_to ) {
		$page_links_to_target_cache[$blog_id] = false;
		return false;
	}

	foreach ( (array) $links_to as $link )
		$page_links_to_target_cache[$blog_id][$link->post_id] = $link->meta_value;

	return $page_links_to_target_cache[$blog_id];
}


function idx_plt_save_meta_box( $post_ID ) {
	if ( wp_verify_nonce( $_REQUEST['_idx_pl2_nonce'], 'idx_plt' ) ) {
		if ( isset( $_POST['idx_links_to'] ) && strlen( $_POST['idx_links_to'] ) > 0 && $_POST['idx_links_to'] !== 'http://' ) {
			$link = stripslashes( $_POST['idx_links_to'] );
			if ( 0 === strpos( $link, 'www.' ) )
				$link = 'http://' . $link; // Starts with www., so add http://
			update_post_meta( $post_ID, '_links_to', $link );
			if ( isset( $_POST['idx_links_to_new_window'] ) )
				update_post_meta( $post_ID, '_links_to_target', '_blank' );
			else
				delete_post_meta( $post_ID, '_links_to_target' );
			if ( isset( $_POST['idx_links_to_302'] ) )
				update_post_meta( $post_ID, '_links_to_type', '302' );
			else
				delete_post_meta( $post_ID, '_links_to_type' );
		} else {
			delete_post_meta( $post_ID, '_links_to' );
			delete_post_meta( $post_ID, '_links_to_target' );
			delete_post_meta( $post_ID, '_links_to_type' );
		}
	}
	return $post_ID;
}


function idx_filter_links_to_pages ($link, $post) {
	$page_links_to_cache = idx_get_page_links_to_meta();

	// Really strange, but page_link gives us an ID and post_link gives us a post object
	$id = ( $post->ID ) ? $post->ID : $post;

	if ( $page_links_to_cache[$id] )
		$link = esc_url( $page_links_to_cache[$id] );

	return $link;
}

function idx_redirect_links_to_pages() {
	if ( !is_single() && !is_page() )
		return;

	global $wp_query;

	$link = get_post_meta( $wp_query->post->ID, '_links_to', true );

	if ( !$link )
		return;

	$redirect_type = get_post_meta( $wp_query->post->ID, '_links_to_type', true );
	$redirect_type = ( $redirect_type = '302' ) ? '302' : '301';
	wp_redirect( $link, $redirect_type );
	exit;
}

function idx_page_links_to_highlight_tabs( $pages ) {
	$page_links_to_cache = idx_get_page_links_to_meta();
	$page_links_to_target_cache = idx_get_page_links_to_targets();

	if ( !$page_links_to_cache && !$page_links_to_target_cache )
		return $pages;

	$this_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$targets = array();

	foreach ( (array) $page_links_to_cache as $id => $page ) {
		if ( isset( $page_links_to_target_cache[$id] ) )
			$targets[$page] = $page_links_to_target_cache[$id];

		if ( str_replace( 'http://www.', 'http://', $this_url ) == str_replace( 'http://www.', 'http://', $page ) || ( is_home() && str_replace( 'http://www.', 'http://', trailingslashit( get_bloginfo( 'home' ) ) ) == str_replace( 'http://www.', 'http://', trailingslashit( $page ) ) ) ) {
			$highlight = true;
			$current_page = esc_url( $page );
		}
	}

	if ( count( $targets ) ) {
		foreach ( $targets as  $p => $t ) {
			$p = esc_url( $p );
			$t = esc_attr( $t );
			$pages = str_replace( '<a href="' . $p . '" ', '<a href="' . $p . '" target="' . $t . '" ', $pages );
		}
	}

	if ( $highlight ) {
		$pages = preg_replace( '| class="([^"]+)current_page_item"|', ' class="$1"', $pages ); // Kill default highlighting
		$pages = preg_replace( '|<li class="([^"]+)"><a href="' . $current_page . '"|', '<li class="$1 current_page_item"><a href="' . $current_page . '"', $pages );
	}

	return $pages;
}

function idx_plt_init() {
	if ( get_option( 'idx_plt_schema_version' ) < 3 ) {
		global $wpdb;
		$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key = '_links_to'        WHERE meta_key = 'links_to'        " );
		$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key = '_links_to_target' WHERE meta_key = 'links_to_target' " );
		$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key = '_links_to_type'   WHERE meta_key = 'links_to_type'   " );
		wp_cache_flush();
		update_option( 'idx_plt_schema_version', 3 );
	}
}

add_filter( 'wp_list_pages',     'idx_page_links_to_highlight_tabs', 9     );
add_action( 'template_redirect', 'idx_redirect_links_to_pages'             );
add_filter( 'page_link',         'idx_filter_links_to_pages',        20, 2 );
add_filter( 'post_link',         'idx_filter_links_to_pages',        20, 2 );
add_action( 'save_post',         'idx_plt_save_meta_box'                   );
add_action( 'init',              'idx_plt_init'                            );

?>
