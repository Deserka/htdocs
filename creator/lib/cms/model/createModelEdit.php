<?php

class cms_model_createModelEdit extends Creator {

   /**
    * @var array
    */
	private $whatever;

	public function __construct() {
		$this->fourSpaces = '    ';
		$this->eightSpaces = $this->fourSpaces . $this->fourSpaces;
	}

	public function createModelEdit($modelName, $tableName, $tablePrefix, $ownColumns, $metaTags, $imagesAndThumbsCounter, $gallery, $type=NULL, array $ids=NULL, $parentTableName=NULL, $parentTablePrefix=NULL) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/model/edit/edit.php');
		if ($ids !== NULL) {
			$content = str_replace('/**_IDS_**/', implode(', ', $ids), $content);
		}
		// Type 2
		if ($type === 'type2' || $type === 'type3') {
			$content = str_replace('/**type2_part1**/', file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/model/edit/type2/part1.php'), $content);
			$content = str_replace('/**type2_part2**/', file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/model/edit/type2/part2.php'), $content);
			$content = str_replace('/**type2_part3**/', file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/model/edit/type2/part3.php'), $content);
		}
		// Type 3
		if ($type === 'type3') {
			$content = str_replace('/**type3_part1**/', str_replace(array('<?php', '_PARENT_TABLE_NAME_', '_PARENT_TABLE_PREFIX_'), array('', $parentTableName, $parentTablePrefix), file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/model/add/type3/part1.php')), $content);
			$content = str_replace('/**type3_part2**/', str_replace('<?php', '', file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/model/add/type3/part2.php')), $content);
		}
		// Own Columns
		if ($ownColumns !== NULL) {
			for ($i=0; $i<count($ownColumns[0]); $i++) {
				$parts[] = '"' . $ownColumns[0][$i] . '"=> $result[0]["_CREATED_TABLE_PREFIX__' . $ownColumns[0][$i] . '"],' . "\n";
			}
			$parts = implode('', $parts);
			$content = str_replace('/**own_columns_part1**/', $parts, $content);
			unset($parts);
		}
		// Meta tags
		if ($metaTags !== NULL) {
			$parts =
            '/* meta_tags_part1 */'. "\n".
            '"meta_title"    	 => $result[0]["_CREATED_TABLE_PREFIX__meta_title"],'. "\n".
            '"meta_keywords"      => $result[0]["_CREATED_TABLE_PREFIX__meta_keywords"],'. "\n".
            '"meta_description"   => $result[0]["_CREATED_TABLE_PREFIX__meta_description"],'. "\n".
            '"meta_author"        => $result[0]["_CREATED_TABLE_PREFIX__meta_author"],'. "\n".
            '"meta_robots"        => $result[0]["_CREATED_TABLE_PREFIX__meta_robots"],'. "\n".
			'/* End meta_tags_part1 */'. "\n";
			$content = str_replace('/**meta_tags_part1**/', $parts, $content);
			unset($parts);
		}
		// Images
		if ($imagesAndThumbsCounter !== NULL) {
			for ($i=0; $i<$imagesAndThumbsCounter[0]; $i++) {
				$j = $i+1;
				$image[] =
					'/* image' . $j . '_part1 */' . "\n".
					'"image' . $j . '" => $result[0]["_CREATED_TABLE_PREFIX__image' . $j . '"],' . "\n".
					'"image' . $j . '_alt" => $result[0]["_CREATED_TABLE_PREFIX__image' . $j . '_alt"],' . "\n".
					'"image' . $j . '_title" => $result[0]["_CREATED_TABLE_PREFIX__image' . $j . '_title"],' . "\n".
					'"image' . $j . '_file_name" => $result[0]["_CREATED_TABLE_PREFIX__image' . $j . '_file_name"],' . "\n".
					'/**thumbs**/' . "\n".
					'/* End image_' . $j . '_part1 */' . "\n";
				$imageAll = implode('', $image);
				// Thumbs
				if ($imagesAndThumbsCounter[1][$i] != 0) {
					for($x=1; $x<=$imagesAndThumbsCounter[1][$i]; $x++) {
						$thumb[] = '"image' . $j . '_thumb' . $x . '" => $result[0]["_CREATED_TABLE_PREFIX__image' . $j . '_thumb' . $x . '"],';
					}
					$thumbAll = implode('', $thumb);
				} else {
					$thumbAll = '';
				}
				
				$parts[] = str_replace('/**thumbs**/', $thumbAll, $imageAll);
				unset($image);
				unset($imageAll);
				unset($thumb);
				unset($thumbAll);
				}
				$parts = implode('', $parts);
			$content = str_replace('/**images_part1**/', $parts, $content);
			unset($parts);
		}
		// Gallery
		if ($gallery !== NULL) {
			$parts = "'show_gallery'              => \$result[0]['_CREATED_TABLE_PREFIX__show_gallery'],";
			$content = str_replace('/**gallery_part1**/ ', $parts, $content);
			unset($parts);
		}
		
		$content = str_replace('<?php class a{', '', $content);
		$content = str_replace('}/*delete*/', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $modelName, $content);
		$content = str_replace('_CREATED_TABLE_NAME_', $tableName, $content);
		$content = str_replace('_CREATED_TABLE_PREFIX_', $tablePrefix, $content);
		return $content;
	}	
}