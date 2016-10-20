<?php

echo '<h2>Page Router:</h2>';

$router = new page_router_createRouter();

$router->deleteCommentedByModuleName($_POST['view_name'], $_SERVER['DOCUMENT_ROOT'].'/index.php');
$content =
	$router->startComment($_POST['view_name']) .
	$router->createRouterElementType2List($_POST['page_router_urls'], $_POST['page_router_urls_list'], $_POST['cms_model']) .
	$router->createRouterElementType2One($_POST['page_router_urls'], $_POST['page_router_urls_one'], $_POST['cms_model']) .
	$router->endComment($_POST['view_name']);
$router->saveInExistedFile($content, $_SERVER['DOCUMENT_ROOT'].'/index.php');
$router->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/index.php');

unset($url);
unset($router);
unset($content);
unset($contentGallery);
unset($baseUrl);

echo 'Page Router zapisany.';