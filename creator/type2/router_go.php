<?php

echo '<h2>Router:</h2>';

$router = new cms_router_createRouter();

// gallery waits for u... ;) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

$router->deleteCommentedByModuleName($_POST['view_name'], $_SERVER['DOCUMENT_ROOT'].'/cms.php');
if (isset($_POST['gallery'])) {
		// Router - Gallery Urls
		$urlRouterGalleryBasic = $urlObject->setUrlGallery(array($_POST['cms_url'], '([0-9]+)'));
		$urlRouterGalleryInsert = $urlObject->setUrlGallery(array($_POST['cms_url'], '([0-9]+)'), 'insert');
		$urlRouterGalleryEdit = $urlObject->setUrlGallery(array($_POST['cms_url'], '([0-9]+)'), 'edit');
		$urlRouterGalleryUpdate = $urlObject->setUrlGallery(array($_POST['cms_url'], '([0-9]+)'), 'update');
		$urlRouterGalleryDelete = $urlObject->setUrlGallery(array($_POST['cms_url'], '([0-9]+)'), 'delete', '([0-9]+)');
		$urlRouterGalleryQueue = $urlObject->setUrlGallery(array($_POST['cms_url'], '([0-9]+)'), 'queue');
		
		$contentGallery =
		$router->createPregMatchRouterGalleryElement($urlRouterGalleryBasic, $_POST['cms_model'], NULL, array('$id')) .
		$router->createPregMatchRouterGalleryElement($urlRouterGalleryInsert, $_POST['cms_model'], 'Insert', array('$id')) .
		$router->createPregMatchRouterGalleryElement($urlRouterGalleryEdit, $_POST['cms_model'], 'Edit') .
		$router->createPregMatchRouterGalleryElement($urlRouterGalleryUpdate, $_POST['cms_model'], 'Update', array('$id')) .
		$router->createPregMatchRouterGalleryElement($urlRouterGalleryDelete, $_POST['cms_model'], 'Delete', array('$id', '$imageId')) .
		$router->createPregMatchRouterGalleryElement($urlRouterGalleryQueue, $_POST['cms_model'], 'Queue');
} else {
	$contentGallery = '';
}
// Router Urls
$urlRouterBasic = $urlObject->setUrl(array($_POST['cms_url']));
$urlRouterList = $urlObject->setUrl(array($_POST['cms_url'], 'list'));
$urlRouterAdd = $urlObject->setUrl(array($_POST['cms_url'], 'add'));
$urlRouterInsert = $urlObject->setUrl(array($_POST['cms_url'], 'insert'));
$urlRouterEdit = $urlObject->setUrl(array($_POST['cms_url'], '([0-9]+)', 'edit'));
$urlRouterDelete = $urlObject->setUrl(array($_POST['cms_url'], '([0-9]+)', 'delete'));
$urlRouterQueue = $urlObject->setUrl(array($_POST['cms_url'], 'queue'));

$content =
	$router->startComment($_POST['view_name']) .
	$router->createRouterElement($urlRouterBasic, $_POST['cms_model'], 'List') . // for redirection /sth to sth/list
	$router->createRouterElement($urlRouterList, $_POST['cms_model'], 'List') .
	$router->createRouterElement($urlRouterAdd, $_POST['cms_model'], 'Add') .
	$router->createRouterElement($urlRouterInsert, $_POST['cms_model'], 'Insert') .
	$router->createPregMatch1RouterElement($urlRouterEdit, $_POST['cms_model'], 'Edit', array('$id')) .
	$router->createPregMatch1RouterElement($urlRouterDelete, $_POST['cms_model'], 'Delete', array('$id')) .
	$router->createRouterElement($urlRouterQueue, $_POST['cms_model'], 'Queue') .
	$contentGallery .
	$router->endComment($_POST['view_name']);
$router->saveInExistedFile($content, $_SERVER['DOCUMENT_ROOT'].'/cms.php');
$router->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/cms.php');

unset($router, $contentGallery, $content);