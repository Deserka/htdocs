<?php

echo '<h2>_Gallery Parent:</h2>';

$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/_Gallery/_Gallery.phtml');

$gallery  = new cms_Gallery_createGalleryView();

$urlListBasic = $urlObject->setUrl(array($_POST['cms_url'], 'list'));
$urlAddEdit = $urlObject->setUrl(array($_POST['cms_url'], '<?= $content[\'galleryParent_id\']?>'));
$urlGalleryInsert = $urlObject->setUrlGallery(array($_POST['cms_url'], '<?= $content[\'galleryParent_id\']?>'), 'insert');
$urlGalleryUpdate = $urlObject->setUrlGallery(array($_POST['cms_url'], '<?= $content[\'galleryParent_id\']?>'), 'update');
$urlGalleryDelete = $urlObject->setUrlGallery(array($_POST['cms_url'], '<?= $content[\'galleryParent_id\']?>'), 'delete', '<?= $images["id"] ?>');
$urlGalleryEdit = $urlObject->setUrlGallery(array($_POST['cms_url'], '<?= $content[\'galleryParent_id\']?>'), 'edit');

$content = str_replace('<!--* _TYPE3_PART1 *-->', file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/_Gallery/type3/parent/part1.phtml'), $content);

		$content = str_replace('_URL_ADD_EDIT_', $urlAddEdit[0], $content);
		$content = str_replace('_URL_GALLERY_INSERT_', $urlGalleryInsert[0], $content);
		$content = str_replace('_URL_GALLERY_UPDATE_', $urlGalleryUpdate[0], $content);
		$content = str_replace('_URL_GALLERY_DELETE_', $urlGalleryDelete[0], $content);
		$content = str_replace('_URL_GALLERY_EDIT_', $urlGalleryEdit[0], $content);
		$content = str_replace('<!--* _CREATED_MODULE_NAME_ *-->', $_POST['view_name'], $content);

file_put_contents($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model'] . 'Gallery.phtml', $content);
$gallery->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model'] . 'Gallery.phtml');
$gallery->deleteCommentsHTML($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model'] . 'Gallery.phtml');
$gallery->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model'] . 'Gallery.phtml');

unset($content, $gallery, $urlListBasic, $urlAddEdit, $urlGalleryInsert, $urlGalleryUpdate, $urlGalleryDelete, $urlGalleryEdit);

echo '_Gallery Parent zapisany.';

// CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1

echo '<h2>_Gallery Child 1:</h2>';

$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/_Gallery/_Gallery.phtml');

$gallery  = new cms_Gallery_createGalleryView();

$urlListParent = $urlObject->setUrl(array($_POST['cms_url'], 'list'));

$urlListBasic = $urlObject->setUrl(array($_POST['cms_url'], '<?= $content[\'parent_id\']?>', $_POST['cms_url_child1'],   'list'));
$urlThisEdit = $urlObject->setUrl(array($_POST['cms_url'], '<?= $content[\'parent_id\']?>', $_POST['cms_url_child1'],  '<?= $content[\'galleryParent_id\']?>', 'edit'));
$urlGalleryInsert = $urlObject->setUrlGallery(array($_POST['cms_url'], '<?= $content[\'parent_id\']?>', $_POST['cms_url_child1'],   '<?= $content[\'galleryParent_id\']?>'), 'insert');
$urlGalleryUpdate = $urlObject->setUrlGallery(array($_POST['cms_url'], '<?= $content[\'parent_id\']?>', $_POST['cms_url_child1'],   '<?= $content[\'galleryParent_id\']?>'), 'update');
$urlGalleryDelete = $urlObject->setUrlGallery(array($_POST['cms_url'], '<?= $content[\'parent_id\']?>', $_POST['cms_url_child1'],   '<?= $content[\'galleryParent_id\']?>'), 'delete', '<?= $images["id"] ?>');
$urlGalleryEdit = $urlObject->setUrlGallery(array($_POST['cms_url'], '<?= $content[\'parent_id\']?>', $_POST['cms_url_child1'],   '<?= $content[\'galleryParent_id\']?>'), 'edit');

$content = str_replace('<!--* _TYPE3_PART1 *-->', file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/_Gallery/type3/child1/part1.phtml'), $content);



		$content = str_replace('_url_this_edit_', $urlThisEdit[0], $content);
		$content = str_replace('_URL_ADD_EDIT_', $urlAddEdit[0], $content);
		$content = str_replace('_URL_GALLERY_INSERT_', $urlGalleryInsert[0], $content);
		$content = str_replace('_URL_GALLERY_UPDATE_', $urlGalleryUpdate[0], $content);
		$content = str_replace('_URL_GALLERY_DELETE_', $urlGalleryDelete[0], $content);
		$content = str_replace('_URL_GALLERY_EDIT_', $urlGalleryEdit[0], $content);
		$content = str_replace('_url_parent_list_', $urlListParent[0], $content);
		$content = str_replace('(url child1 list)', $urlListBasic[0], $content);
		$content = str_replace('<!--* _CREATED_THIS_NAME_ *-->', "<?= (!empty(\$content['galleryParent_title'])) ? \$content['galleryParent_title']:'' ?>", $content);
		
		$content = str_replace('<!--* _CREATED_MODULE_NAME_ *-->', $_POST['view_name_child1'], $content);
		$content = str_replace('<!--* _CREATED_FUNDAMENTAL_NAME_ *-->', $_POST['fundamental_name'], $content);
		$content = str_replace('<!--* _CREATED_PARENT_NAME_ *-->', $_POST['view_name'], $content);
		$content = str_replace('<!--* _PARENT_SPEC_NAME_ *-->', "<?= \$content['parent_title']?>", $content);
		
		
		
		
		
		
		
		

file_put_contents($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model_child1'] . 'Gallery.phtml', $content);
$gallery->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model_child1'] . 'Gallery.phtml');
$gallery->deleteCommentsHTML($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model_child1'] . 'Gallery.phtml');
$gallery->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model_child1'] . 'Gallery.phtml');

unset($content, $gallery, $urlListBasic, $urlAddEdit, $urlGalleryInsert, $urlGalleryUpdate, $urlGalleryDelete, $urlGalleryEdit);

echo '_Gallery Child 1 zapisany.';