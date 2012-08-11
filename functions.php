<?php
/** Start the engine */
require_once( get_template_directory() . '/lib/init.php' );

/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'WPselect' );
define( 'CHILD_THEME_URL', 'http://wpselect.com/' );

/** Child Theme Settings */
include_once( CHILD_DIR . '/lib/child-theme-settings.php');

/** Child Theme Widget Areas */
include_once( CHILD_DIR . '/lib/child-widgetize.php');

/** Child Theme Custom Post Content Functions */
include_once( CHILD_DIR . '/lib/child-post.php');

/** Add Viewport meta tag for mobile browsers */
add_action( 'genesis_meta', 'add_viewport_meta_tag' );
function add_viewport_meta_tag() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

/** Add support for custom background */
add_theme_support( 'custom-background' );

/**
 * Add support for custom header
 * genesis/lib/structure/header.php
 */
add_theme_support( 'custom-header', array( 'width' => 960, 'flex-height' => true, 'height' => 90, 'default-text-color' => 'fff', 'wp-head-callback' => 'wpselect_custom_header_style' ) );
function wpselect_custom_header_style() {
	/** If no options set, don't waste the output. Do nothing. */
	if ( HEADER_TEXTCOLOR == get_header_textcolor() && HEADER_IMAGE == get_header_image() )
		return;
	/** Header image CSS */
	$output = sprintf( '#header .wrap { background-image: url(%s); min-height: %spx }', esc_url( get_header_image() ), get_custom_header()->height );
	/** Header text color CSS, if showing text */
	if ( 'blank' != get_header_textcolor() )
		$output .= sprintf( '#title a, #title a:hover, #description { color: #%s; }', esc_html( get_header_textcolor() ) );
	printf( '<style type="text/css">%s</style>', $output );
}

/** Add support for 3-column footer widgets */
add_theme_support( 'genesis-footer-widgets', 3 );

/** Move secondary nav menu above header */
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before_header', 'genesis_do_subnav' );

/**
 * Remove default stylesheet
 * Add minified stylesheet with version number
 * genesis/lib/structure/layout.php
 */
remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
add_action( 'genesis_meta', 'wpselect_load_stylesheet' );
function wpselect_load_stylesheet() {
	wp_register_style(
		'wpselect-style',
		CHILD_URL . '/style-min.css',
		false,
		filemtime( CHILD_DIR . '/style-min.css' )
	);
	wp_enqueue_style( 'wpselect-style' );
}

/**
 * Customize the post info function
 * genesis/lib/structure/post.php
 */
add_filter( 'genesis_post_info', 'wpselect_post_info' );
function wpselect_post_info($post_info) {
if (!is_page()) {
    $post_info = '[post_date] [post_comments] [post_edit]';
    return $post_info;
	}
}

/**
 * Shortcode to display number of MySQL queries and time to generate page
 */
add_shortcode( 'wpselect_page_stats', 'wpselect_page_stats_shortcode' );
function wpselect_page_stats_shortcode( $atts ) {
	$defaults = array(
		'after'  => '',
		'before' => '',
	);
	$atts = shortcode_atts( $defaults, $atts );
	$output = $atts['before'] . get_num_queries() . ' MySQL queries in ' . timer_stop($display = 0, $precision = 2) . ' seconds' . $atts['after'];
	return $output;
}

/**
 * Customize the credits
 * genesis/lib/structure/footer.php
 */
add_filter('genesis_footer_creds_text', 'wpselect_footer_creds_text');
function wpselect_footer_creds_text($creds_text) {
	$creds_text = wpautop( genesis_get_option('credits-text', 'wpselect-child-theme-settings') );
	return $creds_text;
}

/** Modify the length of post excerpts 55 default */
add_filter( 'excerpt_length', 'wpselect_excerpt_length' );
function wpselect_excerpt_length($length) {
    return 60;
}

/** Modify the more link of post excerpts */
add_filter('excerpt_more', 'wpselect_excerpt_more');
function wpselect_excerpt_more($more) {
	global $post;
	return ' ... <a href="' . get_permalink($post->ID) . '">[Read more...]</a>';
}

/** Lower jpeg quality for media */
add_filter( 'jpeg_quality', 'wpselect_jpeg_quality' );
function wpselect_jpeg_quality( $quality ) {
	return (int)79;
}

/**
 * Customize the search text
 * genesis/lib/structure/search.php
 */
add_filter( 'genesis_search_text', 'wpselect_genesis_search_text');
function wpselect_genesis_search_text() {
	return esc_attr('Google Search ...');
}

/**
 * Customize the search form
 * genesis/lib/structure/search.php
 */
add_filter( 'genesis_search_form', 'wpselect_genesis_search_form', 10, 4);
function wpselect_genesis_search_form( $form, $search_text, $button_text, $label ) {
	$onfocus = " onfocus=\"if (this.value == '$search_text') {this.value = '';}\"";
	$onblur  = " onblur=\"if (this.value == '') {this.value = '$search_text';}\"";
	$form = '
		<form method="get" class="searchform" action="' . esc_attr( genesis_get_option('google-cse-url', 'wpselect-child-theme-settings') ) . '" >' . $label . '
		<input type="text" value="' . $search_text . '" name="q" class="s"' . $onfocus . $onblur . ' />
		<input type="submit" name="submit" class="searchsubmit" value="' . $button_text . '" />
		</form>
	';
	return $form;
}

/** YARPP Related Posts */
add_action( 'genesis_after_post_content', 'wpselect_related_posts', 9 );
function wpselect_related_posts() {
	if ( is_single() ) { 
		if ( function_exists('related_posts') ) : related_posts(); endif;
	}
}
