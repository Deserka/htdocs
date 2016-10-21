<?php

class all_model_createModelType1 extends Creator {

   /**
    * @var array
    */
	private $whatever;

	public function __construct() {
		$this->fourSpaces = '    ';
		$this->eightSpaces = $this->fourSpaces . $this->fourSpaces;
	}
	
	public function createModelBasic($modelName, $tableName, $tablePrefix) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/all/model/type1/basic.php');
		$content = str_replace(array("<?php\r\n", "<?php\n"), '', $content);
		$content = str_replace('MODEL_NAME', $modelName, $content);
		$content = str_replace('TABLE_NAME', $tableName, $content);
		$content = str_replace('TABLE_PREFIX', $tablePrefix, $content);
		return $content;
	}
	

}