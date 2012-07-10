<?php
/** Start the engine */
require_once( get_template_directory() . '/lib/init.php' );

/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'WPselect' );
define( 'CHILD_THEME_URL', 'http://wpselect.com/' );

/** Add Viewport meta tag for mobile browsers */
add_action( 'genesis_meta', 'add_viewport_meta_tag' );
function add_viewport_meta_tag() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

/** Add support for custom background */
add_theme_support( 'custom-background' );

/** Add support for custom header */
add_theme_support( 'genesis-custom-header', array( 'width' => 960, 'height' => 100 ) );

/** Add support for 3-column footer widgets */
add_theme_support( 'genesis-footer-widgets', 3 );

/** Before Content Sidebar Wrap Widget */
genesis_register_sidebar( array(
	'id'			=> 'wpselect_before_content_sidebar_wrap',
	'name'			=> __( 'Before Content Sidebar Wrap', 'genesis' ),
	'description'	=> __( 'Displays on all pages except single posts', 'genesis' ),
) );
add_action( 'genesis_before_content_sidebar_wrap', 'wpselect_before_content_sidebar_wrap' );
function wpselect_before_content_sidebar_wrap() {
	if ( !is_single() ) {
		genesis_widget_area( 'wpselect_before_content_sidebar_wrap', array(
		'before' => '<div class="wpselect_before_content_sidebar_wrap widget-area">',
		) );
	}
}

/** After Post Widget */
genesis_register_sidebar( array(
	'id'			=> 'wpselect_after_post',
	'name'			=> __( 'After First Post', 'genesis' ),
	'description'	=> __( 'Displays on archive pages after first post', 'genesis' ),
) );
add_action( 'genesis_after_post', 'wpselect_after_post' );
function wpselect_after_post() {
	global $loop_counter;
	if ( !is_singular() ) {
		if ( $loop_counter == 0) {
			genesis_widget_area( 'wpselect_after_post', array(
			'before' => '<div class="wpselect_after_post widget-area">',
			) );
		}
	}
}

/** Before Post Content Widget */
genesis_register_sidebar( array(
	'id'			=> 'wpselect_before_post_content',
	'name'			=> __( 'Before Post Content', 'genesis' ),
	'description'	=> __( 'Displays on single posts before content', 'genesis' ),
) );
add_action( 'genesis_before_post_content', 'wpselect_before_post_content' );
function wpselect_before_post_content() {
	if ( is_single() ) {
		genesis_widget_area( 'wpselect_before_post_content', array(
		'before' => '<div class="wpselect_before_post_content widget-area">',
		) );
	}
}

/** After Post Content Widget */
genesis_register_sidebar( array(
	'id'			=> 'wpselect_after_post_content',
	'name'			=> __( 'After Post Content', 'genesis' ),
	'description'	=> __( 'Displays on single posts after content', 'genesis' ),
) );
add_action( 'genesis_after_post_content', 'wpselect_after_post_content', 1 );
function wpselect_after_post_content() {
	if ( is_single() ) {
		genesis_widget_area( 'wpselect_after_post_content', array(
		'before' => '<div class="wpselect_after_post_content widget-area">',
		) );
	}
}
