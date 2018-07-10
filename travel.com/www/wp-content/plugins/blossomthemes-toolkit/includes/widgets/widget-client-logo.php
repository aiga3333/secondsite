<?php
/**
 * Icon Text Widget
 *
 * @package Rttk_Pro
 */

// register Blossom_Client_Logo_Widget widget
function blossom_register_client_logo_widget(){
    register_widget( 'Blossom_Client_Logo_Widget' );
}
add_action('widgets_init', 'blossom_register_client_logo_widget');
 
 /**
 * Adds Blossom_Client_Logo_Widget widget.
 */
class Blossom_Client_Logo_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'blossom_client_logo_widget', // Base ID
            __( 'Blossom: Client Logo Widget', 'blossomthemes-toolkit' ), // Name
            array( 'description' => __( 'A Client Logo Widget.', 'blossomthemes-toolkit' ), ) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        
        $obj     = new BlossomThemes_Toolkit_Functions();
        $title   = ! empty( $instance['title'] ) ? $instance['title'] : '' ;
        $image   = ! empty( $instance['image'] ) ? $instance['image'] : '';
        $link    = ! empty( $instance['link'] ) ? $instance['link'] : '';
        $display_bw   = ! empty( $instance['display_bw'] ) ? $instance['display_bw'] : '' ;
        $class = '';
        if( isset($display_bw) && $display_bw!='' )
        {
            $class = " black-white";
        }
        echo $args['before_widget']; 
        ob_start();
        ?>
            <div class="blossom-iw-holder">
                <div class="blossom-iw-inner-holder">
                    <?php
                    if( $title ) echo $args['before_title'] . apply_filters( 'widget_title', $title, $instance, $this->id_base ) . $args['after_title'];
                    if( $image ){
                        $size = sizeof( $instance['image']);
                        $max = max(array_keys($instance['image']));
                        // print_r($instance['image']);
                        echo '<div class="blossom-inner-wrap">';
                        // for ($i=0; $i <= $max; $i++) {
                        foreach ($instance['image'] as $key => $value) {
                            if( isset( $instance['image'][$key] ) && $instance['image'][$key]!='' ){
                                
                                $image_id = $instance['image'][$key];

                                if ( !filter_var( $instance['image'][$key], FILTER_VALIDATE_URL ) === false ) {
                                    $image_id = $obj->bttk_get_attachment_id( $instance['image'][$key] );
                                }
                                // retrieve the thumbnail size of our image
                                $image_url = wp_get_attachment_image_src( $image_id, 'post-slider-thumb-size' );
                                if(!isset($image_url))
                                {
                                    $image_url = wp_get_attachment_image_src( $image_id, 'thumbnail' );
                                }
                                ?>
                                <div class="image-holder<?php echo esc_attr( $class ); ?>">
                                    <?php
                                    if( isset($instance['link'][$key]) && $instance['link'][$key]!='' )
                                    { ?>
                                        <a href="<?php echo esc_url($instance['link'][$key]);?>" target="_blank">
                                    <?php
                                    }
                                    echo '<img src="'.esc_url($image_url[0]).'" alt="'.esc_attr( $title ).'" />';
                                    if( isset($instance['link'][$key]) && $instance['link'][$key]!='' )
                                    {
                                    echo '</a>';                                
                                    }
                                    ?> 
                                </div>
                                <?php
                            }
                        }
                        echo '</div>';                        
                    }
                    ?>  
                </div>
            </div>
        <?php
        $html = ob_get_clean();
        echo apply_filters( 'blossom_companion_iw', $html, $args, $title,  $image, $link );   
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $obj     = new BlossomThemes_Toolkit_Functions();
        $title   = ! empty( $instance['title'] ) ? $instance['title'] : '' ;
        $display_bw   = ! empty( $instance['display_bw'] ) ? $instance['display_bw'] : '' ;
        $image   = ! empty( $instance['image'] ) ? $instance['image'] : '';
        $link    = ! empty( $instance['link'] ) ? $instance['link'] : '';
        ?>
        <script type='text/javascript'>
            jQuery(document).ready(function($) {
                $('.widget-client-logo-repeater').sortable({
                    cursor: 'move',
                    update: function (event, ui) {
                        $('.widget-client-logo-repeater .link-image-repeat input').trigger('change');
                    }
                });
                $('.check-btn-wrap').on('click', function( event ){
                    $(this).trigger('change');
                });
            });
        </script>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'blossomthemes-toolkit' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />            
        </p>
        
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'display_bw' ) ); ?>" class="check-btn-wrap">
                <input id="<?php echo esc_attr( $this->get_field_id( 'display_bw' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'display_bw' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $display_bw ); ?>/>
                <?php esc_html_e( 'Display logo in black and white', 'blossomthemes-toolkit' ); ?>
            </label>
        </p>

        <div class="widget-client-logo-repeater" id="<?php echo esc_attr( $this->get_field_id( 'blossomcompanion-logo-repeater' ) ); ?>">
            <p>
            <?php 
            if(isset($instance['link'])){
                foreach ( $instance['link'] as $key => $value) { ?>
                    <div class="link-image-repeat"><span class="cross"><a href="javascript:void(0);"><i class="fa fa-times"></i></a></span>
                    <?php $obj->bttk_get_image_field( $this->get_field_id( 'image['.$key.']' ), $this->get_field_name( 'image['.$key.']' ),  $instance['image'][$key], __( 'Upload Image', 'blossomthemes-toolkit' ) ); ?>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'link['.$key.']' ) ); ?>"><?php esc_html_e( 'Featured Link', 'blossomthemes-toolkit' ); ?></label> 
                    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link['.$key.']' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link['.$key.']' ) ); ?>" type="text" value="<?php echo esc_url( $value ); ?>" />            
                    
                    </div>
                <?php 
                }
            }
            ?>
            </p>
        <span class="cl-repeater-holder"></span>
        </div>
        <button class="add-logo button"><?php _e('Add Another Logo','blossomthemes-toolkit');?></button>
    <?php
    }
    
    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title']   = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '' ;
        $instance['display_bw']   = ! empty( $new_instance['display_bw'] ) ? sanitize_text_field( $new_instance['display_bw'] ) : '' ;
        
        foreach ( $new_instance['image'] as $key => $value ) {
            $instance['image'][$key]   = $value;
        }

        foreach ( $new_instance['link'] as $key => $value ) {
            $instance['link'][$key]    = $value;
        }

        return $instance;
    }
    
}  // class Blossom_Client_Logo_Widget