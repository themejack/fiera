<?php
/**
 * Template part for displaying sections.
 *
 * @package Fiera
 */

global $block;
?>

<div<?php the_block_class(); ?><?php the_block_id(); ?><?php the_block_attrs(); ?>>
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2 custom-block__content">
				<?php echo apply_filters( 'the_content', $block['content'] ); // WPCS: XSS OK. ?>
				<div class="custom-block__buttons">
				<!--
				<?php foreach ( $block['buttons'] as $button ) : ?>
					--><a href="<?php echo $button['link']; // WPCS: XSS OK. ?>" class="btn btn--regular btn--<?php echo $button['color']; // WPCS: XSS OK. ?> btn--transition"><?php echo $button['title']; // WPCS: XSS OK. ?></a><!--
				<?php endforeach; ?>
				-->
				</div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container -->
	<?php the_block_overlay(); ?>
</div><!-- /.custom block -->
