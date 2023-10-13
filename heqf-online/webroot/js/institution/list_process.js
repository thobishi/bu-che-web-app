function fadeMessage() {
	setTimeout(function() {
		$('#flash-messages').fadeOut('slow', function() {
			$(this).remove();
		});
	}, 2000);
}

$(function() {
	var 
		$listView = $('#list-view'),
		searchUrl = $('#searchUrl').text();

	$listView
		.delegate('#searchButton, #quickSearchButton', 'click', function(e) {
			e.preventDefault();
			$listView.attr('action', searchUrl).submit();
		})
		.delegate('button:not(#searchButton):not(#quickSearchButton), a.dialogLink', 'click', function(e) {
			e.preventDefault();
			var 
				$this = $(this),
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

			function generateDialog(result) {
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

					buttons[buttonText] = function() {
						var $dialog = $(this);
						var $dialogForm = $dialog.find('form');

						$dialogForm
							.append('<input type="hidden" name="'+buttonName+'" value="'+buttonValue+'" />')
							.append('<input type="hidden" name="data[Process][confirm]" value="1" />')
							.ajaxSubmit({
								success: function(result) {
									if($.isPlainObject(result)) {
										$.pnotify({
											pnotify_title: 'Error',
											pnotify_text: result.message,
											pnotify_type: 'error'
										});
									}
									else {
										$listView
											.html(result);

										renderList();
										configureButtons();
										fadeMessage();
									}
									$dialog.dialog('close');
								}
							});
					};

					$('<div />')
						.html(result)
						.dialog({
							modal: true,
							resizable: false,
							draggable: false,
							width: 500,
							buttons: buttons,
							title: buttonText,
							close: function() {
								$(this).dialog('destroy').remove();
							}
						});
				}

				$listView.find('#actionValue').remove();
			}

			$.blockUI({
				css: {
					top: "15%"
				}
			});

			if(isButton) {
				$listView
					.append('<input type="hidden" id="actionValue" name="'+buttonName+'" value="'+buttonValue+'" />')
					.ajaxSubmit({
						success: generateDialog
					});

				$this.html(buttonHtml);
			}
			else {
				$.get($this.attr('href'), generateDialog);
			}
		})
			.delegate('a.dialogViewLink', 'click', function(e) {
				e.preventDefault();
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
							'Ok': function() {
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

	renderList();
});

function renderList() {
	var $activeCheckboxes = $('#tableBody input:not([disabled=disabled])');

	var $applicationTypes = $('#application-types');
	var $applicationTypeLinks = $applicationTypes.find('a').detach();

	$applicationTypeLinks.each(function() {
		var $link = $(this);
		var $radio = $('<input type="radio" name="filter" />')
			.val($link.attr('href'))
			.attr('id', $link.attr('id'))
			.attr('checked', $link.hasClass('active'));
		var $label = $('<label />')
			.html($link.html())
			.attr('for', $link.attr('id'));

		$applicationTypes
			.append($radio)
			.append($label);
	});

	$applicationTypes
		.find('input')
		.change(function(e) {
			e.preventDefault();

			window.location = $(this).val();
		});

	$("#InstitutionSubmitAll").change(function(){
		var $this = $(this);

		$activeCheckboxes
			.attr('checked', $this.attr('checked'));

		if($this.attr('checked')) {
			$activeCheckboxes
				.attr('checked', true)
				.closest('tr').addClass('selectedRow');
		}
		else {
			$activeCheckboxes
				.attr('checked', false)
				.closest('tr').removeClass('selectedRow');
		}
	});

	$('#tableBody tr').click(function() {
		var $checkbox = $(this).find('input:not([disabled=disabled])');

		if($checkbox.length > 0) {
			var nextTr = $(this).next('tr');
			var nextTrAttr = nextTr.attr('class');
			$checkbox.attr('checked', !$checkbox.attr('checked'));

			if($checkbox.attr('checked')) {
				$(this).addClass('selectedRow');
				if (typeof nextTrAttr == 'undefined' /*|| nextTrAttr == false*/) {
				    nextTr.addClass('additionalTr selectedRow');
				}
			}
			else {
				$(this).removeClass('selectedRow');
				if(nextTr.attr('class') == 'additionalTr selectedRow') {
					nextTr.removeAttr('class');
				}
			}
		}
	});
}

$(function() {
	var $advanced_search = $("#advanced_search"),
		$searchLink = $("#searchLink"),
		$clearSearchLink = $("#clearSearchLink")
		$toDate = $("#ProcessAdvancedSearchSubmissionToDate"),
		$fromDate = $("#ProcessAdvancedSearchSubmissionFromDate");
		
	$advanced_search.hide();
	$searchLink.click(function(e){
		e.preventDefault();
		$advanced_search.toggle("Fast");
		if($searchLink.html() == 'Advanced search'){
			$searchLink.html("Hide advanced search");
		}
		else{
			$searchLink.html("Advanced search");
		}
	});
	
	$clearSearchLink.click(function(e){
		e.preventDefault();
		$advanced_search
			.find(':input:not(:submit)').val("");
		$('#searchButton').click();
	});
	
	var dates = $( "#ProcessAdvancedSearchSubmissionFromDate, #ProcessAdvancedSearchSubmissionToDate" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: "-30:+10",
		onSelect: function( selectedDate ) {
			var option = this.id == "ProcessAdvancedSearchSubmissionFromDate" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
	
	var $errorMessage = $("span.errorMessage"),
		toDateTime = new Date($toDate.val()),
		fromDateTime = new Date($fromDate.val());
	
	$errorMessage.hide();

	if(toDateTime.getTime() < fromDateTime.getTime()){
		$toDate.css("border", "red solid 1px");
		$errorMessage.show();
	}
	else{
		$toDate.css("border", "none");
		$errorMessage.hide();
	}
	
	$toDate.change(function(){
		checkDate();
	});
	
	$fromDate.change(function(){
		checkDate();
	});
	
	function checkDate(){
		toDateTime = new Date($toDate.val()),
		fromDateTime = new Date($fromDate.val());
		
		if(toDateTime.getTime() < fromDateTime.getTime()){
			$toDate.css("border", "red solid 1px");
			$errorMessage.show();
		}
		else{
			$toDate.css("border", "none");
			$errorMessage.hide();
		}
	}
	
});