<?php

require_once 'Connection.php';
require_once 'ContaDAO.class.php';
require_once 'LancamentoDAO.class.php';
require_once __ROOT__.'/private/model/ParcelaLancamento.class.php';
require_once __ROOT__.'/private/utils/util.php';

class ParcelaLancamentoDAO{

	private $conn;

	function __construct(){
		$this->conn = new Connection();
	}

	public function getList($month, $year){
			
		$this->conn->open();
		$query = "SELECT pl.id, pl.data_pgto, pl.data_vencimento, pl.parcela, pl.valor, pl.conta, pl.lancamento
		FROM parcela_lancamento pl join lancamento l on l.id = pl.lancamento
		WHERE EXTRACT(month FROM pl.data_vencimento) = $month
		AND EXTRACT(year FROM pl.data_vencimento) = $year ORDER BY pl.data_vencimento, l.descricao ASC" ;


		$result = pg_query($query);
		if (!$result) {
			echo "Um erro ocorreu na consulta.\n";
			exit;
		}


		$list = array();
		while ($row = pg_fetch_array($result)) {

			$lancamentoDAO = new LancamentoDAO();
			$contaDAO = new ContaDAO();

			$parcelaLancamento = new ParcelaLancamento();
			$parcelaLancamento->setId($row['id']);
			$parcelaLancamento->setConta($contaDAO->get($row['conta']));
			$parcelaLancamento->setDataPgto(($row['data_pgto']));
			$parcelaLancamento->setDataVencimento($row['data_vencimento']);
			$parcelaLancamento->setParcela($row['parcela']);
			$parcelaLancamento->setLancamento($lancamentoDAO->get($row['lancamento']));
			$parcelaLancamento->setValor($row['valor']);
			$list[] = $parcelaLancamento;

		}
		$this->conn->close();

		return $list;

	}

	public function getListPendentes(){
			
		$currentDate = new DateTime();

		$this->conn->open();
		$query = "SELECT id, data_pgto, data_vencimento, parcela, valor, conta, lancamento
		FROM parcela_lancamento
		WHERE data_pgto is null and data_vencimento <= '{$currentDate->format('Y/m/d')}'
		ORDER BY data_vencimento ASC";


		$result = pg_query($query);
		if (!$result) {
			echo "Um erro ocorreu na consulta.\n";
			exit;
		}


		$list = array();
		while ($row = pg_fetch_array($result)) {

			$lancamentoDAO = new LancamentoDAO();
			$contaDAO = new ContaDAO();

			$parcelaLancamento = new ParcelaLancamento();
			$parcelaLancamento->setId($row['id']);
			$parcelaLancamento->setConta($contaDAO->get($row['conta']));
			$parcelaLancamento->setDataPgto($row['data_pgto']);
			$parcelaLancamento->setDataVencimento($row['data_vencimento']);
			$parcelaLancamento->setParcela($row['parcela']);
			$parcelaLancamento->setLancamento($lancamentoDAO->get($row['lancamento']));
			$parcelaLancamento->setValor($row['valor']);
			$list[] = $parcelaLancamento;

		}
		$this->conn->close();

		return $list;

	}

	public function getListFuturas(){

		$currentDate = new DateTime();
		$endDate = new DateTime();
		$endDate->modify('+1 month');

		$this->conn->open();
		$query = "SELECT id, data_pgto, data_vencimento, parcela, valor, conta, lancamento
		FROM parcela_lancamento
		WHERE data_pgto is null and data_vencimento > '{$currentDate->format('Y/m/d')}' and data_vencimento <= '{$endDate->format('Y/m/d')}'
		ORDER BY data_vencimento ASC";


		$result = pg_query($query);
		if (!$result) {
			echo "Um erro ocorreu na consulta.\n";
			exit;
		}


		$list = array();
		while ($row = pg_fetch_array($result)) {

			$lancamentoDAO = new LancamentoDAO();
			$contaDAO = new ContaDAO();

			$parcelaLancamento = new ParcelaLancamento();
			$parcelaLancamento->setId($row['id']);
			$parcelaLancamento->setConta($contaDAO->get($row['conta']));
			$parcelaLancamento->setDataPgto($row['data_pgto']);
			$parcelaLancamento->setDataVencimento($row['data_vencimento']);
			$parcelaLancamento->setParcela($row['parcela']);
			$parcelaLancamento->setLancamento($lancamentoDAO->get($row['lancamento']));
			$parcelaLancamento->setValor($row['valor']);
			$list[] = $parcelaLancamento;

		}
		$this->conn->close();

		return $list;

	}

	public function doSaveOrUpdate(ParcelaLancamento $parcelaLancamento){
		$this->conn->open();

		$dataPgto = $parcelaLancamento->getDataPgto();
		$dataVencimento = $parcelaLancamento->getDataVencimento();
		$params = array(
				($dataPgto)?$dataPgto->format('Y/m/d'):null,
				($dataVencimento)?$dataVencimento->format('Y/m/d'):null,
				$parcelaLancamento->getParcela(),
				$parcelaLancamento->getValor(),
				$parcelaLancamento->getConta()->getId(),
				$parcelaLancamento->getLancamento()->getId()
		);


		$query = "INSERT INTO parcela_lancamento(id, data_pgto, data_vencimento, parcela, valor, conta, lancamento) ".
				"VALUES (nextval('seq_parcela_lancamento'), $1, $2, $3, $4, $5, $6)";


		pg_prepare("queryParcelaLancamentoSave", $query);
		$res= pg_execute("queryParcelaLancamentoSave", $params);
			
		$this->conn->close();

	}

	public function doUpdate(ParcelaLancamento $parcelaLancamento){
		$this->conn->open();

		$dataPgto = $parcelaLancamento->getDataPgto();
		$params = array(
				$parcelaLancamento->getId(),
				($dataPgto)?$dataPgto->format('Y/m/d'):null,
				//$parcelaLancamento->getDataVencimentoFormat(),
				//$parcelaLancamento->getParcela(),
				//$parcelaLancamento->getValor(),
				$parcelaLancamento->getConta()->getId()
				//$parcelaLancamento->getLancamento()->getId()
		);



		$query = "UPDATE parcela_lancamento SET data_pgto = $2, conta = $3 WHERE id = $1";
		//$query = "INSERT INTO parcela_lancamento(id, data_pgto, data_vencimento, parcela, valor, conta, lancamento) ".
		//"VALUES ($1, $2, $3, $4, $5, $6, $7)";


		pg_prepare("queryParcelaLancamentoUpdate", $query);
		$res= pg_execute("queryParcelaLancamentoUpdate", $params);
			
		$this->conn->close();

	}


	public function doRemove(Lancamento $lancmento){

	}

	public function get($id){
		$this->conn->open();
		$result = pg_query("SELECT id, data_pgto, data_vencimento, parcela, valor, conta, lancamento
				FROM parcela_lancamento
				WHERE id = $id ");
		if (!$result) {
			echo "Um erro ocorreu na consulta.\n";
			exit;
		}

		$parcelaLancamento = new ParcelaLancamento();
		while ($row = pg_fetch_array($result)) {

			$lancamentoDAO = new LancamentoDAO();
			$contaDAO = new ContaDAO();

			$parcelaLancamento->setId($row['id']);
			$parcelaLancamento->setConta($contaDAO->get($row['conta']));
			$parcelaLancamento->setDataPgto($row['data_pgto']);
			$parcelaLancamento->setDataVencimento($row['data_vencimento']);
			$parcelaLancamento->setParcela($row['parcela']);
			$parcelaLancamento->setLancamento($lancamentoDAO->get($row['lancamento']));
			$parcelaLancamento->setValor($row['valor']);

		}


		$this->conn->close();
		return $parcelaLancamento;
	}


}
?>