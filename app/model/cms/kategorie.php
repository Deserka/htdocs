<?php
class cms_kategorieModel extends Model {
public function kategorie() {
		$query= $this->pdo->prepare('SELECT kategoria_id as id, kategoria_title as title, kategoria_url as url
									  FROM kategorie 
		                              WHERE kategoria_lang = :lang 
		                              ORDER BY kategoria_queue ASC ,  kategoria_id DESC');
		$query->bindValue(':lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
		$query->execute();	
		$result = $query->fetchAll();
        $content = [
        	'list' => $result,
        ];
		return $content;
}
public function kategorieAdd() {	
        $content = [
        ];
         return $content;
}
public function kategorieInsert() {
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
/* <!-- type2 part 1 */
if (empty( $inputs['id'])) {
	$ins = $this ->pdo ->prepare( 'UPDATE kategorie
									SET 
                                   kategoria_queue = kategoria_queue + 1
                                 ');
	$ins->execute();
    $ins = $this -> pdo -> prepare(' INSERT INTO 
                                            kategorie 
                                            (kategoria_url, kategoria_title, kategoria_created_date, kategoria_created_by, 
                                            kategoria_lang, kategoria_queue, kategoria_hide
/* <!-- meta_tags part 3 */
, kategoria_meta_title, kategoria_meta_keywords, kategoria_meta_description, kategoria_meta_author, kategoria_meta_robots
											) 
                                            VALUES 
                                            ( :kategoria_url, :kategoria_title, NOW(), :kategoria_created_by, :kategoria_lang, :kategoria_queue, :kategoria_hide  
/* <!-- meta_tags part 4 */
, :kategoria_meta_title, :kategoria_meta_keywords, :kategoria_meta_description, :kategoria_meta_author, :kategoria_meta_robots
                                            ) 											
                                     ');   
                        $ins->bindValue(':kategoria_url', $url, PDO::PARAM_STR);  
                        $ins->bindValue(':kategoria_title', $inputs['title'], PDO::PARAM_STR);
                        $ins->bindValue(':kategoria_lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
						$ins->bindValue(':kategoria_queue', 0, PDO::PARAM_STR);
						$ins->bindValue(':kategoria_hide', $inputs['hide'], PDO::PARAM_STR);
						$ins->bindValue(':kategoria_created_by', $_SESSION['login'], PDO::PARAM_STR);
/* <!-- meta_tags part 2 */
$ins->bindValue(":kategoria_meta_title", $inputs["meta_title"], PDO::PARAM_STR);
$ins->bindValue(":kategoria_meta_keywords", $inputs["meta_keywords"], PDO::PARAM_STR);
$ins->bindValue(":kategoria_meta_description", $inputs["meta_description"], PDO::PARAM_STR);
$ins->bindValue(":kategoria_meta_author", $inputs["meta_author"], PDO::PARAM_STR);
$ins->bindValue(":kategoria_meta_robots", $inputs["meta_robots"], PDO::PARAM_STR);
/* --> meta_tags part 2 */
                $ins->execute(); 
/*tags1_part4*/
        $return = [
            'status' => 'added',
        ];
        return $return;
} else {
/* --> end type2 part 1 */
                $ins= $this->pdo->prepare('UPDATE kategorie
                                            SET 											
                                            kategoria_url = :kategoria_url, kategoria_title = :kategoria_title, 
                                            kategoria_lang = :kategoria_lang, kategoria_hide = :kategoria_hide,
                                            kategoria_last_modified_date = NOW(), kategoria_last_modified_by = :kategoria_last_modified_by                                         
/* <!-- meta_tags part 1 */
, kategoria_meta_title = :kategoria_meta_title,
kategoria_meta_keywords = :kategoria_meta_keywords,
kategoria_meta_description = :kategoria_meta_description,
kategoria_meta_author = :kategoria_meta_author,
kategoria_meta_robots = :kategoria_meta_robots
/* --> End meta_tags part 1 */
                                            WHERE
                                            kategoria_lang = :kategoria_lang 
/* <1!-- type2 part 3 */
&& kategoria_id = :kategoria_id
/* <1!-- type2 part 3 */
                                            ');
/* <1!-- type2 part 3 */
$ins->bindValue(':kategoria_id', $inputs['id'], PDO::PARAM_STR);
/* <1!-- type2 part 3 */
                        $ins->bindValue(':kategoria_url', $url, PDO::PARAM_STR);
                        $ins->bindValue(':kategoria_title', $inputs['title'], PDO::PARAM_STR);
                        $ins->bindValue(':kategoria_lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
						$ins->bindValue(':kategoria_hide', $inputs['hide'], PDO::PARAM_STR);
						$ins->bindValue(':kategoria_last_modified_by', $_SESSION['login'], PDO::PARAM_STR);	
/* <!-- meta_tags part 2 */
$ins->bindValue(":kategoria_meta_title", $inputs["meta_title"], PDO::PARAM_STR);
$ins->bindValue(":kategoria_meta_keywords", $inputs["meta_keywords"], PDO::PARAM_STR);
$ins->bindValue(":kategoria_meta_description", $inputs["meta_description"], PDO::PARAM_STR);
$ins->bindValue(":kategoria_meta_author", $inputs["meta_author"], PDO::PARAM_STR);
$ins->bindValue(":kategoria_meta_robots", $inputs["meta_robots"], PDO::PARAM_STR);
/* --> meta_tags part 2 */
                $ins->execute();    
/* <1!-- type2 part 2 */
}
/* <1!-- type2 part 2 */
        $return =  [
            'status' => 'saved',
            'id'     => $inputs['id']
        ];
        return $return;
}
public function kategorieEdit($id) {
        // Select main part
        $query= $this->pdo->prepare(' SELECT * FROM kategorie WHERE kategoria_lang = :lang && kategoria_id = :id');
		$query->bindValue(':lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
$query->bindValue(':id', $id, PDO::PARAM_STR);
        $query->execute();  
        $result = $query->fetchAll();       	
        $inputs = 
        [
'id'                => $result[0]['kategoria_id'],
            'title'             => $result[0]['kategoria_title'],
            'hide'              => $result[0]['kategoria_hide'],
            'lang'              => $result[0]['kategoria_lang'],
/* meta_tags_part1 */
"meta_title"    	 => $result[0]["kategoria_meta_title"],
"meta_keywords"      => $result[0]["kategoria_meta_keywords"],
"meta_description"   => $result[0]["kategoria_meta_description"],
"meta_author"        => $result[0]["kategoria_meta_author"],
"meta_robots"        => $result[0]["kategoria_meta_robots"],
/* End meta_tags_part1 */
        ];
        $content = 
        [
            'inputs' => $inputs,
        ];
            return $content;
}
function kategorieDelete($id) {
                $ins= $this-> pdo-> prepare( 'DELETE FROM kategorie WHERE kategoria_id = :id ' );      
                $ins -> bindValue(':id', $id, PDO::PARAM_STR);
                $ins -> execute();
}
 function kategorieQueue() {
    $x = 1;
    foreach ($_POST['idek'] as $id) {
                $ins= $this->pdo->prepare('UPDATE kategorie
                                            SET 
                                            kategoria_queue = :queue                                        
                                            WHERE
                                            kategoria_id = :idek');
                        $ins->bindValue(':queue', $x, PDO::PARAM_STR);
                        $ins->bindValue(':idek', $id, PDO::PARAM_STR);
                $ins->execute();
         $x++;
    }    
}
}