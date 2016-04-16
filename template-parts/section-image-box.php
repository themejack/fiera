<?php
/**
 * Template part for displaying image box sections.
 *
 * @package Fiera
 */

global $block;

$image_output = '';
if ( ! empty( $block['image'] ) && ! is_wp_error( $block['image'] ) ) {
	$image_output = '<div class="custom-block__image" style="background-image: url(' . esc_url( $block['image'][0] ) . ')"></div><!-- /.hero block image -->';
}
?>
<div<?php the_block_class(); ?><?php the_block_id(); ?><?php the_block_attrs(); ?>>
	<?php
	if ( 'left' === $block['image_position'] ) {
		echo $image_output; // WPCS: XSS OK.
	} ?>
	<div class="custom-block__content custom-block__content--fluid">
		<?php echo apply_filters( 'the_content', $block['content'] ); // WPCS: XSS OK. ?>
	</div><!-- /.map content -->
	<?php
	if ( 'right' === $block['image_position'] ) {
		echo $image_output; // WPCS: XSS OK.
	} ?>
	<?php the_block_overlay(); ?>
</div><!-- /.hero block -->
