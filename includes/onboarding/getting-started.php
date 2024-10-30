<?php
/**
 * Getting started onboarding page
 *
 * @package Headline Studio
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="content image-left">
	<?php echo '<img src="' . esc_attr( HEADLINE_STUDIO_PLUGIN_URL ) . '/assets/img/GettingStarted.png" alt="Headline Studio Report"/>'; ?>

	<div class="copy">
		<h3>Write better headlines that will boost your traffic</h3>
		<p>With data-backed headline scoring, suggestions, & SEO intelligence, you'll quickly write eye-catching headlines that…</p>
		<ul>
			<li>Help your content rank higher & become more visible in search</li>
			<li>Hook readers & boost click-throughs on your content</li>
			<li>Drive traffic back to your brand & convert more readers into customers</li>
		</ul>
	</div>
</div>

<div class="actions">
	<?php
		render_nav_button( 'accountsetup', 'Let\'s Get Started', 'blue' );
	?>
</div>
