<?php
class CedenteSacado{

	private $id;
	private $descricao;
	private $nome;
	private $instancia;

	function getId () {
		return $this->id;
	}

	function setId ($id) {
		$this->id = $id;
	}


	public function getDescricao()
	{
	    return $this->descricao;
	}

	public function setDescricao($descricao)
	{
	    $this->descricao = $descricao;
	}

	public function getNome()
	{
	    return $this->nome;
	}

	public function setNome($nome)
	{
	    $this->nome = $nome;
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