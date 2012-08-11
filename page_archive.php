<?php
/**
 * Template Name: Archive
 * Description: Archive
 */

/** Remove standard post content output **/
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_action( 'genesis_post_content', 'genesis_do_post_content' );
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs');
/** wpselect_page_archive_content defined in lib/child-post.php */
add_action( 'genesis_post_content', 'wpselect_page_archive_content' );

genesis();
