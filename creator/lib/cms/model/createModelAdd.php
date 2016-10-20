<?php

class cms_model_createModelAdd extends Creator {

   /**
    * @var array
    */
	private $whatever;

	public function __construct() {
		$this->fourSpaces = '    ';
		$this->eightSpaces = $this->fourSpaces . $this->fourSpaces;
	}

	public function createModelAdd($modelName, $type=NULL, $ids=NULL, $parentTableName=NULL, $parentTablePrefix=NULL) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/model/add/add.php');
		$content = str_replace('<?php class a{', '', $content);
		if ($ids !== NULL) {
			$content = str_replace('/**_IDS_**/', implode(', ', $ids), $content);
		}
		if ($type==='type3') {
			$part1 = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/model/add/type3/part1.php');
			$part1 = str_replace('<?php', '', $part1);
			$part1 = str_replace('_PARENT_TABLE_NAME_', $parentTableName, $part1);
			$part1 = str_replace('_PARENT_TABLE_PREFIX_', $parentTablePrefix, $part1);
			$part2 = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/model/add/type3/part2.php');
			$part2 = str_replace('<?php', '', $part2);
			$content = str_replace('/**type3_part1**/', $part1, $content);
			$content = str_replace('/**type3_part2**/', $part2, $content);
		}
		$content = str_replace('}/*delete*/', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $modelName, $content);
		return $content;
	}
}