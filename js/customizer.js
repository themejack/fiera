/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	// Header text color.
	wp.customize( 'fiera_header_textcolor', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a, .site-description' ).css( {
				'color': to
			} );
		} );
	} );
	// Footer content.
	wp.customize( 'fiera_footer_content', function( value ) {
		value.bind( function( to ) {
			$( '.footer__content' ).text( to );
		} );
	} );
	// Layout
	var get_page_layout = function() {
		var classes = $( 'body' ).attr( 'class' ).split( /\s+/ );
		var name = 'global';

		if ( $.inArray( 'archive', classes ) > -1 ) {
			name = 'archive';
		}

		if ( $.inArray( 'category', classes ) > -1 ) {
			name = 'category_archive';
		}

		if ( $.inArray( 'search', classes ) > -1 ) {
			name = 'search';
		}

		if ( $.inArray( 'error404', classes ) > -1 ) {
			name = '404';
		}

		if ( $.inArray( 'single', classes ) > -1 ) {
			name = 'single';
		}

		if ( $.inArray( 'page', classes ) > -1 ) {
			name = 'page';
		}

		if (
			(
				$.inArray( 'blog', classes ) > -1 &&
				'page' === wp.customize( 'show_on_front' ).get()
			) ||
			(
				$.inArray( 'home', classes ) > -1 &&
				'page' !== wp.customize( 'show_on_front' ).get()
			)
		) {
			name = 'blog';
		}

		return wp.customize( 'fiera_' + name + '_layout' ).get();
	};

	var $main = $( '.fiera-main-class' ),
		$sidebar = $( '.fiera-sidebar-class' );

	var handle_layout = function() {
		if ( ! $main.length || ! $sidebar.length ) {
			return;
		}

		var page_layout = get_page_layout();

		if ( page_layout == 'disabled' ) {
			page_layout = wp.customize( 'fiera_global_layout' ).get();
		}

		$main.removeClass( 'col-md-12 col-md-8 col-md-push-4' );
		$sidebar.removeClass( 'col-md-pull-8' );

		if ( page_layout == 'none' ) {
			$main.addClass( 'col-md-12' );
			$sidebar.hide();
		} else {
			$main.addClass( 'col-md-8' );
			if ( page_layout == 'left' ) {
				$main.addClass( 'col-md-push-4' );
				$sidebar.addClass( 'col-md-pull-8' );
			}

			$sidebar.show();
		}

		$( window ).trigger( 'resize' );
	};

	var handle_layout_change = function( value ) {
		value.bind( handle_layout );
	};

	wp.customize( 'fiera_global_layout', handle_layout_change );
	wp.customize( 'fiera_blog_layout', handle_layout_change );
	wp.customize( 'fiera_archive_layout', handle_layout_change );
	wp.customize( 'fiera_category_archive_layout', handle_layout_change );
	wp.customize( 'fiera_search_layout', handle_layout_change );
	wp.customize( 'fiera_404_layout', handle_layout_change );
	wp.customize( 'fiera_single_layout', handle_layout_change );
	wp.customize( 'fiera_page_layout', handle_layout_change );

	wp.customize( 'show_on_front', handle_layout_change );

	$( document ).on( 'ready', handle_layout );
	$( document ).on( 'click', 'a', handle_layout );

} )( jQuery );