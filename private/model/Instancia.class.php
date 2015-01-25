<?php
class Instancia{

	private $id;
	private $fundoCaixa;
	private $nome;

	function getId () {
	 return $this->id;
	}

	function setId ($id) {
	 $this->id = $id;
	}

	function getFundoCaixa () {
	 return $this->fundoCaixa;
	}

	function setFundoCaixa ($fundoCaixa) {
	 $this->fundoCaixa = $fundoCaixa;
	}

	function getNome () {
	 return $this->nome;
	}

	function setNome ($nome) {
	 $this->nome = $nome;
	}

}
?>