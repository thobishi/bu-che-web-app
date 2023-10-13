$(function() {
	$('.import-modules').on('click', function(e) {
		e.preventDefault();
		var
			$this = $(this),
			dialog = $('<div />'),
			dialogContent = $('<div />').addClass('dialog-content').appendTo(dialog),			
			initialButtons = {
				'Cancel': function() {
					dialog.dialog('close');
				},
				'Upload / Import': function() {
					dialog.closest('.ui-dialog').block({
						message: 'Please wait while your file is uploaded.'
					});
					dialogContent.find('form').submit();
				}
			},
			acceptButtons = {
				'Discard this import': function() {
					dialog.dialog('close');
				},
				'Accept this import': function() {
					dialog.closest('.ui-dialog').block({
						message: 'Please wait while your data is saved.'
					});
					dialogContent.find('form').submit();
				}
			};

		dialogContent
			.text('Loading...')
			.load($this.attr('href'), function() {
				dialogContent
					.find('form')
						.ajaxForm({
							target: dialogContent,
							error: function() {
								dialog.closest('.ui-dialog').unblock();
							},
							success: function() {
								dialog.closest('.ui-dialog').unblock();
								dialogContent
									.find('form')
										.append('<input type="hidden" value="1" name="accept">')
										.ajaxForm({
											error: function() {
												dialog.closest('.ui-dialog').unblock();
											},
											success: function() {
												dialog.dialog('close');
												
												$.blockUI({
													message: 'Please wait while the list of modules is reloaded.'
												});
												$('a.SaveCont').click();
											}
										})
										.find('.infoText').remove().end()
										.find('.submit').remove();
								dialog
									.dialog('option', 'position', 'center')
									.dialog('option', 'buttons', acceptButtons);
							}
						})
						.find('.submit').remove();

					dialog
						.dialog('option', 'position', 'center')
						.dialog('option', 'buttons', initialButtons);
			});

		dialog
			.dialog({
				modal: true,
				draggable: false,
				resizable: false,
				width: 500,
				title: 'Import modules from excel',
				closeOnEscapeType: false,
				close: function() {
					$(this).dialog('destroy').remove();
				}
			});
	});
});