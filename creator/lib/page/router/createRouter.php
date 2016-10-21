<?php

class page_router_createRouter extends Creator {

   /**
    * @var array
    */
	private $whatever;

	public function __construct() {
		$this->fourSpaces = '    ';
		$this->eightSpaces = $this->fourSpaces . $this->fourSpaces;
		$this->twelveSpaces = $this->fourSpaces . $this->fourSpaces . $this->fourSpaces;
	}
	
	public function createRouterElementType1(array $listOfUrls, $moduleName) {
		for ($i=0; $i<count($listOfUrls); $i++) {
			if ($i === 0) {
				$or = '';
			} else {
				$or = ' || ';
			}
			$urls[] = $or . '$_SERVER["REQUEST_URI"] === "' . $listOfUrls[$i] . '"' ;
		}
		$urls = implode($urls);
		return $listRouter =
		'elseif (' . $urls . ') {' .
		"\n" . $this->fourSpaces . '$ob = new ' . $moduleName . 'Controller;' .
		"\n" . $this->fourSpaces . '$ob->' . $moduleName . '();' .
		"\n" . $this->fourSpaces . 'exit;' .
		"\n" . '} ';
	}
	
	public function createRouterElementType2List(array $listOfUrls, array $listOfUrlsList, $modelName) {
		
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/router/type2/listDivided.php');
		
		for ($i=0; $i<count($listOfUrls); $i++) {
			if ($i === 0) {
				$or = '';
				$if = $this->fourSpaces . 'if ';
			} else {
				$or = ' || ';
				$if = ' elseif ';
			}
			$urlsAll[] = $or . '$_SERVER["REQUEST_URI"] === "' . $listOfUrls[$i] . '" || preg_match("/^' . str_replace('/', '\/', $listOfUrls[$i]) . str_replace('/', '\/', $listOfUrlsList[$i]) . '$/", $_SERVER["REQUEST_URI"])' ;
			$urlsFirstPage[] = $or . '$_SERVER["REQUEST_URI"] === "' . $listOfUrls[$i] . '"';
			$urlsAnotherPages[] = $if . '(preg_match("/^' . str_replace('/', '\/', $listOfUrls[$i]) . str_replace('/', '\/', $listOfUrlsList[$i]) . '$/", $_SERVER["REQUEST_URI"])) {' . "\n" . 
									$this->twelveSpaces . '$o = preg_match("/^' . str_replace('/', '\/', $listOfUrls[$i]) . str_replace('/', '\/', $listOfUrlsList[$i]) . '$/", $_SERVER["REQUEST_URI"], $neededVariables);' . "\n" .
									$this->eightSpaces . '}';
		}
		$urlsAll = implode('', $urlsAll);
		$urlsFirstPage = implode('', $urlsFirstPage);
		$urlsAnotherPages = implode('', $urlsAnotherPages);
		
		$content = str_replace('<?php', '', $content);
		$content = str_replace('MODEL_NAME', $modelName, $content);
		$content = str_replace('URLS_ALL', $urlsAll, $content);
		$content = str_replace('URLS_FIRST_PAGE', $urlsFirstPage, $content);
		$content = str_replace('URLS_ANOTHER_PAGES;', $urlsAnotherPages, $content);
		$content = str_replace('*page_number*', '([\d]+)', $content);
		
		return $content;
	}
	
	public function createRouterElementType2One(array $listOfUrls, array $listOfUrlsOne, $modelName) {
		
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/router/type2/one.php');
		
		if (strpos($listOfUrlsOne[0], '*id*') !== false && strpos($listOfUrlsOne[0], '*url*') !== false) {
			if (strpos($listOfUrlsOne[0], '*id*') < strpos($listOfUrlsOne[0], '*url*')) {
				$variables = $this->fourSpaces . '$id = $neededVariables[1];' . "\n" . $this->fourSpaces . '$url = $neededVariables[2];';
				$variables2 = '$id, $url';
			} else {
				$variables = $this->fourSpaces . '$url = $neededVariables[1];' . "\n" . $this->fourSpaces . '$id = $neededVariables[2];';
				$variables2 = '$url, $id';
			}
		    
		} elseif (strpos($listOfUrlsOne[0], '*id*') !== false) {
			$variables = $this->fourSpaces . '$id = $neededVariables[1];';
			$variables2 = '$id, NULL';
		} elseif (strpos($listOfUrlsOne[0], '*url*') !== false) {
			$variables = $this->fourSpaces . '$url = $neededVariables[1];';
			$variables2 = 'NULL, $url';
		}
		
		for ($i=0; $i<count($listOfUrls); $i++) {
			if ($i === 0) {
				$or = '';
				$if = $this->fourSpaces . 'if ';
			} else {
				$or = ' || ';
				$if = ' elseif ';
			}
			
			$urlsAll[] = $or . 'preg_match("/^' . str_replace('/', '\/', $listOfUrls[$i]) . str_replace('/', '\/', $listOfUrlsOne[$i]) . '$/", $_SERVER["REQUEST_URI"])' ;
			$urlsOne[] = $if . '(preg_match("/^' . str_replace('/', '\/', $listOfUrls[$i]) . str_replace('/', '\/', $listOfUrlsOne[$i]) . '$/", $_SERVER["REQUEST_URI"])) {' . "\n" . 
									$this->twelveSpaces . '$o = preg_match("/^' . str_replace('/', '\/', $listOfUrls[$i]) . str_replace('/', '\/', $listOfUrlsOne[$i]) . '$/", $_SERVER["REQUEST_URI"], $neededVariables);' . "\n" .
									$this->eightSpaces . '}' . "\n";
		}
		$urlsAll = implode('', $urlsAll);
		$urlsOne = implode('', $urlsOne);
		
		$content = str_replace('<?php', '', $content);
		$content = str_replace('MODEL_NAME', $modelName, $content);
		$content = str_replace('URLS_ALL', $urlsAll, $content);
		$content = str_replace('URLS_ONE;', $urlsOne, $content);
		$content = str_replace('VARIABLES1;', $variables, $content);
		$content = str_replace('VARIABLES2', $variables2, $content);
		$content = str_replace('*id*', '([\d]+)', $content);
		$content = str_replace('*url*', '([a-zA-Z0-9-_]+)', $content);
		
		return $content;
	}
	
	
	
	
	
	
	
	
	
	
// --------------------
	
	
	
	
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