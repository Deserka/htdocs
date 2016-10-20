<?php

echo '<h2>Tabela:</h2>';

require_once($_SERVER['DOCUMENT_ROOT']."/creator/lib/lead/lead.php");

$table = new cms_table_createTable();

$con = $table->temporaryConnection();

$table->deleteTables($con, $_POST['cms_table']);

// Basics
$content[] = $table->startBasicsTable($_POST['cms_table'], $_POST['cms_table']);

// Own columns
if (isset($_POST['own_mysql_name'][0]) && !empty($_POST['own_mysql_name'][0])) {
	$content[] = $table->createOwnColumnsElements($_POST['cms_table'], $_POST['own_mysql_name'], $_POST['own_type'], $_POST['own_length']);
}

// Images
if (isset($_POST['image_name'][0]) && !empty($_POST['image_name'][0])) {
	$countImages = $table->imagesAndThumbsCounter($_POST['image_name'], 'image', '_thumbwidth');
	$content[] = $table->createImagesAndThumbsElements($countImages, $_POST['cms_prefix']);
}

// Meta tags
if (isset($_POST['meta_tags'])) {
	$content[] = $table->createMetaTagsElements($_POST['cms_table']);
}

// Gallery part
if (isset($_POST['gallery'])) {
	$content[] = $table->createGalleryElements($_POST['cms_table']);
}

// End of basic table
$content[] = $table->endBasicsTable($_POST['cms_table']);

// Tags

// Gallery table
if (isset($_POST['gallery'])) {
	if (isset($_POST['gal_thumb_height']) && empty($_POST['gal_thumb_height'])) {
		$galleryThumbsCounter = count($_POST['gal_thumb_height']);
	} else {
		$galleryThumbsCounter = NULL;
	}
	$content[] = $table->createGalleryTable($_POST['cms_table'], $_POST['cms_table'], $galleryThumbsCounter);
}

$content[] =  $table->insertData($_POST['cms_table'], $_POST['cms_table'], $_POST['view_name']);

$content = implode("\n", $content);

$table->insertTables($con, $content);


