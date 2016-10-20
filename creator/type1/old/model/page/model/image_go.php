<?php
	$page_image = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/type1/page/model/image/image.php');
	// thumb1
		if (!empty($_POST['image_thumb1width'][$i]) && $_POST['image_thumb1width'][$i] != 0) {
			$page_image_thumb1 = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/type1/page/model/image/image_thumb1.php');
			$page_image_thumb1 = str_replace('<?php $a=[', '', $page_image_thumb1);
			$page_image_thumb1 = str_replace('];/*delete', '', $page_image_thumb1);
		} else {
			$page_image_thumb1 = '';
		}
	// thumb2
		if (!empty($_POST['image_thumb2width'][$i]) && $_POST['image_thumb2width'][$i] != 0) {
			$page_image_thumb2 = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/type1/page/model/image/image_thumb2.php');
			$page_image_thumb2 = str_replace('<?php $a=[', '', $page_image_thumb2);
			$page_image_thumb2 = str_replace('];/*delete', '', $page_image_thumb2);
		} else {
			$page_image_thumb2 = '';
		}
	// thumb3
		if (!empty($_POST['image_thumb3width'][$i]) && $_POST['image_thumb3width'][$i] != 0) {
			$page_image_thumb3 = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/type1/page/model/image/image_thumb3.php');
			$page_image_thumb3 = str_replace('<?php $a=[', '', $page_image_thumb3);
			$page_image_thumb3 = str_replace('];/*delete', '', $page_image_thumb3);
		} else {
			$page_image_thumb3 = '';
		}			
	// thumb4
		if (!empty($_POST['image_thumb4width'][$i]) && $_POST['image_thumb4width'][$i] != 0) {
			$page_image_thumb4 = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/type1/page/model/image/image_thumb4.php');
			$page_image_thumb4 = str_replace('<?php $a=[', '', $page_image_thumb4);
			$page_image_thumb4 = str_replace('];/*delete', '', $page_image_thumb4);
		} else {
			$page_image_thumb4 = '';
		}			
	
	$page_image = str_replace('<?php $a=[', '', $page_image);
	$page_image = str_replace('];/*delete', '', $page_image);
	$page_image = str_replace('/* image_thumb1 */', $page_image_thumb1, $page_image);
	$page_image = str_replace('/* image_thumb2 */', $page_image_thumb2, $page_image);
	$page_image = str_replace('/* image_thumb3 */', $page_image_thumb3, $page_image);
	$page_image = str_replace('/* image_thumb4 */', $page_image_thumb4, $page_image);
	$page_image = str_replace('_NUMBER_OF_IMAGE_', $j, $page_image);
	
	$page_image_all[] = $page_image;
