<?php
class Lancamento{

	private $id;
	private $descricao;
	private $historico;
	private $tipoLancamento;
	private $categoria;
	private $cedenteSacado;
	private $instancia;
	private $parcelas;
	private $repeticaoIndefinida = 'false';
	
	// transients
	private $qtdParcelas;
	private $valorTotal;
	

	function getId () {
		return $this->id;
	}

	function setId ($id) {
		$this->id = $id;
	}
	
	public function getValorTotal(){
		return $this->valorTotal;
	}
	
	public function setValorTotal($valorTotal){
		$this->valorTotal = $valorTotal;
	}
	
	public function getQtdParcelas(){
		return $this->qtdParcelas;
	}
	
	public function setQtdParcelas($qtdParcelas){
		$this->qtdParcelas = $qtdParcelas;
	}
	
	public function isRepeticaoIndefinida(){
		return $this->repeticaoIndefinida;
	}
	
	public function setRepeticaoIndefinida($repeticaoIndefinida){
		$this->repeticaoIndefinida = $repeticaoIndefinida;
	}


	public function getDescricao(){
		return $this->descricao;
	}

	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}

	public function getHistorico()
	{
		return $this->historico;
	}

	public function setHistorico($historico)
	{
		$this->historico = $historico;
	}

	public function getTipoLancamento()
	{
		return $this->tipoLancamento;
	}

	public function setTipoLancamento($tipoLancamento)
	{
		$this->tipoLancamento = $tipoLancamento;
	}

	public function getCategoria()
	{
		return $this->categoria;
	}

	public function setCategoria($categoria)
	{
		$this->categoria = $categoria;
	}

	public function getCedenteSacado()
	{
		return $this->cedenteSacado;
	}

	public function setCedenteSacado($cedenteSacado)
	{
		$this->cedenteSacado = $cedenteSacado;
	}

	public function getInstancia()
	{
		return $this->instancia;
	}

	public function setInstancia($instancia)
	{
		$this->instancia = $instancia;
	}

	public function getParcelas()
	{
		return (array) $this->parcelas;
	}

	public function setParcelas(array $parcelas)
	{
		$this->parcelas = $parcelas;
	}
}
?>