=== GiftFold ===
Contributors: jlberglund
Tags: giftfold, donations, widget
Requires at least: 3.0
Tested up to: 3.6
Stable tag: 1.1.0
License: GPLv2 or later

This plugin allows GiftFold customers to easily embed a donation widget in their Wordpress site.

== Description ==

GiftFold is an online app that enables nonprofit organizations to create and manage donation forms which can be fully branded and integrated into their larger campaign efforts. GiftFold provides organizations with enterprise fundraising features, including complete customization of everything a donor will see, compatibility with all major payment gateways, a mobile-friendly backend, and split testing for different campaign form layouts.

This plugin allows GiftFold customers to easily embed a donation widget in their Wordpress site.

== Installation ==

1. Install the plugin
2. Activate the plugin
3. Add the GiftFold widget
4. Configure the widget URL and default amount

== Screenshots ==

1. With the plugin installed, you can easily add the GiftFold widget to a sidebar in your Wordpress site.

== Changelog ==

= 1.1.0 =
* Switched form to use GET HTTP requests instead of POST requests.
* Added widget option for cross-domain tracking with Google Analytics. Note that you will need to use asynchronous tracking with _setAllowAnchor set. See <http://productforums.google.com/forum/#!topic/analytics/hwDtn8dCmaw>.
* Added fields to change the amount field label (formerly "$") as well as the submit button's label (formerly "Donate").
* Added id attributes to HTML elements for styling (e.g. #giftfold-widget-amount-input).
