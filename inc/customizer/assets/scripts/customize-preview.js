/**
 * File customize-preview.js.
 *
 * Deal with real time changes asynchronously.
 */

( function( $ ) {

	var api = wp.customize;

	// Collect information from customize-controls.js about which panels are opening.
	api.bind( 'preview-ready', function() {

		api.preview.bind( 'section-highlight', function( data ) {

			// Only on the front page.
			if ( ! $( 'body' ).hasClass( 'home' ) ) {
				return;
			}

			if ( true === data.expanded ) {
				$( '.section' ).addClass( 'highlight' );
			} else {
				$( '.section' ).removeClass( 'highlight' );
			}
		});

		api.preview.bind( 'column-highlight', function( data ) {

			// Only on the front page.
			if ( ! $( 'body' ).hasClass( 'home' ) ) {
				return;
			}

			// When the section is expanded, show and scroll to the content placeholders, exposing the edit links.
			if ( true === data.expanded ) {
				$( '#section-' + data.section ).children().addClass( 'highlight' );

				$( '#section-' + data.section + ' .panel-placeholder' ).slideDown( 200, function() {
					$.scrollTo( $( '#section-' + data.section ), {
						duration: 600,
						offset: { 'top': -70 } // Account for sticky menu.
					});
				});

			// If we've left the panel, hide the placeholders and scroll back to the top.
			} else {
				$( '#section-' + data.section ).children().removeClass( 'highlight' );
				// Don't change scroll when leaving - it's likely to have unintended consequences.
				$( '.panel-placeholder' ).slideUp( 200 );
			}
		});
	});

	// Site title.
	api( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		});
	});

	// Site description.
	api( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		});
	});

	// Header text color.
	api( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title a, .site-description' ).css({
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				});
			} else {
				$( '.site-title a, .site-description' ).css({
					'clip': 'auto',
					'position': 'relative'
				});
				$( '.site-title a, .site-description' ).css({
					'color': to
				});
			}
		});
	});

	// Background image.
	api( 'background_image', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).toggleClass( 'custom-background-image', '' !== to );
		});
	});

	// Copyright text.
	api( '_copyright_text', function( value ) {
		value.bind( function( to ) {
			$( '.site-info' ).text( to );
		});
	});

	// Site width.
	api( 'layout_width', function( value ) {
		value.bind( function( to ) {

			// Update CSS value.
			var style = $( '#largo-customizer-styles' ),
				sitewidth = style.data( 'sitewidth' ),
				css = style.html();
				to  = to || '1600'; // If value is removed, fallback to default value - also set in largo_customizer_css().

			css = css.split( sitewidth + 'px' ).join( to + 'px' );
			style.html( css ).data( 'sitewidth', to );
		});
	});

})( jQuery );
