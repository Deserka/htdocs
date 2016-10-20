<?php

class cms_cmsModel extends Model{

 function sitemap(){
     if(!file_exists('sitemap.xml')){
         $exist = false;
         $count = '';
         
     }
     else {
         $exist = true;
         $sitemap = file_get_contents('sitemap.xml');
         $count = substr_count($sitemap, '<loc>');        
     }
          
     $content = 
     [
        'exist' => $exist,
        'urls' => $count,
        
     ];
     
     return $content;
 }


 function generateSitemap(){
     
     function parseHomepage($homeUrl) {
                // Get content from URL
                //$cont = file_get_contents('http://'.$_SERVER['HTTP_HOST']);
                $ch = curl_init('http://'.$_SERVER['HTTP_HOST']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
                $cont = curl_exec($ch);
                curl_close($ch);                
                // Take only body element
                $body = preg_match('/<body>(.*?)<\/body>/s', $cont, $matches);
                // Find all <a href="">
                if (isset($matches[1])) {
                    preg_match_all('/href="(.*?)"/s', $matches[1], $hrefsMain);
                    $hrefsMain = array_filter($hrefsMain[1]);
                } else {
                    $hrefsMain = [];
                }
                // Array with URLs
                $hrefsMain = array_unique($hrefsMain);  
                // Add new URL for homepage
                $hrefsMain[] = '/';
                // Generate errors array 
                $errors['site'] = [];
                $errors['url'] = [];
                //CHeck if status is 200 - if not go to errors
                foreach ($hrefsMain as $url) {
                    $head = get_headers('http://'.$_SERVER['HTTP_HOST'].$url);
                    if ($head[0] === 'HTTP/1.1 200 OK') {
                        $rightUrls[] = 'http://'.$_SERVER['HTTP_HOST'].$url;
                    } else {
                        $errors['site'][] = 'http://'.$_SERVER['HTTP_HOST'];
                        $errors['url'][] = 'http://'.$_SERVER['HTTP_HOST'].$url;
                    }                      
                }
                $urlsChecked[] = 'http://'.$_SERVER['HTTP_HOST'];
                return array($rightUrls, $errors, $urlsChecked);
     }
     // $urls = array - list of urls
     // $errors - array with site and error url
     function parsePage($urls, $errors, $checked) {
         $checker = $urls;
         foreach ($urls as $url) {
             // If URL direct to anchor
             if (strpos($url, '#') !== false) {
                $url = substr($url, 0, strpos($url, "#"));
             }
             // If URL was already viited by this robot
            if (in_array($url, $errors['url'], true) || in_array($url, $checked, true)) {
                
            }     
            // Do your job      
            else {
            	$checked[] = $url;
                
                // Get content of URL
                //$cont = file_get_contents($url);
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
                $cont = curl_exec($ch);
                curl_close($ch);                
                // Take only body element
                $body = preg_match('/<body>(.*?)<\/body>/s', $cont, $matches);
                // Find all <a href="">
                if(isset($matches[1])){
                    preg_match_all('/href="(.*?)"/s', $matches[1], $hrefs);
                    $hrefs = array_filter($hrefs[1]);
                }                
                else{
                    $hrefs = [];
                }
                // Array with URLs from page
                $hrefs = array_unique($hrefs);    
                // Check if URL already exist in error or was already checked
                foreach($hrefs as $h){
                     // If URL direct to anchor
                     if (strpos($h, '#') !== false)
                     {
                        $url = substr($h, 0, strpos($h, "#"));
                     }                    
                    // CHeck header for future ELSEIF
                    $head = get_headers('http://'.$_SERVER['HTTP_HOST'].$h);
                    if($head[0] === 'HTTP/1.1 200 OK'){
                        $isok = true;
                    }
                    else {
                        $isok = false;
                    }                      
                    
                    // If true - do nothing
                    if(in_array('http://'.$_SERVER['HTTP_HOST'].$h, $errors['url'], true) || in_array('http://'.$_SERVER['HTTP_HOST'].$h, $checked, true)){
                    }
                    // Save it in errors cause header is not 200 OK
                    elseif($isok === false){
                        $errors['site'][] = 'http://'.$_SERVER['HTTP_HOST'].$url;
                        $errors['url'][] = 'http://'.$_SERVER['HTTP_HOST'].$h;                       
                    }
                    else {
                        $urls[] = 'http://'.$_SERVER['HTTP_HOST'].$h;
                    }
                }           
            }                        
         }
        if($checker === $urls){
            $urls = array_unique($urls);
            $urls = array_unique($urls);
            return array($urls, $errors, $checked);
        }
        else {
            return (parsePage($urls, $errors, $checked));
        }
            
     }
     
     
     $homepage = parseHomepage('http://'.$_SERVER['HTTP_HOST']);
     
     
     $urls = $homepage[0];
     
     $errors = $homepage[1];
     $checked = $homepage[2];
     
  
     
     $all = parsePage($urls, $errors, $checked);

    
    $forMap = $all[2];

// Generate sitemap

        file_put_contents("sitemap.xml", "");
        
        $start = '<?xml version="1.0" encoding="UTF-8"?>'."\r\n".'<?xml-stylesheet type="text/css" href="public/stylesheets/xml.css" ?>'."\r\n".'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\r\n".'<!-- '.count($forMap).' pages --> '."\r\n";
        file_put_contents("sitemap.xml", $start, FILE_APPEND);
         
        foreach($forMap as $s)
        {
            file_put_contents("sitemap.xml", "<url>\r\n    <loc>".$s."</loc>\r\n</url>\r\n", FILE_APPEND);
        }  
        
        $end =  '</urlset> <!-- '.count($forMap).' pages --> ';
        file_put_contents("sitemap.xml", $end, FILE_APPEND);     
        
        $_SESSION['sitemap'] = $all[1];   
        header('Location: /cms-sitemap');
        exit;
     
 }


function login($data) {
	if (empty($data['login']) && empty($data['password'])) {
		$is_ok = 0;
		$warning = 'Wpisz login i hasło.';
		return array($is_ok, $warning);
		exit;
	} elseif(empty($data['login'])) {
		$is_ok = 0;
		$warning = 'Nie wpisano loginu.';
		return array($is_ok, $warning);
		exit;			
	} elseif(empty($data['password'])) {
		$is_ok = 0;
		$warning = 'Nie wpisano hasła.';
		return array($is_ok, $warning);
		exit;			
	}
	//check login	
	$query = $this -> pdo -> prepare ("SELECT user_id FROM users WHERE login = :login ");
	$query->bindValue(':login', $data['login'], PDO::PARAM_STR);
	$query->execute();			
	$is_login = $query->fetchAll();	
	if (empty($is_login)) {
		$warning = 'Błędny login lub hasło!';
		$is_ok = 0;
		return array($is_ok, $warning, $data);
		exit;
	}			
	//check password
	$query = $this -> pdo -> prepare ("SELECT user_id, login, pass, user_log_in, user_lang FROM users WHERE login = :login ");
	$query->bindValue(':login', $data['login'], PDO::PARAM_STR);
	$query->execute();			
	$pas = $query->fetchAll();	
	$is = password_verify($data['password'], $pas[0]['pass']);
	if ($is === false) {
		$warning = 'Błędny login lub hasło!';
		$is_ok = 0;
		return array($is_ok, $warning, $data);
		exit;
	}
	$ins=$this->pdo->prepare("UPDATE users
								SET user_last_log_in = :date, user_log_in = NOW()
								WHERE user_id = :idek ");
	$ins->bindValue(':date', $pas[0]['user_log_in'], PDO::PARAM_STR);
	$ins->bindValue(':idek', $pas[0]['user_id'], PDO::PARAM_STR);
	$ins->execute();
	return array(1, $pas[0]['user_id'], $pas[0]['login'], $pas[0]['user_lang']);
}




/*
 * ###################################################################################### LANGUAGES #################################################################################################
 * */

public function editing_lang_change() 
{
		$langs = $_POST['lang'];
		$_SESSION['editing_lang'] = $langs;
		echo json_encode('ok');
	
	
}

public function cms_lang_change($data) 
{
		$lang = $data['cms_lang'];
		$_SESSION['cms_lang'] = $lang;
		echo json_encode('ok');
	
	
}




}



?>