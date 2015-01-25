<?php

require_once  'Connection.php';
require_once  'InstanciaDAO.class.php';
require_once  __ROOT__.'/private/model/Banco.class.php';

class BancoDAO{

	private $conn;

	function __construct(){
		$this->conn = new Connection();
	}

	public function get($id){
		$this->conn->open();
		$result = pg_query("SELECT id, ativo, codigo, nome, site, instancia FROM banco WHERE id = $id ");
		if (!$result) {
			echo "Um erro ocorreu na consulta.\n";
			exit;
		}
		
		$banco = new Banco();
		while ($row = pg_fetch_array($result)) {
				
			$instanciaDAO = new InstanciaDAO();

			$banco->setId($row['id']);
			//$categoria->setCategoriaSuperior($this->get($row['categoria_superior']));
			$banco->setNome($row['nome']);
			$banco->setInstancia($instanciaDAO->get($row['instancia']));
			$banco->setCodigo($row['codigo']);
						
		}


		$this->conn->close();
		return $banco;
	}
	
	public function getList(){
// 	    $this->conn->open();
// 	    $result = pg_query("SELECT id, nome, categoria_superior, instancia FROM categoria ORDER BY nome ASC");
// 	    if (!$result) {
// 	        echo "Um erro ocorreu na consulta.\n";
// 	        exit;
// 	    }
	
// 	    while ($row = pg_fetch_array($result)) {
	
// 	        $instanciaDAO = new InstanciaDAO();
// 	        $categoria = new Categoria();

// 			$categoria->setId($row['id']);
// 			//$categoria->setCategoriaSuperior($this->get($row['categoria_superior']));
// 			$categoria->setNome($row['nome']);
// 			$categoria->setInstancia($instanciaDAO->get($row['instancia']));
// 	        $list[] = $categoria;
	        	
// 	    }
// 	    $this->conn->close();
	
	    return $list;
	
	}




}
?>