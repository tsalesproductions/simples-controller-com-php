<?php
	class Connection{
		private $host = "localhost";
		private $user = "root";
		private $senha = "";
		private $banco = "blog";

		public $pdo;

		public function __construct(){
			try{
				$this->pdo = new PDO("mysql:host=$this->host;dbname=$this->banco;charset=utf8", $this->user, $this->senha);
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch(PDOException $e){
				echo "Erro ao conectar-se: ".$e->getMessage();
				exit();
			}
		}

		public function select($query, $params){
			$stmt = $this->pdo->prepare($query);
			
			$stmt->execute(isset($params) ? $params : null);

			return $stmt->fetchAll();
		}

		public function update($query, $params){
			try{
				$stmt = $this->pdo->prepare($query);
				$stmt->execute(isset($params) ? $params : null);
			}catch(PDOException $e){
				echo $e->getMessage();
			}
		}

		public function delete($table, $column, $value){
			try{
				$stmt = $this->pdo->prepare("DELETE FROM {$table} WHERE {$column} = :id");
				$stmt->execute([':id' => $value]);
			}catch(PDOException $e){
				echo $e->getMessage();
			}
		}
	}
?>