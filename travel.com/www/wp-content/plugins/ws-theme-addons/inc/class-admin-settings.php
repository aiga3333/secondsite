<?php
/**
 * Admin Settings page for the Plugin.
 *
 * @package WS Theme Addons
 */

/**
 * WS Theme Addons admin settings class.
 */
class WS_Theme_Addons_Admin_Settings {

	/**
	 * Constructor.
	 */
	function __construct() {
		add_action( 'admin_menu', array( 'WS_Theme_Addons_Admin_Settings', 'register_menu_page' ) );
		add_action( 'admin_enqueue_scripts', array( 'WS_Theme_Addons_Admin_Settings', 'enqueue_scripts' ) );
	}
	/**
	 * Register theme settings page
	 *
	 * @return void
	 */
	public static function register_menu_page() {

		add_theme_page( esc_html__( 'Theme Options','ws-theme-addons' ),esc_html__( 'Theme Options','ws-theme-addons' ),'manage_options','ws-theme-addons',array( 'WS_Theme_Addons_Admin_Settings', 'load_admin_page' ) );
	}
	/**
	 * Load Admin page Template.
	 *
	 * @return void
	 */
	public static function load_admin_page() {
		include sprintf( '%s/inc/admin/templates/settings-page.php', WS_THEME_ADDONS_ABSPATH );
	}
	/**
	 * Enqueue Styles.
	 *
	 * @return void
	 */
	public static function enqueue_scripts() {
		wp_enqueue_style( 'ws-theme-addons-admin-theme-options-css', plugin_dir_url( WS_THEME_ADDONS_PLUGIN_FILE ) . '/assets/admin/css/admin.css' );

		$screen = get_current_screen();
		// Tab for settings page.
		if ( 'appearance_page_ws-theme-addons' == $screen->id ) {
			
			wp_enqueue_script( 'jquery-ui-tabs', array('jquery') );

			wp_enqueue_style( 'limonate-sweetalert-css',  plugin_dir_url( WS_THEME_ADDONS_PLUGIN_FILE ) . '/assets/admin/css/sweetalert-css.css' );
			
			wp_enqueue_script( 'limonate-sweetalert-js',  plugin_dir_url( WS_THEME_ADDONS_PLUGIN_FILE ) . '/assets/admin/js/sweetalert-js.js', array( 'jquery' ), true );
		
			wp_register_script( 'ws-theme-addons-admin-theme-options-js', plugin_dir_url( WS_THEME_ADDONS_PLUGIN_FILE ) . '/assets/admin/js/admin.js', array( 'jquery' ), '', true );

			$ajax_url = admin_url() . '/admin-ajax.php';

			$data_array = array( 'url' => $ajax_url );

			$data_array['strings']['swal'] = array(

				'title' => __( 'Are you sure?', 'ws-theme-addons' ),
				'text' => __( 'Importing demo will import posts, pages and media files.It will clear all of your Theme Settings, Widgets and Nav menu Options', 'ws-theme-addons' ),
				'cancel_text' => __( 'Demo Import Cancelled !', 'ws-theme-addons' ),

			);

			wp_localize_script( 'ws-theme-addons-admin-theme-options-js','ws_theme_addons_admin', $data_array );

			wp_enqueue_script( 'ws-theme-addons-admin-theme-options-js' );
		
		}

	}
}

new WS_Theme_Addons_Admin_Settings();
