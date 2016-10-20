<?php
if (URLS_ALL) {
	if (URLS_FIRST_PAGE) {
	    $ob = new MODEL_NAMEController;
	    $ob->MODEL_NAMEList();
	} else {
URLS_ANOTHER_PAGES;
		$pageNumber = $neededVariables[1];
	    $ob = new MODEL_NAMEController;
	    $ob->MODEL_NAMEList($pageNumber);
	}
}