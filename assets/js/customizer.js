( function( $ ) {

		// do not submit
		$( '.submit' ).on( 'click touch refresh', function( events ) {
				events.preventDefault();
				console.log(wp.customize( 'wpwll_custom_css'));
			});

} )( jQuery );
