<?php
/**
 * For activation or deactivation of plugin.
 *
 * @package WS Theme Addons
 */

/**
 * WS Theme Addons install class.
 */
class WS_Theme_Addons_Install {

	/**
	 * Constructor.
	 */
	function __construct() {
		register_deactivation_hook( WS_THEME_ADDONS_PLUGIN_FILE, array( $this, 'deactivate' ) );
	}

	/**
	 * Deactivation callback.
	 */
	function deactivate() {
		do_action( 'ws_theme_addons_deactivated' );
	}
}

new WS_Theme_Addons_Install();
