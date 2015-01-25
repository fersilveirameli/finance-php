<?php
class Feriado{

	private $id;
	private $data;
	private $descricao;
	private $instancia;

	function getId () {
		return $this->id;
	}

	function setId ($id) {
		$this->id = $id;
	}

	public function getData()	{
		return $this->data;
	}

	public function setData($data)	{
		$this->data = $data;
	}

	public function getDescricao()	{
		return $this->descricao;
	}

	public function setDescricao($descricao)	{
		$this->descricao = $descricao;
	}

	public function getInstancia()	{
		return $this->instancia;
	}

	public function setInstancia($instancia)	{
		$this->instancia = $instancia;
	}
}
?>