<?php
/**
 * Saves all admin settings for the plugin
 *
 * @package WS Theme Addons
 */

/**
 * WS Theme Addons save settings class.
 */
class WS_Theme_Addons_Save_Admin_Settings {

	/**
	 * Constructor.
	 */
	function __construct() {
		add_action( 'admin_post_ws_theme_addons_save_settings', array( 'WS_Theme_Addons_Save_Admin_Settings', 'save_data' ) ); // saves settings.
	}

	/**
	 * Sanitize settings data.
	 *
	 * @param array $data settings data.
	 */
	protected static function sanitize_data( $data ) {

		$sanitized_data = stripslashes_deep( $data );

		return $sanitized_data;

	}
	/**
	 * Save settings data.
	 */
	public static function save_data() {

		if (  isset( $_POST['action'] ) && 'ws_theme_addons_save_settings' == $_POST['action'] && wp_verify_nonce( $_POST['ws_theme_addons_settings_nonce_field'], 'ws-theme-addons-settings-nonce' ) ) {

			// Instagram Setting.
			$instagram_enable = ( isset( $_POST['ws_theme_addons_settings']['instagram_enable'] ) && '' !== $_POST['ws_theme_addons_settings']['instagram_enable'] ) ? 'yes' : 'no';

			$settings['instagram_enable'] = $instagram_enable;

			$sanitized_settings = self::sanitize_data( $settings );

			update_option( 'ws_theme_addons_admin_settings', $sanitized_settings );

			$redirect_url = admin_url( 'admin.php?page=ws-theme-addons&success=true' );

			wp_safe_redirect( $redirect_url );

			exit;

		} else {
			die( 'No script kiddies please!!' );
		}

	}
}

new WS_Theme_Addons_Save_Admin_Settings();
