<?php

echo '<h2>Config:</h2>';

require_once($_SERVER['DOCUMENT_ROOT']."/creator/lib/lead/lead.php");

// Check if isset gallery or/and images
if (isset($_POST['image_maxkb']) && !empty($_POST['image_maxkb']) || isset($_POST['gallery'])) {
	$cms_config_start = 1;
} else {
	if (isset($cms_config_start)) {
		unset($cms_config_start);
	}
}

if (isset($cms_config_start)) {
	// Images
	if (isset($_POST['image_maxkb']) && !empty($_POST['image_maxkb'])) {
		$config_image = new cms_config_createImageModule($_POST['image_maxkb']);
		$temp_thumb = $config_image->setThumbsConfiguration('image', '_thumbwidth', '_thumbheight');
		$config_image_go = $config_image->getImagesConfiguration($_POST['image_maxkb'], $_POST['image_maxwidth'], $_POST['image_maxheight'], $_POST['image_reqwidth'], $_POST['image_reqheight'], $_POST['cms_config'], $temp_thumb);
		unset($temp_thumb);
	} else {
		$config_image_go = NULL;
	}
	// Gallery
	if (isset($_POST['gallery'])) {
		$config_gallery = new cms_config_createGalleryModule();
		if (isset($_POST['gal_thumb_width']) && !empty($_POST['gal_thumb_height'])) {
			$temp_thumb = $config_gallery->setThumbsConfiguration($_POST['gal_thumb_width'], $_POST['gal_thumb_height'], $_POST['cms_config']);
		} else {
			$temp_thumb = NULL;
		}
		$config_gallery_go = $config_gallery->getGalleryConfiguration($_POST['gal_maxkb'], $_POST['gal_max_width'], $_POST['gal_max_height'], $_POST['gal_req_width'], $_POST['gal_req_height'], $_POST['cms_config'], $temp_thumb);
		unset($temp_thumb);
	} else {
		$config_gallery_go = NULL;
	}
	
	$config = new cms_config_createBasicsModule();
	$config->deleteCommentedByModuleName($_POST['view_name'], $_SERVER['DOCUMENT_ROOT'].'/config/configuration.php');
	$content = 
		$config->startComment($_POST['view_name']) .
		$config_image_go . $config_gallery_go .
		$config->endComment($_POST['view_name']);
	$config->saveInExistedFile($content, $_SERVER['DOCUMENT_ROOT'].'/config/configuration.php');
	$config->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/config/configuration.php');

	unset($config);
	unset($content);
	
}
