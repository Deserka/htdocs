<?php

class cms_controller_createControllerGallery extends Creator {

   /**
    * @var array
    */
	private $whatever;

	public function __construct() {
		$this->fourSpaces = '    ';
		$this->eightSpaces = $this->fourSpaces . $this->fourSpaces;
	}
	public function createControllerGalleryBasic($controllerName, array $ids=NULL) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/controller/gallery/basic.php');
		$content = str_replace('<?php', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $controllerName, $content);
		if ($ids !== NULL) {
			$content = str_replace('/**_IDS_**/', implode(', ', $ids), $content);
		}
		return $content;
	}
	public function createControllerGalleryInsert($controllerName, $urlGalleryBasic, array $ids=NULL) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/controller/gallery/insert.php');
		if ($ids !== NULL) {
			$content = str_replace('/**_IDS_**/', implode(', ', $ids), $content);
		}
		$content = str_replace('<?php', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $controllerName, $content);
		$content = str_replace('_CREATED_GALLERY_URL_', $urlGalleryBasic[0], $content);
		return $content;
	}
	public function createControllerGalleryDelete($controllerName, $urlGalleryBasic, array $ids=NULL) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/controller/gallery/delete.php');
		if ($ids !== NULL) {
			$content = str_replace('/**_IDS_**/', implode(', ', $ids), $content);
		}
		$content = str_replace('<?php', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $controllerName, $content);
		$content = str_replace('_CREATED_GALLERY_URL_', $urlGalleryBasic[0], $content);
		return $content;
	}
	public function createControllerGalleryEdit($controllerName) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/controller/gallery/edit.php');
		$content = str_replace('<?php', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $controllerName, $content);
		return $content;
	}
	public function createControllerGalleryUpdate($controllerName, $urlGalleryBasic, array $ids=NULL) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/controller/gallery/update.php');
		if ($ids !== NULL) {
			$content = str_replace('/**_IDS_**/', implode(', ', $ids), $content);
		}
		$content = str_replace('<?php', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $controllerName, $content);
		$content = str_replace('_CREATED_GALLERY_URL_', $urlGalleryBasic[0], $content);
		return $content;
	}
	public function createControllerGalleryQueue($controllerName) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/controller/gallery/queue.php');
		$content = str_replace('<?php', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $controllerName, $content);
		return $content;
	}
	
	
}