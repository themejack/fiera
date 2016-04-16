<?php
/**
 * Template part for displaying location sections.
 *
 * @package Fiera
 */

global $block;

$map_output = '';
if ( ! empty( $block['map'] ) ) {
	$map_output = '<div class="map" data-marker="' . esc_attr( json_encode( $block['map'] ) ) . '"></div><!-- /.map -->';
}
?>
<div<?php the_block_class(); ?><?php the_block_id(); ?><?php the_block_attrs(); ?>>
	<?php
	if ( 'left' === $block['map_position'] ) {
		echo $map_output; // WPCS: XSS OK.
	} ?>
	<div class="custom-block__content custom-block__content--fluid">
		<?php echo apply_filters( 'the_content', $block['content'] ); // WPCS: XSS OK. ?>
	</div><!-- /.map content -->
	<?php
	if ( 'right' === $block['map_position'] ) {
		echo $map_output; // WPCS: XSS OK.
	} ?>
	<?php the_block_overlay(); ?>
</div><!-- /.hero block -->
