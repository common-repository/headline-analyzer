<?php
/**
 * Functionality relating to the Headline Studio settings page
 *
 * @package Headline Studio
 */

defined( 'ABSPATH' ) || exit;
/**
 * Registers a new Headline Studio options page under Settings.
 */
function cos_headlinestudio_register_settings_page() {
	add_options_page(
		'Headline Studio Settings',
		'Headline Studio',
		'manage_options',
		'headline-studio-settings',
		'cos_headlinestudio_settings_page'
	);
}
add_action( 'admin_menu', 'cos_headlinestudio_register_settings_page' );

/**
 * Adds javascript code to handle button clicks on account setup
 */
function cos_headlinestudio_handle_account_click_actions() {
    // Using wp_create_nonce() here is safe because the function is called in an action hook
     $nonce = wp_create_nonce('wp_rest');
     $userId = isset($_GET['userId']) ? $_GET['userId'] : null;
     $email = isset($_GET['email']) ? $_GET['email'] : null;
     $embedToken = isset($_GET['embedToken']) ? $_GET['embedToken'] : null;
     $step = isset($_GET['step']) ? $_GET['step'] : null;
	?>
		<script type="text/javascript">
            const wpNonce = '<?php echo $nonce ?>'

			jQuery(document).ready(function() {
				jQuery( '#hs_disconnect' ).on('click', function() {
					disconnectAccount();
				});

				jQuery( '#hs-reconnect' ).on('click', function() {
					connectAccount();
				});

				jQuery( '#hs-connect' ).on('click', function() {
					connectAccount();
				});

				jQuery( '#hs-create-account' ).on('click', function() {
					createAccount();
				});
			});

      const step = '<?php echo esc_js($step) ?>';
      const userId = '<?php echo esc_js($userId) ?>';
      const email = '<?php echo esc_js($email) ?>';
      const accessToken = '<?php echo esc_js($embedToken) ?>';

      if (userId && email && accessToken && step === 'accountsetup') {
          jQuery.ajax({
            url: '<?php echo esc_url_raw( get_rest_url( null, "cos_headline_studio/v1/connect_account_handler?userId=" . $userId . "&email=" . $email . "&embedToken=" . $embedToken ) ); ?>',
            method: 'GET',
            beforeSend: function (xhr) {
              xhr.setRequestHeader('X-WP-Nonce', wpNonce);
            },
            success: function() {
              location.href = '<?php echo esc_url_raw( get_admin_url( null, "options-general.php?page=headline-studio-settings&step=authconnectsuccess") ); ?>';
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log('Error:', textStatus, errorThrown);
            }
          });
      }

			function disconnectAccount() {
                jQuery.ajax({
                    url: '<?php echo esc_url_raw( get_rest_url( null, 'cos_headline_studio/v1/disconnect_account' ) ); ?>',
                    method: 'GET',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-WP-Nonce', wpNonce);
                    },
                    success: function(data) {
                        location.reload();
                    }
                });
			}


			function connectAccount() {
				const connectionType = 'hs_wp';
				const connectionSource = '<?php echo parse_url( get_site_url(), PHP_URL_HOST ); ?>';
				const connectAccountUri = '<?php echo esc_url_raw( get_admin_url( null, "options-general.php?page=headline-studio-settings&step=accountsetup") ); ?>';
        const encodedUri = encodeURIComponent(connectAccountUri);
				const url = `https://headlines.coschedule.com/oauth/connect?connectionType=${connectionType}&connectionSource=${connectionSource}&redirectUri=${encodedUri}`;
				openConnectCreateModal(url);
      }

			function createAccount() {
				const baseUrl = 'https://coschedule.com/headline-studio-plugin-signup?wordpress-plugin=true';
				new jQuery.oauthpopup({
					path: baseUrl,
					windowOptions: 'width=700,height=800',
					callback: () => connectAccount(),
				});
			}

			function openConnectCreateModal(url) {
				const currentContextLocation = location; // so the popup can refresh the settings page after auth
				new jQuery.oauthpopup({
					path: url,
					windowOptions: 'width=700,height=800',
					callback: () => {
                        jQuery.ajax({
                             url: '<?php echo esc_url_raw( get_rest_url( null, 'cos_headline_studio/v1/set_onboarded?is_onboarded=false' ) ); ?>',
                            method: 'GET',
                            beforeSend: function (xhr) {
                                xhr.setRequestHeader('X-WP-Nonce', '<?php echo $nonce; ?>');
                            },
                            success: function(response) {
                                location.reload();
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log('Error:', textStatus, errorThrown);
                            }
                        })
					},
				});
			}
		</script>
	<?php
}

add_action( 'admin_footer', 'cos_headlinestudio_handle_account_click_actions');

/**
 * Renders the appropriate settings or onboarding page depending on current state
 */
function cos_headlinestudio_settings_page() {
	if ( isset( $_GET['step']) && $_GET['step'] === 'authconnectsuccess' ){
		include 'auth/success.php';
		return;
	} elseif ( get_option( 'cos_headlinestudio_is_onboarded' ) ) {
		?>
		<div class="headline-studio-settings">
			<div class="settings-container">
			<div class="main">
				<?php
					echo '<img class="logo" src="' . esc_attr( HEADLINE_STUDIO_PLUGIN_URL ) . 'assets/img/hs-logo-full-color.svg" alt="Headline Studio Logo">'
				?>

				<?php if ( cos_headlinestudio_is_connected() ) : ?>
				<h4>Connected Account</h4>

				<div class="connected-account">
					<div class="connection-settings">
						<div class="information">
							<h5 title="<?php echo esc_js( get_option('cos_headlinestudio_user_email') ); ?>">
								<?php
								echo esc_js( get_option('cos_headlinestudio_user_email', '') );
								?>
							</h5>
							<span>
								<?php echo esc_js( 'Connected on ' . gmdate( 'F j\, Y', intval( cos_headlinestudio_connected_on() ) ) ); ?>
							</span>
					</div>
					<div class="actions">
						<button id="hs-reconnect" class="hs-wp-button flat">Reconnect</button>
						<button id="hs_disconnect" type="button" class="hs-wp-button flat red">Disconnect</button>
					</div>
				</div>

				</div>
			<?php else : ?>
				<h4>No Account Connected</h4>

				<button id="hs-connect" type="button" class="connect-btn hs-wp-button blue">Connect An Account</button>
			<?php endif; ?>

			<a href="https://headlines.coschedule.com/" target="_blank" rel="noopener noreferrer">Open Headline Studio
				App</a>
			</div>

			<div class="help">
			<h4>Need Some Help?</h4>

			<p>Here are a few articles to help you use your new Headline Studio account and WordPress plugin.</p>

			<a href="https://coschedule.com/support/content-creation/headline-studio/wordpress-plugin"
				target="_blank" rel="noopener noreferrer">How to Use the Headline Studio WordPress Plugin</a>
			<a href="https://coschedule.com/support/content-creation/headline-studio/how-to-use-headline-studio"
				target="_blank" rel="noopener noreferrer">How to Use Headline Studio</a>
			<a href="https://coschedule.com/support/content-creation/headline-studio/how-to-manage-your-headline-studio-subscription"
				target="_blank" rel="noopener noreferrer">How to Manage Your Headline Studio Subscription</a>
			<a href="https://coschedule.com/support/content-creation/headline-studio/headline-studio-faqs"
				target="_blank" rel="noopener noreferrer">Headline Studio FAQs</a>
			</div>
		</div>
	</div>
		<?php
	} else {
		cos_headlinestudio_show_onboarding();
	}
}

/**
 * Registers and enqueue the custom columns style sheet
 *
 * @return void
 */
function cos_headlinestudio_register_hs_admin_settings() {
	if ( defined( 'HEADLINE_STUDIO_PLUGIN_URL' ) ) {
		wp_register_style( 'cos-headlinestudio-hs_admin_settings', HEADLINE_STUDIO_PLUGIN_URL . 'assets/css/hs-admin-settings.css' );
		wp_register_style( 'cos-headlinestudio-hs_base', HEADLINE_STUDIO_PLUGIN_URL . 'assets/css/base.css' );
		wp_enqueue_style( 'cos-headlinestudio-hs_admin_settings' );
		wp_enqueue_style( 'cos-headlinestudio-hs_base' );
		wp_enqueue_script( 'cos-headline-auth_popup', HEADLINE_STUDIO_PLUGIN_URL . 'assets/js/oauth-popup.js', array( 'jquery' ) );
	}
}
add_action( 'admin_enqueue_scripts', 'cos_headlinestudio_register_hs_admin_settings' );


