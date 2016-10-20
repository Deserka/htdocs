<?php

echo '<h2>Page View:</h2>';

$view1_start = '<?php /*'."\n";
$view1_end = '*/?>';
$view1_default = '<?= $content["title"] ?>'."\n";

if ($own_columns === 1) {
	$count = count($_POST['own_mysql_name']);
	
	for ($i = 0; $i < $count; $i++) {
		
		$own_mysql_name = $_POST['own_mysql_name'][$i];
		$own_type = $_POST['own_type'][$i];
		$own_length = $_POST['own_length'][$i];
		$own_cms_name = $_POST['own_cms_name'][$i];
		
		$view1_default_own_columns[] = '<?= $content["'.$own_mysql_name.'"] ?>';
	
	}
	$view1_default_own_columns = implode("\n", $view1_default_own_columns);	
	$view1_default_own_columns = $view1_default_own_columns."\n";
} else {
	$view1_default_own_columns = '';
}

if ($meta_tags === 1) {
	$view1_meta_tags = '<?= $content["meta_title"] ?>'."\n".'<?= $content["meta_keywords"] ?>'."\n".'<?= $content["meta_description"] ?>'."\n".'<?= $content["meta_author"] ?>'."\n".'<?= $content["meta_robots"] ?>'."\n";
} else {
	$view1_meta_tags = '';
}

if ($tags === 1) {
	
}

// Images
if (isset($_POST['image']) && $_POST['image'] != NULL) {
	$count_images = count($_POST['image']);
	for ($i=0; $i<$count_images; $i++) {
		$j = $i+1;
		include($_SERVER['DOCUMENT_ROOT'].'/creator/type1/page/view/image_go.php');
		unset($j);
	}
	$page_view_image_all_array = implode('', $page_view_image_all_array);
}

if ($gallery === 1) {
	$view1_gallery = 
'<?= $content["show_gallery"] ?>'."\n".'<?php'."\n".
'if ($content["show_gallery"] != 0 && !empty($content["gallery"])) {'.
'foreach($content["gallery"] as $image) {'
."\n".'?>'."\n".'<a href="<?= $image[\'img_url\'] ?>"><img src="<?= $image[\'pagethumb\'] ?>" alt="<?= $image[\'img_alt\'] ?>" <?= (!empty($image[\'img_meta_title\'])) ? \'title="\'.$image[\'img_meta_title\'].\'"\':\'\' ?> /></a>'."\n".
'<?= $image["img_title"] ?>'."\n".'<?= $image["img_content"] ?>'."\n".
'<?php'."\n".'} }'."\n".'  ?>'."\n";
} else {
	$view1_gallery = '';
}

$all_view1 = $view1_start.$view1_default.$view1_default_own_columns.$view1_meta_tags.$page_view_image_all_array.$view1_gallery.$view1_end;


file_put_contents($_SERVER['DOCUMENT_ROOT'].'/app/view/templates/'.$model_name.'.phtml', $all_view1);

echo 'Page View zapisany';