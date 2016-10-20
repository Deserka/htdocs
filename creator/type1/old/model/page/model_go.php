<?php

echo '<h2>Page Model:</h2>';

if ($own_columns === 1) {
	$count = count($_POST['own_mysql_name']);
	
	for ($i = 0; $i < $count; $i++) {
		
		$own_mysql_name = $_POST['own_mysql_name'][$i];
		$own_type = $_POST['own_type'][$i];
		$own_length = $_POST['own_length'][$i];
		$own_cms_name = $_POST['own_cms_name'][$i];
		
		$page_model_own_columns[] = "'".$own_mysql_name."'     => \$result[0]['_PAGE_TABLE_PREFIX__".$own_mysql_name."'],";
	
	}
	
	$page_model_own_columns = implode("\n", $page_model_own_columns);	
} else {
	$page_model_own_columns = '';
}

if ($meta_tags === 1) {
	$page_meta_tags = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/type1/page/model/meta_tags.php');
	$page_meta_tags = str_replace('<?php $a=[', '', $page_meta_tags);
	$page_meta_tags = str_replace('];/*delete', '', $page_meta_tags);
} else {
	$page_meta_tags = '';
}

if ($tags === 1) {
	
}

// Images
if (isset($_POST['image']) && $_POST['image'] != NULL) {
	$count_images = count($_POST['image']);
	for ($i=0; $i<$count_images; $i++) {
		$j = $i+1;
		include($_SERVER['DOCUMENT_ROOT'].'/creator/type1/page/model/image_go.php');
		unset($j);
	}
	$page_image_all = implode('', $page_image_all);
} else {
	$page_image_all = '';
}


if ($gallery === 1) {
	$page_gallery1 = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/type1/page/model/gallery/gallery1.php');
	$page_gallery1 = str_replace('<?php', '', $page_gallery1);
	$page_gallery2 = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/type1/page/model/gallery/gallery2.php');	
} else {
	$page_gallery1 = '';
	$page_gallery2 = '';
}

$page_model = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/creator/type1/page/model/model.php');

$page_model = str_replace('/*_PAGE_MODEL_OWN_COLUMNS_*/', $page_model_own_columns, $page_model);
$page_model = str_replace('/*_PAGE_MODEL_META_TAGS_*/', $page_meta_tags, $page_model);
$page_model = str_replace('/*_PAGE_MODEL_IMAGE_*/', $page_image_all, $page_model);
$page_model = str_replace('/*_PAGE_MODEL_GALLERY_1_*/', $page_gallery1, $page_model);
$page_model = str_replace('/*_PAGE_MODEL_GALLERY_2_*/', $page_gallery2, $page_model);

$page_model = str_replace('_PAGE_MODEL_NAME_', $model_name, $page_model);
$page_model = str_replace('_PAGE_TABLE_NAME_', $table_name, $page_model);
$page_model = str_replace('_PAGE_TABLE_PREFIX_', $table_prefix, $page_model);

file_put_contents($_SERVER['DOCUMENT_ROOT'].'/app/model/'.$model_name.'.php', $page_model);

echo 'Page Model zapisany';