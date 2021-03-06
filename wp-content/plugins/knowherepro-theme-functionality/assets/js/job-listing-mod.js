(function($) {

	'use strict';

	$(function () {

		var $supports_html5_history = false;
		if ( window.history && window.history.pushState ) {
			$supports_html5_history = true;
		}

		var location = document.location.href.split('#')[0];

		function job_manager_store_state( target, page ) {
			if ( $supports_html5_history ) {
				var form  = target.find( '.job_filters'),
					data  = $( form ).serialize(),
					index = $( 'div.job_listings' ).index( target );
				window.history.replaceState( { id: 'job_manager_state', page: page, data: data, index: index }, '', location + '#s=1' );
			}
		}

		$('div.job_listings').on( 'update_attributes', function ( e ) {
			var target       = $( this),
				form         = target.find( '.job_filters' ),
				results      = target.find( '.kw-job-filters-search'),
				categories = form.find(':input[name^="search_categories"]').map(function () {
					return $(this).val();
				}).get(),
				data = {
					search_categories: categories
				};

			$( results ).empty();

			$.ajax({
				type: 'POST',
				url: job_manager_ajax_filters.ajax_url.toString().replace( '%%endpoint%%', 'get_attributes' ),
				data: data,
				success: function ( result ) {

					if ( result ) {
						try {

							if ( result.html ) {
								$( results ).html( result.html );
							} else {
								$( results ).empty();
							}

							target.triggerHandler( 'updated_attributes', result );

						} catch(err) {
							if ( window.console ) {
								window.console.log( err );
							}
						}

					}

				},
				error: function ( jqXHR, textStatus, error ) {
					if ( window.console && 'abort' !== textStatus ) {
						window.console.log( textStatus + ': ' + error );
					}
				},
				statusCode: {
					404: function() {
						if ( window.console ) {
							window.console.log( 'Error 404: Ajax Endpoint cannot be reached.' );
						}
					}
				}
			});

		});

		$('#search_categories').change(function() {
			var target = $( this ).closest( 'div.job_listings' );
				target.triggerHandler( 'update_attributes' );
		});

		$('#job_category').change( function (e) {

			e.preventDefault();

			var parent = $( this ).closest('.job-fields-section'),
				term_id = parseInt($( this ).val(), 10),
				elements = parent.children('fieldset[class^="fieldset-kw_"]');

			if ( elements.length ) {

				elements.removeClass('active');
				elements.find(':input[name^="kw_"]').val( '' ).trigger( 'chosen:updated' );

				elements.each(function (id, el) {
					var $this = $(el),
						cat_ids = $this.data('cat-ids').toString(),
						ids = cat_ids.split(',');

					$.each( ids, function (i, id) {

						var parseId = parseInt(id, 10);

						if ( term_id === parseId ) {
							$this.addClass('active');
						}

					});

				});

			}

		});

		$('div.job_listings').on( 'updated_attributes', function ( e, result ) {

			if ( $.isFunction( $.fn.chosen ) ) {
				$( '.job-manager-nav-dropdown' ).chosen({ search_contains: true });
			}

			$( '.job-manager-nav-dropdown, .job-manager-nav-checkbox :input' ).change( function() {
				var target = $( this ).closest( 'div.job_listings' );
					target.triggerHandler( 'update_results', [ 1, false ] );
					job_manager_store_state( target, 1 );
			});

		} );

		if ( $.isFunction( $.fn.chosen ) ) {

			$( '#job_category' ).chosen({
				search_contains: true
			});

			$( '.job-fields-section > fieldset [id^="kw_"] ').chosen({
				search_contains: true
			});

		}

	});

})(jQuery);