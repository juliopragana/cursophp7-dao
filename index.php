<?php 

require_once("config.php");

	//carrega apenas um usuário
	// $root = new Usuario();
	// $root->loadById(3);
	// echo $root;	
	// echo "<hr>";

//$lista = Usuario::getList();
//echo json_encode($lista);
//var_dump($lista);

//carrega uma lista de usuários buscando pelo login
//$search = Usuario::search("J");

//echo json_encode($search);
//var_dump($search);

//carrega o usuário e senha
$usuario = new Usuario();
$usuario->login("root", "@!#@");
echo $usuario;

 ?>