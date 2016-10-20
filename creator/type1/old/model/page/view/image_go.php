<?php
	// thumb1
		if (!empty($_POST['image_thumb1width'][$i]) && $_POST['image_thumb1width'][$i] != 0) {
			$page_view_image_thumb1_view = '<img src="<?= $content["image_NUMBER_OF_IMAGE__thumb1"] ?>" alt="<?= $content["image_NUMBER_OF_IMAGE__alt"] ?>" <?= (!empty($content["image_NUMBER_OF_IMAGE__title"])) ? "title=\'".$content["image_NUMBER_OF_IMAGE__title"]."\'":"" ?> />'."\n";
		} else {
			$page_view_image_thumb1_view = '';
		}
	// thumb2
		if (!empty($_POST['image_thumb2width'][$i]) && $_POST['image_thumb2width'][$i] != 0) {
			$page_view_image_thumb2_view = '<img src="<?= $content["image_NUMBER_OF_IMAGE__thumb2"] ?>" alt="<?= $content["image_NUMBER_OF_IMAGE__alt"] ?>" <?= (!empty($content["image_NUMBER_OF_IMAGE__title"])) ? "title=\'".$content["image_NUMBER_OF_IMAGE__title"]."\'":"" ?> />'."\n";
		} else {
			$page_view_image_thumb2_view = '';
		}
	// thumb3
		if (!empty($_POST['image_thumb3width'][$i]) && $_POST['image_thumb3width'][$i] != 0) {
			$page_view_image_thumb3_view = '<img src="<?= $content["image_NUMBER_OF_IMAGE__thumb3"] ?>" alt="<?= $content["image_NUMBER_OF_IMAGE__alt"] ?>" <?= (!empty($content["image_NUMBER_OF_IMAGE__title"])) ? "title=\'".$content["image_NUMBER_OF_IMAGE__title"]."\'":"" ?> />'."\n";
		} else {
			$page_view_image_thumb3_view = '';
		}			
	// thumb4
		if (!empty($_POST['image_thumb4width']) && $_POST['image_thumb4width'] != 0) {
			$page_view_image_thumb4_view = '<img src="<?= $content["image_NUMBER_OF_IMAGE__thumb4"] ?>" alt="<?= $content["image_NUMBER_OF_IMAGE__alt"] ?>" <?= (!empty($content["image_NUMBER_OF_IMAGE__title"])) ? "title=\'".$content["image_NUMBER_OF_IMAGE__title"]."\'":"" ?> />'."\n";
		} else {
			$page_view_image_thumb4_view = '';
		}			
	
	$page_view_image_all = '<img src="<?= $content["image_NUMBER_OF_IMAGE_"] ?>" alt="<?= $content["image_NUMBER_OF_IMAGE__alt"] ?>" <?= (!empty($content["image_NUMBER_OF_IMAGE__title"])) ? "title=\'".$content["image_NUMBER_OF_IMAGE__title"]."\'":"" ?> />'."\n"
							.$page_view_image_thumb1_view.$page_view_image_thumb2_view.$page_view_image_thumb3_view.$page_view_image_thumb4_view;
							
	$page_view_image_all = str_replace('_NUMBER_OF_IMAGE_', $j, $page_view_image_all);
	$page_view_image_all_array[] = $page_view_image_all;