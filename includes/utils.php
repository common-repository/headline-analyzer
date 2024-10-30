<?php
/**
 * Utils required for Headline Studio functionality
 *
 * @package Headline Studio
 */

defined( 'ABSPATH' ) || exit;

/**
 * Returns true if the site is using Classic Editor instead of Gutenberg.
 *
 * @return bool
 */
function cos_headlinestudio_is_classic_editor() {
	$classic_editor_plugin_active    = function_exists( 'is_plugin_active' ) && is_plugin_active( 'classic-editor/classic-editor.php' );
	$no_register_block_type_function = ! function_exists( 'register_block_type' );

	return ( $classic_editor_plugin_active || $no_register_block_type_function ) && is_admin();
}

/**
 * Returns true if the plugin has completed oAuth connection.
 *
 * @return bool
 */
function cos_headlinestudio_is_connected() {
	return ! ! cos_headlinestudio_get_embed_token();
}

/**
 * Indicates the date on which the Headline Studio was connected to WordPress
 *
 * @return int
 */
function cos_headlinestudio_connected_on() {
	return get_option( 'cos_headlinestudio_account_connected_at', '' );
}

/**
 * Returns the embed token if an oAuth connection exists
 *
 * @return string|null
 */
function cos_headlinestudio_get_embed_token() {
	return get_option( 'cos_headlinestudio_embed_token' );
}

/**
 * Registers the coscheduleHeadlineStudio object on the window
 *
 * @return void
 */
function cos_headlinestudio_register_window_object() {
	$register_function = 'window.coscheduleHeadlineStudio = {}';
	wp_add_inline_script( 'hs-sidebar', $register_function );
}

/**
 * Adds the embed token to the global window context so that it can be used by the Gutenberg sidebar.
 * This is necessary as there is not a Gutenberg wp/data convention for returning options values.
 *
 * @return void
 */
function cos_headlinestudio_register_embed_token() {
	$embed_token       = cos_headlinestudio_get_embed_token();
	$register_function = "window.coscheduleHeadlineStudio.hs_embed_token = '$embed_token'; ";
	wp_add_inline_script( 'hs-sidebar', $register_function );
}

/**
 * Adds the user id the global window context so that it can be used by the Gutenberg sidebar.
 * This is necessary as there is not a Gutenberg wp/data convention for returning options values.
 *
 * @return void
 */
function cos_headlinestudio_register_user_id() {
	$user_id           = get_option( 'cos_headlinestudio_user_id' );
	$register_function = "window.coscheduleHeadlineStudio.hs_user_id = '$user_id'; ";
	wp_add_inline_script( 'hs-sidebar', $register_function );
}

/**
 * Adds the admin root url to the global window context so that it can be used by the Gutenberg sidebar.
 * This is necessary as there is not a Gutenberg wp/data convention for getting the admin url.
 *
 * @return void
 */
function cos_headlinestudio_register_admin_url() {
	$admin_url_base    = get_admin_url();
	$register_function = "window.coscheduleHeadlineStudio.hs_admin_url_base = '$admin_url_base'; ";
	wp_add_inline_script( 'hs-sidebar', $register_function );
}

/**
 * Registers post meta so that it can be saved.
 *
 * @return void
 */
function cos_headlinestudio_register_post_meta() {
	register_post_meta(
		'',
		'cos_headline_score',
		array(
			'type'         => 'integer',
			'show_in_rest' => true,
			'single'       => true,
		)
	);

	register_post_meta(
		'',
		'cos_seo_score',
		array(
			'type'         => 'integer',
			'show_in_rest' => true,
			'single'       => true,
		)
	);

	register_post_meta(
		'',
		'cos_headline_text',
		array(
			'type'         => 'string',
			'show_in_rest' => true,
			'single'       => true,
		)
	);

	register_post_meta(
		'',
		'cos_headline_has_been_analyzed',
		array(
			'type'         => 'boolean',
			'show_in_rest' => true,
			'single'       => true,
		)
	);

	register_post_meta(
		'',
		'cos_last_analyzed_headline',
		array(
			'type'         => 'object',
			'show_in_rest' => array(
				'single' => true,
				'schema' => array(
					'type'       => 'object',
					'properties' => array(
						'last_headline_score' => array(
							'type' => 'integer',
						),
						'last_seo_score'      => array(
							'type' => 'integer',
						),
						'last_headline_text'  => array(
							'type' => 'string',
						),
					),
				),
			),
		)
	);
}
