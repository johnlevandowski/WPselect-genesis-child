<?php
/**
 * Creates the Child Theme Custom Post Content Functions.
 */

/**
 * Archive Page Post Content
 * Displays on Archive and 404 pages
 */
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
		<?php wp_list_categories( 'title_li=' ); ?>
	</ul>

	<h2><?php _e( 'Tags:', 'genesis' ); ?></h2>
		<?php wp_tag_cloud(); ?>

</div><!-- end .archive-page-->

<?php
}
