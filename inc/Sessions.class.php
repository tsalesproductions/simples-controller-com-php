<?php
	class Sessions{

		public function setSessions($id, $nome, $usuario, $senha){
			if($id != null){ $_SESSION['authId'] = $id; }
			if($nome != null){ $_SESSION['authNome'] = $nome; }
			if($usuario != null){ $_SESSION['authUsuario'] = $usuario; }
			if($senha != null){ $_SESSION['authSenha'] = $senha; }
		}

		public function sessionDestroy($redirect){
			session_destroy();

			if($redirect[0] == true){
				$utils = new Utils();
				$utils->redirect($redirect[1], $redirect[2]);
			}
		}
	}
?>