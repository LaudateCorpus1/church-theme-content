<?php
/**
 * Plugin Settings
 *
 * Setup and retrieve plugin settings. Also handles WordPress settings.
 *
 * @package    Church_Theme_Content
 * @copyright  Copyright (c) 2014 - 2017, churchthemes.com
 * @link       https://github.com/churchthemes/church-theme-content
 * @license    GPLv2 or later
 * @since      1.2
 */

// No direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**********************************
 * SETTINGS SETUP
 **********************************/

/**
 * Init settings class
 *
 * This will add settings page and make $ctc_settings object available for settings retrieval
 *
 * Note that title, description, etc. are escaped by CT Plugin Settings for translation security.
 *
 * @since 1.2
 * @global object $ctc_settings
 */
function ctc_settings_setup() {

	global $ctc_settings;

	// Note to add to page description for Pro add-on when not active.
	$pro_upgrade_note = '';
	if ( ! defined( 'CCP_VERSION' ) ) { // plugin not active.
		$pro_upgrade_note = sprintf(
			/* translators: %1$s is URL for Church Content Pro info. */
			__( '<a href="%1$s" target="_blank">Upgrade to Pro</a> to enable extra settings and features.', 'church-theme-content' ),
			'https://churchthemes.com/plugins/church-content-pro/?utm_source=ctc&utm_medium=plugin&utm_campaign=church_content_pro&utm_content=settings'
		);
	}

	// Pro tag to show after field labels.
	$pro_tag = _x( '(Pro)', 'settings', 'church-theme-content' );

	// SEO setting title.
	$seo_title = _x( 'SEO Structured Data', 'settings', 'church-theme-content' );

	// SEO setting description. Same for all post types.
	$seo_desc = sprintf(
		/* translators: %1$s is URL with information about SEO with JSON-LD */
		__( 'Automatically improves Search Engine Optimization (SEO) with schema.org structured data via JSON-LD. <a href="%1$s">Learn more</a>', 'church-theme-content' ),
		'https://churchthemes.com/go/seo-setting/?utm_source=ctc&utm_medium=plugin&utm_campaign=church_content_pro&utm_content=settings'
	);

	// Configuration.
	$config = array(

		// Master Option.
		// All settings will be saved as an array under this single option ID.
		'option_id' => 'ctc_settings',

		// Titles.
		'page_title' => sprintf(
			/* translators: %1$s is Church Content plugin URL, %2$s is add-ons URL */
			__( '%1$s Settings', 'church-theme-content' ),
			CTC_NAME
		),
		'menu_title' => CTC_NAME,

		// Settings page description.
		'desc' => sprintf(
			/* translators: %1$s is Church Content plugin URL, %2$s is note about upgrading to Pro (if not active), %3$s is URL to Customizer. */
			__( 'These settings are for the <a href="%1$s" target="_blank">Church Content</a> plugin. %2$s Use the <a href="%3$s">Customizer</a> for theme-provided appearance settings.', 'church-theme-content' ),
			'https://churchthemes.com/plugins/church-content/?utm_source=ctc&utm_medium=plugin&utm_campaign=church-theme-content&utm_content=settings',
			$pro_upgrade_note,
			esc_url( admin_url( 'customize.php' ) )
		),

		// Plugin File
		'plugin_file' => CTC_FILE, // path to plugin's main file.

		// URL for CT Plugin Settings directory.
		// This is used for loading its CSS and JS files.
		'url' => CTC_URL . '/' . CTC_LIB_DIR . '/ct-plugin-settings',

		// Section Tabs.
		'sections' => array(

			// Licenses.
			'licenses' => array(

				// Title.
				'title' => _x( 'Licenses', 'settings', 'church-theme-content' ),

				// Description.
				'desc' => sprintf(
					/* translators: %1$s is URL to Add-ons */
					__( "Save then activate your add-on's license key to enable one-click updates for it.", 'church-theme-content' ),
					'https://churchthemes.com/plugins/?utm_source=ctc&utm_medium=plugin&utm_campaign=add-ons&utm_content=settings'
				),

				// Fields (Settings).
				'fields' => array(

					// Example
					/*
					'setting_key' => array(
						'name'            => __( 'Field Name', 'church-theme-content' ),
						'after_name'      => '', // (Optional), (Required), etc.
						'desc'            => __( 'This is the description below the field.', 'church-theme-content' ),
						'type'            => 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number
						'checkbox_label'  => '', //show text after checkbox
						'options'         => array(), // array of keys/values for radio or select
						'default'         => '', // value to pre-populate option with (before first save or on reset)
						'no_empty'        => false, // if user empties value, force default to be saved instead
						'allow_html'      => false, // allow HTML to be used in the value
						'class'           => '', // classes to add to input
						'custom_sanitize' => '', // function to do additional sanitization
						'custom_content'  => '', // function for custom display of field input
					),
					*/

				),

			),

			// Sermons.
			'sermons' => array(

				// Title.
				'title' => _x( 'Sermons', 'settings section title', 'church-theme-content' ),

				// Description.
				'desc' => __( 'MAYBE SAY: Settings for Pro features disabled. Install Church Content Pro to enable.', 'church-theme-content' ),

				// Fields (Settings).
				'fields' => array(

					// SEO.
					'sermons_seo' => array(
						'name'            => $seo_title,
						'after_name'      => $pro_tag, // (Optional), (Required), etc.
						'desc'            => $seo_desc,
						'type'            => 'checkbox', // text, textarea, checkbox, checkbox_multiple, radio, select, number.
						'checkbox_label'  => __( 'Enable for Sermons (Recommended)', 'church-theme-content' ), // show text after checkbox.
						'options'         => array(), // array of keys/values for radio or select.
						'default'         => false, // value to pre-populate option with (before first save or on reset).
						'no_empty'        => false, // if user empties value, force default to be saved instead.
						'allow_html'      => false, // allow HTML to be used in the value.
						'class'           => '', // classes to add to input.
						'custom_sanitize' => '', // function to do additional sanitization.
						'custom_content'  => '', // function for custom display of field input.
					),

				),

			),

			// Podcasting.
			'podcasting' => array(

				// Title.
				'title' => _x( 'Podcasting', 'settings section title', 'church-theme-content' ),

				// Description.
				'desc' => '',

				// Fields (Settings).
				'fields' => array(

				),

			),

			// Events.
			'events' => array(

				// Title.
				'title' => _x( 'Events', 'settings section title', 'church-theme-content' ),

				// Description.
				'desc' => '',

				// Fields (Settings).
				'fields' => array(

				),

			),

			// Locations.
			'locations' => array(

				// Title.
				'title' => _x( 'Locations', 'settings section title', 'church-theme-content' ),

				// Description.
				'desc' => '',

				// Fields (Settings).
				'fields' => array(

					// Example.
					'google_maps_api_key' => array(
						'name'            => _x( 'Google Maps API Key', 'settings', 'church-theme-content' ),
						'after_name'      => '', // (Optional), (Required), etc.
						'desc'            => sprintf(
							/* translators: %1$s is URL to guide telling user how to get a Google Maps API Key */
							__( 'An API Key for Google Maps is required if you want to show maps for locations or events. <a href="%1$s" target="_blank">Get an API Key</a>', 'church-theme-content' ),
							'https://churchthemes.com/go/google-maps-api-key'
						),
						'type'            => 'text', // text, textarea, checkbox, checkbox_multiple, radio, select, number.
						'checkbox_label'  => '', // show text after checkbox.
						'options'         => array(), // array of keys/values for radio or select.
						'default'         => '', // value to pre-populate option with (before first save or on reset).
						'no_empty'        => false, // if user empties value, force default to be saved instead.
						'allow_html'      => false, // allow HTML to be used in the value.
						'class'           => '', // classes to add to input.
						'custom_sanitize' => '', // function to do additional sanitization.
						'custom_content'  => '', // function for custom display of field input.
					),

				),

			),

			// People.
			'people' => array(

				// Title.
				'title' => _x( 'People', 'settings section title', 'church-theme-content' ),

				// Description.
				'desc' => '',

				// Fields (Settings).
				'fields' => array(

				),

			),

		),

	);

	// Filter config.
	$config = apply_filters( 'ctc_settings_config', $config );

	// Add settings.
	$ctc_settings = new CT_Plugin_Settings( $config );

}

add_action( 'init', 'ctc_settings_setup' );

/**********************************
 * SETTINGS DATA
 **********************************/

/**
 * Get a setting
 *
 * @since 1.2
 * @param string $setting Setting key.
 * @return mixed Setting value.
 * @global object $ctc_settings.
 */
function ctc_setting( $setting ) {

	global $ctc_settings;

	$value = $ctc_settings->get( $setting );

	return apply_filters( 'ctc_setting', $value, $setting );

}

/**********************************
 * WORDPRESS SETTINGS
 **********************************/

/**
 * Change WordPress "Blog pages show at most" label text.
 *
 * "Posts per page" makes more sense when using multiple post types.
 *
 * @since 1.9.
 */
function ctc_change_wp_per_page_label( $translated_text, $text, $domain ) {

	switch ( $translated_text ) {

		case 'Blog pages show at most':
			/* translators: This replaces "Blog pages show at most" in WordPress Settings > Reading" */
			$translated_text = __( 'Posts per page', 'church-theme-content' );
			break;

	}

	return $translated_text;

}

add_filter( 'gettext', 'ctc_change_wp_per_page_label', 20, 3 );

/**
 * Insert note on Settings > Reading to say use Church Content settings to change "per page" per post type.
 *
 * A description is added after the "Blog pages show at most" input, which we renamed to "Posts per page".
 *
 * @since 1.9.
 */
function ctc_add_wp_per_page_desc() {

	// Get current screen.
	$screen = get_current_screen();

	// On settings screen only.
	if ( 'options-reading' !== $screen->base ) {
		return;
	}

	// Note to append.
	$note = sprintf(
		wp_kses(
			/* translators: %1$s is URL for Church Content Settings */
			__( 'Use <a href="%1$s">Church Content Settings</a> to override this for specific post types (sermons, events, etc.)', 'church-theme-content' ),
			array(
				'a' => array(
					'href' => array(),
				),
			)
		),
		admin_url( 'options-general.php?page=' . CTC_DIR )
	);

	?>

	<script type="text/javascript">

	jQuery( document ).ready( function( $ ) {

		// Get posts_per_page input element.
		var $per_page_input = $( 'input[name=posts_per_page]' );

		// Get parent td of input.
		var $container = $per_page_input.parent( 'td' );

		// Append note to bottom of td as description.
		$container.append( '<p class="description"><?php echo $note; ?></p>' );

	} );

	</script>

	<?php

}

add_action( 'admin_print_footer_scripts', 'ctc_add_wp_per_page_desc' );
