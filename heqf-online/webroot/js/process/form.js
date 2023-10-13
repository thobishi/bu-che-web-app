$(function() {
	var changed = false;
	var rootUrl = $('#rootUrl').text();
	
	$('#closeForm, #menu a').click(function(e) {
		var submitHref = $('#closeForm').attr('href');
		var linkHref = $(this).attr('href');

		if(changed == true) {
			e.preventDefault();
			e.stopImmediatePropagation();	
			$('<div />')
				.append('<p>You changed some fields in this form. Closing the form without saving will result in these changes being lost. What action do you wish to perform?</p>')					
				.dialog({
					modal: true,
					width: 600,
					close: function() {
						$(this).dialog('destroy').remove();
					},
					draggable: false,
					resizable: false,
					title: 'Changes detected',
					buttons: {
						'Close and save' : function() {
							$('#Process').append('<input type="hidden" name="saveForm" value="1">');

							if(submitHref !== linkHref) {
								$('#Process').append('<input type="hidden" name="redirectTo" value="'+linkHref.replace(rootUrl, '')+'">');
							}

							$(this).dialog('close');
							$('#Process').attr('action', submitHref).submit();
						},
						'Close without saving': function() {
							if(submitHref !== linkHref) {
								$('#Process').append('<input type="hidden" name="redirectTo" value="'+linkHref.replace(rootUrl, '')+'">');
							}							

							$(this).dialog('close');
							$('#Process').attr('action', submitHref).submit();
						},
						'Cancel': function() {

							$(this).dialog('close');
						}
					}
				});
		}
	});

	$('#sidebar a, a.processLink, #moveButton').click(function(e) {
		e.preventDefault();

		if($(this).attr('rel') == 'comments'){
			popUpComments($(this));
		}
		else{
			var link = $(this).attr('href');
			
			if(typeof link == 'undefined') {
				link = $(this).val();
			}

			$('#Process').attr('action', link).submit();
		}
	})

	$('#Process').find(':input').change(function() {
		changed = true;
	});
	
	$('#moveButton').button();
	
	var 
		$Process = $('#sidebar');
		
		$Process.delegate('button:not(#searchButton), a.dialogViewLink', 'click', function(e) {
				e.preventDefault();
		}
	);
	
	function popUpComments($this){
	
		var 
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
						'Ok': function() {
							$(this).dialog('close');
						}
					},
					boxWidth = 500,
					xPos = $("#content").width() - boxWidth,
					yPos = 0;

				$('<div />')
					.html(result)
					.dialog({
						modal: false,
						resizable: false,
						draggable: true,
						width: boxWidth,
						buttons: buttons,
						title: buttonText,
						position: [xPos, yPos],
						close: function() {
							$(this).dialog('destroy').remove();
						}
					});
			}
		}
		
		if(isButton) {
			$Process
				.ajaxSubmit({
					success: generateViewDialog
				});

			$this.html(buttonHtml);
		}
		else {
			$.get($this.attr('href'), generateViewDialog);
		}
	}
});

$(document).ready(function() {
  $("#commentsLink").click();
});