<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/creator/lib/cms/config/createConfig.php');

class cms_List_createBasicList extends Creator {

	 public function __construct() {

	 }

	public function createGallery($content, $urlGallery) {
		$part1 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/_List/gallery/part1.phtml');
		$part1 = str_replace('<!--* _URL_GALLERY_BASIC_ *-->', $urlGallery[0], $part1);
		$content = str_replace('<!--* _GALLERY_PART1_ *-->', $part1, $content);
		return $content;
	}


}