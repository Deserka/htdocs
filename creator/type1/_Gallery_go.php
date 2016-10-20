<?php

echo '<h2>_Gallery:</h2>';

$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/_Gallery/_Gallery.phtml');

$gallery  = new cms_Gallery_createGalleryView();

$urlListBasic = $urlObject->setUrl(array($_POST['cms_url'], 'list'));
$urlAddEdit = $urlObject->setUrl(array($_POST['cms_url'], 'edit'));
$urlGalleryInsert = $urlObject->setUrlGallery(array($_POST['cms_url']), 'insert');
$urlGalleryUpdate = $urlObject->setUrlGallery(array($_POST['cms_url']), 'update');
$urlGalleryDelete = $urlObject->setUrlGallery(array($_POST['cms_url']), 'delete', '<?= $images["id"] ?>');
$urlGalleryEdit = $urlObject->setUrlGallery(array($_POST['cms_url']), 'edit');

$content = str_replace('<!--* _TYPE1_PART1 *-->', file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/_Gallery/type1/part1.phtml'), $content);

		$content = str_replace('_URL_ADD_EDIT_', $urlAddEdit[0], $content);
		$content = str_replace('_URL_GALLERY_INSERT_', $urlGalleryInsert[0], $content);
		$content = str_replace('_URL_GALLERY_UPDATE_', $urlGalleryUpdate[0], $content);
		$content = str_replace('_URL_GALLERY_DELETE_', $urlGalleryDelete[0], $content);
		$content = str_replace('_URL_GALLERY_EDIT_', $urlGalleryEdit[0], $content);
		$content = str_replace('<!--* _CREATED_MODULE_NAME_ *-->', $_POST['view_name'], $content);
		$content = str_replace('<!--* _CREATED_THIS_NAME_ *-->', $_POST['view_name'], $content);

file_put_contents($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model'] . 'Gallery.phtml', $content);
$gallery->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model'] . 'Gallery.phtml');
$gallery->deleteCommentsHTML($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model'] . 'Gallery.phtml');
$gallery->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model'] . 'Gallery.phtml');

unset($content, $gallery, $urlListBasic, $urlAddEdit, $urlGalleryInsert, $urlGalleryUpdate, $urlGalleryDelete, $urlGalleryEdit);

echo '_Gallery zapisany.';