<?php
/*
Template Name: Blog
*/
?>

<?php get_header(); ?>

	<div id="content">
		
	<?php get_posts('&category=Blog')?>

	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>

			<?php include('folio-format.php'); ?>

		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>

	<?php else : ?>

		<h2 class="center">Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>

	<?php endif; ?>

	</div>

<?php get_footer(); ?>
