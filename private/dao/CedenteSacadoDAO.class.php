<?php

require_once 'Connection.php';
require_once 'InstanciaDAO.class.php';
require_once __ROOT__.'/private/model/CedenteSacado.class.php';

class CedenteSacadoDAO{

	private $conn;

	function __construct(){
		$this->conn = new Connection();
	}

	public function get($id){
		$this->conn->open();
		$result = pg_query("SELECT id, descricao, nome, instancia FROM cedente_sacado WHERE id = $id ");
		if (!$result) {
			echo "Um erro ocorreu na consulta.\n";
			exit;
		}

		$cedenteSacado = new CedenteSacado();
		while ($row = pg_fetch_array($result)) {

			$instanciaDAO = new InstanciaDAO();

			$cedenteSacado->setId($row['id']);
			$cedenteSacado->setDescricao($row['descricao']);
			$cedenteSacado->setNome($row['nome']);
			$cedenteSacado->setInstancia($instanciaDAO->get($row['instancia']));
		}


		$this->conn->close();
		return $cedenteSacado;
	}

	public function getList(){
		$this->conn->open();
		$result = pg_query("SELECT id, descricao, nome, instancia FROM cedente_sacado ORDER BY nome ASC");
		if (!$result) {
			echo "Um erro ocorreu na consulta.\n";
			exit;
		}

		$list = array();
		while ($row = pg_fetch_array($result)) {

			$instanciaDAO = new InstanciaDAO();

			$cedenteSacado = new CedenteSacado();
			$cedenteSacado->setId($row['id']);
			$cedenteSacado->setDescricao(utf8_decode($row['descricao']));
			$cedenteSacado->setNome(utf8_decode($row['nome']));
			$cedenteSacado->setInstancia($instanciaDAO->get($row['instancia']));
			$list[] = $cedenteSacado;

		}
		$this->conn->close();

		return $list;

	}




}
?>