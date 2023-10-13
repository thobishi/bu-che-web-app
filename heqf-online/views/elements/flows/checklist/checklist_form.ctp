<?php
echo $this->Form->hidden('Application.checklisting_date', array('value' => date('Y-m-d', time())));
echo $this->Form->hidden('Application.checklisting_user_id', array('value' => Auth::get('User.id')));
echo '<label><b>Checklisting Status</b></label>';
?>
<div id="alert" class="flash-messages">
	<div class="ui-state-good ui-corner-all"><b>NOTE:</b>
		<ul>
			<li>
				<u><i>Checklisting:</i></u><br />
				Checklisting is incomplete. Remains with the checklisting user.
			</li>
			<li>
				<u><i>Return to institution:</i></u><br />
				Checklisting is complete, but not ready for evaluation. The application is returned to the CHE administrator.
			</li>
			<li>
				<u><i>Ready for evaluation:</i></u><br />
				Checklisting is complete and is ready for evaluation. The application is returned to the CHE administrator.
			</li>
		</ul>
	</div>
</div>
<?php
$between = '<div id="alert" class="flash-messages">
				<div class="ui-state-good ui-corner-all">PLease enter the comments that would be visible for the instituion in order to make the necessary correction(s).
					Please note that this would be available to the instituion.
			</div></div>';
echo $this->Form->input('Application.checklisting_status_id', array('type' => 'radio', 'legend'=> false, 'options' => $ChecklistingStatus));
echo $this->Form->input('Application.checklisting_comments', array('label' => '<b>Comments / suggestions</b>', 'type' => 'textarea', 'between' => $between)); //do a before for this -> 
?>