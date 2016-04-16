<?php
/**
 * Template part for displaying tickets sections.
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

		<?php if ( ! empty( $block['tickets'] ) ) : ?>
		<div class="row">
			<?php foreach ( $block['tickets'] as $ticket ) : ?>
			<div class="col-md-4 col-sm-6">
				<div class="custom-block__content">
					<div class="ticket-card">
						<?php if ( isset( $ticket['name'] ) && ! empty( $ticket['name'] ) ) : ?>
						<h3><?php echo esc_html( $ticket['name'] ); ?></h3>
						<?php endif; ?>

						<?php echo apply_filters( 'the_content', $ticket['description'] ); // WPCS: XSS OK. ?>

						<hr class="ticket-card__divider">

						<?php if ( isset( $ticket['price'] ) && ! empty( $ticket['price'] ) ) : ?>
						<span class="ticket-card__price"><?php echo esc_html( $ticket['price'] ); ?></span>
						<?php endif; ?>

						<?php if ( isset( $ticket['link'] ) && ! empty( $ticket['link'] ) ) : ?>
						<a href="<?php echo esc_url( $ticket['link'] ); ?>" class="btn btn--regular btn--red btn--transition"><?php esc_html_e( 'Buy now', 'fiera' ); ?></a>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</div><!-- /.container -->
	<?php the_block_overlay(); ?>
</div><!-- /.custom block -->
