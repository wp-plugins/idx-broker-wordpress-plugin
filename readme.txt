=== IDX Broker Wordpress Plugin ===
Author: IDX Broker
Contributors: idxco, highjump76
Author URL: http://www.idxbroker.com
Tags: idx, real estate, search, widget, wordpress, wordpress idx, housing, RETS, MLS
Requires at least: 2.8.2
Tested up to: 2.9.2
Stable tag: 1.2.2

== Description ==

This plugin is exclusively for IDX Broker Clients. It accomplishes three things:

1. Easily drag and drop every IDX Broker Widget into your Wordpress theme.
2. Easily add IDX links to your menu.
3. Easily display any neighborhood or subdivision (any custom link) landing pages that you've created using IDX Broker.

Your IDX results and details pages are hosted by IDX Broker, not your Wordpress blog. This means that you will not need to hand-code or remember any WordPress tags in order to use this plugin. 

Most of your IDX lead capture, iPhone app settings, lead routing, listing email updates, etc. are to be managed using your IDX Broker Admin, not via Admin for this WordPress Plugin. We believe most Plugin clients will appreciate that we have not reproduced an entire IDX back-office solution within Wordpress. The IDX feature set is far too robust build and support for each new and future version of WordPress. 

With that said, we have provided you with the tools that you need to get started with Wordpress and IDX. This Plugin is ideal for those Realtors&reg; who simply need to build a site or blog quickly in WordPress. It provides a way to quickly display featured listings, community/subdivision pages, basic search, your iPhone app code, and more - without having to hand-code this into every theme.

<strong>Advanced Users</strong>

If you are a WordPress theme designer or IDX reseller and wish to use this Plugin, keep in mind that the plugin is designed primarily for novice users. Any custom Widgets, CSS, and other customization needs to be handled within the HTML code for each Theme. The CSS classes and IDs needed to perform that customization are all available within each IDX Broker page. We recommend that you use <a href="http://getfirebug.com/">Firebug</a> to identify those CSS elements. 

The 'advanced' settings provide on the Plugin admin page provide you with a way to <a href="http://www.idxbroker.com/support/kb/questions/291/">synchronize WordPress with IDX pages</a>, with the click of a mouse. This synchronization option is only useful if a client's IDX pages need to match their WordPress blog. <strong>Only synchronize if the WordPress blog is the MLS-approved domain on record.</strong>      

<strong>Getting Started</strong>

Existing IDX Broker clients may simply enter their IDX Broker client ID (CID), Password, and IDX subdomain (mysite.idxco.com or <a href="http://www.idxbroker.com/support/kb/questions/270/">custom domain</a>) to get started. 

<strong>What is Available?</strong>

Indexable IDX - All hosted IDX pages are fully indexable. We have removed duplicate titles and descriptions from most of your IDX results and details pages. We also provide you with a way to edit URL paths, add subheader content, custom title/description tags, and make your IDX pages unique. 

Custom Results Landing Pages - We recommend that you add custom content to the subheaders of your IDX results pages in order to encourage the search enginess to differentiate your content from all the other IDX results and details pages that display the same addresses, Cities, and Zips for each MLS region. 

Lead Registration - You can use IDX Broker to force signup on every 4th or 5th property detail view. Or, if you prefer, require registration once the visitor click the link to your custom results page. 

Lead Management - Anybody who requests property info, fills out your contact form, saves a search, or creates an account with you will show up in the Lead Management tab of IDX Broker. You will also receive an email alert when this occurs.    

<strong>General Terms of Use</strong> 

This IDX plugin is supported by MLS/IDX feeds. This means that your MLS governs the IDX results and details pages. 

IDX, Inc. manages any MLS paperwork and IDX Broker will automatically display the correct MLS/IDX disclaimers to ensure compliance with the MLS(s) & Board(s) that provides you with your IDX feed. 

== Installation ==

1. Download and extract the IDX Broker plugin. You may also install directly by going to your WP-Admin page and then Plugins > Add New. Search for 'idxbroker' under new plugins and click to install directly.
2. Upload the uncompressed folder to your `/wp-content/plugins/` directory.
3. Activate the plugin through the Plugins menu in WordPress.
4. You will need an IDX Broker account (MLS approval required), for the Plugin to work. Go to the IDX Broker Plugin page within WordPress. Enter your CID, Password, and IDX Broker Subdomain and click the 'Save Changes' button.
5. Your plugin will now pull your IDX Broker account information into Wordpress. Use the IDX Broker Plugin Admin page to add Widgets, menu links, and neighborhood/subdivision landing pages (Custom Links).

== Frequently Asked Questions ==

= How does IDX work? =
IDX is a type of data feed provided by your MLS. This data feed typically (but not always) mirrors the data available on your MLS's website. IDX Broker™ connects to this data feed automatically, maps the necessary fields, and adds forms, scripts, etc, giving you a way to add html links and widgets to you website(s). 

= How many blogs/websites can I integrate with IDX Broker? =
Features provided by this Plugin - Widgets, links, and custom links may be placed onto ANY WordPress website or blog, regardless of MLS approval status. The reason for this is because all Widgets, links, and custom links point back to the original IDX-approved website. 

Note that the website hosting the design for IDX pages must be approved by your local MLS(s).  

= Do I need an IDX Broker account in order to use this plugin? =

Yes. IDX Broker manages your IDX feed by building forms, results, and property details pages that match your website or blog design. All IDX feeds require approval from a local board or MLS. If you are not a member of a local board or MLS, or your MLS does not provide an IDX data feed, then you will be unable to add IDX Broker plugin functionality to your WordPress site. <a href="http://www.idxbroker.com/idx_qanda.php">Read more about IDX Broker and IDX Feeds.</a>
 
== Screenshots ==

1. Featured property slideshow Widget - 'screenshot-1.png'
2. myAgent iPhone App Widget - 'screenshot-2.png'
3. Custom links Widget - 'screenshot-3.png'
4. IDX Menu links - 'screenshot-4.png'
5. Plugin Admin screen. 'screenshot-5.png'
6. IDX Widget Admin - myAgent iPhone App. 'screenshot-6.png'
7. IDX automatic wrapper generation - 'screenshot-7.png'

== Upgrade Notice ==

= 1.2.2 =

Consider this major upgrade to WP and especially, MU compatibility. Please review the details below if you have previously used the 'advanced' synchronization functionality. 

<strong>If you created synchronized header/footer files using a previous version of this plugin, please follow <a href="http://www.idxbroker.com/support/kb/questions/292/">these instructions</a> to establish the correct permissions for your header/footer files.</strong>

= 1.2 =

Allows automatic header and footer include generation for the IDX Broker system.


== Changelog ==

= 1.2.2 =

Cleaned up options page and options registration scripts for forward WP compatability and MU compatability.

= 1.2.1 =

Added the ability to add custom links into the main navigation.
Cleaned up admin styling.
Added custom link cleaning.
Better commenting on code.
Better function division.

= 1.2 =

Added automatic header and footer generation

= 1.1.0.2 =

Commented out password field (for future use), added more system links in the system links widget.

= 1.1 =

Added custom links widget from web services pull.
Added other widgets to bring plugin to 1.1 spec

= 1.01 = 

Added error checking on missing domain entry and malformed or missing CID, with error messages on widget placement/configuration page.
Added wildcard search form widget to list of avaliable tools.
Added more format options to Quick Search Form.
Added myAgent badge widget.

= 1.0 =

Currently in Beta Testing as of 4/29/10
