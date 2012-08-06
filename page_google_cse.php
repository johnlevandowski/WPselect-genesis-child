<?php
/**
 * Template Name: Google Custom Search
 * Description: Google Custom Search
 */

/**
  * Force full-width layout
  */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_action( 'genesis_before_content_sidebar_wrap', 'wpselect_before_content_sidebar_wrap' );
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs');

/**
  * Add Google CSE javascript to header
  */
add_action('genesis_meta', 'wpselect_google_cse_meta');
function wpselect_google_cse_meta() { ?>
<script type="text/javascript">
  (function() {
    var cx = '<?php echo esc_attr( genesis_get_option('wpselect-google-cse-id', 'wpselect-child-settings') ); ?>';
    var gcse = document.createElement('script'); gcse.type = 'text/javascript'; gcse.async = true;
    gcse.src = (document.location.protocol == 'https' ? 'https:' : 'http:') +
        '//www.google.com/cse/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(gcse, s);
  })();
</script><?php
}

/**
  * Remove standard post content output
  */
remove_action( 'genesis_post_content', 'genesis_do_post_content' );
add_action( 'genesis_post_content', 'wpselect_google_cse_content' );
function wpselect_google_cse_content() { ?>
<gcse:searchresults-only></gcse:searchresults-only><?php
}

genesis();
