<?php

require_once 'Connection.php';
require_once 'CategoriaDAO.class.php';
require_once 'CedenteSacadoDAO.class.php';
require_once 'InstanciaDAO.class.php';
require_once 'ParcelaLancamentoDAO.class.php';
require_once __ROOT__.'/private/model/Lancamento.class.php';

class LancamentoDAO{

	private $conn;
	private $queryselect = "SELECT id, descricao, historico, tipo_lancamento, categoria, cedente_sacado, instancia FROM lancamento";
	private $queryinsert = "INSERT INTO lancamento(id, descricao, historico, tipo_lancamento, categoria, cedente_sacado, instancia, repeticao_indefinida) VALUES ($1, $2, $3, $4, $5, $6, $7, $8)";


	function __construct(){
		$this->conn = new Connection();
	}

	public function getList(){
		$this->conn->open();
		$result = pg_query($this->queryinsert);
		if (!$result) {
			echo "Um erro ocorreu na consulta.\n";
			exit;
		}

		$list = array();
		while ($row = pg_fetch_array($result)) {

			$instanciaDAO = new InstanciaDAO();
			$categoriaDAO = new CategoriaDAO();
			$cedenteSacadoDAO = new CedenteSacadoDAO();

			$lancamento = new Lancamento();
			$lancamento->setId($row['id']);
			$lancamento->setInstancia($instanciaDAO->get($row['instancia']));
			$lancamento->setTipoLancamento($row['tipo_lancamento']);
			$lancamento->setHistorico(utf8_decode($row['historico']));
			$lancamento->setDescricao(utf8_decode($row['descricao']));
			//$lancamento->setCategoria($categoriaDAO->get($row['categoria']));
			$lancamento->setCedenteSacado($cedenteSacadoDAO->get($row['cedente_sacado']));
			$list[] = $lancamento;

		}
		$this->conn->close();

		return $list;

	}

	public function get($id){
		$this->conn->open();

		$result = pg_query("$this->queryselect WHERE id = $id ");
		if (!$result) {
			echo "Um erro ocorreu na consulta.\n";
			exit;
		}

		$lancamento = new Lancamento();
		while ($row = pg_fetch_array($result)) {

			$instanciaDAO = new InstanciaDAO();
			$categoriaDAO = new CategoriaDAO();
			$cedenteSacadoDAO = new CedenteSacadoDAO();

			$lancamento->setId($row['id']);
			$lancamento->setInstancia($instanciaDAO->get($row['instancia']));
			$lancamento->setTipoLancamento($row['tipo_lancamento']);
			$lancamento->setHistorico(utf8_decode($row['historico']));
			$lancamento->setDescricao(utf8_decode($row['descricao']));
			$lancamento->setCategoria($categoriaDAO->get($row['categoria']));
			$lancamento->setCedenteSacado($cedenteSacadoDAO->get($row['cedente_sacado']));
		}


		$this->conn->close();
		return $lancamento;
	}

	public function doSaveOrUpdate(Lancamento $lancamento){
		try {

			$this->conn->open();

			$row = pg_fetch_array(pg_query("select nextval('seq_lancamento')"));
			$lancamento->setId($row[0]);

			$params = array(
					$lancamento->getId(),
					$lancamento->getDescricao(),
					$lancamento->getHistorico(),
					$lancamento->getTipoLancamento(),
					$lancamento->getCategoria()->getId(),
					$lancamento->getCedenteSacado()->getId(),
					$lancamento->getInstancia()->getId(),
					'false'
			);

			
				
			pg_prepare("queryLancamentoSave",$this->queryinsert);
			$res= pg_execute("queryLancamentoSave", $params);

			$this->conn->close();

			$parcelaLancamentoDAO = new ParcelaLancamentoDAO();
			$parcelas = $lancamento->getParcelas();

			foreach ($parcelas as $parcela){
				$parcelaLancamentoDAO->doSaveOrUpdate($parcela);
			}

		} catch (Exception $e) {
			echo "Exceзгo pega: ",  $e->getMessage(), "\n";
		}

	}

	public function doRemove(Lancamento $lancmento){

	}


}
?>