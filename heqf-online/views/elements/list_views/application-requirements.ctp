<?php
	if(!Auth::checkRole('che_admin') && !Auth::checkRole('che_default')) {
		echo $this->element('list_views/application/institution');
	}
	else {
		echo $this->element('list_views/application/che');
	}