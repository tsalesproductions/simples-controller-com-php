<?php
	class Website{
		public static function pagination(){
			$url = (isset($_GET['pagina'])) ? $_GET['pagina'] : 'inicio';
			$explode = explode('/', $url);
			$dir = 'views/';
			$ext = '.php';

			if(file_exists($dir.$explode[0].$ext)){
				include($dir.$explode[0].$ext);
			}else{
				$utils = new Utils();
				$utils->alert("danger", "Página não encontrada!");
			}
		}

		public static function paginationAuth(){
			$url = (isset($_GET['pagina'])) ? $_GET['pagina'] : 'login';
			$explode = explode('/', $url);
			$dir = 'views/';
			$ext = '.php';

			if(file_exists($dir.$explode[0].$ext) && isset($_SESSION['authUsuario'])){
				include($dir.$explode[0].$ext);
			}else{
				include($dir.'login'.$ext);
			}
		}
	}
?>