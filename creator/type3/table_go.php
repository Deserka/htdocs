<?php

require_once($_SERVER['DOCUMENT_ROOT']."/creator/lib/lead/lead.php");

echo '<h2>Tabela Parent:</h2>';
$table = new cms_table_createTable();
$con = $table->temporaryConnection();
$table->deleteTables($con, $_POST['cms_table']);
// Basics
$content[] = $table->startBasicsTable($_POST['cms_table'], $_POST['cms_prefix']);
// Own columns
if (isset($_POST['own_mysql_name'][0]) && !empty($_POST['own_mysql_name'][0])) {
	$content[] = $table->createOwnColumnsElements($_POST['cms_prefix'], $_POST['own_mysql_name'], $_POST['own_type'], $_POST['own_length']);
}
// Images
if (isset($_POST['image_name'][0]) && !empty($_POST['image_name'][0])) {
	$countImages = $table->imagesAndThumbsCounter($_POST['image_name'], 'image', '_thumbwidth');
	$content[] = $table->createImagesAndThumbsElements($countImages, $_POST['cms_prefix']);
}
// Meta tags
if (isset($_POST['meta_tags'])) {
	$content[] = $table->createMetaTagsElements($_POST['cms_prefix']);
}
// Gallery part
if (isset($_POST['gallery'])) {
	$content[] = $table->createGalleryElements($_POST['cms_prefix']);
}
// End of basic table
$content[] = $table->endBasicsTable($_POST['cms_prefix']);
// Tags
// Gallery table
if (isset($_POST['gallery'])) {
	if (isset($_POST['gal_thumb_height']) && empty($_POST['gal_thumb_height'])) {
		$galleryThumbsCounter = count($_POST['gal_thumb_height']);
	} else {
		$galleryThumbsCounter = NULL;
	}
	$content[] = $table->createGalleryTable($_POST['cms_table'], $_POST['cms_prefix'], $galleryThumbsCounter);
}
$content = implode("\n", $content);
$table->insertTables($con, $content);

unset($table, $con, $content, $countImages, $galleryThumbsCounter);

// CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1

echo '<h2>Tabela Child1:</h2>';
$table = new cms_table_createTable();
$con = $table->temporaryConnection();
$table->deleteTables($con, $_POST['cms_table_child1']);
// Basics
$content[] = $table->startBasicsTable($_POST['cms_table_child1'], $_POST['cms_prefix_child1']);
// Type 3
$content[] = $table->createType3Elements($_POST['cms_prefix_child1']);
// Own columns
if (isset($_POST['own_mysql_name_child1'][0]) && !empty($_POST['own_mysql_name_child1'][0])) {
	$content[] = $table->createOwnColumnsElements($_POST['cms_prefix_child1'], $_POST['own_mysql_name_child1'], $_POST['own_type_child1'], $_POST['own_length_child1']);
}
// Images
if (isset($_POST['image_name_child1'][0]) && !empty($_POST['image_name_child1'][0])) {
	$countImages = $table->imagesAndThumbsCounter($_POST['image_name_child1'], 'image', '_thumbwidth_child1');
	$content[] = $table->createImagesAndThumbsElements($countImages, $_POST['cms_prefix_child1']);
}
// Meta tags
if (isset($_POST['meta_tags_child1'])) {
	$content[] = $table->createMetaTagsElements($_POST['cms_prefix_child1']);
}
// Gallery part
if (isset($_POST['gallery_child1'])) {
	$content[] = $table->createGalleryElements($_POST['cms_prefix_child1']);
}
// End of basic table
$content[] = $table->endBasicsTable($_POST['cms_prefix_child1']);
// Tags
// Gallery table
if (isset($_POST['gallery_child1'])) {
	if (isset($_POST['gal_thumb_height_child1']) && empty($_POST['gal_thumb_height_child1'])) {
		$galleryThumbsCounter = count($_POST['gal_thumb_height_child1']);
	} else {
		$galleryThumbsCounter = NULL;
	}
	$content[] = $table->createGalleryTable($_POST['cms_table_child1'], $_POST['cms_prefix_child1'], $galleryThumbsCounter);
}
$content = implode("\n", $content);
$table->insertTables($con, $content);
unset($table, $con, $content, $countImages, $galleryThumbsCounter);