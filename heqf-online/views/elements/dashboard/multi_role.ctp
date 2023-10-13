<?php
	$roles = Auth::get('Role');
	
	if(!empty($roles)){
?>
<h3>You are logged in with the following roles:</h3>
	<div id="accordion">
	<?php
		foreach($roles as $role){
	?>
			<h3>
				<a href="#"><?php echo $role['name']; ?></a>
			</h3>
			<div>
				<?php echo $this->element('dashboard/' . $role['dashboard_view']); ?>
			</div>
	<?php
		}
	?>
	</div>
<?php
	}
?>

<script>
	$(function() {
		$( "#accordion" ).accordion({
			autoHeight: false
		});
	});
</script>