( function( $ ) {

		// do not submit
		$( '.submit' ).on( 'click touch refresh', function( events ) {
				events.preventDefault();
				console.log(wp.customize( 'wpwll_custom_css'));
			});

			// Site Title textfield.
			wp.customize( 'blogname', function( value ) {
				value.bind( function( to ) {
					$( 'h2 a' ).text( to );
				} );
			} );

	   wp.customize( 'wpwll_custom_css', function( value ) {
	     value.bind( function( to ) {
	       $( 'body' ).css( 'background-image', to );
	     } );
	   } );

} )( jQuery );
