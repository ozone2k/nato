<?php get_header(); ?>

	<div id="content" class="span-24 last">
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<?php include('folio-format-single.php'); ?>
	
	<?php /*?>
        <?php comments_template(); ?>
    <?php */?>	
    
    <?php endwhile; else: ?>
    
            <p>Sorry, no posts matched your criteria.</p>
    
    <?php endif; ?>

	</div>

<?php get_footer(); ?>
