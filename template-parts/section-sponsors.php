<?php
/**
 * Template part for displaying sponsors sections.
 *
 * @package Fiera
 */

global $block;

$slides_to_show = (int) count( $block['sponsors'] ) - 1;
if ( $slides_to_show > 5 ) {
	$slides_to_show = 5;
}
if ( 0 === $slides_to_show ) {
	$slides_to_show = 1;
}
?>

<div<?php the_block_class(); ?><?php the_block_id(); ?><?php the_block_attrs(); ?>>
	<?php if ( $slides_to_show >= 1 ) : ?>
	<div class="photo-slider" data-slick='{ "slidesToShow": <?php echo (int) $slides_to_show; ?>, "slidesToScroll": 1, "autoplay": true, "autoplaySpeed": 2000 }'>
		<?php foreach ( $block['sponsors'] as $sponsor ) : ?>
		<div><a href="<?php echo esc_url( $sponsor['link'] ); ?>"><?php echo $sponsor['image']; // WPCS: XSS OK. ?></a></div>
		<?php endforeach; ?>
	</div><!-- /.photo slider -->
	<?php endif; ?>
	<?php the_block_overlay(); ?>
</div><!-- /.hero block -->
