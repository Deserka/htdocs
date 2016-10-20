<?php

class panel_panelController extends Controller{
	
function __construct()
    {  	
		$this -> panel = new panel_panelModel;	
		$this -> index = new indexModel;	
		//$this -> captcher = new Captcher;	
    }
	 
/*
 * ###################################################################################### LOGIN #################################################################################################
 * */
 /**
	 * LOG IN
	 */
	 
/*
function login()
{
		$view = new View ;
		$view -> main_part = $view -> render2('panel/login');
		$view -> render('panel/layouts/main');	
}
*/
function login()
{
		$view = new View ;
		$view->set('all', $this -> index->all());
		$view->set('log_in', $this -> panel -> log_in($_POST));
			$checker = $view -> get('log_in');
				if(empty($checker))
				{
				$view -> main_part = $view -> render2('panel/login');
				$view -> render('layouts/layout');	
				exit;					
				}
				elseif($checker[0] === 0)
				{
					$back = new View ;
					$back->set('all', $this -> index->all());
					$back -> set ('back', $checker);
					$back -> main_part = $view -> render2('panel/login');
					$back -> render('layouts/layout');	
					exit;
				}
				elseif ($checker[0] === 1) 
				{
					session_start();
						$_SESSION['user_panel_id'] = $checker[1];
						$_SESSION['user_panel_login'] = $checker[2];		
						$_SESSION['user_panel_avatar'] = $checker[3];		
							header("Location: /panel-account");
							exit;								
				}
				
						

}

function logout(){
		session_unset(); 
		session_destroy(); 
		header("Location: /panel");
			exit;
}

function registration()
{
		$view = new View ;
        $view->set('all', $this -> index->all());
		$view->set('captcha', $this -> panel -> captcha());
		$view -> main_part = $view -> render2('panel/registration');
		$view -> render('layouts/layout');	
}

function registration_insert()
{
		$view = new View ;
		$view->set('registration_insert', $this -> panel -> registration_insert($_POST));
			$checker = $view -> get('registration_insert');

				if($checker[0] === 0)
				{
					$back = new View ;
                    $back->set('all', $this -> index->all());
					$back->set('captcha', $this -> panel -> captcha());
					$back -> set ('back', $checker);
					$back -> main_part = $view -> render2('panel/registration');
					$back -> render('layouts/layout');	
					
				}
				elseif($checker[0] === 1)
				{
					$back = new View ;
                    $back->set('all', $this -> index->all());
					$back->set('captcha', $this -> panel -> captcha());
					$back -> set ('ok', $checker);
					$back -> main_part = $view -> render2('panel/registration');
					$back -> render('layouts/layout');						
				}
				else
				{
					$back = new View ;
                    $back->set('all', $this -> index->all());
					$back->set('captcha', $this -> panel -> captcha());
					$back -> set ('none', $checker);
					$back -> main_part = $view -> render2('panel/registration');
					$back -> render('layouts/layout');							
				}

}

function acc_activation($code)
{
		$view = new View ;
        $view->set('all', $this -> index->all());
		$view->set('activation', $this -> panel -> acc_activation($code));
		$view -> main_part = $view -> render2('panel/acc_activation');
		$view -> render('layouts/layout');	
}


function password_reset()
{
		$view = new View ;
        $view->set('all', $this -> index->all());
        $view->set('all', $this -> index->all());
		$view -> main_part = $view -> render2('panel/pass_reset');
		$view -> render('layouts/layout');	
}


function account()
{
		$view = new View ;
		$view->set('all', $this -> index->all());
		$view->set('content', $this -> panel -> account($_SESSION['user_panel_id']));
		$view -> main_part = $view -> render2('panel/account');
		$view -> render('layouts/layout');	
}
function accountChange()
{
        $view = new View ;
        $view->set('all', $this -> index->all());
        $view->set('content', $this -> panel -> accountChange());
        $view -> main_part = $view -> render2('panel/account_change');
        $view -> render('layouts/layout');  
}

function account_update()
{
		$this -> panel -> account_update();
		header("Location: /panel-account-change");
			exit;	
}
function account_update_avatar()
{
        $view = new View ;
        $view->set('all', $this -> index->all());
        $view -> main_part = $view -> render2('panel/account_change_avatar');
        $view -> render('layouts/layout');      
}
function account_update_avatar_put()
{
        $this -> panel -> account_update_avatar_put();
        header("Location: /panel-account-change-avatar");
            exit;   
}
function account_update_mail()
{
        $view = new View ;
        $view->set('all', $this -> index->all());
        $view -> main_part = $view -> render2('panel/account_change_mail');
        $view -> render('layouts/layout');      
}
function account_update_mail_put()
{
        $this -> panel -> account_update_mail_put();
        header("Location: /panel-account-change-mail");
            exit;   
}
function account_update_pass()
{
        $view = new View ;
        $view->set('all', $this -> index->all());
        $view -> main_part = $view -> render2('panel/account_change_pass');
        $view -> render('layouts/layout');      
}
function account_update_pass_put()
{
        $this -> panel -> account_update_pass_put();
        header("Location: /panel-account-change-pass");
            exit;   
}










function mail_update()
{
		$this -> panel -> mail_update($_POST, $_SESSION);
		header("Location: /panel-account#c_mail");
			exit;		
}

function pass_update()
{
		$this -> panel -> pass_update($_POST, $_SESSION);
		header("Location: /panel-account#c_pass");
			exit;		
}

}

?>