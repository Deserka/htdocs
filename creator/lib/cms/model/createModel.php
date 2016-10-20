<?php

class cms_model_createModel extends Creator {

   /**
    * @var array
    */
	private $whatever;

	public function __construct() {
		$this->fourSpaces = '    ';
		$this->eightSpaces = $this->fourSpaces . $this->fourSpaces;
	}
	
	public function createModelStart($modelName) {
		return $content = 
		'<?php' . "\n" . 'class cms_' . $modelName . 'Model extends Model {';
	}
	
	public function createModelEnd() {
		return $content = 
		"\n" . '}';
	}

	
	
	
	
	
	
	
	/*
	
	
	
	public function createControllerConstruct($controllerName) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/controller/construct.php');
		$content = str_replace('<?php', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $controllerName, $content);
		return $content;
	}
	public function createControllerInsert($controllerName, $controllerUrl) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/controller/insert.php');
		$content = str_replace('<?php', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $controllerName, $content);
		$content = str_replace('_CREATED_URL_', $controllerUrl[0], $content);
		return $content;
	}
	public function createControllerEdit($controllerName) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/controller/edit.php');
		$content = str_replace('<?php', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $controllerName, $content);
		return $content;
	}
	public function createControllerQueue($controllerName) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/controller/queue.php');
		$content = str_replace('<?php', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $controllerName, $content);
		return $content;
	}
*/
}