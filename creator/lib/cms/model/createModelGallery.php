<?php

class cms_model_createModelGallery extends Creator {

	 public function __construct() {

	 }
	 
	 public function createGalleryBasic($modelName, $tableName, $tablePrefix, array $ids = NULL, $type=NULL, $parentTableName=NULL, $parentTablePrefix=NULL) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/gallery/basic/basic.php');
		if ($ids !== NULL) {
			$ids = implode(', ', $ids);
			$content = str_replace('/**_IDS_**/', $ids, $content);
		}
		
		if ($type === 'part2' || $type === 'part3') {
			$content = str_replace('/**type2_part1**/', 'WHERE _CREATED_TABLE_PREFIX__img_parent_id = :id', $content);
			$content = str_replace('/**type2_part2**/', '$query->bindValue(":id", $id, PDO::PARAM_STR);', $content);
			$content = str_replace('/**type2_part3**/', file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/gallery/basic/type2/part3.php'), $content);
			$content = str_replace('/**type2_part4**/', '"galleryParent_id" => $title[0][0], "galleryParent_title" => $title[0][1],', $content);
		}
		if ($type === 'part3_child1') {
			$content = str_replace('/**type3_child1_part1**/', 'WHERE _CREATED_TABLE_PREFIX__img_parent_id = :id', $content);
			$content = str_replace('/**type3_child1_part2**/', '$query->bindValue(":id", $id, PDO::PARAM_STR);', $content);
			$content = str_replace('/**type3_child1_part3**/', str_replace(array('<?php', '*parent table name*', '*parent table prefix*'), array('', $parentTableName, $parentTablePrefix), file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/gallery/basic/type3/child1/part1.php')), $content);
			$content = str_replace('/**type3_child1_part4**/', file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/gallery/basic/type3/child1/part2.php'), $content);
			$content = str_replace('/**type3_child1_part5**/', file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/gallery/basic/type3/child1/part3.php'), $content);
			$content = str_replace('/**type3_child1_part6**/', '"galleryParent_id" => $title[0][0], "galleryParent_title" => $title[0][1],', $content);
			
		}
		$content = str_replace('<?php ', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $modelName, $content);
		$content = str_replace('_CREATED_TABLE_NAME_', $tableName, $content);
		$content = str_replace('_CREATED_TABLE_PREFIX_', $tablePrefix, $content);
		return $content;
	 }
	 
	 public function createGalleryInsert($modelName, $tableName, $tablePrefix, $folderName, $configName, $thumbsAmount, array $ids = NULL, $type=NULL) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/gallery/insert/insert.php');
		if ($ids !== NULL) {
			$ids = implode(', ', $ids);
			$content = str_replace('/**_IDS_**/', $ids, $content);
		}
		if ($type === 'type1') {
			$content = str_replace('/**type1_part1**/', '$ins->bindValue(":_CREATED_TABLE_PREFIX__img_parent_id", 0, PDO::PARAM_STR);', $content);
		} elseif ($type === 'type2' || $type === 'type3' || $type === 'type3_child1') {
			$content = str_replace('/**type2_part1**/', '$ins->bindValue(":_CREATED_TABLE_PREFIX__img_parent_id", $id, PDO::PARAM_STR);', $content);
		}
		// Thumbs
		if ($thumbsAmount !== NULL) {
			for ($i=0; $i<$thumbsAmount; $i++) {
				$j = $i+1;
				$part1 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/gallery/insert/part1.php');
				$part1 = str_replace('<?php', '', $part1);
				$part1 = str_replace('_NUMBER_OF_THUMB_', $j, $part1);
				$part1All[] = $part1;
				$part2 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/gallery/insert/part2.php');
				$part2 = str_replace('<?php', '', $part2);
				$part2 = str_replace('_NUMBER_OF_THUMB_', $j, $part2);
				$part2All[] = $part2;
				$part3 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/gallery/insert/part3.php');
				$part3 = str_replace('<?php', '', $part3);
				$part3 = str_replace('_NUMBER_OF_THUMB_', $j, $part3);
				$part3All[] = $part3;
				$part4 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/gallery/insert/part4.php');
				$part4 = str_replace('<?php', '', $part4);
				$part4 = str_replace('_NUMBER_OF_THUMB_', $j, $part4);
				$part4All[] = $part4;
			}
			$part1All = implode('', $part1All);
			$content = str_replace('/**thumbs_part1**/', $part1All, $content);
			$part2All = implode('', $part2All);
			$content = str_replace('/**thumbs_part2**/', $part2All, $content);
			$part3All = implode('', $part3All);
			$content = str_replace('/**thumbs_part3**/', $part3All, $content);
			$part4All = implode('', $part4All);
			$content = str_replace('/**thumbs_part4**/', $part4All, $content);
		}
		$content = str_replace('<?php ', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $modelName, $content);
		$content = str_replace('_CREATED_TABLE_NAME_', $tableName, $content);
		$content = str_replace('_CREATED_TABLE_PREFIX_', $tablePrefix, $content);
		$content = str_replace('_CREATED_FOLDER_NAME_', $folderName, $content);
		$content = str_replace('_CREATED_CONFIG_NAME_', $configName, $content);
		return $content;
	 }

	 public function createGalleryDelete($modelName, $tableName, $tablePrefix, $thumbsAmount, array $ids, $type=NULL) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/gallery/delete/delete.php');
		if ($ids !== NULL) {
			$ids = implode(', ', $ids);
			$content = str_replace('/**_IDS_**/', $ids, $content);
		}
		if ($type === 'type2') {
			$content = str_replace('/**type2_part1**/', $_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/gallery/delete/type2/part1.php', $content);
		}
		// Thumbs
		if ($thumbsAmount !== NULL) {
			for ($i=0; $i<$thumbsAmount; $i++) {
				$j = $i+1;
				$part1 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/gallery/delete/part1.php');
				$part1 = str_replace('<?php', '', $part1);
				$part1 = str_replace('_NUMBER_OF_THUMB_', $j, $part1);
				$part1All[] = $part1;
				$part2 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/gallery/delete/part2.php');
				$part2 = str_replace('_NUMBER_OF_THUMB_', $j, $part2);
				$part2All[] = $part2;
			}
			$part1All = implode('', $part1All);
			$content = str_replace('/**thumbs_part1**/', $part1All, $content);
			$part2All = implode('', $part2All);
			$content = str_replace('/**thumbs_part2**/', $part2All, $content);
		}
		$content = str_replace('<?php ', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $modelName, $content);
		$content = str_replace('_CREATED_TABLE_NAME_', $tableName, $content);
		$content = str_replace('_CREATED_TABLE_PREFIX_', $tablePrefix, $content);
		return $content;
	 }

	 public function createGalleryEdit($modelName, $tableName, $tablePrefix) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/gallery/edit/edit.php');
		$content = str_replace('<?php ', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $modelName, $content);
		$content = str_replace('_CREATED_TABLE_NAME_', $tableName, $content);
		$content = str_replace('_CREATED_TABLE_PREFIX_', $tablePrefix, $content);
		return $content;
	 }
	 
	 public function createGalleryUpdate($modelName, $tableName, $tablePrefix, $folderName, $configName, $thumbsAmount, array $ids=NULL) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/gallery/update/update.php');
		if ($ids !== NULL) {
			$ids = implode(', ', $ids);
			$content = str_replace('/**_IDS_**/', $ids, $content);
		}
		// Thumbs
		if ($thumbsAmount !== NULL) {
			for ($i=0; $i<$thumbsAmount; $i++) {
				$j = $i+1;
				$part1 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/gallery/insert/part1.php');
				$part1 = str_replace('<?php', '', $part1);
				$part1 = str_replace('_NUMBER_OF_THUMB_', $j, $part1);
				$part1All[] = $part1;
				$part2 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/gallery/insert/part2.php');
				$part2 = str_replace('<?php', '', $part2);
				$part2 = str_replace('_NUMBER_OF_THUMB_', $j, $part2);
				$part2All[] = $part2;
				$part3 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/gallery/insert/part3.php');
				$part3 = str_replace('<?php', '', $part3);
				$part3 = str_replace('_NUMBER_OF_THUMB_', $j, $part3);
				$part3All[] = $part3;
				$part4 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/gallery/insert/part4.php');
				$part4 = str_replace('<?php', '', $part4);
				$part4 = str_replace('_NUMBER_OF_THUMB_', $j, $part4);
				$part4All[] = $part4;
				$part5 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/gallery/insert/part5.php');
				$part5 = str_replace('<?php', '', $part5);
				$part5 = str_replace('_NUMBER_OF_THUMB_', $j, $part5);
				$part5All[] = $part5;
				$part6 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/gallery/insert/$part6.php');
				$part6 = str_replace('<?php', '', $part6);
				$part6 = str_replace('_NUMBER_OF_THUMB_', $j, $part6);
				$part6All[] = $part5;
			}
			$part1All = implode('', $part1All);
			$content = str_replace('/**thumbs_part1**/', $part1All, $content);
			$part2All = implode('', $part2All);
			$content = str_replace('/**thumbs_part2**/', $part2All, $content);
			$part3All = implode('', $part3All);
			$content = str_replace('/**thumbs_part3**/', $part3All, $content);
			$part4All = implode('', $part4All);
			$content = str_replace('/**thumbs_part4**/', $part4All, $content);
			$part5All = implode('', $part5All);
			$content = str_replace('/**thumbs_part5**/', $part5All, $content);
			$part6All = implode('', $part6All);
			$content = str_replace('/**thumbs_part6**/', $part6All, $content);
		}
		$content = str_replace('<?php ', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $modelName, $content);
		$content = str_replace('_CREATED_TABLE_NAME_', $tableName, $content);
		$content = str_replace('_CREATED_TABLE_PREFIX_', $tablePrefix, $content);
		$content = str_replace('_CREATED_FOLDER_NAME_', $folderName, $content);
		$content = str_replace('_CREATED_CONFIG_NAME_', $configName, $content);
		return $content;
	 }

	 public function createGalleryQueue($modelName, $tableName, $tablePrefix) {
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/gallery/queue/queue.php');
		$content = str_replace('<?php ', '', $content);
		$content = str_replace('_CREATED_MODEL_NAME_', $modelName, $content);
		$content = str_replace('_CREATED_TABLE_NAME_', $tableName, $content);
		$content = str_replace('_CREATED_TABLE_PREFIX_', $tablePrefix, $content);
		return $content;
	 }

	 public function createModelGalleryType1($thumbsAmount, $modelName, $tableName, $tablePrefix, $configName, $folderName) {
		$galleryModel = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/type1/modelGallery.php');
		$galleryModel = str_replace('<?php class a { ', '', $galleryModel);
		// Thumbs
		if ($thumbsAmount !== NULL) {
			for ($i=0; $i<$thumbsAmount; $i++) {
				$j = $i+1;
				$part1 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/shared/gallery/thumbs_part1.php');
				$part1 = str_replace('<?php', '', $part1);
				$part1 = str_replace('_NUMBER_OF_THUMB_', $j, $part1);
				$part1All[] = $part1;
				$part2 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/shared/gallery/thumbs_part2.php');
				$part2 = str_replace('_NUMBER_OF_THUMB_', $j, $part2);
				$part2All[] = $part2;
				$part3 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/shared/gallery/thumbs_part3.php');
				$part3 = str_replace('_NUMBER_OF_THUMB_', $j, $part3);
				$part3All[] = $part3;
				$part4 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/shared/gallery/thumbs_part4.php');
				$part4 = str_replace('<?php', '', $part4);
				$part4 = str_replace('_NUMBER_OF_THUMB_', $j, $part4);
				$part4All[] = $part4;
				$part5 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/shared/gallery/thumbs_part5.php');
				$part5 = str_replace('<?php', '', $part5);
				$part5 = str_replace('_NUMBER_OF_THUMB_', $j, $part5);
				$part5All[] = $part5;
				$part6 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/shared/gallery/thumbs_part6.php');
				$part6 = str_replace('<?php', '', $part6);
				$part6 = str_replace('_NUMBER_OF_THUMB_', $j, $part6);
				$part6All[] = $part6;
				$part7 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/shared/gallery/thumbs_part7.php');
				$part7 = str_replace('<?php', '', $part7);
				$part7 = str_replace('_NUMBER_OF_THUMB_', $j, $part7);
				$part7All[] = $part7;
				$part8 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/shared/gallery/thumbs_part8.php');
				$part8 = str_replace('<?php', '', $part8);
				$part8 = str_replace('_NUMBER_OF_THUMB_', $j, $part8);
				$part8All[] = $part8;
				$part9 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/shared/gallery/thumbs_part9.php');
				$part9 = str_replace('<?php', '', $part9);
				$part9 = str_replace('_NUMBER_OF_THUMB_', $j, $part9);
				$part9All[] = $part9;
				$part10 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/shared/gallery/thumbs_part10.php');
				$part10 = str_replace('<?php', '', $part10);
				$part10 = str_replace('_NUMBER_OF_THUMB_', $j, $part10);
				$part10All[] = $part10;
				$part11 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/shared/gallery/thumbs_part11.php');
				$part11 = str_replace('<?php', '', $part11);
				$part11 = str_replace('_NUMBER_OF_THUMB_', $j, $part11);
				$part11All[] = $part11;
			}
			$part1All = implode('', $part1All);
			$galleryModel = str_replace('/**thumbs_part1**/', $part1All, $galleryModel);
			$part2All = implode('', $part2All);
			$galleryModel = str_replace('/**thumbs_part2**/', $part2All, $galleryModel);
			$part3All = implode('', $part3All);
			$galleryModel = str_replace('/**thumbs_part3**/', $part3All, $galleryModel);
			$part4All = implode('', $part4All);
			$galleryModel = str_replace('/**thumbs_part4**/', $part4All, $galleryModel);
			$part5All = implode('', $part5All);
			$galleryModel = str_replace('/**thumbs_part5**/', $part5All, $galleryModel);
			$part6All = implode('', $part6All);
			$galleryModel = str_replace('/**thumbs_part6**/', $part6All, $galleryModel);
			$part7All = implode('', $part7All);
			$galleryModel = str_replace('/**thumbs_part7**/', $part7All, $galleryModel);
			$part8All = implode('', $part8All);
			$galleryModel = str_replace('/**thumbs_part8**/', $part8All, $galleryModel);
			$part9All = implode('', $part9All);
			$galleryModel = str_replace('/**thumbs_part9**/', $part9All, $galleryModel);
			$part10All = implode('', $part10All);
			$galleryModel = str_replace('/**thumbs_part10**/', $part10All, $galleryModel);
			$part11All = implode('', $part11All);
			$galleryModel = str_replace('/**thumbs_part11**/', $part11All, $galleryModel);
		}
		$galleryModel = str_replace('<?php class a { ', '', $galleryModel);
		$galleryModel = str_replace('}/**delete**/', '', $galleryModel);
		$galleryModel = str_replace('_CREATED_MODEL_NAME_', $modelName, $galleryModel);
		$galleryModel = str_replace('_CREATED_TABLE_NAME_', $tableName, $galleryModel);
		$galleryModel = str_replace('_CREATED_TABLE_PREFIX_', $tablePrefix, $galleryModel);
		$galleryModel = str_replace('_CREATED_CONFIG_NAME_', $configName, $galleryModel);
		$galleryModel = str_replace('_CREATED_FOLDER_NAME_', $folderName, $galleryModel);

		return $galleryModel;
	 }
}