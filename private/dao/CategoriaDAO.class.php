<?php

require_once  'Connection.php';
require_once  'InstanciaDAO.class.php';
require_once  __ROOT__.'/private/model/Categoria.class.php';

class CategoriaDAO{

	private $conn;

	function __construct(){
		$this->conn = new Connection();
	}

	public function get($id){
		$this->conn->open();
		$result = pg_query("SELECT id, nome, categoria_superior, instancia FROM categoria WHERE id = $id ");
		if (!$result) {
			echo "Um erro ocorreu na consulta.\n";
			exit;
		}
		
		$categoria = new Categoria();
		while ($row = pg_fetch_array($result)) {
				
			$instanciaDAO = new InstanciaDAO();

			$categoria->setId($row['id']);
			//$categoria->setCategoriaSuperior($this->get($row['categoria_superior']));
			$categoria->setNome(utf8_decode($row['nome']));
			$categoria->setInstancia($instanciaDAO->get($row['instancia']));
		}


		$this->conn->close();
		return $categoria;
	}
	
	public function getList(){
	    $this->conn->open();
	    $result = pg_query("SELECT id, nome, categoria_superior, instancia FROM categoria ORDER BY nome ASC");
	    if (!$result) {
	        echo "Um erro ocorreu na consulta.\n";
	        exit;
	    }
	
		$list = array();
	    while ($row = pg_fetch_array($result)) {
	
	        $instanciaDAO = new InstanciaDAO();
	        $categoria = new Categoria();

			$categoria->setId($row['id']);
			//$categoria->setCategoriaSuperior($this->get($row['categoria_superior']));
			$categoria->setNome(utf8_decode($row['nome']));
			$categoria->setInstancia($instanciaDAO->get($row['instancia']));
	        $list[] = $categoria;
	        	
	    }
	    $this->conn->close();
	
	    return $list;
	
	}




}
?>