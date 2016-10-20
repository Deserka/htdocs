<?php

echo '<h2>Page Model:</h2>';

$pageModel = new page_model_createModel();

// Meta tags
if (isset($_POST['meta_tags'])) {
	$metaTags[] = 1;
} else {
	$metaTags = NULL;
}
// Own columns
if (isset($_POST['own_mysql_name'][0]) && !empty($_POST['own_mysql_name'][0])) {
	$ownColumns[] = $_POST['own_mysql_name'];
} else {
	$ownColumns = NULL;
}
// Images
if (isset($_POST['image_name'][0]) && !empty($_POST['image_name'][0])) {
	//$images = new cms_model_createImagesElements();
	$imagesAndThumbsCounter = $pageModel->imagesAndThumbsCounter($_POST['image_name'], 'image', '_thumbwidth');
} else {
	$imagesAndThumbsCounter = NULL;
}
// Gallery
if (isset($_POST['gallery'])) {
	$gallery = 'ok';
	$modelGallery = new cms_model_createModelGallery();
	// Thumbs
	if (isset($_POST['gal_thumb_height'])) {
		$gallery = count($_POST['gal_thumb_height']);
	}
} else {
	$gallery = NULL;
}

$content = 
	$pageModel->createModelStart($_POST['cms_model']) .
	$pageModel->createModelType2List($_POST['cms_model'], $_POST['cms_table'], $_POST['cms_prefix'], $_POST['cms_config'], $ownColumns, $metaTags, $imagesAndThumbsCounter, $gallery) .
	$pageModel->createModelType2One($_POST['cms_model'], $_POST['cms_table'], $_POST['cms_prefix'], $ownColumns, $metaTags, $imagesAndThumbsCounter, $gallery) .
	$pageModel->createModelEnd($_POST['cms_model']);

$content = preg_replace('#/\*\*(.*?)\*\*/#s', '', $content);

file_put_contents( $_SERVER['DOCUMENT_ROOT'].'/app/model/' . $_POST['cms_model'] . '.php', $content);
$model->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/app/model/' . $_POST['cms_model'] . '.php');

echo 'Page Model zapisany.';
