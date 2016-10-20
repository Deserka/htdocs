<?php

echo '<h2>Router Parent:</h2>';
$router = new cms_router_createRouter();

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

unset($router, $contentGallery, $content, $urlRouterGalleryBasic, $urlRouterGalleryInsert, $urlRouterGalleryEdit, $urlRouterGalleryUpdate, $urlRouterGalleryDelete, $urlRouterGalleryQueue, $urlRouterBasic, 
	  $urlRouterList, $urlRouterAdd, $urlRouterInsert, $urlRouterEdit, $urlRouterDelete, $urlRouterDelete, $urlRouterQueue);
	  
// CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1

echo '<h2>Router Parent:</h2>';
$router = new cms_router_createRouter();

$router->deleteCommentedByModuleName($_POST['view_name_child1'], $_SERVER['DOCUMENT_ROOT'].'/cms.php');
if (isset($_POST['gallery_child1'])) {
		// Router - Gallery Urls
		$urlRouterGalleryBasic = $urlObject->setUrlGallery(array($_POST['cms_url'], '([0-9]+)', $_POST['cms_url_child1'],  '([0-9]+)'));
		$urlRouterGalleryInsert = $urlObject->setUrlGallery(array($_POST['cms_url'], '([0-9]+)', $_POST['cms_url_child1'],  '([0-9]+)'), 'insert');
		$urlRouterGalleryEdit = $urlObject->setUrlGallery(array($_POST['cms_url'], '([0-9]+)', $_POST['cms_url_child1'],  '([0-9]+)'), 'edit');
		$urlRouterGalleryUpdate = $urlObject->setUrlGallery(array($_POST['cms_url'], '([0-9]+)', $_POST['cms_url_child1'],  '([0-9]+)'), 'update');
		$urlRouterGalleryDelete = $urlObject->setUrlGallery(array($_POST['cms_url'], '([0-9]+)', $_POST['cms_url_child1'],  '([0-9]+)'), 'delete', '([0-9]+)');
		$urlRouterGalleryQueue = $urlObject->setUrlGallery(array($_POST['cms_url'], '([0-9]+)', $_POST['cms_url_child1'],  '([0-9]+)'), 'queue');
		
		$contentGallery =
		$router->createPregMatchRouterGalleryElement($urlRouterGalleryBasic, $_POST['cms_model_child1'], NULL, array('$parent_id' ,'$id')) .
		$router->createPregMatchRouterGalleryElement($urlRouterGalleryInsert, $_POST['cms_model_child1'], 'Insert', array('$parent_id' ,'$id')) .
		$router->createPregMatchRouterGalleryElement($urlRouterGalleryEdit, $_POST['cms_model_child1'], 'Edit', array('$parent_id' ,'$id')) .
		$router->createPregMatchRouterGalleryElement($urlRouterGalleryUpdate, $_POST['cms_model_child1'], 'Update', array('$parent_id' ,'$id')) .
		$router->createPregMatchRouterGalleryElement($urlRouterGalleryDelete, $_POST['cms_model_child1'], 'Delete', array('$parent_id' ,'$id', '$imageId')) .
		$router->createPregMatchRouterGalleryElement($urlRouterGalleryQueue, $_POST['cms_model_child1'], 'Queue', array('$parent_id' ,'$id'));
} else {
	$contentGallery = '';
}
// Router Urls
$urlRouterBasic = $urlObject->setUrl(array($_POST['cms_url'], '([0-9]+)', $_POST['cms_url_child1']));
$urlRouterList = $urlObject->setUrl(array($_POST['cms_url'], '([0-9]+)', $_POST['cms_url_child1'], 'list'));
$urlRouterAdd = $urlObject->setUrl(array($_POST['cms_url'], '([0-9]+)', $_POST['cms_url_child1'], 'add'));
$urlRouterInsert = $urlObject->setUrl(array($_POST['cms_url'], '([0-9]+)', $_POST['cms_url_child1'], 'insert'));
$urlRouterEdit = $urlObject->setUrl(array($_POST['cms_url'], '([0-9]+)', $_POST['cms_url_child1'], '([0-9]+)', 'edit'));
$urlRouterDelete = $urlObject->setUrl(array($_POST['cms_url'], '([0-9]+)', $_POST['cms_url_child1'], '([0-9]+)', 'delete'));
$urlRouterQueue = $urlObject->setUrl(array($_POST['cms_url'], '([0-9]+)', $_POST['cms_url_child1'], 'queue'));

$content =
	$router->startComment($_POST['view_name_child1']) .
	$router->createPregMatch1RouterElement($urlRouterBasic, $_POST['cms_model_child1'], 'List', array('$parent_id')) . 
	$router->createPregMatch1RouterElement($urlRouterList, $_POST['cms_model_child1'], 'List', array('$parent_id')) .
	$router->createPregMatch1RouterElement($urlRouterAdd, $_POST['cms_model_child1'], 'Add', array('$parent_id')) .
	$router->createPregMatch1RouterElement($urlRouterInsert, $_POST['cms_model_child1'], 'Insert', array('$parent_id')) .
	$router->createPregMatch1RouterElement($urlRouterEdit, $_POST['cms_model_child1'], 'Edit', array('$parent_id', '$id')) .
	$router->createPregMatch1RouterElement($urlRouterDelete, $_POST['cms_model_child1'], 'Delete', array('$parent_id', '$id')) .
	$router->createPregMatch1RouterElement($urlRouterQueue, $_POST['cms_model_child1'], 'Queue', array('$parent_id')) .
	$contentGallery .
	$router->endComment($_POST['view_name_child1']);
$router->saveInExistedFile($content, $_SERVER['DOCUMENT_ROOT'].'/cms.php');
$router->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/cms.php');

unset($router, $contentGallery, $content, $urlRouterGalleryBasic, $urlRouterGalleryInsert, $urlRouterGalleryEdit, $urlRouterGalleryUpdate, $urlRouterGalleryDelete, $urlRouterGalleryQueue, $urlRouterBasic, 
	  $urlRouterList, $urlRouterAdd, $urlRouterInsert, $urlRouterEdit, $urlRouterDelete, $urlRouterDelete, $urlRouterQueue);