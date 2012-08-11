<?php
/**
 * Creates the Child Theme Settings page.
 * genesis/lib/admin/seo-settings.php
 */

/**
 * Registers a new admin page, providing content and corresponding menu item
 * for the Child Theme Settings page.
 */

// Specify a class
class WPselect_Child_Theme_Settings extends Genesis_Admin_Boxes {

	/**
	 * Create an admin menu item and settings page.
	 */
	function __construct() {

		// Specify a page_id
		$page_id = 'wpselect-settings';

		// Specify a page_title and menu_title
		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'genesis',
				'page_title'  => __( 'Child Theme Settings', 'genesis' ),
				'menu_title'  => __( 'Child Theme Settings', 'genesis' )
			)
		);

		$page_ops = array(
			'screen_icon'       => 'options-general',
			'save_button_text'  => __( 'Save Settings', 'genesis' ),
			'reset_button_text' => __( 'Reset Settings', 'genesis' ),
			'saved_notice_text' => __( 'Settings saved.', 'genesis' ),
			'reset_notice_text' => __( 'Settings reset.', 'genesis' ),
			'error_notice_text' => __( 'Error saving settings.', 'genesis' ),
		);

		// Specify a settings field
		// used by genesis_get_option( 'option_name', 'settings_field')
		$settings_field = 'wpselect-child-theme-settings';

		// Set default values for options
		$default_settings = array(
			'google-cse-id' => '009034775234597001862:WMX2724661',
			'credits-text' => 'Powered by <a title="Genesis Framework" href="http://www.studiopress.com/themes/genesis">Genesis</a>, <a title="Hosting by HostGator" href="http://wpselect.com/go/hostgator/">HostGator</a>, [footer_wordpress_link] and [wpselect_page_stats]

Copyright [footer_copyright] · <a title="Privacy Policy" href="/privacy-policy/">Privacy Policy</a> · <a title="Disclaimer" href="/disclaimer/">Disclaimer</a> · <a title="FTC Disclosure" href="/ftc-disclosure/">FTC Disclosure</a> · <a title="Image Attribution" href="/image-attribution/">Image Attribution</a>',
		);

		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

		add_action( 'genesis_settings_sanitizer_init', array( $this, 'sanitizer_filters' ) );

	}

	/**
	 * Registers each of the settings with a sanitization filter type.
	 */
	public function sanitizer_filters() {

		// Specify sanitization filter for options
		genesis_add_option_filter(
			'no_html',
			$this->settings_field,
			array(
				'google-cse-id',
			)
		);
		
		genesis_add_option_filter(
			'safe_html',
			$this->settings_field,
			array(
				'credits-text',
			)
		);

	}

	/**
 	 * Register meta boxes on the Child Theme Settings page.
 	 */
	function metaboxes() {

		// Add meta box and content display function below
		add_meta_box( 'wpselect-google-cse-settings', __( 'Google Custom Search Engine', 'genesis' ), array( $this, 'wpselect_google_cse_settings_box' ), $this->pagehook, 'main' );
		
		add_meta_box( 'wpselect-credits-text', __( 'Footer Credits', 'genesis' ), array( $this, 'wpselect_credits_text_box' ), $this->pagehook, 'main' );

	}

	/**
	 * Callback for meta box.
	 */
	function wpselect_google_cse_settings_box() {
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'google-cse-id' ); ?>"><?php _e( 'Search engine unique ID:', 'genesis' ); ?></label>
			<input type="text" name="<?php echo $this->get_field_name( 'google-cse-id' ); ?>" id="<?php echo $this->get_field_id( 'google-cse-id' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'google-cse-id' ) ); ?>" size="40" />
		</p>
		<p>
			<span class="description"><?php printf( __( 'Create a <a href="%s">Page</a> with a permalink of <a href="%s">%s</a> and apply the <code>Google Custom Search</code> template.', 'genesis' ), admin_url('edit.php?post_type=page'), home_url('/google-cse/'), home_url('/google-cse/') ); ?></span>
		</p>

		<?php
	}
	
	function wpselect_credits_text_box() {
		wp_editor( $this->get_field_value( 'credits-text' ), $this->get_field_id( 'credits-text' ), array(
				'media_buttons' => false,
				'textarea_rows' => 8
				)
			);
		?>
		<p>
			<span class="description"><?php _e( 'Safe HTML and WordPress Shortcodes allowed.', 'genesis' ); ?></span>
		</p>

		<?php
	}
	
	/**
	 * Set up Help Tab
	 * http://codex.wordpress.org/Function_Reference/add_help_tab
	 * genesis/lib/classes/admin.php
	 */
	function help() {
		$screen = get_current_screen();

		// Specify id, title, and content		
		$screen->add_help_tab( array( 
			'id'      => 'wpselect-help-id',
			'title'   => 'Child Theme Help',
			'content' => '<p>Help content goes here.</p>',
		) );
	}

}

/**
 * Adds submenu items under Genesis item in admin menu.
 * genesis/lib/admin/menu.php
 */
add_action( 'genesis_admin_menu', 'wpselect_add_admin_submenus' );
function wpselect_add_admin_submenus() {

	/** Do nothing, if not viewing the admin */
	if ( ! is_admin() )
		return;

	/** Don't add submenu items if Genesis menu is disabled */
	if( ! current_theme_supports( 'genesis-admin-menu' ) )
		return;

	/** Add submenu item using new class */
	global $_wpselect_child_theme_settings;
	$_wpselect_child_theme_settings = new WPselect_Child_Theme_Settings;

}
