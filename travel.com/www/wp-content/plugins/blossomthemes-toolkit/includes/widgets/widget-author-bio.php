<?php
/**
 * Widget Author Bio
 *
 * @package Bttk
 */
 
// register Bttk_Author_Bio widget
function bttk_register_author_bio_widget() {
    register_widget( 'Bttk_Author_Bio' );
}
add_action( 'widgets_init', 'bttk_register_author_bio_widget' );

function bttk_author_load_sortable() {    
    wp_enqueue_script( 'jquery-ui-core' );    
    wp_enqueue_script( 'jquery-ui-sortable' );    
}
add_action( 'load-widgets.php', 'bttk_author_load_sortable' );

if( ! class_exists( 'Bttk_Author_Bio' ) ) : 
 /**
 * Adds Bttk_Author_Bio widget.
 */
class Bttk_Author_Bio extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
        add_action( 'admin_print_footer_scripts', array( $this,'bttk_socicon_template' ) );
		parent::__construct(
			'bttk_author_bio', // Base ID
			__( 'Blossom: Author Bio', 'blossomthemes-toolkit' ), // Name
			array( 'description' => __( 'An Author Bio Widget', 'blossomthemes-toolkit' ), ) // Args
		);
	}

	        // /**
    //  * Get the allowed socicon lists.
    //  * @return array
    //  */
    function bttk_allowed_socicons() {
        return apply_filters( 'bttk_social_icons_allowed_socicon', array( 'modelmayhem', 'mixcloud', 'drupal', 'swarm', 'istock', 'yammer', 'ello', 'stackoverflow', 'persona', 'triplej', 'houzz', 'rss', 'paypal', 'odnoklassniki', 'airbnb', 'periscope', 'outlook', 'coderwall', 'tripadvisor', 'appnet', 'goodreads', 'tripit', 'lanyrd', 'slideshare', 'buffer', 'disqus', 'vk', 'whatsapp', 'patreon', 'storehouse', 'pocket', 'mail', 'blogger', 'technorati', 'reddit', 'dribbble', 'stumbleupon', 'digg', 'envato', 'behance', 'delicious', 'deviantart', 'forrst', 'play', 'zerply', 'wikipedia', 'apple', 'flattr', 'github', 'renren', 'friendfeed', 'newsvine', 'identica', 'bebo', 'zynga', 'steam', 'xbox', 'windows', 'qq', 'douban', 'meetup', 'playstation', 'android', 'snapchat', 'twitter', 'facebook', 'google-plus', 'pinterest', 'foursquare', 'yahoo', 'skype', 'yelp', 'feedburner', 'linkedin', 'viadeo', 'xing', 'myspace', 'soundcloud', 'spotify', 'grooveshark', 'lastfm', 'youtube', 'vimeo', 'dailymotion', 'vine', 'flickr', '500px', 'instagram', 'wordpress', 'tumblr', 'twitch', '8tracks', 'amazon', 'icq', 'smugmug', 'ravelry', 'weibo', 'baidu', 'angellist', 'ebay', 'imdb', 'stayfriends', 'residentadvisor', 'google', 'yandex', 'sharethis', 'bandcamp', 'itunes', 'deezer', 'medium', 'telegram', 'openid', 'amplement', 'viber', 'zomato', 'quora', 'draugiem', 'endomodo', 'filmweb', 'stackexchange', 'wykop', 'teamspeak', 'teamviewer', 'ventrilo', 'younow', 'raidcall', 'mumble', 'bebee', 'hitbox', 'reverbnation', 'formulr', 'battlenet', 'chrome', 'diablo', 'discord', 'issuu', 'macos', 'firefox', 'heroes', 'hearthstone', 'overwatch', 'opera', 'warcraft', 'starcraft', 'keybase', 'alliance', 'livejournal', 'googlephotos', 'horde', 'etsy', 'zapier', 'google-scholar', 'researchgate' ) );
    }

    /**
     * Get the icon from supported URL lists.
     * @return array
     */
    function bttk_get_supported_url_icon() {
        return apply_filters( 'bttk_social_icons_get_supported_url_icon', array(
            'feed'                  => 'rss',
            'ok.ru'                 => 'odnoklassniki',
            'vk.com'                => 'vk',
            'last.fm'               => 'lastfm',
            'youtu.be'              => 'youtube',
            'battle.net'            => 'battlenet',
            'blogspot.com'          => 'blogger',
            'play.google.com'       => 'play',
            'plus.google.com'       => 'google-plus',
            'photos.google.com'     => 'googlephotos',
            'chrome.google.com'     => 'chrome',
            'scholar.google.com'    => 'google-scholar',
            'feedburner.google.com' => 'mail',
        ) );
    }

    /**
     * Get the social icon name for given website url.
     *
     * @param  string $url Social site link.
     * @return string
     */
    function bttk_get_social_icon_name( $url ) {
        $icon = '';
        // $obj = new Rara_Theme_Toolkit_Pro_Admin;
        if ( $url = strtolower( $url ) ) {
            foreach ( $this->bttk_get_supported_url_icon() as $link => $icon_name ) {
                if ( strstr( $url, $link ) ) {
                    $icon = $icon_name;
                }
            }

            if ( ! $icon ) {
                foreach ( $this->bttk_allowed_socicons() as $icon_name ) {
                    if ( strstr( $url, $icon_name ) ) {
                        $icon = $icon_name;
                    }
                }
            }
        }

        return apply_filters( 'btss_social_icons_get_icon_name', $icon, $url );
    }

	/**
    * 
    * Social icon template for team.
    *
    * @since 1.0.0
    */
    function bttk_socicon_template() { 
    	$screen = get_current_screen();?>
	        <div class="bttk-socicon-template">
	            <li class="social-share-list" data-id="{{socicon_index}}">
                    <span class="bttk-social-icons-sortable-handle"></span>
                    <span class="bttk-social-icons-field-handle fa fa-facebook"></span>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'socicon_profile[{{socicon_index}}]' ) ); ?>"><?php esc_html_e( 'Social Icon', 'blossomthemes-toolkit' ); ?></label>
                    <span class="example-text">Example: facebook</span>
                    <input class="user-social-profile" id="<?php echo esc_attr( $this->get_field_id( 'socicon_profile[{{socicon_index}}]' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'socicon_profile[{{socicon_index}}]' ) ); ?>" type="text" value="" placeholder="<?php _e('Search Social Icons','blossomthemes-toolkit');?>" />
                    <label class="link-label" for="<?php echo esc_attr( $this->get_field_id( 'socicon_profile[{{socicon_index}}]' ) ); ?>"><?php esc_html_e( 'Link', 'blossomthemes-toolkit' ); ?></label>
                    <span class="example-text">Example: http://facebook.com</span>
                    <input class="user-social-links" id="<?php echo esc_attr( $this->get_field_id( 'socicon[{{socicon_index}}]' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'socicon[{{socicon_index}}]' ) ); ?>" type="text" value="" />
                    <span class="del-user-social-links dashicons-no" style="font-family: 'dashicons'"></span>
                </li>
	        </div>
	        <style type="text/css">.bttk-socicon-template{display: none;}</style>
    <?php
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
        
        $obj = new BlossomThemes_Toolkit_Functions();
        $title            = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $name             = ! empty( $instance['name'] ) ? $instance['name'] : '';
        $email            = ! empty( $instance['email'] ) ? $instance['email'] : '';        
        $content          = ! empty( $instance['content'] ) ? $instance['content'] : '';
        $image            = ! empty( $instance['image'] ) ? $instance['image'] : '';
        $author_image     = ! empty( $instance['author-image'] ) ? $instance['author-image'] : '';
        $label            = ! empty( $instance['label'] ) ? $instance['label'] : '';
        $link             = ! empty( $instance['link'] ) ? $instance['link'] : '';
        $signaturetext    = ! empty( $instance['signature-text'] ) ? $instance['signature-text'] : '';
        $attachment_id    = $image;
        $author_image_id  = $author_image; 

        if ( !filter_var( $image, FILTER_VALIDATE_URL ) === false ) {
            $attachment_id = $obj->bttk_get_attachment_id( $image );
        }

        if ( !filter_var( $author_image, FILTER_VALIDATE_URL ) === false ) {
            $author_image_id = $obj->bttk_get_attachment_id( $author_image );
        }        
        
        $socicon          = ! empty( $instance['socicon'] ) ? $instance['socicon'] : '';   
        $option           = ! empty( $instance['author-image-option'] ) ? $instance['author-image-option'] : 'gravatar';
        $signature_option = ! empty( $instance['author-signature-option'] ) ? $instance['author-signature-option'] : 'text';

        
        if( $attachment_id == 0 )
        {
            $image_array[] = $image;
        }
        else{

	        $author_bio_img_size = apply_filters('author_bio_img_size','medium');

	        $image_array   = wp_get_attachment_image_src( $attachment_id, $author_bio_img_size );
	        
	        $image         = preg_match('/(^.*\.jpg|jpeg|png|gif|ico*)/i', $image);
        }

        if( $author_image_id == 0 )
        {
            $author_image_array[] = $author_image;
        }
        else{

            $author_img_size = apply_filters('author_bio_img_size','medium');

            $author_image_array   = wp_get_attachment_image_src( $author_image_id, $author_img_size );
            
            $author_image         = preg_match('/(^.*\.jpg|jpeg|png|gif|ico*)/i', $author_image);
        }
                
        echo $args['before_widget'];
        
        if( $title ) echo $args['before_title'] . apply_filters( 'widget_title', $title, $instance, $this->id_base ) . $args['after_title']; 
        ?>
        <div class="bttk-author-bio-holder">
            <div class="image-holder">
                <?php 
                if($option=='gravatar'){ 
                    echo get_avatar( $email, 300 ); 
                }
                else{ ?>
                    <img src="<?php echo esc_url( $author_image_array[0] ); ?>" alt="<?php echo esc_attr( $name ); ?>" />
                <?php
                }
                ?>
            </div> 
            <div class="text-holder">
                <div class="title-holder"><?php echo esc_html($name); ?></div> 
                <div class="author-bio-content">
                    <?php echo wpautop( wp_kses_post( $content ) ); ?>
                </div>
                <?php
                if( $signature_option == 'photo' ){ ?>
                    <div class="signature-holder">
                        <img src="<?php echo esc_url( $image_array[0] ); ?>" alt="<?php echo esc_attr( $title ); ?>" />
                    </div>
                <?php } else{ echo '<div class="text-signature">'.esc_html($signaturetext).'</div>';}?>                
                <?php if( $link && $label ){ ?>
                <a href="<?php echo esc_url( $link ); ?>" class="readmore"><?php echo esc_html( $label );?></a>
                <?php } ?>
    	        <div class="author-bio-socicons">
                    <?php
                    if(is_array($socicon)): ?>
                        <ul class="author-socicons">
        	        	<?php
        	        	foreach ($socicon as $key => $value) { ?>
        		            <li class="social-share-list">
        		                <a href="<?php echo esc_url($value);?>"><i class="fa fa-<?php echo esc_attr($this->bttk_get_social_icon_name($value));?>"></i></a>
        		                
        		            </li>
        		        <?php
        		        }
        		        ?>
                        </ul>
                <?php endif; ?>
    	        </div>
            </div>
	    </div>
        <?php    
        
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
        $obj = new BlossomThemes_Toolkit_Functions();
        $email = get_option('admin_email');
        $title   = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $name   = ! empty( $instance['name'] ) ? $instance['name'] : '';
        $email   = ! empty( $instance['email'] ) ? $instance['email'] : $email;
        $content = ! empty( $instance['content'] ) ? $instance['content'] : '';
        $image   = ! empty( $instance['image'] ) ? $instance['image'] : '';
        $author_image   = ! empty( $instance['author-image'] ) ? $instance['author-image'] : '';
        $label   = ! empty( $instance['label'] ) ? $instance['label'] : '';
        $link    = ! empty( $instance['link'] ) ? $instance['link'] : '';
        $signaturetext    = ! empty( $instance['signature-text'] ) ? $instance['signature-text'] : '';
        $socicon    = ! empty( $instance['socicon'] ) ? $instance['socicon'] : ''; 
        $option    = ! empty( $instance['author-image-option'] ) ? $instance['author-image-option'] : 'gravatar';
        $signature_option = ! empty( $instance['author-signature-option'] ) ? $instance['author-signature-option'] : 'text';
        echo 
        '<script>
        jQuery(document).ready(function($){
            $(".bttk-sortable-icons").sortable({
                    cursor: "move",
                    update: function (event, ui) {
                        $(".bttk-sortable-icons .social-share-list input").trigger("change");
                    }
                });
            $("body").on("click", ".del-user-social-links", function() {
                $(this).trigger("change");
            });
            $( ".author-image:checked" ).each(function() {
                var val = $(this).val();
                if( val == "gravatar" )
                {
                    $(this).parent().next(".widget-upload").hide();
                    $(this).parent().siblings(".author-email").show();
                    $(this).parent().siblings(".widget-side-note").show();
                }
                if( val == "photo" )
                {
                    $(this).parent().siblings(".author-email").hide();
                    $(this).parent().siblings(".widget-side-note").hide();
                    $(this).parent().next(".widget-upload").show();
                }
            });

            $(".author-image").change(function () {
               if( $(this).val() == "gravatar" )
               {
                    $(this).parent().next(".widget-upload").hide();
                    $(this).parent().siblings(".author-email").show();
                    $(this).parent().siblings(".widget-side-note").show();
               }
               if( $(this).val() == "photo" )
               {
                     $(this).parent().siblings(".author-email").hide();
                    $(this).parent().next(".widget-upload").show();
                    $(this).parent().siblings(".widget-side-note").hide();
               }
            });
            
            $( ".author-signature:checked" ).each(function() {
                var val = $(this).val();
                if( val == "text" )
                {
                    $(this).parent().next(".widget-upload").hide();
                    $(this).parent().siblings(".signature-text").show();
                }
                if( val == "photo" )
                {
                    $(this).parent().siblings(".signature-text").hide();
                    $(this).parent().siblings(".widget-side-note").hide();
                }
            });

            $(".author-signature").change(function () {
               if( $(this).val() == "text" )
               {
                    $(this).parent().next(".widget-upload").hide();
                    $(this).parent().siblings(".signature-text").show();
               }
               if( $(this).val() == "photo" )
               {
                    $(this).parent().siblings(".signature-text").hide();
                    $(this).parent().next(".widget-upload").show();
               }
            });
        });
        </script>';
        ?>
		
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'blossomthemes-toolkit' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>"><?php esc_html_e( 'Author Name', 'blossomthemes-toolkit' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="text" value="<?php echo esc_attr( $name ); ?>" />
        </p>
        
        <p>
            <label><?php _e('Display photo from:','blossomthemes-toolkit'); ?></label>
            <input class="author-image" type="radio" name="<?php echo esc_attr( $this->get_field_name( 'author-image-option' ) );?>" id="<?php echo esc_attr( $this->get_field_id( 'author-image-option' . '-gravatar' ) );?>" value="gravatar" <?php if( $option == 'gravatar' ) echo 'checked'; ?> />
            <label for="<?php echo esc_attr( $this->get_field_id( 'author-image-option' . '-gravatar' ) );?>" class="radio-btn-wrap"><?php _e('Gravatar', 'blossomthemes-toolkit');?></label>
            <input class="author-image" type="radio" name="<?php echo esc_attr( $this->get_field_name( 'author-image-option' ) );?>" id="<?php echo esc_attr( $this->get_field_id( 'author-image-option' . '-photo' ) );?>" value="photo" <?php if( $option == 'photo' ) echo 'checked'; ?> />
            <label for="<?php echo esc_attr( $this->get_field_id( 'author-image-option' . '-photo' ) );?>" class="radio-btn-wrap"><?php _e('Uploaded Photo','blossomthemes-toolkit');?></label>
        </p>
        
        <?php $obj->bttk_get_image_field( $this->get_field_id( 'author-image' ), $this->get_field_name( 'author-image' ), $author_image, __( 'Upload Author Image', 'blossomthemes-toolkit' ) ); ?>
        
        <p class="author-email">
            <label for="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>"><?php esc_html_e( 'Author Email', 'blossomthemes-toolkit' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" type="text" value="<?php echo esc_attr( $email ); ?>" />
        </p>
        <div class="widget-side-note" class="example-text"><?php $link1 = '<a href="http://en.gravatar.com/" target="_blank">Gravatar</a>'; echo sprintf( __( 'You can show your %1$s image instead of manually uploading your photo. Just add your gravatar registered email address here.','blossomthemes-toolkit'), $link1 );?></div>
        
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>"><?php esc_html_e( 'Description', 'blossomthemes-toolkit' ); ?></label>
            <textarea name="<?php echo esc_attr( $this->get_field_name( 'content' ) ); ?>" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>"><?php echo wp_kses_post( $content ); ?></textarea>
        </p>
        
        <p>
            <label><?php _e('Display Signature from:','blossomthemes-toolkit'); ?></label>
            <input class="author-signature" type="radio" name="<?php echo esc_attr( $this->get_field_name( 'author-signature-option' ) );?>" id="<?php echo esc_attr( $this->get_field_id( 'author-signature-option' . '-text' ) );?>" value="text" <?php if( $signature_option == 'text' ) echo 'checked'; ?> />
            <label for="<?php echo esc_attr( $this->get_field_id( 'author-signature-option' . '-text' ) );?>" class="radio-btn-wrap"><?php _e('Text','blossomthemes-toolkit');?></label>
            <input class="author-signature" type="radio" name="<?php echo esc_attr( $this->get_field_name( 'author-signature-option' ) );?>" id="<?php echo esc_attr( $this->get_field_id( 'author-signature-option' . '-photo' ) );?>" value="photo" <?php if( $signature_option == 'photo' ) echo 'checked'; ?> />
            <label for="<?php echo esc_attr( $this->get_field_id( 'author-signature-option' . '-photo' ) );?>" class="radio-btn-wrap"><?php _e('Uploaded Photo','blossomthemes-toolkit');?></label>
        </p>

        <?php $obj->bttk_get_image_field( $this->get_field_id( 'image' ), $this->get_field_name( 'image' ), $image, __( 'Upload Signature Image', 'blossomthemes-toolkit' ) ); ?>
        
        <p class="signature-text">
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'signature-text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'signature-text' ) ); ?>" type="text" value="<?php echo esc_attr( $signaturetext ); ?>" />
            <label for="<?php echo esc_attr( $this->get_field_id( 'signature-text' ) ); ?>"><?php esc_html_e( 'Signature Text', 'blossomthemes-toolkit' ); ?></label>
		</p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'label' ) ); ?>"><?php esc_html_e( 'Button Label', 'blossomthemes-toolkit' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'label' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'label' ) ); ?>" type="text" value="<?php echo esc_attr( $label ); ?>" />
		</p>
        
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php esc_html_e( 'Button Link', 'blossomthemes-toolkit' ); ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="text" value="<?php echo esc_url( $link ); ?>" />
            
		</p>
        <ul class="bttk-sortable-icons" id="<?php echo esc_attr( $this->get_field_id( 'bttk-social-icons' ) ); ?>">
		<?php
		    if($socicon=='')
		    {?>
		        <li class="social-share-list" data-id="1">
		            <span class="bttk-social-icons-sortable-handle"></span>
		            <span class="bttk-social-icons-field-handle fa fa-facebook"></span>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'socicon_profile[1]' ) ); ?>"><?php esc_html_e( 'Social Icon', 'blossomthemes-toolkit' ); ?></label>
                    <span class="example-text">Example: facebook</span>
                    <input class="user-social-profile" id="<?php echo esc_attr( $this->get_field_id( 'socicon_profile[1]' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'socicon_profile[1]' ) ); ?>" type="text" value="facebook" />
                    <label class="link-label" for="<?php echo esc_attr( $this->get_field_id( 'socicon_profile[1]' ) ); ?>"><?php esc_html_e( 'Link', 'blossomthemes-toolkit' ); ?></label>
                    <span class="example-text">Example: http://facebook.com</span>
                    <input class="user-social-links" id="<?php echo esc_attr( $this->get_field_id( 'socicon[1]' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'socicon[1]' ) ); ?>" type="text" value="http://facebook.com" />
		            <span class="del-user-social-links dashicons-no" style="font-family: 'dashicons'"></span>
		        </li>
		        <li class="social-share-list" data-id="2">
                    <span class="bttk-social-icons-sortable-handle"></span>
                    <span class="bttk-social-icons-field-handle fa fa-facebook"></span>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'socicon_profile[2]' ) ); ?>"><?php esc_html_e( 'Social Icon', 'blossomthemes-toolkit' ); ?></label>
                    <span class="example-text">Example: facebook</span>
                    <input class="user-social-profile" id="<?php echo esc_attr( $this->get_field_id( 'socicon_profile[2]' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'socicon_profile[2]' ) ); ?>" type="text" value="twitter" />
                    <label class="link-label" for="<?php echo esc_attr( $this->get_field_id( 'socicon_profile[2]' ) ); ?>"><?php esc_html_e( 'Link', 'blossomthemes-toolkit' ); ?></label>
                    <span class="example-text">Example: http://facebook.com</span>
                    <input class="user-social-links" id="<?php echo esc_attr( $this->get_field_id( 'socicon[2]' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'socicon[2]' ) ); ?>" type="text" value="http://twitter.com" />
                    <span class="del-user-social-links dashicons-no" style="font-family: 'dashicons'"></span>
                </li>
		        <?php 
                } 
		    else{
		        foreach ($socicon as $key => $value) { ?>
		            <li class="social-share-list" data-id="<?php echo $key;?>">
		                <span class="bttk-social-icons-sortable-handle"></span>
		                <span class="bttk-social-icons-field-handle fa fa-<?php echo esc_attr($this->bttk_get_social_icon_name($value));?>"></span>
                        <label for="<?php echo esc_attr( $this->get_field_name( 'socicon_profile['.$key.']' ) ); ?>"><?php esc_html_e( 'Social Icon', 'blossomthemes-toolkit' ); ?></label>
                        <span class="example-text">Example: facebook</span>
		                <input class="user-social-profile" id="<?php echo esc_attr( $this->get_field_id( 'socicon_profile['.$key.']' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'socicon_profile['.$key.']' ) ); ?>" type="text" value="<?php echo esc_attr($this->bttk_get_social_icon_name($value));?>" />
                        <label class="link-label" for="<?php echo esc_attr( $this->get_field_id( 'socicon['.$key.']' ) ); ?>"><?php esc_html_e( 'Link', 'blossomthemes-toolkit' ); ?></label>
                        <span class="example-text">Example: http://facebook.com</span>
                        <input class="user-social-links" id="<?php echo esc_attr( $this->get_field_id('socicon['.$key.']' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'socicon['.$key.']' ) ); ?>" type="text" value="<?php echo esc_url($value);?>" />
		                <span class="del-user-social-links dashicons-no" style="font-family: 'dashicons'"></span>
		            </li>
		        <?php
		        }
		    }
		    ?>
        <span class="bttk-socicon-holder"></span>
        </ul>
		<input type="button" name="button" id="add-user-socicon" class="button button-primary" value="<?php _e('Add Social Profile','blossomthemes-toolkit');?>"><br>
        <span class="bttk-option-side-note" class="example-text"><?php _e('Click on the above button to add social media icons. You can also change the order of the social icons.','blossomthemes-toolkit');?></span>
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
        $email = get_option('admin_email');
        $instance['title']   = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['name']   = ! empty( $new_instance['name'] ) ? sanitize_text_field( $new_instance['name'] ) : '';
        $instance['email']   = ! empty( $new_instance['email'] ) ? sanitize_text_field( $new_instance['email'] ) : $email;
        $instance['content'] = ! empty( $new_instance['content'] ) ? wp_kses_post( $new_instance['content'] ) : '';
        $instance['image']   = ! empty( $new_instance['image'] ) ? esc_attr( $new_instance['image'] ) : '';
        $instance['author-image']   = ! empty( $new_instance['author-image'] ) ? esc_attr( $new_instance['author-image'] ) : '';
        $instance['label']   = ! empty( $new_instance['label'] ) ? sanitize_text_field( $new_instance['label'] ) : '';
        $instance['link']    = ! empty( $new_instance['link'] ) ? esc_url_raw( $new_instance['link'] ) : '';
        $instance['signature-text']       = ! empty( $new_instance['signature-text'] ) ? $new_instance['signature-text'] : '';
        $instance['socicon']    = ! empty( $new_instance['socicon'] ) ? $new_instance['socicon'] : '';
        $instance['socicon_profile']    = ! empty( $new_instance['socicon_profile'] ) ? $new_instance['socicon_profile'] : '';
        $instance['author-image-option'] = ! empty( $new_instance['author-image-option'] ) ? $new_instance['author-image-option'] : 'gravatar';
        $instance['author-signature-option'] = ! empty( $new_instance['author-signature-option'] ) ? $new_instance['author-signature-option'] : 'text';
		return $instance;
	}

} // class Bttk_Author_Bio
endif;