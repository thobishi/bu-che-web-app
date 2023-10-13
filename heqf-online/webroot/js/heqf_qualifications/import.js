$(function() {
	var currentAction = 'Uploading spreadsheet';
	var error = false;
	var timer = 0;	
	var statusUrl = $('#statusUrl').text();
	var $loadingDiv = $("#loadingDiv");
	var $progressbar = $("#progressbar");	
	var $completedDiv = $("#completedDiv");	
	var $waiting = $("#waiting");	
	var $uploadForm = $('#uploadForm');
	var $validationReport = $('#validationReport');
	var $flashMessage = $('#flashMessage');
	var $HeqfQualificationBrowser = $('#HeqfQualificationBrowser');
	var $HEQFQualification_importForm = $('#HEQFQualification_importForm');
	var $importBut = $('#importBut');
	var $errorMsg = $('#errorMsg');
	var $reImportLink = $('#reImportLink');
	var $acceptLinks = $('#acceptLink, #acceptBut');
	var $discardLink = $('#discardLink');
	var $downloadLink = $('#downloadLink');
	$errorMsg.hide();
	$reImportLink.hide();
	$acceptLinks.hide();
	$discardLink.hide();
	$downloadLink.hide();

	$importBut.click(function() {
		$importBut.attr("name", "saveJS");
	});	

	$acceptLinks.live('click', function(e) {
		e.preventDefault();
		if($('#editOnline').length > 0){
			$( "#editOnline" ).dialog({
				resizable: true,
				height:350,
				width: 650,
				modal: true,
				buttons: {
					"Proceed": function() {
						$('#HeqfQualificationLink').val('accept');
						$('#HeqfQualificationSaveDataForm').submit();	
						$( this ).dialog( "close" );
					},
					Cancel: function() {
						$('#discardBut').click();
						$('#HeqfQualificationSaveDataForm').submit();
						$( this ).dialog( "close" );
					}
				}
			});
		}
		else{
			$('#HeqfQualificationLink').val('accept');
			$('#HeqfQualificationSaveDataForm').submit();	
		}
	});		
		
	$discardLink.click(function(e) {
		e.preventDefault();
		$('#HeqfQualificationLink').val('discard');
		$('#HeqfQualificationSaveDataForm').submit();
	});	
	
	$downloadLink.click(function(e) {
		e.preventDefault();
		$('#HeqfQualificationImportForm').submit();
	});


	if($.browser.msie){
		$HeqfQualificationBrowser.val('TRUE');
	}

	var options = { 
		iframe: true,
		target:        '#validationReport',   // target element(s) to be updated with server response 
		beforeSubmit:  startRequest,
		complete: clearTime
	}; 
	$('#HEQFQualification_importForm').ajaxForm(options);

	function startRequest(formData, jqForm, options) { 
		$uploadForm.hide();
		$flashMessage.empty().hide();
		$progressbar.empty();
		$completedDiv.empty();
		$loadingDiv.empty();
		$progressbar.show();
		$completedDiv.show();
		$loadingDiv.show();			
		error = false;
		perform();
		return true; 
	}

	function clearTime(){
		clearTimeout(timer);
		if(error){
			$progressbar.empty().hide();
			$completedDiv.empty().hide();
			$waiting.hide();
			$loadingDiv.hide();			
			$validationReport.hide();
			$HEQFQualification_importForm.clearForm();
			$HEQFQualification_importForm.resetForm();
			
			$errorMsg.append('<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><p>' + error + '</p>');
			var boxwidth = (error.length > 50) ? 450 : 300;
			var boxheight = (error.length > 50) ? 250 : 175;
			var resizableVal = (error.length > 50) ? true : false;
			
			$errorMsg.dialog({
				resizable: resizableVal,
				height: boxheight,
				width: boxwidth,
				modal: true,
				buttons: {
					"OK": function() {
						location.reload();
						$( this ).dialog( "close" );
					}
				},
				close: function(event, ui) {
						location.reload();
				}

			});
		}
		else{
			clearTimeout(timer);
			$waiting.hide();
			$progressbar.empty().hide();
			$completedDiv.empty().hide();
			$loadingDiv.hide();
			$validationReport.fadeIn('slow');
			$reImportLink.show();
			$acceptLinks.show();
			$discardLink.show();	
			$downloadLink.show();
			
			configureButtons();
		}
	}


	function perform(){
		$.ajax({
			async: false,
			type: "GET",
			url: statusUrl,
			success: function(data) {
				if (data.current_function) {
					$loadingDiv.html('<span align="center"><b>' + data.current_function + "</b></span> " + data.percent + "%");
					$progressbar.progressbar({ value: data.percent });
				}

				if(data.error){
					error = data.error;
				}

				if(currentAction != data.current_function){
					$loadingDiv.empty();
					$completedDiv.append('<span align="center"><b>' + currentAction + "</b></span> COMPLETE <br>");
					currentAction = data.current_function;
				}

				if(currentAction == 'finished'){
					$loadingDiv.empty();
					$waiting.fadeIn('Slow');
					clearTimeout(timer);
				}
				else if(!error){
					timer = setTimeout(perform, 50);
				}
			}
		});	
	}		
});