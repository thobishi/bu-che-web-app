<div class="dashboard">
<h2>Help page</h2>
<p>For any additional information, please consult the help documents below.</p>

<ul>
<?php
	echo '<li>' . $html->link('Help manual - Institutional administrator', array('controller' => 'pages', 'action' => 'download_help', 'manual-instadmin')) . '</li>';
	echo '<li>' . $html->link('Help manual - Institutional user', array('controller' => 'pages', 'action' => 'download_help', 'manual-instuser')) . '</li>';
	echo '<li>' . $html->link('Help manual - CHE administrator', array('controller' => 'pages', 'action' => 'download_help', 'manual-cheadmin')) . '</li>';
	echo '<li>' . $html->link('Revised HEQSF as of September 2011', array('controller' => 'pages', 'action' => 'download_help', 'revised')) . '</li>';
	echo '<li>' . $html->link('HEQSF review discussion', array('controller' => 'pages', 'action' => 'download_help', 'discussion')) . '</li>';
	echo '<li>' . $html->link('Classification of Educational Subject Matter', array('controller' => 'pages', 'action' => 'download_help', 'cesm')) . '</li>';
	echo '<li>' . $html->link('Publication of the GFETQSF and HEQSF of the NQF', array('controller' => 'pages', 'action' => 'download_help', 'gfetqsf')) . '</li>';
	echo '<li>' . $html->link('HEQSF Alignment Section 2 validation checklist', array('controller' => 'pages', 'action' => 'download_help', 's2_valid')) . '</li>';
?>
</ul>
</div>