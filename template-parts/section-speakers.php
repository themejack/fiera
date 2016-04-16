<?php
/**
 * Template part for displaying speakers sections.
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

		<?php if ( ! empty( $block['speakers'] ) ) : ?>
		<div class="row">
			<?php foreach ( $block['speakers'] as $speaker ) : ?>
			<div class="col-lg-3 col-md-4 col-sm-6 people-item">
				<div class="people-item__inner">
					<div class="people-item__image"<?php if ( ! is_wp_error( $speaker['image'] ) ) : ?> style="background-image: url(<?php echo $speaker['image'][0]; // WPCS: XSS OK. ?>);"<?php endif; ?>>
						<?php if ( ! empty( $speaker['social_icons'] ) ) : ?>
						<ul class="social-list">
							<?php foreach ( $speaker['social_icons'] as $social_icon ) : ?>
							<li class="social-list__item">
								<a href="<?php echo $social_icon['link']; // WPCS: XSS OK. ?>" class="social-list__link social-list__link--<?php echo $social_icon['icon']; // WPCS: XSS OK. ?> btn--transition" target="_blank"><i class="fa fa-<?php echo $social_icon['icon']; // WPCS: XSS OK. ?>"></i></a>
							</li>
							<?php endforeach; ?>
						</ul>
						<?php endif; ?>
					</div><!-- /.image -->

					<?php if ( ! empty( $speaker['name'] ) || ! empty( $speaker['title'] ) ) : ?>
					<div class="people-item__content" data-mh>
						<?php if ( ! empty( $speaker['name'] ) ) : ?>
						<h3 class="people-item__name"><?php echo esc_html( $speaker['name'] ); ?></h3>
						<?php endif; ?>
						<?php if ( ! empty( $speaker['title'] ) ) : ?>
						<h4 class="people-item__title"><?php echo esc_html( $speaker['title'] ); ?></h4>
						<?php endif; ?>
					</div><!-- /.content -->
					<?php endif; ?>
				</div>
			</div><!-- /.col -->
			<?php endforeach; ?>
		</div><!-- /.row -->
		<?php endif; ?>
	</div><!-- /.container -->
	<?php the_block_overlay(); ?>
</div><!-- /.custom block -->
