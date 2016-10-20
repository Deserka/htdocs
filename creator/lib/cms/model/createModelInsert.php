<?php

class cms_model_createModelInsert extends Creator {

   /**
    * @var array
    */
	private $whatever;

	public function __construct() {
		$this->fourSpaces = '    ';
		$this->eightSpaces = $this->fourSpaces . $this->fourSpaces;
	}

	public function createModelInsert($modelName, $tableName, $tablePrefix, $folderName, $configName, $ownColumns, $metaTags, $imagesAndThumbsCounter, $imagesNames, $gallery, $type=NULL, $ids=NULL, $parentTableName=NULL, $parentTablePrefix=NULL) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/model/insert/insert.php');
		if ($ids !== NULL) {
			$content = str_replace('/**_IDS_**/', implode(', ', $ids), $content);
		}
		// Type 2 && 3
		if ($type === 'type2' || $type === 'type3') {
			$content = str_replace('/**type2_part1**/', str_replace('<?php', '', file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/insert/type2/part1.php')), $content);
			$content = str_replace('/**type2_part2**/', file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/insert/type2/part2.php'), $content);
			$content = str_replace('/**type2_part3**/', file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/insert/type2/part3.php'), $content);
			$content = str_replace('/**type2_part4**/', file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/insert/type2/part4.php'), $content);
		}
		// Type 3
		if ($type === 'type3') {
			$content = str_replace('/**type3_part1**/', str_replace(array('<?php', '_PARENT_TABLE_NAME_', '_PARENT_TABLE_PREFIX_'), array('', $parentTableName, $parentTablePrefix), file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/model/insert/type3/part1.php')), $content);
			$content = str_replace('/**type3_part2**/', str_replace('<?php', '', file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/insert/type3/part2.php')), $content);
			$content = str_replace('/**type3_part3**/', str_replace('<?php', '', file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/insert/type3/part3.php')), $content);
			$content = str_replace('/**type3_part4**/', str_replace('<?php', '', file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/insert/type3/part4.php')), $content);
			$content = str_replace('/**type3_part5**/', str_replace('<?php', '', file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/insert/type3/part5.php')), $content);
		
		}
		// Own Columns
		if ($ownColumns !== NULL) {
			for ($i=0; $i<count($ownColumns[0]); $i++) {
				$parts1[] = ', _CREATED_TABLE_PREFIX__' . $ownColumns[0][$i] . ' = :_CREATED_TABLE_PREFIX__' . $ownColumns[0][$i] . "\n";
				$parts2[] = '$ins->bindValue(":_CREATED_TABLE_PREFIX__' . $ownColumns[0][$i] . '", $inputs["' . $ownColumns[0][$i] . '"], PDO::PARAM_STR);' . "\n";
				// Type 2 && 3
				if ($type === 'type2' || $type === 'type3') {
					$parts3[] = ', _CREATED_TABLE_PREFIX__' . $ownColumns[0][$i] . "\n";
					$parts4[] = ', :_CREATED_TABLE_PREFIX__' . $ownColumns[0][$i] . "\n";
				}
			}
			$parts1 = implode('', $parts1); $parts2 = implode('', $parts2);
			$content = str_replace('/**own_columns_part1**/', $parts1, $content);
			$content = str_replace('/**own_columns_part2**/', $parts2, $content);
			if ($type === 'type2' || $type === 'type3') {
				$parts3 = implode('', $parts3); $parts4 = implode('', $parts4);
				$content = str_replace(array('/**own_columns_part3**/', '/**own_columns_part4**/', '/**own_columns_part5**/'), array($parts3, $parts4, $parts2), $content);
				unset($parts3, $parts4);
			}
			unset($parts1, $parts2);
		}
		// Meta tags
		if ($metaTags !== NULL) {
			$parts1 =
            '/* <!-- meta_tags part 1 */'. "\n".
			', _CREATED_TABLE_PREFIX__meta_title = :_CREATED_TABLE_PREFIX__meta_title,'. "\n".
			'_CREATED_TABLE_PREFIX__meta_keywords = :_CREATED_TABLE_PREFIX__meta_keywords,'. "\n".
			'_CREATED_TABLE_PREFIX__meta_description = :_CREATED_TABLE_PREFIX__meta_description,'. "\n".
			'_CREATED_TABLE_PREFIX__meta_author = :_CREATED_TABLE_PREFIX__meta_author,'. "\n".
			'_CREATED_TABLE_PREFIX__meta_robots = :_CREATED_TABLE_PREFIX__meta_robots'. "\n".
			'/* --> End meta_tags part 1 */'. "\n";
			$parts2 = 
            '/* <!-- meta_tags part 2 */'. "\n".
            '$ins->bindValue(":_CREATED_TABLE_PREFIX__meta_title", $inputs["meta_title"], PDO::PARAM_STR);'. "\n".
            '$ins->bindValue(":_CREATED_TABLE_PREFIX__meta_keywords", $inputs["meta_keywords"], PDO::PARAM_STR);'. "\n".
            '$ins->bindValue(":_CREATED_TABLE_PREFIX__meta_description", $inputs["meta_description"], PDO::PARAM_STR);'. "\n".
            '$ins->bindValue(":_CREATED_TABLE_PREFIX__meta_author", $inputs["meta_author"], PDO::PARAM_STR);'. "\n".
            '$ins->bindValue(":_CREATED_TABLE_PREFIX__meta_robots", $inputs["meta_robots"], PDO::PARAM_STR);'. "\n".
			'/* --> meta_tags part 2 */'. "\n";
			$content = str_replace('/**meta_tags_part1**/', $parts1, $content);
			$content = str_replace('/**meta_tags_part2**/', $parts2, $content);
			if ($type === 'type2' || $type === 'type3') {
				$parts3 =
	            '/* <!-- meta_tags part 3 */'. "\n".
				', _CREATED_TABLE_PREFIX__meta_title, _CREATED_TABLE_PREFIX__meta_keywords, _CREATED_TABLE_PREFIX__meta_description, _CREATED_TABLE_PREFIX__meta_author, _CREATED_TABLE_PREFIX__meta_robots'. "\n";
				'/* --End meta_tags_part 3 */'. "\n";
				$parts4 =
	            '/* <!-- meta_tags part 4 */'. "\n".
				', :_CREATED_TABLE_PREFIX__meta_title, :_CREATED_TABLE_PREFIX__meta_keywords, :_CREATED_TABLE_PREFIX__meta_description, :_CREATED_TABLE_PREFIX__meta_author, :_CREATED_TABLE_PREFIX__meta_robots'. "\n";
				'/* <!-- meta_tags part 4 */'. "\n";
				$content = str_replace(array('/**meta_tags_part3**/', '/**meta_tags_part4**/', '/**meta_tags_part5**/'), array($parts3, $parts4, $parts2), $content);
				unset($parts3, $parts4);
			}
			unset($parts1, $parts2);
		}
		// Images
		if ($imagesAndThumbsCounter !== NULL) {
			$part1 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/insert/images/part1.php');
			$part1 = str_replace('<?php', '', $part1);
			for ($i=0; $i<$imagesAndThumbsCounter[0]; $i++) {
				$j = $i+1;
				$part2 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/insert/images/part2.php');
				$part2 = str_replace('<?php', '', $part2);
				$part2 = str_replace('_NUMBER_OF_IMAGE_', $j, $part2);
				$part2 = str_replace('_CREATED_NAME_', $imagesNames[$i], $part2);
				$part2All[] = $part2;
				$part3 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/insert/images/part3.php');
					// Thumbs for part3
					if ($imagesAndThumbsCounter[1][$i] != 0) {
						for($x=1; $x<=$imagesAndThumbsCounter[1][$i]; $x++) {
							$part3ThumbsPart1All[] = '$image_NUMBER_OF_IMAGE__thumb' . $x . 'Path = "/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/thumb' . $x . '/".$image_NUMBER_OF_IMAGE__newName.".".$image_NUMBER_OF_IMAGE__extension;';
							$part3ThumbsPart2 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/insert/images/thumbs/part3_part2.php');
							$part3ThumbsPart2 = str_replace('__number__', $x, $part3ThumbsPart2);
							$part3ThumbsPart2 = str_replace('<?php', '', $part3ThumbsPart2);
							$part3ThumbsPart2All[] = $part3ThumbsPart2;
							$part3ThumbsPart3 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/insert/images/thumbs/part3_part3.php');
							$part3ThumbsPart3 = str_replace('__number__', $x, $part3ThumbsPart3);
							$part3ThumbsPart3 = str_replace('<?php', '', $part3ThumbsPart3);
							$part3ThumbsPart3All[] = $part3ThumbsPart3;
							$part3ThumbsPart4 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/insert/images/thumbs/part3_part4.php');
							$part3ThumbsPart4 = str_replace('__number__', $x, $part3ThumbsPart4);
							$part3ThumbsPart4 = str_replace('<?php', '', $part3ThumbsPart4);
							$part3ThumbsPart4All[] = $part3ThumbsPart4;
							$part3ThumbsPart5All[] = '$image_NUMBER_OF_IMAGE__thumb' . $x . 'Path = "/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/thumb' . $x . '/".$image_NUMBER_OF_IMAGE__potName.".".$image_NUMBER_OF_IMAGE__extension;';
							$part3ThumbsPart6All[] = '$image_NUMBER_OF_IMAGE__thumb' . $x . 'Path = "/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/thumb' . $x . '/".$oldImageName;';
							$part3ThumbsPart7All[] = '$image_NUMBER_OF_IMAGE__thumb' . $x . 'Path = "";';
						}
						$part3ThumbsPart1All = implode('', $part3ThumbsPart1All);
						$part3ThumbsPart2All = implode('', $part3ThumbsPart2All);
						$part3ThumbsPart3All = implode('', $part3ThumbsPart3All);
						$part3ThumbsPart4All = implode('', $part3ThumbsPart4All);
						$part3ThumbsPart5All = implode('', $part3ThumbsPart5All);
						$part3ThumbsPart6All = implode('', $part3ThumbsPart6All);
						$part3ThumbsPart7All = implode('', $part3ThumbsPart7All);
					} else {
						$part3ThumbsPart1All = ''; $part3ThumbsPart2All = ''; $part3ThumbsPart3All = ''; $part3ThumbsPart4All = ''; $part3ThumbsPart5All = ''; $part3ThumbsPart6All = ''; $part3ThumbsPart7All = '';
					}
					// We have all thumbs for one image - add it
					$thumbsParts = array($part3ThumbsPart1All, $part3ThumbsPart2All, $part3ThumbsPart3All, $part3ThumbsPart4All, $part3ThumbsPart5All, $part3ThumbsPart6All, $part3ThumbsPart7All);
					$readyThumbsParts = array('/**thumbs_part1**/', '/**thumbs_part2**/', '/**thumbs_part3**/', '/**thumbs_part4**/', '/**thumbs_part5**/', '/**thumbs_part6**/', '/**thumbs_part7**/');
				$part3 = str_replace($readyThumbsParts, $thumbsParts, $part3);
					unset($part3ThumbsPart1, $part3ThumbsPart2, $part3ThumbsPart3, $part3ThumbsPart4, $part3ThumbsPart5, $part3ThumbsPart6, $part3ThumbsPart7);
					unset($part3ThumbsPart1All, $part3ThumbsPart2All, $part3ThumbsPart3All, $part3ThumbsPart4All, $part3ThumbsPart5All, $part3ThumbsPart6All, $part3ThumbsPart7All);
				$part3 = str_replace('<?php', '', $part3);
				$part3 = str_replace('_NUMBER_OF_IMAGE_', $j, $part3);
				$part3 = str_replace('_CREATED_NAME_', $imagesNames[$i], $part3);
				$part3All[] = $part3;
				$part4 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/insert/images/part4.php');
					if (isset($imagesAndThumbsCounter[1][$i]) && $imagesAndThumbsCounter[1][$i] != 0 || $imagesAndThumbsCounter[1][$i] != NULL) {
						for($x=1; $x<=$imagesAndThumbsCounter[1][$i]; $x++) {
							$part4ThumbsPart1[] = '_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__thumb' . $x . ' = :_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__thumb' . $x . ',' . "\n";
						}
						$part4ThumbsPart1 = implode('', $part4ThumbsPart1);
						$part4 = str_replace('/**thumbs**/', $part4ThumbsPart1, $part4);
					}
				unset($part4ThumbsPart1);
				$part4 = str_replace('_NUMBER_OF_IMAGE_', $j, $part4);
				$part4All[] = $part4;
				$part5 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/insert/images/part5.php');
					if ($imagesAndThumbsCounter[1][$i] != 0) {
						for($x=1; $x<=$imagesAndThumbsCounter[1][$i]; $x++) {
							$part5ThumbsPart1[] = '$ins->bindValue(":_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__thumb' . $x . '", $image_NUMBER_OF_IMAGE__thumb' . $x . 'Path, PDO::PARAM_STR);' . "\n";
						}
						$part5ThumbsPart1 = implode('', $part5ThumbsPart1);
						$part5 = str_replace('/**thumbs**/', $part5ThumbsPart1, $part5);
					}
				unset($part5ThumbsPart1);
				$part5 = str_replace('_NUMBER_OF_IMAGE_', $j, $part5);
				$part5All[] = $part5;
				if ($type === 'type2' || $type === 'type3') {
					$part6 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/insert/images/part6.php');
						if ($imagesAndThumbsCounter[1][$i] != 0) {
							for($x=1; $x<=$imagesAndThumbsCounter[1][$i]; $x++) {
								$part6ThumbsPart1[] = '_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__thumb' . $x . ',' . "\n";
							}
							$part6ThumbsPart1 = implode('', $part6ThumbsPart1);
							$part6 = str_replace('/**thumbs**/', $part6ThumbsPart1, $part6);
						}
					unset($part6ThumbsPart1);
					$part6 = str_replace('_NUMBER_OF_IMAGE_', $j, $part6);
					$part6All[] = $part6;
					$part7 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/insert/images/part7.php');
						if ($imagesAndThumbsCounter[1][$i] != 0) {
							for($x=1; $x<=$imagesAndThumbsCounter[1][$i]; $x++) {
								$part7ThumbsPart1[] = ':_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__thumb' . $x . ',' . "\n";
							}
							$part7ThumbsPart1 = implode('', $part7ThumbsPart1);
							$part7 = str_replace('/**thumbs**/', $part7ThumbsPart1, $part7);
						}
					unset($part7ThumbsPart1);
					$part7 = str_replace('_NUMBER_OF_IMAGE_', $j, $part7);
					$part7All[] = $part7;
				}
				}
			$part2All = implode('', $part2All); $part3All = implode('', $part3All); $part4All = implode('', $part4All); $part5All = implode('', $part5All);
			$what = ['/**images_part1**/', '/**images_part2**/', '/**images_part3**/', '/**images_part4**/', '/**images_part5**/'];
			$for = [$part1, $part2All, $part3All, $part4All, $part5All];
			$content = str_replace($what, $for, $content);
			if ($type === 'type2' || $type === 'type3') {
				$part6All = implode('', $part6All); $part7All = implode('', $part7All);
				$content = str_replace(array('/**images_part6**/', '/**images_part7**/', '/**images_part8**/'), array($part6All, $part7All, $part5All), $content);
				unset($part6, $part7);
				unset($part6All, $part7All);
			}
			unset($part1, $part2, $part3, $part4, $part5);
			unset($part1, $part2All, $part3All, $part4All, $part5All);
		}

		// Gallery
		if ($gallery !== NULL) {
			$part1 = ",_CREATED_TABLE_PREFIX__show_gallery = :_CREATED_TABLE_PREFIX__show_gallery";
			$part2 = "\$ins->bindValue(':_CREATED_TABLE_PREFIX__show_gallery', \$_POST['show_gallery'], PDO::PARAM_STR);";
			$content = str_replace('/**gallery_part1**/', $part1, $content);
			$content = str_replace('/**gallery_part2**/', $part2, $content);
			if ($type === 'type2' || $type === 'type3') {
				$part3 = ",_CREATED_TABLE_PREFIX__show_gallery";
				$part4 = ",:_CREATED_TABLE_PREFIX__show_gallery";
				$content = str_replace(array('/**gallery_part3**/', '/**gallery_part4**/', '/**gallery_part5**/'), array($part3, $part4, $part2), $content);
				unset($part3, $part4);
			}
			unset($part1, $part2);
		}
		
		$content = str_replace('<?php class a{', '', $content);
		$content = str_replace('}/*delete*/', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $modelName, $content);
		$content = str_replace('_CREATED_TABLE_NAME_', $tableName, $content);
		$content = str_replace('_CREATED_TABLE_PREFIX_', $tablePrefix, $content);
		$content = str_replace('_CREATED_FOLDER_NAME_', $folderName, $content);
		$content = str_replace('_CREATED_CONFIG_NAME_', $configName, $content);
		
		return $content;
	}	
}