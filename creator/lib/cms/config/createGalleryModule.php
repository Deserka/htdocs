<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/creator/lib/cms/config/createConfig.php');

class cms_config_createGalleryModule extends Creator {

    /**
     * @var array
     */
	private $imagesMaxKb;


	 public function __construct() {

	 }

	 public function setThumbsConfiguration(array $thumbsWidth, array $thumbsHeight, $prefix) {
	 	
		$count = count($thumbsWidth);
		$thumbs = [];
		for ($i=0; $i<$count; $i++) {
			$j = $i+1;
			$thumbs[] = "'" . $prefix . "_gallery_thumb" . $j . "_width' => " . $thumbsWidth[$i] . ",";
			$thumbs[] = "'" . $prefix . "_gallery_thumb" . $j . "_height' => " . $thumbsHeight[$i] . ",";
		}
		$thumbs = implode("\n", $thumbs);
		return $thumbs;

	 }

	public function getGalleryConfiguration($galleryMaxKb, $galleryMaxWidth, $galleryMaxHeight, $galleryReqWidth, $galleryReqHeight, $prefix, $thumbs=NULL) {

			if (empty($galleryReqWidth) || $galleryReqWidth == 0) {
				$galleryReqWidth = 0;
			}
			if (empty($galleryReqHeight) || $galleryReqHeight == 0) {
				$galleryReqHeight = 0;
			}			

			$config[] = "\n'" . $prefix . "_gallery_max_size' => " . $galleryMaxKb . ", // kb";
			$config[] = "'" . $prefix . "_gallery_max_width' => " . $galleryMaxWidth . ",";
			$config[] = "'" . $prefix . "_gallery_max_height' => " . $galleryMaxHeight . ",";
			$config[] = "'" . $prefix . "_gallery_required_width' => " . $galleryReqWidth . ",";
			$config[] = "'" . $prefix . "_gallery_required_height' => " . $galleryReqHeight . ",";
			
			if ($thumbs !== NULL) {
				$config[] = $thumbs;
			}
		$config = implode("\n", $config);
		return $config;
	}

}