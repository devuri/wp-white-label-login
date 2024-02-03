jQuery(document).ready(function($) {

	// document.getElementById("#login").addEventListener("submit", function(e){
	//     alert('prevent');
	//     e.preventDefault()
	// });

    // Check if wp.customize is available
    if (typeof wp.customize !== 'undefined') {
        console.log('Customizer API available.');

        wp.customize('wpwll_options[copyright_text]', function(value) {
            console.log('Binding to setting.');

            value.bind(function(newval) {
                console.log('New value received: ', newval);

                // Update the element's text
                $('.wll-footer-copyright-text').text(newval);
            });
        });
    } else {
        console.log('Customizer API not available.');
    }
});
