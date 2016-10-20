<?php

echo '<h2>Controller Parent:</h2>';

$controller = new cms_controller_createController();

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

unset($controller, $content, $contentGallery, $urlControllerGalleryInsert, $urlControllerGalleryDelete, $urlControllerGalleryUpdate, $urlControllerBasic, $urlControllerList);

echo 'Kontroler Parent zapisany.';

// CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1

echo '<h2>Controller Child 1:</h2>';

$controller = new cms_controller_createController();

if (isset($_POST['gallery_child1'])) {
		// Controller - Gallery Urls
		$urlControllerGalleryInsert = $urlObject->setUrlGallery(array($_POST['cms_url'], '".$parent_id."', $_POST['cms_url_child1'], '".$id."'));
		$urlControllerGalleryDelete = $urlObject->setUrlGallery(array($_POST['cms_url'], '".$parent_id."', $_POST['cms_url_child1'], '".$id."'));
		$urlControllerGalleryUpdate = $urlObject->setUrlGallery(array($_POST['cms_url'], '".$parent_id."', $_POST['cms_url_child1'], '".$id."'));

		$controllerGallery = new cms_controller_createControllerGallery();
		$contentGallery =
		$controllerGallery->createControllerGalleryBasic($_POST['cms_model_child1'], array('$parent_id', '$id')) .
		$controllerGallery->createControllerGalleryInsert($_POST['cms_model_child1'], $urlControllerGalleryInsert, array('$parent_id', '$id')) .
		$controllerGallery->createControllerGalleryDelete($_POST['cms_model_child1'], $urlControllerGalleryDelete, array('$parent_id', '$id', '$imageId')) .
		$controllerGallery->createControllerGalleryEdit($_POST['cms_model_child1']) .
		$controllerGallery->createControllerGalleryUpdate($_POST['cms_model_child1'], $urlControllerGalleryUpdate, array('$parent_id', '$id')) .
		$controllerGallery->createControllerGalleryQueue($_POST['cms_model_child1']);
} else {
	$contentGallery = '';
}
// Controller Urls
$urlControllerBasic = $urlObject->setUrl(array($_POST['cms_url'], '\'.$parent_id.\'', $_POST['cms_url_child1']));
$urlControllerList = $urlObject->setUrl(array($_POST['cms_url'], '\'.$parent_id.\'', $_POST['cms_url_child1'], 'list'));

$content =
	$controller->createControllerStart($_POST['cms_model_child1']) .
	$controller->createControllerConstruct($_POST['cms_model_child1']) .
	$controller->createControllerList($_POST['cms_model_child1'], array('$parent_id')) .
	$controller->createControllerAdd($_POST['cms_model_child1'], array('$parent_id')) .
	$controller->createControllerInsert($_POST['cms_model_child1'], $urlControllerBasic, array('$parent_id')) .
	$controller->createControllerEdit($_POST['cms_model_child1'], array('$parent_id', '$id')) .
	$controller->createControllerDelete($_POST['cms_model_child1'], $urlControllerList, array('$parent_id', '$id')) .
	$controller->createControllerQueue($_POST['cms_model_child1'], array('$parent_id')) .
	$contentGallery .
	$controller->createControllerEnd();

$content = preg_replace('#/\*\*(.*?)\*\*/#s', '', $content);

file_put_contents( $_SERVER['DOCUMENT_ROOT'].'/app/controller/cms/' . $_POST['cms_model_child1'] . '.php', $content);
$controller->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/app/controller/cms/' . $_POST['cms_model_child1'] . '.php');

unset($controller, $content, $contentGallery, $urlControllerGalleryInsert, $urlControllerGalleryDelete, $urlControllerGalleryUpdate, $urlControllerBasic, $urlControllerList);

echo 'Kontroler Child 1 zapisany.';