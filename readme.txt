=== IDX Broker Wordpress Plugin ===
Author: IDX Broker
Contributors: idxco
Author URL: http://www.idxbroker.com
Tags: rets, ftp, idx, idx broker, idx plugin, idx wordpress plugin, wordpress plugin, real estate wordpress, real estate, idx widget, wordpress mls, wordpress idx, RETS, MLS, idxbroker, idx feed, agent, integrated idx
Tested up to: 3.3.2
Stable tag: 1.5.3

IDX Broker Plugin for Designers and REALTORS&reg;	 

== Description ==

<h3>Powerful, IDX search tools for REALTORS&reg; and IDX Developers.</h3>
<br />
<strong>NOTE: IDX Broker Platinum is now available to 500 markets in the US and Canada. <a href="http://wordpress.org/extend/plugins/idx-broker-platinum/">The IDX Broker Platinum plugin page</a> includes information for current users who are interested in upgrading to IDX Broker Platinum (same monthly price).</strong>
<br /><br />
For clients using IDX Broker Platinum currently, please download the new <a href="http://wordpress.org/extend/plugins/idx-broker-platinum/">IDX Broker Platinum Plugin.</a> and activate using the API key provided in your account setup email.  

== Installation ==

== Frequently Asked Questions ==

Applies to IDX Broker Platinum. 

= What is IDX? =
Internet Data Exchange, or IDX, is a type of data feed provided by your MLS. This data feed typically (but not always) mirrors the data available on your MLS's website. IDX Broker&reg; connects to this data feed automatically, maps the necessary fields, and then adds forms, scripts, etc, giving you a way to add html links and widgets to you website(s). 

= Do I need an IDX Broker account in order to use this plugin? =
Yes. IDX Broker manages your IDX feed by building forms, results, and property details pages that match your website or blog design. All IDX feeds require approval from a local board or MLS. If you are not a member of a local board or MLS, or your MLS does not provide an IDX data feed, then you will be unable to add IDX Broker plugin functionality to your WordPress site. <a href="http://www.idxbroker.com/idx_mls_coverage.php">Read more about our MLS coverage.</a> Note that some MLS's may charge you a separate fee for access to your IDX feed. 

= Does IDX Broker require a long-term contract? =
No. IDX Broker requires a month-to-month agreement only. There are three monthly account levels - Agent ($39.99+), Team ($49.99+), and Office($78.99+). 

= What can I expect if I decide to get my IDX feed through IDX Broker? =
When you sign up for a new account, IDX, Inc sends you any necessary MLS paperwork (if required). Once you have signed the necessary paperwork, you will need to fax that back to us and we will then forward your paperwork to the MLS for approval. Approval can take anywhere from 3-10 days. Once approved, we will activate your account, integrate your site's design into IDX pages, and send you IDX Broker login credentials so that you can add links and Widgets to your site or blog.  

= How many blogs/websites can I integrate with IDX Broker? =
Features provided by this Plugin - Widgets, links, and custom links may be placed onto any WordPress website or blog, regardless of MLS approval status. The reason for this is because all Widgets, links, and custom links point back to the original IDX-approved website. Each IDX Broker account requires MLS approval of one site for IDX display. Your search results and details pages must match this approved site. 

= Does IDX Broker offer lead capture functionality? =
Yes. IDX Broker provides you with a sign up Widget, sign up links, a lead manager page, a customizable sign up form, and provides you with 'teaser' registration options. 
 
== Screenshots ==

== Upgrade Notice ==

= 1.5.1 =

Switched custom link data pull so that it uses an object rather than array (limited).

= 1.5.0 =

Major revision; moved queries to wpdb method, added version tracking to client header, moved to WP API http connect method. 

= 1.4.1 =

Security update

= 1.4.0 =

Replaced deprecated WP function call. Error check to remove warning when no custom links created. Missing icons and logo from images folder. Moved custom links connection settings to work with WP API.Fixed bug that was dropping the last custom link from the array. 

= 1.3.9 =

Brought compatibility to 3.2+. Resolved false error codes and warnings that appear when server settings do not allow XML file access (custom links). Fixed Agent URL bug. Resolved JS errors that sometimes display when a Widget is first added to the sidebar. Updated SOAP services files. Resolved error when CID is more than four characters. 

= 1.3.8 =

Minor bug update.

= 1.3.7 =

Adding fallback to web services curl if simple xml fails.  Recommended upgrade.

= 1.3.5 =

Small Patch to resove php error.  To add more reliability to the plugin we moved to an XML feed for custom links from our server.  As a result you may see duplicates in your pages generated from custom links.  Please remove the duplicates in your 'pages' admin and import your custom links again.

= 1.3.4 =

Switched from web services to an xml feed for better reliability for custom link aquisition.  Highly recommended upgrade.

= 1.3.3 =

Cleaned up admin UI, replaced php shortcodes, replaced myAgent widget link, added additional help links, resized quick search widget, embedded additional knowledgebase links.  

= 1.3.2 =

Added sitemap, user login, and other links to the standard link options. Provided additional help for people confused about what to enter in subdomain field. 

= 1.3.1 =

Bug fixes ajax scripts that would spin out and never let options page submit.

= 1.3 =

Bug fixes for very large custom link lists. Added Select/Deselect all functionality on link lists.

= 1.2.9 =

Essential update to fix page links to function namespace errors and help links added.

= 1.2.8 =

Plugin has been streamlined and optimized after its initial development.  Wrapper features have updgraded were no file permissions, or copy and paste is needed in order to take advantage of the full integration feature.  Simply add your tags, set a few settings in the IDX Broker Admin, and your pages are automatically wrapped for you.  No need to update your wrapper, it's dyanamically loaded each time someone hits one of your pages.  The "Property Manager Signup" widget has been added, so that your visitor can sign up for automatic email updates that match searches that they preform on your site.  An essential upgrade!

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

= 1.5.3 =

Fixed similar error to v1.5.2 when WP cannot connect to pull in custom links. 

= 1.5.2 =

Fixed error when WP cannot connect to pull in custom links. 

= 1.5.1 =

Switched custom link data pull so that it uses an object rather than array (limited).

= 1.5.0 =

Major revision; moved queries to wpdb method, added version tracking to client header, moved to WP API http connect method. 

= 1.4.1 =

Security update

= 1.4.0 =

Replaced deprecated WP function call. Error check to remove warning when no custom links created. Fixed URL in help icon CSS. Fixed bug that was dropping the last custom link from the array. 

= 1.3.9 =

Brought compatibility to 3.2+. 
Resolved false error codes and warnings that appear when server settings do not allow XML file access (custom links). 
Fixed Agent URL bug. 
Resolved JS errors that sometimes display when a Widget is first added to the sidebar. 
Updated SOAP services files. 
Resolved error when CID is more than four characters. 

= 1.3.8 =

Minor bug update.

= 1.3.7 =

Adding fallback to web services curl if simple xml fails. Recommended upgrade.

= 1.3.5 =

Small Patch to resove php error.

= 1.3.4 =

Switched from web services to an xml feed for better reliability for custom link aquisition.  Highly recommended upgrade.

= 1.3.3 =

Bug fix for php shortcodes and resized quick search widget.  

= 1.3.2 =

Bug fix for extra div tag on widest QS form, labeling on General Settings updated in admin.

= 1.3.1 =

Bug fixes ajax scripts that would spin out and never let options page submit.

= 1.3 =

Bug fixes for very large custom link lists. Added Select/Deselect all functionality on link lists.

= 1.2.9 =

Page links to function namespace errors, added help icons and links.

= 1.2.8 =

Wrapper class removed, added "Property Manager Signup" widget, custom link code optimized for large volume.

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
