<?php /*
YARPP Related Posts
Author: wpselect.com
*/
?>
<?php if (have_posts()):?>
<div class="yarpp entry-content">
<h3>Related Posts</h3>
<ul>
	<?php while (have_posts()) : the_post(); ?>
	<li><a href="<?php the_permalink() ?>" onclick="javascript:_gaq.push(['_trackEvent','related-post-click','yarpp']);" rel="bookmark"><?php the_title(); ?></a><!-- (<?php the_score(); ?>)--></li>
	<?php endwhile; ?>
</ul>
</div>
<?php endif; ?>
