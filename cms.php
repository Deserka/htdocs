<?php 
include_once 'app/code.php';
/* */
session_start();
if(empty($_SESSION['editing_lang']) OR  $_SESSION['editing_lang'] == ''){$_SESSION['editing_lang'] = 'pl';} //lang of  www version
if(empty($_SESSION['cms_lang']) OR  $_SESSION['cms_lang'] == ''){$_SESSION['cms_lang'] = 'pl';} //lang of elements in cms
/* */
/* Install */  
if ($_SERVER['REQUEST_URI'] === '/cms-install') {
    $log = new cms_cmsController;
    $log->install();
    exit;    
}
// If not logged
if (empty($_SESSION['login'])) {
	$log = new cms_cmsController;
	$log->login();
	exit;
}
if ($_SERVER['REQUEST_URI'] === '/cms') {
        $ob = new cms_cmsController;
        $ob->index();    
        exit;
} elseif($_SERVER['REQUEST_URI'] === '/cms-logout') {
        $ob = new cms_cmsController;
        $ob->logout();    
        exit;
} elseif($_SERVER['REQUEST_URI'] === '/cms-cms_change-lang') {
        $ob = new cms_cmsController;
        $ob->cms_lang_change();    
        exit;
} elseif($_SERVER['REQUEST_URI'] === '/cms-change-lang') {
        $ob = new cms_cmsController;
        $ob->editing_lang_change();    
        exit;
} 
/* Sitemap */
elseif ($_SERVER['REQUEST_URI'] === '/cms-sitemap') {
    $ob = new cms_cmsController;
    $ob->sitemap();
    exit;
} elseif ($_SERVER['REQUEST_URI'] === '/cms-generate-sitemap') {
    $ob = new cms_cmsController;
    $ob->generateSitemap();
    exit;
}
/* Aktualności */
elseif ($_SERVER["REQUEST_URI"] === "/cms/aktualnosci") {
    $ob = new cms_aktualnosciController;
    $ob->aktualnosciList();
    exit;
} elseif ($_SERVER["REQUEST_URI"] === "/cms/aktualnosci/list") {
    $ob = new cms_aktualnosciController;
    $ob->aktualnosciList();
    exit;
} elseif ($_SERVER["REQUEST_URI"] === "/cms/aktualnosci/add") {
    $ob = new cms_aktualnosciController;
    $ob->aktualnosciAdd();
    exit;
} elseif ($_SERVER["REQUEST_URI"] === "/cms/aktualnosci/insert") {
    $ob = new cms_aktualnosciController;
    $ob->aktualnosciInsert();
    exit;
} elseif (preg_match("/^\/cms\/aktualnosci\/([0-9]+)\/edit$/", $_SERVER["REQUEST_URI"])) {
    $o = preg_match("/^\/cms\/aktualnosci\/([0-9]+)\/edit$/", $_SERVER["REQUEST_URI"], $neededVariables);
    $id = $neededVariables[1];
    $ob = new cms_aktualnosciController;
    $ob->aktualnosciEdit($id);
    exit;
} elseif (preg_match("/^\/cms\/aktualnosci\/([0-9]+)\/delete$/", $_SERVER["REQUEST_URI"])) {
    $o = preg_match("/^\/cms\/aktualnosci\/([0-9]+)\/delete$/", $_SERVER["REQUEST_URI"], $neededVariables);
    $id = $neededVariables[1];
    $ob = new cms_aktualnosciController;
    $ob->aktualnosciDelete($id);
    exit;
} elseif ($_SERVER["REQUEST_URI"] === "/cms/aktualnosci/queue") {
    $ob = new cms_aktualnosciController;
    $ob->aktualnosciQueue();
    exit;
} elseif (preg_match("/^\/cms\/aktualnosci\/([0-9]+)\/gallery$/", $_SERVER["REQUEST_URI"])) {
    $o = preg_match("/^\/cms\/aktualnosci\/([0-9]+)\/gallery$/", $_SERVER["REQUEST_URI"], $neededVariables);
    $id = $neededVariables[1];
    $ob = new cms_aktualnosciController;
    $ob->aktualnosciGallery($id);
    exit;
} elseif (preg_match("/^\/cms\/aktualnosci\/([0-9]+)\/gallery\/insert$/", $_SERVER["REQUEST_URI"])) {
    $o = preg_match("/^\/cms\/aktualnosci\/([0-9]+)\/gallery\/insert$/", $_SERVER["REQUEST_URI"], $neededVariables);
    $id = $neededVariables[1];
    $ob = new cms_aktualnosciController;
    $ob->aktualnosciGalleryInsert($id);
    exit;
} elseif (preg_match("/^\/cms\/aktualnosci\/([0-9]+)\/gallery\/edit$/", $_SERVER["REQUEST_URI"])) {
    $o = preg_match("/^\/cms\/aktualnosci\/([0-9]+)\/gallery\/edit$/", $_SERVER["REQUEST_URI"], $neededVariables);
    $id = $neededVariables[1];
    $ob = new cms_aktualnosciController;
    $ob->aktualnosciGalleryEdit();
    exit;
} elseif (preg_match("/^\/cms\/aktualnosci\/([0-9]+)\/gallery\/update$/", $_SERVER["REQUEST_URI"])) {
    $o = preg_match("/^\/cms\/aktualnosci\/([0-9]+)\/gallery\/update$/", $_SERVER["REQUEST_URI"], $neededVariables);
    $id = $neededVariables[1];
    $ob = new cms_aktualnosciController;
    $ob->aktualnosciGalleryUpdate($id);
    exit;
} elseif (preg_match("/^\/cms\/aktualnosci\/([0-9]+)\/gallery\/([0-9]+)\/delete$/", $_SERVER["REQUEST_URI"])) {
    $o = preg_match("/^\/cms\/aktualnosci\/([0-9]+)\/gallery\/([0-9]+)\/delete$/", $_SERVER["REQUEST_URI"], $neededVariables);
    $id = $neededVariables[1];
    $imageId = $neededVariables[2];
    $ob = new cms_aktualnosciController;
    $ob->aktualnosciGalleryDelete($id, $imageId);
    exit;
} elseif (preg_match("/^\/cms\/aktualnosci\/([0-9]+)\/gallery\/queue$/", $_SERVER["REQUEST_URI"])) {
    $o = preg_match("/^\/cms\/aktualnosci\/([0-9]+)\/gallery\/queue$/", $_SERVER["REQUEST_URI"], $neededVariables);
    $id = $neededVariables[1];
    $ob = new cms_aktualnosciController;
    $ob->aktualnosciGalleryQueue();
    exit;
} 
/* End Aktualności */
/* Kontakt */
elseif ($_SERVER["REQUEST_URI"] === "/cms/kontakt") {
    $ob = new cms_contactController;
    $ob->contactEdit();
    exit;
} elseif ($_SERVER["REQUEST_URI"] === "/cms/kontakt/edit") {
    $ob = new cms_contactController;
    $ob->contactEdit();
    exit;
} elseif ($_SERVER["REQUEST_URI"] === "/cms/kontakt/insert") {
    $ob = new cms_contactController;
    $ob->contactInsert();
    exit;
} elseif($_SERVER["REQUEST_URI"] === "/cms/kontakt/gallery") {
    $ob = new cms_contactController;
    $ob->contactGallery();
    exit;
} elseif($_SERVER["REQUEST_URI"] === "/cms/kontakt/gallery/insert") {
    $ob = new cms_contactController;
    $ob->contactGalleryInsert();
    exit;
} elseif($_SERVER["REQUEST_URI"] === "/cms/kontakt/gallery/edit") {
    $ob = new cms_contactController;
    $ob->contactGalleryEdit();
    exit;
} elseif($_SERVER["REQUEST_URI"] === "/cms/kontakt/gallery/update") {
    $ob = new cms_contactController;
    $ob->contactGalleryUpdate();
    exit;
} elseif (preg_match("/^\/cms\/kontakt\/gallery\/([0-9]+)\/delete$/", $_SERVER["REQUEST_URI"])) {
    $o = preg_match("/^\/cms\/kontakt\/gallery\/([0-9]+)\/delete$/", $_SERVER["REQUEST_URI"], $neededVariables);
    $imageId = $neededVariables[1];
    $ob = new cms_contactController;
    $ob->contactGalleryDelete($imageId);
    exit;
} elseif($_SERVER["REQUEST_URI"] === "/cms/kontakt/gallery/queue") {
    $ob = new cms_contactController;
    $ob->contactGalleryQueue();
    exit;
} 
/* End Kontakt */
/* Adder */
else {
	$ob = new cms_cmsController;
	$ob->er404();    
	exit;
}                