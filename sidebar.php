<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Fiera
 */

$sidebar_classes = fiera_sidebar_classes( array(), false );

if ( ! is_active_sidebar( 'sidebar-1' ) || null === $sidebar_classes ) {
	return;
}
?>

<div class="<?php echo esc_attr( join( ' ', $sidebar_classes ) ); ?>">
	<div id="secondary" class="widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div><!-- #secondary -->
</div>
