<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/creator/lib/cms/config/createConfig.php');

class cms_model_createImagesElements extends Creator {

    /**
     * @var array
     */
	private $imagesMaxKb;


	 public function __construct() {

	 }
	 
	 public function replacePart1($file, $changer, array $imagesAndThumbs, $tablePrefix) {
		for ($i=0; $i<$imagesAndThumbs[0]; $i++) {
			$j = $i+1;
			$image[] =
			'/* image' . $j . '_part1 */' . "\n".
			'"image' . $j . '" => $result[0]["' . $tablePrefix . '_image' . $j . '"],' . "\n".
			'"image' . $j . '_alt" => $result[0]["' . $tablePrefix . '_image' . $j . '_alt"],' . "\n".
			'"image' . $j . '_title" => $result[0]["' . $tablePrefix . '_image' . $j . '_title"],' . "\n".
			'"image' . $j . '_file_name" => $result[0]["' . $tablePrefix . '_image' . $j . '_file_name"],' . "\n".
			'/**thumbs**/' . "\n".
			'/* End image_' . $j . '_part1 */' . "\n";
			$imageAll = implode('', $image);
			// Thumbs
			if ($imagesAndThumbs[1][$i] != 0) {
				for($x=1; $x<=$imagesAndThumbs[1][$i]; $x++) {
					$thumb[] = '"image' . $j . '_thumb' . $x . '" => $result[0]["' . $tablePrefix . '_image' . $j . '_thumb' . $x . '"],';
				}
				$thumbAll = implode('', $thumb);
			} else {
				$thumbAll = '';
			}
			
			$content[] = str_replace('/**thumbs**/', $thumbAll, $imageAll);	
			unset($image);
			unset($imageAll);
			unset($thumb);
			unset($thumbAll);
			}
		$content = implode('', $content);
		$file = str_replace($changer, $content, $file);
		return $file;
	 }

	 public function replacePart2($file, $changer, array $imagesAndThumbs, $tablePrefix, $imagesNames) {
		for ($i=0; $i<$imagesAndThumbs[0]; $i++) {
			$j = $i+1;
			$image = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/shared/images/part2.php');
			$image = str_replace('<?php', '', $image);
			$image = str_replace('_NUMBER_OF_IMAGE_', $j, $image);
			$image = str_replace('_CREATED_NAME_', $imagesNames[$i], $image);
			$content[] = $image;
			unset($image);
		}
		$content = implode('', $content);
		$file = str_replace($changer, $content, $file);
		return $file;
	 }

	 public function replacePart3($file, $changer, array $imagesAndThumbs, $tablePrefix, $imagesNames) {
		for ($i=0; $i<$imagesAndThumbs[0]; $i++) {
			$j = $i+1;
			$image = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/shared/images/part3.php');
			if ($imagesAndThumbs[1][$i] != 0) {
				for($x=1; $x<=$imagesAndThumbs[1][$i]; $x++) {
					$thumbs_part1[] = '$image_NUMBER_OF_IMAGE__thumb' . $x . 'Path = "/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/thumb' . $x . '/".$image_NUMBER_OF_IMAGE__newName.".".$image_NUMBER_OF_IMAGE__extension;';
					$thumbs_part2_temp = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/creator/repo/model/shared/images/thumbs/image_part3_thumb_part2.php');
					$thumbs_part2[] = str_replace('__number__', $x, $thumbs_part2_temp);
					$thumbs_part3[] = 'if( is_file( $_SERVER["DOCUMENT_ROOT"]."/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/thumb' . $x . '/".$image_NUMBER_OF_IMAGE__deleteName ) ) {' . "\n".
										'unlink( $_SERVER["DOCUMENT_ROOT"]."/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/thumb' . $x . '/".$image_NUMBER_OF_IMAGE__deleteName );' . "\n".
										'}';
					$thumbs_part4[] = 'if (is_file( $_SERVER["DOCUMENT_ROOT"]."/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/thumb' . $x . '/".$image_NUMBER_OF_IMAGE__originalPath)) {' . "\n".
										'copy( $_SERVER["DOCUMENT_ROOT"]."/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/thumb' . $x . '/".$image_NUMBER_OF_IMAGE__originalPath, ' . "\n".
										'$_SERVER["DOCUMENT_ROOT"]."/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/thumb' . $x . '/".$image_NUMBER_OF_IMAGE__potName.".".$image_NUMBER_OF_IMAGE__extension );' . "\n".
										'unlink( $_SERVER["DOCUMENT_ROOT"]."/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/thumb' . $x . '/".$image_NUMBER_OF_IMAGE__originalPath );' . "\n".
										'}';
					$thumbs_part5[] = '$image_NUMBER_OF_IMAGE__thumb' . $x . 'Path = "/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/thumb' . $x . '/".$image_NUMBER_OF_IMAGE__potName.".".$image_NUMBER_OF_IMAGE__extension;';
					$thumbs_part6[] = '$image_NUMBER_OF_IMAGE__thumb' . $x . 'Path = "/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/thumb' . $x . '/".$oldImageName;';
					$thumbs_part7[] = '$image_NUMBER_OF_IMAGE__thumb' . $x . 'Path = "";';
				}
				$thumbs_part1 = implode('', $thumbs_part1);
				$thumbs_part2 = implode('', $thumbs_part2);
				$thumbs_part3 = implode('', $thumbs_part3);
				$thumbs_part4 = implode('', $thumbs_part4);
				$thumbs_part5 = implode('', $thumbs_part5);
				$thumbs_part6 = implode('', $thumbs_part6);
				$thumbs_part7 = implode('', $thumbs_part7);
			} else {
				$thumbs_part1 = '';
				$thumbs_part2 = '';
				$thumbs_part3 = '';
				$thumbs_part4 = '';
				$thumbs_part5 = '';
				$thumbs_part6 = '';
				$thumbs_part7 = '';
			}
			$thumbsParts = array($thumbs_part1, $thumbs_part2, $thumbs_part3, $thumbs_part4, $thumbs_part5, $thumbs_part6, $thumbs_part7);
			$readyThumbsParts = array('/**thumbs_part1**/', '/**thumbs_part2**/', '/**thumbs_part3**/', '/**thumbs_part4**/', '/**thumbs_part5**/', '/**thumbs_part6**/', '/**thumbs_part7**/');
			$image = str_replace($readyThumbsParts, $thumbsParts, $image);
			$image = str_replace('<?php', '', $image);
			$image = str_replace('_NUMBER_OF_IMAGE_', $j, $image);
			$image = str_replace('_CREATED_NAME_', $imagesNames[$i], $image);
			unset($thumbs_part1, $thumbs_part2, $thumbs_part3, $thumbs_part4, $thumbs_part5, $thumbs_part6, $thumbs_part7);
			$content[] = $image;
			}
			$content = implode('', $content);

		$file = str_replace($changer, $content, $file);
		return $file;
	 }	 
	 
	 public function replacePart4($file, $changer, array $imagesAndThumbs, $tablePrefix) {
		for ($i=0; $i<$imagesAndThumbs[0]; $i++) {
			$j = $i+1;
			$image = ', _CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE_, /**thumbs**/ _CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__alt, _CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__title, _CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__file_name';
			if ($imagesAndThumbs[1][$i] != 0) {
				for($x=1; $x<=$imagesAndThumbs[1][$i]; $x++) {
					$thumb[] = '_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__thumb' . $x . ',';
				}
				$thumbAll = implode('', $thumb);
			} else {
				$thumbAll = '';
			}
			$image = str_replace('_NUMBER_OF_IMAGE_', $j, $image);
			$content[] = str_replace('/**thumbs**/', $thumbAll, $image);	
			unset($image);
			unset($thumb);
			unset($thumbAll);
			}
		$content = implode('', $content);
		$file = str_replace($changer, $content, $file);
		return $file;
	 }	 
	 
	 public function replacePart5($file, $changer, array $imagesAndThumbs, $tablePrefix) {
		for ($i=0; $i<$imagesAndThumbs[0]; $i++) {
			$j = $i+1;
			$image = ', :_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE_, /**thumbs**/ :_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__alt, :_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__title, :_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__file_name';
			if ($imagesAndThumbs[1][$i] != 0) {
				for($x=1; $x<=$imagesAndThumbs[1][$i]; $x++) {
					$thumb[] = ':_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__thumb' . $x . ',';
				}
				$thumbAll = implode('', $thumb);
			} else {
				$thumbAll = '';
			}
			$image = str_replace('_NUMBER_OF_IMAGE_', $j, $image);
			$content[] = str_replace('/**thumbs**/', $thumbAll, $image);	
			unset($image);
			unset($thumb);
			unset($thumbAll);
			}
		$content = implode('', $content);
		$file = str_replace($changer, $content, $file);
		return $file;
	 }	 
	 
	 public function replacePart6($file, $changer, array $imagesAndThumbs, $tablePrefix) {
		for ($i=0; $i<$imagesAndThumbs[0]; $i++) {
			$j = $i+1;
			$image = '/*image_NUMBER_OF_IMAGE__part6*/'. "\n" .
			'$ins->bindValue(":_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE_", $image_NUMBER_OF_IMAGE__originalPath, PDO::PARAM_STR);'. "\n" .
			'/**thumbs**/'. "\n" .
			'$ins->bindValue(":_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__alt", $inputs["image_NUMBER_OF_IMAGE__alt"], PDO::PARAM_STR);'. "\n" .
			'$ins->bindValue(":_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__title", $inputs["image_NUMBER_OF_IMAGE__title"], PDO::PARAM_STR);'. "\n" .
			'$ins->bindValue(":_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__file_name", $inputs["image_NUMBER_OF_IMAGE__file_name"], PDO::PARAM_STR);'. "\n";
			if ($imagesAndThumbs[1][$i] != 0) {
				for($x=1; $x<=$imagesAndThumbs[1][$i]; $x++) {
					$thumb[] = '$ins->bindValue(":_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__thumb' . $x . '", $image_NUMBER_OF_IMAGE__thumb' . $x . 'Path, PDO::PARAM_STR);';
				}
				$thumbAll = implode('', $thumb);
			} else {
				$thumbAll = '';
			}
			$tempContent = str_replace('/**thumbs**/', $thumbAll, $image);
			$tempContent = str_replace('_NUMBER_OF_IMAGE_', $j, $tempContent);
			$content[] = $tempContent;
			unset($tempContent);
			unset($thumb);
			unset($thumbAll);
			}
		$content = implode('', $content);
		$file = str_replace($changer, $content, $file);
		return $file;
	 }
	 
	 public function replacePart7($file, $changer, array $imagesAndThumbs, $tablePrefix) {
		for ($i=0; $i<$imagesAndThumbs[0]; $i++) {
			$j = $i+1;
			$image = '/*image_NUMBER_OF_IMAGE__part7*/'. "\n" .
			', _CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE_ = :_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE_,'. "\n" .
			'/**thumbs**/'. "\n" .
			'_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__alt = :_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__alt,'. "\n" .
			'_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__title = :_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__title,'. "\n" .
			'_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__file_name = :_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__file_name'. "\n";
			if ($imagesAndThumbs[1][$i] != 0) {
				for($x=1; $x<=$imagesAndThumbs[1][$i]; $x++) {
					$thumb[] = '_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__thumb' . $x . ' = :_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__thumb' . $x . ',';
				}
				$thumbAll = implode('', $thumb);
			} else {
				$thumbAll = '';
			}
			$tempContent = str_replace('/**thumbs**/', $thumbAll, $image);
			$tempContent = str_replace('_NUMBER_OF_IMAGE_', $j, $tempContent);
			$content[] = $tempContent;
			unset($image);
			unset($thumb);
			unset($tempContent);
			unset($thumbAll);
			}
		$content = implode('', $content);
		$file = str_replace($changer, $content, $file);
		return $file;
	 }	 
	 
	 public function replacePart8($file, $changer, array $imagesAndThumbs, $tablePrefix) {
		for ($i=0; $i<$imagesAndThumbs[0]; $i++) {
			$j = $i+1;
			$image = '/* image_NUMBER_OF_IMAGE_ part8 */'. "\n" .
			'$ins= $this-> pdo-> prepare("SELECT _CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE_ as image_NUMBER_OF_IMAGE_ '. "\n" .
			'/**thumbs_part1**/'. "\n" .
			'FROM _CREATED_TABLE_NAME_ WHERE _CREATED_TABLE_PREFIX__id = :id");'. "\n" .
			'$ins -> bindValue(":id", $id, PDO::PARAM_STR);'. "\n".
			'$ins -> execute();' . "\n".
			'$result = $ins->fetchAll();' . "\n".
			'if (!empty($result[0]["image_NUMBER_OF_IMAGE_"])) {' . "\n".
			'unlink($_SERVER["DOCUMENT_ROOT"].$result[0]["image_NUMBER_OF_IMAGE_"]);' . "\n".
			'}' . "\n".
			'/**thumbs_part2**/' . "\n".
			'/* End image_NUMBER_OF_IMAGE_ part8 */' . "\n";
			
			if ($imagesAndThumbs[1][$i] != 0) {
				for($x=1; $x<=$imagesAndThumbs[1][$i]; $x++) {
					$thumb_part1[] = ',_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__thumb1 as image_NUMBER_OF_IMAGE__thumb' . $x . '';
					$thumb_part2[] = 'if (!empty($result[0]["image_NUMBER_OF_IMAGE__thumb1"])) {' . "\n".
										'unlink($_SERVER["DOCUMENT_ROOT"].$result[0]["image_NUMBER_OF_IMAGE__thumb1"]);' . "\n".
										'}';
				}
				$thumb_part1_All = implode('', $thumb_part1);
				$thumb_part2_All = implode('', $thumb_part2);
			} else {
				$thumb_part1_All = '';
				$thumb_part2_All = '';
			}
			$image = str_replace('_NUMBER_OF_IMAGE_', $j, $image);
			$content_temp = str_replace('/**thumbs_part1**/', $thumb_part1_All, $image);
			$content_temp = str_replace('/**thumbs_part1**/', $thumb_part2_All, $content_temp);
			$content[] = $content_temp;
			unset($image);
			unset($thumb);
			unset($thumb_part1_All);
			unset($thumb_part2_All);
			unset($content_temp);
			}
		$content = implode('', $content);
		$file = str_replace($changer, $content, $file);
		return $file;
	 }	 
	 

}
	 
