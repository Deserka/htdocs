<?php

	function MODEL_NAMEList($pageNumber=NULL) {
		include($_SERVER['DOCUMENT_ROOT'].'/config/page_config.php');
		$limit = $configuration['CONFIG_NAME_list_elements_amount'];
		if ($pageNumber == NULL) {
			$limitMysql = 'LIMIT 0, ' . $limit . '';
		} elseif ($pageNumber == 1) {
			$limitMysql = 'LIMIT 0, ' . $limit . '';
		} else {
			$offset = $pageNumber * $limit;
			$limitMysql = 'LIMIT ' . $offset . ', ' . $limit . '';
		}
		$query=$this->pdo->prepare("
			SELECT
			TABLE_PREFIX_id as id,
			TABLE_PREFIX_title as title,
			TABLE_PREFIX_url as url,
			TABLE_PREFIX_hide as hide,
			TABLE_PREFIX_lang as lang,
			TABLE_PREFIX_viewers as viewers,
			TABLE_PREFIX_queue as queue,
			TABLE_PREFIX_created_date as date,
			TABLE_PREFIX_created_by as created_by
			/**own_columns_part1**/
			/**images_part1**/
			FROM TABLE_NAME
			WHERE TABLE_PREFIX_lang = :lang && TABLE_PREFIX_hide = 0
			". $limitMysql ."
		");
	    $query->bindValue(':lang', $_SESSION['page_lang'], PDO::PARAM_STR);			
		$query->execute();	
		$result = $query->fetchAll();
		
	    if (empty($result)) {
	    	$content = [
	        	'status' => 'error404',
	        ];
	            return ($content); 
		}
		$content = [
	    	'list'		=> $result,
		];
		return ($content);
	}