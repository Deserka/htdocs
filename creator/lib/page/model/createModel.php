<?php

class page_model_createModel extends Creator {

   /**
    * @var array
    */
	private $whatever;

	public function __construct() {
		$this->fourSpaces = '    ';
		$this->eightSpaces = $this->fourSpaces . $this->fourSpaces;
	}
	
	public function createModelStart($modelName) {
		return $content = 
		'<?php' . "\n" . 'class ' . $modelName . 'Model extends Model {';
	}
	
	public function createModelEnd() {
		return $content = 
		"\n" . '}';
	}
	
	public function createModelType1($modelName, $tableName, $tablePrefix, $metaTags, $ownColumns, $imagesAndThumbs, $gallery) {
		
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/model/type1/index.php');
		// Meta tags
		if ($metaTags === 1) {
			str_replace('/**meta_tags_part1**/', file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/model/metaTags/part1.php'), $content);
		}
		// Own Columns
		if ($ownColumns === 1) {
			foreach ($ownColumns as $ownColumn) {
				$tempContent[] = str_replace('COLUMN_NAME', $ownColumn, file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/model/metaTags/part1.php'));
			}
			str_replace('/**own_columns_part1**/', implode('', $tempContent), $content);
		}
		// Images
		if ($imagesAndThumbs === 1) {
			for ($i=0; $i<$imagesAndThumbs[0]; $i++) {
				$j = $i+1;
				$image = str_replace('IMAGE_NUMBER', $j, file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/model/images/part1.php'));
				if ($imagesAndThumbs[1][$i] != 0) {
					for($x=1; $x<=$imagesAndThumbs[1][$i]; $x++) {
						$thumbs[] = str_replace(array('IMAGE_NUMBER', 'THUMB_NUMBER'), array($j, $x), file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/model/images/thumbs/part1.php'));
					}
				}
				$tempContent[] = str_replace('/**images_part1**/', implode('', $thumbs, $image));
				unset($thumbs, $image);
			}
		}
		// Gallery
		if ($gallery !== NULL) {
			$galleryContent = str_replace('<?php', '', file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/model/gallery/part1.php'));
			if (is_int($gallery) && $gallery > 0) {
				for($x=1; $x<=$gallery[1][$i]; $x++) {
					$thumbs[] = str_replace('THUMB_NUMBER', $x, file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/model/gallery/thumbs/part1.php'));
				}
				$thumbs = implode('', $thumbs);
				$galleryContent = str_replace('/**thumbs_part1**/', implode('', $thumbs, $galleryContent));
			}
			str_replace('/**gallery_part1**/', $galleryContent, $content);
		}
		
		$content = str_replace('<?php', '', $content);
		$content = str_replace('MODEL_NAME', $modelName, $content);
		$content = str_replace('TABLE_NAME', $tableName, $content);
		$content = str_replace('TABLE_PREFIX', $tablePrefix, $content);
		
		return $content;
	}

	public function createModelType2List($modelName, $tableName, $tablePrefix, $configName, $metaTags, $ownColumns, $imagesAndThumbs, $gallery) {
		
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/model/type2/list.php');
		// Own Columns
		if ($ownColumns === 1) {
			foreach ($ownColumns as $ownColumn) {
				$tempContent[] = str_replace('COLUMN_NAME', $ownColumn, file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/model/metaTags/part1.php'));
			}
			str_replace('/**own_columns_part1**/', implode('', $tempContent), $content);
		}
		// Images
		if ($imagesAndThumbs === 1) {
			for ($i=0; $i<$imagesAndThumbs[0]; $i++) {
				$j = $i+1;
				$image = str_replace('IMAGE_NUMBER', $j, file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/model/images/part1.php'));
				if ($imagesAndThumbs[1][$i] != 0) {
					for($x=1; $x<=$imagesAndThumbs[1][$i]; $x++) {
						$thumbs[] = str_replace(array('IMAGE_NUMBER', 'THUMB_NUMBER'), array($j, $x), file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/model/images/thumbs/part1.php'));
					}
				}
				$tempContent[] = str_replace('/**images_part1**/', implode('', $thumbs, $image));
				unset($thumbs, $image);
			}
		}
		
		$content = str_replace('<?php', '', $content);
		$content = str_replace('MODEL_NAME', $modelName, $content);
		$content = str_replace('TABLE_NAME', $tableName, $content);
		$content = str_replace('TABLE_PREFIX', $tablePrefix, $content);
		$content = str_replace('CONFIG_NAME', $configName, $content);
		
		return $content;
	}

	public function createModelType2One($modelName, $tableName, $tablePrefix, $metaTags, $ownColumns, $imagesAndThumbs, $gallery) {
		
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/model/type2/one.php');
		// Meta tags
		if ($metaTags === 1) {
			str_replace('/**meta_tags_part1**/', file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/model/metaTags/part1.php'), $content);
		}
		// Own Columns
		if ($ownColumns === 1) {
			foreach ($ownColumns as $ownColumn) {
				$tempContent[] = str_replace('COLUMN_NAME', $ownColumn, file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/model/metaTags/part1.php'));
			}
			str_replace('/**own_columns_part1**/', implode('', $tempContent), $content);
		}
		// Images
		if ($imagesAndThumbs === 1) {
			for ($i=0; $i<$imagesAndThumbs[0]; $i++) {
				$j = $i+1;
				$image = str_replace('IMAGE_NUMBER', $j, file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/model/images/part1.php'));
				if ($imagesAndThumbs[1][$i] != 0) {
					for($x=1; $x<=$imagesAndThumbs[1][$i]; $x++) {
						$thumbs[] = str_replace(array('IMAGE_NUMBER', 'THUMB_NUMBER'), array($j, $x), file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/model/images/thumbs/part1.php'));
					}
				}
				$tempContent[] = str_replace('/**images_part1**/', implode('', $thumbs, $image));
				unset($thumbs, $image);
			}
		}
		// Gallery
		if ($gallery !== NULL) {
			$galleryContent = str_replace('<?php', '', file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/model/gallery/part1.php'));
			if (is_int($gallery) && $gallery > 0) {
				for($x=1; $x<=$gallery[1][$i]; $x++) {
					$thumbs[] = str_replace('THUMB_NUMBER', $x, file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/model/gallery/thumbs/part1.php'));
				}
				$thumbs = implode('', $thumbs);
				$galleryContent = str_replace('/**thumbs_part1**/', implode('', $thumbs, $galleryContent));
			}
			str_replace('/**gallery_part1**/', $galleryContent, $content);
		}
		
		$content = str_replace('<?php', '', $content);
		$content = str_replace('MODEL_NAME', $modelName, $content);
		$content = str_replace('TABLE_NAME', $tableName, $content);
		$content = str_replace('TABLE_PREFIX', $tablePrefix, $content);
		
		return $content;
	}

	
}