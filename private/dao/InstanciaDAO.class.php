<?php

require_once 'Connection.php';
require_once __ROOT__.'/private/model/Instancia.class.php';

class InstanciaDAO{

	private $conn;

	function __construct(){
		$this->conn = new Connection();
	}

	public function get($id){
		$this->conn->open();
		$result = pg_query("SELECT id, fundo_caixa, nome FROM instancia WHERE id = $id ");
		if (!$result) {
			echo "Um erro ocorreu na consulta.\n";
			exit;
		}

		$instancia = new Instancia();
		while ($row = pg_fetch_array($result)) {
				
			$instancia->setId($row['id']);
			$instancia->setFundoCaixa($row['fundo_caixa']);
			$instancia->setNome($row['nome']);
		}
		$this->conn->close();
		return $instancia;
	}
}
?>