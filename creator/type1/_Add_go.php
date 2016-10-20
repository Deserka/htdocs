<?php

echo '<h2>_Add:</h2>';

$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/_Add/_Add.phtml');
$_Add = new cms_Add_createBasicAdd();

$content = str_replace('<!--* _TYPE1_PART1 *-->', file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/_Add/type1/part1.phtml'), $content);

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

// It's type1!
$content = str_replace('<!--* _TYPE1_PART1 *-->', file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/_Add/type1/part1.phtml'), $content);
$content = str_replace('<!--* _TYPE1_PART2 *-->', file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/_Add/type1/part2.phtml'), $content);

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
$content = str_replace('<!--* _CREATED_MODULE_NAME_ *-->', $_POST['view_name'], $content);
$content = str_replace('<!--* _CREATED_MODULE_EDITION_ *-->', $_POST['view_edition'], $content);

file_put_contents($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model'] . 'Add.phtml', $content);
$_Add->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model'] . 'Add.phtml');
$_Add->deleteCommentsHTML($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model'] . 'Add.phtml');
$_Add->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model'] . 'Add.phtml');

echo '_Add zapisany.';