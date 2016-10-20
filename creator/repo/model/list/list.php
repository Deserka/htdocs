<?php class a{
public function _CREATED_MODEL_NAME_(/**_IDS_**/) {
		$query= $this->pdo->prepare('SELECT _CREATED_TABLE_PREFIX__id as id, _CREATED_TABLE_PREFIX__title as title, _CREATED_TABLE_PREFIX__url as url
									  FROM _CREATED_TABLE_NAME_ 
		                              WHERE _CREATED_TABLE_PREFIX__lang = :lang /**type3_part3**/
		                              ORDER BY _CREATED_TABLE_PREFIX__queue ASC ,  _CREATED_TABLE_PREFIX__id DESC');
		$query->bindValue(':lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
/**type3_part4**/
		$query->execute();	
		$result = $query->fetchAll();
/**type3_part1**/
        $content = [
        	'list' => $result,
/**type3_part2**/
        ];
		return $content;
}
}/*delete*/