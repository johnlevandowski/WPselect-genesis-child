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

/** Add support for custom header genesis/lib/structure/header.php */
add_theme_support( 'custom-header', array( 'width' => 960, 'flex-height' => true, 'height' => 100, 'default-text-color' => 'fff', 'wp-head-callback' => 'wpselect_custom_header_style' ) );
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

/** Add version number to stylesheet genesis/lib/structure/layout.php */
remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
add_action( 'genesis_meta', 'wpselect_load_stylesheet' );
function wpselect_load_stylesheet() {
	/** Show Child Info */
	$child_info = wp_get_theme() ;
	echo '<link rel="stylesheet" href="' . get_bloginfo( 'stylesheet_url' ) . '?ver=' . esc_attr( $child_info['Version'] ) . '" type="text/css" media="screen" />'."\n";
}

/** Customize the post info function genesis/lib/structure/post.php */
add_filter( 'genesis_post_info', 'wpselect_post_info' );
function wpselect_post_info($post_info) {
if (!is_page()) {
    $post_info = '[post_date] [post_edit] [post_comments]';
    return $post_info;
	}
}

/** Customize the credits genesis/lib/structure/footer.php */
add_filter('genesis_footer_creds_text', 'wpselect_footer_creds_text');
function wpselect_footer_creds_text($creds_text) {
	$creds_text = 'Powered by <a href="http://www.studiopress.com/themes/genesis" title="Genesis Framework">Genesis</a>, <a href="http://wpselect.com/go/hostgator/" title="Hosting by HostGator">HostGator</a>, [footer_wordpress_link] and ';
	$creds_text .= get_num_queries(). ' MySQL queries in ' . timer_stop($display = 0, $precision = 2) . ' seconds<br />';
	$creds_text .= 'Copyright [footer_copyright] &middot; <a href="/privacy-policy/" title="Privacy Policy">Privacy Policy</a> &middot; <a href="/disclaimer/" title="Disclaimer">Disclaimer</a> &middot; <a href="/ftc-disclosure/" title="FTC Disclosure">FTC Disclosure</a> &middot; <a href="/image-attribution/" title="Image Attribution">Image Attribution</a>';
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

/** YARPP Related Posts */
add_action( 'genesis_after_post_content', 'wpselect_related_posts', 9 );
function wpselect_related_posts() {
	if ( is_single() ) { 
		if ( function_exists('related_posts') ) : related_posts(); endif;
	}
}
