<?php 

include_once 'app/code.php';
session_start();


if(empty($_SESSION['user_panel_login']) )
	{

        if($_SERVER['REQUEST_URI'] === '/panel')
        {
            $log = new panel_panelController;
            $log -> login();
            exit;            
        }
        elseif($_SERVER['REQUEST_URI'] === '/panel-login')
        {
            $log = new panel_panelController;
            $log -> login();
            exit;            
        }             
        elseif($_SERVER['REQUEST_URI'] === '/panel-registration')
        {
            $log = new panel_panelController;
            $log -> registration();
            exit;            
        }        
        elseif($_SERVER['REQUEST_URI'] === '/panel-password_reset')
        {
            $log = new panel_panelController;
            $log -> password_reset();
            exit;            
        }            
        elseif($_SERVER['REQUEST_URI'] === '/panel-registration_in')
        {
            $log = new panel_panelController;
            $log -> registration_insert();
            exit;            
        } 
        elseif($_SERVER['REQUEST_URI'] === '/panel-registration_in')
        {
            $log = new panel_panelController;
            $log -> registration_insert();
            exit;            
        }       
        elseif(preg_match('/^\/panel-account-activation-[a-z0-9]+$/', $_SERVER['REQUEST_URI']))
        {
            $o = preg_match('/^\/panel-account-activation-([a-z0-9]+)$/', $_SERVER['REQUEST_URI'], $neededVariables);
            $code = $neededVariables[1];
            $log = new panel_panelController;
            $log -> acc_activation($code);
            exit;            
        }    
              
        else 
        {
            $log = new panel_panelController;
            $log -> login();
            exit;               
        }
    

	}
elseif(!empty($_SESSION['user_panel_login']) )
{

	
		if($_SERVER['REQUEST_URI'] == '/panel' || $_SERVER['REQUEST_URI'] == '/panel-login' || $_SERVER['REQUEST_URI'] == '/panel-registration')
		{		
			header("Location: /panel-account");
			exit;								
		}
        elseif($_SERVER['REQUEST_URI'] === '/panel-account')
        {
            $log = new panel_panelController;
            $log -> account();
            exit;           
        } 
        elseif($_SERVER['REQUEST_URI'] === '/panel-account-change')
        {
            $log = new panel_panelController;
            $log -> accountChange();
            exit;           
        }  
        elseif($_SERVER['REQUEST_URI'] === '/panel-account-update')
        {
            $log = new panel_panelController;
            $log -> account_update();
            exit;           
        }      
        elseif($_SERVER['REQUEST_URI'] === '/panel-account-change-avatar')
        {
            $log = new panel_panelController;
            $log -> account_update_avatar();
            exit;           
        }   
        elseif($_SERVER['REQUEST_URI'] === '/panel-account-change-avatar-put')
        {
            $log = new panel_panelController;
            $log -> account_update_avatar_put();
            exit;           
        }           
        elseif($_SERVER['REQUEST_URI'] === '/panel-account-change-mail')
        {
            $log = new panel_panelController;
            $log -> account_update_mail();
            exit;           
        }   
        elseif($_SERVER['REQUEST_URI'] === '/panel-account-change-mail-put')
        {
            $log = new panel_panelController;
            $log -> account_update_mail_put();
            exit;           
        }    
        elseif($_SERVER['REQUEST_URI'] === '/panel-account-change-pass')
        {
            $log = new panel_panelController;
            $log -> account_update_pass();
            exit;           
        }   
        elseif($_SERVER['REQUEST_URI'] === '/panel-account-change-pass-put')
        {
            $log = new panel_panelController;
            $log -> account_update_pass_put();
            exit;           
        }                                    
}
else
{
    $ob = new indexController;
    $ob->er404();    
    exit;
}






?>