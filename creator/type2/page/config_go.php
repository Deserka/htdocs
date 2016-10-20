<?php

echo '<h2>Page Config:</h2>';

require_once($_SERVER['DOCUMENT_ROOT']."/creator/lib/lead/lead.php");

	$config = new page_config_createConfig();
	$content = 
		$config->startComment($_POST['view_name']) .
		$config->createList($_POST['cms_config'], $_POST['list_elements_amount'], $_POST['date_format']) .
		$config->endComment($_POST['view_name']);
		
	$config->deleteCommentedByModuleName($_POST['view_name'], $_SERVER['DOCUMENT_ROOT'].'/config/page_config.php');
	$config->saveInExistedFile($content, $_SERVER['DOCUMENT_ROOT'].'/config/page_config.php');
	$config->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/config/page_config.php');

	unset($config);
	unset($content);

echo 'Page Config zapisany.';