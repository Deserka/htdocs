<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/creator/lib/cms/config/createConfig.php');

class cms_model_createMetaTagsElements extends Creator {

    /**
     * @var array
     */
	private $imagesMaxKb;


	 public function __construct() {

	 }
	 
	 public function replacePart1($file, $changer) {
			$content =
            '/* meta_tags_part1 */'. "\n".
            '"meta_title"    	 => $result[0]["_CREATED_TABLE_PREFIX__meta_title"],'. "\n".
            '"meta_keywords"      => $result[0]["_CREATED_TABLE_PREFIX__meta_keywords"],'. "\n".
            '"meta_description"   => $result[0]["_CREATED_TABLE_PREFIX__meta_description"],'. "\n".
            '"meta_author"        => $result[0]["_CREATED_TABLE_PREFIX__meta_author"],'. "\n".
            '"meta_robots"        => $result[0]["_CREATED_TABLE_PREFIX__meta_robots"],'. "\n".
			'/* End meta_tags_part1 */'. "\n";
			$file = str_replace($changer, $content, $file);
			return $file;
	 }

	 public function replacePart2($file, $changer) {
			$content =
            '/* meta_tags_part2 */'. "\n".
            ',_CREATED_TABLE_PREFIX__meta_title,'. "\n".
            '_CREATED_TABLE_PREFIX__meta_keywords,'. "\n".
            '_CREATED_TABLE_PREFIX__meta_description,'. "\n".
            '_CREATED_TABLE_PREFIX__meta_author,'. "\n".
            '_CREATED_TABLE_PREFIX__meta_robots'. "\n".
			'/* End meta_tags_part2 */'. "\n";
			$file = str_replace($changer, $content, $file);
			return $file;
	 }

	 public function replacePart3($file, $changer) {
			$content =
            '/* meta_tags_part3 */'. "\n".
            ', :_CREATED_TABLE_PREFIX__meta_title,'. "\n".
			':_CREATED_TABLE_PREFIX__meta_keywords,'. "\n".
			':_CREATED_TABLE_PREFIX__meta_description,'. "\n".
			':_CREATED_TABLE_PREFIX__meta_author,'. "\n".
			':_CREATED_TABLE_PREFIX__meta_robots'. "\n".
			'/* End meta_tags_part3 */'. "\n";
			$file = str_replace($changer, $content, $file);
			return $file;
	 }

	 public function replacePart4($file, $changer) {
			$content =
            '/* meta_tags_part4 */'. "\n".
            '$ins->bindValue(":_CREATED_TABLE_PREFIX__meta_title", $inputs["meta_title"], PDO::PARAM_STR);'. "\n".
            '$ins->bindValue(":_CREATED_TABLE_PREFIX__meta_keywords", $inputs["meta_keywords"], PDO::PARAM_STR);'. "\n".
            '$ins->bindValue(":_CREATED_TABLE_PREFIX__meta_description", $inputs["meta_description"], PDO::PARAM_STR);'. "\n".
            '$ins->bindValue(":_CREATED_TABLE_PREFIX__meta_author", $inputs["meta_author"], PDO::PARAM_STR);'. "\n".
            '$ins->bindValue(":_CREATED_TABLE_PREFIX__meta_robots", $inputs["meta_robots"], PDO::PARAM_STR);'. "\n".
			'/* End meta_tags_part4 */'. "\n";
			$file = str_replace($changer, $content, $file);
			return $file;
	 }

	 public function replacePart5($file, $changer) {
			$content =
            '/* meta_tags_part5 */'. "\n".
			', _CREATED_TABLE_PREFIX__meta_title = :_CREATED_TABLE_PREFIX__meta_title,'. "\n".
			'_CREATED_TABLE_PREFIX__meta_keywords = :_CREATED_TABLE_PREFIX__meta_keywords,'. "\n".
			'_CREATED_TABLE_PREFIX__meta_description = :_CREATED_TABLE_PREFIX__meta_description,'. "\n".
			'_CREATED_TABLE_PREFIX__meta_author = :_CREATED_TABLE_PREFIX__meta_author,'. "\n".
			'_CREATED_TABLE_PREFIX__meta_robots = :_CREATED_TABLE_PREFIX__meta_robots'. "\n".
			'/* End meta_tags_part5 */'. "\n";
			$file = str_replace($changer, $content, $file);
			return $file;
	 }

}