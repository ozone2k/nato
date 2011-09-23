<?php get_header(); ?>

	<div id="content" class="span-24 last">
    	<div class=" span-16 append-1">
			<?php if (have_posts()) : ?>
        		<h2>All works</h2>
				<?php while (have_posts()) : the_post(); ?>
        		    <?php include('folio-format.php'); ?>
                <?php endwhile; ?>
                <div class="navigation clear">
                    <div class="alignleft"><?php next_posts_link('&laquo; Previous Page') ?></div>
                    <div class="alignright"><?php previous_posts_link('Next Page &raquo;') ?></div>
                </div>
            <?php else : ?>
                <h2 class="center">Not Found</h2>
                <p class="center">Sorry, but you are looking for something that isn't here.</p>
            <?php endif; ?>
        </div>
        
        <div class="span-6 append-1 last right-side">
        	<?php get_sidebar(); ?>
        </div>

	
	</div>

	
    
    

<?php get_footer(); ?>
