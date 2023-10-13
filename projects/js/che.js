var helpPage=null;
var holiday_arr = new Array();
var public_docs = new String();
var private_docs = new String();
var applicationwin = null;
var instprofilewin = null;

function checkDocumentsSelected (question, priv_publ) {
	obj = document.all;
	all_checked = true;
	docs = 0;
	fld_name = "";
	for (i=0; i < obj.length; i++) {
		obj_fld_name = new String (obj[i].name);
		if ((obj[i].type == "radio") && (obj_fld_name.substr(4, 1) == question) && (obj_fld_name.indexOf('criteria') == -1)) {
			if (fld_name != obj[i].name) {
				fld_name = obj[i].name;	
				if (priv_publ == 1) {
					docs = private_docs.indexOf(obj_fld_name.substr(4, obj_fld_name.length));
				}else {
					docs = public_docs.indexOf(obj_fld_name.substr(4, obj_fld_name.length));
				}
				if (docs > 0) {
					if (getSelectedRadio(obj[i].name) == -1) {
						if ((obj.MOVETO.value == "next") || (obj.MOVETO.value > 2)) {
							all_checked = false;
						}
					}
				}
			}
		}
	}
	if (all_checked) {
		return true;
	}else {
		alert("Please select at least 1 option for each required documentation.");
		obj.MOVETO.value = '';
		return false;
	}
}

function getSelectedRadio(buttonGroup) {
   // returns the array number of the selected radio button or -1 if no button is selected
	 buttonGroup = document.all[buttonGroup];
   if (buttonGroup[0]) { // if the button group is an array (one button is not an array)
      for (var i=0; i<buttonGroup.length; i++) {
         if (buttonGroup[i].checked) {
            return i;
         }
      }
   } else {
      if (buttonGroup.checked) { return 0; } // if the one button is checked, return zero
   }
   // if we get to this point, no radio button is selected
   return -1;
} // Ends the "getSelectedRadio" function

/*
function getSelectedRadioValue(buttonGroup) {
   // returns the value of the selected radio button or "" if no button is selected
   var i = getSelectedRadio(buttonGroup);
   if (i == -1) {
      return "";
   } else {
      if (buttonGroup[i]) { // Make sure the button group is an array (not just one button)
         return buttonGroup[i].value;
      } else { // The button group is just the one button, and it is checked
         return buttonGroup.value;
      }
   }
}
*/

function showHide2(obj, objImg) {
	if (obj.style.display == "none") {
		obj.style.display = "Block";
		objImg.src = 'images/ico_minus.gif';
	}else{
		obj.style.display = "none";
		objImg.src = 'images/ico_plus.gif';
	}
}

function openFileWin(page,val,field){
	var width = 392;
	var height = 234;
	var left = (screen.width-width)/2;
	var top = (screen.height-height)/3;
	hlpWidth = (screen.width);
	var win = open(page+"?val="+val+"&field="+field,'null', "scrollbars=yes, toolbar=no, status=no, menubar=no, width="+width+", height="+height+", left="+left+", top="+top+"");
}

function showProcessDescription(id){
	w=400;
	h=500;
	leftSide = (screen.width-w)-25;
	topSide = 120;
	contentwin = open("pages/ProcessDescription.php?id="+id,"","width="+w+",height="+h+", top="+topSide+", left="+leftSide+", scrollbars=yes");
}

function winContentTextTMP(title, template, content) {
// Diederik - a TMP as someone tool my stuff out of the other script
      w=300;
      h=500;
      leftSide = (screen.width-w)-25; 
      topSide = 120;
      contentwin = open("pages/contentText.php?tempname="+template+"&content="+content,"","width="+w+",height="+h+", top="+topSide+", left="+leftSide+", scrollbars=yes");
}

function winContentText(title, template, content) {
	openHelp=false;
	if ( !helpPage ) {
		openHelp=true;
	} else {
		if (helpPage.closed) {
			openHelp=true;
		}
	}

	switch (content) {
		case "help_home_page" : 
			content  = '<span class="helptextheader">GETTING STARTED</span>';
			
			content += '<hr>';				
			
			content += '<br><span class="helptext">You will see a menu at the top of the screen (below the HEQC logo). This menu will differ, depending on whether you are an administrator or part of the academic staff:</span>';
			content += '<br><br><span class="helptextb">Administrators:</span>';
			content += '<span class="helptext">';
			content += '<ul>';
			content += '<li><b>Home</b>: allows you to go back to the Home page with a list of your active processes.</li>';
			content += '<li><b>Tools:</b> allows access to your institutional profile </li>';
			content += '<li><b>Reports:</b> allows the user access to your application progress report for your institution (which allows read-only access to all applications (both complete and active).</li>';
			content += '<li><b>Help:</b> general help for the accreditation system</li>';
			content += '<li><b>Logout:</b> allows you to conclude a task and exit the system from any given screen</li>';
			content += '</ul>';
			content += '</span>';

			content += '<span class="helptextb">Academic staff:</span>';
			content += '<span class="helptext">';
			content += '<ul>';
			content += '<li><b>Home</b>: allows you to go back to the Home page with a list of your active processes.</li>';
			content += '<li><b>Help:</b> general help for the accreditation system</li>';
			content += '<li><b>Logout:</b> allows you to conclude a task and exit the system from any given screen</li>';
			content += '</ul>';
			content += '</span>';		
			
			content += '<span class="helptext">';
			content += 'On the right hand side of your screen is an Actions menu:';
			content += '<ul>';
			content += '<li><b>Accreditation Information</b>: gives further information on the accreditation process.</li>';
			content += '<li><b>New Accreditation Application:</b> creates a new application form for programme accreditation. This will eventually be submitted to the Council on Higher Education.</li>';
			content += '<li><b>Change password:</b> allows you to change your password</li>';
			content += '<li><b>Help Getting Started</b></li>';
			content += '</ul>';
			content += '</span>';	
			
			content += '<br><br>';				
			
			content += '<span class="helptextb">';
			content += 'Applying for Accreditation:';
			content += '</span>';				
			content += '<br><br>';
			content += '<span class="helptext">';
			content += 'Click on "New Accreditation Application" on the Actions menu. If you have not filled in your institutional profile before, then the Institution Information page will be displayed. If your Institutional Profile has been completed then the Programme Information page will be displayed.';
			content += '</span>';	
			
			content += '<br><br>';	
			content += '<br><br>';				
			
			content += '<span class="helptextb">';
			content += 'Accessing an Application form you have filled in before:';
			content += '</span>';				
			content += '<br><br>';
			content += '<span class="helptext">';
			content += 'To access a form that you have filled in previously, make sure that you are on the Home page ("Welcome! You have the following active processes."). You will see a list of "active processes". These are the application forms that you are currently busy with. Click on the relevant application form (found either by application reference number or programme name). Remember the list is updated each time you enter an application, so that the last accessed form will always be at the top of the list.';
			content += '</span>';	
			
			content += '<br><br>';				
			content += '<hr>';				
			content += '<br><br>';				

		break;
	}
	
	
	if(openHelp) {
		hlpWidth = (screen.width-200);
		dialogText = '';
		dialogText = dialogText + '<html><head>';
		dialogText = dialogText + '<title>'+title+'</title><link rel=STYLESHEET TYPE="text/css" href="styles.css" title="Normal Style"></head>';
		dialogText = dialogText + '<body class="help">';
		dialogText = dialogText + '<table width="100%" cellpadding="2" cellspacing="0" border="0">';
		dialogText = dialogText + '<tr>';
		dialogText = dialogText + '<td bgcolor="#CC3300" height="2"></td>';
		dialogText = dialogText + '</tr>';
		dialogText = dialogText + '<tr>';
		dialogText = dialogText + '<td bgcolor="#ECF1F6" align="center"><img src=\"images/help_top.gif\" width=\"255\" height=\"45\"></td>';
		dialogText = dialogText + '</tr>';
		dialogText = dialogText + '<tr>';
		dialogText = dialogText + '<td bgcolor="#CC3300" height="2"></td>';
		dialogText = dialogText + '</tr>';
		dialogText = dialogText + '</table><br>';
		dialogText = dialogText + '<table width="90%" align="center" cellpadding="2" cellspacing="0" border="0"><tr><td>'+content+'</td></tr></table>';
		dialogText = dialogText + '</body></html>';
//		helpPage = showModelessDialog("javascript:document.write('"+dialogText+"');", null, "dialogLeft:"+hlpWidth+";dialogWidth:340px;dialogHeight:500px;help=no;status=no;");
		helpPage = showModelessDialog("test.html", null, "dialogLeft:"+hlpWidth+";dialogWidth:340px;dialogHeight:500px;help=no;status=no;");
		helpPage.document.open();
		helpPage.document.write(dialogText);
		helpPage.document.close();

	} else {
		helpPage.focus();
	}
//	w=300;
//	h=500;
//	leftSide = (screen.width-w)-25;
//	topSide = 120;
//	contentwin = open("pages/contentText.php?tempname="+template+"&content="+content,"","width="+w+",height="+h+", top="+topSide+", left="+leftSide+", scrollbars=yes");
}

function winPrintApplicationForm(title, appid, workflow_settings,path) {
	if (applicationwin && applicationwin.open && !applicationwin.closed){
		applicationwin.close();
	}
	w=(screen.width-100)+"px";
	h=(screen.height-100)+"px";
	leftSide = ((screen.width-w)/1.3);
	topSide = 25;
//	applicationwin = window.showModelessDialog(path+"pages/printApplicationFormFrames.php?workflow_settings="+workflow_settings+"&title="+title+"&appid="+appid,"","dialogWidth:"+w+"; dialogHeight:"+h+"; dialogTop:"+topSide+"; dialogLeft:"+leftSide+"; resizable:yes; scroll:yes;center:no");
	//applicationwin = open(path+"pages/printApplicationFormFrames.php?workflow_settings="+workflow_settings+"&title="+title+"&appid="+appid,"","dialogWidth:"+w+"; dialogHeight:"+h+"; dialogTop:"+topSide+"; dialogLeft:"+leftSide+"; resizable:yes; scroll:yes;center:no");
	applicationwin = open(path+"pages/printApplicationFormFrames.php?workflow_settings="+workflow_settings+"&title="+title+"&appid="+appid,"","width="+w+"; height="+h+"; top="+topSide+"; left="+leftSide+"; resizable=1; scroll:yes;center:no");
}

function winPrintEvalReportForm(title, evalReport_id, workflow_settings,path) {
	w="600px";
	h=(screen.height-100)+"px";
	leftSide = (screen.width-600);
	topSide = 25;
	evalreportwin = window.showModelessDialog(path+"pages/printEvalReportFormFrames.php?workflow_settings="+workflow_settings+"&title="+title+"&evalReport_id="+evalReport_id, "","dialogWidth:"+w+"; dialogHeight:"+h+"; dialogTop:"+topSide+"; dialogLeft:"+leftSide+"; resizable:yes; scroll:yes;center:no");
}

function printOfflineEvalForm (title, evalReport_id, workflow_settings,path) {
	w="600px";
	h=(screen.height-100)+"px";
	leftSide = (screen.width-600);
	topSide = 25;
	evalreportwin = window.showModelessDialog(path+"pages/printOfflineEvalForm.php?workflow_settings="+workflow_settings+"&title="+title+"&evalReport_id="+evalReport_id, "","dialogWidth:"+w+"; dialogHeight:"+h+"; dialogTop:"+topSide+"; dialogLeft:"+leftSide+"; resizable:yes; scroll:yes;center:no");
}

function winPrintEvalSumReportForm(title, evalReport_id, workflow_settings,path) {
	w="600px";
	h=(screen.height-100)+"px";
	leftSide = (screen.width-600)/2;
	topSide = 30;
	evalreportsumwin = window.showModelessDialog(path+"pages/printEvalSumReportFormFrames.php?workflow_settings="+workflow_settings+"&title="+title+"&evalReport_id="+evalReport_id,"","dialogWidth:"+w+"; dialogHeight:"+h+"; dialogTop:"+topSide+"; dialogLeft:"+leftSide+"; resizable:yes; scroll:yes;center:no");
}

function winPrintInstProfileForm(title, evalReport_id, workflow_settings,path) {
	if (instprofilewin && instprofilewin.open && !instprofilewin.closed){
		instprofilewin.close();
	}
	w=(screen.width-100)+"px";
	h=(screen.height-100)+"px";
	leftSide = ((screen.width-w)/1.3);
	topSide = 15;
//	instprofilewin = window.showModelessDialog(path+"pages/printInstProfileFormFrames.php?workflow_settings="+workflow_settings+"&title="+title+"&evalReport_id="+evalReport_id,"","dialogWidth:"+w+"; dialogHeight:"+h+"; dialogTop:"+topSide+"; dialogLeft:"+leftSide+"; resizable:yes; scroll:yes;center:no");
//	instprofilewin = open(path+"pages/printInstProfileFormFrames.php?workflow_settings="+workflow_settings+"&title="+title+"&evalReport_id="+evalReport_id,"","dialogWidth:"+w+"; 	dialogHeight:"+h+"; 	dialogTop:"+topSide+"; 	dialogLeft:"+leftSide+"; resizable:1; scroll:yes;center:no");
	instprofilewin = open(path+"pages/printInstProfileFormFrames.php?workflow_settings="+workflow_settings+"&title="+title+"&evalReport_id="+evalReport_id,"","width=:"+w+"; 	height="+h+"; 		top="+topSide+"; 	left="+leftSide+"; 	resizable=1; 	scroll:yes;center:no");

}

function improvement(obj, field, obj2) {
	if (obj.length > 0){
		for (i=0; i<obj.length; i++) {
			if (obj[i].checked == true){
				showHideImprovement(obj[i], field, obj2);
			}
		}
	}
	if (obj.value > 0){
		showHideImprovement(obj, field, obj2);
	}
}

function showHideImprovement(obj, field, obj2){
	if (obj.value == 3){
		obj2.style.display="none";
		field.style.display="Block";
		field.all[0].focus();
	}else{
		obj2.style.display="Block";
		field.style.display="none";
	}
}

function checkCriteria (obj) {
	obj[0].checked = true;
}

function showHideAction (name, show) {
	newDisplay = "none";

	if (show == true) {
		newDisplay = "Block";
	}

	try{
		action = document.all["action_"+name];
		action.style.display = newDisplay;
	}catch (e){}

	try{
		actionImg = document.all["action_"+name+"_Img"];
		actionImg.style.display = newDisplay;
	}catch (e){}
}


function showHide(obj) {
	if (obj.style.display == "none") {
		obj.style.display = "Block";
	}else{
		obj.style.display = "none";
	}
}

function enableInstTypeIn(obj, field, disabledField){
	if (obj.checked == true) {
		obj.value = "on";
		disabledField.disabled = true;
		field.style.display="Block";
		field.focus();
	}else{
		disabledField.disabled = false;
		field.style.display="none";
	}
}

function whyNot(obj, field, fieldVal, field2, field2Val){
	try {
		if ((obj.value == "1") || (obj.value == "5")){
			field.style.display="Block";
			field2.style.display="none";
			field2Val.value = '';
		}else if (obj.value == "2") {
			field2.style.display="Block";
			field.style.display="none";
			fieldVal.value = '';
		}else if ((obj.value == "3") || (obj.value == "4")) {
			field2.style.display="none";
			field2Val.value = '';
			field.style.display="none";
			fieldVal.value = '';
		}
	}catch(e){}
}

function tmpWhyNot(field) {
	field.style.display="Block";
/*	if (field.id.substring((field.id.length-4), field.id.length) == "_doc") {
		document.all[field.id.substring(0, (field.id.length-4))].style.display = "none";
	}else {
		document.all[field.id+"_doc"].style.display = "none";
	}*/
}

function tryExpandWhyNot() {
	obj = document.defaultFrm;
	try {
		for (i=0; i<obj.elements.length; i++) {
			if ((obj.elements[i].type == "radio") && (obj.elements[i].checked)) {
				var name = obj.elements[i].name;
				if (! name.match("criteria") ) {
					obj2 = document.all;
					if ((obj.elements[i].value == 1) || (obj.elements[i].value == 5)) {
						for (j=0; j < obj2.length; j++) {
							if ((obj2[j].id.match(name)) && !(obj2[j].id.match(name+"_doc"))) {
								tmpWhyNot(obj2[j]);
							}
						}
					}
					
					if ((obj.elements[i].value == 2)) {
						for (j=0; j < obj2.length; j++) {
							if (obj2[j].id.match(name+"_doc")) {
								tmpWhyNot(obj2[j]);
							}
						}
					}
				}
			}
		}
	}catch (e){
	}
}

function moveto(id) {
	document.defaultFrm.MOVETO.value = id;
	if ((document.defaultFrm.onsubmit > "")){ // && (id == "next")
// the fireEvent doesn't work in IE5
		if (document.fireEvent) {
			if (document.defaultFrm.fireEvent('onsubmit')){
				document.defaultFrm.submit();
			}
		}else {
			document.defaultFrm.submit();
		}
	}else{
		document.defaultFrm.submit();
	}
}

// move to page in VIEW mode
function viewPage(id) {
	document.defaultFrm.VIEW.value = id;
	if ((document.defaultFrm.onsubmit > "")){ // && (id == "next")
		// the fireEvent doesn't work in IE5
		if (document.fireEvent) {
			if (document.defaultFrm.fireEvent('onsubmit')){
				document.defaultFrm.submit();
			}
		}else {
			document.defaultFrm.submit();
		}
	}else{
		document.defaultFrm.submit();
	}
}

// exit view mode and goto (id)
function exitView(id) {
	document.defaultFrm.VIEW.value = -1;
	document.defaultFrm.GOTO.value = id;
	document.defaultFrm.submit();
}

// cancel current screen
function cancelPage(id) {
	document.defaultFrm.VIEW.value = -1;
	document.defaultFrm.submit();
}

function goto(id) {
	document.defaultFrm.GOTO.value = id;
	if ((document.defaultFrm.onsubmit > "")){ // && (id == "next")
		// the fireEvent doesn't work in IE5
		if (document.fireEvent) {
			if (document.defaultFrm.fireEvent('onsubmit')){
				document.defaultFrm.submit();
			}
		}else {
			document.defaultFrm.submit();
		}
	}else{
		document.defaultFrm.submit();
	}
}

function addSelectEntries(obj, id, desc){
	sLength = obj.length;
	flag = 0;
	for (i = 0; i < sLength; i++){
		if (obj.options[i].value == id){
			flag = 1;
		}
	}
	if (flag != 1){
		obj.options[sLength] = new Option(desc, id);
	}
}
	
function removeSelectEntries(obj){
	sLength = obj.length;
	for (i = (sLength-1); i >= 0 ; i--){
		if (obj.options[i].selected == true){
			obj.options[i] = null;
		}
	}	
}

//obj = DOCUMENT.FORM
//partialFieldName = The partial string for which to within all the elements.
//postField = the field to which the outcome string should be posted.

/* It doesn't seem as if the system uses this function anymore.*/
function makeFieldsArray (obj, partialFieldName, postField) {
	alert('If you see this, please contact Octoplus at 012 3464823.');
}
/*
function makeFieldsArray (obj, partialFieldName, postField) {
	var jArray = new Array();
	for (i=0; i<obj.elements.length; i++) {
		if (obj.elements[i].name.substr(0,partialFieldName.length) == partialFieldName) {
			switch (obj.elements[i].type) {
				case "checkbox":
						if (obj.elements[i].checked == true){
							jArrayPush (obj, partialFieldName, jArray, i);
						}
						break;
				case "radio":
						if ((obj.elements[i].checked == true)){ // && (obj.elements[i].value == 2) Should come in due to the fact that radio buttons must be valued 2 (yes)
							jArrayPush (obj, partialFieldName, jArray, i);
						}
						break;
				case "text":
						if (obj.elements[i].value > "") {
							jArrayPush (obj, partialFieldName, jArray, i);
						}
						break;
				case "password":
						if (obj.elements[i].value > "") {
							jArrayPush (obj, partialFieldName, jArray, i);
						}
						break;
				case "textarea":
						if (obj.elements[i].value > "") {
							jArrayPush (obj, partialFieldName, jArray, i);
						}
						break;
			}
		}
	}
	i = 0;
	postField.value = "";
	while (i<(jArray.length)) {
		if (i != (jArray.length-1)) {
			postField.value += jArray[i]+"|";
		}else{
			postField.value += jArray[i];
		}
		i++;
	}
	return true;
}

function jArrayPush (obj, partialFieldName, jArray, i) {
	var inc = 1;
	var str = "";
	if (obj.elements[i].name.substr(partialFieldName.length,1) == "M") {
		inc = 2;
		str = "M";
	}
	len = obj.elements[i].name.length;
	str += obj.elements[i].name.substr(partialFieldName.length+inc,len);
	alert(i);
	jArray.push(str);
	alert(jArray.length);
}
*/

var weekend = [0,6];
var weekendColor = "d6e0eb";
var fontface = "Verdana";
var fontsize = 2;
var gNow = new Date();
var ggWinCal;
isNav = (navigator.appName.indexOf("Netscape") != -1) ? true : false;
isIE = (navigator.appName.indexOf("Microsoft") != -1) ? true : false;

Calendar.Months = ["January", "February", "March", "April", "May", "June",
"July", "August", "September", "October", "November", "December"];

// Non-Leap year Month days..
Calendar.DOMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
// Leap year Month days..
Calendar.lDOMonth = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

function Calendar(p_item, p_WinCal, p_month, p_year, p_format) {
	if ((p_month == null) && (p_year == null))	return;

	if (p_WinCal == null)
		this.gWinCal = ggWinCal;
	else
		this.gWinCal = p_WinCal;
	
	if (p_month == null) {
		this.gMonthName = null;
		this.gMonth = null;
		this.gYearly = true;
	} else {
		this.gMonthName = Calendar.get_month(p_month);
		this.gMonth = new Number(p_month);
		this.gYearly = false;
	}

	this.gYear = p_year;
	this.gFormat = p_format;
	this.gBGColor = "white";
	this.gFGColor = "black";
	this.gTextColor = "black";
	this.gHeaderColor = "black";
	this.gReturnItem = p_item;
}

Calendar.get_month = Calendar_get_month;
Calendar.get_daysofmonth = Calendar_get_daysofmonth;
Calendar.calc_month_year = Calendar_calc_month_year;
//Calendar.print = Calendar_print;

function Calendar_get_month(monthNo) {
	return Calendar.Months[monthNo];
}

function Calendar_get_daysofmonth(monthNo, p_year) {
	/* 
	Check for leap year ..
	1.Years evenly divisible by four are normally leap years, except for... 
	2.Years also evenly divisible by 100 are not leap years, except for... 
	3.Years also evenly divisible by 400 are leap years. 
	*/
	if ((p_year % 4) == 0) {
		if ((p_year % 100) == 0 && (p_year % 400) != 0)
			return Calendar.DOMonth[monthNo];
	
		return Calendar.lDOMonth[monthNo];
	} else
		return Calendar.DOMonth[monthNo];
}

function Calendar_calc_month_year(p_Month, p_Year, incr) {
	/* 
	Will return an 1-D array with 1st element being the calculated month 
	and second being the calculated year 
	after applying the month increment/decrement as specified by 'incr' parameter.
	'incr' will normally have 1/-1 to navigate thru the months.
	*/
	var ret_arr = new Array();
	
	if (incr == -1) {
		// B A C K W A R D
		if (p_Month == 0) {
			ret_arr[0] = 11;
			ret_arr[1] = parseInt(p_Year) - 1;
		}
		else {
			ret_arr[0] = parseInt(p_Month) - 1;
			ret_arr[1] = parseInt(p_Year);
		}
	} else if (incr == 1) {
		// F O R W A R D
		if (p_Month == 11) {
			ret_arr[0] = 0;
			ret_arr[1] = parseInt(p_Year) + 1;
		}
		else {
			ret_arr[0] = parseInt(p_Month) + 1;
			ret_arr[1] = parseInt(p_Year);
		}
	}
	
	return ret_arr;
}

//function Calendar_print() {
//	ggWinCal.print();
//}

function Calendar_calc_month_year(p_Month, p_Year, incr) {
	/* 
	Will return an 1-D array with 1st element being the calculated month 
	and second being the calculated year 
	after applying the month increment/decrement as specified by 'incr' parameter.
	'incr' will normally have 1/-1 to navigate thru the months.
	*/
	var ret_arr = new Array();
	
	if (incr == -1) {
		// B A C K W A R D
		if (p_Month == 0) {
			ret_arr[0] = 11;
			ret_arr[1] = parseInt(p_Year) - 1;
		}
		else {
			ret_arr[0] = parseInt(p_Month) - 1;
			ret_arr[1] = parseInt(p_Year);
		}
	} else if (incr == 1) {
		// F O R W A R D
		if (p_Month == 11) {
			ret_arr[0] = 0;
			ret_arr[1] = parseInt(p_Year) + 1;
		}
		else {
			ret_arr[0] = parseInt(p_Month) + 1;
			ret_arr[1] = parseInt(p_Year);
		}
	}
	
	return ret_arr;
}

// This is for compatibility with Navigator 3, we have to create and discard one object before the prototype object exists.
new Calendar();

Calendar.prototype.getMonthlyCalendarCode = function() {
	var vCode = "";
	var vHeader_Code = "";
	var vData_Code = "";
	
	// Begin Table Drawing code here..
	vCode = vCode + "<TABLE align=\"center\" cellpadding=\"1\" cellspacing=\"1\" BORDER=1>";
	
	vHeader_Code = this.cal_header();
	vData_Code = this.cal_data();
	vCode = vCode + vHeader_Code + vData_Code;
	
	vCode = vCode + "</TABLE>";
	
	return vCode;
}

Calendar.prototype.show = function() {
	var vCode = "";
	
	this.gWinCal.document.open();

	// Setup the page...
	this.wwrite("<html>");
	this.wwrite("<head><title>Calendar</title>");
	this.wwrite("<link rel=STYLESHEET TYPE=\"text/css\" href=\"styles.css\" title=\"Normal Style\">");
	this.wwrite("</head>");

	this.wwrite("<body bgcolor=#80B280 " + // took the following out so that the drop down year can work: onblur=\"javascript: self.focus();\"
		"link=\"" + this.gLinkColor + "\" " + 
		"vlink=\"" + this.gLinkColor + "\" " +
		"alink=\"" + this.gLinkColor + "\" " +
		"text=\"" + this.gTextColor + "\">");
	this.wwrite("<TABLE width=\"100%\"><TR><TD valign=\"top\"><FONT FACE='" + fontface + "' SIZE=2><B>"+this.gMonthName + " " + this.gYear+"</B></TD>");
	input = "<input type='text' name='man_year' value='' size='5'>";
	this.wwrite("<TD align="+"'right'"+" valign="+"'top'"+">Please enter a year: "+input+" <a href="+'"'+"javascript:if(checkDate(document.all.man_year)) {window.opener.Build("+"'" + this.gReturnItem + "', '" + this.gMonth + "', document.all.man_year.value, '" + this.gFormat + "'" +		");};"+'"'+">Go</a></TD></TR></TABLE>");
	this.wwrite("<script>function checkDate(obj){ if (obj.value == '') { alert('Please enter a year'); obj.focus(); return false;} return true;}</script>");

	// Show navigation buttons
	var prevMMYYYY = Calendar.calc_month_year(this.gMonth, this.gYear, -1);
	var prevMM = prevMMYYYY[0];
	var prevYYYY = prevMMYYYY[1];

	var nextMMYYYY = Calendar.calc_month_year(this.gMonth, this.gYear, 1);
	var nextMM = nextMMYYYY[0];
	var nextYYYY = nextMMYYYY[1];
	
	this.wwrite("<br><TABLE WIDTH='100%' BORDER=0 CELLSPACING=1 CELLPADDING=1><tr><td ALIGN=center>Year</td><td ALIGN=center>Month</td><td ALIGN=center>Month</td><td ALIGN=center>Year</td></tr><TR><TD ALIGN=center>");
	this.wwrite("[ <A class=\"huge\" HREF=\"" +
		"javascript:window.opener.Build(" + 
		"'" + this.gReturnItem + "', '" + this.gMonth + "', '" + (parseInt(this.gYear)-1) + "', '" + this.gFormat + "'" +
		");" +
		"\"><<<\/A> ]</TD><TD ALIGN=center>");
	this.wwrite("[ <A class=\"huge\" HREF=\"" +
		"javascript:window.opener.Build(" + 
		"'" + this.gReturnItem + "', '" + prevMM + "', '" + prevYYYY + "', '" + this.gFormat + "'" +
		");" +
		"\"><<\/A> ]</TD><TD ALIGN=center>");
//	this.wwrite("[<A HREF=\"javascript:window.print();\">Print</A>]</TD><TD ALIGN=center>");
	this.wwrite("[ <A class=\"huge\" HREF=\"" +
		"javascript:window.opener.Build(" + 
		"'" + this.gReturnItem + "', '" + nextMM + "', '" + nextYYYY + "', '" + this.gFormat + "'" +
		");" +
		"\">><\/A> ]</TD><TD ALIGN=center>");
	this.wwrite("[ <A class=\"huge\" HREF=\"" +
		"javascript:window.opener.Build(" + 
		"'" + this.gReturnItem + "', '" + this.gMonth + "', '" + (parseInt(this.gYear)+1) + "', '" + this.gFormat + "'" +
		");" +
		"\">>><\/A> ]</TD></TR></TABLE><BR>");

	// Get the complete calendar code for the month..
	vCode = this.getMonthlyCalendarCode();
	this.wwrite(vCode);

	this.wwrite("</font></body></html>");
	this.gWinCal.document.close();
}

Calendar.prototype.showY = function() {
	var vCode = "";
	var i;
	var vr, vc, vx, vy;		// Row, Column, X-coord, Y-coord
	var vxf = 285;			// X-Factor
	var vyf = 200;			// Y-Factor
	var vxm = 10;			// X-margin
	var vym;				// Y-margin
	if (isIE)	vym = 75;
	else if (isNav)	vym = 25;
	
	this.gWinCal.document.open();

	this.wwrite("<html>");
	this.wwrite("<head><title>Calendar</title>");
	this.wwrite("<style type='text/css'>\n<!--");
	for (i=0; i<12; i++) {
		vc = i % 3;
		if (i>=0 && i<= 2)	vr = 0;
		if (i>=3 && i<= 5)	vr = 1;
		if (i>=6 && i<= 8)	vr = 2;
		if (i>=9 && i<= 11)	vr = 3;
		
		vx = parseInt(vxf * vc) + vxm;
		vy = parseInt(vyf * vr) + vym;

		this.wwrite(".lclass" + i + " {position:absolute;top:" + vy + ";left:" + vx + ";}");
	}
	this.wwrite("-->\n</style>");
	this.wwrite("</head>");

	this.wwrite("<body bgcolor=#80B280 " + 
		"link=\"" + this.gLinkColor + "\" " + 
		"vlink=\"" + this.gLinkColor + "\" " +
		"alink=\"" + this.gLinkColor + "\" " +
		"text=\"" + this.gTextColor + "\">");
	this.wwrite("<FONT FACE='" + fontface + "' SIZE=2><B>");
	this.wwrite("Year : " + this.gYear);
	this.wwrite("</B><BR>");

	// Show navigation buttons
	var prevYYYY = parseInt(this.gYear) - 1;
	var nextYYYY = parseInt(this.gYear) + 1;
	
	this.wwrite("<TABLE WIDTH='100%' BORDER=1 CELLSPACING=0 CELLPADDING=0 BGCOLOR='#e0e0e0'><TR><TD ALIGN=center>");
	this.wwrite("[<A HREF=\"" +
		"javascript:window.opener.Build(" + 
		"'" + this.gReturnItem + "', null, '" + prevYYYY + "', '" + this.gFormat + "'" +
		");" +
		"\" alt='Prev Year'><<<\/A>]</TD><TD ALIGN=center>");
//	this.wwrite("[<A HREF=\"javascript:window.print();\">Print</A>]</TD><TD ALIGN=center>");
	this.wwrite("[<A HREF=\"" +
		"javascript:window.opener.Build(" + 
		"'" + this.gReturnItem + "', null, '" + nextYYYY + "', '" + this.gFormat + "'" +
		");" +
		"\">>><\/A>]</TD></TR></TABLE><BR>");

	// Get the complete calendar code for each month..
	var j;
	for (i=11; i>=0; i--) {
		if (isIE)
			this.wwrite("<DIV ID=\"layer" + i + "\" CLASS=\"lclass" + i + "\">");
		else if (isNav)
			this.wwrite("<LAYER ID=\"layer" + i + "\" CLASS=\"lclass" + i + "\">");

		this.gMonth = i;
		this.gMonthName = Calendar.get_month(this.gMonth);
		vCode = this.getMonthlyCalendarCode();
		this.wwrite(this.gMonthName + "/" + this.gYear + "<BR>");
		this.wwrite(vCode);

		if (isIE)
			this.wwrite("</DIV>");
		else if (isNav)
			this.wwrite("</LAYER>");
	}

	this.wwrite("</font><BR></body></html>");
	this.gWinCal.document.close();
}

Calendar.prototype.wwrite = function(wtext) {
	this.gWinCal.document.writeln(wtext);
}

Calendar.prototype.wwriteA = function(wtext) {
	this.gWinCal.document.write(wtext);
}

Calendar.prototype.cal_header = function() {
	var vCode = "";
	
	vCode = vCode + "<TR>";
	vCode = vCode + "<TD bgcolor='D6E0EB' WIDTH='14%' align='center'><FONT SIZE='2' FACE='" + fontface + "' COLOR='" + this.gHeaderColor + "'><B>Sun</B></FONT></TD>";
	vCode = vCode + "<TD bgcolor='D6E0EB' WIDTH='14%' align='center'><FONT SIZE='2' FACE='" + fontface + "' COLOR='" + this.gHeaderColor + "'><B>Mon</B></FONT></TD>";
	vCode = vCode + "<TD bgcolor='D6E0EB' WIDTH='14%' align='center'><FONT SIZE='2' FACE='" + fontface + "' COLOR='" + this.gHeaderColor + "'><B>Tue</B></FONT></TD>";
	vCode = vCode + "<TD bgcolor='D6E0EB' WIDTH='14%' align='center'><FONT SIZE='2' FACE='" + fontface + "' COLOR='" + this.gHeaderColor + "'><B>Wed</B></FONT></TD>";
	vCode = vCode + "<TD bgcolor='D6E0EB' WIDTH='14%' align='center'><FONT SIZE='2' FACE='" + fontface + "' COLOR='" + this.gHeaderColor + "'><B>Thu</B></FONT></TD>";
	vCode = vCode + "<TD bgcolor='D6E0EB' WIDTH='14%' align='center'><FONT SIZE='2' FACE='" + fontface + "' COLOR='" + this.gHeaderColor + "'><B>Fri</B></FONT></TD>";
	vCode = vCode + "<TD bgcolor='D6E0EB' WIDTH='16%' align='center'><FONT SIZE='2' FACE='" + fontface + "' COLOR='" + this.gHeaderColor + "'><B>Sat</B></FONT></TD>";
	vCode = vCode + "</TR>";
	
	return vCode;
}

Calendar.prototype.cal_data = function() {
	var vDate = new Date();
	vDate.setDate(1);
	vDate.setMonth(this.gMonth);
	vDate.setFullYear(this.gYear);

	var vFirstDay=vDate.getDay();
	var vDay=1;
	var vLastDay=Calendar.get_daysofmonth(this.gMonth, this.gYear);
	var vOnLastDay=0;
	var vCode = "";

	/*
	Get day for the 1st of the requested month/year..
	Place as many blank cells before the 1st day of the month as necessary. 
	*/

	vCode = vCode + "<TR>";
	for (i=0; i<vFirstDay; i++) {
		vCode = vCode + "<TD WIDTH='14%'" + this.write_weekend_string(i) + "><FONT SIZE='2' FACE='" + fontface + "'> </FONT></TD>";
	}

	// Write rest of the 1st week
	for (j=vFirstDay; j<7; j++) {
		weekend = "";
		public_holiday = false;
		for (z=0; z<holiday_arr.length; z++) {
			if ((holiday_arr[z].substr(5,2)-1) == this.gMonth) {
				tmpDay = holiday_arr[z].substr(8,2);
				if (tmpDay.substr(0,1) == 0) tmpDay = tmpDay.substr(1,1); 
				if (tmpDay == vDay) {
					public_holiday = true;
				}
			}
		}
		if ((j == 0) || (j == 6)) {
			weekend = "self.opener.checkWeekends("+j+");";
		}
		if (public_holiday) {
			vCode = vCode + "<TD WIDTH='14%'" + this.write_weekend_string(j) + "><FONT SIZE='2' FACE='" + fontface + "'>" + 
				this.format_day(vDay) + 
			"</FONT></TD>";
		}else {
			vCode = vCode + "<TD WIDTH='14%'" + this.write_weekend_string(j) + "><FONT SIZE='2' FACE='" + fontface + "'>" + 
			"<A HREF='#' " + 
				"onClick=\"self.opener.document." + this.gReturnItem + ".value='" + 
				this.format_data(vDay) + 
				"';"+weekend+"window.close();\">" + 
				this.format_day(vDay) + 
			"</A>" + 
			"</FONT></TD>";
		}
		vDay=vDay + 1;
	}
	vCode = vCode + "</TR>";

	// Write the rest of the weeks
	for (k=2; k<7; k++) {
		vCode = vCode + "<TR>";

		for (j=0; j<7; j++) {
			weekend = "";
			public_holiday = false;
			for (z=0; z<holiday_arr.length; z++) {
				if ((holiday_arr[z].substr(5,2)-1) == this.gMonth) {
					tmpDay = holiday_arr[z].substr(8,2);
					if (tmpDay.substr(0,1) == 0) tmpDay = tmpDay.substr(1,1); 
					if (tmpDay == vDay) {
						public_holiday = true;
					}
				}
			}
			if ((j == 0) || (j == 6)) {
				weekend = "self.opener.checkWeekends("+j+");";
			}
			if (public_holiday) {
				vCode = vCode + "<TD WIDTH='14%'" + this.write_weekend_string(j) + "><FONT SIZE='2' FACE='" + fontface + "'>" + 
				this.format_day(vDay) + 
				"</FONT></TD>";
			}else {
				vCode = vCode + "<TD WIDTH='14%'" + this.write_weekend_string(j) + "><FONT SIZE='2' FACE='" + fontface + "'>" + 
				"<A HREF='#' " + 
					"onClick=\"self.opener.document." + this.gReturnItem + ".value='" + 
					this.format_data(vDay) + 
					"';"+weekend+"window.close();\">" + 
					this.format_day(vDay) + 
				"</A>" + 
				"</FONT></TD>";
			}
			vDay=vDay + 1;

			if (vDay > vLastDay) {
				vOnLastDay = 1;
				break;
			}
		}

		if (j == 6)
			vCode = vCode + "</TR>";
		if (vOnLastDay == 1)
			break;
	}
	
	// Fill up the rest of last week with proper blanks, so that we get proper square blocks
	for (m=1; m<(7-j); m++) {
		if (this.gYearly)
			vCode = vCode + "<TD WIDTH='14%'" + this.write_weekend_string(j+m) + 
			"><FONT SIZE='2' FACE='" + fontface + "' COLOR='gray'> </FONT></TD>";
		else
			vCode = vCode + "<TD WIDTH='14%'" + this.write_weekend_string(j+m) + 
			"><FONT SIZE='2' FACE='" + fontface + "' COLOR='gray'>" + m + "</FONT></TD>";
	}
	
	return vCode;
}

Calendar.prototype.format_day = function(vday) {
	var vNowDay = gNow.getDate();
	var vNowMonth = gNow.getMonth();
	var vNowYear = gNow.getFullYear();

	if (vday == vNowDay && this.gMonth == vNowMonth && this.gYear == vNowYear)
		return ("<FONT COLOR=\"#336699\"><B>" + vday + "</B></FONT>");
	else
		return (vday);
}

Calendar.prototype.write_weekend_string = function(vday) {
	var i;

	// Return special formatting for the weekend day.
	for (i=0; i<weekend.length; i++) {
		if (vday == weekend[i])
			return (" BGCOLOR=\"" + weekendColor + "\"");
	}
	
	return "";
}

Calendar.prototype.format_data = function(p_day) {
	var vData;
	var vMonth = 1 + this.gMonth;
	vMonth = (vMonth.toString().length < 2) ? "0" + vMonth : vMonth;
	var vMon = Calendar.get_month(this.gMonth).substr(0,3).toUpperCase();
	var vFMon = Calendar.get_month(this.gMonth).toUpperCase();
	var vY4 = new String(this.gYear);
	var vY2 = new String(this.gYear.substr(2,2));
	var vDD = (p_day.toString().length < 2) ? "0" + p_day : p_day;

	switch (this.gFormat) {
		case "MM\/DD\/YYYY" :
			vData = vMonth + "\/" + vDD + "\/" + vY4;
			break;
		case "MM\/DD\/YY" :
			vData = vMonth + "\/" + vDD + "\/" + vY2;
			break;
		case "MM-DD-YYYY" :
			vData = vMonth + "-" + vDD + "-" + vY4;
			break;
		case "YYYY-MM-DD" :
			vData = vY4 +"-"+ vMonth + "-" + vDD;
			break;
		case "MM-DD-YY" :
			vData = vMonth + "-" + vDD + "-" + vY2;
			break;

		case "DD\/MON\/YYYY" :
			vData = vDD + "\/" + vMon + "\/" + vY4;
			break;
		case "DD\/MON\/YY" :
			vData = vDD + "\/" + vMon + "\/" + vY2;
			break;
		case "DD-MON-YYYY" :
			vData = vDD + "-" + vMon + "-" + vY4;
			break;
		case "DD-MON-YY" :
			vData = vDD + "-" + vMon + "-" + vY2;
			break;

		case "DD\/MONTH\/YYYY" :
			vData = vDD + "\/" + vFMon + "\/" + vY4;
			break;
		case "DD\/MONTH\/YY" :
			vData = vDD + "\/" + vFMon + "\/" + vY2;
			break;
		case "DD-MONTH-YYYY" :
			vData = vDD + "-" + vFMon + "-" + vY4;
			break;
		case "DD-MONTH-YY" :
			vData = vDD + "-" + vFMon + "-" + vY2;
			break;

		case "DD\/MM\/YYYY" :
			vData = vDD + "\/" + vMonth + "\/" + vY4;
			break;
		case "DD\/MM\/YY" :
			vData = vDD + "\/" + vMonth + "\/" + vY2;
			break;
		case "DD-MM-YYYY" :
			vData = vDD + "-" + vMonth + "-" + vY4;
			break;
		case "DD-MM-YY" :
			vData = vDD + "-" + vMonth + "-" + vY2;
			break;

		default :
			vData = vMonth + "\/" + vDD + "\/" + vY4;
	}

	return vData;
}

function Build(p_item, p_month, p_year, p_format) {
	var p_WinCal = ggWinCal;
	gCal = new Calendar(p_item, p_WinCal, p_month, p_year, p_format);

	// Customize your Calendar here..
	gCal.gBGColor="";
	gCal.gLinkColor="blue";
	gCal.gTextColor="#000000";
	gCal.gHeaderColor="#000000";

	// Choose appropriate show function
	if (gCal.gYearly)	gCal.showY();
	else	gCal.show();
}

function show_calendar() {
	/* 
		p_month : 0-11 for Jan-Dec; 12 for All Months.
		p_year	: 4-digit year
		p_format: Date format (mm/dd/yyyy, dd/mm/yy, ...)
		p_item	: Return Item.
	*/

	p_item = arguments[0];
	if (arguments[1] == null)
		p_month = new String(gNow.getMonth());
	else
		p_month = arguments[1];
	if (arguments[2] == "" || arguments[2] == null)
		p_year = new String(gNow.getFullYear().toString());
	else
		p_year = arguments[2];
	if (arguments[3] == null)
		p_format = "YYYY-MM-DD";
	else
		p_format = arguments[3];

	vWinCal = window.open("", "Calendar","width=350,height=300,status=no,resizable=no,top=200,left=200");
	vWinCal.opener = self;
	ggWinCal = vWinCal;
	Build(p_item, p_month, p_year, p_format);
}
/*
Yearly Calendar Code Starts here
*/
function show_yearly_calendar(p_item, p_year, p_format) {
	// Load the defaults..
	if (p_year == null || p_year == "")
		p_year = new String(gNow.getFullYear().toString());
	if (p_format == null || p_format == "")
		p_format = "YYYY-MM-DD";

	var vWinCal = window.open("", "Calendar", "scrollbars=yes");
	vWinCal.opener = self;
	ggWinCal = vWinCal;

	Build(p_item, null, p_year, p_format);
}

function checkWeekends (id) {
	if ((id == 0) || (id == 6)) {
		alert("WARNING: This date is on a weekend.");
	}
}

function setUploaded(fld,val) {
	document.defaultFrm[fld].value = val;
	moveto('stay');
}

function setNew(val){
	document.defaultFrm.CHANGE_TO_RECORD.value=val+'|NEW';
	moveto('next');
}

function setDirectorate(val){
	document.defaultFrm.CHANGE_TO_RECORD.value='lkp_directorate|'+val;
	moveto('next');
}

function setMandate(val){
	document.defaultFrm.CHANGE_TO_RECORD.value='lkp_che_mandate|'+val;
	moveto('next');
}

function setPerformance(val){
	document.defaultFrm.CHANGE_TO_RECORD.value='lkp_indicator|'+val;
	moveto('next');
}

function setRequiredProject(val){
	document.defaultFrm.CHANGE_TO_RECORD.value='project_required_list|'+val;
	moveto('next');
}

function setRequiredLineItem(val){
	document.defaultFrm.CHANGE_TO_RECORD.value='project_required_line_item|'+val;
	moveto('next');
}

function setUser(val){
	document.defaultFrm.CHANGE_TO_RECORD.value='users|'+val;
	moveto('next');
}

function valTextRequired(fld,msg){
	if (fld.value == '') {
		alert(msg);
		fld.focus();
		document.defaultFrm.MOVETO.value = '';
		return false;
	}
	return true;
}

function valNumberRequired(fld,msg){
	if (fld.value == 0 || isNaN(fld.value)) {
		alert(msg);
		fld.focus();
		document.defaultFrm.MOVETO.value = '';
		return false;
	}
	return true;
}

function valDateRequired(fld,msg){
	if (fld.value == '1970-01-01' || fld.value == '') {
		alert(msg);
		fld.focus();
		document.defaultFrm.MOVETO.value = '';
		return false;
	}
	return true;
}

function restrictDropdown(formObj, restrict_var){
	curDropdown = mA[restrict_var];

	len = formObj.length;
	for (i = (len-1); i > 0 ; i--){
		formObj.options[i] = null;
	}		

	num=1;		// We do not want to replace the first one (0)
	for (var key in curDropdown) {
		formObj.options[num++]=new Option(curDropdown[key][0], key);
	}

}

// 2008-02-08 Robin
// Allow editing from anchors and actions to jump to a different workflow for a particular record and table.  Most of these
// are hardcoded functions in javascript in the template or html page.
// Note: moveto keeps the workflow settings.
function getForm(target,id){
	document.defaultFrm.CHANGE_TO_RECORD.value= target;
	moveto(id);
}

