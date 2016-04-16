//= include vendor/bootstrap/tab.js
//= include vendor/bootstrap/tooltip.js
//= include vendor/bootstrap/transition.js
//= include vendor/slick.js
//= include vendor/jquery.match-height.js

;( function ( $, theme_options ) {
	var $document = $( document );
	var $html_body = $( 'html, body' );
	var $body = $html_body.filter( 'body' );

	// Default theme options
	if ( 'undefined' === typeof theme_options || 'undefined' === typeof theme_options.mapbox_public_token ) {
		theme_options = {
			mapbox_public_token: ''
		};
	}

	/**
	 * Initialize mapbox
	 *
	 * @param  {jQuery} $map jQuery map elements object.
	 */
	function init_mapbox( $map ) {
		if ( ! $map.length ) {
			return;
		}

		if ( ! theme_options.mapbox_public_token.length ) {
			console.error( 'Location map is not working. If you are Site Administrator go to WordPress Admin > Appearance > Fiera and insert your Mapbox Public Token.' );
			return;
		}

		if ( typeof L != 'undefined' ) {
			L.mapbox.accessToken = theme_options.mapbox_public_token;

			var i, l, map, $map_el, marker_data;
			for ( i = 0, l = $map.length; i < l; i += 1 ) {
				$map_el = $map.eq(i);
				try {
					marker_data = JSON.parse( $map_el.attr( 'data-marker' ) );
					map = L.mapbox.map( $map_el[0], 'mapbox.streets', {
						center: [ marker_data['lat'], marker_data['lng'] ],
						zoom: 11,
						touchZoom: false,
						scrollWheelZoom: false,
						tap: false,
						zoomControl: false,
						attributionControl: false
					} );
				} catch ( e ) {}
			}
		}
	}

	// Initialize all maps on homepage
	init_mapbox( $( '.custom-block.location .map', $body ) );

	// Photo slider
	$( '.photo-slider', $body ).each( function() {
		var $self = $( this ),
			slick_options = {
				infinite: true,
				prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-long-arrow-left"></i></button>',
				nextArrow: '<button type="button" class="slick-next"><i class="fa fa-long-arrow-right"></i></button>',
				responsive: [
					{
						breakpoint: 768,
						settings: {
							slidesToShow: 1
						}
					}
				]
			};

		var element_options = $self.attr( 'data-slick' );

		// Add responsive breakpoint
		if ( element_options && element_options.length ) {
			try {
				element_options = JSON.parse( element_options );
			} catch ( e ) {}

			if ( element_options.slidesToShow && parseInt( element_options.slidesToShow ) >= 3 ) {
				slick_options.responsive.push( {
					breakpoint: 992,
					settings: {
						slidesToShow: 3
					}
				} );
			}
		}

		$self.slick( slick_options );
	} );

	// Smooth anchor scrolling
	$document.on( 'click', 'a[href^="#"]:not([data-toggle="tab"])', function( event ) {
		var $element = $( $( this ).attr( 'href' ) );
		if ( $element.length ) {
			event.preventDefault();

			$html_body.animate( {
				scrollTop: $element.offset().top
			}, 800 );

			return false;
		}
	} );

	// Tabs
	$document.on( 'click', '[data-toggle="tab"]', function( event ) {
		event.preventDefault();
		event.stopPropagation();

		$( this ).tab( 'show' );

		return false;
	} );

	// Adding class to body to expand offcanvas from its default state
	$document.on( 'click', '.offcanvas-toggle', function() {
		$body.toggleClass( 'offcanvas-expanded', 'add' );
	} );
} ) ( jQuery, fiera_theme_options );