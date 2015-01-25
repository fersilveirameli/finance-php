<?php
class Banco{

	private $id;
	private $ativo;
	private $codigo;
	private $nome;
	private $site;
	private $instancia;

	function getId () {
		return $this->id;
	}

	function setId ($id) {
		$this->id = $id;
	}


	public function getAtivo()
	{
	    return $this->ativo;
	}

	public function setAtivo($ativo)
	{
	    $this->ativo = $ativo;
	}

	public function getCodigo()
	{
	    return $this->codigo;
	}

	public function setCodigo($codigo)
	{
	    $this->codigo = $codigo;
	}

	public function getNome()
	{
	    return $this->nome;
	}

	public function setNome($nome)
	{
	    $this->nome = $nome;
	}

	public function getSite()
	{
	    return $this->site;
	}

	public function setSite($site)
	{
	    $this->site = $site;
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