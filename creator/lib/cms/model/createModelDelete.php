<?php

class cms_model_createModelDelete extends Creator {

   /**
    * @var array
    */
	private $whatever;

	public function __construct() {
		$this->fourSpaces = '    ';
		$this->eightSpaces = $this->fourSpaces . $this->fourSpaces;
	}

	public function createModelDelete($modelName, $tableName, $tablePrefix, $imagesAndThumbsCounter, $gallery, $type=NULL, $ids=NULL) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/model/delete/delete.php');
		if ($ids !== NULL) {
			$content = str_replace('/**_IDS_**/', implode(', ', $ids), $content);
		}
		if ($imagesAndThumbsCounter !== NULL) {
			for ($i=0; $i<$imagesAndThumbsCounter[0]; $i++) {
				$j = $i+1;
				$image = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/model/delete/images/part1.php');
				$image = str_replace('<?php ', '', $image);
				if ($imagesAndThumbsCounter[1][$i] != 0) {
					for($x=1; $x<=$imagesAndThumbsCounter[1][$i]; $x++) {
						$thumb_part1[] = ',_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__thumb' . $x . ' as image_NUMBER_OF_IMAGE__thumb' . $x . '';
						$thumb_part2[] = 'if (!empty($result[0]["image_NUMBER_OF_IMAGE__thumb' . $x . '"])) {' . "\n".
											'unlink($_SERVER["DOCUMENT_ROOT"].$result[0]["image_NUMBER_OF_IMAGE__thumb' . $x . '"]);' . "\n".
											'}';
					}
					$thumb_part1_All = implode('', $thumb_part1);
					$thumb_part2_All = implode('', $thumb_part2);
				} else {
					$thumb_part1_All = '';
					$thumb_part2_All = '';
				}
				$image = str_replace('/**thumbs_part1**/', $thumb_part1_All, $image);
				$image = str_replace('/**thumbs_part2**/', $thumb_part2_All, $image);
				$image = str_replace('_NUMBER_OF_IMAGE_', $j, $image);
				$content = str_replace('/**images_part1**/', $image, $content);
				unset($image);
				unset($thumb);
				unset($thumb_part1_All);
				unset($thumb_part2_All);
				unset($content_temp);
			}
		}
		
		$content = str_replace('<?php class a{', '', $content);
		$content = str_replace('}/*delete*/', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $modelName, $content);
		$content = str_replace('_CREATED_TABLE_NAME_', $tableName, $content);
		$content = str_replace('_CREATED_TABLE_PREFIX_', $tablePrefix, $content);
		return $content;
	}	
	
	
	
	
	
	
	
	/*
	
	
	
	public function createControllerConstruct($controllerName) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/controller/construct.php');
		$content = str_replace('<?php', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $controllerName, $content);
		return $content;
	}
	public function createControllerInsert($controllerName, $controllerUrl) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/controller/insert.php');
		$content = str_replace('<?php', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $controllerName, $content);
		$content = str_replace('_CREATED_URL_', $controllerUrl[0], $content);
		return $content;
	}
	public function createControllerEdit($controllerName) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/controller/edit.php');
		$content = str_replace('<?php', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $controllerName, $content);
		return $content;
	}
	public function createControllerQueue($controllerName) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/controller/queue.php');
		$content = str_replace('<?php', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $controllerName, $content);
		return $content;
	}
*/
}