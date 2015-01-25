<?php
class Usuario{

	private $id;
	private $email;
	private $nome;
	private $senha;
	private $instancia;

	function getId () {
		return $this->id;
	}

	function setId ($id) {
	 $this->id = $id;
	}

	function getEmail () {
	 return $this->email;
	}

	function setEmail ($email) {
	 $this->email = $email;
	}

	function getNome () {
	 return $this->nome;
	}

	function setNome ($nome) {
	 $this->nome = $nome;
	}

	function getSenha () {
	 return $this->senha;
	}

	function setSenha ($senha) {
	 $this->senha = $senha;
	}

	function getInstancia () {
	 return $this->instancia;
	}

	function setInstancia ($instancia) {
	 $this->instancia = $instancia;
	}

}
?>