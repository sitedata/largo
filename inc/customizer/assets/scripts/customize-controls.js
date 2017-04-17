/**
 * Theme Customizer enhancements, specific to panels, for a better user experience.
 *
 * This allows us to detect when the user has opened specific sections within the Customizer,
 * and adjust our preview pane accordingly.
 */

( function( $ ) {

	var api = wp.customize;

	api.bind( 'ready', function() {

		api( 'header_textcolor', function( setting ) {
		    var setupControl = function( control ) {
		        var setActiveState, isDisplayed;
		        isDisplayed = function() {
		            return 'blank' !== setting.get();
		        };
		        setActiveState = function() {
		            control.active.set( isDisplayed() );
		        };
		        setActiveState();
		        setting.bind( setActiveState );
		    };
		    api.control( 'blogname', setupControl );
		    api.control( 'blogdescription', setupControl );
		} );

		api( 'largo_homepage_layout_settings', function( setting ) {

			// Build logic dynamically for each of 5 homepage sections
			var setupControls = [];
			for ( var i = 1; i <= 5; i++ ) {
				(function (i) {

					/*
					 * Only display as many homepage layout sections as are specified
					 * in the Homepage Layout > Sections setting.
					 *
					 * For more information about this technique, reference:
					 * https://make.xwp.co/2016/07/24/dependently-contextual-customizer-controls/
					 */
					setupControls[i] = function( control ) {
						var setActiveState, isDisplayed;
						isDisplayed = function() {
							return i <= setting.get();
						};
						setActiveState = function() {
							control.active.set( isDisplayed() );
						};
						control.active.validate = isDisplayed;
						setActiveState();
						setting.bind( setActiveState );
					};
					api.control( 'largo_homepage_layout_settings_' + i, setupControls[i] );


					// Detect when the front page sections section is expanded (or closed) so we can adjust the preview accordingly.
					api.section( 'largo_homepage_layout_section-' + i, function( section ) {
						section.expanded.bind( function( isExpanding ) {
							api.previewer.send( 'column-highlight', {
								expanded: isExpanding,
								section: i,
							});
						} );
					} );
				})(i);
			}

			// Detect when the front page sections section is expanded (or closed) so we can adjust the preview accordingly.
			api.section( 'largo_homepage_layout_section', function( section ) {
				section.expanded.bind( function( isExpanding ) {
					api.previewer.send( 'section-highlight', {
						expanded: isExpanding,
					});
				} );
			} );
/*
			var container = $('.radiobutton');
//			console.log( api.control( 'largo_homepage_layout_settings' ).setting.get() );
//			var setting = api.control( 'largo_homepage_layout_settings' ).setting.get();

			// Initialize the buttonset.
			container.buttonset();

			// Update the buttonset if the setting changes.
			api.control( 'largo_homepage_layout_settings' ).setting.bind(function(value) {
				console.log( value );
				container.find('input:radio').filter('[value=' + value + ']').prop('checked', true);
//				container.find('input:radio').filter('[value=' + value + ']').parent().siblings().removeClass( 'active' );
//				container.find('input:radio').filter('[value=' + value + ']').parent().addClass( 'active' );
			});



			// Listen for changes to the radio group.
			container.on('change', 'input:radio', function() {
				var value = $(this).parent().find('input:radio:checked').val();
				control.setting.set(value);
			});

			// Update the radio group if the setting changes.
			control.setting.bind(function(value) {
				$container.find('input:radio').filter('[value=' + value + ']').prop('checked', true);
			});
*/
		} );

		api.controlConstructor['radiobutton'] = api.Control.extend({

		    ready: function() {
		        var control = this;
		        var value = (undefined !== control.setting._value) ? control.setting._value : '';

		        this.container.on( 'change', 'input:radio', function() {
		            value = jQuery( this ).val();
		            control.setting.set( value );
		            // refresh the preview
		            api.previewer.refresh();
		        });
		    }

		});
/*
		api.controlConstructor['radiobutton'] = api.Control.extend( {
			ready: function() {
				var control = this,
					$container = control.container.find('.radiobutton');

				this.container.on( 'change', 'select',
					function() {
						control.setting.set( jQuery( this ).val() );
					}
				);

				$container.each(function() {
					if ($(this).hasClass('make-radio-buttonset-container') || $(this).hasClass('make-radio-image-container')) {
						$(this).buttonset();
					}
				});

				// Listen for changes to the radio group.
				$container.on('change', 'input:radio', function() {
					var value = $(this).parent().find('input:radio:checked').val();
					control.setting.set(value);
				});

				// Update the radio group if the setting changes.
				control.setting.bind(function(value) {
					$container.find('input:radio').filter('[value=' + value + ']').prop('checked', true);
				});

			}
		} );
*/

		/**
		 * Initialize instances of MAKE_Customizer_Control_Radio
		 *
		 * @since 1.7.0.
		 */
/*
		api.controlConstructor.make_radio = api.Control.extend({
			ready: function() {
				var control = this,
					$container = control.container.find('.make-radio-container');

				$container.each(function() {
					if ($(this).hasClass('make-radio-buttonset-container') || $(this).hasClass('make-radio-image-container')) {
						$(this).buttonset();
					}
				});

				// Listen for changes to the radio group.
				$container.on('change', 'input:radio', function() {
					var value = $(this).parent().find('input:radio:checked').val();
					control.setting.set(value);
				});

				// Update the radio group if the setting changes.
				control.setting.bind(function(value) {
					$container.find('input:radio').filter('[value=' + value + ']').prop('checked', true);
				});
			}
		});
*/

		// @TODO use these notes to build the "preset layouts"
		// from http://shibashake.com/wordpress-theme/wordpress-theme-customizer-javascript-interface
		// api.settings = window._wpCustomizeSettings;

		// console.log( api.settings );
		// console.log( api.instance('blogname').get() );
		// console.log( api.control( '_footer_scripts' ).active.get() );

		// api.instance('blogname').set('New Site Title2');
		// api.instance('blogname').previewer.refresh();
		// console.log( api.instance('blogname').get() );

	} );
})( jQuery );
