<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title_for_layout; ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->Html->url('/css/pdf.css', true) ?>" />
	</head>
	<body>
		<h1><?php echo $title_for_layout; ?></h1>
		<?php echo $content_for_layout; ?>
	</body>
</html>
<?php
	if(isset($filename) && $filename > ''){
		$this->setOption('filename', $filename . '.pdf');
	}
 ?>