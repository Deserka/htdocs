<?php

class page_view_createView extends Creator {

   /**
    * @var array
    */
	private $whatever;

	public function __construct() {
		$this->fourSpaces = '    ';
		$this->eightSpaces = $this->fourSpaces . $this->fourSpaces;
	}
	
	public function createViewType1($modelName, $tableName, $tablePrefix, $metaTags, $ownColumns, $imagesAndThumbs, $gallery) {
		
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/view/type1/index.php');
		// Own Columns
		if ($ownColumns === 1) {
			foreach ($ownColumns as $ownColumn) {
				$tempContent[] = str_replace('COLUMN_NAME', $ownColumn, file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/view/metaTags/part1.php'));
			}
			$content = str_replace('<!--* own_columns_part1 *-->', implode('', $tempContent), $content);
		}
		// Images
		if ($imagesAndThumbs === 1) {
			for ($i=0; $i<$imagesAndThumbs[0]; $i++) {
				$j = $i+1;
				$image = str_replace('IMAGE_NUMBER', $j, file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/view/images/part1.php'));
				if ($imagesAndThumbs[1][$i] != 0) {
					for($x=1; $x<=$imagesAndThumbs[1][$i]; $x++) {
						$thumbs[] = str_replace(array('IMAGE_NUMBER', 'THUMB_NUMBER'), array($j, $x), file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/view/images/thumbs/part1.php'));;
					}
				}
				$tempContent[] = str_replace('<!--* images_part1 *-->', implode('', $thumbs, $image));
				unset($thumbs, $image);
			}
		}
		// Gallery
		if ($gallery !== NULL) {
			echo 'aaaa';
			$galleryContent = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/view/gallery/part1.php');
			if (is_int($gallery) && $gallery > 0) {
				for($x=1; $x<=$gallery[1][$i]; $x++) {
					$thumbs[] = str_replace('THUMB_NUMBER', $x, file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/view/gallery/thumbs/part1.php'));
				}
				$thumbs = implode('', $thumbs);
				$galleryContent = str_replace('<!--* thumbs_part1 *-->', implode('', $thumbs, $galleryContent));
			}
			$content = str_replace('<!--* gallery_part1 *-->', $galleryContent, $content);
		}
		
		return $content;
	}

	public function createViewType2One($modelName, $tableName, $tablePrefix, $metaTags, $ownColumns, $imagesAndThumbs, $gallery) {
		
		$content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/view/type2/one.php');
		// Own Columns
		if ($ownColumns === 1) {
			foreach ($ownColumns as $ownColumn) {
				$tempContent[] = str_replace('COLUMN_NAME', $ownColumn, file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/view/metaTags/part1.php'));
			}
			$content = str_replace('<!--* own_columns_part1 *-->', implode('', $tempContent), $content);
		}
		// Images
		if ($imagesAndThumbs === 1) {
			for ($i=0; $i<$imagesAndThumbs[0]; $i++) {
				$j = $i+1;
				$image = str_replace('IMAGE_NUMBER', $j, file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/view/images/part1.php'));
				if ($imagesAndThumbs[1][$i] != 0) {
					for($x=1; $x<=$imagesAndThumbs[1][$i]; $x++) {
						$thumbs[] = str_replace(array('IMAGE_NUMBER', 'THUMB_NUMBER'), array($j, $x), file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/view/images/thumbs/part1.php'));;
					}
				}
				$tempContent[] = str_replace('<!--* images_part1 *-->', implode('', $thumbs, $image));
				unset($thumbs, $image);
			}
		}
		// Gallery
		if ($gallery !== NULL) {
			echo 'aaaa';
			$galleryContent = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/view/gallery/part1.php');
			if (is_int($gallery) && $gallery > 0) {
				for($x=1; $x<=$gallery[1][$i]; $x++) {
					$thumbs[] = str_replace('THUMB_NUMBER', $x, file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/repo/page/view/gallery/thumbs/part1.php'));
				}
				$thumbs = implode('', $thumbs);
				$galleryContent = str_replace('<!--* thumbs_part1 *-->', implode('', $thumbs, $galleryContent));
			}
			$content = str_replace('<!--* gallery_part1 *-->', $galleryContent, $content);
		}
		
		return $content;
	}
	
}