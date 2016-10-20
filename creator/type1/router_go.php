<?php

echo '<h2>Router:</h2>';

$router = new cms_router_createRouter();

$router->deleteCommentedByModuleName($_POST['view_name'], $_SERVER['DOCUMENT_ROOT'].'/cms.php');
if (isset($_POST['gallery'])) {
		$contentGallery =
		$router->createRouterGalleryElement($urlGalleryBasic, $_POST['cms_model'], NULL) .
		$router->createRouterGalleryElement($urlGalleryInsert, $_POST['cms_model'], 'Insert') .
		$router->createRouterGalleryElement($urlGalleryEdit, $_POST['cms_model'], 'Edit') .
		$router->createRouterGalleryElement($urlGalleryUpdate, $_POST['cms_model'], 'Update') .
		$router->createPregMatchRouterGalleryElement($urlGalleryDelete, $_POST['cms_model'], 'Delete', array('$imageId')) .
		$router->createRouterGalleryElement($urlGalleryQueue, $_POST['cms_model'], 'Queue');
} else {
	$contentGallery = '';
}
$content =
	$router->startComment($_POST['view_name']) .
	$router->createRouterElement($urlAddBasic, $_POST['cms_model'], 'Edit') . // for redirection /sth to sth/edit
	$router->createRouterElement($urlAddEdit, $_POST['cms_model'], 'Edit') .
	$router->createRouterElement($urlAddInsert, $_POST['cms_model'], 'Insert') .
	$contentGallery .
	$router->endComment($_POST['view_name']);
$router->saveInExistedFile($content, $_SERVER['DOCUMENT_ROOT'].'/cms.php');
$router->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/cms.php');

unset($url);
unset($router);
unset($content);
unset($contentGallery);
unset($baseUrl);
