<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/creator/lib/cms/config/createConfig.php');

class cms_Gallery_createGalleryView extends Creator {

	 public function __construct() {

	 }
	 
	public function createGalleryViewType1($viewName, $type=NULL) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/_Gallery/_Gallery.phtml');
		
		$urlObject = new cms_url_createUrls();
		$urlListBasic = $urlObject->setUrl(array($_POST['cms_url'], 'list'));
		$urlAddEdit = $urlObject->setUrl(array($_POST['cms_url'], '<?= $content[\'galleryParent_id\']?>'));
		$urlGalleryInsert = $urlObject->setUrlGallery(array($_POST['cms_url'], '<?= $content[\'galleryParent_id\']?>'), 'insert');
		$urlGalleryUpdate = $urlObject->setUrlGallery(array($_POST['cms_url'], '<?= $content[\'galleryParent_id\']?>'), 'update');
		$urlGalleryDelete = $urlObject->setUrlGallery(array($_POST['cms_url'], '<?= $content[\'galleryParent_id\']?>'), 'delete', '<?= $images["id"] ?>');
		$urlGalleryEdit = $urlObject->setUrlGallery(array($_POST['cms_url'], '<?= $content[\'galleryParent_id\']?>'), 'edit');
		echo $urlGalleryInsert[0];
		
		if ($type === 'type2') {
			$content = str_replace('<!--* _TYPE2_PART1 *-->', file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/_Gallery/type2/part1.phtml'), $content);
		}
		$content = str_replace('_URL_ADD_EDIT_', $urlAddEdit[0], $content);
		$content = str_replace('_URL_GALLERY_INSERT_', $urlGalleryInsert[0], $content);
		$content = str_replace('_URL_GALLERY_UPDATE_', $urlGalleryUpdate[0], $content);
		$content = str_replace('_URL_GALLERY_DELETE_', $urlGalleryDelete[0], $content);
		$content = str_replace('_URL_GALLERY_EDIT_', $urlGalleryEdit[0], $content);
		$content = str_replace('<!--* _CREATED_MODULE_NAME_ *-->', $viewName, $content);
		return $content;
	}
	
}