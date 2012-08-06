<?php
/** Remove default loop **/
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_action( 'genesis_before_content_sidebar_wrap', 'wpselect_before_content_sidebar_wrap' );
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'wpselect_404' );
function wpselect_404() { ?>

	<div class="post hentry">

		<h1 class="entry-title"><?php _e( 'Page Not Found', 'genesis' ); ?></h1>
		<div class="entry-content">
			<p>The page you are looking for no longer exists. Perhaps you can try searching for it or use one of the following links.</p>

			<?php get_search_form(); ?>

			<br />

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

		</div><!-- end .entry-content -->

	</div><!-- end .postclass -->

<?php
}

genesis();
