<?php
/*
Plugin Name: IDX Broker
Plugin URI: http://www.idxbroker.com/wordpress/
Description: The IDX Broker plugin gives Realtors&trade; an easier way to add IDX Broker Widgets, Menu links, and Custom Links to any Wordpress blog. 
Version: 1.1
Author: IDX, Inc.
Author URI: http://www.idxbroker.com
License: GPL
*/

// ini_set('display_errors', 1);

/* Runs when plugin is activated */
register_activation_hook(__FILE__,'idx_broker_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'idx_broker_remove');

function idx_broker_install() {
	add_option("idx_broker_cid", '', '', 'yes');		// client identification number
	add_option("idx_broker_pass", '', '', 'yes');		// client password
	add_option("idx_broker_domain", '', '', 'yes');		// domain of client website
	add_option("idx_broker_basicSearchLink", '', '', 'yes');
	add_option("idx_broker_basicSearchLabel", '', '', 'yes');
	add_option("idx_broker_advancedSearchLink", '', '', 'yes');
	add_option("idx_broker_advancedSearchLabel", '', '', 'yes');
	add_option("idx_broker_mapSearchLink", '', '', 'yes');
	add_option("idx_broker_mapSearchLabel", '', '', 'yes');
	add_option("idx_broker_addressSearchLink", '', '', 'yes');
	add_option("idx_broker_addressSearchLabel", '', '', 'yes');
	add_option("idx_broker_listingSearchLink", '', '', 'yes');
	add_option("idx_broker_listingSearchLabel", '', '', 'yes');
	add_option("idx_broker_featuredLink", '', '', 'yes');
	add_option("idx_broker_featuredLabel", '', '', 'yes');
	add_option("idx_broker_soldPendLink", '', '', 'yes');
	add_option("idx_broker_soldPendLabel", '', '', 'yes');
}

function idx_broker_remove() {
	// removes options on plugin uninstallation
	delete_option('idx_broker_cid');
	delete_option('idx_broker_pass');
	delete_option('idx_broker_domain');
	delete_option("idx_broker_basicSearchLink");
	delete_option("idx_broker_basicSearchLabel");
	delete_option("idx_broker_advancedSearchLink");
	delete_option("idx_broker_advancedSearchLabel");
	delete_option("idx_broker_mapSearchLink");
	delete_option("idx_broker_mapSearchLabel");
	delete_option("idx_broker_addressSearchLink");
	delete_option("idx_broker_addressSearchLabel");
	delete_option("idx_broker_listingSearchLink");
	delete_option("idx_broker_listingSearchLabel");
	delete_option("idx_broker_featuredLink");
	delete_option("idx_broker_featuredLabel");
	delete_option("idx_broker_soldPendLink");
	delete_option("idx_broker_soldPendLabel");
	
	
	// @todo
	// add main nav sanitation code
	
}

if ( is_admin() ){
	function idx_broker_admin() {
		include('idx_broker_admin.php');				// file that provides the admin interface
		add_options_page('IDX Broker Plugin Options', 'IDX Broker Plugin', 'administrator', 'idx-broker', 'idx_broker_admin_page');
	}
	add_action('admin_menu', 'idx_broker_admin');	
}

/*		widget_idxLinks();
 *
 *		Provides a widget to place links to various part of the clients idx system including: Basic Search, Advanced Search, Map Search, Address Search,
 *		Featured Properties, Contact Page, User Login Page, User Signup Page, Email Updates Page, and the Agent Roster Page (multiuser account).
 *		
 */

class widget_idxLinks extends WP_Widget {
	
	function widget_idxLinks() {
		
		$widget_ops = array( 'classname' => 'widget_idxLinks', 'description' => __( "IDX System Links" ) );
		$this->WP_Widget('idxLinks', __('IDX System Links'), $widget_ops);
		
	}
	
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

add_action('widgets_init', create_function('', 'return register_widget("widget_idxLinks");'));

/*		simplle console
 *
 */

class widget_console extends WP_Widget {
	
	function widget_console() {
		
		$widget_ops = array( 'classname' => 'widget_console', 'description' => __( "Console" ) );
		$this->WP_Widget('console', __('Console'), $widget_ops);
		
	}
	function widget($args, $instance) {
		
		extract($args);
		
		echo $before_widget;
		echo $before_title;
		echo 'Console';
		echo $after_title;
		
		// place console code here

		echo $after_widget;

	}
	
	function update($new_instance, $old_instance) {
		return $new_instance;
	}
	
	function form($instance) {
		echo idx_get_wrapper('header');
	}
}

add_action('widgets_init', create_function('', 'return register_widget("widget_console");'));


/*		widget_idxSlideshow();
 *
 *		Provides a widget to place a rotating slideshow of properites.  This slideshow is controlled by logging into the IDX Admin (http://www.idxco.com/mgmt/)
 *		under Widgets -> Slidewhow Settings
 *		
 */

class widget_idxSlideshow extends WP_Widget {
	
	function widget_idxSlideshow() {
		
		$widget_ops = array( 'classname' => 'widget_idxSlideshow', 'description' => __( "IDX Property Slideshow" ) );
		$this->WP_Widget('idxSlideshow', __('IDX Property Slideshow'), $widget_ops);
		
	}
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

add_action('widgets_init', create_function('', 'return register_widget("widget_idxSlideshow");'));

/*		widget_idxQs();
 *
 *		Provides a widget to place a property Quick Search Form in two customizable formats, narrow and wide.
 *		
 */

class widget_idxQs extends WP_Widget {
	
	function widget_idxQs() {
		
		$widget_ops = array( 'classname' => 'widget_idxQs', 'description' => __( "IDX Quick Search" ) );
		$this->WP_Widget('idxQs', __('IDX Quick Search'), $widget_ops);
		
	}
	
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

add_action('widgets_init', create_function('', 'return register_widget("widget_idxQs");'));

/*		widget_idxFeatAgent();
 *
 *		Provides a widget to place a featured agent section.  Most useful in a IDX Broker multiuser account.
 *		
 */

class widget_idxFeatAgent extends WP_Widget {
	
	function widget_idxFeatAgent() {
		
		$widget_ops = array( 'classname' => 'widget_idxFeatAgent', 'description' => __( "IDX Featured Agent" ) );
		$this->WP_Widget('idxFeatAgent', __('IDX Featured Agent'), $widget_ops);
		
	}
	
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

add_action('widgets_init', create_function('', 'return register_widget("widget_idxFeatAgent");'));

/*		widget_idxWildcardSearch();
 *
 *		Provides a widget to place a wildcard search form.
 *		
 */

class widget_idxWildcardSearch extends WP_Widget {
	
	function widget_idxWildcardSearch() {
		
		$widget_ops = array( 'classname' => 'widget_idxWildcardSearch', 'description' => __( "IDX Wildcard Search" ) );
		$this->WP_Widget('widget_idxWildcardSearch', __('IDX Wildcard Search'), $widget_ops);
		
	}
	
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

add_action('widgets_init', create_function('', 'return register_widget("widget_idxWildcardSearch");'));

/*		widget_myAgentBadge();
 *
 *		Provides a widget to place a myAgent iphone app badge with embedded agent code.
 *		
 */

class widget_myAgentBadge extends WP_Widget {
	
	function widget_myAgentBadge() {
		
		$widget_ops = array( 'classname' => 'widget_myAgentBadge', 'description' => __( "IDX myAgent Badge" ) );
		$this->WP_Widget('myAgentBadge', __('IDX myAgent Badge'), $widget_ops);
		
	}
	
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

add_action('widgets_init', create_function('', 'return register_widget("widget_myAgentBadge");'));

/*		widget_idxLeadLogin();
 *
 *		Provides a widget for client leads to login to their listings manager account.
 *		
 */

class widget_idxLeadLogin extends WP_Widget {
	
	function widget_idxLeadLogin() {
		
		$widget_ops = array( 'classname' => 'widget_idxLeadLogin', 'description' => __( "IDX Lead Login" ) );
		$this->WP_Widget('idxLeadLogin', __('IDX Lead Login'), $widget_ops);
		
	}
	
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

add_action('widgets_init', create_function('', 'return register_widget("widget_idxLeadLogin");'));

/*		idxUpdateLinks();
 *
 *		Manages IDX links in the header nav.
 *		
 */

function idxUpdateLinks() {
	
	global $wpdb;
	
	$links = array( 'basic' => $_GET['basicLink'],'advanced' => $_GET['advancedLink'], 'map' => $_GET['mapLink'], 'address' => $_GET['addressLink'], 'listing' => $_GET['listingLink'], 'featured' => $_GET['featuredLink'], 'soldPend' => $_GET['soldPendLink'] );
	$labels = array( 'basic' => $_GET['basicLabel'],'advanced' => $_GET['advancedLabel'], 'map' => $_GET['mapLabel'], 'address' => $_GET['addressLabel'], 'listing' => $_GET['listingLabel'], 'featured' => $_GET['featuredLabel'], 'soldPend' => $_GET['soldPendLabel'] );

	foreach($links as $type => $state) {
		
		$where = 'idx_'.$type;
		
		if ($state == "true") {
			
			switch($type){
				
				case "basic":
					$label = ($labels[$type] != '')?$labels[$type]:"Basic Search";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/basicSearch.php";
					break;
				
				case "advanced":
					
					$label = ($labels[$type] != '')?$labels[$type]:"Advanced Search";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/advancedSearch.php";
					break;
				
				case "map":
					
					$label = ($labels[$type] != '')?$labels[$type]:"Map Search";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/mapSearch.php";
					break;
				
				case "address":
					
					$label = ($labels[$type] != '')?$labels[$type]:"Address Search";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/addressSearch.php";
					break;
				
				case "listing":
					
					$label = ($labels[$type] != '')?$labels[$type]:"Listing Search";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/listingIDSearch.php";
					break;
				
				case "featured":
					
					$label = ($labels[$type] != '')?$labels[$type]:"Featured Properties";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/featured.php";
					break;
				
				case "soldPend":
					
					$label = ($labels[$type] != '')?$labels[$type]:"Sold/Pending Properties";
					$url = "http://".get_option('idx_broker_domain')."/idx/".get_option('idx_broker_cid')."/soldPending.php";
					break;
				
			}
			
			$current = mysql_query( "SELECT ID FROM wp_posts WHERE post_name = '$where' " );
			$row = mysql_fetch_array($current);
			
			if(mysql_num_rows($current) > 0){
				
				//mysql_query( "UPDATE wp_posts SET post_title='$label', post_type='page', post_name='$where' WHERE ID ='$row[ID]'" );
				$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->posts SET post_title = %s, post_type='page', post_name=%s WHERE ID = %d", $label, $where, $row[ID] ) );
				//mysql_query( "UPDATE wp_postmeta SET meta_key = '_links_to', meta_value = '$url' WHERE post_id = '$row[ID]' " );
				$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_key = '_links_to', meta_value = %s WHERE post_id = %d", $url, $row[ID] ) );
			
			} else {
				
				//mysql_query( "INSERT INTO wp_posts SET post_title='$label', post_type='page', post_name='$where'" );
				$wpdb->query( $wpdb->prepare( "INSERT INTO $wpdb->posts SET post_title = %s, post_type='page', post_name=%s", $label, $where ) );
				//mysql_query( "INSERT INTO wp_postmeta SET meta_key = '_links_to', meta_value = '$url', post_id = '".mysql_insert_id()."'" );
				$wpdb->query( $wpdb->prepare( "INSERT INTO $wpdb->postmeta SET meta_key = '_links_to', meta_value = %s, post_id = %d", $url, mysql_insert_id() ) );
				
			}
			
		} else {
			
			$current = mysql_query( "SELECT ID FROM wp_posts WHERE post_name = '$where' " );
			//$current = $wpdb->query( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s", $where ) );
			$row = mysql_fetch_array($current);
			
			if(mysql_num_rows($current) > 0){
				
				mysql_query( "DELETE FROM wp_posts WHERE ID ='$row[ID]'" );
				//$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->posts WHERE ID = %d", $row[ID] ) );
				mysql_query( "DELETE FROM wp_postmeta WHERE post_id = '$row[ID]' " );
				//$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->postmeta WHERE post_id = %d", $row[ID] ) );
				
			}
		}
	}
	
	die();
	
}

add_action('wp_ajax_idxUpdateLinks', 'idxUpdateLinks' );

function idxUpdateWrapper () {
	
	$url = "http://www.idxbroker.com/wordpress/";
	
	$curl_handle = curl_init();
    curl_setopt( $curl_handle, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
    curl_setopt( $curl_handle, CURLOPT_URL, $url );
    curl_setopt( $curl_handle, CURLOPT_FOLLOWLOCATION, true );
    curl_setopt( $curl_handle, CURLOPT_ENCODING, "" );
    curl_setopt( $curl_handle, CURLOPT_AUTOREFERER, true );
	curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $curl_handle, CURLOPT_MAXREDIRS, 10 );
	$wrapper = curl_exec($curl_handle);
	curl_close($curl_handle);
	
	$header = substr(strrev(stristr(strrev($wrapper), '>vid/<>";enon :yalpsid"=elyts "tratSxdi"=di vid<')), 0, -48); // 48 char
	$footer = substr(stristr($wrapper, '<div id="idxStop" style="display: none;"></div>'), 47); //47 char
	
	$headerFile = "../wp-content/plugins/idx-broker-wordpress-plugin/wrapper/header.php";
	$fhHead = fopen($headerFile, 'w') or die("Can't open file");
	fwrite($fhHead, $header);
	fclose($fhHead);
	
	$footerFile = "../wp-content/plugins/idx-broker-wordpress-plugin/wrapper/footer.php";
	$fhFoot = fopen($footerFile, 'w') or die("Can't open file");
	fwrite($fhFoot, $footer);
	fclose($fhFoot);
	
	die();
	
}

add_action('wp_ajax_idxUpdateWrapper', 'idxUpdateWrapper' );

function errorCheck() {
	
	// get values of options
	$cid = get_option('idx_broker_cid');
	$domain = get_option('idx_broker_domain');
	
	// array that holds our errors
	$errors = array();
	
	// check 
	if (empty($cid) || !is_numeric($cid) ||  (strlen($cid) != 4)) {
		
		$errors[] = "Please check your Client Identification (CID) in the IDX Broker Plugin Settings for errors.";
		
	}
	
	if (empty($domain)) {
		
		$errors[] = "Please enter the full domain of IDX hosted pages in the IDX Broker Plugin Settings.";
		
	}
	
	foreach ($errors as $error){
		
		$errorOutput .= "<div style='color: red; margin: 10px 0; font-weight: bold'>".$error."</div";
		
	}
	
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

add_action('widgets_init', create_function('', 'return register_widget("widget_idxCustomLinks");'));


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

add_filter( 'page_link', 'idx_filter_links_to_pages', 20, 2 );


function idx_start () {
	 echo '<div id="idxStart" style="display: none;"></div>';
}

function idx_stop () {
	echo '<div id="idxStop" style="display: none;"></div>';
}

?>
