=== IDX Broker Wordpress Plugin ===
Author: IDX Broker
Contributors: idxco, highjump76
Author URL: http://www.idxbroker.com
Tags: idx, real estate, search, widget, wordpress, wordpress idx, housing, RETS, MLS
Requires at least: 2.8.2
Tested up to: 3.0
Stable tag: 1.2.7

IDX Broker Plugin - Add integrated IDX to your website or blog today. 

== Description ==

This IDX plugin provides Realtors&reg; with a very easy way to add integrated IDX without using iFrames and without having to edit your theme's HTML directly. This plugin has been tested on AgentPress, as well as other popular IDX themes for Realtors.   

Note: This plugin requires an IDX Broker Account. Check MLS/IDX feed coverage <a href="http://www.idxbroker.com/idx_mls_coverage.php">here.</a> IDX Broker WordPress Plugin examples may be found <a href="http://www.idxbroker.com/idx_examples/">here.</a> 

<strong>Features include:</strong>

1. Drag-and-drop IDX search, new account setup, and other IDX Broker Widgets. 
2. Unlimited page links can be embedded into your navigation, including custom neighborhood, foreclosure, and other search page links. 
3. Widget to help you promote your myAgent iPhone App agent code. 
4. Advanced Theme Developers Only: Automated header and footer code generation to synchronize WordPress design with IDX pages.      

<strong>Benefits</strong>

Get Indexed - All IDX pages are fully indexable. 

Promote a mobile solution - Encourage people to download the free myAgent App and enter your Agent code. Once embedded, you become the primary point of contact for each and every property. 

Find the ideal signup process - Request signup on search, upon results, or after the 5th property view. It's up to you!

Pay one flat-rate price - Get IDX on your site, Widgets on your blog, map search, lead capture, iPhone application, and much more starting at $39.99/month. No monthly commitment required. 

<strong>Getting Started</strong>

Existing IDX Broker clients may simply enter their IDX Broker Client ID (CID), Password, and IDX subdomain (mysite.idxco.com or <a href="http://www.idxbroker.com/support/kb/questions/270/">custom domain</a>) to get started. Once entered, simply follow the instructions provided on the plugin page, or review articles published to the <a href="http://www.idxbroker.com/support/kb/categories/Wordpress+Plugin/">IDX Broker Knowledgebase.</a>    

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

= Does this plugin work with PHP4? =
No. The latest version of this plugin is written for PHP5. Download the 1.2.6 version of the plugin if your web server uses PHP4. 

= How does IDX work? =
IDX is a type of data feed provided by your MLS. This data feed typically (but not always) mirrors the data available on your MLS's website. IDX Broker™ connects to this data feed automatically, maps the necessary fields, and adds forms, scripts, etc, giving you a way to add html links and widgets to you website(s). 

= How many blogs/websites can I integrate with IDX Broker? =
Features provided by this Plugin - Widgets, links, and custom links may be placed onto ANY WordPress website or blog, regardless of MLS approval status. The reason for this is because all Widgets, links, and custom links point back to the original IDX-approved website. 

Note that the website hosting the design for IDX pages must be approved by your local MLS(s).  

= Do I need an IDX Broker account in order to use this plugin? =

Yes. IDX Broker manages your IDX feed by building forms, results, and property details pages that match your website or blog design. All IDX feeds require approval from a local board or MLS. If you are not a member of a local board or MLS, or your MLS does not provide an IDX data feed, then you will be unable to add IDX Broker plugin functionality to your WordPress site. <a href="http://www.idxbroker.com/idx_qanda.php">Read more about IDX Broker and IDX Feeds.</a>

= Should I use the advanced synchronization features, or leave that to my developer? =

We recommend that you leave the advanced synchronization feature to your developer. One exception to this rule is if you understand how WordPress manages security settings including CHMOD settings. If you don't know what CHMOD settings are, you should not attempt to synchronize your WordPress with IDX pages. Simply <a href="http://www.idxbroker.com/support/kb/contact.php">contact our support team</a> <strong>once you have finished making changes to your WordPress blog or site using the plugin</strong>, and we will update your IDX pages with those changes.    
 
== Screenshots ==

1. Featured property slideshow Widget - 'screenshot-1.png'
2. myAgent iPhone App Widget - 'screenshot-2.png'
3. Custom links Widget - 'screenshot-3.png'
4. IDX Menu links - 'screenshot-4.png'
5. Plugin Admin screen. 'screenshot-5.png'
6. IDX Widget Admin - myAgent iPhone App. 'screenshot-6.png'
7. IDX automatic wrapper generation - 'screenshot-7.png'

== Upgrade Notice ==

= 1.2.7 =

Advanced feature now detects tags, read/write settings for folders, and provides copy/paste of header and footer content if security settings do not allow for the locally stored live wrapper files.

<strong>Important Note to Advanced Developers: If you currently use the live wrapper files, all updates will force you to manually modify the CHMOD settings for your /wrapper/ folder and the header.php and footer.php files contained there. Please review <a href="http://www.idxbroker.com/support/kb/questions/301/">this knowledgebase article</a> for more information about how to manage live wrappers when you update the IDX Broker plugin. Note that this is due to WordPress security requirements. This logic applies to any plugin that writes files to your local WordPress installation. 

= 1.2.5 =

Adds another option for wrapper generation.  Some Worpress Server configurations will not allow for the include files, this version will generate the static code to copy and paste into the IDX Broker Middlware.

= 1.2.3 =

Better front end error reporting to reduce confusion on cid missing error

= 1.2.2 =

Cleaned up options page and options registration scripts for forward WP compatibility and MU compatibility.

= 1.2 =

Allows automatic header and footer include generation for the IDX Broker system.


== Changelog ==

= 1.2.7 =

Wrapper update options are now avaliable depending on detection of requirements.  Wrapper functions moved off into it's own class.

= 1.2.6 =

Custom links error sending output before header. Corrected

= 1.2.5 =

Wrapper option added, you can now generate your header and footer to copy and paste into the IDX Broker Middleware.

= 1.2.3 =

Better front end error reporting to reduce confusion on cid missing error

= 1.2.2 =

Cleaned up options page and options registration scripts for forward WP compatibility and MU compatibility.

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
Added wildcard search form widget to list of available tools.
Added more format options to Quick Search Form.
Added myAgent badge widget.

= 1.0 =

Currently in Beta Testing as of 4/29/10
