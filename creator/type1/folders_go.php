<?php

echo '<h2>Folders:</h2>';

$folders = new cms_folders_createFolders();

$folders->deleteFolders($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/'.$_POST['cms_folder']);
echo 'Stare foldery (' . $_POST['cms_folder'] . ') usunięte.<br />';
// Gallery
if (isset($_POST['gallery'])) {
	if (isset($_POST['gal_thumb_height']) && empty($_POST['gal_thumb_height'])) {
		$galleryThumbsCounter = count($_POST['gal_thumb_height']);
	} else {
		$galleryThumbsCounter = NULL;
	}
	$folders->createGalleryFolders($_POST['cms_folder'], $galleryThumbsCounter);
	echo 'Foldery dla galerii utworzone.<br />';
}
// Images
if (isset($_POST['image_maxkb']) && !empty($_POST['image_maxkb'])) {
	$countImages = $folders->imagesAndThumbsCounter($_POST['image_name'], 'image', '_thumbwidth');
	$folders->createImagesFolders($_POST['cms_folder'], $countImages);
	echo 'Foldery dla obrazów utworzone.<br />';
}
// Editor
if (isset($_POST['own_type'])) {
	$amount = $folders->textColumnCounter($_POST['own_type']);
	if ($amount !== NULL) {
		$folders->createEditorFolders($_POST['cms_folder'], $amount);
		echo 'Foldery dla edytora/edytorów utworzone.<br />';
	}
	
}

unset($folders, $galleryThumbsCounter, $countImages, $amount);