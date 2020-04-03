( function( $ ) {

	   wp.customize( 'wpwll_logo_url', function( value ) {
	     value.bind( function( to ) {
	       $( '#wll-header' ).html( to );
	     } );
	   } );

} )( jQuery );
