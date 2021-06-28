(function( $ ) {
	'use strict';
	
	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	 $(document).ready(function() {
	 	var string_to_slug = function (str)
		{
			str = str.replace(/^\s+|\s+$/g, ''); // trim
			str = str.toLowerCase();

			// remove accents, swap ñ for n, etc
			var from = "àáäâèéëêìíïîòóöôùúüûñçěščřžýúůďťň·/_,:;";
			var to   = "aaaaeeeeiiiioooouuuuncescrzyuudtn------";

			for (var i=0, l=from.length ; i<l ; i++)
			{
				str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
			}

			str = str.replace('.', '-') // replace a dot by a dash 
				.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
				.replace(/\s+/g, '-') // collapse whitespace and replace by a dash
				.replace(/-+/g, '-') // collapse dashes
				.replace( /\//g, '' ); // collapse all forward-slashes

			return str;
		}
	    $( '.select2' ).select2( {
			allowClear: true,
			width: '100%',
			minimumInputLength: 6,
			ajax: {
				url: '/wp-json/wp/v2/pages',
				dataType: 'json',
				data: function ( params ) {
					return {												
						search_by_title_like: params.term
					};
				},
				processResults: function( data ) {
					return {
						results: jQuery.map( data, function( obj ) {						
							return { id: obj.id, text: obj.title.rendered };
						} )
					}
				}
			}
		} );

	});

})( jQuery );
