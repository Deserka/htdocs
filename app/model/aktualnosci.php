<?php
class aktualnosciModel extends Model {
	function aktualnosciList($pageNumber=NULL) {
		include($_SERVER['DOCUMENT_ROOT'].'/config/page_config.php');
		$limit = $configuration['aktualnosci_list_elements_amount'];
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
			aktualnosc_id as id,
			aktualnosc_title as title,
			aktualnosc_url as url,
			aktualnosc_hide as hide,
			aktualnosc_lang as lang,
			aktualnosc_viewers as viewers,
			aktualnosc_queue as queue,
			aktualnosc_created_date as date,
			aktualnosc_created_by as created_by
			FROM aktualnosci
			WHERE aktualnosc_lang = :lang && aktualnosc_hide = 0
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
	function aktualnosciOne($id, $url) {
		if ($id !== NULL && $url !== NULL) {
			$where = ' && aktualnosc_id = :id && aktualnosc_url = :url';
		} elseif ($id !== NULL) {
			$where = ' && aktualnosc_id = :id';
		} else {
			$where = ' && aktualnosc_url = :url';
		}
		$query=$this->pdo->prepare("
			SELECT
			aktualnosc_id as id,
			aktualnosc_title as title,
			aktualnosc_url as url,
			aktualnosc_hide as hide,
			aktualnosc_lang as lang,
			aktualnosc_viewers as viewers,
			aktualnosc_queue as queue,
			aktualnosc_created_date as date,
			aktualnosc_created_by as created_by,
			aktualnosc_last_modified_date as last_modified_date,
			aktualnosc_last_modified_by as modified_by
			FROM aktualnosci
			WHERE aktualnosc_lang = :lang " . $where . "
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
}