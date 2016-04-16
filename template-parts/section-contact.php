<?php
/**
 * Template part for displaying contact sections.
 *
 * @package Fiera
 */

global $block; ?>

<div<?php the_block_class(); ?><?php the_block_id(); ?><?php the_block_attrs(); ?>>
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 custom-block__content">
				<?php echo apply_filters( 'the_content', $block['content'] ); // WPCS: XSS OK. ?>
			</div><!-- /.col -->
		</div><!-- /.row -->

		<?php if ( ! empty( $block['form'] ) ) : ?>
		<div class="row">
			<div class="col-lg-12 custom-block__content">
				<?php echo apply_filters( 'the_content', $block['form'] ); // WPCS: XSS OK. ?>
			</div>
		</div>
		<?php endif; ?>
	</div><!-- /.container -->
	<?php the_block_overlay(); ?>
</div><!-- /.custom block -->
