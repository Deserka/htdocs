<?php

class cms_cmshomepageModel extends Model{



public function homepageEdit() 
{
        
        $query=$this->pdo->prepare("SELECT * FROM homepage WHERE homepage_lang = :lang");
            $query->bindValue(':lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
        $query->execute();  
        
        $result = $query->fetchAll();
        
        $inputs = 
        [
            /* ALL */
            'id'                => $result[0]['homepage_id'],
            'title'             => $result[0]['homepage_title'],
            'content'           => $result[0]['homepage_content'],
            'gallery'           => $result[0]['homepage_show_gallery'],
            'img'               => $result[0]['homepage_img'],
            'image_title'       => $result[0]['homepage_img_title'],
            'image_file_name'   => $result[0]['homepage_img_file_name'],
            'image_alt'         => $result[0]['homepage_alt'],
            'lang'              => $result[0]['homepage_lang'],
            'gallery'           => $result[0]['homepage_gallery'],
                  
            /* META TAGS */
            'meta_title'         => $result[0]['homepage_meta_title'],
            'meta_keywords'      => $result[0]['homepage_keywords'],
            'meta_description'   => $result[0]['homepage_description'],
            'meta_author'        => $result[0]['homepage_author'],
            'meta_robots'        => $result[0]['homepage_robots'],            
        ];
        
        $content = 
        [
            'inputs' => $inputs
        ];           

    
                return $content;
}
 


public function homepageInsert()
{
    include('config/configuration.php');
/*
 * INPUTS VALIDATION -------------------------------------------------------------------------       
*/  
    $inputs = $_POST;
    // Validate title - required
    if(empty($_POST['title']))
    {
        $errors[] = 'Wpisz tytuł';
    }  
    
/*
 * IMAGE VALIDATION -------------------------------------------------------------------------       
*/    
    // If image is for uplaod - validate it
    if(!empty($_FILES["image"]["tmp_name"]))
    {
        // If it is edit - delete current image from server and from database
        if(!empty($inputs['id']))
        {
            if(file_exists($inputs['current_img']))
            {
                unlink($inputs['current_img']);
                $userChangedImage = 1;
            } 
            
            $ins=$this->pdo->prepare('UPDATE `homepage` SET homepage_img = "" WHERE homepage_id = :this_id ');
                 $ins->bindValue(':this_id', $inputs['id'], PDO::PARAM_STR);      
            $ins->execute();               
            
        }
        // If image is changed - delete temporary image
        if($inputs['temp_image'] === '1' OR $inputs['temp_image'] === 1)
        {
            if(is_file($inputs['temp_image_path']))
            {
                unlink($inputs['temp_image_path']);
            }            
        }
        
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $tempImage = explode(".", $_FILES["image"]["name"]);
        $extension = end($tempImage);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES["image"]["tmp_name"]);  
        $imageDimension = getimagesize($_FILES["image"]["tmp_name"]);
        $imageWidth = $image_info[0];
        $imageHeight = $image_info[1];        
        
        if ( ($mime !== "image/gif") && ($mime !== "image/jpeg") && ($mime !== "image/pjpeg") && ($mime !== "image/x-png") && ($mime !== "image/png"))
        {
            $errors[] = 'Błędny format zdjęcia. (dostępne: jpg, jpeg, png, gif)';
        }      
        elseif(!in_array(strtolower($extension), $allowedExts))
        {
            $errors[] = 'Błędny format zdjęcia. (dostępne: jpg, jpeg, png, gif)2';
        }       
        elseif($_FILES["image"]["size"] > $configuration['pages_max_size'])
        {
            $errors[] = 'Rozmiar zdjęcia jest za duży. (max. '.($configuration['homepage_max_size']/1000000).'mb - '.($configuration['homapegemax_size']/100000).'kb)';
        } 
        elseif($imageWidth > $configuration['pages_max_width'])
        {
            $errors[] = 'Obrazek jest za szeroki. (max. '.$configuration['pages_max_width'].'px)';
        }
        elseif($imageHeight > $configuration['pages_max_height'])
        {
             $errors[] = 'Obrazek jest za wysoki. (max. '.$configuration['pages_max_height'].'px)';
        }   
        else
        {
            // Create temporary name for image
            $name =  uniqid().'.'.$extension;
            // Upload temporary image
            move_uploaded_file($_FILES["image"]["tmp_name"], 'public/images/uploads/homepage/temp/'.$name);
            
            // Delete files from temp if last mod of file is further than 24h
                    // Get all files from temp
                    $files = glob('public/images/uploads/homepage/temp/*'); 
                    foreach($files as $file)
                    { 
                      if(is_file($file))
                        if((time() - filemtime($file)) > 86400)
                        {
                            unlink($file);
                        }
                    } 
            // Save that temp imae was created
            $inputs['temp_image'] = 1; 
            $inputs['temp_image_path'] = 'public/images/uploads/homepage/temp/'.$name;                                      
        }     
            
    }
    // If image exist as temporary file
    elseif($inputs['temp_image'] === 1)
    {
        $inputs['temp_image'] = 1; 
        $inputs['temp_image_path'] = $inputs['temp_image_path'];         
    }

/*
 * CHECK IF ERRRORS EXIST -------------------------------------------------------------------------       
*/ 
    if(!empty($errors))
    {
        $return = 
        [
            'status' => 'error',
            'errors' => $errors,
            'inputs' => $inputs
        ];
        return $return;
    }
    
/*
 * VALIDATION IS OK - START ADDING TO DATEBASE -------------------------------------------------------------------------       
*/     
    function checkName($path)
    {
        if(is_file($path))
        {
            $exp = explode('.', $path);
            $path = str_replace('.'.end($exp), rand(0, 100).'.'.end($exp) , $path);
            return checkName($path);
        }
        else {
            return $path;
        }
    }
    
    // Image - Image was uploaded - Create image from temporary file
    if($inputs['temp_image'] === '1' OR $inputs['temp_image'] === 1)
    {
        // Get extension for image name
        $explodeImageName = explode(".", $inputs['temp_image_path']);
        $extension = end($explodeImageName);        
        // Create name for image     
        if(!empty($inputs['image_file_name']))   
        {
            $tempImageName = $inputs['image_file_name'];
        }
        elseif(!empty($inputs['image_alt']))
        {
            $tempImageName = $inputs['image_alt'];
        }
        elseif(!empty($inputs['title']))
        {
            $tempImageName = $inputs['title'];
        }        
        // Replace unwanted characters
        $tempImageName = mb_strtolower($tempImageName, 'UTF-8');
            $notAllowedCharacters = array(" ", "ą", "ć", "ę", "ó", "ł", "ń", "ż", "ź", "ś",
                            "?", "!", ".", ",", ":", ";", "!", "@", "#", "$", "%", "^", "*", "(", ")", "+","=", "<", ">", "~", "`", "/", "\\", "{", "}", "[", "]", '\'', '"', "|");                       
            $substitutes = array("-", "a", "c", "e", "o", "l", "n", "z", "z", "s",
                            "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "");
        $imageName = str_replace($notAllowedCharacters, $substitutes, $tempImageName);      
        // Path + name
        // If user changed image - we have to add something to name because cache will remember old photo
        if($userChangedImage === 1)
        {
            $forNameAdd = rand(2, 100);    
        }
        else {
            $forNameAdd = '';
        }
                
        $newPath = "public/images/uploads/homepage/main/" . $imageName.$forNameAdd.'.'.$extension;  
        $newPath = checkName($newPath);
        
        // Dimension of required main image for page
        $requiredWidth = $configuration['homepage_required_width'];
        $requiredHeight = $configuration['homepage_required_height'];
        list($width, $height) = getimagesize($inputs['temp_image_path']);
       
        // If original image is smaller than required - upload original image as main image
        if($width <= $requiredWidth && $height <= $requiredHeight)
        {
            // Upload original image
            copy($inputs['temp_image_path'], $newPath);
            // Unlink temporary image
            if(is_file($inputs['temp_image_path']))
            {
                unlink($inputs['temp_image_path']);
            }
        }    
        else 
        {
            
            // If width is bigger than height -> resize by width
            if($width > $height)
            {
                $percent = $requiredHeight/$height;
            }
            // Else resize by height
            elseif($width < $height)
            {
                $percent = $requiredWidth/$width;
            }   
            
            // Size of new image
            $mainImageWidth = round($width * $percent);
            $mainImageHeight = round($height * $percent);            
            
            // Rezize image
            $tempImageForResize = imagecreatetruecolor($mainImageWidth, $mainImageHeight);    
            $tempImageFromOriginalImage = imagecreatefromjpeg($inputs['temp_image_path']);
            imagecopyresampled($tempImageForResize, $tempImageFromOriginalImage, 0, 0, 0, 0, $mainImageWidth, $mainImageHeight, $width, $height);  

            if($mainImageWidth > $requiredWidth || $mainImageHeight > $requiredHeight)
            {
                // Cut image
                if($mainImageWidth > $mainImageHeight)
                {
                    $cutX = ($mainImageWidth/2)-($requiredWidth/2);
                    $cutY = 0;                      
                }
                else 
                {
                    $cutX = 0;
                    $cutY = ($mainImageHeight/2)-($requiredHeight/2); 
                }      
                $totalCut = imagecreatetruecolor($requiredWidth, $requiredHeight);     
                imagecopyresampled($totalCut, $tempImageForResize, 0, 0, $cutX, $cutY, $requiredWidth, $requiredHeight, $requiredWidth, $requiredHeight);  
                imagejpeg($totalCut, $newPath , 100);
                if(is_file($inputs['temp_image_path']))
                {
                    unlink($inputs['temp_image_path']);
                }                          
            }
            else 
            {
                imagejpeg($tempImageForResize, $newPath , 100);
                if(is_file($inputs['temp_image_path']))
                {
                    unlink($inputs['temp_image_path']);
                }                
            }                     
        }   
  

        
   
    
    } // End ogf if image was uploaded
    
    
        // Url - Create URL based on title
        $url = mb_strtolower($inputs['title'], 'UTF-8');
            $notAllowedCharacters = array(" ", "ą", "ć", "ę", "ó", "ł", "ń", "ż", "ź", "ś",
                            "?", "!", ".", ",", ":", ";", "!", "@", "#", "$", "%", "^", "*", "(", ")", "+","=", "<", ">", "~", "`", "/", "\\", "{", "}", "[", "]", '\'', '"', "|");                       
            $substitutes = array("-", "a", "c", "e", "o", "l", "n", "z", "z", "s",
                            "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "");
        $url = str_replace($notAllowedCharacters, $substitutes, $url);   
        
        

if(empty($inputs['id']))    
{
    /*
        if(empty($newPath))
        $newPath = '';  
            
                $ins=$this->pdo->prepare('INSERT INTO 
                                            pages 
                                            (page_url, page_title, page_meta_title, page_keywords, page_description, page_author, page_robots, 
                                            page_content,
                                            page_img, page_alt, page_img_title, page_img_file_name, page_hide, page_gallery, page_lang) 
                                            VALUES 
                                            (:page_url, :page_title, :page_meta_title, :page_keywords, :page_description, :page_author, :page_robots, 
                                            :page_content,
                                            :page_img, :page_alt, :page_img_title, :page_img_file_name, :page_hide, :page_gallery, :page_lang) 
                                            ');      
                                            
                        $ins->bindValue(':page_url', $url, PDO::PARAM_STR);  
                        $ins->bindValue(':page_title', $inputs['title'], PDO::PARAM_STR);
                        
                        $ins->bindValue(':page_meta_title', $inputs['meta_title'], PDO::PARAM_STR);
                        $ins->bindValue(':page_keywords', $inputs['meta_keywords'], PDO::PARAM_STR);
                        $ins->bindValue(':page_description', $inputs['meta_description'], PDO::PARAM_STR);
                        $ins->bindValue(':page_author', $inputs['meta_author'], PDO::PARAM_STR);
                        $ins->bindValue(':page_robots', $inputs['meta_robots'], PDO::PARAM_STR);
                        
                        $ins->bindValue(':page_content', $inputs['content'], PDO::PARAM_STR);                    
                        
                        $ins->bindValue(':page_img', $newPath, PDO::PARAM_STR);
                        $ins->bindValue(':page_alt', $inputs['image_alt'], PDO::PARAM_STR);
                        $ins->bindValue(':page_img_title', $inputs['image_title'], PDO::PARAM_STR);
                        $ins->bindValue(':page_img_file_name', $inputs['image_file_name'], PDO::PARAM_STR);
                        $ins->bindValue(':page_hide', $inputs['hide'], PDO::PARAM_STR);
                        $ins->bindValue(':page_gallery', $inputs['gallery'], PDO::PARAM_STR);
                        $ins->bindValue(':page_lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
                        $ins->bindValue(':page_queue', 0, PDO::PARAM_STR);
                        
                $ins->execute();     
                
        $return = 
        [
            'status' => 'added',
        ];
        return $return;       
     */         
}

else 
{

        if(!empty($newPath))
        {
            $newPath = $newPath;  
        }
        elseif(!empty($inputs['current_img']))
        {
            $newPath = $inputs['current_img']; 
            
            // Image exist and it isn't changed - we have to check if name is ok

            
                // Get extension for image name
                $explodeImageName = explode(".", $inputs['current_img']);
                $extension = end($explodeImageName);        
                // Create name for image                            
                if(!empty($inputs['image_file_name']))   
                {
                    $tempImageName = $inputs['image_file_name'];
                }
                elseif(!empty($inputs['image_alt']))
                {
                    $tempImageName = $inputs['image_alt'];
                }
                elseif(!empty($inputs['title']))
                {
                    $tempImageName = $inputs['title'];
                }        
                // Replace unwanted characters
                $tempImageName = mb_strtolower($tempImageName, 'UTF-8');
                    $notAllowedCharacters = array(" ", "ą", "ć", "ę", "ó", "ł", "ń", "ż", "ź", "ś",
                                    "?", "!", ".", ",", ":", ";", "!", "@", "#", "$", "%", "^", "*", "(", ")", "+","=", "<", ">", "~", "`", "/", "\\", "{", "}", "[", "]", '\'', '"', "|");                       
                    $substitutes = array("-", "a", "c", "e", "o", "l", "n", "z", "z", "s",
                                    "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "");
                $imageName = str_replace($notAllowedCharacters, $substitutes, $tempImageName);     
                
                $nams = explode('/', $inputs['current_img']);
                $nams2 = explode('.', end($nams));
                $no_numbers1 = preg_replace('/[0-9]+/', '', reset($nams2));
                $no_numbers2 = preg_replace('/[0-9]+/', '', $imageName);
                

                
                if ($no_numbers1 === $no_numbers2) 
                {
                    
                }
                else 
                {
                    $newPath = "public/images/uploads/homepage/main/" . $imageName.'.'.$extension;  
                    $newPath = checkName($newPath);   
                     
                    // Copy file with new name
                    copy($inputs['current_img'], $newPath);
                    // Unlink image with wrong name
                    if(is_file($inputs['current_img']))
                    {
                        unlink($inputs['current_img']);
                    }                    
                         
                }
                    
            
        }    
        else
        {
            $newPath = ''; 
        }
        
        

                $ins=$this->pdo->prepare('UPDATE homepage
                                            SET 
                                            homepage_title = :homepage_title, 
                                            homepage_meta_title = :homepage_meta_title, homepage_keywords = :homepage_keywords, homepage_description = :homepage_description, homepage_author = :homepage_author, 
                                            homepage_robots = :homepage_robots, 
                                            homepage_content = :homepage_content,
                                            homepage_img = :homepage_img, homepage_alt = :homepage_alt, homepage_img_title = :homepage_img_title, homepage_img_file_name = :homepage_img_file_name, 
                                            homepage_gallery = :homepage_gallery, homepage_lang = :homepage_lang
                                            WHERE
                                            homepage_id = :homepage_id

                                            ');      
                        
                        $ins->bindValue(':homepage_id', $inputs['id'], PDO::PARAM_STR);                      
                        $ins->bindValue(':homepage_title', $inputs['title'], PDO::PARAM_STR);
                        
                        $ins->bindValue(':homepage_meta_title', $inputs['meta_title'], PDO::PARAM_STR);
                        $ins->bindValue(':homepage_keywords', $inputs['meta_keywords'], PDO::PARAM_STR);
                        $ins->bindValue(':homepage_description', $inputs['meta_description'], PDO::PARAM_STR);
                        $ins->bindValue(':homepage_author', $inputs['meta_author'], PDO::PARAM_STR);
                        $ins->bindValue(':homepage_robots', $inputs['meta_robots'], PDO::PARAM_STR);
                        
                        $ins->bindValue(':homepage_content', $inputs['content'], PDO::PARAM_STR);
                        
                        $ins->bindValue(':homepage_img', $newPath, PDO::PARAM_STR);
                        $ins->bindValue(':homepage_alt', $inputs['image_alt'], PDO::PARAM_STR);
                        $ins->bindValue(':homepage_img_title', $inputs['image_title'], PDO::PARAM_STR);
                        $ins->bindValue(':homepage_img_file_name', $inputs['image_file_name'], PDO::PARAM_STR);
                        $ins->bindValue(':homepage_gallery', $inputs['show_gallery'], PDO::PARAM_STR);
                        $ins->bindValue(':homepage_lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
                        
                $ins->execute();      
                
                
        $return = 
        [
            'status' => 'saved',
            'id'     => $inputs['id']
        ];
        return $return;                  
    
    }
  
 
}

public function pageEditGallery($id) 
{
        $query=$this->pdo->prepare("SELECT pimg_id as id, pimg_title as title, pimg_url_cmsthumb as cmsthumb, pimg_url as url  
                                    FROM pages_images WHERE pimg_page_id = '$id'
                                    ORDER BY pimg_queue ASC ,  pimg_id DESC
                                        ");
        $query->execute();      
        $result = $query->fetchAll();
        $images = $result;
        
        $query2=$this->pdo->prepare("SELECT page_title  FROM pages WHERE page_id = :idek  ");
        $query2->bindValue(':idek', $id, PDO::PARAM_STR);                                
        $query2->execute();      
        $result2 = $query2->fetchAll();    

            
    $return = 
    [
        'id' => $id,
        'page_title' => $result2[0]['page_title'],
        'images' => $images
    ];
    
    return $return;
}

public function pageEditGalleryInsertImage()
{
    $inputs = $_POST;
    $id = $_POST['page_id'];

    include('config/configuration.php');
     
    if(!empty($_FILES['image']['name']))
    {
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $tempImage = explode(".", $_FILES["image"]["name"]);
        $extension = end($tempImage);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES["image"]["tmp_name"]);  
        $imageDimension = getimagesize($_FILES["image"]["tmp_name"]);
        $imageWidth = $image_info[0];
        $imageHeight = $image_info[1];   
    }    
    
    if(empty($_FILES['image']['name']))
    {
        $errors[] = 'Wybierz zdjęcie';  
    }
     
        
        elseif ( ($mime !== "image/gif") && ($mime !== "image/jpeg") && ($mime !== "image/pjpeg") && ($mime !== "image/x-png") && ($mime !== "image/png"))
        {
            $errors[] = 'Błędny format zdjęcia. (dostępne: jpg, jpeg, png, gif)';
        }      
        elseif(!in_array(strtolower($extension), $allowedExts))
        {
            $errors[] = 'Błędny format zdjęcia. (dostępne: jpg, jpeg, png, gif)2';
        }       
        elseif($_FILES["image"]["size"] > $configuration['pages_max_size'])
        {
            $errors[] = 'Rozmiar zdjęcia jest za duży. (max. '.($configuration['pages_gallery_max_size']/1000000).'mb - '.($configuration['pages_gallery_max_size']/1000).'kb)';
        } 
        elseif($imageWidth > $configuration['pages_max_width'])
        {
            $errors[] = 'Obrazek jest za szeroki. (max. '.$configuration['pages_gallery_max_width'].'px)';
        }
        elseif($imageHeight > $configuration['pages_max_height'])
        {
             $errors[] = 'Obrazek jest za wysoki. (max. '.$configuration['pages_gallery_max_height'].'px)';
        }    
    
        if(!empty($errors))
        {
        $return = 
        [
            'id' => $id,
            'inputs' => $_POST,
            'errors' => $errors,
            'status' => 'error'
        ];       
        return $return;      
        }
            
    function checkName($path)
    {
        if(is_file($path))
        {
            $exp = explode('.', $path);
            $path = str_replace('.'.end($exp), rand(0, 100).'.'.end($exp) , $path);
            return checkName($path);
        }
        else {
            return $path;
        }
    }
    
    // Create name of image
    if(!empty($_POST ["image_file_name"]))
    {
        $tempImageName = $_POST ["image_file_name"];
    }
    elseif(!empty($_POST["image_meta_description"]))
    {
        $tempImageName = $_POST ["image_meta_description"];
    }
    elseif(!empty($_POST["image_title"]))
    {
        $tempImageName = $_POST ["image_title"];
    }    
    else {
        $tempImageName = uniqid();
    }
                $tempImageName = mb_strtolower($tempImageName, 'UTF-8');
                    $notAllowedCharacters = array(" ", "ą", "ć", "ę", "ó", "ł", "ń", "ż", "ź", "ś",
                                    "?", "!", ".", ",", ":", ";", "!", "@", "#", "$", "%", "^", "*", "(", ")", "+","=", "<", ">", "~", "`", "/", "\\", "{", "}", "[", "]", '\'', '"', "|");                       
                    $substitutes = array("-", "a", "c", "e", "o", "l", "n", "z", "z", "s",
                                    "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "");
                $imageName = str_replace($notAllowedCharacters, $substitutes, $tempImageName);     
    
    $imageName = $imageName.'.'.$extension;   
    
    $path = "public/images/uploads/pages/galleries/original/".$imageName;
    $path = checkName($path);  
    
    $uh = explode('/', $path);
    $imageName = end($uh);
    
            // Upload temporary image
            move_uploaded_file($_FILES["image"]["tmp_name"], $path);    


        list($imageWidth, $imageHeight) = getimagesize($path);
                         
/*
 *    ADD THUMB FOR CMS         
*/             


        $requiredWidth = 200;
        $requiredHeight = 150;
        $newPath = "public/images/uploads/pages/galleries/cms_thumb/".$imageName;
        // If original image is smaller than required - upload original image as main image
        if($imageWidth <= $requiredWidth && $imageHeight <= $requiredHeight)
        {
            // Upload thumb from original file
            copy($path, $newPath);
        }    
        else 
        {       
            // If width is bigger than height -> resize by width
            if($imageWidth > $imageHeight)
            {
                $percent = $requiredHeight/$imageHeight;
            }
            // Else resize by height
            elseif($imageWidth <= $imageHeight)
            {
                $percent = $requiredWidth/$imageWidth;
            }         

            // Size of new image
            $mainImageWidth = round($imageWidth * $percent);
            $mainImageHeight = round($imageHeight * $percent);    
                              
            // Rezize image
            $tempImageForResize = imagecreatetruecolor($mainImageWidth, $mainImageHeight);    
            $tempImageFromOriginalImage = imagecreatefromjpeg($path);
            imagecopyresampled($tempImageForResize, $tempImageFromOriginalImage, 0, 0, 0, 0, $mainImageWidth, $mainImageHeight, $imageWidth, $imageHeight);  

            if($mainImageWidth > $requiredWidth || $mainImageHeight > $requiredHeight)
            {
                // Cut image
                if($mainImageWidth > $mainImageHeight)
                {
                    $cutX = ($mainImageWidth/2)-($requiredWidth/2);
                    $cutY = 0;                      
                }
                else 
                {
                    $cutX = 0;
                    $cutY = ($mainImageHeight/2)-($requiredHeight/2); 
                }      
                $totalCut = imagecreatetruecolor($requiredWidth, $requiredHeight);     
                imagecopyresampled($totalCut, $tempImageForResize, 0, 0, $cutX, $cutY, $requiredWidth, $requiredHeight, $requiredWidth, $requiredHeight);  
                imagejpeg($totalCut, $newPath , 100);                        
            }
            else 
            {
                imagejpeg($tempImageForResize, $newPath , 100);             
            }                     
        }

/*
 *    ADD THUMB FOR WEBSITE       
*/             

        $requiredWidth = $configuration['pages_gallery_thumb_width'];
        $requiredHeight = $configuration['pages_gallery_thumb_height'];
        $newPath2 = "public/images/uploads/pages/galleries/page_thumb/".$imageName;
        // If original image is smaller than required - upload original image as main image
        if($imageWidth <= $requiredWidth && $imageHeight <= $requiredHeight)
        {
            // Upload thumb from original file
            copy($path, $newPath2);
        }    
        else 
        {       
            // If width is bigger than height -> resize by width
            if($imageWidth > $imageHeight)
            {
                $percent = $requiredHeight/$imageHeight;
            }
            // Else resize by height
            elseif($imageWidth <= $imageHeight)
            {
                $percent = $requiredWidth/$imageWidth;
            }         

            // Size of new image
            $mainImageWidth = round($imageWidth * $percent);
            $mainImageHeight = round($imageHeight * $percent);    
                              
            // Rezize image
            $tempImageForResize = imagecreatetruecolor($mainImageWidth, $mainImageHeight);    
            $tempImageFromOriginalImage = imagecreatefromjpeg($path);
            imagecopyresampled($tempImageForResize, $tempImageFromOriginalImage, 0, 0, 0, 0, $mainImageWidth, $mainImageHeight, $imageWidth, $imageHeight);  

            if($mainImageWidth > $requiredWidth || $mainImageHeight > $requiredHeight)
            {
                // Cut image
                if($mainImageWidth > $mainImageHeight)
                {
                    $cutX = ($mainImageWidth/2)-($requiredWidth/2);
                    $cutY = 0;                      
                }
                else 
                {
                    $cutX = 0;
                    $cutY = ($mainImageHeight/2)-($requiredHeight/2); 
                }      
                $totalCut = imagecreatetruecolor($requiredWidth, $requiredHeight);     
                imagecopyresampled($totalCut, $tempImageForResize, 0, 0, $cutX, $cutY, $requiredWidth, $requiredHeight, $requiredWidth, $requiredHeight);  
                imagejpeg($totalCut, $newPath2 , 100);                        
            }
            else 
            {
                imagejpeg($tempImageForResize, $newPath2 , 100);             
            }                     
        }


                $ins=$this->pdo->prepare('INSERT INTO 
                                            pages_images 
                                            (pimg_page_id, pimg_url, pimg_url_pagethumb, pimg_url_cmsthumb, pimg_title, pimg_content, pimg_meta_title, pimg_alt, pimg_file_name, pimg_date, pimg_queue) 
                                            VALUES 
                                            (:pimg_page_id, :pimg_url, :pimg_url_pagethumb, :pimg_url_cmsthumb, :pimg_title, :pimg_content, :pimg_meta_title, :pimg_alt, :pimg_file_name, NOW(), :pimg_queue) 
                                            ');      
                                            
                        $ins->bindValue(':pimg_page_id', $id, PDO::PARAM_STR);  
                        $ins->bindValue(':pimg_url', $path, PDO::PARAM_STR); 
                        $ins->bindValue(':pimg_url_pagethumb', $newPath2, PDO::PARAM_STR); 
                        $ins->bindValue(':pimg_url_cmsthumb', $newPath, PDO::PARAM_STR);              
                        $ins->bindValue(':pimg_title', $inputs['image_title'], PDO::PARAM_STR);
                        $ins->bindValue(':pimg_content', $inputs['image_description'], PDO::PARAM_STR);
                        $ins->bindValue(':pimg_meta_title', $inputs['image_meta_title'], PDO::PARAM_STR);
                        $ins->bindValue(':pimg_alt', $inputs['image_meta_description'], PDO::PARAM_STR);
                        $ins->bindValue(':pimg_file_name', $inputs['image_file_name'], PDO::PARAM_STR);
                        $ins->bindValue(':pimg_queue', 0, PDO::PARAM_STR);
                        
                $ins->execute();   

        $return = 
        [
            'status' => 'added',
            'id'     => $id
        ];
        return $return;   
}


function pageEditGalleryDeleteImage($id)
{
        $query=$this->pdo->prepare("SELECT  pimg_url_cmsthumb as cmsthumb, pimg_url as url, pimg_url_pagethumb as pagethumb  FROM pages_images WHERE pimg_id = :id ");
            $query->bindValue(':id', $id, PDO::PARAM_STR);
        $query->execute();      
        $result = $query->fetchAll();      
        
        if(file_exists($result[0]['cmsthumb']))
        {
            unlink($result[0]['cmsthumb']);
        }
        if(file_exists($result[0]['url']))
        {
            unlink($result[0]['url']);
        }
        if(file_exists($result[0]['pagethumb']))
        {
            unlink($result[0]['pagethumb']);
        }               
    
                $ins=$this->pdo->prepare('DELETE FROM pages_images WHERE pimg_id = :id ');      
                $ins->bindValue(':id', $id, PDO::PARAM_STR);
                $ins->execute(); 
                
         $return = 
         [
            'status' => 'deleted',
         ];
         return $return;
}




function pageEditGalleryEditImage()
{
       $idek = $_POST['idek'];
            $query=$this->pdo->prepare( "SELECT pimg_title, pimg_content, pimg_meta_title, pimg_alt, pimg_file_name, pimg_url_cmsthumb                              
                                          FROM pages_images
                                          WHERE pimg_id = $idek
                                            ");                                                               
            $query->execute();  
            $result = $query->fetchAll();   
            
        $content = 
        [
            'id'            => $idek,
            'title'        => $result[0]['pimg_title'],
            'content'     => $result[0]['pimg_content'],
            'meta_title'   => $result[0]['pimg_meta_title'],
            'alt'           => $result[0]['pimg_alt'],
            'file_name'    => $result[0]['pimg_file_name'],   
            'cmsthumb'      => $result[0]['pimg_url_cmsthumb'],        
        ];            
            
            echo json_encode($content);
            
}

function pageEditGalleryEditImageUpdate()
{
            
            $query=$this->pdo->prepare( "SELECT pimg_file_name , pimg_url, pimg_url_pagethumb, pimg_url_cmsthumb
                                        FROM pages_images
                                          WHERE pimg_id = :idek  ");  
            $query->bindValue(':idek', $_POST['edit-id'], PDO::PARAM_STR);                                                                                           
            $query->execute();  
            $result = $query->fetchAll();  
     
            
            if($result[0]['pimg_file_name'] !== $_POST['edit-file-name'])
            {
                
                function checkName($name)
                {
                    if(is_file('public/images/uploads/pages/galleries/original/'.$name))
                    {
                        $exp = explode('.', $name);
                        $name = str_replace('.'.end($exp), rand(0, 100).'.'.end($exp) , $name);
                        return checkName($name);
                    }
                    else {
                        return $name;
                    }
                }                
                
                // Replace unwanted characters
                $tempImageName = mb_strtolower($_POST['edit-file-name'], 'UTF-8');
                    $notAllowedCharacters = array(" ", "ą", "ć", "ę", "ó", "ł", "ń", "ż", "ź", "ś",
                                    "?", "!", ".", ",", ":", ";", "!", "@", "#", "$", "%", "^", "*", "(", ")", "+","=", "<", ">", "~", "`", "/", "\\", "{", "}", "[", "]", '\'', '"', "|");                       
                    $substitutes = array("-", "a", "c", "e", "o", "l", "n", "z", "z", "s",
                                    "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "");
                $imageName = str_replace($notAllowedCharacters, $substitutes, $tempImageName);   
                
                     $ext = explode('.', $result[0]['pimg_url']);
                     $ext = end($ext);                
                
                $original = 'public/images/uploads/pages/galleries/original/'.$imageName.'.'.$ext;
                
                $cmsthumb = 'public/images/uploads/pages/galleries/cms_thumb/'.$imageName.'.'.$ext;
                
                $pagethumb = 'public/images/uploads/pages/galleries/page_thumb/'.$imageName.'.'.$ext;
                
                    $imageName = checkName($imageName);  
                    

                    
                    // Original photo
                    copy($result[0]['pimg_url'], $original);
                    
                    copy($result[0]['pimg_url_pagethumb'], $pagethumb);
                    
                    copy($result[0]['pimg_url_cmsthumb'], $cmsthumb);
                    
                    if(file_exists($result[0]['pimg_url']))
                    {
                        unlink($result[0]['pimg_url']);
                    }
                    if(file_exists($result[0]['pimg_url_pagethumb']))
                    {
                        unlink($result[0]['pimg_url_pagethumb']);
                    }                   
                    if(file_exists($result[0]['pimg_url_cmsthumb']))
                    {
                        unlink($result[0]['pimg_url_cmsthumb']);
                    }                    
                    
                $ins=$this->pdo->prepare('UPDATE pages_images
                                            SET pimg_url = :url, pimg_url_pagethumb = :pagethumb, pimg_url_cmsthumb = :cmsthumb
                                                                                      
                                            WHERE
                                            pimg_id = :idek');      
                        
                        $ins->bindValue(':url', $original, PDO::PARAM_STR);                      
                        $ins->bindValue(':pagethumb', $pagethumb, PDO::PARAM_STR);  
                        $ins->bindValue(':cmsthumb', $cmsthumb, PDO::PARAM_STR);    
                        $ins->bindValue(':idek', $_POST['edit-id'], PDO::PARAM_STR);
                        
                $ins->execute();                       
  
            }
    
                $ins=$this->pdo->prepare('UPDATE pages_images
                                            SET 
                                            pimg_title = :title, pimg_content = :content, pimg_meta_title = :meta_title, pimg_alt = :alt, pimg_file_name = :file_name                                           
                                            WHERE
                                            pimg_id = :idek');      
                        
                        $ins->bindValue(':title', $_POST['edit-title'], PDO::PARAM_STR);                      
                        $ins->bindValue(':content', $_POST['edit-description'], PDO::PARAM_STR);  
                        $ins->bindValue(':meta_title', $_POST['edit-meta-title'], PDO::PARAM_STR);    
                        $ins->bindValue(':alt', $_POST['edit-meta-description'], PDO::PARAM_STR);
                        $ins->bindValue(':file_name', $_POST['edit-file-name'], PDO::PARAM_STR);
                        $ins->bindValue(':idek', $_POST['edit-id'], PDO::PARAM_STR);
                        
                $ins->execute();      
}

function pageEditGalleryEditImagesQueue()
{
    $x = 1;
    foreach($_POST['idek'] as $id)
    {
                $ins=$this->pdo->prepare('UPDATE pages_images
                                            SET 
                                            pimg_queue = :queue                                        
                                            WHERE
                                            pimg_id = :idek');      
                        
                        $ins->bindValue(':queue', $x, PDO::PARAM_STR);                      
                        $ins->bindValue(':idek', $id, PDO::PARAM_STR);
                        
                $ins->execute();     
                
         $x++;    
    }

    
}

function pageEditQueue()
{
    $x = 1;
    foreach($_POST['idek'] as $id)
    {
                $ins=$this->pdo->prepare('UPDATE pages
                                            SET 
                                            page_queue = :queue                                        
                                            WHERE
                                            page_id = :idek');      
                        
                        $ins->bindValue(':queue', $x, PDO::PARAM_STR);                      
                        $ins->bindValue(':idek', $id, PDO::PARAM_STR);
                        
                $ins->execute();     
                
         $x++;    
    }    
}







    





}



?>