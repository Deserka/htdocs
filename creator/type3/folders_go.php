<?php

echo '<h2>Folders Parent:</h2>';

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

// CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1

echo '<h2>Folders Child 1:</h2>';

$folders = new cms_folders_createFolders();

$folders->deleteFolders($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/'.$_POST['cms_folder_child1']);
echo 'Stare foldery (' . $_POST['cms_folder_child1'] . ') usunięte.<br />';
// Gallery
if (isset($_POST['gallery_child1'])) {
	if (isset($_POST['gal_thumb_height_child1']) && empty($_POST['gal_thumb_height_child1'])) {
		$galleryThumbsCounter = count($_POST['gal_thumb_height_child1']);
	} else {
		$galleryThumbsCounter = NULL;
	}
	$folders->createGalleryFolders($_POST['cms_folder_child1'], $galleryThumbsCounter);
	echo 'Foldery dla galerii utworzone.<br />';
}
// Images
if (isset($_POST['image_maxkb_child1']) && !empty($_POST['image_maxkb_child1'])) {
	$countImages = $folders->imagesAndThumbsCounter($_POST['image_name_child1'], 'image', '_thumbwidth_child1');
	$folders->createImagesFolders($_POST['cms_folder_child1'], $countImages);
	echo 'Foldery dla obrazów utworzone.<br />';
}
// Editor
if (isset($_POST['own_type_child1'])) {
	$amount = $folders->textColumnCounter($_POST['own_type_child1']);
	if ($amount !== NULL) {
		$folders->createEditorFolders($_POST['cms_folder_child1'], $amount);
		echo 'Foldery dla edytora/edytorów utworzone.<br />';
	}
	
}
unset($folders, $galleryThumbsCounter, $countImages, $amount);