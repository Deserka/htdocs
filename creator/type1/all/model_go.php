<?php

echo '<h2>Page Model All:</h2>';

$allModel = new all_model_createModelType1();


if (isset($_POST['model_all_type1'])) {
	$allModel->deleteCommentedByModuleName($_POST['view_name'], $_SERVER['DOCUMENT_ROOT'].'/app/model/all.php');
	$content = 
	$allModel->startComment($_POST['view_name']) .
	$allModel->createModelBasic($_POST['cms_model'], $_POST['cms_table'], $_POST['cms_table']) .
	$allModel->endComment($_POST['view_name']);
}
$allModel->saveInExistedFile($content, $_SERVER['DOCUMENT_ROOT'].'/app/model/all.php');
$allModel->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/app/model/all.php');


unset($allModel);

echo 'Page Model zapisany.';