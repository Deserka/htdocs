<?php

class page_config_createConfig extends Creator {

	/**
     * @var string
     */	 
     private $moduleName;

	public function __construct() {

	}
	 
	public function createList($configName, $amount, $dateFormat) {
		$content[] = "'" . $configName . "_list_elements_amount' => " . $amount . ",";
		$content[] = "'" . $configName . "_date_format' => " . $dateFormat . ",";
		$content = implode("\n", $content);
		return $content;
	}

}