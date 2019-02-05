<?php

if(!defined('DB_HOST')){
	include __DIR__.'/../config.php';
}

class Conexao {
	const host = DB_HOST;
	const porta = DB_PORT;
	const banco = DB_NAME;
	const usuario = DB_USER;
	const senha = DB_PASS;

	public $conexao;

	public function __construct($host = DB_HOST, $banco = DB_NAME, $usuario = DB_USER, $senha = DB_PASS){
		try { 
			$PDO = new PDO('mysql:host='.$host.';dbname='.$banco, $usuario, $senha); 
			$PDO->exec("set names utf8");
			$this->conexao = $PDO;
		} catch (PDOException $e) { 
			return false;
		}
	}

}
?>
