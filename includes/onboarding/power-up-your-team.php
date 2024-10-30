<?php
/**
 * Power up your team onboarding page
 *
 * @package Headline Studio
 */

defined( 'ABSPATH' ) || exit;

$image_source = HEADLINE_STUDIO_PLUGIN_URL . '/assets/img/Team.png';
?>

<div class="content image-left">
	<picture>
		<img src="<?php echo esc_attr( $image_source ); ?>" alt="Analyze headlines with your team">
	</picture>

	<div class="copy">
		<h3>Write and analyze side-by-side with your team</h3>
		<p>With the Headline Studio plugin, you can share your account with
			your entire team. Connect the plugin once and your team can
			analyze headlines directly inside WordPress, no matter who's logged in.</p>
	</div>
</div>

<div class="actions multiple">
	<?php
	render_nav_button( 'accountsetup', 'Go Back', 'outline' );
	render_nav_button( 'seeyourscore', 'Continue', 'blue' );
	?>
</div>
