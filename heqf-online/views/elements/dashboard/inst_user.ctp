<h3>You are logged in as an Institutional user</h3>
<p>The Institutional user may assist with the upload of applications and  the correction of any import errors in order to get the application ready for 
submission to the Council on Higher Education (CHE). When completed, the user must send the applications to the Institution administrator.
The following functionality is available from the <b>menu bar at the top of the page</b>:
<br/>
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
		 Search, view, edit or delete application data for applications that are assigned to you.
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
<!-- 2013-11-13 Removed by Robin. Re-opening of system allowing new applications and 
<ol>
	<li>
		<b>Home</b>: Returns you to this page from anywhere in the system
		<br/><br/>
	</li>
	<li>
		<b>Applications</b>: Download the template, import and correct applications and send them to your institutional administrator
		<p>
			<br/>
			The process of data capture and submission of HEQSF applications is as follows:
			<br/>
			<br/>
			<?php echo $this->Html->image('appl_subm_process_user.png', array('usemap' => '#applicationMap'));?>
		</p>
	</li>
	<li>
		<b>Your account</b>: Update the details of your account.
		<br/><br/>
	</li>
	<li>
		<b>Help</b>: Access the HEQSF-Online user manual
		<br/><br/>
	</li>
	<li>
		<b>Logout</b>: Logout the system
	</li>
</ol>
<br/>
</p>
<?php
	$applicationUrl = $this->Html->url(array(
		'controller' => 'process',
		'action' => 'list_process',
		'process-slug' => 'application'
	));
?>
<map name="applicationMap">
	<area shape="rect" coords="8,6,129,54" href="heqf_qualifications/download_template">
	<area shape="rect" coords="299,6,419,54" href="heqf_qualifications/import">
	<area shape="rect" coords="597,6,796,54" href="<?php echo $applicationUrl;?>">
</map>
<!-->