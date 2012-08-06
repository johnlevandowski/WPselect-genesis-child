<?php
/**
 * Child Theme Settings
 */ 

/**
 * Registers a new admin page, providing content and corresponding menu item
 * for the Child Theme Settings page.
 */
class Child_Theme_Settings extends Genesis_Admin_Boxes {

	/**
	 * Create an admin menu item and settings page.
	 */
	function __construct() {

		// Specify a unique page ID. 
		$page_id = 'wpselect-child';

		// Set it as a child to genesis, and define the menu and page titles
		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'genesis',
				'page_title'  => 'Genesis - Child Theme Settings',
				'menu_title'  => 'Child Theme Settings',
			)
		);

		// Set up page options. These are optional, so only uncomment if you want to change the defaults
		$page_ops = array(
		//	'screen_icon'       => 'options-general',
		//	'save_button_text'  => 'Save Settings',
		//	'reset_button_text' => 'Reset Settings',
		//	'save_notice_text'  => 'Settings saved.',
		//	'reset_notice_text' => 'Settings reset.',
		);		

		// Give it a unique settings field. 
		// You'll access them from genesis_get_option( 'option_name', 'child-settings' );
		$settings_field = 'wpselect-child-settings';

		// Set the default values
		$default_settings = array(
			'wpselect-google-cse-id'   => '',
		);

		// Create the Admin Page
		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

		// Initialize the Sanitization Filter
		add_action( 'genesis_settings_sanitizer_init', array( $this, 'sanitization_filters' ) );

	}

	/** 
	 * Set up Sanitization Filters
	 */	
	function sanitization_filters() {

		genesis_add_option_filter( 'no_html', $this->settings_field,
			array(
				'wpselect-google-cse-id',
			) );
	}

	/**
	 * Set up Help Tab
	 */
	 function help() {
	 	$screen = get_current_screen();

		$screen->add_help_tab( array(
			'id'      => 'sample-help', 
			'title'   => 'Sample Help',
			'content' => '<p>Help content goes here.</p>',
		) );
	 }

	/**
	 * Register metaboxes on Child Theme Settings page
	 */
	function metaboxes() {
		add_meta_box('wpselect-cse-settings', 'Google Custom Search', array( $this, 'wpselect_cse_settings_box' ), $this->pagehook, 'main', 'high');
	}

	function wpselect_cse_settings_box() {
		echo '<p><label for="' . $this->get_field_name( 'wpselect-google-cse-id' ) . '">Search engine unique ID:</label><br />';
		echo '<input type="text" name="' . $this->get_field_name( 'wpselect-google-cse-id' ) . '" id="' . $this->get_field_id( 'wpselect-google-cse-id' ) . '"  value="' . esc_attr($this->get_field_value( 'wpselect-google-cse-id' ) ) . '" size="50" /></p>';
		echo '<p><span class="description">Create a <a href="' . admin_url( 'edit.php?post_type=page' ) . '">Page</a> with a permalink of <a href="' . home_url('/google-cse/') . '">' . home_url('/google-cse/') . '</a> and apply the <code>Google Custom Search</code> template.</span></p>';
	}

}

add_action( 'genesis_admin_menu', 'wpselect_add_child_theme_settings' );
/**
 * Add the Theme Settings Page
 */
function wpselect_add_child_theme_settings() {
	global $_child_theme_settings;
	$_child_theme_settings = new Child_Theme_Settings;	 	
}
