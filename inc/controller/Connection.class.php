<?php
	class Connection{
		private $host = db_host;
		private $user = db_user;
		private $senha = db_pass;
		private $banco = db_db;

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

		public function insert($query, $params){
			try{
				$stmt = $this->pdo->prepare($query);

				$stmt->execute(isset($params) ? $params : null);

				return $stmt->rowCount();

			}catch(PDOException $e){
				echo $e->getMessage();
			}
		}

		public function select($query, $params){
			$stmt = $this->pdo->prepare($query);
			
			$stmt->execute(isset($params) ? $params : null);

			if($stmt->rowCount() > 0){
				return $stmt->fetchAll();
			}else{
				return [];
			}
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

		public function rowCount($query, $params){
			try{
				$stmt = $this->pdo->prepare($query);

				$stmt->execute(isset($params) ? $params : null);

				return $stmt->rowCount();

			}catch(PDOException $e){
				echo $e->getMessage();
			}
		}
		
	}
?>