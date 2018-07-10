<?php
/**
 * Widget Recent Post
 *
 * @package Bttk
 */
 
// register Bttk_Recent_Post widget
function bttk_register_recent_post_widget() {
    register_widget( 'Bttk_Recent_Post' );
}
add_action( 'widgets_init', 'bttk_register_recent_post_widget' );
 
 /**
 * Adds Bttk_Recent_Post widget.
 */
class Bttk_Recent_Post extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'bttk_pro_recent_post', // Base ID
            __( 'Blossom: Recent Post', 'blossomthemes-toolkit' ), // Name
            array( 'description' => __( 'A Recent Post Widget', 'blossomthemes-toolkit' ), ) // Args
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
        $title      = ! empty( $instance['title'] ) ?  $instance['title'] : __( 'Recent Posts', 'blossomthemes-toolkit' );
        $num_post   = ! empty( $instance['num_post'] ) ? $instance['num_post'] : 3 ;
        $show_thumb = ! empty( $instance['show_thumbnail'] ) ? $instance['show_thumbnail'] : '';
        $show_date  = ! empty( $instance['show_postdate'] ) ? $instance['show_postdate'] : '';
        $cats[]     = '';
        $cat        = apply_filters( 'bttk_pro_exclude_categories', $cats );
        $style      = ! empty( $instance['style'] ) ? $instance['style'] : 'style-one';

        global $post;
        $qry = new WP_Query( array(
            'post_type'             => 'post',
            'post_status'           => 'publish',
            'posts_per_page'        => $num_post,
            'ignore_sticky_posts'   => true,
            'category__not_in'      => $cat
        ) );
        if( $qry->have_posts() ){
            echo $args['before_widget'];
            if( $title ) echo $args['before_title'] . apply_filters( 'widget_title', $title, $instance, $this->id_base ) . $args['after_title'];
            ?>
            <ul class="<?php echo esc_attr($style);?>">
                <?php 
                while( $qry->have_posts() ){
                    $qry->the_post();
                ?>
                    <li>
                        <?php if( has_post_thumbnail() && $show_thumb ){ ?>
                            <a href="<?php the_permalink();?>" class="post-thumbnail">
                                <?php 
                                $feat_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-slider-thumb-size' );
                                if(!isset($feat_image_url))
                                {
                                    $feat_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' );
                                }
                                echo '<img src="'.esc_url($feat_image_url[0]).'">';
                                ?>
                            </a>
                        <?php 
                        }
                        if( $show_thumb && !has_post_thumbnail() ){
                            echo '<a href="'.esc_url(BTTK_FILE_URL).'/public/css/image/no-featured-img.png" class="post-thumbnail"><img src="'.esc_url(BTTK_FILE_URL).'/public/css/image/no-featured-img.png"></a>';
                        }
                        ?>
                        <div class="entry-header">
                                <?php
                                $category_detail = get_the_category($post->ID);//$post->ID
                                echo '<span class="cat-links">';
                                foreach($category_detail as $cd){
                                echo '<a href="' . esc_url( get_category_link( $cd->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'blossomthemes-toolkit' ), $cd->name ) ) . '">' . esc_html( $cd->name ) . '</a>';
                                }
                                echo '</span>';
                                ?>
                            <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
                            <?php if( $show_date ) { ?>
                                <div class="entry-meta">
                                    <span class="posted-on"><a href="<?php the_permalink(); ?>">
                                        <time datetime="<?php printf( __( '%1$s', 'blossomthemes-toolkit' ), get_the_date('Y-m-d') ); ?>"><?php printf( __( '%1$s', 'blossomthemes-toolkit' ), get_the_date('F j, Y') ); ?></time></a>
                                    </span>
                                </div>
                            <?php } ?>
                        </div>                        
                    </li>        
                <?php    
                }
            ?>
            </ul>
            <?php
            echo $args['after_widget'];   
        }
        wp_reset_postdata();  
    }

    //function to add different styling classes
    public function bttk_add_recent_post_class()
    {
       $arr = array(
            'Style One'     => 'style-one',
            'Style Two'     => 'style-two',
            'Style Three'   => 'style-three',
            );
        $arr = apply_filters( 'bttk_add_recent_post_class', $arr );
        return $arr;
    }
    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        
        $title          = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Recent Posts', 'blossomthemes-toolkit' );      
        $num_post       = ! empty( $instance['num_post'] ) ? $instance['num_post'] : 3 ;
        $show_thumbnail = ! empty( $instance['show_thumbnail'] ) ? $instance['show_thumbnail'] : '';
        $show_postdate  = ! empty( $instance['show_postdate'] ) ? $instance['show_postdate'] : '';
        $style          = ! empty( $instance['style'] ) ? $instance['style'] : 'style-one';

        
        ?>
        
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'blossomthemes-toolkit' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'num_post' ) ); ?>"><?php esc_html_e( 'Number of Posts', 'blossomthemes-toolkit' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'num_post' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'num_post' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $num_post ); ?>" />
        </p>
        
        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'show_thumbnail' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_thumbnail' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $show_thumbnail ); ?>/>
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_thumbnail' ) ); ?>"><?php esc_html_e( 'Show Post Thumbnail', 'blossomthemes-toolkit' ); ?></label>
        </p>
        
        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'show_postdate' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_postdate' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $show_postdate ); ?>/>
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_postdate' ) ); ?>"><?php esc_html_e( 'Show Post Date', 'blossomthemes-toolkit' ); ?></label>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>"><?php esc_html_e( 'Layout:', 'blossomthemes-toolkit' ); ?></label>
            <select id="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'style' ) ); ?>" class="based-on">
                <?php
                $styles = $this->bttk_add_recent_post_class();
                foreach ($styles as $key => $value) { ?>
                    <option value="<?php echo $value; ?>" <?php selected($style,$value);?>><?php echo $key;?></option>
                <?php
                }
                ?>
                
            </select>
        </p>
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
        
        $instance['title']          = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : __( 'Recent Posts', 'blossomthemes-toolkit' );
        $instance['num_post']       = ! empty( $new_instance['num_post'] ) ? absint( $new_instance['num_post'] ) : 3 ;        
        $instance['show_thumbnail'] = ! empty( $new_instance['show_thumbnail'] ) ? absint( $new_instance['show_thumbnail'] ) : '';
        $instance['show_postdate']  = ! empty( $new_instance['show_postdate'] ) ? absint( $new_instance['show_postdate'] ) : '';
        $instance['style']          = ! empty( $new_instance['style'] ) ? esc_attr( $new_instance['style'] ) : 'style-one';

        return $instance;
        
    }

} // class Bttk_Recent_Post / class Bttk_Recent_Post / class Bttk_Recent_Post / class Bttk_Recent_Post 