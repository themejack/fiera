<?php
/**
 * The template for displaying front page.
 *
 * @package Fiera
 */

global $fiera_data;
$block = array();

get_header(); ?>
<?php if ( ! empty( $fiera_data ) ) : ?>
	<?php if ( ! empty( $fiera_data['hero'] ) ) : ?>
		<div class="hero-subheader" style="background-image: url(<?php echo $fiera_data['hero']['background'][0]; // WPCS: XSS OK. ?>)">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="hero-content">
							<h2 class="hero-content__title"><?php echo $fiera_data['hero']['title']; // WPCS: XSS OK. ?></h2>

							<h4 class="hero-content__info"><?php echo $fiera_data['hero']['info']; // WPCS: XSS OK. ?></h4>

							<h3 class="hero-content__intro"><?php echo $fiera_data['hero']['intro']; // WPCS: XSS OK. ?></h3>

							<ul class="hero-content__buttons">
							<!--
							<?php foreach ( $fiera_data['hero']['buttons'] as $button ) : ?>
							--><li><a href="<?php echo $button['link']; // WPCS: XSS OK. ?>" class="btn btn--regular btn--<?php echo $button['color']; // WPCS: XSS OK. ?> btn--transition"><?php echo $button['title']; // WPCS: XSS OK. ?></a></li><!--
							<?php endforeach; ?>
							-->
							</ul>
						</div><!-- /.content -->
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container -->

			<div class="hero-subheader__overlay" style="background-color: rgba(0, 0, 0, 0.4);"></div><!-- /.overlay -->
		</div><!-- /.hero subheader -->
	<?php endif; ?>

		<?php if ( ! empty( $fiera_data['sections'] ) && isset( $fiera_data['sections']['blocks'] ) && ! empty( $fiera_data['sections']['blocks'] ) ) :
			foreach ( $fiera_data['sections']['blocks'] as $block ) :
				if ( setup_block_data( $block ) ) :
					get_template_part( 'template-parts/section', isset( $block['type'] ) ? str_replace( '_', '-', $block['type'] ) : '' );
				endif;
			endforeach;
		endif; ?>

<?php endif; ?>

<?php get_footer();
