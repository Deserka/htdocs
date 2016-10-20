<?php class a{
public function _CREATED_MODEL_NAME_Edit(/**_IDS_**/) {
        // Select main part
        $query= $this->pdo->prepare(' SELECT * FROM _CREATED_TABLE_NAME_ WHERE _CREATED_TABLE_PREFIX__lang = :lang /**type2_part1**/');
		$query->bindValue(':lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
/**type2_part2**/
        $query->execute();  
        $result = $query->fetchAll();       	
/**tags1_part1**/
        $inputs = 
        [
/**type2_part3**/
            'title'             => $result[0]['_CREATED_TABLE_PREFIX__title'],
            'hide'              => $result[0]['_CREATED_TABLE_PREFIX__hide'],
            'lang'              => $result[0]['_CREATED_TABLE_PREFIX__lang'],
/**own_columns_part1**/
/**meta_tags_part1**/         
/**tags1_part2**/
/**images_part1**/
/**gallery_part1**/           			            
        ];
/**type3_part1**/
        $content = 
        [
            'inputs' => $inputs,
/**type3_part2**/
        ];
            return $content;
}
}/*delete*/