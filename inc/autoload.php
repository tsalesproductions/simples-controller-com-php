<?php
	session_start();
	
	class Autoload{
	    public function __construct(){
	        spl_autoload_extensions('.class.php');
	        spl_autoload_register(array($this, 'load'));
	    }

	    private function load($className){
	        $extension = spl_autoload_extensions();
	        require_once (__DIR__ . '/' . $className.$extension);
	    }
	}

	$autoload = new Autoload();
?>