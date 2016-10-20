<?php

echo '<h2>Page Controller:</h2>';

$controller = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/type1/page/controller/controller.php');

$controller = str_replace('_PAGE_MODEL_NAME_', $model_name, $controller);

if (isset($_POST['homepage_r'])) {
	$homepage_element = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/type1/page/controller/homepage.php');
} else {
	$homepage_element = '';
}
$controller = str_replace('/*_HOMEPAGE_ALL_MODEL_*/', $homepage_element, $controller);

file_put_contents($_SERVER['DOCUMENT_ROOT'].'/app/controller/'.$model_name.'.php', $controller);

echo 'Page Controller zapisany';