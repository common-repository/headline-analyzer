<?php
/**
 * Final page of Onboarding
 *
 * @package Headline Studio
 */

defined( 'ABSPATH' ) || exit;

display_start_analyzing();

/**
 * Display the Start Analyzing onboarding page with the correct preferred experience info
 */
function display_start_analyzing() {
	$prefer_classic_experience = get_option( 'cos_headlinestudio_prefer_classic_experience', false );
	ob_start();
	render_preferred_experience( $prefer_classic_experience );
	render_action_section();
	ob_end_flush();
}

/**
 * Render classic or Gutenberg info page depending on the preferred experience
 *
 * @param bool $is_classic True when classic editor is preferred, false otherwise.
 */
function render_preferred_experience( $is_classic ) {
	return $is_classic ? render_classic_editor_page() : render_gutenberg_editor_page();
}

/**
 * Renders Gutenberg editor page info
 */
function render_gutenberg_editor_page() {
	?>
	<div class="content image-left">
		<picture>
			<?php echo '<img src="' . esc_attr( HEADLINE_STUDIO_PLUGIN_URL ) . '/assets/img/Gutenberg.png" alt="Analyze headlines right inside your post editor">'; ?>
		</picture>

		<div class="copy">
			<h3>Start Analyzing!</h3>
			<p>If you're using the Gutenberg Block Editor, access the Headline Studio plugin in your WordPress post by clicking the Headline Studio <?php echo '<img src="' . esc_attr( HEADLINE_STUDIO_PLUGIN_URL ) . '/assets/img/hs-icon-blue.svg" alt="Headline Studio Icon">'; ?> on the top toolbar.</p>

			<p>Simply click <i>Analyze</i> to see your score. When you've made changes to your title, click <i>Reanalyze</i> to create a new version with a new score.</p>

			<a id="hs-set-classic-editor" href="">See the Classic Editor experience</a>

			<div class="more-resources">
				<a href="https://coschedule.com/support/content-creation/headline-studio" target="blank" rel="noopener noreferrer">More Resources</a>
				<span class="separator"> | </span>
				<a href="https://headlines.coschedule.com/" target="blank" rel="noopener noreferrer">Headline Studio App</a>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Renders Classic editor page info
 */
function render_classic_editor_page() {
	?>
	<div class="content image-left">
		<picture>
			<?php echo '<img src="' . esc_attr( HEADLINE_STUDIO_PLUGIN_URL ) . '/assets/img/ClassicEditor.png" alt="Analyze headlines right inside your post editor">'; ?>
		</picture>

		<div class="copy">
			<h3>Start Analyzing!</h3>
			<p>If you’re using the Classic Editor, you can find the Headline Studio plugin in the publish box section of your WordPress post.</p>

			<p>When you’re ready to score your headline, click <i>analyze</i> and your full report will be available in the Headline Studio section.</p>

			<a id="hs-set-gutenberg-editor" href="">See the Gutenberg Block Editor experience</a>

			<div class="more-resources">
				<a href="https://coschedule.com/support/content-creation/headline-studio" target="blank" rel="noopener noreferrer">More Resources</a>
				<span class="separator"> | </span>
				<a href="https://headlines.coschedule.com/" target="blank" rel="noopener noreferrer">Headline Studio App</a>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Renders the footer buttons and actions
 */
function render_action_section() {
    $nonce = wp_create_nonce('wp_rest');
	?>
	<div class="actions multiple">
		<?php
		render_nav_button( 'seeyourscore', 'Go Back', 'outline' );
		?>
		<a id="hs-go-to-posts" href="<?php echo esc_url( get_admin_url() ) . 'edit.php'; ?>" class="hs-wp-button blue">Go To My Posts</a>
	</div>

	<script type="text/javascript">
        const wpNonce = '<?php echo $nonce ?>'

		jQuery( '#hs-go-to-posts' ).on('click', function() {
			jQuery.ajax({
                url: '<?php echo esc_url_raw( get_rest_url( null, 'cos_headline_studio/v1/set_onboarded?is_onboarded=true' ) ); ?>',
                method: 'GET',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-WP-Nonce', wpNonce);
                },
            })
		});

		jQuery( '#hs-set-gutenberg-editor' ).on('click', function() {
            jQuery.ajax({
                url: '<?php echo esc_url_raw( get_rest_url( null, 'cos_headline_studio/v1/set_preferred_editor?preferred_editor=gutenberg' ) ); ?>',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-WP-Nonce', wpNonce);
                },
                success: function(data) {
                    location.reload();
                }
            })
		});

		jQuery( '#hs-set-classic-editor' ).on('click', function() {
			jQuery.ajax({
                url: '<?php echo esc_url_raw( get_rest_url( null, 'cos_headline_studio/v1/set_preferred_editor?preferred_editor=classic' ) ); ?>',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-WP-Nonce', wpNonce);
                },
                success: function(data) { location.reload() }
            });
		});
	</script>
	<?php
}
