<?php

echo '<h2>_List Parent:</h2>';

$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/_List/_List.phtml');
$_List = new cms_List_createBasicList();

// Gallery
if (isset($_POST['gallery'])) {
	$urlListGalleryBasic = $urlObject->setUrlGallery(array($_POST['cms_url'], '<?= $element[\'id\'] ?>'));
	$content = $_List->createGallery($content, $urlListGalleryBasic);
}

// Urls
$urlListBasic = $urlObject->setUrl(array($_POST['cms_url'], 'list'));
$urlListAdd = $urlObject->setUrl(array($_POST['cms_url'], 'add'));
$urlListEdit = $urlObject->setUrl(array($_POST['cms_url'], '<?= $element[\'id\'] ?>', 'edit'));
$urlListDelete = $urlObject->setUrl(array($_POST['cms_url'], '<?= $element[\'id\'] ?>', 'delete'));
$urlListQueue = $urlObject->setUrl(array($_POST['cms_url'], 'queue'));

// Type 3 Parent
$urlListRollup = $urlObject->setUrl(array($_POST['cms_url'], '<?= $element[\'id\'] ?>', $_POST['cms_url_child1'], 'list'));
$content = str_replace('<!--* _TYPE3_PARENT_PART1 *-->', file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/_List/type3/parent/part1.phtml'), $content);
$content = str_replace('<!--* _TYPE3_PARENT_PART3 *-->', file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/_List/type3/parent/part3.phtml'), $content);
$content = str_replace('<!--* _URL_ROLLUP_ *-->', $urlListRollup[0], $content);
$content = str_replace('<!--* _CREATED_FUNDAMENTAL_NAME_ *-->', $_POST['fundamental_name'], $content);




$content = str_replace('<!--* _URL_BASIC_ *-->', $urlListBasic[0], $content);
$content = str_replace('<!--* _URL_LIST_ADD_ *-->', $urlListAdd[0], $content);
$content = str_replace('<!--* _URL_EDIT_ *-->', $urlListEdit[0], $content);
$content = str_replace('<!--* _URL_DELETE_ *-->', $urlListDelete[0], $content);
$content = str_replace('<!--* _URL_QUEUE_ *-->', $urlListQueue[0], $content);
$content = str_replace('<!--* _CREATED_MODULE_NAME_ *-->', $_POST['view_name'], $content);
$content = str_replace('<!--* _CREATED_MODULE_ADD_ *-->', $_POST['view_add'], $content);

file_put_contents($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model'] . 'List.phtml', $content);
$_List->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model'] . 'List.phtml');
$_List->deleteCommentsHTML($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model'] . 'List.phtml');
$_List->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model'] . 'List.phtml');

unset($content, $_List, $urlListGalleryBasic, $urlListBasic, $urlListAdd, $urlListEdit, $urlListDelete, $urlListQueue);

echo '_List Parent zapisany.';

// CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1 CHILD 1

echo '<h2>_List Child 1:</h2>';

$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/_List/_List.phtml');
$_List = new cms_List_createBasicList();

// Gallery
if (isset($_POST['gallery_child1'])) {
	$urlListGalleryBasic = $urlObject->setUrlGallery(array($_POST['cms_url'], '<?= $content[\'parent_id\'] ?>', $_POST['cms_url_child1'], '<?= $element[\'id\'] ?>'));
	$content = $_List->createGallery($content, $urlListGalleryBasic);
}

// Urls
$urlListParent = $urlObject->setUrl(array($_POST['cms_url'], 'list'));
$urlListBasic = $urlObject->setUrl(array($_POST['cms_url'], '<?= $content[\'parent_id\'] ?>', $_POST['cms_url_child1'], 'list'));
$urlListAdd = $urlObject->setUrl(array($_POST['cms_url'], '<?= $content[\'parent_id\'] ?>', $_POST['cms_url_child1'], 'add'));
$urlListAddParent = $urlObject->setUrl(array($_POST['cms_url'], 'add'));
$urlListEdit = $urlObject->setUrl(array($_POST['cms_url'], '<?= $content[\'parent_id\'] ?>', $_POST['cms_url_child1'], '<?= $element[\'id\'] ?>', 'edit'));
$urlListDelete = $urlObject->setUrl(array($_POST['cms_url'], '<?= $content[\'parent_id\'] ?>', $_POST['cms_url_child1'], '<?= $element[\'id\'] ?>', 'delete'));
$urlListQueue = $urlObject->setUrl(array($_POST['cms_url'], '<?= $content[\'parent_id\'] ?>', $_POST['cms_url_child1'], 'queue'));

// Type 3 Child 1
$content = str_replace('<!--* _TYPE3_CHILD1_PART1 *-->', file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/_List/type3/child1/part1.phtml'), $content);
$content = str_replace('<!--* _CREATED_FUNDAMENTAL_NAME_ *-->', $_POST['fundamental_name'], $content);
$content = str_replace('<!--* _CREATED_PARENT_NAME_ *-->', $_POST['view_name'], $content);

$content = str_replace('_parent_list_', $urlListParent[0], $content);

$content = str_replace('<!--* _URL_BASIC_ *-->', $urlListBasic[0], $content);
$content = str_replace('<!--* _URL_LIST_ADD_ *-->', $urlListAdd[0], $content);
$content = str_replace('<!--* _URL_EDIT_ *-->', $urlListEdit[0], $content);
$content = str_replace('<!--* _URL_DELETE_ *-->', $urlListDelete[0], $content);
$content = str_replace('<!--* _URL_QUEUE_ *-->', $urlListQueue[0], $content);
$content = str_replace('<!--* _CREATED_MODULE_NAME_ *-->', $_POST['view_name_child1'], $content);
$content = str_replace('<!--* _CREATED_MODULE_ADD_ *-->', $_POST['view_add_child1'], $content);


file_put_contents($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model_child1'] . 'List.phtml', $content);
$_List->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model_child1'] . 'List.phtml');
$_List->deleteCommentsHTML($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model_child1'] . 'List.phtml');
$_List->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/' . $_POST['cms_model_child1'] . 'List.phtml');

unset($content, $_List, $urlListGalleryBasic, $urlListBasic, $urlListAdd, $urlListEdit, $urlListDelete, $urlListQueue);

echo '_List Child 1 zapisany.';