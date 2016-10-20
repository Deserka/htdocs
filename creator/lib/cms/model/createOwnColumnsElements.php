<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/creator/lib/cms/config/createConfig.php');

class cms_model_createOwnColumnsElements extends Creator {

    /**
     * @var array
     */
	private $imagesMaxKb;


	 public function __construct() {

	 }
	 
	 public function replacePart1($file, $changer, $columnName) {
		for ($i = 0; $i < count($columnName); $i++) {
			$content[] = '"' . $columnName[$i] . '"=> $result[0]["_CREATED_TABLE_PREFIX__' . $columnName[$i] . '"],' . "\n";
		}
		$content = implode('', $content);
		$file = str_replace($changer, $content, $file);
		return $file;
	 }
	 
	 public function replacePart2($file, $changer, $columnName) {
		for ($i = 0; $i < count($columnName); $i++) {
			$content[] = ',_CREATED_TABLE_PREFIX__' . $columnName[$i] . '"],' . "\n";
		}
		$content = implode('', $content);
		$file = str_replace($changer, $content, $file);
		return $file;
	 }
	 
	 public function replacePart3($file, $changer, $columnName) {
		for ($i = 0; $i < count($columnName); $i++) {
			$content[] = ',:_CREATED_TABLE_PREFIX__' . $columnName[$i] . '"],' . "\n";
		}
		$content = implode('', $content);
		$file = str_replace($changer, $content, $file);
		return $file;
	 }

	 public function replacePart4($file, $changer, $columnName) {
		for ($i = 0; $i < count($columnName); $i++) {
			$content[] = '$ins->bindValue(":_CREATED_TABLE_PREFIX__' . $columnName[$i] . '", $inputs["' . $columnName[$i] . '"], PDO::PARAM_STR);' . "\n";
		}
		$content = implode('', $content);
		$file = str_replace($changer, $content, $file);
		return $file;
	 }
	 
	 public function replacePart5($file, $changer, $columnName) {
		for ($i = 0; $i < count($columnName); $i++) {
			$content[] = ', _CREATED_TABLE_PREFIX__' . $columnName[$i] . ' = :_CREATED_TABLE_PREFIX__' . $columnName[$i] . "\n";
		}
		$content = implode('', $content);
		$file = str_replace($changer, $content, $file);
		return $file;
	 }
	 
}