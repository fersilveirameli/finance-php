<?php
define('__ROOT__', dirname(__FILE__));
require_once __ROOT__.'/private/dao/LancamentoDAO.class.php';
require_once __ROOT__.'/private/dao/CategoriaDAO.class.php';
require_once __ROOT__.'/private/dao/CedenteSacadoDAO.class.php';
require_once __ROOT__.'/private/dao/InstanciaDAO.class.php';
require_once __ROOT__.'/private/dao/ContaDAO.class.php';
require_once __ROOT__.'/private/model/Lancamento.class.php';
require_once __ROOT__.'/private/model/ParcelaLancamento.class.php';
require_once __ROOT__.'/private/utils/util.php';



# Evita o armazenamento em Cache
@header("Content-Type: text/html; charset=iso-8859-1");
@header("Cache-Control: no-cache, must-revalidate");
@header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
# Verifica se os dados foram enviados do form e retira o espaco em branco (trim)


$action = $_POST['action'];


switch ($action) {
	case 0:
		save();
		break;
	case 1:
		update();
		break;
	case 2:
		remove();
		break;
}





function save(){
	$tipoLancamento = trim($_POST['tipoLancamento']);
	$dataVencimento = parseDate(trim($_POST['dataVencimento']));
	$dataPgto = parseDate(trim($_POST['dataPgto']));
	$descricao = trim($_POST['descricao']);
	$categoria = trim($_POST['categoria']);
	$conta = trim($_POST['conta']);
	$valor = trim($_POST['valor']);
	$qtdParcelas = trim($_POST['parcelas']);
	$formaPgto = trim($_POST['formaPgto']);
	$historico = trim($_POST['historico']);
	$repeticaoIndefinida = trim($_POST['repeticaoIndefinida']);
	$cedenteSacado = trim($_POST['cedenteSacado']);


	$dataVencimento = ($dataVencimento)?new DateTime($dataVencimento):null;
	$dataPgto = ($dataPgto)?new DateTime($dataPgto):null;


	$categoriaDAO = new CategoriaDAO();
	$cedenteSacadoDAO = new CedenteSacadoDAO();
	$instanciaDAO = new InstanciaDAO();
	$lancamentoDAO = new LancamentoDAO();
	$contaDAO = new ContaDAO();



	$lancamento = new Lancamento();
	$lancamento->setCategoria($categoriaDAO->get($categoria));
	$lancamento->setCedenteSacado($cedenteSacadoDAO->get($cedenteSacado));
	$lancamento->setDescricao($descricao);
	$lancamento->setHistorico($historico);
	$lancamento->setInstancia($instanciaDAO->get(1));
	$lancamento->setTipoLancamento($tipoLancamento);

	if($formaPgto==A_VISTA){
		$qtdParcelas = 1;
	}elseif ($formaPgto==PARCELADO ){
		$valor = $valor/$qtdParcelas;
	}

	if($repeticaoIndefinida=='true'){
		$lancamento->setRepeticaoIndefinida('TRUE');
		$qtdParcelas = 720;// 5 anos
	}


	$parcelas = array();
	$conta = $contaDAO->get($conta);
	for($parcela = 1; $parcela<=$qtdParcelas; $parcela++){
		$parcelaLancamento = new ParcelaLancamento();

		$parcelaLancamento->setParcela(0);
		if($formaPgto==PARCELADO){
			$parcelaLancamento->setParcela($parcela);
			if($parcela>1)
				$dataVencimento->modify('+1 month');
		}

		$parcelaLancamento->setDataPgto($dataPgto);
		$parcelaLancamento->setValor($valor);
		$parcelaLancamento->setConta($conta);
		$parcelaLancamento->setLancamento($lancamento);
		$parcelaLancamento->setDataVencimento(clone $dataVencimento);


		$parcelas[] = $parcelaLancamento;
	}

	$lancamento->setParcelas($parcelas);


	$lancamentoDAO->doSaveOrUpdate($lancamento);

	echo "Cadastro realizado com sucesso!";
}
function update(){

	$dataPgto = trim($_POST['dataPgto']);
	$conta = trim($_POST['conta']);
	$id = trim($_POST['id']);

	$contaDAO = new ContaDAO();

	$parcelaLancamentoDAO = new ParcelaLancamentoDAO();
	$parcelaLancamento = $parcelaLancamentoDAO->get($id);


	if($dataPgto)
		$parcelaLancamento->setDataPgto(parseDate($dataPgto));

	if($conta)
		$parcelaLancamento->setConta($contaDAO->get($conta));

	$parcelaLancamentoDAO->doUpdate($parcelaLancamento);

	echo "Atualizado com sucesso!";
}

function remove(){
	echo "Removido com sucesso!";
}





?>