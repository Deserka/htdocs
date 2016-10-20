<?php
class _PAGE_MODEL_NAME_Model extends Model {

	public function _PAGE_MODEL_NAME_() {

			$query=$this->pdo->prepare( "SELECT * FROM _PAGE_TABLE_NAME_ WHERE _PAGE_TABLE_PREFIX__lang = :lang ");
	            $query->bindValue(':lang', $_SESSION['page_lang'], PDO::PARAM_STR);			
			$query->execute();	
			$result = $query->fetchAll();

	        if(empty($result))
	        {
	            $content = 
	            [
	                'status' => 'error404',
	            ];
	            return ($content); 
	        }

/*_PAGE_MODEL_GALLERY_1_*/
			
	        $content = 
	        [
	            /* ALL */
	            'title'     => $result[0]['_PAGE_TABLE_PREFIX__title'],
	            'viewers'     => $result[0]['_PAGE_TABLE_PREFIX__viewers'],
/*_PAGE_MODEL_OWN_COLUMNS_*/
/*_PAGE_MODEL_META_TAGS_*/
/*_PAGE_MODEL_IMAGE_*/
/*_PAGE_MODEL_GALLERY_2_*/
	        ];
				return ($content);		
	}
		
}