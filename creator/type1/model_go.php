<?php

echo '<h2>Model:</h2>';

if (isset($_POST['own_mysql_name'][0]) && !empty($_POST['own_mysql_name'][0])) {
	$ownColumns[] = $_POST['own_mysql_name'];
} else {
	$ownColumns = NULL;
}
// Meta tags
if (isset($_POST['meta_tags'])) {
	$metaTags[] = 1;
} else {
	$metaTags = NULL;
}
// Images
if (isset($_POST['image_name'][0]) && !empty($_POST['image_name'][0])) {
	$images = new cms_model_createImagesElements();
	$imagesAndThumbsCounter = $images->imagesAndThumbsCounter($_POST['image_name'], 'image', '_thumbwidth');
	$imagesNames = $_POST['image_name'];
} else {
	$imagesAndThumbsCounter = NULL;
	$imagesNames = NULL;
}
// Gallery
if (isset($_POST['gallery'])) {
	$gallery = 1;
	$modelGallery = new cms_model_createModelGallery();
	// Thumbs
	if (isset($_POST['gal_thumb_height'])) {
		$thumbsAmount = count($_POST['gal_thumb_height']);
	} else {
		$thumbsAmount = NULL;
	}
	$modelGalleryContent = 
	$modelGallery->createGalleryBasic($_POST['cms_model'], $_POST['cms_table'], $_POST['cms_table']) .
	$modelGallery->createGalleryInsert($_POST['cms_model'], $_POST['cms_table'], $_POST['cms_table'], $_POST['cms_folder'], $_POST['cms_config'], $thumbsAmount, NULL, 'part1') .
	$modelGallery->createGalleryDelete($_POST['cms_model'], $_POST['cms_table'], $_POST['cms_table'], $thumbsAmount, array('$imageId')) .
	$modelGallery->createGalleryEdit($_POST['cms_model'], $_POST['cms_table'], $_POST['cms_table']) .
	$modelGallery->createGalleryUpdate($_POST['cms_model'], $_POST['cms_table'], $_POST['cms_table'], $_POST['cms_folder'], $_POST['cms_config'], $thumbsAmount) .
	$modelGallery->createGalleryQueue($_POST['cms_model'], $_POST['cms_table'], $_POST['cms_table']);
} else {
	$gallery = NULL;
	$modelGalleryContent = '';
}

$model = new cms_model_createModel();
$modelEdit = new cms_model_createModelEdit();
$modelInsert = new cms_model_createModelInsert();

$content = 
	$model->createModelStart($_POST['cms_model']) .
	$modelEdit->createModelEdit($_POST['cms_model'], $_POST['cms_table'], $_POST['cms_table'], $ownColumns, $metaTags, $imagesAndThumbsCounter, $gallery) .
	$modelInsert->createModelInsert($_POST['cms_model'], $_POST['cms_table'], $_POST['cms_table'], $_POST['cms_folder'], $_POST['cms_config'], $ownColumns, $metaTags, $imagesAndThumbsCounter, $imagesNames, $gallery) .
	$modelGalleryContent .
	$model->createModelEnd();

$content = preg_replace('#/\*\*(.*?)\*\*/#s', '', $content);

file_put_contents( $_SERVER['DOCUMENT_ROOT'].'/app/model/cms/' . $_POST['cms_model'] . '.php', $content);
$model->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/app/model/cms/' . $_POST['cms_model'] . '.php');

echo 'Model zapisany.';
