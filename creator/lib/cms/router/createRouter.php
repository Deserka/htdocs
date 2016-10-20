<?php

class cms_router_createRouter extends Creator {

   /**
    * @var array
    */
	private $whatever;

	public function __construct() {
		$this->fourSpaces = '    ';
		$this->eightSpaces = $this->fourSpaces . $this->fourSpaces;
	}
	
	public function createRouterElement(array $url, $moduleName, $task) {
		return $listRouter =
		'elseif ($_SERVER["REQUEST_URI"] === "' . $url[0] . '") {' .
		"\n" . $this->fourSpaces . '$ob = new cms_' . $moduleName . 'Controller;' .
		"\n" . $this->fourSpaces . '$ob->' . $moduleName . $task . '();' .
		"\n" . $this->fourSpaces . 'exit;' .
		"\n" . '} ';
	}
	
	public function createPregMatch1RouterElement(array $url, $moduleName, $task, array $ids= NULL) {
		if ($ids !== NULL) {
			for ($i=0; $i<count($ids); $i++) {
				$j = $i+1;
				$variables[] = "\n" . $this->fourSpaces . $ids[$i] . ' = $neededVariables[' . $j . '];';
			}
			$variables = implode('', $variables);
			$ids = implode(', ', $ids);
		} else {
			$variables = "\n" . $this->fourSpaces . '$id = $neededVariables[1];';
		}
		return $listRouter =
		'elseif (preg_match("/^' . $url[1] . '$/", $_SERVER["REQUEST_URI"])) {' .
		"\n" . $this->fourSpaces . '$o = preg_match("/^' . $url[1] . '$/", $_SERVER["REQUEST_URI"], $neededVariables);' .
		$variables .
		"\n" . $this->fourSpaces . '$ob = new cms_' . $moduleName . 'Controller;' .
		"\n" . $this->fourSpaces . '$ob->' . $moduleName . $task . '(' . $ids .');' .
		"\n" . $this->fourSpaces . 'exit;' .
		"\n" . '} ';
	}
	
	public function createRouterGalleryElement(array $url, $moduleName, $task=NULL, array $ids=NULL) {
		if ($ids !== NULL) {
			$ids = implode(',', $ids);
		} else {
			$ids = '';
		}
		return $listRouter =
		'elseif($_SERVER["REQUEST_URI"] === "' . $url[0] . '") {' .
		"\n" . $this->fourSpaces . '$ob = new cms_' . $moduleName . 'Controller;' .
		"\n" . $this->fourSpaces . '$ob->' . $moduleName . 'Gallery' . $task . '(' . $ids . ');' .
		"\n" . $this->fourSpaces . 'exit;' .
		"\n" . '} ';
	}
	
	public function createPregMatchRouterGalleryElement(array $url, $moduleName, $task=NULL, array $ids= NULL) {
		if ($ids !== NULL) {
			for ($i=0; $i<count($ids); $i++) {
				$j = $i+1;
				$variables[] = "\n" . $this->fourSpaces . $ids[$i] . ' = $neededVariables[' . $j . '];';
			}
			$variables = implode('', $variables);
			$ids = implode(', ', $ids);
		} else {
			$variables = "\n" . $this->fourSpaces . '$id = $neededVariables[1];';
		}
		return $listRouter =
		'elseif (preg_match("/^' . $url[1] . '$/", $_SERVER["REQUEST_URI"])) {' .
		"\n" . $this->fourSpaces . '$o = preg_match("/^' . $url[1] . '$/", $_SERVER["REQUEST_URI"], $neededVariables);' .
		$variables .
		"\n" . $this->fourSpaces . '$ob = new cms_' . $moduleName . 'Controller;' .
		"\n" . $this->fourSpaces . '$ob->' . $moduleName . 'Gallery' . $task . '(' . $ids . ');' .
		"\n" . $this->fourSpaces . 'exit;' .
		"\n" . '} ';
	}
	
	
	
}