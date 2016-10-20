<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/creator/lib/cms/config/createConfig.php');

class cms_config_createImageModule extends Creator {

    /**
     * @var array
     */
	private $imagesMaxKb;

    /**
     * @var array
     */
	private $imagesRequiredWidth;

    /**
     * @var array
     */
	private $imagesRequiredHeight;

    /**
     * @var array
     */
	private $imagesWidth;

    /**
     * @var array
     */
	private $imagesHeight;

    /**
     * @var int
     */
	private $numberOfImages;	
	
	/**
     * @var string
     */
     private $prefix;

	 public function __construct(array $images) {
		$this->numberOfImages = count($images);
	 }

	 public function setThumbsConfiguration($part1, $part2, $part3) {
	 	$thumbs = [];
		for ($i=0; $i<$this->numberOfImages; $i++) {
			$j = $i+1;
			$tempPostWidth = $part1 . $j . $part2;
			$tempPostHeight = $part1 . $j . $part3;
			if (isset($_POST[$tempPostWidth]) && !empty($_POST[$tempPostWidth])) {
				for ($p=0; $p<count($_POST[$tempPostWidth]); $p++) {
					$temp_array[] = ['thumbWidth' => $_POST[$tempPostWidth][$p], 'thumbHeight' => $_POST[$tempPostHeight][$p]];
				}
				array_push($thumbs, $temp_array);
				unset($temp_array);
			} else {
				$temp_array = [];
				array_push($thumbs, $temp_array);
				unset($temp_array);
			}
		}
		return $thumbs;
	 }

	public function getImagesConfiguration(array $imagesMaxKb, array $imagesMaxWidth, array $imagesMaxHeight, array $imagesRequiredWidth, array $imagesRequiredHeight, $prefix, array $thumbs) {

		for ($i=0; $i<$this->numberOfImages; $i++) {
			$j = $i+1;
			$maxKb = $imagesMaxKb[$i];
			$config[] = "'" . $prefix . "_image" .$j. "_max_size' => " . $maxKb . ", // kb";
			$config[] = "'" . $prefix . "_image" .$j. "_max_width' => " . $imagesMaxWidth[$i] . ",";
			$config[] = "'" . $prefix . "_image" . $j . "_max_height' => " . $imagesMaxHeight[$i] . ",";
			$config[] = "'" . $prefix . "_image" .$j. "_required_width' => " . $imagesRequiredWidth[$i] . ",";
			$config[] = "'" . $prefix . "_image" . $j . "_required_height' => " . $imagesRequiredHeight[$i] . ",";
			if (!empty($thumbs[$i])) {
				$k=1;
				foreach ($thumbs[$i] as $thumb) {
					// _CREATED_CONFIG_NAME__image_NUMBER_OF_IMAGE__thumb1_width
					$config[]= "'" . $prefix . "_image" .$j. "_thumb" . $k . "_width' => " . $thumb['thumbWidth'] . ",";
					$config[]= "'" . $prefix . "_image" .$j. "_thumb" . $k . "_height' => " . $thumb['thumbHeight'] . ",";
					$k++;
				}
			}
		}
		$config = implode("\n", $config);
		return $config;
	}

}