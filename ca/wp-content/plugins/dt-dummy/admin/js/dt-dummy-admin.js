(function( $ ) {
	'use strict';

	$(function() {
		var xhr = false;

		var getDummyID = function( $container ) {
			var dummyID = [];
			$('input[type="checkbox"]:checked', $container).each(function(){
				dummyID.push( $(this).attr('name') );
			});

			return dummyID.join(',');
		};

		var getDummyUser = function( $container ) {
			return $('.dt-dummy-content-user', $container).first().val();
		};

		var ajaxImportDummy = function( dummyID, options ) {
			var ajaxData = {
				action: 'presscore_import_dummy',
				dummy: dummyID,
				_wpnonce: dtDummy.import_nonce
			};

			if ( typeof( options.ajaxData ) == 'object' ) {
				$.extend( ajaxData, options.ajaxData );
			}

			var xhr;
			xhr = $.post(
				ajaxurl,
				ajaxData
			)
				.success( function( response ) {
					if ( typeof(options.onSuccessResponse) == 'function' ) {
						options.onSuccessResponse(response, dummyID, options);
					}
				} )
				.fail( function( response ) {
					if ( typeof(options.onFailResponse) == 'function' ) {
						options.onFailResponse(response, dummyID, options);
					}
				} );

			return xhr;
		};

		$('.dt-dummy-control-buttons .dt-dummy-button-import').on('click', function(event) {
			event.preventDefault();

			if ( xhr ) {
				return false;
			}

			var $this = $(this);
			var originBtnTxt = $this.text();
			var $spinner = $this.siblings('.spinner').first();

			var addInlineMsg = function(msg, type, wrap) {
				if ( typeof wrap === 'undefined' ) {
					wrap = true;
				}

				msg = ( wrap ? '<p>'+msg+'</p>' : msg );

				var $msg = $('<div class="dt-dummy-inline-msg hide-if-js inline ' + type + '">' + msg + '</div>');
				$this.closest('.dt-dummy-controls').prepend($msg);
				$msg.fadeIn();
			};

			var removeInlineMsgs = function() {
				$this.closest('.dt-dummy-controls').find('.dt-dummy-inline-msg').fadeOut('400', function() {
					$(this).remove();
				});
			};

			var spinnerOn = function() {
				$spinner.addClass('is-active');
			};

			var spinnerOff = function() {
				$spinner.removeClass('is-active');
				$this.removeClass('button--importing');
				$this.text(originBtnTxt);
			};

			var setSataus__Default = function() {
				$this.removeClass( 'button--importing' );
				spinnerOff();
			};

			var setStatus__Importing = function() {
				removeInlineMsgs();
				setSataus__Default();
				$this.addClass('button--importing').text(dtDummy.import_msg.btn_import);
				spinnerOn();
			};

			var displayPHPStatus = function () {
				$.post(ajaxurl, {
					action: 'dt_dummy_php_status',
					_wpnonce: dtDummy.statusNonce
				}, function(status) {
					if ( status.success && status.data ) {
						addInlineMsg(status.data, 'error', false);
					}
				})
					.fail(function() {
						addInlineMsg(dtDummy.import_msg.msg_import_fail, 'error');
					});
			};

			setStatus__Importing();

			var $blockContainer = $this.parents('.dt-dummy-controls').first();
			var contentPartId = $blockContainer.attr( 'data-dt-dummy-content-part-id' ) || '0';

			xhr = ajaxImportDummy(
				getDummyID($blockContainer),
				{
					ajaxData: {
						imported_authors: ['admin'],
						user_map: [getDummyUser($blockContainer)],
						content_part_id: contentPartId
					},
					onSuccessResponse: function( response ) {
						if ( response.success ) {
							addInlineMsg(dtDummy.import_msg.msg_import_success, 'updated');
							setSataus__Default();
						} else {
							displayPHPStatus();
							setSataus__Default();
						}
						xhr = null;
					},
					onFailResponse: function() {
						xhr = null;
						displayPHPStatus();
						setSataus__Default();
					}
				}
			);

			return false;
		});

	});

})( jQuery );
