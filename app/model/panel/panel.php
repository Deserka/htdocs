<?php

class panel_panelModel extends Model{


/*
 * ###################################################################################### LOGIN #################################################################################################
 * */


//registration captcha
function captcha()
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
	unset($_SESSION['panel_registration_captcha']);
	$_SESSION['panel_registration_captcha'] = $number;
	return $base64;
}

function log_in($data)
{
		if(empty($data))
		{
			return;
		}
	
		if(empty($data['login']))
			$warning['login'] = 'Wpisz login.';

		if(empty($data['password']))
			$warning['password'] = 'Wpisz hasło.';
		
		if(!empty($warning))
		{
			$data['password'] = '';
			$is_ok = 0;
			return array($is_ok, $warning, $data);
			exit;
		}	
	//check login	
		$query = $this -> pdo -> prepare ("SELECT up_id, up_login, up_password, up_verification_code, up_avatar FROM users_panel WHERE up_login = :login ");
		$query->bindValue(':login', $data['login'], PDO::PARAM_STR);
		$query->execute();			
		$is_login = $query->fetchAll();	
		if(empty($is_login))
		{
			$data['password'] = '';
			$warning['login'] = 'Błędny login!';
			$is_ok = 0;
			return array($is_ok, $warning, $data);
			exit;
		}			
	//check password
		$pass = sha1($data['password'].$is_login[0]['up_verification_code']);
		$query = $this -> pdo -> prepare ("SELECT up_id, up_login, up_last_login FROM users_panel WHERE up_login = :login AND up_password = :pass ");
		$query->bindValue(':login', $data['login'], PDO::PARAM_STR);
		$query->bindValue(':pass', $pass, PDO::PARAM_STR);
		$query->execute();			
		$is_pass = $query->fetchAll();	
		if(empty($is_pass))
		{

			$data['password'] = '';
			$warning['password'] = 'Błędne hasło!';
			$is_ok = 0;
			return array($is_ok, $warning, $data);
			exit;
		}
			$ins=$this->pdo->prepare("UPDATE users_panel 
										SET up_before_last_login = :date, up_last_login = NOW()
										WHERE up_id = :idek ");
					$ins->bindValue(':date', $is_pass[0]['up_last_login'], PDO::PARAM_STR);
					$ins->bindValue(':idek', $is_pass[0]['up_id'], PDO::PARAM_STR);
				$ins->execute();			
		
		
		return array(1, $is_login[0]['up_id'],  $is_login[0]['up_login'], $is_login[0]['up_avatar'] ) ;
					
}

function registration_insert($data)
{
    
    
        if(file_exists('helpers/forbidden_words.php'))
        {
            require_once('helpers/forbidden_words.php');
            $forb = in_array($data['login'], $forbidden_words);
            if(!empty($forb))
            {
                $forb = true;
            }            
        }
        
            $query = $this -> pdo -> prepare ("SELECT COUNT(up_login) FROM users_panel WHERE up_login = :login ");
            $query->bindValue(':login', $data['login'], PDO::PARAM_STR);
            $query->execute();          
            $is_login = $query->fetchColumn();   
            if(0<$is_login)
                $same_login = true;
                         
            
		if(empty($data['login']))
			$warning['login'] = 'Wpisz login.';
		elseif(strlen($data['login']) < 3)
			$warning['login'] = 'Login jest za krótki.';
		elseif(strlen($data['login']) > 15)
			$warning['login'] = 'Login jest za długi';
		elseif($forb === true)
		    $warning['login'] = 'Zbyt wulgarnie!';
        elseif($same_login === true)
            $warning['main'] = 'Istnieje już użytkownik o takim loginie.';      


		
		if(empty($data['password']))
			$warning['password'] = 'Wpisz hasło.';
		elseif(strlen($data['password']) < 6)
			$warning['password'] = 'Hasło jest za krótkie.';
		elseif(strlen($data['password']) > 30)
			$warning['password'] = 'Hasło jest za długie';	
		
		if(empty($data['password2']))
			$warning['password2'] = 'Powtórz hasło.';
		elseif(strlen($data['password2']) < 6)
			$warning['password2'] = '2 różne hasła.';
		elseif(strlen($data['password2']) > 30)
			$warning['password2'] = 'Za długo!';			
		elseif($data['password'] != $data['password2'])
			$warning['password'] = '2 różne hasła!';	

	
		
		if(empty($data['mail']))
			$warning['mail'] = 'Wpisz adres e-mail.';
		elseif(!filter_var($data['mail'], FILTER_VALIDATE_EMAIL))
			$warning['mail'] = 'To nie jest e-mail.';
		else 
		{
			$query = $this -> pdo -> prepare ("SELECT COUNT(up_id) FROM users_panel WHERE up_mail = :mail ");
			$query->bindValue(':mail', $data['mail'], PDO::PARAM_STR);
			$query->execute();			
			$is_mail = $query->fetchColumn();	
			if(!empty($is_mail))
				$warning['main'] = 'Na ten adres e-mail jest już zarejestrowane konto.<br />Jeśli to Twój e-mail, spróbuj zresetować hasło.';			
		}
		
		if(empty($data['captcha']))
			$warning['captcha'] = 'Przepisz kod z obrazka.';
		elseif($data['captcha'] != $_SESSION['panel_registration_captcha'])
			$warning['captcha'] = 'Błędny kod!';

 
		
		if(!empty($warning))
		{
			$data['password'] = '';
			$data['password2'] = '';
			$data['captcha'] = '';
			$is_ok = 0;
			return array($is_ok, $warning, $data);
			exit;
		}	
		
						


		
//everything is ok, now insert user to database

		//ver. code
		$ac_link = uniqid();

		//password
		$pass = $data['password'].$ac_link;
		$sha = sha1($pass);
		

			$ins=$this->pdo->prepare("INSERT INTO users_panel 
											(up_register_date, up_login, up_password, up_mail, up_confirmed, up_verification_code, up_type, up_avatar) 
										VALUES 
											(NOW(), :login, :pass, :mail, :confirmed, :ver_code, :type, :avatar) ");
					$ins->bindValue(':login', $data['login'], PDO::PARAM_STR);
					$ins->bindValue(':pass', $sha, PDO::PARAM_STR);
					$ins->bindValue(':mail', $data['mail'], PDO::PARAM_STR);
					$ins->bindValue(':confirmed', 0, PDO::PARAM_STR);
					$ins->bindValue(':ver_code', $ac_link, PDO::PARAM_STR);
					$ins->bindValue(':type', 'user', PDO::PARAM_STR);
					$ins->bindValue(':avatar', 'default.png', PDO::PARAM_STR);
				$ins->execute();			


		

//send a message with activation link
if (file_exists('config/mail.php' ))
{
	require_once('config/mail.php');		

				
				if(!empty($email_for_registration_panel))
				{
					$topic1 = '- dziękujemy za rejestrację. Aktywuj konto!';
					$domain_name = str_replace('www.', '', $_SERVER["SERVER_NAME"]);
					$topic = $domain_name.$topic1;
					
					$content = '<p>Witamy!</p><p>Aby dokończyć rejestrację swojego konta w panelu <a href="http://'.$domain_name.'">'.$domain_name.'</a> 
								kliknij w poniższy link aktywacyjny:</p><p><a href="http://'.$_SERVER["SERVER_NAME"].'/panel-account-activation-'.$ac_link.'">'.$_SERVER["SERVER_NAME"].'/'.$ac_link.'</a></p>';
					
					
					$m_mail = $email_for_registration_panel;
					
	
					$ip = '<p><br /><pre>Z adresu ip: '.$_SERVER['SERVER_ADDR'].'</pre>';
					$prze = '<pre>Z przeglądarki: '.$_SERVER['HTTP_USER_AGENT'].'</pre></p>';	
									

						mail($data['mail'],"=?UTF-8?B?".base64_encode($topic)."?=", $content.$ip.$prze,'From:'.$m_mail."\r\nContent-Type: text/html; charset=utf-8");		
					
				}
}	


	
		//check fails since 00:00 - if more than 10 -> login is not allowed
		/*
		$ins=$this->pdo->prepare('SELECT count(log_id)   FROM `logs` WHERE `log_try` = :try AND TIMESTAMPDIFF(DAY, NOW(), `log_date`) = :date AND log_type = :type AND log_ip = :log_ip ');
	        	$ins->bindValue(':try', 'fail', PDO::PARAM_STR);
				$ins->bindValue(':date', 0, PDO::PARAM_STR);
				$ins->bindValue(':type', 'panel_registration', PDO::PARAM_STR);
				$ins->bindValue(':log_ip', $_SERVER['SERVER_ADDR'], PDO::PARAM_STR);
				
		$ins->execute();
		$fails = $ins->fetchAll();	
		//if more than 30 fails today return warning		
		if($fails[0][0] > 50)
		{
			$warning['general'] = 'Zbyt dużo nieudanych prób. Spróbuj jutro.';
			return $warning;
			exit;
		}
		*/
		return array(1);				
}


function acc_activation($code)
{
	//delete unactivated accounts 48h
		$del=$this->pdo->prepare('DELETE FROM users_panel WHERE up_confirmed = :null AND TIMESTAMPDIFF(HOUR, `up_register_date`, NOW() ) > :date ');
			$del->bindValue(':null', 0, PDO::PARAM_STR);
			$del->bindValue(':date', 48, PDO::PARAM_STR);
		$del->execute();	
	
	//check if that activation code exist
		$query = $this -> pdo -> prepare ("SELECT up_id, up_confirmed, DATE_FORMAT(up_acc_activation_date, '%e %c %Y %H %i') as new_date FROM users_panel WHERE up_verification_code = :code ");
		$query->bindValue(':code', $code, PDO::PARAM_STR);
		$query->execute();			
		$how = $query->fetchAll();	

	
	if(empty($how))
	{
		return array(0); //acc deleted
	}	
	elseif($how[0]['up_confirmed'] == 1)
	{
		return array(1, $how[0]['new_date']); //acc already confirmed
	}
	elseif($how[0]['up_confirmed'] == 0)
	{
			$query=$this->pdo->prepare("UPDATE users_panel SET up_confirmed = :ok, up_acc_activation_date = NOW() WHERE up_id = :upid");
			$query->bindValue(':upid', $how[0]['up_id'], PDO::PARAM_STR);
			$query->bindValue(':ok', 1, PDO::PARAM_STR);
			$query->execute();		
		return array(2); //acc activated..
	}
	

	
}


function account($idek)
{
		$query = $this -> pdo -> prepare ("SELECT up_login, up_register_date, up_before_last_login, up_mail, up_avatar, up_last_login, up_newsletter, up_about, up_name, 
		                                  up_sex, up_age, up_city, up_vocation,
		                                  DATE_FORMAT(up_age, '%d/%m/%Y') as date
		                                  FROM users_panel
		                                  WHERE up_id = :idek ");
		$query->bindValue(':idek', $_SESSION['user_panel_id'], PDO::PARAM_STR);
		$query->execute();			    
		$result = $query->fetchAll();	

        if($result[0]['up_newsletter'] == 1)
            $newsletter = 'Chcę otrzymywać';
        else 
            $newsletter = 'Nie chcę otrzymywać';
        
        if($result[0]['up_about'] === NULL || $result[0]['up_about'] === '')
            $about = 'Brak danych';
        else 
            $about = $result[0]['up_about'];
        
        if($result[0]['up_name'] === NULL || $result[0]['up_name'] === '')
            $name = 'Brak danych';
        else 
            $name = $result[0]['up_name'];     
        
        if($result[0]['up_sex'] === NULL || $result[0]['up_sex'] === '')
            $sex = 'Brak danych';
        elseif($result[0]['up_sex'] === 'W')
            $sex = 'Kobieta';
        elseif($result[0]['up_sex'] === 'M')
            $sex = 'Mężczyzna';     
        elseif($result[0]['up_sex'] === 'D')
            $sex = 'Inna';                       
        else 
            $sex = 'Brak danych';     
        
        if($result[0]['up_city'] === NULL || $result[0]['up_city'] === '')
            $city = 'Brak danych';
        else 
            $city = $result[0]['up_city'];               
            
        if($result[0]['up_city'] === NULL || $result[0]['up_city'] === '')
            $city = 'Brak danych';
        else 
            $city = $result[0]['up_city'];       
        
        if($result[0]['up_vocation'] === NULL || $result[0]['up_vocation'] === '')
            $vocation = 'Brak danych';
        else 
            $vocation = $result[0]['up_vocation'];  
 
        if($result[0]['date'] === NULL)
            $age = 'Brak danych';
        else 
            $age = $result[0]['date'];          
             
        
        $content = 
        [
            'mail' => $result[0]['up_mail'],
            'register' => $result[0]['up_register_date'],
            'last_login' => $result[0]['up_before_last_login'],
            'newsletter' => $newsletter,
            'about' => $about,
            'name' => $name,
            'sex' => $sex,
            'age' => $age,
            'city' => $city,
            'vocation' => $vocation,
        ];
        	
		return $content;
}

function accountChange()
{
        $query = $this -> pdo -> prepare ("SELECT up_login, up_register_date, up_before_last_login, up_mail, up_avatar, 
                                            up_last_login, up_newsletter, up_about, up_name, up_sex, up_city, up_vocation,
                                            DATE_FORMAT(up_age, '%d/%m/%Y') as date
                                            FROM users_panel WHERE up_id = :idek ");
        $query->bindValue(':idek', $_SESSION['user_panel_id'], PDO::PARAM_STR);
        $query->execute();              
        $result = $query->fetchAll();   
        
                  
        
        $content = 
        [
            'mail' => $result[0]['up_mail'],
            'register' => $result[0]['up_register_date'],
            'last_login' => $result[0]['up_before_last_login'],
            'newsletter' => $result[0]['up_newsletter'],
            'about' => $result[0]['up_about'],
            'name' => $result[0]['up_name'],
            'sex' => $result[0]['up_sex'],
            'age' => $result[0]['up_age'],
            'city' => $result[0]['up_city'],
            'vocation' => $result[0]['up_vocation'],
            'age' => $result[0]['date'],
        ];

            
        return $content;    
    
}


function account_update($data)
{


//newsletter
if($data['newsletter'] ==  0)
{
	$newsletter = 0;
}
elseif($data['newsletter'] == 1)	
{
	$newsletter = 1;
}	
else
{
	$newsletter = 0;	
}

//sex
if($data['sex'] ==  'W')
{
	$sex = 'W';
}
elseif($data['sex'] == 'M')	
{
	$sex = 'M';
}	
elseif($data['sex'] == 'D')	
{
	$sex = 'D';	
}
else 
{
	$sex = 'W';	
}

//age
$data['age1'] = intval($data['age1']);	
$data['age2'] = intval($data['age2']);	
$data['age3'] = intval($data['age3']);	
if($data['age1'] > 0 && $data['age1'] < 32 && $data['age2'] > 0 && $data['age2'] < 13 && $data['age3'] > 1929 && $data['age3'] < date('Y')+1 && is_numeric($data['age1']) && is_numeric($data['age2']) && is_numeric($data['age2']) )
{
	$age = $data['age3'].'-'.$data['age2'].'-'.$data['age2'];
}
else
{
	$age = '0000-00-00';
}
	



							$inss=$this->pdo->prepare("UPDATE users_panel SET up_about = :about, up_newsletter = :newsletter, up_name = :name, up_sex = :sex, up_age = :age, up_city = :city, up_vocation = :vocation 
														WHERE up_id = :idek");
									$inss->bindValue(':about', $data['about'], PDO::PARAM_STR);
									$inss->bindValue(':newsletter', $newsletter, PDO::PARAM_STR);
									$inss->bindValue(':name', $data['name'], PDO::PARAM_STR);
									$inss->bindValue(':sex', $sex, PDO::PARAM_STR);
									$inss->bindValue(':age', $age, PDO::PARAM_STR);
									$inss->bindValue(':city', $data['city'], PDO::PARAM_STR);
									$inss->bindValue(':vocation', $data['vocation'], PDO::PARAM_STR);
									
									$inss->bindValue(':idek', $_SESSION['user_panel_id'], PDO::PARAM_STR);
							$inss->execute();		
                            
                            $_SESSION['user_panel_ok'] = 'Zmiany zostały zapisane.';
                            
}

function account_update_avatar_put()
{
    if($file['avatar']['size'] > 0) //whether user uploaded file or not
    {
        if($file['avatar']['size'] < 20000) // is it too big?
        {
            $img = $file['avatar']['name'];
            $img_t = pathinfo($img,PATHINFO_EXTENSION); //type of file
    
            if($img_t == 'png' || $img_t == 'jpeg' || $img_t == 'jpg' || $img_t == 'gif')
            {
                $img_i = getimagesize($_FILES["avatar"]["tmp_name"]); //dimension ?
                if($img_i[0] == 80 && $img_i[1] == 80)
                {
                    function try_name()
                    {
                        $name = uniqid();
                        $full_name = $name.'.'.$img_t;
                        if (!file_exists('public/images/panel/avatars/'.$full_name)) //check if file alreade exist
                        {                                       
                            return $name;
                        } 
                        
                        else 
                        {
                            try_name();
                        }
                    }
                    $img_file = $_FILES["avatar"]["tmp_name"];
                    $img_name = try_name().'.'.$img_t;
                    move_uploaded_file($img_file, "public/images/panel/avatars/$img_name"); //upload file
                    
                    $sql = $this->pdo->prepare("UPDATE users_panel 
                                                SET up_avatar = :avatar
                                                WHERE up_id = :idek");
                    $sql->bindValue(':avatar', $img_name, PDO::PARAM_STR);                      
                    $sql->bindValue(':idek', $idek, PDO::PARAM_STR);
                    $sql->execute();                                        //update user account
                    
                    
                    
                    if($_SESSION['user_panel_avatar'] != 'default.png' && !empty($_SESSION['user_panel_avatar'])) //if old avatar isn't default and if existed
                    {
                        if(file_exists('public/images/panel/avatars/'.$_SESSION['user_panel_avatar'])){
                            unlink('public/images/panel/avatars/'.$_SESSION['user_panel_avatar']);  //delete old avatar
                            $_SESSION['user_panel_avatar'] = $img_name;
                        }                                       
                    }
                    
                    $_SESSION['user_panel_avatar'] = $img_name; //update session img 
                    
                    
                }
                else
                {
                    $_SESSION['user_panel_warning'] = 'Błędne wymiary obrazka. (80x80)';
                }   
            }
            else 
            {
                $_SESSION['user_panel_warning'] = 'Zły format obrazka.';
            }
        }
        else
        {
            $_SESSION['user_panel_warning'] = 'Obrazek jest za duży. (ponad 20KB)';
        }
    }
    else
    {
        
    }
    
}



function mail_update($data, $session)
{
	if(!empty($data['new_mail1']) && !empty($data['new_mail2']))
	{
		if(filter_var($data['new_mail1'], FILTER_VALIDATE_EMAIL) && filter_var($data['new_mail2'], FILTER_VALIDATE_EMAIL) )
		{
			if($data['new_mail1'] == $data['new_mail2'])
			{
							$inss=$this->pdo->prepare("UPDATE users_panel SET up_mail = :mail
														WHERE up_id = :idek");
								$inss->bindValue(':mail', $data['new_mail1'], PDO::PARAM_STR);								
								$inss->bindValue(':idek', $session['user_panel_id'], PDO::PARAM_STR);
							$inss->execute();	
						$_SESSION['user_panel_warning_mail'] = '<span style="color: green">Adres e-mail został zmieniony.</span>';
						return;													
			}
			else
			{
				$_SESSION['user_panel_warning_mail'] = 'Adresy e-mail różnią się od siebie.';
				return;				
			}
		}
		else 
		{
			$_SESSION['user_panel_warning_mail'] = 'Wpisz poprawny adres e-mail.';
			return;
		}
	}
	else 
	{
		$_SESSION['user_panel_warning_mail'] = 'Wypełnij pola.';
		return;
	}
}

function pass_update($data, $session) 
{
	$data['new_old_pass'];
	$data['nw_pass1'];
	$data['new_pass2'];
	if(!empty($data['new_old_pass']) || !empty($data['nw_pass1']) || !empty($data['new_pass2']))
	{
		if($data['new_pass1'] == $data['new_pass2'])
		{
			if(mb_strlen($data['new_pass1'], 'UTF-8') > 5 || mb_strlen($data['new_pass2'], 'UTF-8') > 5 )
			{
				if(mb_strlen($data['new_pass1'], 'UTF-8') < 31 || mb_strlen($data['new_pass2'], 'UTF-8') < 31)
				{
					$query = $this -> pdo -> prepare ("SELECT up_password, up_verification_code FROM users_panel WHERE up_id = :idek ");
					$query->bindValue(':idek', $session['user_panel_id'], PDO::PARAM_STR);
					$query->execute();			
					$result = $query->fetchAll();	
					
					
					if(sha1($data['new_old_pass'].$result[0]['up_verification_code']) == $result[0]['up_password'])	
					{
							$update = $this->pdo->prepare("UPDATE users_panel SET up_password = :pass
														WHERE up_id = :idek");
								$update -> bindValue(':pass', sha1($data['new_pass1'].$result[0]['up_verification_code']), PDO::PARAM_STR);								
								$update -> bindValue(':idek', $session['user_panel_id'], PDO::PARAM_STR);
							$update -> execute();	
						$_SESSION['user_panel_warning_pass'] = '<span style="color: green">Hasło zostało zmienione.</span>';
						return;								
					}
					else 
					{
						$_SESSION['user_panel_warning_pass'] = 'Stare hasło jest nieprawidłowe.';
						return;						
					}
				}
				else 
				{
					$_SESSION['user_panel_warning_pass'] = 'Nowe hasło jest za długie.';
					return;						
				}
			}
			else
			{
				$_SESSION['user_panel_warning_pass'] = 'Nowe hasło jest za krótkie.';
				return;					
			}
		}
		else 
		{
			$_SESSION['user_panel_warning_pass'] = 'Hasła różnią się od siebie.';
			return;							
		}
	}
	else 
	{
		$_SESSION['user_panel_warning_pass'] = 'Wpisz hasła.';
		return;		
	}
	
}	




}





?>