<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.example.com
 * @since      1.0.0
 *
 * @package    tn_Popup
 * @subpackage tn_Popup/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    tn_Popup
 * @subpackage tn_Popup/admin
 * @author     Truc Nguyen <anhtruc92@gmail.com>
 */
class tn_Popup_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;	
		
	}
	/**
	 * Custom search query 
	 *
	 * @since    1.0.0
	 * @param      Array    $args       
	 * @param      WP_Rest_Request    $request    
	 */
	function custom_search($args, $request){		
		$get = $request->get_params('GET');			
		if( !empty($get['search_by_title_like']) ){
			$args['search_by_title_like'] = $get['search_by_title_like'];

		}		
		return $args;
	}
	/**
	 * Custom where query 
	 *
	 * @since    1.0.0
	 * @param      string    $where       
	 * @param      WP_Query   $wp_query    
	 */
	function search_title_filter( $where, $wp_query )
	{
	    global $wpdb;
		$search_term = $wp_query->get( 'search_by_title_like' );
		$search_term = trim($search_term);
	    if ( !empty($search_term) ) {
	        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . $wpdb->esc_like( $search_term ) . '%\'';
	        
	    }
		
	    return $where;
	}

	/**
	 * init function
	 *
	 * @since    1.0.0
	 */
	public function init() {		
		$current_screen = get_current_screen();		
		if( $current_screen->id === tn_POPUP ) {
			$post_id = 0;
			if( !empty($_GET['post']) ){
				$post_id = $_GET['post'];
				$display_on = get_post_meta($post_id, 'display_on', true);
							
			}
			$metabox = new tn_Metabox( 'Extra Settings', 'extra_settings', array(tn_POPUP) );			
			$metabox->add_field(
				array(
					'name' => 'display_on',
					'title' => 'Display on',
					'desc' => 'This popup will be displayed on pages',
					'type'=> 'select',
					'classes'=>'select2',
					'multiple'=>true,
					'object_type'=>'post',					
					'options'=>array(
						''=>'All'
					 )));
			$metabox->add_field(
				array(
					'name' => 'exclude_on',
					'title' => 'Exclude on',
					'desc' => 'This popup will be excluded on pages',
					'type'=> 'select',
					'classes'=>'select2',
					'multiple'=>true,
					'object_type'=>'post'));
			$metabox->add_field(
				array(
					'name' => 'popup_background',
					'title' => 'Background',
					'desc' => 'The background of this popup',
					'type'=> 'text',
					'default'=>'#ffffff'
					));

		}
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in tn_Popup_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The tn_Popup_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( 'select2', plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tn-popup-admin.css', array('select2'), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in tn_Popup_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The tn_Popup_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( 'select2-js', plugin_dir_url( __FILE__ ) . 'js/select2.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tn-popup-admin.js', array( 'jquery', 'select2-js' ), $this->version, false );

	}



}
