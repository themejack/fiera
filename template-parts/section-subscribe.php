<?php
/**
 * Template part for displaying subscribe sections.
 *
 * @package Fiera
 */

global $block; ?>

<div<?php the_block_class(); ?><?php the_block_id(); ?><?php the_block_attrs(); ?>>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 custom-block__content">
				<?php echo apply_filters( 'the_content', $block['content'] ); // WPCS: XSS OK. ?>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container -->
	<?php the_block_overlay(); ?>
</div><!-- /.custom block -->
