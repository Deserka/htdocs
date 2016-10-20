<?php

echo '<h2>_List:</h2>';

$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/_List/_List.phtml');
$_List = new cms_List_createBasicList();

// Gallery
if (isset($_POST['gallery'])) {
	$urlListGalleryBasic = $urlObject->setUrlGallery(array($_POST['cms_url'], '<?= $element[\'id\'] ?>'));
	$content = $_List->createGallery($content, $urlListGalleryBasic);
}

//Type 2
$content = str_replace('<!--* _TYPE2_PART1 *-->', file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/_List/type2/part1.phtml'), $content);

// Urls
$urlListBasic = $urlObject->setUrl(array($_POST['cms_url'], 'list'));
$urlListAdd = $urlObject->setUrl(array($_POST['cms_url'], 'add'));
$urlListEdit = $urlObject->setUrl(array($_POST['cms_url'], '<?= $element[\'id\'] ?>', 'edit'));
$urlListDelete = $urlObject->setUrl(array($_POST['cms_url'], '<?= $element[\'id\'] ?>', 'delete'));
$urlListQueue = $urlObject->setUrl(array($_POST['cms_url'], 'queue'));

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

echo '_List zapisany.';