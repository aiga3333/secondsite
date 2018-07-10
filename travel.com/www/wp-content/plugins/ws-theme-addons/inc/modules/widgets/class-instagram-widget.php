<?php
/**
 * Instagram Widget / Images
 *
 * @package WS Theme Addons
 */

if ( ! class_exists( 'WS_Theme_Addons_Instagram_Widget' ) ) :
	/**
	 * Instragram Widget Main class.
	 *
	 */
	class WS_Theme_Addons_Instagram_Widget extends WP_Widget {

		/**
		 * Holds widget settings defaults, populated in constructor.
		 *
		 * @var array
		 */
		protected $defaults;

		/**
		 * Constructor. Set the default widget options and create widget.
		 *
		 */
		function __construct() {
			$this->defaults = array(
				'title'    => __( 'Instagram Photos', 'ws-theme-addons' ),
				'username' => '',
				'layout'   => 'three-columns',
				'number'   => 6,
				'target'   => 1,
				'link'     => 'follow us',
			);

			$ws_theme_addons_instagram = array(
				'classname'   => 'ws_theme_addons_instagram widget_instagram clearfix',
				'description' => __( 'Display Your Instagram Photos in Widget Locations', 'ws-theme-addons' ),
			);

			$ws_theme_addons_custom_control_instagram = array(
				'id_base' => 'ws-theme-addons-custom-instagram',
			);

			parent::__construct(
				'ws-theme-addons-custom-instagram', // Base ID
				__( 'WS Instagram Widget', 'ws-theme-addons' ), // Name.
				$ws_theme_addons_instagram,
				$ws_theme_addons_custom_control_instagram
			);
		}
		/**
		 * Widget Form Function.
		 *
		 * @param array $instance Instance.
		 * @return void
		 */
		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, $this->defaults );

			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title', 'ws-theme-addons' ); ?>:</label>
				<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php esc_html_e( 'Instagram Username', 'ws-theme-addons' ); ?>:</label>
				<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" value="<?php echo esc_attr( $instance['username'] ); ?>" class="widefat" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>"><?php esc_html_e( 'Display Layout', 'ws-theme-addons' ); ?>:</label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>" class="widefat">
					<?php
						$post_type_choices = array(
							'two-columns'   => __( '2 Column', 'ws-theme-addons' ),
							'three-columns' => __( '3 Column', 'ws-theme-addons' ),
							'full-width' 	=> __( 'Full Width', 'ws-theme-addons' ),
						);

					foreach ( $post_type_choices as $key => $value ) {
						echo '<option value="' . esc_attr( $key ) . '" ' . selected( $key, $instance['layout'], false ) . '>' . esc_html( $value ) . '</option>';
					}
					?>
				</select>
				<span class="info-msg"><strong><em><?php esc_html_e( 'Note: ','ws-theme-addons' ); ?></em><?php esc_html_e( 'Full Width Layout displays images in 6 columns', 'ws-theme-addons' ); ?></strong></span>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of photos to show', 'ws-theme-addons' ); ?>:</label>
				<input type="number" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" value="<?php echo absint( $instance['number'] ); ?>" class="small-text" min="1" max="12" />
			</p>

			<p>
				<input class="checkbox" type="checkbox" <?php checked( $instance['target'] ) ?> id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" />
				<label for="<?php echo esc_attr( $this->get_field_id('target' ) ); ?>"><?php _e( 'Check to Open Image / Link in new Tab/Window', 'ws-theme-addons' ); ?></label><br />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php _e( 'Follow Link text', 'ws-theme-addons' ); ?>:
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['link'] ); ?>" /></label></p>
			<?php

		}
		/**
		 * Update Widget
		 *
		 * @param array $new_instance New instance.
		 * @param array $old_instance Old Instance.
		 * @return array $instance Modified Instance.
		 */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title']    = sanitize_text_field( $new_instance['title'] );
			$instance['username'] = sanitize_text_field( $new_instance['username'] );
			$instance['layout']   = sanitize_key( $new_instance['layout'] );
			$instance['number']   = absint( $new_instance['number'] );
			$instance['target']   = ! empty( $new_instance['target'] ) ? 1 : 0;
			$instance['link']     = strip_tags( $new_instance['link'] );

			return $instance;
		}
		/**
		 * Widget Render
		 *
		 * @param array $args Arguments Array.
		 * @param array $instance WidgetInstance.
		 * @return void
		 */
		function widget( $args, $instance ) {
			// Merge with defaults.
			$instance = wp_parse_args( (array) $instance, $this->defaults );

			echo $args['before_widget'];

			// Set up the author bio.
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title'];
			}

			$username = empty( $instance['username'] ) ? '' : $instance['username'];
			$number   = empty( $instance['number'] ) ? 9 : $instance['number'];
			$link     = empty( $instance['link'] ) ? '' : $instance['link'];

			$target = '_self';

			if ( $instance['target'] ) {
				$target = '_blank';
			}

			if ( '' !== $username ) {

				$media_array = $this->scrape_instagram( $username, $number );

				if ( is_wp_error( $media_array ) ) {

					echo wp_kses_post( $media_array->get_error_message() );

				} else {
					// filter for images only?
					if ( $images_only = FALSE ) {
						$media_array = array_filter( $media_array, array( $this, 'images_only' ) );
					}
					?>
					<div class="widget-wrap">
			  			<?php $linkclass = 'clear';
			  			if ( '' !== $link ) { ?>
			  			<div class="follow-button">
							<a href="//instagram.com/<?php echo esc_attr( trim( $username ) ); ?>" class="btn btn-blue" target="<?php echo esc_attr( $target ); ?>"><i class="fa fa-instagram"></i><?php echo wp_kses_post( $link ); ?></a>
			  			</div>
			  			<?php } if ( isset( $media_array['images_meta'] ) ) : ?>
						<ul class="<?php echo esc_attr( $instance['layout'] ); ?>">
						<?php
						
						$thumbnail_index = 3;

						switch( $instance['layout'] ) {

							case 'three-columns':

								$thumbnail_index = 3;

							break;

							case 'two-columns':

								$thumbnail_index = 4;

							break;

							default :

								$thumbnail_index = 1;

							break;


						}
						
						foreach ( $media_array['images_meta'] as $item ) {
							echo '
							<li>
								<span class="insta-feed-img">
									<img src="' . esc_url( $item['thumbnails'][$thumbnail_index]['src'] ) . '"/>
								</span>
								<a class="fancybox" data-fancybox="gallery" href="' . esc_url( $item['src'] ) . '">
										<i class="fa fa-plus" aria-hidden="true"></i>
								</a>
								<a class="insta-profile" href="' . esc_url( '//instagram.com/p/'. $item['link'] ) . '" target="' . esc_attr( $target ) . '">
								<i class="fa fa-instagram" aria-hidden="true"></i>
								</a>
							</li>';
						}
						?>
						</ul>
					<?php endif; ?>
					</div>
				<?php
				}
			}
			echo $args['after_widget'];
		}

		// based on https://gist.github.com/cosmocatalano/4544576.
		/**
		 * Scrape_instagram
		 *
		 * @param string  $username Username.
		 * @param integer $slice Slice.
		 * @return void
		 */
		function scrape_instagram( $username, $slice = 9 ) {
			$username = strtolower( $username );
			$username = str_replace( '@', '', $username );

			if ( false === ( $instagram = get_transient( 'instagram-a' . absint( $slice ) . '-' . sanitize_title_with_dashes( $username ) ) ) ) {

				$remote = wp_remote_get( 'http://instagram.com/' . trim( $username ) );

				if ( is_wp_error( $remote ) ) {
					return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'ws-theme-addons' ) );
				}

				if ( 200 != wp_remote_retrieve_response_code( $remote ) ) {
					return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'ws-theme-addons' ) );
				}

				$shards      = explode( 'window._sharedData = ', $remote['body'] );
				$insta_json  = explode( ';</script>', $shards[1] );
				$insta_array = json_decode( $insta_json[0], TRUE );

				
				if ( ! $insta_array ) {
					return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'ws-theme-addons' ) );
				}
				
				$nodes = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];

				$images = array();

				foreach( $nodes as $key => $node ) {

					$images[$key]['src'] = $nodes[$key]['node']['display_url'];
					$images[$key]['link'] = $nodes[$key]['node']['shortcode'];
					$images[$key]['thumbnails'] = $nodes[$key]['node']['thumbnail_resources'];

				}

				if ( ! is_array( $images ) && '' === $images ) {

					return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'ws-theme-addons' ) );

				}		
				
				if( isset( $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['profile_pic_url'] ) ){ 
					$proifle_pic_url = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['profile_pic_url'];
				}
				if ( isset( $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['full_name'] ) ) {
					$full_name = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['full_name'];
				} else {
					$full_name = '';
				}

				if ( ! is_array( $images ) ) {
					return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'ws-theme-addons' ) );
				}

				$instagram = array( 'proifle_pic_url' => $proifle_pic_url, 'full_name' => $full_name );
				$instagram_images_meta = $images;

				if ( isset( $instagram_images_meta ) ) :
					$instagram_images_meta['images_meta'] = array_slice( $instagram_images_meta, 0, $slice );
					$instagram = array_merge( $instagram, $instagram_images_meta );

				endif;

				// do not set an empty transient - should help catch private or empty accounts.
				// if ( ! empty( $instagram ) ) {
				// 	set_transient( 'instagram-a3-' . sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'ws_theme_addons_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );
				// }

				delete_transient( 'instagram-a3-' . sanitize_title_with_dashes( $username ) );
			}

			if ( ! empty( $instagram ) ) {
				return $instagram;
			} else {

				return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'ws-theme-addons' ) );

			}
		}
		/**
		 * Images Only
		 *
		 * @param array $media_item Media Item.
		 * @return bool true/false.
		 */
		function images_only( $media_item ) {
			if ( $media_item['type'] == 'image' ) {
				return true;
			}

			return false;
		}
	}
endif;

if ( ! function_exists( 'ws_theme_addons_register_instagram_widget' ) ) :
	/**
	 * Registers the widget
	 *
	 * @since 1.0.0
	 */
	function ws_theme_addons_register_instagram_widget() {
		register_widget( 'WS_Theme_Addons_Instagram_Widget' );
	}

endif;

add_action( 'wp_enqueue_scripts', 'ws_theme_addons_instagram_widget_scripts' );
/**
 * Instagram Widget Scripts.
 *
 * @return void
 */
function ws_theme_addons_instagram_widget_scripts() {

	wp_enqueue_style( 'jquery-fancy-box-css', plugin_dir_url( WS_THEME_ADDONS_PLUGIN_FILE ) . 'assets/public/css/fancybox-css.css' );

	wp_enqueue_script( 'jquery-fancybox-instagram-js', plugin_dir_url( WS_THEME_ADDONS_PLUGIN_FILE ) . 'assets/public/js/fancybox-js.js', array( 'jquery' ), '', true );

}

add_action( 'widgets_init', 'ws_theme_addons_register_instagram_widget' );
