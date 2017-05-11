<?php
/**
 *
 * Plugin Name: WordPress Plugin Boilerplate
 * Version: 1.0.0
 *
 * */

// Security Check
if(!defined('ABSPATH')) die();

// OS independent directory seperator shortning
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

// Signature Macro of the plugin
define('WORDPRESS_PLUGIN_BOILERPLATE', true);

/**
 *
 * @class WordPressPluginBoilerplage
 * @description Main class of the plugin
 * 
 * */
class WordPressPluginBoilerplate{ // Edit Identifier

	/**
	 *
	 * @var string $name
	 * @description Name of the plugin
	 * 
	 * */
	public $name;
	
	/**
	 *
	 * @var string $prefix
	 * @description Unique Identifier of the plugin
	 *
	 * */
	public $prefix;

	/**
	 *
	 * @var string $version
	 * @description Version number of the plugin
	 *
	 * */
	public $version;

	/**
	 *
	 * @var string $path
	 * @description Root path of this plugin
	 * 
	 * */
	public $path;

	/**
	 *
	 * @var string $url
	 * @description Root URL of the plugin
	 *
	 * */
	public $url;

	/**
	 *
	 * @var string $upload_path
	 * @description Upload directory path of the plugin
	 *
	 * */
	public $upload_path; // Use this if you need upload directory

	/**
	 *
	 * @var string $upload_url
	 * @description Upload directory URL of the plugin
	 *
	 * */
	public $upload_url; // Use this if you need upload directory

	/**
	 *
	 * @var mixed $options
	 * @description Options store for the plugin
	 *
	 * */
	public $options;
	
	/**
	 * 
	 * @var array $shortcode_data
	 * @description Shortcode Data to be stored.
	 * 
	 * */
	public $shortcode_data;
	
	/**
	 * 
	 * @var string $shortcode_html
	 * @description Shortcode return html data storage.
	 * 
	 * */
	public $shortcode_html;
	
	/**
	 *
	 * @var string $website
	 * @description Website of the plugin
	 *
	 * */
	public $website;

	/**
	 *
	 * @var string $support
	 * @description Support page URL
	 *
	 * */
	public $support;

	/**
	 *
	 * @var string $feedback
	 * @description Feedback/Review Page URL
	 * 
	 * */
	public $feedback;

	/**
	 *
	 * @var string $logo_url
	 * @description URL of the logo
	 *
	 * */
	public $logo_url;
	
	/**
	 *
	 * @function __construct
	 * @description Main constructor function of the plugin
	 * @param string $name Name of the plugin
	 * @return void
	 * 
	 * */
	public function __construct($name){

		// Plugin data initialization
		$this->name = trim($name);
		$this->prefix = 'gb_' . str_replace(' ', '-', strtolower($this->name));
		$this->path = plugin_dir_path(__FILE__);
		$this->url = plugin_dir_url(__FILE__);

		// URLS and extras
		$this->version = '1.0.0';
		$this->website = '';
		$this->support = '';
		$this->feedback = '';
		$this->logo_url = '';

		// Options
		$this->options = get_option($this->prefix);
		if(!empty($this->options)) $this->options = array();
		register_shutdown_function(array(&$this, 'save_options')); // Works as destructor for the object

		// Working with upload directory
		$upload = wp_upload_dir(); // Upload Directory
		$this->upload_path = $upload['basedir'] . DS . $this->prefix; // Path
		$this->upload_url = $upload['baseurl'] . '/' . $this->prefix; // URL
		if( !is_dir($this->upload_path ) ) mkdir( $this->upload_path , 0755 ); // Creates the upload directory if it is not their

		// Plugin Action Links on plugin.php page
		//auto::  add_filter('plugin_action_links', array(&$this, 'plugin_page_links'), 10, 2);

		// Adding hooks
		// add_action('hook_name', array(&$this, 'function_name'));
		
		// Frontend assets Registration
		add_action('wp_enqueue_scripts', array(&$this, 'assets') );

		// Admin assets Registration
		add_action('admin_enqueue_scripts', array(&$this, 'admin_assets') );
		
		// Custom post
		add_action('init', array(&$this, 'custom_posts'));
		
		// Custom Post Taxenomy
        add_action('init', array(&$this, 'custom_post_taxonomies'));
		
		// Adding menu
		add_action('admin_menu', array(&$this, 'menu'));
		
		// Adding Shortcode
		add_shortcode('example_shortcode', array(&$this, 'example_shortcode')); // Shortcode Example
		
		// Ajax Call
		add_action('wp_ajax_ajax_frontend_example', array(&$this, 'ajax_frontend_general_example')); // Logged in users
		add_action('wp_ajax_nopriv_ajax_frontend_example', array(&$this, 'ajax_frontend_general_example')); // Guest in users
		
		// Widget
		include($this->path . 'views' . DS . 'widget' . DS . 'test-widget.php'); // Including widget file
		add_action( 'widgets_init', create_function('', 'register_widget("GBTestWidget");') );
		
		// Site origin widget
		add_filter('siteorigin_widgets_widget_folders', array(&$this, 'site_origin_widget_collection'));
	}
	
	/**
	 * 
	 * @function assets
	 * @description Registers assets to be loaded later where needed.
	 * @param void
	 * @return null
	 * 
	 * */
	public function assets(){
		
		// Style Sheets
		wp_register_style( 'wpb-frontend-style', $this->url . 'assets/css/frontend-style.css' ); // Custom style for the frontend.
		
		// Javascript
		wp_register_script( 'wpb-frontend-script', $this->url . 'assets/js/frontend-script.js', array('jquery') ); // Custom script for the frontend.
		
		wp_localize_script( 'wpb-frontend-script', 'GB_AJAXURL', array( admin_url( 'admin-ajax.php' ) ) ); // Assigning GB_AJAXURL on the frontend
		wp_localize_script( 'wpb-frontend-script', '_GB_SECURITY', array( wp_create_nonce( "gb-ajax-nonce" ) ) ); // Assigning GB_AJAXURL on the frontend
		
	}
	
	/**
	 * 
	 * @function admin_assets
	 * @description Loads admin assets
	 * @param void
	 * @return void
	 * 
	 * */
	public function admin_assets(){
		
		// Style Sheets
		wp_register_style( 'wpb-bootstrap-main-style', $this->url . 'external/bootstrap-3.3.7/css/bootstrap.min.css',  array(), '3.3.7'); // Bootstrap Main File.
		wp_register_style( 'wpb-bootstrap-material-theme-style', $this->url . 'external/bootstrap-3.3.7/css/bootstrap-theme.min.css', array('wpb-bootstrap-main-style'), '4.0.2' ); // Bootstrap Material Theme.
		wp_register_style( 'wpb-bootstrap-material-theme-ripples-style', $this->url . 'external/bootstrap-3.3.7/css/ripples.min.css', array('wpb-bootstrap-material-theme-style'), '4.0.2' ); // Bootstrap Material Theme.
		wp_register_style( 'wpb-admin-style', $this->url . 'assets/css/admin-style.css', array('wpb-bootstrap-material-theme-ripples-style') ); // Custom style for the frontend.
		
		// Javascript
		wp_register_script( 'wpb-bootstrap-main-script', $this->url . 'external/bootstrap-3.3.7/js/bootstrap.min.js', array('jquery'), '3.3.7' ); // Custom script for the frontend.
		wp_register_script( 'wpb-admin-script', $this->url . 'assets/js/admin-script.js', array('wpb-bootstrap-main-script') ); // Custom script for the frontend.
		
	}
	
	/**
	 *
	 * @function save_options
	 * @description Saves the option when the function closes
	 * @param void
	 * @return void
	 *
	 * */
	public function save_options(){
		update_option($this->prefix,array());
	}

	/**
	 * 
	 * @function custom_posts
	 * @description Adds a custom post type to wordpress
	 * @param void
	 * @return void
	 * 
	 * */
	public function custom_posts(){

		register_post_type(
			'custom_posts',
			array(
				'labels' => array(
					'name' => __('Custom Posts'),
					'singular_name' => __('Custom Post'),
					'add_new' => __('Add Custom Post'),
					'add_new_item' => __('Add new Custom Post'),
				),
				'description' => 'Description of custom post type',
				'public' => true,
				'hierarchical' => true,
				'exclude_from_search' => false,
				'publicly_queryable' => true,
				'show_ui' => true,
				'show_in_menu' => true,
				'show_in_nav_menu' => true,
				'show_in_rest' => true,
				'menu_icon' => 'dashicons-menu',
				'taxonomies' => array('category',),
				'has_archive' => true,
				'featured_image' => true,
				'supports' => array( 'title', 'editor', 'comments', 'revisions', 'trackbacks', 'author', 'excerpt', 'page-attributes', 'thumbnail', 'custom-fields', 'post-formats'),
			)
		);
	}
	
	/**
	 * 
	 * @function custom_post_taxonomies
	 * @description Custom post taxonomies
	 * 
	 * */
	public function custom_post_taxonomies(){
		
		$labels = array(
            'singular_name' => 'Custom Post Taxonomy',
            //auto::  'search_items' => __('Search Groups', 'textdomain'),
            //auto::  'all_items' => __('All Group', 'textdomain'),
            //auto::  'parent_item' => __('Parent Group', 'textdomain'),
            //auto::  'parent_item_colon' => __('Parent Group:', 'textdomain'),
            //auto::  'edit_item' => __('Edit Group', 'textdomain'),
            //auto::  'update_item' => __('Update Group', 'textdomain'),
            //auto::  'add_new_item' => __('Add New Group', 'textdomain'),
            //auto::  'new_item_name' => __('New Group Name', 'textdomain'),
            'menu_name' => 'CP Taxonomy',
        );
		
		$args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'mtt_group'),
        );
		
		register_taxonomy('cp_taxonomy', array('custom_posts'), $args);
		
	}
	
	/**
	 * 
	 * @function menu
	 * @description Adding admin menu to the WordPress admin dashboard
	 * 
	 * */
	public function menu(){
		
		// Adding main menu
		add_menu_page( 
			'WordPress Plugin Boilerplate', // Title of the page
			'WP Boilerplate', // Menu Title
			'administrator', // Capability
			'wordpress-plugin-boilerplate-menu' // Menu Slug
			//auto::  create_function('', 'require_once( plugin_dir_path( __FILE__ ) . "views" . DS . "admin" . DS . "menu.php" );'), // Function 
			//auto::  '', // Image URL
			//auto::  7 // Menu Position
		);
		
		// Adding submenu for main menu
		add_submenu_page( 
			'wordpress-plugin-boilerplate-menu', // Parent Slug
			'WordPress Boilerplate', // Page title
			'WPB Menu', // Submenu title
			'administrator', // User capabilities
			'wordpress-plugin-boilerplate-menu', // Menu Slug
			create_function('', 'require_once( plugin_dir_path( __FILE__ ) . "views" . DS . "admin" . DS . "menu.php" );')
		);
		
		// Adding submenu
		add_submenu_page( 
			'wordpress-plugin-boilerplate-menu', // Parent Slug
			'WordPress Boilerplate Submenu', // Page title
			'WPB Submenu', // Submenu title
			'administrator', // User capabilities
			'wordpress-plugin-boilerplate-menu-submenu', // Menu Slug
			create_function('', 'require_once( plugin_dir_path( __FILE__ ) . "views" . DS . "admin" . DS . "sub-menu.php" );')
		);
	}
	
	/**
	 * 
	 * @function example_shortcode
	 * @description Shortcode example for the plugin
	 * @param array $data
	 * @return html
	 * 
	 * */
	public function example_shortcode($data){
		$this->shortcode_data = $data;
		// Including file for shortcode
		include $this->path . 'views' . DS . 'shortcodes' . DS . 'example_shortcode.php';
		return $this->shortcode_html;
	}
	
	/**
	 * 
	 * @function ajax_frontend_general_example
	 * @description Example of ajax call from non logged in and logged in users
	 * @param void
	 * @return void
	 * 
	 * */
	public function ajax_frontend_general_example(){
		check_ajax_referer('gb-ajax-nonce', '_gb_security');
		echo 'Response Content';
		wp_die();
	}
	
	/**
	 * 
	 * @function test_template
	 * @description Example of template functions
	 * @param array $data
	 * @return void
	 * @usage
	 * 	global $wordpress_plugin_boilerplage;
	 * 	$wordpress_plugin_boilerplage->test_template();
	 * */
	public function test_template($data = array(1, 2, 3, 5)){
		pr($data);
	}
	
	/**---------------------- Site Origin ----------------------**/
	/**
	 * 
	 * @function site_origin_widget_collection
	 * @description Adds siteorigin widget folders
	 * @param array $folders
	 * @return array $folders
	 * 
	 * */
	public function site_origin_widget_collection($folders){
		$folders[] = $this->path . 'views/widget/siteorigin/';
		return $folders;
	}
}

/**
 * 
 * @function pr
 * @description Formatted output of print_r function
 * @param mixed $obj
 * @return void
 * 
 * */
if(!function_exists('pr')):
function pr($obj){
	echo "<pre>"; 
	print_r($obj);
	echo "</pre>";
}
endif;

// Declaring the global variable for this plugin
global $wordpress_plugin_boilerplage;
$wordpress_plugin_boilerplage = new WordPressPluginBoilerplate('WordPress Plugin Boilerplage');
