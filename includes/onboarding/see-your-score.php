<?php
/**
 * See your score onboarding page
 *
 * @package Headline Studio
 */

defined( 'ABSPATH' ) || exit;

$image_source = HEADLINE_STUDIO_PLUGIN_URL . '/assets/img/PostsPage.png';
?>
<div class="content image-left">
	<picture>
		<img src="<?php echo esc_attr( $image_source ); ?>" alt="See all your scores on your posts page">
	</picture>

	<div class="copy">
		<h3>See all your headline scores together</h3>
		<p>The Headline Studio plugin adds additional columns to
			your Posts page for SEO Score and Headline Score. Easily
			keep track of analyzed headlines to make sure every
			headline is a top performer.</p>
	</div>
</div>

<div class="actions multiple">
	<?php
	render_nav_button( 'powerup', 'Go Back', 'outline' );
	render_nav_button( 'startanalyzing', 'Continue', 'blue' );
	?>
</div>
