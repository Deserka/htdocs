<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/creator/lib/cms/config/createConfig.php');

class cms_Add_createBasicAdd extends Creator {

	 public function __construct() {

	 }
	 
	public function createOwnColumnsElements($addHTML, $columnName, $columnType, $inputName) {
		for ($x=0; $x<count($columnName); $x++) {
			if ($columnType[$x] !== 'text') {
				$tempContent = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/_Add/ownColumns/ownColumnsText.phtml');
				$tempContent = str_replace('_INPUT_NAME_', $inputName[$x], $tempContent);
				$tempContent = str_replace('_COLUMN_NAME_', $columnName[$x], $tempContent);
				$content[] = $tempContent;
				unset($tempContent);
			} elseif ($columnType[$x] === 'text') {
				$tempContent = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/_Add/ownColumns/ownColumnsTextarea.phtml');
				$tempContent = str_replace('_INPUT_NAME_', $inputName[$x], $tempContent);
				$tempContent = str_replace('_COLUMN_NAME_', $columnName[$x], $tempContent);
				$content[] = $tempContent;
				unset($tempContent);
			}
		}
		$content = implode('', $content);
		$return = str_replace('<!--* _CREATED_OWN_COLUMNS_ *-->', $content, $addHTML);
		return $return;
	}

	public function createImagesElements($content, $imageName) {
		for ($x=0; $x<count($imageName); $x++) {
			$y = $x +1;
				$tempContent = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/_Add/images/image.phtml');
				$tempContent = str_replace('_CREATED_NAME_', $imageName[$x], $tempContent);
				$tempContent = str_replace('_NUMBER_OF_IMAGE_', $y, $tempContent);
				$contentAll[] = $tempContent;
				unset($tempContent);
		}
		$contentImplode = implode('', $contentAll);
		$return = str_replace('<!--* _IMAGES_ *-->', $contentImplode, $content);
		return $return;
	}

	public function createMetaTags($content) {
		$tempContent = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/_Add/metaTags/metaTags.phtml');
		$return = str_replace('<!--* _META_TAGS_ *-->', $tempContent, $content);
		return $return;
	}

	public function createGallery($content, $urlGallery) {
		$part1 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/_Add/gallery/part1.phtml');
		$part1 = str_replace('_CREATED_GALLERY_URL_', $urlGallery[0], $part1);
		$part2 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/_Add/gallery/part2.phtml');
		$content = str_replace('<!--* _GALLERY_PART1_ *-->', $part1, $content);
		$content = str_replace('<!--* _GALLERY_PART2_ *-->', $part2, $content);
		return $content;
	}


}