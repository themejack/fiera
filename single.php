<?php
/**
 * The template for displaying all single posts.
 *
 * @package Fiera
 */

get_header(); ?>

<div class="container">
	<div class="row">
		<div<?php fiera_main_classes(); ?>>
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', 'single' ); ?>

					<?php the_post_navigation(); ?>

					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>

				<?php endwhile; // End of the loop. ?>

				</main><!-- #main -->
			</div><!-- #primary -->
		</div><!-- /.col -->

		<?php get_sidebar(); ?>
	</div><!-- /.row -->
</div><!-- /.container -->

<?php get_footer();
