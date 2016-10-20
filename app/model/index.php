<?php


class IndexModel extends Model{

 
 
/*
 * ###################################################################################### ALL #################################################################################################
 * */
 

public function all() {
 	
        require 'config/configuration.php';
        
/* 
* NEWWEST ARTS
*/ 
        if($configuration['newest_articles'] > 0)
        {
            $query=$this->pdo->prepare( "SELECT arts_id, arts_url, arts_title, 
                                          DATE_FORMAT(arts_date, '".$configuration['date_format']."') as dater                                  
                                          FROM arts
                                          ORDER BY arts_id DESC LIMIT 0, ".$configuration['newest_articles']." ");                                                               
            $query->execute();  
            $newest_articles = $query->fetchAll();            
        }

/* 
* NEWWEST COMMENTS
*/           
        if($configuration['newest_comments'] > 0)
        {         
            $query=$this->pdo->prepare( "SELECT com_id, com_url, com_author, com_content, com_date, art_id as idek, 
                                          DATE_FORMAT(com_date, '".$configuration['date_format']."') as dater
                                          FROM comments
                                          LEFT JOIN articles  ON art_url = com_url
                                          ORDER BY com_id DESC LIMIT 0, ".$configuration['newest_comments']." ");
            $query->execute();  
            $newest_comments = $query->fetchAll();              
        }  		
		
/* 
* NEWEST TITBIT
*/
		if($configuration['newest_titbits'] > 0)
		{  
            $query=$this->pdo->prepare( "SELECT * FROM titbits LIMIT 0, ".$configuration['newest_titbits']." ");
            $query->execute();  
            $newest_titbits = $query->fetchAll();  		    
		}
        
/* 
* NEWEST NEWS 
*/
        if($configuration['newest_news'] > 0)
        {     
            $query=$this->pdo->prepare( "SELECT news_id, news_url, news_title, news_img, news_alt,  
                                          DATE_FORMAT(news_date, '".$configuration['date_format']."') as dater 
                                          FROM news ORDER BY news_id 
                                          DESC LIMIT 0, ".$configuration['newest_news']." ");
            $query->execute();  
            $newest_news= $query->fetchAll();              
        }  
              
/* 
* MOST RED ARTICLES
*/
		if($configuration['most_red_articles'] > 0)
        {
            $query=$this->pdo->prepare( "SELECT art_id, art_url, art_title, art_viewers, art_content, art_img, art_alt,  
                                           DATE_FORMAT(art_date, '".$configuration['date_format']."') as dater   
                                           FROM articles 
                                           ORDER BY art_viewers 
                                           DESC LIMIT 0, ".$configuration['most_red_articles']." ");
            $query->execute();  
            $most_red_articles = $query->fetchAll();             
        }
	
/* 
* ALL CATEGORIES if not empty
*/		
        if($configuration['all_categories'] > 0)
        {
            $query=$this->pdo->prepare( "SELECT artscats_id, artscats_url, artscats_title FROM artscats");
            $query->execute();  
            $cats = $query->fetchAll();
            
            if(!empty($cats))
            {
                foreach($cats as $c)
                {
                    $idek = $c['artscats_id'];
                    $query=$this->pdo->prepare("SELECT COUNT(arts_id)  FROM arts WHERE arts_cat_id = $idek");
                    $query->execute();  
                    $idks = $query->fetchAll();
                        if($idks[0][0] != 0)
                        {
                            $oneCat = 
                            [
                                'cat_id' => $c['artscats_id'],
                                'cat_url' => $c['artscats_url'],
                                'cat_title' => $c['artscats_title'],
                            ];
                            
                            $all_categories[] = $oneCat;
                           
                        }
                }
            }            
        }

/* 
* ALL SUBCATEGORIES if not empty
*/          
        if($configuration['all_subcategories'] > 0)
        {
            $query=$this->pdo->prepare( "SELECT subcat_id, subcat_url, subcat_name, subcat_cat_id FROM articles_subcategories");
            $query->execute();  
            $subcats = $query->fetchAll();
            
            if(!empty($subcats))
            {
                foreach($subcats as $c)
                {
                    $idek = $c['subcat_id'];
                    $query=$this->pdo->prepare("SELECT COUNT(art_id)  FROM articles WHERE art_subcat_id = $idek");
                    $query->execute();  
                    $idks = $query->fetchAll();
                        if($idks[0][0] != 0)
                        {
                            $all_subcategories[] = $c;
                        }
                }
            }            
        }

/* 
* ALL TAGS if not empty
*/          
        if($configuration['all_tags'] > 0)
        {
            $query=$this->pdo->prepare( "SELECT tag_id, tag_name, tag_url FROM tags");
            $query->execute();  
            $tags = $query->fetchAll();               
            if(!empty($tags))
            {
                foreach($tags as $t)
                {
                    $idek = $t['tag_id'];
                    $query=$this->pdo->prepare("SELECT COUNT(tacon_art_id) FROM articles_tags_connection WHERE tacon_tag_id = $idek");
                    $query->execute();  
                    $idks = $query->fetchAll();
                        if($idks[0][0] != 0)
                        {
                            $all_tags[] = $t;
                        }
                }
            }                    
        }

        
/* 
* RETURN
*/ 

$return = 
[
    'newest_articles'       => $newest_articles,
    'newest_comments'       => $newest_comments,
    'newest_titbits'        => $newest_titbits,
    'newest_news'           => $newest_news,
    'most_red_articles'     => $most_red_articles,
    'all_categories'        => $all_categories,
    'all_subcategories'     => $all_subcategories,
    'all_tags'              => $all_tags
    
];
			
				return $return;	

}
 

 
 /*
 * ###################################################################################### SEARCHER #################################################################################################
 * */


public function search($get) {
  			$keyword = $get['keyword'];
  		
		//ARTICLES
		$query=$this->pdo->prepare( "SELECT art_id, title, art_url  FROM articles WHERE title = :keyword OR title LIKE :keyword1 OR title LIKE :keyword2 OR title LIKE :keyword3  ");
		$query -> bindValue(':keyword', $keyword, PDO::PARAM_STR);
		$query -> bindValue(':keyword1', '%'.$keyword, PDO::PARAM_STR);
		$query -> bindValue(':keyword2', $keyword.'%', PDO::PARAM_STR);
		$query -> bindValue(':keyword3', '%'.$keyword.'%', PDO::PARAM_STR);
		$query->execute();	
		$articles[] = $query->fetchAll();	
		
		
		foreach($articles[0] as $a)
		{
			$arts[] = '<a class="one-s" href="/art-'.$a['art_url'].'-'.$a['art_id'].'"><div class="one-d">'.$a['title'].'</div><div>Artykuły</div></a><hr class="one-hr">';
		}  	
		
  		return array($arts);
  
  } 

  
  
  
  
  
  

/*
 * ###################################################################################### PAGES #################################################################################################
 * */
 /**
	 * HOMEPAGE
	 */			
public function homepage() {
    /* CONTENT */
		$query=$this->pdo->prepare( "SELECT * FROM pages_homepage WHERE main_lang = :lang ");
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
       
        
// Depends on configuration:                      
        require 'config/configuration.php';
        
/* 
* NEWWEST ARTS
*/ 
        if($configuration['home_newest_articles'] > 0)
        {           
            $query=$this->pdo->prepare( "SELECT arts_id, arts_url, arts_title, arts_img, arts_alt, arts_img_title, 
                                          DATE_FORMAT(arts_date, '".$configuration['date_format']."') as dater                                  
                                          FROM arts
                                          ORDER BY arts_id DESC LIMIT 0, ".$configuration['home_newest_articles']."" );                                                             
            $query->execute();                         
            $newest_articles = $query->fetchAll(); 
            if(!empty($newest_articles))
            {
                foreach($newest_articles as $a)
                {
                    $oneArt = 
                    [
                        'id'        => $a['arts_id'],
                        'url'       => $a['arts_url'],
                        'title'     => $a['arts_title'],
                        'img'      => $a['arts_img'],
                        'alt'      => $a['arts_alt'],
                        'img_title' => $a['arts_img_title'],
                        'date'      => $a['dater'],
                        
                    ]; 
                               
                    $arts[] = $oneArt;                      
                }
                $newest_articles = $arts;
           
            }   
            else {
                $newest_articles = '';
            }         
        }


/* 
* NEWWEST COMMENTS
*/           
        if($configuration['home_newest_comments'] > 0)
        {         
            $query=$this->pdo->prepare( "SELECT com_id, com_url, com_author, com_content, com_date, art_id as idek, 
                                          DATE_FORMAT(com_date, '".$configuration['date_format']."') as dater
                                          FROM comments
                                          LEFT JOIN articles  ON art_url = com_url
                                          ORDER BY com_id DESC LIMIT 0, ".$configuration['home_newest_comments']." ");
            $query->execute();  
            $newest_comments = $query->fetchAll();              
        }       
        
/* 
* NEWEST TITBIT
*/
        if($configuration['home_newest_titbits'] > 0)
        {  
            $query=$this->pdo->prepare( "SELECT * FROM titbits LIMIT 0, ".$configuration['home_newest_titbits']." ");
            $query->execute();  
            $newest_titbits = $query->fetchAll();           
        }
        
/* 
* NEWEST NEWS 
*/
        if($configuration['home_newest_news'] > 0)
        {     
            $query=$this->pdo->prepare( "SELECT news_id, news_url, news_title, news_img, news_alt,  
                                          DATE_FORMAT(news_date, '".$configuration['date_format']."') as dater 
                                          FROM news ORDER BY news_id 
                                          DESC LIMIT 0, ".$configuration['home_newest_news']." ");
            $query->execute();  
            $newest_news= $query->fetchAll();              
        }  
              
/* 
* MOST RED ARTICLES
*/
        if($configuration['home_most_red_articles'] > 0)
        {
            $query=$this->pdo->prepare( "SELECT art_id, art_url, art_title, art_viewers, art_content, art_img, art_alt,  
                                           DATE_FORMAT(art_date, '".$configuration['date_format']."') as dater   
                                           FROM articles 
                                           ORDER BY art_viewers 
                                           DESC LIMIT 0, ".$configuration['home_most_red_articles']." ");
            $query->execute();  
            $most_red_articles = $query->fetchAll();             
        }
    
/* 
* ALL CATEGORIES if not empty
*/      
        if($configuration['home_all_categories'] > 0)
        {
            $query=$this->pdo->prepare( "SELECT artscats_id, artscats_url, artscats_title FROM artscats");
            $query->execute();  
            $cats = $query->fetchAll();
            
            if(!empty($cats))
            {
                foreach($cats as $c)
                {
                    $idek = $c['artscats_id'];
                    $query=$this->pdo->prepare("SELECT COUNT(arts_id)  FROM arts WHERE arts_cat_id = $idek");
                    $query->execute();  
                    $idks = $query->fetchAll();
                        if($idks[0][0] != 0)
                        {
                            $oneCat = 
                            [
                                'cat_id' => $c['artscats_id'],
                                'cat_url' => $c['artscats_url'],
                                'cat_title' => $c['artscats_title'],
                            ];
                            
                            $all_categories[] = $oneCat;
                           
                        }
                }
            }            
        }

/* 
* ALL SUBCATEGORIES if not empty
*/          
        if($configuration['home_all_subcategories'] > 0)
        {
            $query=$this->pdo->prepare( "SELECT subcat_id, subcat_url, subcat_name, subcat_cat_id FROM articles_subcategories");
            $query->execute();  
            $subcats = $query->fetchAll();
            
            if(!empty($subcats))
            {
                foreach($subcats as $c)
                {
                    $idek = $c['subcat_id'];
                    $query=$this->pdo->prepare("SELECT COUNT(art_id)  FROM articles WHERE art_subcat_id = $idek");
                    $query->execute();  
                    $idks = $query->fetchAll();
                        if($idks[0][0] != 0)
                        {
                            $all_subcategories[] = $c;
                        }
                }
            }            
        }

/* 
* ALL TAGS if not empty
*/          
        if($configuration['home_all_tags'] > 0)
        {
            $query=$this->pdo->prepare( "SELECT tag_id, tag_name, tag_url FROM tags");
            $query->execute();  
            $tags = $query->fetchAll();               
            if(!empty($tags))
            {
                foreach($tags as $t)
                {
                    $idek = $t['tag_id'];
                    $query=$this->pdo->prepare("SELECT COUNT(tacon_art_id) FROM articles_tags_connection WHERE tacon_tag_id = $idek");
                    $query->execute();  
                    $idks = $query->fetchAll();
                        if($idks[0][0] != 0)
                        {
                            $all_tags[] = $t;
                        }
                }
            }                    
        }

        
/* 
* RETURN
*/ 


        
        $content = 
        [
            /* ALL */
            'id'        => $result[0]['main_id'],
            'title'     => $result[0]['main_title'],
            'content'   => $result[0]['main_content'],
            'header'    => $result[0]['main_header'],
            'speech'    => $result[0]['main_speech'],
            'hide'      => $result[0]['main_hide'],
            'img'       => $result[0]['main_img'],
            'alt'       => $result[0]['main_alt'],
            'form'      => $result[0]['main_form'],
            'lang'      => $result[0]['main_lang'],
                  
            /* META TAGS */
            'meta_title'    => $result[0]['main_meta_title'],
            'keywords'      => $result[0]['main_keywords'],
            'description'   => $result[0]['main_description'],
            'author'        => $result[0]['main_author'],
            'robots'        => $result[0]['main_robots'],


            'newest_articles'       => $newest_articles,
            'newest_comments'       => $newest_comments,
            'newest_titbits'        => $newest_titbits,
            'newest_news'           => $newest_news,
            'most_red_articles'     => $most_red_articles,
            'all_categories'        => $all_categories,
            'all_subcategories'     => $all_subcategories,
            'all_tags'              => $all_tags,            
            
        ];

    
		
				return ($content);	




}
 /**
	 * ALL PAGES
	 */	
	 
public function pages() 
{
		$query=$this->pdo->prepare( "SELECT page_id, page_link, title FROM `pages` WHERE page_hide = 0");
		$query->execute();	
		$result = $query->fetchAll();
        
		
				return array($result);
}	 
	 
 /**
	 * ONE PAGE
	 */	
public function page($url, $id) 
{
		$query=$this->pdo->prepare( "SELECT * FROM pages WHERE page_url = :url && page_id = :id");
		$query->bindValue(':url', $url, PDO::PARAM_STR);
        $query->bindValue(':id', $id, PDO::PARAM_STR);
		$query->execute();	
		$result = $query->fetchAll();
        
        $content = 
        [
            /* ALL */
            'id'        => $result[0]['page_id'],
            'url'       => $result[0]['page_url'],
            'title'     => $result[0]['page_title'],
            'content'   => $result[0]['page_content'],
            'header'    => $result[0]['page_header'],
            'speech'    => $result[0]['page_speech'],
            'hide'      => $result[0]['page_hide'],
            'img'       => $result[0]['page_img'],
            'img_title' => $result[0]['page_img_title'],
            'alt'       => $result[0]['page_alt'],
            'form'      => $result[0]['page_form'],
            'lang'      => $result[0]['page_lang'],
            'show_gallery'=> $result[0]['page_show_gallery'],
                  
            /* META TAGS */
            'meta_title'    => $result[0]['page_meta_title'],
            'keywords'      => $result[0]['page_keywords'],
            'description'   => $result[0]['page_description'],
            'author'        => $result[0]['page_author'],
            'robots'        => $result[0]['page_robots'],
            

            
        ];        
        
		
		$query=$this->pdo->prepare("UPDATE pages SET page_viewers = page_viewers+1 WHERE page_id = :pid");
		$query->bindValue(':pid', $id, PDO::PARAM_STR);
		$query->execute();		

        
				return array($content);
}

	
    
    
    
    
    
    
    
    
    
    
    
    
    
    
/*
 * ###################################################################################### ARTICLES #################################################################################################
 * */
  /**
	 * ALL ARTICLES
	 */	
public function articles() 
{
		$art=$this->pdo->prepare('SELECT  *, cat_name, cat_url, cat_id 
										FROM articles LEFT JOIN categories  ON a.id_categories = cat_id  ORDER BY art_id DESC');
		$art->execute();
		$result = $art->fetchAll();	
				return array($result);
}

 /**
	 * ONE ARTICLE
	 */	
public function article($data) 
{
			$query = $this -> pdo -> prepare ("SELECT *, DATE_FORMAT(a.date, '%e %c %Y %H %i') as new_date  FROM `articles`  as a
											     LEFT JOIN 
											         categories as c 
											         ON id_categories = cat_id 

											     LEFT JOIN 
											         articles_subcategories as s ON subcat_id = cat_id 																												
											     WHERE 
											         a.art_id = :getname");	
			$query -> bindValue(':getname',$data['a_id'], PDO::PARAM_STR);
			$query ->execute();
			$result = $query->fetchAll();
            
            
			
			$query = $this -> pdo -> prepare ("SELECT tacon_tag_id FROM articles_tags_connection WHERE tacon_art_id = :conn");
				$query -> bindValue(':conn', $result[0]['art_id'], PDO::PARAM_STR);
			$query ->execute();
			$conn = $query->fetchAll();
					
					foreach($conn as $c)
					{
						$query = $this -> pdo -> prepare ("SELECT tag_id, tag_name, tag_url FROM tags WHERE tag_id = :idek");
							$query -> bindValue(':idek', $c['tacon_tag_id'], PDO::PARAM_STR);
						$query ->execute();
						$tags[] = $query->fetchAll();						
					}

			$query=$this->pdo->prepare("UPDATE articles SET art_viewers = art_viewers+1 WHERE art_id = :aid");
			$query->bindValue(':aid',$result[0]['art_id'], PDO::PARAM_STR);
			$query->execute();	

			//previous art
			$query = $this -> pdo -> prepare ("SELECT art_id, art_url, title FROM articles  WHERE art_id < :getname && id_categories = :cat_id ORDER BY art_id DESC LIMIT 1") ;
			$query -> bindValue(':getname',$data['a_id'], PDO::PARAM_STR);
			$query -> bindValue(':cat_id',$result[0]['cat_id'], PDO::PARAM_STR);
			$query ->execute();
			$result2 = $query->fetchAll();
			//next art
			$query = $this -> pdo -> prepare ("SELECT art_id, art_url, title FROM articles  WHERE art_id > :getname  && id_categories = :cat_id ORDER BY art_id ASC LIMIT 1") ;
			$query -> bindValue(':getname',$data['a_id'], PDO::PARAM_STR);
			$query -> bindValue(':cat_id',$result[0]['cat_id'], PDO::PARAM_STR);
			$query ->execute();
			$result3 = $query->fetchAll();			
					 return array($result, $result2, $result3, $tags);
} 
	
/*
 * ###################################################################################### CATEGORIES #################################################################################################
 * */
  /**
	 * ALL CATEGORIES
	 */	

public function categories() 
{
		$query = $this -> pdo -> prepare ("SELECT  * FROM categories ");
		$query->execute();			
		$result = $query->fetchAll();
        		return array($result);
}

  /**
	 * ONE CATEGORIES BY ID
	 */		
function categorie_divided($data)
{
	$id = $data['c_id']; $name = $data['c_name']; $limit = $data['c_limit'] ;


		
		$query = $this -> pdo -> prepare ("SELECT * FROM categories WHERE cat_id = :cat_id"); //cat name
		$query->bindValue(':cat_id',$id, PDO::PARAM_STR);
		$query->execute();			
		$result = $query->fetchAll();	
		
		if($limit <= 0 OR $limit == 1){$limit = 0;}		elseif ($limit > 1){$limit = ($limit - 1) * 10;} 	else{$limit = 1;}
		
		$query = $this -> pdo -> prepare ("SELECT  *, DATE_FORMAT(date, '%e %c %Y %H %i') as new_date FROM articles
											
											WHERE id_categories = :id AND art_hide = 0 ORDER BY date DESC  LIMIT $limit, 10 ");
		$query->bindValue(':id',$id, PDO::PARAM_STR);
		$query->execute();			
		$result2[] = $query->fetchAll();		
		//how many for pagination
		$query = $this -> pdo -> prepare ("SELECT  COUNT(art_id) FROM articles WHERE id_categories = :cat_id"); //cat name
		$query->bindValue(':cat_id',$id, PDO::PARAM_STR);
		$query->execute();			
		$result3 = $query->fetchAll();	
		
		//tags
		foreach($result2 as $a)
		{
			//tags names etc
			$query = $this -> pdo -> prepare ("SELECT tacon_tag_id, tag_name, tag_url, tag_id FROM articles_tags_connection 
												LEFT JOIN tags ON tag_id = tacon_tag_id
												WHERE tacon_art_id = :idek ");
			$query->bindValue(':idek',$a[0]['art_id'], PDO::PARAM_STR);
			$query->execute();			
			$tags[] = $query->fetchAll();					
		
		}
		


        		return array($result, $result2, $result3, $tags);
	
}		


function subcategorie_divided($data)
{
	$id = $data['c_id']; $name = $data['c_name']; $limit = $data['c_limit'] ;


		
		$query = $this -> pdo -> prepare ("SELECT * FROM articles_subcategories WHERE subcat_id = :subcat_id"); //cat name
		$query->bindValue(':subcat_id',$id, PDO::PARAM_STR);
		$query->execute();			
		$result = $query->fetchAll();	
		
		if($limit <= 0 OR $limit == 1){$limit = 0;}		elseif ($limit > 1){$limit = ($limit - 1) * 10;} 	else{$limit = 1;}
		
		$query = $this -> pdo -> prepare ("SELECT  *, DATE_FORMAT(date, '%e %c %Y %H %i') as new_date FROM articles
											
											WHERE art_subcat_id = :id AND art_hide = 0 ORDER BY date DESC  LIMIT $limit, 10 ");
		$query->bindValue(':id',$id, PDO::PARAM_STR);
		$query->execute();			
		$result2[] = $query->fetchAll();		
		//how many for pagination
		$query = $this -> pdo -> prepare ("SELECT  COUNT(art_id) FROM articles WHERE art_subcat_id = :subcat_id"); //cat name
		$query->bindValue(':subcat_id',$id, PDO::PARAM_STR);
		$query->execute();			
		$result3 = $query->fetchAll();	
		
		//tags
		foreach($result2 as $a)
		{
			//tags names etc
			$query = $this -> pdo -> prepare ("SELECT tacon_tag_id, tag_name, tag_url, tag_id FROM articles_tags_connection 
												LEFT JOIN tags ON tag_id = tacon_tag_id
												WHERE tacon_art_id = :idek ");
			$query->bindValue(':idek',$a[0]['art_id'], PDO::PARAM_STR);
			$query->execute();			
			$tags[] = $query->fetchAll();					
		
		}
		


        		return array($result, $result2, $result3, $tags);
	
}	
 
 /*
 		$query = $this -> pdo -> prepare ("SELECT
											(SELECT  art_id FROM articles  ORDER BY date  LIMIT 0, 1 
											) AS ab, 
											(
											SELECT  cat_name FROM categories WHERE cat_url = :cat_url LIMIT 0,1
											) AS bb
											");
  * */
 

 /*
 * ###################################################################################### TAGS #################################################################################################
 * */
  /**
	 * SHOW ARTICLES BY ONE TAG
	 */	
	 
function tag_one($data)
{
	$id = $data['idek']; $name = $data['c_name']; $limit = $data['t_limit'] ;
		//name of tag
		$query = $this -> pdo -> prepare ("SELECT  tag_name FROM tags WHERE tag_id = :idek ");
		$query->bindValue(':idek',$id, PDO::PARAM_STR);
		$query->execute();			
		$result = $query->fetchAll();

		
		//id of arts
		$query = $this -> pdo -> prepare ("SELECT tacon_art_id FROM articles_tags_connection WHERE tacon_tag_id = :idek"); 
		$query->bindValue(':idek',$id, PDO::PARAM_STR);
		$query->execute();			
		$conn = $query->fetchAll();		
		//arts
		foreach($conn as $c)
		{
			$query = $this -> pdo -> prepare ("SELECT *, DATE_FORMAT(date, '%e %c %Y %H %i') as new_date, cat_id, cat_name, cat_url 											
												FROM articles 
												LEFT JOIN categories ON id_categories = cat_id 
												WHERE art_id = :idek AND art_hide = 0 "); 
			$query->bindValue(':idek',$c['tacon_art_id'], PDO::PARAM_STR);
			$query->execute();			
			$arts[] = $query->fetchAll();			
		}
	

		if($limit <= 0 OR $limit == 1){$limit = 0;}		elseif ($limit > 1){$limit = ($limit - 1) * 10;} 	else{$limit = 1;}
		
		$arts = array_slice($arts, $limit, 10);
		
		$result2 = $arts;		
		
		//how many articles for pagination
		$result3 = count($arts);
		
		//tags
		foreach($arts as $a)
		{
			//tags ids
			$query = $this -> pdo -> prepare ("SELECT tacon_tag_id, tag_name, tag_url, tag_id FROM articles_tags_connection 
												LEFT JOIN tags ON tag_id = tacon_tag_id
												WHERE tacon_art_id = :idek ");
			$query->bindValue(':idek',$a[0]['art_id'], PDO::PARAM_STR);
			$query->execute();			
			$tags[] = $query->fetchAll();					
		
		}


        		return array($result, $result2, $result3, $tags);
	
}	 
 /*
 * ###################################################################################### NEWS #################################################################################################
 * */
  /**
	 * 10 NEWS
	 */	 
	 
function news_divided($data)
{
 $limit = $data['n_limit'] ;

		if($limit <= 0 OR $limit == 1){$limit = 0;}		elseif ($limit > 1){$limit = ($limit - 1) * 10;} 	else{$limit = 1;}

		$query = $this -> pdo -> prepare ("SELECT  *, DATE_FORMAT(news_date, '%e %c %Y %H %i') as new_date FROM news
											WHERE news_lang = :news_lang AND news_hide = 0 ORDER BY news_date DESC  LIMIT $limit, 10 ");
		$query->bindValue(':news_lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
		$query->execute();			
		$result = $query->fetchAll();	
		return array($result);
 
}
 
public function news_one($data) 
{
		$query = $this -> pdo -> prepare ("SELECT *, DATE_FORMAT(news_date, '%e %c %Y %H %i') as new_date FROM news WHERE news_id = :news_id ");
		$query->bindValue(':news_id',$data['n_id'], PDO::PARAM_STR);
		$query->execute();			
		$result = $query->fetchAll();
		
		$query=$this->pdo->prepare("UPDATE news SET news_viewers = news_viewers+1 WHERE news_id = :nid");
		$query->bindValue(':nid',$result[0]['news_id'], PDO::PARAM_STR);
		$query->execute();	

        		return array($result);
}
 
 
  /*
 * ###################################################################################### COMMENTS #################################################################################################
 * */
   /**
	 * LOAD COMMENTS
	 */	 
 
 public function load_comments($data) 
{
	
		$query = $this -> pdo -> prepare ("SELECT *, DATE_FORMAT(com_date, '%e/%c/%Y %H:%i') as new_date  FROM comments WHERE com_url = :com_url ");
		$query->bindValue(':com_url',$data['patch'], PDO::PARAM_STR);
		$query->execute();			
		$result = $query->fetchAll();
		
		foreach($result as $r){		
			if($r['com_parent'] == NULL){
				$new_result[] = $r;
				$new = $r['com_id'];
				
					foreach($result as $r2){
						if($r2['com_parent'] == $new){
							$new_result[] = $r2;
							$new2 = $r2['com_id'];
							
								foreach($result as $r3){
									if($r3['com_parent'] == $new2){
										$new_result[] = $r3;
										$new3 = $r3['com_id'];
										
											foreach($result as $r4){
												if($r4['com_parent'] == $new3){
													$new_result[] = $r4;
													$new4 = $r4['com_id'];
							
												}
											}
							
									}
								}
						}
					}
			}
		}
		

		echo json_encode($new_result);		
}
	
 
  /**
	 * ADD COMMENT
	 */	 
public function add_comment($data) 
{
    

	
		$data['author'];
		$data['mail'];
		$data['content'];
		$data['captcha'];
		
		// validation
		function checker($author, $mail, $content, $captcha){
					
				if(empty($author) || empty($mail) || empty($content) || empty($captcha))
					$error[] = '<a>Wypełnij wszystkie wymagane pola</a>';	
				
				if(!empty($error))
					return $error;
		
				if(mb_strlen($author, 'UTF-8') > 30)
					$error[] = '<a>! Za długa nazwa !</a>';
				
				if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) 
	 				 $error[] = '<a>Niepoprawny format e-mail</a>';
				
				if(mb_strlen($content, 'UTF-8') < 3)
					$error[] = '<a>! Za krótki komentarz !</a>';
				
	
			  if(!empty($error))
				return $error;	
		  	
			}
		
		$validation = checker($data['author'], $data['mail'], $data['content'], $data['captcha']);

		if (!empty($validation)){
				$end = 'error';
				$errors = array($end, $validation);

				echo json_encode($errors);		
				exit;
			
		}
		
		//captcha validation
		function cap_checker($captcha)
		{ 
	       if($_SESSION['comments_captcha'] != $captcha)
           {
                $number = rand(10000,99999);
                $image = ImageCreate(150, 50) or die("GD?"); //150x50
                $background = ImageColorAllocate($image, 255, 255, 255);
                $grey = imagecolorallocate($image, 128, 128, 128);
                $black = imagecolorallocate($image, 0, 0, 0);
                $font = 'helpers/fonts/snapitc.ttf';
                imagettftext($image, 28, 0, 22, 30, $grey, $font, $number);
                imagettftext($image, 28, 3, 3, 42, $black, $font, $number);
            
                ob_start();
                Imagepng($image);
                $img = ob_get_contents();
                ob_end_clean();
                $base64 = base64_encode($img);
                
                session_start();
                unset($_SESSION['comments_captcha']);
                $_SESSION['comments_captcha'] = $number;
                
                //echo json_encode($base64);  
                return array('invalid_captcha', $base64);                
           }
    	    
   
    /*
                
			$captcha2 = mb_strtolower($captcha, 'UTF-8');
				
			
					switch ($img) {
					    case 1:
					        if($captcha2 != 'v69x3')
								return 'invalid_captcha';
					        break;
					    case 2:
					        if($captcha2 != 'ul961')
								return 'invalid_captcha';
					        break;
					    case 3:
					        if($captcha2 != '97515')
								return 'invalid_captcha';
					        break;
						case 4:
					        if($captcha2 != '162f7')
								return 'invalid_captcha';
					        break;
						case 5:
					        if($captcha2 != '791h4')
								return 'invalid_captcha';
					        break;		
					    
					    default:
								return 'invalid_captcha';
					} 
     */
		
		}
		
		$captcha_validation = cap_checker($data['captcha']);
		
			if ($captcha_validation[0] === 'invalid_captcha'){
				echo json_encode($captcha_validation);		
				exit;
			}
	
		$data['url'];
		$data['idek'];
		$data['parent'];
		$data['children'];

		if($data['idek'] == 'null'){
			$parent = Null;
			$children = 0;
		}
		else{
			$parent = $data['idek'];
			$children = $data['children'] + 1;
		}
		



		//check if it's not spam - how many comments this person added in 5 minutes
		$query = $this -> pdo -> prepare ("SELECT com_id FROM comments WHERE com_author_ip = :com_author_ip && TIMESTAMPDIFF(MINUTE,`com_date`, NOW() ) < 5; ");
		$query->bindValue(':com_author_ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
		$query->execute();			
		$how = $query->fetchAll();	
		$how_much = count($how);
			if($how_much > 5)
			{ //more than 5 comments in 5 minutes
				$show = 'too_much';
				echo json_encode($show);
				exit;
			}
//replace 
if (file_exists('helpers/forbidden_words.php' ))
{
	require_once('helpers/forbidden_words.php');	
	
	$data['content'] = str_replace($forbidden_words, '*****', $data['content']);
	
}		
//send a message with info the comments is added
if (file_exists('config/mail.php' ))
{
	require_once('config/mail.php');		

				
				if(!empty($email_send))
				{
					
					$topic1 = 'Dodano komentarz:';
					$domain_name = $_SERVER["SERVER_NAME"];
					$topic = $topic1.' z '.$domain_name;
					
					$name = '<p>Imię: <b>'.$data['author'].'</b></p>';
					
					$m_topic = '<p>Na stronie: <b>'.$domain_name.$data['uri'].'</b></p>';
					
					$m_mail = '<p>Adres e-mail: <b>'.$data['mail'].'</b></p>';
					
					$message = '<p>Treść:<br />'.nl2br($data['content']).'</p>';
	
					$ip = '<p><br /><pre>Z adresu ip: '.$_SERVER['SERVER_ADDR'].'</pre>';
					$prze = '<pre>Z przeglądarki: '.$_SERVER['HTTP_USER_AGENT'].'</pre></p>';	
									
					foreach($email_send as $mail)
					{
						mail($mail,"=?UTF-8?B?".base64_encode($topic)."?=", $name.$m_topic.$m_mail.$message.$ip.$prze,'From:'.$m_mail."\r\nContent-Type: text/html; charset=utf-8");		
					}
				}
}	
		if(!empty($_SESSION['user_panel_avatar']))
        {
            $image = $_SESSION['user_panel_avatar'];
        }	
        else 
        {
            $image = 'non-logged.png';
        }		
	
		$ins = $this -> pdo ->prepare ("INSERT INTO comments (com_url, com_author, com_author_ip,  com_content, com_date, com_mail, com_parent, com_children, com_img) 
										VALUES 
										(:com_url, :com_author, :com_author_ip, :com_content,  NOW(), :com_mail, :com_parent, :com_children, :com_img) ");
				$ins->bindValue(':com_url', $data['uri'], PDO::PARAM_STR);
				$ins->bindValue(':com_author', $data['author'], PDO::PARAM_STR);
				$ins->bindValue(':com_author_ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
				$ins->bindValue(':com_content', nl2br($data['content']), PDO::PARAM_STR);
				$ins->bindValue(':com_mail', $data['mail'], PDO::PARAM_STR);
				$ins->bindValue(':com_parent', $parent, PDO::PARAM_STR);
				$ins->bindValue(':com_children', $children, PDO::PARAM_STR);
				$ins->bindValue(':com_img', $image, PDO::PARAM_STR);
		$ins->execute();	
		$lastid = $this -> pdo ->lastInsertId();
		$result = array('ok', $lastid);
                        
               
		echo json_encode($result);		 
}



function checkSessionLogin()
{
    if(!empty($_SESSION['user_panel_login']))
    {
        echo json_encode($_SESSION['user_panel_login']);  
    }
    else 
    {
	   echo json_encode('');  
    }
}


function captchaComments()
{
    $number = rand(10000,99999);
    $image = ImageCreate(150, 50) or die("GD?"); //150x50
    $background = ImageColorAllocate($image, 255, 255, 255);
    $grey = imagecolorallocate($image, 128, 128, 128);
    $black = imagecolorallocate($image, 0, 0, 0);
    $font = 'helpers/fonts/snapitc.ttf';
    imagettftext($image, 20, 0, 35, 30, $grey, $font, $number);
    imagettftext($image, 20, 0, 38, 33, $black, $font, $number);

    ob_start();
    Imagepng($image);
    $img = ob_get_contents();
    ob_end_clean();
    $base64 = base64_encode($img);
    
    session_start();
    unset($_SESSION['comments_captcha']);
    $_SESSION['comments_captcha'] = $number;
    
    echo json_encode($base64);  
    return $base64;    
}


 
 /*
 * ###################################################################################### GALLERIES #################################################################################################
 * */
  /**
	 * ONE GALLERY DIVIDED
	 */	
 
 
 function gallery_divided($data){
 		$id = $data['g_id']; $name = $data['g_name']; $limit = $data['g_limit'] ;
		
		$query = $this -> pdo -> prepare ("SELECT * FROM galleries WHERE gals_id = :gals_id"); //cat name
		$query->bindValue(':gals_id',$id, PDO::PARAM_STR);
		$query->execute();			
		$result = $query->fetchAll();		
		
		if($limit <= 0 OR $limit == 1){$limit = 0;}		elseif ($limit > 1){$limit = ($limit - 1) * 10;} 	else{$limit = 1;}
		$query = $this -> pdo -> prepare ("SELECT  *, DATE_FORMAT(gal_date, '%e %m %Y') as new_date FROM gallery
											WHERE gal_gals_id = :id  ORDER BY gal_date DESC  LIMIT $limit, 10 ");
		$query->bindValue(':id',$id, PDO::PARAM_STR);
		$query->execute();			
		$result2 = $query->fetchAll();	

		return array($result, $result2);	
 
 }
 
 
 function gallery_one_image($data){
 		$id = $data['i_id'];  ;
		
		$query = $this -> pdo -> prepare ("SELECT *, DATE_FORMAT(gal_date, '%e %m %Y') as new_date FROM gallery WHERE gal_id = :gal_id"); //cat name
		$query->bindValue(':gal_id',$id, PDO::PARAM_STR);
		$query->execute();			
		$result = $query->fetchAll();		
		
	
		
		$query = $this -> pdo -> prepare ("SELECT gals_name, gals_id, gals_url FROM galleries WHERE gals_id = :gals_id"); //cat name
		$query->bindValue(':gals_id',$result[0]['gal_gals_id'], PDO::PARAM_STR);
		$query->execute();			
		$result2 = $query->fetchAll();

		return array($result, $result2);	
 
 } 
  
  
  
  
  
  }
?>