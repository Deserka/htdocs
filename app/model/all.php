<?php
class allModel extends Model{
	public function all() {
		$content = [];
/* VIEW_NAME */
            $query=$this->pdo->prepare( "SELECT TABLE_PREFIX_url, TABLE_PREFIX_title                              
                                          FROM TABLE_NAME
                                          WHERE TABLE_PREFIX_lang = :lang ");
			$query->bindValue(':lang', $_SESSION['page_lang'], PDO::PARAM_STR);
            $query->execute();
            $MODEL_NAME = $query->fetchAll();
			$content['MODEL_NAME'] = ['url' => $MODEL_NAME[MODEL_NAME_url], 'title' => $MODEL_NAME[MODEL_NAME_title]];
/* End VIEW_NAME */
/* Kontakt */
            $query=$this->pdo->prepare( "SELECT contact_url, contact_title
                                          FROM contact
                                          WHERE contact_lang = :lang ");
			$query->bindValue(':lang', $_SESSION['page_lang'], PDO::PARAM_STR);
            $query->execute();
            $contact = $query->fetchAll();
			$content['contact'] = ['url' => $contact[contact_url], 'title' => $contact[contact_title]];
/* End Kontakt */
/* Adder */
			return ($content);
	}
}