<?php
/**
 * Custom REST routes and handlers
 *
 * @package Headline Studio
 */

defined( 'ABSPATH' ) || exit;


function cos_headlinestudio_manage_permission_callback( WP_REST_Request $request ) {
  $nonce = $request->get_header('X-WP-Nonce');
  if (! wp_verify_nonce($nonce, 'wp_rest')) { return false; }
  return current_user_can( 'manage_options' );
}


function cos_headlinestudio_edit_permission_callback( WP_REST_Request $request ) {
  $nonce = $request->get_header('X-WP-Nonce');
  $postId = $request->get_param('postId');
  if (! wp_verify_nonce($nonce, 'wp_rest')) { return false; }
  return current_user_can( 'edit_posts', $postId) || current_user_can( 'edit_pages', $postId );
}

/**
 * Registers custom routes
 */
function cos_headlinestudio_register_custom_endpoints() {
	register_rest_route(
		'cos_headline_studio/v1',
		'/set_headline_post_meta/(?P<post_id>\d+)',
		array(
			'methods'             => 'POST',
			'callback'            => 'cos_headlinestudio_set_headline_post_meta',
			'args'                => array(
				'post_id' => array(),
			),
      'permission_callback' => 'cos_headlinestudio_edit_permission_callback',
		),
	);

	register_rest_route(
		'cos_headline_studio/v1',
		'/disconnect_account',
		array(
			'methods'             => 'GET',
			'callback'            => 'cos_headlinestudio_disconnect_headline_studio',
			'args'                => array(),
      'permission_callback' => 'cos_headlinestudio_manage_permission_callback',
		),
	);

	register_rest_route(
		'cos_headline_studio/v1',
		'/connect_account_handler',
		array(
			'methods'             => 'GET',
			'callback'            => 'cos_headlinestudio_connect_handler',
			'args'                => array(),
      'permission_callback' => 'cos_headlinestudio_manage_permission_callback',
    ),
	);

	register_rest_route(
		'cos_headline_studio/v1',
		'/get_headline_post_meta/(?P<post_id>\d+)',
		array(
			'methods'             => 'GET',
			'callback'            => 'cos_headlinestudio_get_headline_post_meta',
			'args'                => array(
				'post_id' => array(),
			),
      'permission_callback' => 'cos_headlinestudio_edit_permission_callback',
		),
	);

	register_rest_route(
		'cos_headline_studio/v1',
		'/set_preferred_editor',
		array(
			'methods'             => 'GET',
			'callback'            => 'cos_headlinestudio_set_preferred_editor',
			'args'                => array(),
      'permission_callback' => 'cos_headlinestudio_manage_permission_callback',
		),
	);

	register_rest_route(
		'cos_headline_studio/v1',
		'/set_onboarded',
		array(
			'methods'             => 'GET',
			'callback'            => 'cos_headlinestudio_set_onboarding',
			'args'                => array(),
      'permission_callback' => 'cos_headlinestudio_manage_permission_callback',
		),
	);
}

/**
 * Handles successful oAuth connect
 *
 * @param WP_REST_Request $request Request object.
 */
function cos_headlinestudio_connect_handler( WP_REST_Request $request ) {
	try {
		$embed_token = $request->get_param( 'embedToken' );
		$user_id     = $request->get_param( 'userId' );
		$email       = $request->get_param( 'email' );

		update_option( 'cos_headlinestudio_embed_token', $embed_token );
		update_option( 'cos_headlinestudio_user_id', $user_id );
		update_option( 'cos_headlinestudio_user_email', $email );
		update_option( 'cos_headlinestudio_account_connected_at', time() );

		return 'Account connected';
	} catch ( Exception $e ) {
		return 'There was a problem connecting your account';
	}
}


/**
 * Updates WordPress options on account disconnect
 */
function cos_headlinestudio_disconnect_headline_studio() {
	update_option( 'cos_headlinestudio_embed_token', '' );
	update_option( 'cos_headlinestudio_user_id', '' );
	update_option( 'cos_headlinestudio_user_email', '' );
	update_option( 'cos_headlinestudio_account_connected_at', 0 );
	return 'Account disconnected';
}

/**
 * Sets post_meta for headline info
 *
 * @param WP_REST_Request $request REST request object.
 *
 * @return array
 */
function cos_headlinestudio_set_headline_post_meta( WP_REST_Request $request ) {
	$post_id     = $request->get_param( 'post_id' );
	$json_params = $request->get_json_params();

	foreach ( $json_params as $key => $value ) {
		update_post_meta( $post_id, $key, $value );
	}

	return $json_params;
}

/**
 * Registers custom routes
 *
 * @param WP_REST_Request $request REST request object.
 *
 * @return array
 */
function cos_headlinestudio_get_headline_post_meta( WP_REST_Request $request ) {
	$post_id      = $request->get_param( 'post_id' );
	$result_array = array();
	foreach ( HEADLINE_STUDIO_POST_META_KEYS as $post_meta_key ) {
		$post_meta_value                = get_post_meta( $post_id, $post_meta_key, true );
		$result_array[ $post_meta_key ] = $post_meta_value;
	}

	return $result_array;
}

/**
 * Sets the preferred editor for onboarding info display purposes
 *
 * @param WP_REST_Request $request REST request object.
 */
function cos_headlinestudio_set_preferred_editor( WP_REST_Request $request ) {
	$preferred_editor = $request->get_param( 'preferred_editor' );
	$prefer_classic   = 'classic' === $preferred_editor;
	update_option( 'cos_headlinestudio_prefer_classic_experience', $prefer_classic );
	return 'success';
}

/**
 * Sets the preferred editor for onboarding info display purposes
 *
 * @param WP_REST_Request $request REST request object.
 */
function cos_headlinestudio_set_onboarding( WP_REST_Request $request ) {
	$is_onboarded = 'true' === $request->get_param( 'is_onboarded' );
	update_option( 'cos_headlinestudio_is_onboarded', $is_onboarded );
	return 'success';
}
