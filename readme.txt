=== ACF Render ===
Contributors: goldhat
Donate link: http://goldhat.ca/donate/
Tags: acf, acf theme, acf template, acf fields
Requires at least: 4.0
Tested up to: 4.6
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Provides shortcode acf-render for the rendering of ACF field values. Requires ACF5. Visit http://goldhat.ca/plugins/acf-render/ for details and docs.

== Description ==

Provides shortcode acf-render for the rendering of ACF field values. Provides API for output of ACF field values, and ability to override or add new field templates. Requires ACF.

Basic shortcode example: [acf-render name="my_field_name"]

Shortcode Usage Examples:

* Show Label: [acf-render name="first_name" label=1]
* Specify Post ID: [acf-render name="first_name" post="89"]
* Specify Template: [acf-render name="first_name" template="custom-text"]

API, programmatic usage: see ACF Render Docs at http://goldhat.ca/acf-render-docs/

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Add an [acf-render name="acf_field_name"] shortcode to a post or anywhere shortcodes are used.
