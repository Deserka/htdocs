<?php

class page_controller_createController extends Creator {

   /**
    * @var array
    */
	private $whatever;

	public function __construct() {
		$this->fourSpaces = '    ';
		$this->eightSpaces = $this->fourSpaces . $this->fourSpaces;
	}
	
	public function createControllerStart($controllerName) {
		return $content = 
		'<?php' . "\n" . 'class ' . $controllerName . 'Controller extends Controller {';
	}
	
	public function createControllerEnd() {
		return $content =
		"\n" . '}';
	}
	
	public function createControllerConstruct($controllerName) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/controller/construct.php');
		$content = str_replace('<?php', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $controllerName, $content);
		return $content;
	}
	
	public function createControllerType1Index($controllerName) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/controller/type1/index.php');
		$content = str_replace('<?php', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $controllerName, $content);
		return $content;
	}
	
	public function createControllerType2List($controllerName) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/controller/type2/list.php');
		$content = str_replace('<?php', '', $content);
		$content = str_replace('MODEL_NAME', $controllerName, $content);
		return $content;
	}
	
	public function createControllerType2One($controllerName) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/controller/type2/one.php');
		$content = str_replace('<?php', '', $content);
		$content = str_replace('MODEL_NAME', $controllerName, $content);
		return $content;
	}
	
	
	
	
	
	
	

	public function createControllerInsert($controllerName, $urlAddEdit, array $ids=NULL) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/controller/insert.php');
		$content = str_replace('<?php', '', $content);
		if ($ids !== NULL) {
			$content = str_replace('/**_IDS_**/', implode(', ', $ids), $content);
		}
		$content = str_replace('_CREATED_MODEL_NAME_', $controllerName, $content);
		$content = str_replace('_URL_BASIC_', $urlAddEdit[0], $content);
		$content = str_replace('_URL_BASIC2_', $urlAddEdit[0], $content);
		return $content;
	}
	public function createControllerEdit($controllerName, array $ids=NULL) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/controller/edit.php');
		$content = str_replace('<?php', '', $content);
		if ($ids !== NULL) {
			$content = str_replace('/**_IDS_**/', implode(', ', $ids), $content);
		}
		$content = str_replace('_CREATED_MODEL_NAME_', $controllerName, $content);
		return $content;
	}
	public function createControllerQueue($controllerName, array $ids=NULL) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/controller/queue.php');
		$content = str_replace('<?php', '', $content);
		if ($ids !== NULL) {
			$content = str_replace('/**_IDS_**/', implode(', ', $ids), $content);
		}
		$content = str_replace('_CREATED_MODEL_NAME_', $controllerName, $content);
		return $content;
	}
	public function createControllerList($controllerName, array $ids=NULL) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/controller/list.php');
		$content = str_replace('<?php', '', $content);
		if ($ids !== NULL) {
			$content = str_replace('/**_IDS_**/', implode(', ', $ids), $content);
		}
		$content = str_replace('_CREATED_MODEL_NAME_', $controllerName, $content);
		return $content;
	}
	public function createControllerAdd($controllerName, array $ids=NULL) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/controller/add.php');
		$content = str_replace('<?php', '', $content);
		if ($ids !== NULL) {
			$content = str_replace('/**_IDS_**/', implode(', ', $ids), $content);
		}
		$content = str_replace('_CREATED_MODEL_NAME_', $controllerName, $content);
		return $content;
	}
	public function createControllerDelete($controllerName, $urlAddBasic, array $ids=NULL) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/controller/delete.php');
		if ($ids !== NULL) {
			$content = str_replace('/**_IDS_**/', implode(', ', $ids), $content);
		}
		$content = str_replace('<?php', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $controllerName, $content);
		$content = str_replace('_URL_AD_BASIC_', $urlAddBasic[0], $content);
		return $content;
	}

}