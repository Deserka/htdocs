<?php

echo '<h2>Router na stronie:</h2>';

if (isset($_POST['homepage_r'])) {
	echo 'Strona główna - Router istnieje od początku i nie trzeba było go zapisywać';
} else {
	$add_page_router =
"/* ".$menu_name." */
if(\$_SERVER['REQUEST_URI'] === '/".$_POST['page_url']."' || preg_match('/^\/[a-z]{2}\/".$_POST['page_url']."$/', \$_SERVER['REQUEST_URI'])) {
	\$ob = new ".$model_name."Controller;
	\$ob->".$model_name."();
	exit;
}
/* End ".$menu_name." */	
/* Adder */";

	// Add this rouer...
	$current_page_router = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/index.php');
	
		// Delete if existed
		if(strpos($current_page_router, '/* '.$menu_name.' */') && strpos($current_page_router, '/* End '.$menu_name.' */'))
		{
		    $current_page_router = preg_replace('/\/\* '.$menu_name.' \*\/(.*)\/\* End '.$menu_name.' \*\//s', '', $current_page_router);
		    echo 'Poprzedni wpis w Page Routerze usunięto - '.$menu_name."<br />";
		}
	
	if (!strpos($current_page_router, '/* '.$menu_name.' */')) {
		$future_page_router = str_replace('/* Adder */', $add_page_router, $current_page_router);
		file_put_contents($_SERVER['DOCUMENT_ROOT'].'/index.php', $future_page_router);
		echo 'Page Router dodany';
	} else {
		echo 'Był już taki Page Router';
	}

}

