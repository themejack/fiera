<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Fiera
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div class="offcanvas">
		<ul class="main-nav">
			<?php
			global $fiera_data;
			$nav_items = array();
			if ( isset( $fiera_data['sections'] ) && isset( $fiera_data['sections']['nav_items'] ) ) {
				$nav_items = $fiera_data['sections']['nav_items'];
			}

			$navigation = fiera_nav_menu( $nav_items );
			echo $navigation; // WPCS: XSS OK.
			?>
		</ul>
	</div><!-- /.offcanvas -->

	<div class="site-wrap">
		<header class="header">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="header__content">
							<div class="site-branding">
								<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-title__link"><?php bloginfo( 'name' ); ?></a></h1><!-- /.site-title -->
								<p class="site-description"><?php bloginfo( 'description' ); ?></p>
							</div>

							<ul class="main-nav hidden-xs">
								<?php echo $navigation; // WPCS: XSS OK. ?>
							</ul>

							<button class="offcanvas-toggle visible-xs-inline-block">
								<i class="fa fa-bars"></i>
							</button>
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container -->
		</header><!-- /.header -->
