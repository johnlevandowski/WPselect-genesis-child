<?php
/**
 * Template Name: Archive
 * Description: Archive
 */

/** Remove standard post content output **/
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_action( 'genesis_post_content', 'genesis_do_post_content' );
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs');
add_action( 'genesis_post_content', 'wpselect_page_archive_content' );
function wpselect_page_archive_content() { ?>

	<div class="archive-page">

		<h2><?php _e( 'Posts:', 'genesis' ); ?></h2>
		<ul>
			<?php wp_get_archives( 'type=postbypost' ); ?>
		</ul>

	</div><!-- end .archive-page-->

	<div class="archive-page">

		<h2><?php _e( 'Pages:', 'genesis' ); ?></h2>
		<ul>
			<?php wp_list_pages( 'title_li=' ); ?>
		</ul>

		<h2><?php _e( 'Categories:', 'genesis' ); ?></h2>
		<ul>
			<?php wp_list_categories( 'sort_column=name&title_li=' ); ?>
		</ul>

		<h2><?php _e( 'Tags:', 'genesis' ); ?></h2>
		<ul>
			<?php wp_tag_cloud( 'sort_column=name&title_li=' ); ?>
		</ul>

	</div><!-- end .archive-page-->

<?php
}

genesis();
