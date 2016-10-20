<?php

echo '<h2>Controller:</h2>';

$controller = new cms_controller_createController();
$url = new cms_url_createUrls();

if (isset($_POST['gallery'])) {
		$baseUrl = $url->setUrl(array($_POST['cms_url']), 'type1');
		$controllerGallery = new cms_controller_createControllerGallery();
		$contentGallery =
		$controllerGallery->createControllerGalleryBasic($_POST['cms_model']) .
		$controllerGallery->createControllerGalleryInsert($_POST['cms_model'], $urlGalleryBasic) .
		$controllerGallery->createControllerGalleryDelete($_POST['cms_model'], $urlGalleryBasic, array('$imageId')) .
		$controllerGallery->createControllerGalleryEdit($_POST['cms_model']) .
		$controllerGallery->createControllerGalleryUpdate($_POST['cms_model'], $urlGalleryBasic) .
		$controllerGallery->createControllerGalleryQueue($_POST['cms_model']);
} else {
	$contentGallery = '';
}

$content =
	$controller->createControllerStart($_POST['cms_model']) .
	$controller->createControllerConstruct($_POST['cms_model']) .
	$controller->createControllerInsert($_POST['cms_model'], $urlAddEdit) .
	$controller->createControllerEdit($_POST['cms_model']) .
	$controller->createControllerQueue($_POST['cms_model']) .
	$contentGallery .
	$controller->createControllerEnd();

file_put_contents( $_SERVER['DOCUMENT_ROOT'].'/app/controller/cms/' . $_POST['cms_model'] . '.php', $content);
$controller->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/app/controller/cms/' . $_POST['cms_model'] . '.php');

unset($controller);
unset($url);
unset($content);

echo 'Kontroler zapisany.';