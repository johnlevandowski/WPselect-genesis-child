<?php
/**
 * Template Name: Landing
 * Description: Landing
 */

/** Add custom body class to the head */
add_filter( 'body_class', 'add_body_class' );
function add_body_class( $classes ) {
	$classes[] = 'wpselect-landing';
	return $classes;
}

/** Remove header, navigation, breadcrumbs, footer widgets, footer */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_action( 'genesis_before_header', 'genesis_do_subnav' );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_before_content_sidebar_wrap', 'wpselect_before_content_sidebar_wrap' );
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs');
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
add_action( 'genesis_header', 'wpselect_do_header' );
function wpselect_do_header() {
	echo '<div id="title-area">';
	do_action( 'genesis_site_title' );
	echo '</div><!-- end #title-area -->';
}

genesis();
