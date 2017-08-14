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

	} );

})( jQuery );
