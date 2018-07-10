<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://wordpress.org/plugins/blossomthemes-toolkit/
 * @since      1.0.0
 *
 * @package    Blossomthemes_Toolkit
 * @subpackage Blossomthemes_Toolkit/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Blossomthemes_Toolkit
 * @subpackage Blossomthemes_Toolkit/public
 * @author     blossomthemes <info@blossomthemes.com>
 */
class Blossomthemes_Toolkit_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Blossomthemes_Toolkit_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Blossomthemes_Toolkit_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/blossomthemes-toolkit-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'font-awesome', plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'owl-carousel', plugin_dir_url( __FILE__ ) . 'css/owl.carousel.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'owl-theme-default', plugin_dir_url( __FILE__ ) . 'css/owl.theme.default.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'Dancing-Script', 'http://fonts.googleapis.com/css?family=Dancing+Script', false ); 
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Blossomthemes_Toolkit_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Blossomthemes_Toolkit_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
        wp_enqueue_script( 'masonry' );
        wp_enqueue_script( 'isotope-pkgd', plugin_dir_url( __FILE__ ) . 'js/isotope.pkgd.min.js', array( 'jquery' ), '3.0.5', false );		
		wp_enqueue_script( 'owl-carousel', plugin_dir_url( __FILE__ ) . 'js/owl.carousel.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'waypoint', plugin_dir_url( __FILE__ ) . 'js/waypoint.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'odometer', plugin_dir_url( __FILE__ ) . 'js/odometer.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/blossomthemes-toolkit-public.js', array( 'jquery' ), $this->version, false );
	}

}
