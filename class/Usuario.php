<?php 
//model

class Usuario {

	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;


	//get e set
	public function getIdsuario(){
		return $this->idusuario;
	}

	public function setIdsuario($value){
		$this->idusuario = $value;
	}

	public function getDeslogin(){
		return $this->deslogin;
	}

	public function setDeslogin($value){
		$this->deslogin = $value;
	}

	public function getDessenha(){
		return $this->dessenha;
	}

	public function setDessenha($value){
		$this->dessenha = $value;
	}

	public function getDtcadastro(){
		return $this->dtcadastro;
	}

	public function setDtcadastro($value){
		$this->dtcadastro = $value;
	}

	//metodo listar usuário pelo id
	public function loadById($id){
		//instanciando a classe Sql
		$sql = new Sql();

		//faznedo uma consulta no banco pelo id
		$results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
			":ID"=>$id
		));

		//verficando se a pesquisa tem algum registro.	
		if(isset($results[0])){
			//atribuindo o resultado do indice 1.
			$this->setData($results[0]);
		}

	}

	//trás uma lista completa
	public static function getList(){
		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin;");
	}

	//tras uma lista pelo nome do login
	public static function search($login){
		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
			':SEARCH'=>"%".$login."%"
		));
	}

	//faz autenticação de login
	public function login($login, $password){
		$sql = new Sql();

		//faznedo uma consulta no banco pelo id
		$results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(
			":LOGIN"=>$login,
			":PASSWORD"=>$password
		));

		//verficando se a pesquisa tem algum registro.	
		if(isset($results[0])){
			//atribuindo o resultado do indice 1.
			$this->setData($results[0]);
			
		} else {
			throw new Exception('Usuário ou senha inválido', 1);
		}
	}

	public function setData($data){
			$this->setIdsuario($data['idusuario']);
			$this->setDeslogin($data['deslogin']);
			$this->setDessenha($data['dessenha']);
			$this->setDtcadastro(new DateTime($data['dtcadastro']));
	}


	//método de inserção.
	public function insert(){
		$sql = new Sql();

		//Procidure
		$results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
			':LOGIN'=>$this->getDeslogin(),
			'PASSWORD'=>$this->getDessenha()
		));

		if(count($results) > 0){
			$this->setData($results[0]); 
		}

	}

	//metodo para receber os dados
	public function __construct($login = "", $password = ""){
		$this->setDeslogin($login);
		$this->setDessenha($password);
	}

	//update
	public function update($login, $password){
		$this->setDeslogin($login);
		$this->setDessenha($password);

		$sql = new Sql();
		$sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
			':LOGIN'=>$this->getDeslogin(),
			':PASSWORD'=>$this->getDessenha(),
			':ID'=>$this->getIdsuario()
		));
	}	

	//delete 
	public function delete(){
		$sql = new Sql();
		$sql->query("DELETE FROM tb_usuarios WHERE idusuario = :ID", array(
			':ID'=>$this->getIdsuario()
		));
		//zerando o objeto
		$this->setIdsuario(0);
		$this->setDeslogin("");
		$this->setDessenha("");
		$this->setDtcadastro(new DateTime());
	}

	//método que transforma o objeto em String
	public function __toString(){
		return json_encode(array(
			"idusuario" =>$this->getIdsuario(),
			"deslogin"=>$this->getDeslogin(),
			"dessenha"=>$this->getDessenha(),
			"dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i")
		));
	}
	

}


 ?>