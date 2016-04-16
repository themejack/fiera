<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Fiera
 */

?>
	<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-5 col-md-6 col-sm-7">
					<h1 class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo__link"><?php bloginfo( 'name' ); ?></a></h1><!-- /.logo -->
					<hr class="footer__divider">
					<p class="footer__content"><?php echo esc_html( get_theme_mod( 'fiera_footer_content', '' ) ); ?></p>
					<p><?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'fiera' ), 'Fiera', '<a href="http://slicejack.com" rel="designer">Slicejack</a>' ); ?></p>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container -->
	</footer><!-- /.footer -->
</div><!-- /.site wrap -->

<?php wp_footer(); ?>

</body>
</html>
