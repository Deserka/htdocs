<?php

echo '<h2>Menu:</h2>';

$urlMenuBasic = $urlObject->setUrl(array($_POST['cms_url'], 'list'));
$menu = new cms_menu_createMenu();
$menu->deleteCommentedByModuleNameHTML($_POST['fundamental_name'], $_SERVER['DOCUMENT_ROOT'].'/app/view/cms/parts/left_menu.phtml');
$content = $menu->createSingleMenu($_POST['fundamental_name'], $urlMenuBasic, $_POST['menu_icon'], 'cms/' . $_POST['fundamental_url']);

$menu->saveInExistedFileHTML($content, $_SERVER['DOCUMENT_ROOT'].'/app/view/cms/parts/left_menu.phtml');

$menu->deleteEnters($_SERVER['DOCUMENT_ROOT'].'/app/view/cms/parts/left_menu.phtml');