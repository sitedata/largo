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
		    var setupControl_1 = function( control ) {
		        var setActiveState, isDisplayed;
		        isDisplayed = function() {
							return 1 <= setting.get();
		        };
		        setActiveState = function() {
		            control.active.set( isDisplayed() );
		        };
						control.active.validate = isDisplayed;
		        setActiveState();
		        setting.bind( setActiveState );
		    };

				var setupControl_2 = function( control ) {
						var setActiveState, isDisplayed;
						isDisplayed = function() {
							return 2 <= setting.get();
						};
						setActiveState = function() {
								control.active.set( isDisplayed() );
						};
						control.active.validate = isDisplayed;
						setActiveState();
						setting.bind( setActiveState );
				};

				var setupControl_3 = function( control ) {
						var setActiveState, isDisplayed;
						isDisplayed = function() {
							return 3 <= setting.get();
						};
						setActiveState = function() {
								control.active.set( isDisplayed() );
						};
						control.active.validate = isDisplayed;
						setActiveState();
						setting.bind( setActiveState );
				};

				var setupControl_4 = function( control ) {
						var setActiveState, isDisplayed;
						isDisplayed = function() {
							return 4 <= setting.get();
						};
						setActiveState = function() {
								control.active.set( isDisplayed() );
						};
						control.active.validate = isDisplayed;
						setActiveState();
						setting.bind( setActiveState );
				};

				var setupControl_5 = function( control ) {
						var setActiveState, isDisplayed;
						isDisplayed = function() {
							return 5 <= setting.get();
						};
						setActiveState = function() {
								control.active.set( isDisplayed() );
						};
						control.active.validate = isDisplayed;
						setActiveState();
						setting.bind( setActiveState );
				};

				// Detect when the front page sections section is expanded (or closed) so we can adjust the preview accordingly.
				wp.customize.section( 'largo_homepage_layout_section-1', function( section ) {
					section.expanded.bind( function( isExpanding ) {

						// Value of isExpanding will = true if you're entering the section, false if you're leaving it.
						wp.customize.previewer.send( 'section-highlight', { expanded: isExpanding });
					} );
				} );


		    api.control( 'largo_homepage_layout_settings_1', setupControl_1 );
		    api.control( 'largo_homepage_layout_settings_2', setupControl_2 );
		    api.control( 'largo_homepage_layout_settings_3', setupControl_3 );
		    api.control( 'largo_homepage_layout_settings_4', setupControl_4 );
		    api.control( 'largo_homepage_layout_settings_5', setupControl_5 );
		} );

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
