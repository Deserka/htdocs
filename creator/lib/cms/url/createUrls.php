<?php

class cms_url_createUrls extends Creator {

    /**
     * @var array
     */
	private $whatever;


	 public function __construct($additionalBase=NULL) {
	 	if ($additionalBase !== NULL) {
	 		$additionalBase = $additionalBase . '/';
	 	}
		$this->base = '/cms/' . $additionalBase;
	 }
		// $elements - list f urls example - contact or  articles, categories
		// $type - have to recognize type1
		// $task - task like insert or edit
		// $id - add element as variable
	 public function setUrl(array $elements) {
		$url = $this->base . implode('/', $elements);
		$preg_match_url = str_replace('/', '\/', $url);
		return array($url, $preg_match_url);
	 }
	 public function setUrlGallery(array $elements, $task=NULL, $id=NULL) {
	 	$url = $this->base . implode('/', $elements);
		// Set task
		if ($task !== NULL) {
			$task = '/' . $task;
		}
		if ($id !== NULL) {
			$id = '/' . $id;
		}
		$url = $url .'/gallery' . $id . $task;
		$preg_match_url = str_replace('/', '\/', $url);
		return array($url, $preg_match_url);
	 }

}