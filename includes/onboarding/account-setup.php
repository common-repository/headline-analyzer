<?php
/**
 * Account setup settings page
 *
 * @package Headline Studio
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="content setup-step">
	<?php if ( cos_headlinestudio_is_connected() ) : ?>
		<h3>Account Connected!</h3>
		<div class="connected-account">
			<div class="connection-settings">

				<div class="information">
					<h5 title="<?php echo esc_js( get_option( 'cos_headlinestudio_user_email' ) ); ?>">
						<?php
						echo esc_js( get_option( 'cos_headlinestudio_user_email', '' ) );
						?>
					</h5>
					<span>
						<?php echo esc_js( 'Connected on ' . gmdate( 'F j\, Y', intval( cos_headlinestudio_connected_on() ) ) ); ?>
					</span>
				</div>

				<div class="connection-actions">
					<button id="hs_disconnect" type="button" class="hs-wp-button flat red">Disconnect</button>
				</div>
			</div>
		</div>

		<p>Make sure everything looks right and press continue to finish setting up your Headline Studio Plugin!</p>
	<?php else : ?>
		<h3>Create Your Account</h3>
		<p>Get started with a FREE Headline Studio account and start writing 10x better headlines today.</p>

		<button id="hs-create-account" class="create-account hs-wp-button blue">Create My Account</button>

		<h5>Already have an account?</h5>
		<button id="hs-connect" class="sign-in hs-wp-button outline blue">Sign In</button>
	<?php endif; ?>
</div>

<div class="actions multiple">
	<?php
	render_nav_button( 'gettingstarted', 'Go Back', 'outline' );
	render_nav_button( 'powerup', 'Continue', 'blue' );
	?>
</div>
