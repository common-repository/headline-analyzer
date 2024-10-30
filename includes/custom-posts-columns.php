<?php
/**
 * Display the Headline Score and SEO scores on the post admin page
 *
 * @package Headline Studio
 */

defined( 'ABSPATH' ) || exit;

/**
 * Adds the 'Headline Score' and 'SEO Score' custom columns to the 'All Posts' admin table
 *
 * @param array $columns Collection of columns.
 *
 * @return array
 */
function cos_headlinestudio_set_custom_columns( $columns ) {
	return array_merge(
		$columns,
		array(
			'cos_headline_score' => 'Headline Score',
			'cos_seo_score'      => 'SEO Score',
		)
	);
}
add_filter( 'manage_post_posts_columns', 'cos_headlinestudio_set_custom_columns' );
add_filter( 'manage_pages_columns', 'cos_headlinestudio_set_custom_columns' );


/**
 * Gets the headline or seo score depending on the field
 *
 * @param int    $post_id Name of the column.
 * @param string $post_title Post id.
 * @param string $column_name Post id.
 *
 * @returns int  Headline or SEO score
 */
function cos_headline_studio_get_headline_field_value( $post_id, $post_title, $column_name ) {
	$current_field_value = get_post_meta( $post_id, $column_name, true );

	if ( ! $current_field_value ) {
		$previous_headline_scores = get_post_meta( $post_id, 'cos_last_analyzed_headline', true );
		if ( $previous_headline_scores && $previous_headline_scores['last_headline_text'] == $post_title ) {
			switch ( $column_name ) {
				case 'cos_headline_score':
					$current_field_value = $previous_headline_scores['last_headline_score'] ?? null;
					break;
				case 'cos_seo_score':
					$current_field_value = $previous_headline_scores['last_seo_score'] ?? null;
			}
		}
	}

	return $current_field_value;
}
/**
 * Adds values to the 'Headline Score' and 'SEO Score' custom posts columns
 *
 * @param string $column_name Admin column name.
 * @param int    $post_id Post id.
 *
 * @return void
 */
function cos_headlinestudio_custom_column_values( $column_name, $post_id ) {
	if ( ! ( 'cos_headline_score' === $column_name || 'cos_seo_score' === $column_name ) ) {
		return;
	}

	$post_title         = get_post_field( 'post_title', $post_id );
	$cos_headline_score = cos_headline_studio_get_headline_field_value( $post_id, $post_title, 'cos_headline_score' );
	$cos_seo_score      = cos_headline_studio_get_headline_field_value( $post_id, $post_title, 'cos_seo_score' );

	switch ( $column_name ) {
		case 'cos_headline_score':
			$column_score = $cos_headline_score ?? null;
			break;
		case 'cos_seo_score':
			$column_score = $cos_seo_score ?? null;
			break;
		default:
			$column_score = null;
	}

	if ( $column_score ) {
		$score_state = cos_headlinestudio_get_score_state( $column_score );
		echo '<div class="headline-studio-score-column">';
		echo '<div class="score-circle ' . esc_html( $score_state ) . '"></div>';
		echo '<div class="score-value">' . esc_html( $column_score ) . '</div>';
		echo '</div>';
	} else {
		echo '—';
	}
}
add_action( 'manage_post_posts_custom_column', 'cos_headlinestudio_custom_column_values', 10, 2 );
add_action( 'manage_pages_custom_column', 'cos_headlinestudio_custom_column_values', 10, 2 );


/**
 * Returns a "state" class based on a headline or seo score.
 *
 * @param int $score Headline or SEO score.
 *
 * @return string
 */
function cos_headlinestudio_get_score_state( $score ) {
	if ( $score >= 70 ) { // 70-100
		return 'good';
	}

	if ( $score >= 40 ) { // 40-69
		return 'warning';
	}

	if ( $score <= 39 ) { // 0-39
		return 'issue';
	}

	return 'neutral';
}


/**
 * Registers and enqueue the custom columns style sheet
 *
 * @return void
 */
function cos_headlinestudio_register_custom_column_styles() {
	if ( defined( 'HEADLINE_STUDIO_PLUGIN_URL' ) ) {
		$handle = 'cos-headlinestudio-custom-column-styles';
		wp_register_style( $handle, HEADLINE_STUDIO_PLUGIN_URL . 'assets/css/hs-custom-column-styles.css' );
		wp_enqueue_style( $handle );
	}
}
add_action( 'admin_enqueue_scripts', 'cos_headlinestudio_register_custom_column_styles' );
