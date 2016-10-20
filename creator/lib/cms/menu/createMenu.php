<?php

class cms_menu_createMenu extends Creator {

   /**
    * @var array
    */
	private $whatever;

	public function __construct() {
		$this->fourSpaces = '    ';
		$this->eightSpaces = $this->fourSpaces . $this->fourSpaces;
	}

	 public function createSingleMenu($name, $url, $icon, $serverStrpos) {
	 	copy($_SERVER['DOCUMENT_ROOT'].'/creator/icons/'.$icon.'.png', $_SERVER['DOCUMENT_ROOT'].'/public/images/cms/menu/'.$icon.'.png');
		return $content =
'<!-- ' . $name . ' -->' .
"\n" . '<div class=\'menu_button1\' style=\'background: url("/public/images/cms/menu/' . $icon . '.png"); background-repeat: no-repeat; background-position: 13px center; <?= ( strpos($_SERVER[\'REQUEST_URI\'], "' . $serverStrpos . '") !== false ) ? "background-color: rgb(191, 36, 35) !important;":""  ?>\' >' .
"\n" . $this->fourSpaces . '<a href=\'' . $url[0] . '\'>' .
"\n" . $this->eightSpaces . $name .
"\n" . $this->fourSpaces . '</a>' .
"\n" . '</div>' .
"\n" . '<!-- End ' . $name . ' -->' .
"\n" . '<!-- Adder -->';
		
	 }

}