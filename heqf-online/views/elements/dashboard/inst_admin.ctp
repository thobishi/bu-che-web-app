<h3>You are logged in as an Institutional administrator</h3>
<p>
The Institutional administrator is responsible for managing the data capture of HEQSF-Online applications and then submitting them to the CHE.  The following functionality 
is available from the <b>menu bar at the top of the page</b>:
<p>
		<?php
			echo $this->Html->image("menu_home.png", array(
				"alt" => "Home"
			)); 
		?>
		 Returns you to this page from anywhere in the system
		<br/>
		<br/>
		<?php
			echo $this->Html->image("menu_applications.png", array(
				"alt" => "Applications"
			)); 
		?>
		 Search, view, edit or delete application data. Pass (or take back) applications to colleagues who are assisting you. Submit applications to the CHE.
		<br/>
		<br/>
			<?php echo $this->Html->image('appl_subm_process.png', array('usemap' => '#applicationMap'));?>
		<br/>
		<br/>
		<?php
			echo $this->Html->image("menu_modules.png", array(
				"alt" => "Modules"
			)); 
		?>
		 Access data capture templates for modules. Import modules for the institution and import modules for ALL qualifications (global load of modules).
		<br/>
		<br/>
		<?php
			echo $this->Html->image("menu_bulkimport.png", array(
				"alt" => "Bulk Import"
			)); 
		?>
		 Access data capture templates for qualification applications. Import applications data, view validation report and accept or discard data.
		<p>
			<br/>
			The process of data capture and submission of HEQSF applications is as follows:
			<br/>
			<br/>
			<?php echo $this->Html->image('appl_subm_process_v1.png', array('usemap' => '#importMap'));?>
		</p>
		<br/>
		<br/>
		<?php
			echo $this->Html->image("menu_users.png", array(
				"alt" => "Users"
			)); 
		?>
		 Create or update user accounts for colleagues.
		<br/>
		<br/>
		<?php
			echo $this->Html->image("menu_account.png", array(
				"alt" => "Your Account"
			)); 
		?>
		 Update the details of your account.
		<br/>
		<br/>
		<?php
			echo $this->Html->image("menu_help.png", array(
				"alt" => "Help"
			)); 
		?>
		 Access relevant documents including the HEQSF-Online user manual.
		<br/>
		<br/>
		<?php
			echo $this->Html->image("menu_logout.png", array(
				"alt" => "Logout"
			)); 
		?>
		 Logout the system
</p>

<?php
	$allUrl = $this->Html->url(array(
		'controller' => 'process',
		'action' => 'list_process',
		'process-slug' => 'application'
	));
	$needsCorrectionUrl = $this->Html->url(array(
		'controller' => 'process',
		'action' => 'list_process',
		'error' => true,
		'status' => 'New',
		'process-slug' => 'application'
	));
	$submitUrl = $this->Html->url(array(
		'controller' => 'process',
		'action' => 'list_process',
		'error' => false,
		'status' => 'New',
		'process-slug' => 'application'
	));
?>
<map name="applicationMap">
	<area shape='rect' coords="10,9,130,57" href="<?php echo $allUrl; ?>">
	<area shape='rect' coords="157,9,277,57" href="<?php echo $needsCorrectionUrl; ?>">
	<area shape='rect' coords="301,9,422,57" href="<?php echo $submitUrl; ?>">
</map>
<map name="importMap">
	<area shape=Rect Coords=10,9,130,57 href="heqf_qualifications/download_template">
	<area shape=Rect Coords=301,9,422,57 href="heqf_qualifications/import">
	<area shape=Rect Coords=453,9,573,57 href="<?php echo $needsCorrectionUrl; ?>">
	<area shape=Rect Coords=599,9,720,57 href="<?php echo $submitUrl; ?>">
</map>
