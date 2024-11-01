=== Zipcode Lockdown ===
Contributors: customscripts
Tags: zip code, zip, location, page, pages, access, popup, overlay
Requires at least: 4.1
Tested up to: 4.8.1
Requires PHP: 5
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Restrict access to pages based on the user's zipcode.

== Description ==
Restrict access to pages based on the user inputting their zip code. When a user tries to visit a page with a list of zip codes specified, a popup will prompt them to enter their zip code. Until the user enters a pre-defined zip code, the contents of the page will be obfuscated. If a user enters an unlisted zip code, a message will appear in the popup politely informing them that the page is unavailable based on their input. Once the user enters a valid zip code, the popup will fade out and the page contents will fade in.

Note: The user's input is stored in a session variable, to allow the user to revisit the page. By installing this plugin, you agree to the use of the session variable (in the user's browser). The session variable is temporary, and is erased once the user closes his or her browser. No information is collected or saved by this plugin.

== Installation ==
1. Install and activate the plugin from the Plugins admin page.
2. Edit a page.
3. Zipcode Lockdown options are displayed in a right-hand panel.
4. Enter a comma-separated list of zip codes, e.g., "02215, 03301, 03801." (The list can include spaces, or not).
5. Click "Publish" (if creating a new page), or "Update" (if editing an existing page).
6. View your page to test out the feature. Try entering an invalid zip code first, and then a valid one.
7. The user's input is stored in a session variable, so that they can return to the page and not have to reinput the zip code.

== Frequently Asked Questions ==
= **Can I use this plugin with a "Post" post type?** =
No. The plugin only works with pages.

= **Can I use this plugin with a custom post-type?** =
No, because the plugin only works with the post_type "page." It is possible to modify this plugin, however, but it would require some knowledge of PHP.

To modify the plugin to support custom post types, open the main PHP file in the plugin, and edit the "if" statement on line 188 to include (making sure to replace everything inside the brackets, and the brackets themselves): 
 || $screen->post_type == '[Your custom post type here]'

== Screenshots ==
1. The user is prompted to enter their zip code on an enabled page.
2. Enter a comma-separated list of zip codes to allow acces.

== Changelog ==

= 1.0 =
* Stable, initial release

== Additional Info ==
*For more information, follow us online at customscripts.tech*