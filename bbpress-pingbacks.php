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
include_once "bbpress-pingbacks-admin.php";

class bbPress_Pingbacks {

	/**
	 * Singleton instance of this class
	 * @var bbPress_Pingbacks
	 */
	protected static $instance;

	/**
	 * @var bbPress_Pingbacks_Admin
	 */
	public $admin;

	/* Path of the templates included in this plugin */
	protected $templates_path;

	protected $pingbacks = null;
	protected $current_pingback = null;

	function __construct() {
		add_action( 'bbp_theme_after_reply_content', 	array( $this, 'add_reply_pingbacks_template'	) );
		add_action( 'bbp_template_after_replies_loop', 	array( $this, 'add_topic_pingbacks_template'	) );

		add_filter( 'bbp_get_template_stack', array( $this, 'add_templates_folder' ) );

		$this->templates_path = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'templates';

		$this->admin = new bbPress_Pingbacks_Admin();
	}

	/**
	 * Adds the pingbacks template after the replies loop
	 */
	public function add_topic_pingbacks_template() {
		bbp_get_template_part( 'loop', 'topic-pingbacks' );
	}

	/**
	 * Adds the pingbacks template after each single reply
	 */
	public function add_reply_pingbacks_template() {
		bbp_get_template_part( 'loop', 'reply-pingbacks' );
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


	/**
	 * Loads the pingbacks for a given post
	 *
	 * @param int $post_id
	 */
	public function load_pingbacks( $post_id = null ) {

		/* We don't want the topic pingbacks on the first post */
		if ( bbp_get_reply_id() == bbp_get_topic_id() )
			return;

		if ( empty( $post_id ) ) {
			$post_id = bbp_get_reply_id();
			if ( empty( $post_id ) )
				$post_id = bbp_get_topic_id();
		}

		$this->current_pingback = null;

		$args = apply_filters( 'bbp_query_pingbacks', array(
			'post_id'   => $post_id,
			'type'      => 'pingback',
			'approve'   => 1,
		) );

		$query = new WP_Comment_Query;

		$this->pingbacks = $query->query( $args );
	}

	/**
	 * Loads the pingbacks on the first call, and then returns true until
	 * all the pingbacks were traversed with the_pingback
	 *
	 * @return bool
	 */
	public function have_pingbacks() {

		if ( $this->pingbacks === null )
			$this->load_pingbacks();

		if ( empty( $this->pingbacks ) ) {
			$this->pingbacks = null;
			return false;
		}

		return true;
	}

	/**
	 * Advances the pingbacks array and returns the current pingback
	 * @return null
	 */
	public function the_pingback() {
		$this->current_pingback = array_shift( $this->pingbacks );
		return $this->current_pingback();
	}

	/**
	 * Returns the current pingback
	 * @return null
	 */
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