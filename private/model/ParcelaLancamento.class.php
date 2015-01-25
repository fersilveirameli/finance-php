<?php
class ParcelaLancamento{

	private $id;
	private $dataPgto;
	private $dataVencimento;
	private $parcela = 0;
	private $valor;
	private $conta;
	private $lancamento;

	function getId () {
		return $this->id;
	}

	function setId ($id) {
		$this->id = $id;
	}


	public function getDataPgto(){
		return $this->dataPgto;
	}

	public function getDataPgtoFormat(){
		if($this->dataPgto){
			return $this->dataPgto->format('d/m/Y');
		}
		return null;
	}

	public function setDataPgto($dataPgto){
		if($dataPgto){
			if($dataPgto instanceof DateTime)
				$this->dataPgto = $dataPgto;
			else
				$this->dataPgto = new DateTime($dataPgto);

		}
	}

	public function getDataVencimento(){
		return $this->dataVencimento;
	}

	public function getDataVencimentoFormat(){
		if($this->dataVencimento)
			return $this->dataVencimento->format('d/m/Y');
		return null;
	}

	public function setDataVencimento($dataVencimento){
		if($dataVencimento){
			if($dataVencimento instanceof DateTime)
				$this->dataVencimento = $dataVencimento;
			else
				$this->dataVencimento = new DateTime($dataVencimento);

		}
	}



	public function getParcela(){
		return $this->parcela;
	}

	public function setParcela($parcela){
		$this->parcela = $parcela;
	}

	public function getValor(){
		return $this->valor;
	}

	public function setValor($valor){
		$this->valor = $valor;
	}

	public function getConta(){
		return $this->conta;
	}

	public function setConta($conta){
		$this->conta = $conta;
	}

	public function getLancamento(){
		return $this->lancamento;
	}

	public function setLancamento($lancamento){
		$this->lancamento = $lancamento;
	}
}
?>