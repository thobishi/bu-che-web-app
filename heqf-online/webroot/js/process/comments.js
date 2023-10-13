$(function() {
	var $this = $(this),
		isButton = $this.is('button'),
		buttonText = '',
		buttonHtml = '',
		buttonName = '',
		buttonValue = '';
		
	if(isButton) {
		buttonText = $this.text();
		buttonHtml = $this.html();
		$this.html('');

		buttonName = $this.attr('name');
		buttonValue = $this.val();
	}
	else {
		buttonText = $this.text();
		buttonName = 'action';
		buttonValue = $this.attr('rel');
	}
		
	function generateViewDialog(result) {
		$.unblockUI();
		if($.isPlainObject(result)) {
			$.pnotify({
				pnotify_title: 'Error',
				pnotify_text: result.message,
				pnotify_type: 'error'
			});
		}
		else {
			var buttons = {
				'Cancel': function() {
					$(this).dialog('close');
				}
			};

			$('<div />')
				.html(result)
				.dialog({
					modal: false,
					resizable: true,
					draggable: true,
					width: 500,
					buttons: buttons,
					title: buttonText,
					position: ['right', 'top'],
					close: function() {
						$(this).dialog('destroy').remove();
					}
				});
		}

		$listView.find('#actionValue').remove();
	}
	
	if(isButton) {
		$listView
			.append('<input type="hidden" id="actionValue" name="'+buttonName+'" value="'+buttonValue+'" />')
			.ajaxSubmit({
				success: generateViewDialog
			});

		$this.html(buttonHtml);
	}
	else {
		$.get($this.attr('href'), generateViewDialog);
	}
});