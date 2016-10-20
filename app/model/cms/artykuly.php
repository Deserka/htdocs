<?php
class cms_artykulyModel extends Model {
public function artykuly() {
		$query= $this->pdo->prepare('SELECT artykul_id as id, artykul_title as title, artykul_url as url
									  FROM artykuly 
		                              WHERE artykul_lang = :lang 
		                              ORDER BY artykul_queue ASC ,  artykul_id DESC');
		$query->bindValue(':lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
		$query->execute();	
		$result = $query->fetchAll();
        $content = [
        	'list' => $result,                    
        ];
		return $content;
}
public function artykulyAdd() {	
	if( !isset($errors) ){
			$errors = '';
		}
        $content = 
        [
            'errors' => $errors
        ];         
         return $content;
}
public function artykulyInsert() {
    include('config/configuration.php');
	include('creator/repo/allowed_characters/arrays.php');
	    $inputs = $_POST;
		$errors = [];
// INPUTS VALIDATION -------------------------------------------------------------------------            
    // Validate title - required
    if (empty( $_POST['title'])) {
        $errors[] = 'Wpisz tytuł';
    }  
// CHECK IF ERRRORS EXIST -------------------------------------------------------------------------       
    if (!empty( $errors )) {
        $return = [
            'status' => 'error',
            'errors' => $errors,
            'inputs' => $inputs,
        ];
        return $return;
    }  
        // Url - Create URL based on title
        $url = mb_strtolower( $inputs['title'], 'UTF-8' );        
        $url = str_replace( $notAllowedCharacters, $substitutes, $url );   
                $ins= $this->pdo->prepare('UPDATE artykuly
                                            SET 											
                                            artykul_url = :artykul_url, artykul_title = :artykul_title, 
                                            artykul_lang = :artykul_lang, artykul_hide = :artykul_hide,
                                            artykul_last_modified_date = NOW(), artykul_last_modified_by = :artykul_last_modified_by                                         
/* <!-- meta_tags part 1 */
, artykul_meta_title = :artykul_meta_title,
artykul_meta_keywords = :artykul_meta_keywords,
artykul_meta_description = :artykul_meta_description,
artykul_meta_author = :artykul_meta_author,
artykul_meta_robots = :artykul_meta_robots
/* --> End meta_tags part 1 */
                                            WHERE
                                            artykul_lang = :artykul_lang 
                                            ');
                        $ins->bindValue(':artykul_url', $url, PDO::PARAM_STR);
                        $ins->bindValue(':artykul_title', $inputs['title'], PDO::PARAM_STR);
                        $ins->bindValue(':artykul_lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
						$ins->bindValue(':artykul_hide', $inputs['hide'], PDO::PARAM_STR);
						$ins->bindValue(':artykul_last_modified_by', $_SESSION['login'], PDO::PARAM_STR);	
/* <!-- meta_tags part 2 */
$ins->bindValue(":artykul_meta_title", $inputs["meta_title"], PDO::PARAM_STR);
$ins->bindValue(":artykul_meta_keywords", $inputs["meta_keywords"], PDO::PARAM_STR);
$ins->bindValue(":artykul_meta_description", $inputs["meta_description"], PDO::PARAM_STR);
$ins->bindValue(":artykul_meta_author", $inputs["meta_author"], PDO::PARAM_STR);
$ins->bindValue(":artykul_meta_robots", $inputs["meta_robots"], PDO::PARAM_STR);
/* --> meta_tags part 2 */
                $ins->execute();    
        $return =  [
            'status' => 'saved',
            'id'     => $inputs['id']
        ];
        return $return;
}
public function artykulyEdit($parent_id, $id) {
        // Select main part
        $query= $this->pdo->prepare(' SELECT * FROM artykuly WHERE artykul_lang = :lang ');
		$query->bindValue(':lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
        $query->execute();  
        $result = $query->fetchAll();       	
        $inputs = 
        [
            'title'             => $result[0]['artykul_title'],
            'hide'              => $result[0]['artykul_hide'],
            'lang'              => $result[0]['artykul_lang'],
/* meta_tags_part1 */
"meta_title"    	 => $result[0]["artykul_meta_title"],
"meta_keywords"      => $result[0]["artykul_meta_keywords"],
"meta_description"   => $result[0]["artykul_meta_description"],
"meta_author"        => $result[0]["artykul_meta_author"],
"meta_robots"        => $result[0]["artykul_meta_robots"],
/* End meta_tags_part1 */
        ];
        $content = 
        [
            'inputs' => $inputs,
        ];           
            return $content;
}
function artykulyDelete($parent_id, $id) {
                $ins= $this-> pdo-> prepare( 'DELETE FROM artykuly WHERE artykul_id = :id ' );      
                $ins -> bindValue(':id', $id, PDO::PARAM_STR);
                $ins -> execute();
}
 function artykulyQueue() {
    $x = 1;
    foreach ($_POST['idek'] as $id) {
                $ins= $this->pdo->prepare('UPDATE artykuly
                                            SET 
                                            artykul_queue = :queue                                        
                                            WHERE
                                            artykul_id = :idek');
                        $ins->bindValue(':queue', $x, PDO::PARAM_STR);
                        $ins->bindValue(':idek', $id, PDO::PARAM_STR);
                $ins->execute();
         $x++;
    }    
}
}