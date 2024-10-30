<?php
/**
 * Display Onboarding slides to new users
 *
 * @package Headline Studio
 */

defined( 'ABSPATH' ) || exit;

/**
 * Define and return onboarding steps
 *
 * @return Array $onboardingsteps
 */
function cos_headlinestudio_get_onboarding_steps() {
	$onboarding_steps                   = array();
	$onboarding_steps['gettingstarted'] = array(
		'index'    => 0,
		'text'     => 'Getting Started',
		'template' => 'onboarding/getting-started.php',
	);
	$onboarding_steps['accountsetup']   = array(
		'index'    => 1,
		'text'     => 'Setup Account',
		'template' => 'onboarding/account-setup.php',
	);
	$onboarding_steps['powerup']        = array(
		'index'    => 2,
		'text'     => 'Power Up Your Team',
		'template' => 'onboarding/power-up-your-team.php',
	);
	$onboarding_steps['seeyourscore']   = array(
		'index'    => 3,
		'text'     => 'See Your Score',
		'template' => 'onboarding/see-your-score.php',
	);
	$onboarding_steps['startanalyzing'] = array(
		'index'    => 4,
		'text'     => 'Start Analyzing',
		'template' => 'onboarding/start-analyzing.php',
	);

	return $onboarding_steps;
}

/**
 * Renders button to move forward and backward through onboarding
 *
 * @param string $target_page Page to which to navigate.
 * @param string $button_text Text to display on the button.
 * @param string $button_class Class to apply to the button.
 */
function render_nav_button( $target_page, $button_text, $button_class ) {
	?>
	<a href="<?php echo esc_url( get_admin_url() ) . 'options-general.php?page=headline-studio-settings&step=' . esc_attr( $target_page ); ?>" class="hs-wp-button <?php echo esc_attr( $button_class ); ?>"><?php echo esc_html( $button_text ); ?></a>
	<?php
}

/**
 * Renders progress bar for onboarding slides
 *
 * @param array  $onboarding_steps Array of onboarding steps.
 * @param string $current_page Key of current onboarding page.
 */
function cos_headlinestudio_render_onboarding_progress_bar( $onboarding_steps, $current_page ) {
	$current_step = $onboarding_steps[ $current_page ] ?? null;
	if ( ! $current_step ) {
		return;
	}

	foreach ( $onboarding_steps as $current_step_name => $current_step_info ) {
		$class_name = '';
		if ( $current_step['index'] > $current_step_info['index'] ) {
			$class_name = 'done';
		} elseif ( $current_step['index'] === $current_step_info['index'] ) {
			$class_name = 'active';
		}

		?>
		<li class="<?php echo esc_attr( $class_name ); ?>">
			<a href="<?php echo esc_attr( get_admin_url() ) . 'options-general.php?page=headline-studio-settings&step=' . esc_attr( $current_step_name ); ?>"><?php echo esc_html( $current_step_info['text'] ); ?></a>
		</li>
		<?php
	}
}

/**
 * Displays correct settings page based on current state
 */
function cos_headlinestudio_show_onboarding() {
	$onboarding_steps = cos_headlinestudio_get_onboarding_steps();
	$current_page     = isset( $_GET['step']) ? $_GET['step'] : 'gettingstarted';
	?>
<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<title></title>
			<meta name="description" content="">
			<meta name="viewport" content="width=device-width, initial-scale=1">
		</head>
		<body>
			<div class="headline-studio-onboarding">

				<div class="header">
					<div class="wizard-logo">
						<a href="https://coschedule.com/headline-studio" target="blank" rel="noopener noreferrer">
							<?php echo '<img src="' . esc_attr( HEADLINE_STUDIO_PLUGIN_URL ) . '/assets/img/hs-logo-full-color.svg" alt="Headline Studio Logo">'; ?>
						</a>
					</div>

					<ul class="progress-bar">
						<?php cos_headlinestudio_render_onboarding_progress_bar( $onboarding_steps, $current_page ); ?>
					</ul>
				</div>
				<div class="content-container">
					<?php include $onboarding_steps[ $current_page ]['template']; ?>
				</div>
			</div>
		</body>
	</html>
	<?php
}
