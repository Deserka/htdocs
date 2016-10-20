<?php

echo '<h2>Page Controller:</h2>';

$controller = new page_controller_createController();

$content =
	$controller->createControllerStart($_POST['cms_model']) .
	$controller->createControllerConstruct($_POST['cms_model']) .
	$controller->createControllerType1Index($_POST['cms_model']) .
	$controller->createControllerEnd();

file_put_contents( $_SERVER['DOCUMENT_ROOT'].'/app/controller/' . $_POST['cms_model'] . '.php', $content);
$controller->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/app/controller/' . $_POST['cms_model'] . '.php');

unset($controller);
unset($content);

echo 'Page Kontroler zapisany.';