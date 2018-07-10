<?php
/**
 * Functions for configuring demo importer.
 *
 * @author   WEN Solutions
 * @category Admin
 * @package  Importer/Functions
 * @version  0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Setup demo importer config.
 *
 * @param  array $demo_data Demo data file.
 * @return array $demo_data Modified Demo data.
 */
function travel_log_demo_importer_config( $demo_data, $new_demo_config ) {
	$new_demo_config = array(

		'customizer_data_update' => array(

			'categories' => array(

				'post_filter_category' => array(

					'0' => 'France',
					'1' => 'Nepal',
					'2' => 'Thailand',

				),
			),

			'pages' => array(

				'call_to_action_content_page' => 'THIS VACATION BELONGS TO YOU',

			),
		),
	);

	return array_merge( $demo_data, $new_demo_config );

}

add_filter( 'ws_theme_addons_demo_config', 'travel_log_demo_importer_config', 10, 2 );

