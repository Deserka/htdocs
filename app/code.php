<?php
 function __autoload($className)
{
    if (preg_match('/^[a-z][0-9a-z]*(_[0-9a-z]+)*$/i', $className))
    {
    	if(strpos($className, 'Controller') !== FALSE) {
    		$name = str_replace('Controller', '', $className);       
			$file = dirname(__FILE__) . '/controller/' . str_replace('_' , '/', $name);
        	if (file_exists($path = $file . '.php') || file_exists($path = $file . '.php'));
    		}		
		elseif(strpos($className, 'Model') !== FALSE) {
			$name = str_replace('Model', '', $className);
			$file = dirname(__FILE__) . '/model/' . str_replace('_' , '/', $name);
        	if (file_exists($path = $file . '.php') || file_exists($path = $file . '.php'));
    		}
		elseif(strpos($className, 'View') !== FALSE) {
			$name = str_replace('View', '', $className);
			$file = dirname(__FILE__) . '/view/' . str_replace('_' , '/', $name);
        	if (file_exists($path = $file . '.php') || file_exists($path = $file . '.php'));
    		}
        /*
		elseif(strpos($className, 'Captcher') !== FALSE) {
			$name = str_replace('Captcher', '', $className);
			$file = dirname(__FILE__) . '/captcher/' . str_replace('_' , '/', $name);
        	if (file_exists($path = $file . '.php') || file_exists($path = $file . '.php'));
    		}	
         */	
		}
        else 
	   {
	       
	   }
          
            require_once $path;
            return;
        
    
	_Controller::http404();
}

/*--------------------------------------------------------------------------------------------------------------
 * CONTROLLER */
 
 

	
abstract class Controller{

    }

/*--------------------------------------------------------------------------------------------------------------
 * VIEW */


    class View
{
    static $dir = 'app/view/cms/layouts/';
    static $var = array();
    protected $file;
    protected $data = array();
      
	  
	 

	  
	public function render($name, $path='app/view/') {

		if(strpos($name, 'cms/') !== FALSE) {
			$name = str_replace('cms/', '', $name);
			$path=$path. 'cms/'.$name.'.phtml';
		}
		elseif(strpos($name, 'panel/') !== FALSE) {
			$name = str_replace('panel/', '', $name);
			$path=$path. 'panel/'.$name.'.phtml';
		}	
        elseif(strpos($name, 'cms/creator/') !== FALSE) {
            $name = str_replace('cms/creator/', '', $name);
            $path=$path. 'cms/creator/'.$name.'.phtml';
        }           	
		else{
			 $path=$path. 'templates/'. $name.'.phtml';
	}
        try {
            if(is_file($path)) {
                require $path;
            } else {
                throw new Exception('Can not open template '.$name.' in: '.$path);
            }
        }
        catch(Exception $e) {
            echo $e->getMessage().'<br />
                File: '.$e->getFile().'<br />
                Code line: '.$e->getLine().'<br />
                Trace: '.$e->getTraceAsString();
            exit;
        }
    }
	
	public function render2($name, $path='app/view/') {

		if(strpos($name, 'cms/') !== FALSE) {
			$name = str_replace('cms/', '', $name);
			$path=$path. 'cms/'.$name.'.phtml';
		}
		elseif(strpos($name, 'panel/') !== FALSE) {
			$name = str_replace('panel/', '', $name);
			$path=$path. 'panel/'.$name.'.phtml';
		}
        elseif(strpos($name, 'cms/creator/') !== FALSE) {
            $name = str_replace('cms/creator/', '', $name);
            $path=$path. 'cms/creator/'.$name.'.phtml';
        }          
		else{
			 $path=$path. 'templates/'. $name.'.phtml';
	}
        try {
            if(is_file($path)) {
            	
            	return $path;
               
            } else {
                throw new Exception('Can not open template '.$name.' in: '.$path);
            }
        }
        catch(Exception $e) {
            echo $e->getMessage().'<br />
                File: '.$e->getFile().'<br />
                Code line: '.$e->getLine().'<br />
                Trace: '.$e->getTraceAsString();
            exit;
        }
    }
	
	public function set($name, $value) {
        $this->$name=$value;
    }
  
    public function get($name) {
        return $this->$name;
    }
	public function makeButtons($name, $value) {
        $this->$name=$value;
    }
  
    public function showButtons($name) {
        return $this->$name;
    }
	
    function __get($name)
    {
        return array_key_exists($name, $this->data) ? $this->data[$name] : null;
    }    
    function __set($name, $value)
    {
        $this->data[$name] = $value;
    }    
    function __toString()
    {
        if (!file_exists(self::$dir . $this->file)) return '';
        foreach (array_merge(self::$var, $this->data) as $name => $value)
        {
            if ($name != 'this') $$name = $value;
        }
        unset($name, $value);
        $_config = Controller::$config;
        $_dir = self::$dir;
        ob_start();
        require $_dir . $this->file;
        Controller::$config = $_config;
        return ob_get_clean();
    }
}

/*--------------------------------------------------------------------------------------------------------------
 * MODEL */
 
abstract class Model{
    protected $pdo;
	protected $site_lang;
	protected $lang;
	
    public function  __construct() {
        try {
            require 'config/sql.php';
            $this->pdo=new PDO('mysql:host='.$host.';charset=utf8;dbname='.$dbase, $user, $pass);
			//$dbh->exec("set names utf8");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
        }
        catch(Throwable $e) {
            echo 'The connect can not create: ' . $e->getMessage();
        }
    }

    public function select($from, $select='*', $where=NULL, $order=NULL, $limit=NULL) {
        $query='SELECT '.$select.' FROM '.$from;
        if($where!=NULL)
            $query=$query.' WHERE '.$where;
        if($order!=NULL)
            $query=$query.' ORDER BY '.$order;
        if($limit!=NULL)
            $query=$query.' LIMIT '.$limit;
        $select=$this->pdo->query($query);
        foreach ($select as $row) {
            $data[]=$row;
        }
        $select->closeCursor();
        return $data;
    }
}









?>