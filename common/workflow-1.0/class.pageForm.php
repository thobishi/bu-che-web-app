<?php

//require_once ('class.createPage.php');
//require_once ('class.formActions.php');
//require_once ('class.formFields.php');

define ("FLD_STATUS_DEFAULT", 0);
define ("FLD_STATUS_ENABLED", 1);
define ("FLD_STATUS_DISABLED", 2);
define ("FLD_STATUS_TEXT", 3);
define ("CHK_DEFAULT_TRUE", 1);
define ("CHK_DEFAULT_FALSE", 0);

class pageForm extends createPage {

	var $formName, $formAction, $formMethod, $formHidden, $formTarget;
	var $formOnSubmit;
	var $formActions, $db_settingsKey;
	var $formStatus;
	var $beginYear, $endYear;

	function __construct () {
		$this->createPage ();
		$this->formInit();
	}
	
	function pageForm () {
		self::__construct();
	}

	function formInit () {
		$this->formName = "defaultFrm";
		// $this->formAction = $selfArr[count($selfArr)-1];
		$this->formAction = "?";
		$this->formMethod = "POST";
		$this->formHidden = array ();
		$this->formActions = array ();
		$this->formStatus = 0;
		$this->formTarget = "";
	}

	function createForm () {
		$ONSUBMIT = "";
		if ( isset($this->formOnSubmit) && ($this->formOnSubmit > "") ) {
			$ONSUBMIT = ' onSubmit="'.$this->formOnSubmit.'"';
		}
		echo '<FORM ';

		echo 'NAME="'.$this->formName.'" ID="'.$this->formName.'" ACTION="'.$this->formAction.'" METHOD="'.$this->formMethod.'"'.$ONSUBMIT.' TARGET="'.$this->formTarget.'">'."\n";
		foreach ($this->formHidden as $key => $val) {
			// 2010-03-08 Robin: Need ID for getElementbyID for firefox.  Replace document.All javascript syntax.
			//echo '<INPUT TYPE=HIDDEN NAME="'.$key.'" VALUE="'.$val.'">'."\n";
			echo '<INPUT TYPE=HIDDEN NAME="'.$key.'" ID="'.$key.'" VALUE="'.$val.'">'."\n";
		}
	}

	function createAction ($name, $desc, $type="", $dest="", $img="", $imgAlt="", $target="", $title="") {
		$this->formActions[$name] = new formActions ($name);
		$this->formActions[$name]->actionDesc = $desc;
		if ($type > "") $this->formActions[$name]->actionType = $type;
		if ($dest > "") $this->formActions[$name]->actionDest = $dest;
		if ($img > "") {
			$img = "<img src='images/".$img."' alt='".$imgAlt."' border=0>";
			$this->formActions[$name]->actionImg = $img;
		}
		if ($target > "") $this->formActions[$name]->target = $target;
		if ($title > "") $this->formActions[$name]->title = $title;
	}

	function readDefaultActions () {
		$inst_code = $this->getValueFromTable("users", "user_id", $this->currentUserID, "institution_ref");
		if (($inst_code != 1) && ($inst_code != 2))
		{
			$SQL = "SELECT * FROM template_text WHERE template_ref = ? AND text_type_ref = 3";
                        $conn = $this->getDatabaseConnection();
                        $sm = $conn->prepare($SQL);
                        $sm->bind_param("s", $this->template);
                        $sm->execute();
                        $rs = $sm->get_result();
                        
			//$rs = mysqli_query ($this->getDatabaseConnection(), $SQL);
			while ($row = mysqli_fetch_assoc ($rs)) {
				$this->createAction ("PageHelp", $row["template_text_desc"], "href", "javascript:winContentText('".$row["template_text_desc"]."', '".$this->template."', '".$row["text_actual"]."');", "ico_help.gif", $row["template_text_desc"]);
			}
		}
	}

	function showActions () {
		// first check if we do not need any default action (from the database)
		$this->readDefaultActions ();

		foreach ($this->formActions as $key => $obj) {
			if ($obj->actionMayShow) {
				switch ($obj->actionType) {
					case 'login':
						$action = "submit";
					case 'button':
						$action = $obj->actionType;
						echo '<tr><td width="28" valign="top"><div id="action_'.$obj->actionName.'Img" style="display:Block">' . $obj->actionImg.'</div></td><td valign="top"><div id="action_'.$obj->actionName.'" style="display:Block"><INPUT CLASS="'.$obj->actionClass.'" TYPE="'.$action.'" NAME="'.$obj->actionName.'" VALUE="'.$obj->actionDesc.'"></div></td></tr>'."\n";
						break;
					case 'submit':
						echo '<tr><td height=22 width="28" valign="top"><div id="action_'.$obj->actionName.'_Img" style="display:Block">'."<a title='".$obj->title."' target='".$obj->target."' CLASS='".$obj->actionClass."' href=\"javascript:moveto('".$obj->actionName."');\">". $obj->actionImg. '</a></div></td><td height=22 valign="top"><div id="action_'.$obj->actionName.'" style="display:Block">'."<a title='".$obj->title."' target='".$obj->target."' CLASS='".$obj->actionClass."'  href=\"javascript:moveto('".$obj->actionName."');\">".$obj->actionDesc."</a></div></td></tr>\n";
						break;
					case 'href':
						echo '<tr><td height=22 width="28" valign="top"><div id="action_'.$obj->actionName.'_Img" style="display:Block">'."<a title='".$obj->title."' target='".$obj->target."' CLASS='".$obj->actionClass."' href=\"".$obj->actionDest."\">".$obj->actionImg. '</a></div></td><td height=22 valign="top"><div id="action_'.$obj->actionName.'" style="display:Block">'."<a title='".$obj->title."'  target='".$obj->target."' CLASS='".$obj->actionClass."' href=\"".$obj->actionDest."\">".$obj->actionDesc."</a></div></td></tr>\n";
						break;
					case 'blank':
						echo '<tr><td height=22 width="28" valign="top"><div id="action_'.$obj->actionName.'_Img" style="display:Block">'.$obj->actionImg.'</div>'.'</td><td height=22 valign="top"><div id="action_'.$obj->actionName.'" style="display:Block">'."<a CLASS='".$obj->actionClass."' href=\"".$obj->actionDest."\">".$obj->actionDesc."</a></div></td></tr>\n";
						break;
				}
			}
		}
	}

	function setFieldProperties ($name, $type="", $size="") {
		$obj = &$this->formFields[$name];
		if ($type > "") $obj->fieldType = $type;
		if ($size > "") $obj->fieldSize = $size;
	}

	function fieldToDB($properties) {
		if (count($properties) > 0) {
			$keys = array();
			$values = array();
			foreach ($properties AS $key=>$value) {
				if (!(($key == "fieldValue") || ($key == "fieldValuesArray"))) {
					array_push ($keys, $key);
					if (is_array($value)) {
						$value = implode("|", $value);
					}
					array_push ($values, $value);
				}
			}
			$values = str_replace("'", "\\'", $values);
			$SQL = "REPLACE INTO `template_field` (template_name, ".implode(",",$keys).") VALUES ('".$this->template."', '".implode ("','", $values)."')";
		//	$RS = mysqli_query($SQL) or die($SQL);
		}
	}

	function templateToDB($template) {
		if (count((array)$template) > 0) {
			$keys = array();
			$values = array();
			foreach ($template AS $key=>$value) {
				if ($key != "dbTableCurrentID") {
					array_push ($keys, "template_".$key);
					array_push ($values, $value);
				}
			}
		}
		//$SQL = "REPLACE INTO `template_info` (template_name, ".implode(",",$keys).") VALUES ('".$this->template."', '".implode ("','", $values)."')";
		//$RS = mysqli_query($SQL);
	}

	function createInput ($name, $type="", $val="", $size="", $status=0) {
		$this->formFields[$name] = new formFields ($name);
		$obj = &$this->formFields[$name];

		switch ($type) {
			case "RADIO":
			case "RADIO:VERTICAL":
			case "SELECT":
			case "MULTIPLE":
				if ($val > "") {
					$obj->fieldValuesArray = $val;
				}
				break;
			case "CHECKBOX":
				if ($val > "") {
					$obj->fieldValue = $val;
				} else {
					$obj->fieldValue = CHK_DEFAULT_TRUE;
				}
				break;
			default:
				$obj->fieldValue = $val;
				break;
		}
		$this->setFieldProperties ($name, $type, $size);
		$obj->fieldStatus = $status;
	}

	function createField ($name, $type="", $val="", $size="") {

		$this->createInput ($name, $type, $val, $size);
		$obj = &$this->formFields[$name];
		$obj->fieldDBconnected = true;

		// if it is a CHECKBOX insert/add to an array in the hidden values.
		if (strtoupper($obj->fieldType) == "CHECKBOX") {
			$this->addHiddenArray("SHOULDSAVE", $name);
		}
		$this->getFieldSettingsFromDB($name);
		$this->setFieldProperties ($name, $type, $size);   // run eintlik al vir die 2de keer

		if (isset($this->dbTableCurrent) && isset($this->dbTableInfoArray[$this->dbTableCurrent]) && $this->dbTableInfoArray[$this->dbTableCurrent]->dbTableCurrentID != "NEW") {
			$SQL = "SELECT ".$name." FROM ".$this->dbTableCurrent." WHERE ".$this->dbTableInfoArray[$this->dbTableCurrent]->dbTableKeyField." = '".$this->dbTableInfoArray[$this->dbTableCurrent]->dbTableCurrentID."'";
			$rs = mysqli_query($this->getDatabaseConnection(), $SQL);
			if ($rs) {
				if ($row = mysqli_fetch_array ($rs)) {
					if ($obj->fieldType != "CHECKBOX") {
						$obj->fieldValue = $row[0];
					} else {
						if ($row[0]) {
							$obj->fieldOptions = "CHECKED";
						}
					}
				}
			}
		}
	}

	function createFieldFromDB ($name, $type, $table, $key="", $val="", $size="",$where="1") {
		$SQL = "SELECT * FROM ".$table." WHERE ".$where;
		$valArr = $this->makeArrayFromSQL($SQL, $key, $val);
		$this->createField($name, $type, $valArr, $size);
		$this->formFields[$name]->fieldSelectTable = $table;
		$this->formFields[$name]->fieldSelectID = $key;
		$this->formFields[$name]->fieldSelectName = $val;
	}

	function createForeignFieldFromDB ($name, $fTable, $fKeyField, $fKeyValue, $type, $lkpTable, $lkpKeyField="", $lkpKeyValue="", $returnField="", $returnDesc="", $size="") {
		$SQL = "SELECT * FROM ".$lkpTable;
		if ($lkpKeyField > "") {
					 $SQL .= " WHERE $lkpKeyField = '$lkpKeyValue'";
		}
		$valArr = $this->makeArrayFromSQL($SQL, $returnField, $returnDesc);
		$this->createForeignField($name, $fTable, $fKeyField, $fKeyValue, $type, $valArr, $size);
	}

	function createForeignField ($name, $fTable, $fKeyField, $fKeyValue, $type="", $val="", $size="") {
		if ($val > "") {
			$defaultValue = $val;
		} else {
			$defaultValue = $this->getValueFromTable($fTable, $fKeyField, $fKeyValue, $name);
		}
		$this->createField($name, $type, $defaultValue, $size);
		$this->formHidden["INFFT_".$name] = $fTable."_|_".$fKeyField."_|_".$fKeyValue."_|_".$name;
	}

	function createMultipleRelation ($name, $mainTable, $mainFld, $mainVal, $relationFld, $relationTable, $relationKey, $relationVal, $size="") {
		$SQL = "SELECT $relationTable.$relationKey, $relationTable.$relationVal ".
					 "FROM $mainTable, $relationTable ".
					 "WHERE $mainTable.$relationFld = $relationTable.$relationKey ".
					 "AND $mainTable.$mainFld = '$mainVal'";

		$valArr = $this->makeArrayFromSQL($SQL);
		$this->createField($name, "MULTIPLE", $valArr, $size);
		$this->formHidden["MRINF_".$name] = $mainTable."_|_".$mainFld."_|_".$mainVal."_|_".$relationFld;
		$this->formFields[$name]->fieldMainTable = $mainTable;
		$this->formFields[$name]->fieldMainFld = $mainFld;
		$this->formFields[$name]->fieldMainVal = $mainVal;
		$this->formFields[$name]->fieldRelationFld = $relationFld;
		$this->formFields[$name]->fieldRelationTable = $relationTable;
		$this->formFields[$name]->fieldRelationKey = $relationKey;
		$this->formFields[$name]->fieldRelationVal = $relationVal;
	}

	function createInputFromDB ($name, $type, $table, $key="", $val="", $size="", $where="", $orderby="") {
		$SQL = "SELECT * FROM ".$table;
		if ($where > "") $SQL .= " WHERE ".$where;
		if ($orderby > "") $SQL .= " ORDER BY ".$orderby;
		$valArr = $this->makeArrayFromSQL($SQL, $key, $val);
		$this->createInput($name, $type, $valArr, $size);
		$this->formFields[$name]->fieldSelectTable = $table;
		$this->formFields[$name]->fieldSelectID = $key;
		$this->formFields[$name]->fieldSelectName = $val;
	}

	function showField ($name) {
		$style = "";
		$onclick = "";
		$onchange = "";
		$options = "";
		if ( isset($this->formFields[$name]) ) {
			$obj = $this->formFields[$name];

			$DBfld = ( ($obj->fieldDBconnected)?("FLD_"):("") );
			if ($obj->fieldDBconnected && $obj->fieldType == "MULTIPLE") {
				$DBfld = "FLDS_";
			}
			if ($obj->fieldDBconnected && $obj->fieldType == "ADMINPASSWORD") {
				$DBfld = "PWA_";
			}
			if (isset($obj->fieldStyle) && ($obj->fieldStyle > "") ){
				$style = ' STYLE="'.$obj->fieldStyle.'"';
			}
			if (isset($obj->fieldOptions) && ($obj->fieldOptions > "") ){
				$options = ' '.$obj->fieldOptions.' ';
			}
			if (isset($obj->fieldOnClick) && ($obj->fieldOnClick > "") ){
				$onclick = ' OnClick="'.$obj->fieldOnClick.'"';
			}
			if (isset($obj->fieldOnChange) && ($obj->fieldOnChange > "") ){
				$onchange = ' OnChange="'.$obj->fieldOnChange.'"';
			}

			$status = FLD_STATUS_ENABLED; //default status  enabled
			if ($this->formStatus > FLD_STATUS_DEFAULT) $status = $this->formStatus;
			if ($obj->fieldStatus > FLD_STATUS_DEFAULT) $status = $obj->fieldStatus;

			switch ($status) {
				case FLD_STATUS_ENABLED:
						$this->doPrintField($obj, $DBfld, $style, $onclick, $onchange, $options);
						break;
				case FLD_STATUS_DISABLED:
						$status = " DISABLED";
						$this->doPrintField($obj, $DBfld, $style, $onclick, $onchange, $status, $options);
						break;
				case FLD_STATUS_TEXT:

						$fieldValue = simple_text2html ($obj->fieldValue);
						// Commented out by Robin 11/1/2007. Replaced by code below it.
						// Reason:  Some radio buttons from e.g. grid slip through this condition. Their $obj->fieldSelectTable
						// 			is blank.  The fieldValuesArray seems to pickup everything that has a lookup.
						//for selects and radios etc.
						//if ($obj->fieldSelectTable > "") {
						//	$fieldValue = $this->getValueFromTable ($obj->fieldSelectTable, $obj->fieldSelectID, $obj->fieldValue, $obj->fieldSelectName);
						//}

						// for any field that has a lookup array of values (radio, select) - Robin 11/1/2007
						
						if (isset($obj->fieldValuesArray[$obj->fieldValue])){
							$fieldValue = $obj->fieldValuesArray[$obj->fieldValue];
						}
						
						// 2012-04-30 Robin: If lookup tables change by disabling historic values and adding more relevant values then 
						// historic values should still display. Fix for codes displaying as e.g. 6 because option 6 in the list was disabled.
						// Exclude default blank values: 0
						// Currently only adding for a SELECT input - could consider including RADIO.
						if ($obj->fieldType == 'SELECT'){
							if ($obj->fieldValue > 0 AND (!isset($obj->fieldValuesArray[$obj->fieldValue]))){  // ones in array are picked up in preceding statement. Want to catch the ones falling through the cracks.
								$fieldValue = $this->getValueFromTable($obj->fieldSelectTable, $obj->fieldSelectID, $obj->fieldValue, $obj->fieldSelectName);
							}
						}

						//for MULTIPLE selects etc.
						if (($obj->fieldMainTable > "") && ($obj->fieldRelationTable > "")) {
							foreach ($obj->fieldValuesArray AS $fValue) {
								$fieldValue .= "<br>".$fValue."\n";
							}
						}

						if ($obj->fieldType != "HIDDEN" AND $obj->fieldType != "FILE") {
							echo $fieldValue."<br>\n";
						}
						break;
			}
		}
	}

	function doPrintField($obj, $DBfld="", $style="", $onclick="", $onchange="", $status="", $options="") {
		switch (strtoupper($obj->fieldType)) {
			case "TEXT":
			case "HIDDEN":
			case "PASSWORD":
				echo '<INPUT CLASS="'.$obj->fieldClass.'" TYPE="'.$obj->fieldType.'" NAME="'.$DBfld.$obj->fieldName.'" VALUE="'.system_htmlspecialchars($obj->fieldValue).'" SIZE="'.$obj->fieldSize.'" MAXLENGTH="'.$obj->fieldMaxFieldSize.'"'.$style.$onclick.$onchange.$status.$options.'>';
				break;
			case "ADMINPASSWORD":
				echo '<INPUT CLASS="'.$obj->fieldClass.'" TYPE="PASSWORD" NAME="'.$DBfld.$obj->fieldName.'" VALUE="" SIZE="'.$obj->fieldSize.'" MAXLENGTH="'.$obj->fieldMaxFieldSize.'"'.$style.$onclick.$onchange.$status.$options.'>';
				break;
			case "FILE":
				$this->makeDocInput($obj,$DBfld);
				break;
			case "TEXTAREA":
				echo '<TEXTAREA CLASS="'.$obj->fieldClass.'" NAME="'.$DBfld.$obj->fieldName.'" cols="'.$obj->fieldCols.'" rows="'.$obj->fieldRows.'"'.$style.$onclick.$onchange.$status.$options.'>'.$obj->fieldValue."</TEXTAREA>";
				break;
			case "RADIO":
			echo '<table><tr>';
				foreach ($obj->fieldValuesArray as $key => $val) {
					$SEL = "";
					if ($obj->fieldValue == $key) $SEL = " CHECKED";
					echo '<td nowrap><INPUT CLASS="'.$obj->fieldClass.'" TYPE="RADIO" NAME="'.$DBfld.$obj->fieldName.'" ID="'.$key.'" VALUE="'.$key.'"'.$style.$onclick.$onchange.$SEL.$status.$options.'>'.$val." </td> ";
				}
			echo '</tr></table>';
				break;
			case "RADIO:VERTICAL":
			echo '<table>';
				foreach ($obj->fieldValuesArray as $key => $val) {
					echo '<tr>';
					$SEL = "";
					if ($obj->fieldValue == $key) $SEL = " CHECKED";
					echo '<td valign="top"><INPUT CLASS="'.$obj->fieldClass.'" TYPE="RADIO" NAME="'.$DBfld.$obj->fieldName.'" ID="'.$key.'" VALUE="'.$key.'"'.$style.$onclick.$onchange.$SEL.$status.$options.'></td><td valign="top">'.$val.'</td>';
					echo '</tr>';
				}
			echo '</table>';
				break;
			case "ENUM":
				foreach ($obj->fieldValuesArray as $key => $val) {
					$SEL = "";
					if ($obj->fieldValue == $key) $SEL = " CHECKED";
					echo '<INPUT CLASS="'.$obj->fieldClass.'" TYPE="RADIO" NAME="'.$DBfld.$obj->fieldName.'" ID="'.$key.'" VALUE="'.$key.'"'.$style.$onclick.$onchange.$SEL.$status.$options.'>'.$val." &nbsp; ";
				}
				break;
			case "CHECKBOX":
				echo '<INPUT CLASS="'.$obj->fieldClass.'" TYPE="'.$obj->fieldType.'" NAME="'.$DBfld.$obj->fieldName.'" VALUE="'.$obj->fieldValue.'" '.$style.$onclick.$onchange.$status.$options.'>';
				break;
			case "SELECT":
				$this->makeSelectField($obj->fieldName, $obj->fieldValuesArray, $obj, $obj->fieldValue, $DBfld, $style, $onclick, $onchange, $status, $options);
				break;
			case "MULTIPLE":
				$this->makeSelectField($obj->fieldName."[]", $obj->fieldValuesArray, $obj, $obj->fieldValue, $DBfld, $style, $onclick, $onchange, $status, "MULTIPLE");
				break;
			case "DATE":
				$this->makeDateFields($obj, $DBfld, $style, $onclick, $onchange, $status, $options);
				break;
			case "TIME":
				$this->makeTimeFields($obj, $DBfld, $style, $onclick, $onchange, $status, $options);
				break;
		}
	}

	function makeSelectField($fieldName, $arr, $obj, $defaultVal, $DBfld="", $style="", $onclick="", $onchange="", $status="", $options="") {
//		$this->printVars($obj);
		echo '<SELECT CLASS="'.$obj->fieldClass.'" NAME="'.$DBfld.$fieldName.'" '.$style." ".$onclick." ".$onchange." ".$status." ".$options.'>';
		if ($obj->fieldNullValue > "") {
			echo '<OPTION VALUE="0">'.$obj->fieldNullValue.'</OPTION>'."\n";
		}
			foreach ($arr as $key => $val) {
				$SEL = "";
				if ($defaultVal == $key) $SEL = " SELECTED";
				echo '<OPTION VALUE="'.$key.'"'.$SEL.' >'.$val.'</OPTION>'."\n";
			}
		echo "</SELECT>\n";
	}


	//Reyno van der Hoven
	//2004/4/2
	//Maak dat popup calender werk vir alle date fields
	function makeDateFields($obj, $DBfld="", $style="", $onclick="", $onchange="", $status="", $options="") {
		echo '<INPUT readonly CLASS="'.$obj->fieldClass.'" TYPE="TEXT" NAME="'.$DBfld.$obj->fieldName.'" VALUE="'.$obj->fieldValue.'" SIZE="'.$obj->fieldSize.'" MAXLENGTH="'.$obj->fieldMaxFieldSize.'"'.$style.$onclick.$onchange.$status.'>';
		?>
		<a href="javascript:show_calendar('defaultFrm.<?php echo $DBfld.$obj->fieldName?>');"><img src="images/icon_calendar.gif" border=0></a>
		<?php
	}

	//Louwtjie
	//2004/4/20
	//Maak dat popup calender werk vir alle time fields
	function makeTimeFields($obj, $DBfld="", $style="", $onclick="", $onchange="", $status="", $options="") {
		echo '<INPUT readonly CLASS="'.$obj->fieldClass.'" TYPE="TEXT" NAME="'.$DBfld.$obj->fieldName.'" VALUE="'.$obj->fieldValue.'" SIZE="'.$obj->fieldSize.'" MAXLENGTH="'.$obj->fieldMaxFieldSize.'"'.$style.$onclick.$onchange.$status.'>';
		?>
		<a href="javascript:showTime('','defaultFrm.<?php echo $DBfld.$obj->fieldName?>');"><img src="images/icon_time.gif" border=0></a>
		<?php
	}

	function getFieldSettingsFromDB ($name) {

		$obj = &$this->formFields[$name];
		if ( (DB_DATABASE) && isset($this->dbTableCurrent) ) {
			// If the next line gives an error the following are not filled in:
			// for your template in db: work_flows
			// cols:template_dbTableName & template_dbTableKeyField
			$fields = mysqli_query( $this->getDatabaseConnection(), 'SHOW COLUMNS FROM '.$this->dbTableCurrent );
			//$fields = mysqli_list_fields(DB_DATABASE, $this->dbTableCurrent);
			$columns = mysqli_num_fields($fields);
			for ($i = 0; $i < $columns; $i++) {
		    if (mysqli_fetch_field_direct ($fields, $i)->name == $name) {
					$obj->fieldSize = mysqli_field_len ($fields, $i);
					$obj->fieldMaxFieldSize = mysqli_field_len ($fields, $i);
					if ( strstr(mysqli_field_flags ($fields, $i), "enum") ) {
						$SQL = "SHOW FIELDS FROM ".$this->dbTableCurrent;
						$rs = mysqli_query ($this->getDatabaseConnection(), $SQL);
						while ($row = mysqli_fetch_assoc ($rs)) {
							if ($row["Field"] == $name) {
								$vals = explode ("','", substr ($row["Type"], 6, strlen($row["Type"])-8) );
								foreach ($vals as $val) {
									$obj->fieldValuesArray[$val] = $val;
								}
							}
						}
					}
				}
			}
		}

	}

	function getFieldValue ($name) {
		if ( isset($this->formFields[$name]) ) {
			$obj = $this->formFields[$name];
			return ($obj->fieldValue);
		}
		return ("");
	}

	function addHiddenArray($name, $val) {
		if (isset($this->formHidden[$name])) {
			$this->formHidden[$name] .= "_|_".$val;
		} else {
			$this->formHidden[$name] = $val;
		}
	}
}

?>
