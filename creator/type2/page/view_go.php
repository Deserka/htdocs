<?php

echo '<h2>Page View:</h2>';

$pageModel = new page_view_createView();

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
	// Thumbs
	if (isset($_POST['gal_thumb_height'])) {
		$gallery = count($_POST['gal_thumb_height']);
	}
} else {
	$gallery = NULL;
}
// View

// One
$content = $pageModel->createViewType2One($_POST['cms_model'], $_POST['cms_table'], $_POST['cms_table'], $ownColumns, $metaTags, $imagesAndThumbsCounter, $gallery);
//$content = preg_replace('#/\*\*(.*?)\*\*/#s', '', $content);
file_put_contents( $_SERVER['DOCUMENT_ROOT'].'/app/view/templates/' . $_POST['cms_model'] . 'One.phtml', $content);
$pageModel->deleteCommentsHTML($_SERVER['DOCUMENT_ROOT'].'/app/view/templates/' . $_POST['cms_model'] . 'One.phtml');
$pageModel->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/app/view/templates/' . $_POST['cms_model'] . 'One.phtml');
unset($content);

unset($pageModel);

echo 'Page View zapisany.';
