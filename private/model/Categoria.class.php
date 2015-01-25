<?php
class Categoria{

	private $id;
	private $nome;
	private $categoriaSuperior;
	private $instancia;

	function getId () {
		return $this->id;
	}

	function setId ($id) {
		$this->id = $id;
	}


	public function getNome()
	{
	    return $this->nome;
	}

	public function setNome($nome)
	{
	    $this->nome = $nome;
	}

	public function getCategoriaSuperior()
	{
	    return $this->categoriaSuperior;
	}

	public function setCategoriaSuperior($categoriaSuperior)
	{
	    $this->categoriaSuperior = $categoriaSuperior;
	}

	public function getInstancia()
	{
	    return $this->instancia;
	}

	public function setInstancia($instancia)
	{
	    $this->instancia = $instancia;
	}
}
?>