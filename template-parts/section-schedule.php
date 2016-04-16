<?php
/**
 * Template part for displaying schedule sections.
 *
 * @package Fiera
 */

global $block; ?>

<div<?php the_block_class(); ?><?php the_block_id(); ?><?php the_block_attrs(); ?>>
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-7 col-sm-8 custom-block__content">
				<?php echo apply_filters( 'the_content', $block['content'] ); // WPCS: XSS OK. ?>
			</div><!-- /.col -->
		</div><!-- /.row -->

		<?php if ( ! empty( $block['tabs'] ) ) : ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="tabs">
					<ul class="nav nav-tabs" role="tablist">
					<?php foreach ( $block['tabs'] as $tab_id => $tab ) : ?>
						<li role="presentation"<?php if ( true === $tab['is_active'] ) : ?> class="active"<?php endif; ?>><a href="#<?php echo esc_attr( 'tab-' . $tab_id ); ?>" aria-controls="<?php echo esc_attr( 'tab-' . $tab_id ); ?>" role="tab" data-toggle="tab"><?php echo esc_html( $tab['title'] ); ?></a></li>
					<?php endforeach; ?>
					</ul>

					<div class="tab-content">
					<?php foreach ( $block['tabs'] as $tab_id => $tab ) : ?>
						<div role="tabpanel" class="tab-pane fade in<?php if ( true === $tab['is_active'] ) : ?> active<?php endif; ?>" id="<?php echo esc_attr( 'tab-' . $tab_id ); ?>">
							<?php echo apply_filters( 'the_content', $tab['content'] ); // WPCS: XSS OK. ?>
						</div>
					<?php endforeach; ?>
					</div>
				</div>
			</div><!-- /.col -->
		</div><!-- /.row -->
		<?php endif; ?>
	</div><!-- /.container -->
	<?php the_block_overlay(); ?>
</div><!-- /.custom block -->
