<?php
class bbPress_Pingbacks_Admin {

	/**
	 * Allow topic pingbacks options key
	 * @var string
	 */
	protected $allow_topic_pingbacks = '_bbp_allow_topic_pingbacks';
	/**
	 * Allow reply pingbacks options key
	 * @var string
	 */
	protected $allow_reply_pingbacks = '_bbp_allow_reply_pingbacks';

	function __construct() {
		add_filter( 'bbp_admin_get_settings_sections', 	array( $this, 'add_settings_section' 	 ) 		  );
		add_filter( 'bbp_admin_get_settings_fields', 	array( $this, 'add_settings_fields' 	 ) 		  );
		add_filter( 'bbp_map_settings_meta_caps', 		array( $this, 'set_settings_section_cap' ), 10, 4 );
	}

	/**
	 * @param bool $default
	 *
	 * @return bool
	 */
	public function allow_topic_pingbacks( $default  ) {
		return (bool) apply_filters( 'bbp_allow_topic_pingbacks', (bool) get_option( $this->allow_topic_pingbacks, $default ) );
	}

	/**
	 * @param bool $default
	 *
	 * @return bool
	 */
	public function allow_reply_pingbacks( $default ) {
		return (bool) apply_filters( 'bbp_allow_reply_pingbacks', (bool) get_option( $this->allow_reply_pingbacks, $default ) );
	}

	/**
	 * Adds settings section to the bbPress settings page
	 *
	 * @param array $sections
	 *
	 * @return array
	 */
	public function add_settings_section( $sections ) {
		$sections['bbp_settings_pingbacks'] = array(
			'title'    => __( 'Pingbacks Settings', 'bbpress-pingbacks' ),
			'callback' => array( $this, 'setting_section_description' ),
			'page'     => 'bbpress'
		);

		return $sections;
	}

	/**
	 * @param $caps
	 * @param $cap
	 * @param $user_id
	 * @param $args
	 *
	 * @return array
	 */
	public function set_settings_section_cap( $caps, $cap, $user_id, $args ) {
		if ( $cap !== 'bbp_settings_pingbacks' )
			return $caps;

		return array( bbpress()->admin->minimum_capability );
	}

	/**
	 *
	 */
	public function setting_section_description() {
		_e( 'Settings for the pingbacks functionality.', 'bbpress-pingbacks' );
	}

	/**
	 * Adds settings fields to the bbPress settings page
	 *
	 * @param array $settings
	 *
	 * @return array
	 */
	public function add_settings_fields( $settings ) {

		$settings['bbp_settings_pingbacks'] = array(

			// Allow topic pingbacks
			'_bbp_allow_topic_pingbacks' => array(
				'title'             => __( 'Topic Pingbacks', 'bbpress-pingbacks' ),
				'callback'          => array( $this, 'field_allow_topic_pingbacks' ),
				'sanitize_callback' => 'intval',
				'args'              => array()
			),
			// Allow reply pingbacks
			'_bbp_allow_reply_pingbacks' => array(
				'title'             => __( 'Reply Pingbacks', 'bbpress-pingbacks' ),
				'callback'          => array( $this, 'field_allow_reply_pingbacks' ),
				'sanitize_callback' => 'intval',
				'args'              => array()
			),
		);

		return $settings;
	}

	/**
	 *	Settings field for allow topic pingbacks
	 */
	public function field_allow_topic_pingbacks() {
		?>
	<input id="<?php echo $this->allow_topic_pingbacks; ?>" name="<?php echo $this->allow_topic_pingbacks; ?>" type="checkbox" value="1" <?php checked( bbp_allow_topic_pingbacks( false ) ); ?> />
	<label for="<?php echo $this->allow_topic_pingbacks; ?>"><?php _e( 'Show topic pingbacks', 'bbpress-pingbacks' ); ?></label>
	<?php
	}

	/**
	 * Settings field for allow reply pingbacks
	 */
	public function field_allow_reply_pingbacks() {
		?>
	<input id="<?php echo $this->allow_reply_pingbacks; ?>" name="<?php echo $this->allow_reply_pingbacks; ?>" type="checkbox" value="1" <?php checked( bbp_allow_reply_pingbacks( false ) ); ?> />
	<label for="<?php echo $this->allow_reply_pingbacks; ?>"><?php _e( 'Show reply pingbacks', 'bbpress-pingbacks' ); ?></label>
	<?php
	}

}