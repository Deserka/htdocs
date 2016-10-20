<?php

echo '<h2>_Add:</h2>';

$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/_Add/_Add.phtml');
$_Add = new cms_Add_createBasicAdd();

// Own columns
if (isset($_POST['own_mysql_name'][0]) && !empty($_POST['own_mysql_name'][0])) {
	$content = $_Add->createOwnColumnsElements($content, $_POST['own_mysql_name'], $_POST['own_type'], $_POST['own_cms_name']);
}

// Images
if (isset($_POST['image_name'][0]) && !empty($_POST['image_name'][0])) {
	$imagesCounter = count($_POST['image_name']);
	$content = $_Add->createImagesElements($content, $_POST['image_name']);
}

// Meta tags
if (isset($_POST['meta_tags'])) {
	$content = $_Add->createMetaTags($content);
}

// Gallery
if (isset($_POST['gallery'])) {
	$content = $_Add->createGallery($content, $urlGalleryBasic);
}

// It's type2!
$content = str_replace('<!--* _TYPE2_PART1 *-->', file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/_Add/type2/part1.phtml'), $content);
$content = str_replace('<!--* _TYPE2_PART3 *-->', file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/_Add/type2/part3.phtml'), $content);

$urlAddInsert = $urlObject->setUrl(array($_POST['cms_url'], 'insert'));
$urlAddBasic = $urlObject->setUrl(array($_POST['cms_url'], 'list'));
// Tags
// ----------------------------------------------------------------------- waiting
/*
 * if ($tags1 === 1) {
	include($_SERVER['DOCUMENT_ROOT'].'/creator/shared/_Add/tags1_go.php');
	
} else {
	$_Add = str_replace('_TAGS1_', '', $_Add);
}
 */


 
$content = str_replace('<!--* _URL_ADD_INSERT_ *-->', $urlAddInsert[0], $content);
$content = str_replace('<!--* _URL_ADD_BASIC_ *-->', $urlAddBasic[0], $content);


$content = str_replace('<!--* _CREATED_MODULE_NAME_ *-->', $_POST['view_name'], $content);
$content = str_replace('<!--* _CREATED_MODULE_NEW_ *-->', $_POST['view_new'], $content);
$content = str_replace('<!--* _CREATED_MODULE_ADD_ *-->', $_POST['view_add'], $content);
$content = str_replace('<!--* _CREATED_MODULE_EDITION_ *-->', $_POST['view_edition'], $content);

file_put_contents($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model'] . 'Add.phtml', $content);
$_Add->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model'] . 'Add.phtml');
$_Add->deleteCommentsHTML($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model'] . 'Add.phtml');
$_Add->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model'] . 'Add.phtml');

echo '_Add zapisany.';