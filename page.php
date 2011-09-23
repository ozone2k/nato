<?php get_header(); ?>

	<div id="content" class="span-24 last">
    	<div class=" span-16 append-1">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="post" id="post-<?php the_ID(); ?>">
            <h2><?php the_title(); ?></h2>
            
            <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
    
            </div>
            <?php endwhile; endif; ?>
        </div>
        
        <div class="span-6 append-1 last right-side">
        	<?php get_sidebar(); ?>
        </div>

	
	</div>

	
    
    

<?php get_footer(); ?>

	

