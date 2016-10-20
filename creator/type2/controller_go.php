<?php

echo '<h2>Controller:</h2>';

$controller = new cms_controller_createController();
$url = new cms_url_createUrls();

if (isset($_POST['gallery'])) {
		// Controller - Gallery Urls
		$urlControllerGalleryInsert = $urlObject->setUrlGallery(array($_POST['cms_url'], '".$id."'));
		$urlControllerGalleryDelete = $urlObject->setUrlGallery(array($_POST['cms_url'], '".$id."'));
		$urlControllerGalleryUpdate = $urlObject->setUrlGallery(array($_POST['cms_url'], '".$id."'));

		$controllerGallery = new cms_controller_createControllerGallery();
		$contentGallery =
		$controllerGallery->createControllerGalleryBasic($_POST['cms_model'], array('$id')) .
		$controllerGallery->createControllerGalleryInsert($_POST['cms_model'], $urlControllerGalleryInsert, array('$id')) .
		$controllerGallery->createControllerGalleryDelete($_POST['cms_model'], $urlControllerGalleryDelete, array('$id', '$imageId')) .
		$controllerGallery->createControllerGalleryEdit($_POST['cms_model']) .
		$controllerGallery->createControllerGalleryUpdate($_POST['cms_model'], $urlControllerGalleryUpdate, array('$id')) .
		$controllerGallery->createControllerGalleryQueue($_POST['cms_model']);
} else {
	$contentGallery = '';
}
// Controller Urls
$urlControllerBasic = $urlObject->setUrl(array($_POST['cms_url'], 'list'));
$urlControllerList = $urlObject->setUrl(array($_POST['cms_url'], 'list'));

$content =
	$controller->createControllerStart($_POST['cms_model']) .
	$controller->createControllerConstruct($_POST['cms_model']) .
	$controller->createControllerList($_POST['cms_model']) .
	$controller->createControllerAdd($_POST['cms_model']) .
	$controller->createControllerInsert($_POST['cms_model'], $urlControllerBasic) .
	$controller->createControllerEdit($_POST['cms_model'], array('$id')) .
	$controller->createControllerDelete($_POST['cms_model'], $urlControllerList, array('$id')) .
	$controller->createControllerQueue($_POST['cms_model']) .
	$contentGallery .
	$controller->createControllerEnd();

$content = preg_replace('#/\*\*(.*?)\*\*/#s', '', $content);

file_put_contents( $_SERVER['DOCUMENT_ROOT'].'/app/controller/cms/' . $_POST['cms_model'] . '.php', $content);
$controller->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/app/controller/cms/' . $_POST['cms_model'] . '.php');

unset($controller, $url, $content, $contentGallery);

echo 'Kontroler zapisany.';