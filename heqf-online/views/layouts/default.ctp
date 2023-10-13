<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('HEQSF: Higher Education Qualification Sub-Framework:'); ?> | <?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array(
			'cake.generic', 
			'custom-theme/jquery-ui', 
			'validation', 
			'/jquery_plugins/css/jquery.pnotify.default',
			'select2',
			'bootstrap',
			'styles'
		));
		
		echo $this->Html->script(array(
			'/jquery/js/jquery.js', 
			'jquery.form', 
			'/jquery/js/jquery.ui',
			'/jquery_plugins/js/jquery.pnotify.min',
			'/jquery_plugins/js/jquery.blockUi',
			'/jquery_plugins/js/jquery.scrollfollow',
			'/js/clicknscroll',
			'/js/bootstrap',
			'/js/select2.min'
		));

		echo $scripts_for_layout;
	?>
	<script>
		function configureButtons() {
			$('.bulkButtons, .actions').buttonset();
		}

		$(function() {
			$.ajaxSetup({
				cache: false
			});

			$('#sidebar').scrollFollow();

			configureButtons();
		});
	</script>
</head>
<body>
	<div id="container">
		<div id="header">
			<?php echo $this->Html->image('new_logo.gif', array('id' => 'logoImage', 'url' => '/', 'width' => '203', 'height' => '46')); ?>
		</div>
		<?php echo $this->element('layout/menu'); ?>
		
		<?php 
			$sidebar = $this->element('layout/sidebar');
			$class = trim($sidebar) == '' ? 'no-sidebar' : '';
		?>
		
		<div id="wrapper" class="<?php echo $class?>">
		  <div id="inner-container">
			  <div id="content">
				<div class="content-object">
				<?php
					$errorFlash = $this->Session->flash('auth') . $this->Session->flash('error');
					$messageFlash = $this->Session->flash();
					
					if(!empty($errorFlash) || !empty($messageFlash)) {
						$messageBox = '<div id="flash-messages">';
						if(!empty($errorFlash)) {
							$messageBox .= '<div class="ui-state-error ui-corner-all">';
							$messageBox .= '<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>';
							$messageBox .= $errorFlash;
							$messageBox .= '</div>';
						}
						
						if(!empty($messageFlash)) {
							$messageBox .= '<div class="ui-state-good ui-corner-all">';
							$messageBox .= '<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>';
							$messageBox .= $messageFlash;
							$messageBox .= '</div>';
						}						
						
						$messageBox .= '</div>';
						
						echo $messageBox;
					}
				?>

			  <?php echo $content_for_layout; ?>
				</div>
			</div>
		  </div>
			
		  <?php echo $sidebar?> 
			
		  <div class="clearing">&nbsp;</div>
		</div>
		<div id="footer">
		</div>
	</div>

	<span id="rootUrl" class="ui-helper-hidden"><?php echo $this->Html->url('/'); ?></span>	

	<script>
	$(function(){
		$("#content").clickNScroll({
			allowHiliting: true,
		});
		$('#content').mousedown(function(event){
			if($(event.target).is("input:text") || $(event.target).is("input:password") || $(event.target).is("textarea")){
				$(event.target).focus().val($(event.target).val());	
			}
		});
	});
	</script>	
</body>
</html>