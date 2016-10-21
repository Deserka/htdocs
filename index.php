<?php 
include_once 'app/code.php';
session_start();
require 'config/configuration.php';
// If lang is set URL
if(preg_match('/^\/[a-z]{2}\//', $_SERVER['REQUEST_URI']))
{
        // What lang is in URL?
        $o = preg_match('/^\/([a-z]{2})\//', $_SERVER['REQUEST_URI'], $neededVariables);
        $lang = $neededVariables[1]; 
        if(in_array($lang, $configuration['langs']))
        {
            unset($_SESSION['page_lang']);
            unset($_SESSION['page_url']);            
            $_SESSION['page_lang'] = $lang;
            $_SESSION['page_url'] = $_SESSION['page_lang'].'/';   
        }   
        else 
        {
            $ob = new indexController;
            $ob->er404();    
            exit;            
        }  
}
else 
{
	unset($_SESSION['page_lang']);
    unset($_SESSION['page_url']);
}
if(empty($_SESSION['page_lang']))
{
    // Default lang
        $_SESSION['page_lang'] = $configuration['default_lang'];
        $_SESSION['page_url'] = '';      
}
// Ładowanie języka dla guzików na stronie ------------------------------------------------------------------------------------------
if($_SERVER['REQUEST_URI'] === '/index.php'){
	header('Location: http://'.$_SERVER['SERVER_NAME'].'');
}
//if(empty($_SESSION['editing_lang']) OR  $_SESSION['editing_lang'] == ''){$_SESSION['editing_lang'] = 'pl';}
// Sitemap
if ($_SERVER['REQUEST_URI'] === '/sitemap.xml') {
    $ob = new indexController;
    $ob->sitemap();    
    exit;
}
/* Homepage */
if($_SERVER['REQUEST_URI'] === '/' || preg_match('/^\/[a-z]{2}\/$/', $_SERVER['REQUEST_URI'])) {
    $ob = new homepageController;
    $ob->homepage();
    exit;
}
/* End Homepage */
/* Aktualności */
if ($_SERVER["REQUEST_URI"] === "/news" || preg_match("/^\/news\/aaa-([\d]+)$/", $_SERVER["REQUEST_URI"])) {
	if ($_SERVER["REQUEST_URI"] === "/news") {
	    $ob = new aktualnosciController;
	    $ob->aktualnosciList();
	} else {
    if (preg_match("/^\/news\/aaa-([\d]+)$/", $_SERVER["REQUEST_URI"])) {
            $o = preg_match("/^\/news\/aaa-([\d]+)$/", $_SERVER["REQUEST_URI"], $neededVariables);
        }
		$pageNumber = $neededVariables[1];
	    $ob = new aktualnosciController;
	    $ob->aktualnosciList($pageNumber);
	}
}
if (preg_match("/^\/news\/id-([\d]+)iurl-([a-zA-Z0-9-_]+)$/", $_SERVER["REQUEST_URI"])) {
    if (preg_match("/^\/news\/id-([\d]+)iurl-([a-zA-Z0-9-_]+)$/", $_SERVER["REQUEST_URI"])) {
            $o = preg_match("/^\/news\/id-([\d]+)iurl-([a-zA-Z0-9-_]+)$/", $_SERVER["REQUEST_URI"], $neededVariables);
        }
    $id = $neededVariables[1];
    $url = $neededVariables[2];
	$ob = new aktualnosciController;
	$ob->aktualnosciOne($id, $url);
}
/* End Aktualności */
/* Kontakt */
elseif ($_SERVER["REQUEST_URI"] === "/kontakt") {
    $ob = new contactController;
    $ob->contact();
    exit;
} 
/* End Kontakt */
/* Adder */
    $ob = new indexController;
    $ob->er404();
    exit;
?>