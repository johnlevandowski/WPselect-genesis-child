<?php /*
YARPP Related Posts
Author: wpselect.com
*/
?><div class="yarpp entry-content">
<h3>Related Posts</h3>
<?php if (have_posts()):?>
<ul>
	<?php while (have_posts()) : the_post(); ?>
	<li><a href="<?php the_permalink() ?>" onclick="javascript:_gaq.push(['_trackEvent','related-post-click','yarpp']);" rel="bookmark"><?php the_title(); ?></a><!-- (<?php the_score(); ?>)--></li>
	<?php endwhile; ?>
</ul>
<?php else: ?>
<p>No related posts.</p>
<?php endif; ?>
</div>
