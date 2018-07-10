<?php
/**
 * Demo Importer Class.
 *
 * @package WS Theme Addons
 */

/**
 * WS Theme Addons install class.
 */
class WS_Theme_Addons_Import_Demo_Data {

	/**
	 * Constructor.
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'includes' ) );

		add_action( 'wp_ajax_ws-theme-addons-demo-import-action', array( 'WS_Theme_Addons_Import_Demo_Data', 'demo_import_ajax_handler' ) );

		add_filter( 'wensol_widget_demo_import_settings', array( $this, 'update_widget_data' ) );

		add_filter( 'wensol_customizer_demo_import_settings', array( $this, 'update_customizer_data' ), 10, 2 );
	}
	/**
	 * Include required core files.
	 */
	public function includes() {
		include_once sprintf( '%s/inc/importers/customizer-import/class-customizer-importer.php', WS_THEME_ADDONS_ABSPATH );
		include_once sprintf( '%s/inc/importers/class-widget-importer.php', WS_THEME_ADDONS_ABSPATH );

		$config_file = self::import_file_path( 'dummy-config.php' );

		if ( is_file( $config_file ) ) :

			include_once sprintf( '%s/dummy-data/dummy-config.php', WS_THEME_ADDONS_ABSPATH );

		endif;
	}
	/**
	 * Get the import file path.
	 *
	 * @return string the import data file path.
	 */
	private static function import_file_path( $filename ) {

		$working_dir = WS_THEME_ADDONS_ABSPATH . '/dummy-data';

		return trailingslashit( $working_dir ) . sanitize_file_name( $filename );
	}
	/**
	 * Import dummy content from a XML file.
	 * @param  array  $status
	 * @return bool
	 */
	public static function import_dummy_xml( $import_file ) {

		// Load Importer API.
		require_once ABSPATH . 'wp-admin/includes/import.php';

		if ( ! class_exists( 'WP_Importer' ) ) {
			$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';

			if ( file_exists( $class_wp_importer ) ) {
				require $class_wp_importer;
			}
		}

			// Include WXR Importer.
			require( dirname( __FILE__ ) . '/importers/wordpress-importer/class-wxr-importer.php' );

		// Import XML file demo content.
		if ( is_file( $import_file ) ) {
			$wp_import = new WS_WXR_Importer();
			$wp_import->fetch_attachments = true;

			ob_start();
			$wp_import->import( $import_file );
			ob_end_clean();

			flush_rewrite_rules();
		} else {
			$status['errorMessage'] = __( 'The XML file dummy content is missing.', 'ws-theme-addons' );
			
			$status['file'] = $import_file;
			
			wp_send_json_error( $status );
		}

		return true;

	}
	/**
	 * Import site core options from its ID.
	 *
	 * @param  array  $demo_data.
	 * @return bool
	 */
	public static function import_core_options() {

		$import_file = self::import_file_path( 'dummy-customizer.json' );

		$demo_data = json_decode( file_get_contents( $import_file ) , true );

		if ( ! empty( $demo_data['core_options'] ) ) {
			foreach ( $demo_data['core_options'] as $option_key => $option_value ) {
				if ( ! in_array( $option_key, array( 'blogname', 'blogdescription', 'show_on_front', 'page_on_front', 'page_for_posts' ) ) ) {
					continue;
				}

				// Format the value based on option key.
				switch ( $option_key ) {
					case 'show_on_front':
						if ( in_array( $option_value, array( 'posts', 'page' ) ) ) {
							update_option( 'show_on_front', $option_value );
						}
					break;
					case 'page_on_front':
					case 'page_for_posts':
						$page = get_page_by_title( $option_value );

						if ( is_object( $page ) && $page->ID ) {
							update_option( $option_key, $page->ID );
							update_option( 'show_on_front', 'page' );
						}
					break;
					default:
						update_option( $option_key, sanitize_text_field( $option_value ) );
					break;
				}
			}
		}

		return true;
	}
	/**
	 * Import customizer Values.
	 * 
	 * @return void
	 */
	public static function import_customizer_values() {

		$data = self::import_file_path( 'dummy-customizer.json' );

		if ( is_file( $data ) ) {

			$results = WS_Customizer_Importer::import( $data );

			if ( is_wp_error( $results ) ) {
				return false;
			}
		} else {
			$status['errorMessage'] = __( 'The customizer data JSON file is missing.', 'ws-theme-addons' );
			wp_send_json_error( $status );
		}
		return true;

	}
	/**
	 * Import widgets settings from WIE or JSON file.
	 * @param  array  $status
	 * @return bool
	 */
	public static function import_widget_settings( $status = array() ) {

		$import_file = self::import_file_path( 'dummy-widget.json' );

		if ( is_file( $import_file ) ) {

			$results = WS_Widget_Importer::import( $import_file );

			if ( is_wp_error( $results ) ) {
				return false;
			}
		} else {
			$status['errorMessage'] = __( 'The JSON file widget content is missing.', 'ws-theme-addons' );
			wp_send_json_error( $status );
		}

		return true;
	}
	/**
	 * Ajax Handler
	 *
	 * @return string data.
	 */
	public static function demo_import_ajax_handler( $status = array() ) {

		if ( ! current_user_can( 'manage_options' ) ) {
			$status['errorMessage'] = __( 'Sorry, you are not allowed to import.', 'ws-theme-addons' );
			wp_send_json_error( $status );
		}

		if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
			define( 'WP_LOAD_IMPORTERS', true );
		}

		$import_file = self::import_file_path( 'dummy-content.xml' );

		if ( ! empty( $import_file ) ) {

			/**
			 * Hook : ws_theme_addons_ajax_before_demo_import
			 *
			 * Clear data befor demo import.
			 *
			 * @hooked : ws_theme_addons_reset_widgets -10
			 * @hooked : ws_theme_addons_delete_nav_menus -20
			 * @hooked : ws_theme_addons_remove_theme_mods -30
			 * 
			 */
			do_action( 'ws_theme_addons_ajax_before_demo_import' );
			
			//Defining Blank Status array.
			$status = array();

			// Import Dummy XML Data.
			self::import_dummy_xml( $import_file );

			// Import Core Options.
			self::import_core_options();

			// Import customizer values.
			self::import_customizer_values();

			// Import customizer values.
			self::import_widget_settings();

		}

		// On Success, Add Priview URL.
		$status['previewUrl'] = esc_url( get_home_url( '/' ) );

		wp_send_json_success( $status );

	}

	/**
	 * Update customizer settings data.
	 * @param  array $data
	 * @param  array $demo_data
	 * @return array
	 */
	public function update_customizer_data( $demo_data ) {

		if ( ! empty( $demo_data['customizer_data_update'] ) ) {
			foreach ( $demo_data['customizer_data_update'] as $data_type => $data_value ) {

				// if ( ! in_array( $data_type, array( 'pages', 'categories', 'nav_menu_locations' ) ) ) {
				// 	continue;
				// }
				// Format the value based on data type.
				switch ( $data_type ) {
					case 'pages':
						foreach ( $data_value as $option_key => $option_value ) {
							if ( ! empty( $demo_data['mods'][ $option_key ] ) ) {
								$page = get_page_by_title( $option_value );
								if ( is_object( $page ) && $page->ID ) {
									$demo_data['mods'][ $option_key ] = $page->ID;
								}
							}
						}
					break;
					case 'categories':
						foreach ( $data_value as $option_key => $option_data ) {

							foreach ( $option_data as $key => $taxonomy ) {

								if ( ! term_exists( $taxonomy, $tax = 'category' ) ) {
									continue;
								}

								if ( ! empty( $demo_data['mods'][ $option_key ] ) ) {

									$term = get_term_by( 'name', $taxonomy, $tax="category" );

									if ( is_object( $term ) && $term->term_id ) {

										$demo_data['mods'][ $option_key ][$key] = $term->term_id;

									}
								}
							}
						}
					break;
					case 'nav_menu_locations':
						$nav_menus = wp_get_nav_menus();

						if ( ! empty( $nav_menus ) ) {
							foreach ( $nav_menus as $nav_menu ) {
								if ( is_object( $nav_menu ) ) {
									foreach ( $data_value as $location => $location_name ) {
										if ( $nav_menu->name == $location_name ) {
											$demo_data['mods'][ $data_type ][ $location ] = $nav_menu->term_id;
										}
									}
								}
							}
						}
					break;
				}
			}
		}

		return $demo_data;
	}
	/**
	 * Updates widgets settings data.
	 * @param  array  $widget
	 * @param  string $widget_type
	 * @param  int    $instance_id
	 * @param  array  $demo_data
	 * @return array
	 */
	public function update_widget_data( $widget, $widget_type, $instance_id ) {
		if ( 'nav_menu' == $widget_type ) {
			$nav_menu = wp_get_nav_menu_object( $widget['title'] );

			if ( is_object( $nav_menu ) && $nav_menu->term_id ) {
				$widget['nav_menu'] = $nav_menu->term_id;
			}
		} elseif ( ! empty( $demo_data['widgets_data_update'] ) ) {
			foreach ( $demo_data['widgets_data_update'] as $dropdown_type => $dropdown_data ) {
				if ( ! in_array( $dropdown_type, array( 'dropdown_pages', 'dropdown_categories' ) ) ) {
					continue;
				}

				// Format the value based on dropdown type.
				switch ( $dropdown_type ) {
					case 'dropdown_pages':
						foreach ( $dropdown_data as $widget_id => $widget_data ) {
							if ( ! empty( $widget_data[ $instance_id ] ) && $widget_id == $widget_type ) {
								foreach ( $widget_data[ $instance_id ] as $widget_key => $widget_value ) {
									$page = get_page_by_title( $widget_value );

									if ( is_object( $page ) && $page->ID ) {
										$widget[ $widget_key ] = $page->ID;
									}
								}
							}
						}
					break;
					case 'dropdown_categories':
						foreach ( $dropdown_data as $taxonomy => $taxonomy_data ) {
							if ( ! taxonomy_exists( $taxonomy ) ) {
								continue;
							}

							foreach ( $taxonomy_data as $widget_id => $widget_data ) {
								if ( ! empty( $widget_data[ $instance_id ] ) && $widget_id == $widget_type ) {
									foreach ( $widget_data[ $instance_id ] as $widget_key => $widget_value ) {
										$term = get_term_by( 'name', $widget_value, $taxonomy );

										if ( is_object( $term ) && $term->term_id ) {
											$widget[ $widget_key ] = $term->term_id;
										}
									}
								}
							}
						}
					break;
				}
			}
		}

		return $widget;
	}

}

new WS_Theme_Addons_Import_Demo_Data();
