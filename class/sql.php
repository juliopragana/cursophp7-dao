<?php 

//criando Class de conexão
class Sql extends PDO {

		private $conn;

		public function __construct(){

			$this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", "root", "");
			$this->conn->exec("set names utf8");

		}

		//recebendo parâmetros externos
		private function setParams($statement, $parameters = array()){

			foreach ($parameters as $key => $value) {

				$this->setParam($statement, $key, $value);

			}

		}


		//recebendo apenas um parâmetro
		private function setParam($statement, $key, $value){

			$statement->bindParam($key, $value);
		}		

		//Faz tratamento das query e executa
		public function query($rawQuery, $params = array()){

			$stmt = $this->conn->prepare($rawQuery);

			$this->setParams($stmt, $params);

			$stmt->execute();

			return $stmt;
		}

		public function select($rawQuery, $params = array()):array{

		 	$stmt =	$this->query($rawQuery, $params);

			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
}



 ?>