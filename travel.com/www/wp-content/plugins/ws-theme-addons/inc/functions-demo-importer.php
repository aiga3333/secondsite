<?php
/**
 * Demo Importer Functions.
 *
 * @package WS Theme Addons
 */

/**
 * Clear data before demo import AJAX action.
 *
 * @see ws_theme_addons_reset_widgets()
 * @see ws_theme_addons_delete_nav_menus()
 * @see ws_theme_addons_remove_theme_mods()
 */
if ( apply_filters( 'ws_theme_addons_clear_data_before_demo_import', true ) ) {
	add_action( 'ws_theme_addons_ajax_before_demo_import', 'ws_theme_addons_reset_widgets', 10 );
	add_action( 'ws_theme_addons_ajax_before_demo_import', 'ws_theme_addons_delete_nav_menus', 20 );
	add_action( 'ws_theme_addons_ajax_before_demo_import', 'ws_theme_addons_remove_theme_mods', 30 );
}

/**
 * Reset existing active widgets.
 */
function ws_theme_addons_reset_widgets() {
	$sidebars_widgets = wp_get_sidebars_widgets();

	// Reset active widgets.
	foreach ( $sidebars_widgets as $key => $widgets ) {
		$sidebars_widgets[ $key ] = array();
	}

	wp_set_sidebars_widgets( $sidebars_widgets );
}

/**
 * Delete existing navigation menus.
 */
function ws_theme_addons_delete_nav_menus() {
	$nav_menus = wp_get_nav_menus();

	// Delete navigation menus.
	if ( ! empty( $nav_menus ) ) {
		foreach ( $nav_menus as $nav_menu ) {
			wp_delete_nav_menu( $nav_menu->slug );
		}
	}
}

/**
 * Remove theme modifications option.
 */
function ws_theme_addons_remove_theme_mods() {
	remove_theme_mods();
}
