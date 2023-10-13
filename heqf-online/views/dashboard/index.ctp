<?php
	if(Auth::get()) {
		$roles = Auth::get('Role');
		echo '<div class="dashboard">';
		echo $this->element('notice');
		echo $this->element('dashboard/welcome_message');
		if(count($roles) == 1){
			foreach($roles as $role) {
				echo $this->element('dashboard/' . $role['dashboard_view']);
			}
		}
		else{
			echo $this->element('dashboard/multi_role');
		}
		echo '</div>';
	}
	else {
		echo $this->element('dashboard/guest');
	}