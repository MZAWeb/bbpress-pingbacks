<?php
/**
 * Plugin Name: bbPress Pingbacks
 * Plugin URI:  https://github.com/MZAWeb/bbpress-pingbacks
 * Description: Shows topic and replies pingbacks.
 * Author:      Daniel Dvorkin
 * Plugin URI:  http://danieldvork.in
 * Version:     0.1
 * Text Domain: bbpress-pingbacks
 * Domain Path: /languages/
 */

include_once "template-tags.php";

class bbPress_Pingbacks {

	/* Singleton instance of this class */
	protected static $instance;

	/* Path of the templates included in this plugin */
	protected $templates_path;

	protected $pingbacks = null;
	protected $current_pingback = null;

	function __construct() {
		add_action( 'bbp_template_after_replies_loop', array( $this, 'add_topic_pingbacks_template' ) );

		add_filter( 'bbp_get_template_stack', array( $this, 'add_templates_folder' ) );

		$this->templates_path = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'templates';

	}

	/**
	 * Adds the pingbacks template after the replies loop
	 */
	public function add_topic_pingbacks_template() {
		bbp_get_template_part( 'pingbacks', 'topic' );
	}

	/**
	 * Registers the templates folder in this plugin on bbPress template stack
	 *
	 * @param $templates
	 *
	 * @return array
	 */
	public function add_templates_folder( $templates ) {
		$templates[] = $this->templates_path;
		return $templates;
	}


	/********* HELPER FUNCTIONS **************/

	public function load_pingbacks( $post_id = null ) {

		if ( empty( $post_id ) )
			$post_id = get_the_ID();

		$this->current_pingback = null;

		$args = apply_filters( 'bbp_query_pingbacks', array(
			'post_id'   => $post_id,
			'type'      => 'pingback',
			'approve'   => 1,
		) );

		$query = new WP_Comment_Query;

		$this->pingbacks = $query->query( $args );
	}

	public function have_pingbacks() {

		if ( $this->pingbacks === null )
			$this->load_pingbacks();

		if ( empty( $this->pingbacks ) )
			return false;
		return true;
	}

	public function the_pingback() {
		$this->current_pingback = array_shift( $this->pingbacks );
		return $this->current_pingback();
	}

	public function current_pingback() {
		return $this->current_pingback;
	}

	/**
	 * Singleton function to get the only instance of this class
	 *
	 * @static
	 * @return bbPress_Pingbacks
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new bbPress_Pingbacks;
		}
		return self::$instance;
	}
}

/* Loads the plugin */
add_action( 'plugins_loaded', 'bbp_pingbacks' );