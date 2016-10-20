<?php

class cms_model_createModelQueue extends Creator {

   /**
    * @var array
    */
	private $whatever;

	public function __construct() {
		$this->fourSpaces = '    ';
		$this->eightSpaces = $this->fourSpaces . $this->fourSpaces;
	}

	public function createModelQueue($modelName, $tableName, $tablePrefix, $type=NULL, $ids=NULL) {
		if ($ids !== NULL) {
			$content = str_replace('/**_IDS_**/', implode(', ', $ids), $content);
		}
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/model/queue/queue.php');
		$content = str_replace('<?php', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $modelName, $content);
		$content = str_replace('_CREATED_TABLE_NAME_', $tableName, $content);
		$content = str_replace('_CREATED_TABLE_PREFIX_', $tablePrefix, $content);
		return $content;
	}
}