<?php
namespace WPWhiteLabel;
/**
 * Upgrade Control
 */
if ( class_exists( 'WP_Customize_Control' ) ) :

	/**
	 * Displays the upgrade message .
	 */
	class ProControl extends WP_Customize_Control {
		/**
		 * Render Control
		 */
		public function render_content() {
			?>

			<div class="upgrade-pro-version">

				<span class="customize-control-title"><?php esc_html_e( 'Pro Version Add-on', 'whitelabel-login' ); ?></span>

				<span class="textfield">
					<?php printf( esc_html__( 'Purchase the %s Add-on to get additional features and advanced customization options.', 'whitelabel-login' ), 'White Label Login Pro' ); ?>
				</span>

				<p>
					<a href="<?php echo esc_url( __( 'https://whitelabelwp.net/add-ons/whitelabel-login-pro/', 'whitelabel-login' ) ); ?>" target="_blank" class="button button-secondary">
						<?php printf( esc_html__( 'Learn more about %s', 'whitelabel-login' ), 'White Label Login Pro' ); ?>
					</a>
				</p>

			</div>

			<?php
		}
	}

endif;
