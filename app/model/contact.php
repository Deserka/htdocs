<?php
class contactModel extends Model {
	function contact() {
		$query=$this->pdo->prepare("
			SELECT
			contact_id as id,
			contact_title as title,
			contact_url as url,
			contact_hide as hide,
			contact_lang as lang,
			contact_viewers as viewers,
			contact_queue as queue,
			contact_created_date as date,
			contact_created_by as created_by,
			contact_last_modified_date as last_modified_date,
			contact_last_modified_by as modified_by
			FROM contact
			WHERE contact_lang = :lang 
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
	    	'content'		=> $result[0],
		];
		return ($content);
	}
}