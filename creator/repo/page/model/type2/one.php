<?php
	function MODEL_NAMEOne($id, $url) {
		if ($id !== NULL && $url !== NULL) {
			$where = ' && TABLE_PREFIX_id = :id && TABLE_PREFIX_url = :url';
		} elseif ($id !== NULL) {
			$where = ' && TABLE_PREFIX_id = :id';
		} else {
			$where = ' && TABLE_PREFIX_url = :url';
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
			TABLE_PREFIX_created_by as created_by,
			TABLE_PREFIX_last_modified_date as last_modified_date,
			TABLE_PREFIX_last_modified_by as modified_by
			/**meta_tags_part1**/
			/**own_columns_part1**/
			/**images_part1**/
			/**gallery_part1**/
			FROM TABLE_NAME
			WHERE TABLE_PREFIX_lang = :lang " . $where . "
		");
	    $query->bindValue(':lang', $_SESSION['page_lang'], PDO::PARAM_STR);
		if ($id !== NULL && $url !== NULL) {
			$query->bindValue(':id', $id, PDO::PARAM_STR);
			$query->bindValue(':url', $url, PDO::PARAM_STR);
		} elseif ($id !== NULL) {
			$query->bindValue(':id', $id, PDO::PARAM_STR);
		} else {
			$query->bindValue(':url', $url, PDO::PARAM_STR);
		}
		$query->execute();
		$result = $query->fetchAll();

		/**gallery_part2**/

	    if (empty($result)) {
	    	$content = [
	        	'status' => 'error404',
	        ];
	            return ($content); 
		}

		$content = [
	    	'content'		=> $result[0],
		];
		return ($content);
	}