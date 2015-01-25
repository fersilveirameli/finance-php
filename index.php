<?php
define('__ROOT__', dirname(__FILE__));
require_once __ROOT__.'/private/dao/ParcelaLancamentoDAO.class.php';
require_once __ROOT__.'/private/utils/util.php';

date_default_timezone_set('America/Sao_Paulo');



$parcelaLancamentoDAO = new ParcelaLancamentoDAO();
$parcelasPendentes = $parcelaLancamentoDAO->getListPendentes();
$parcelasFuturas = $parcelaLancamentoDAO->getListFuturas();


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Finance Manager</title>

<link href="css/global.css" rel="stylesheet" type="text/css" />
<link type="text/css"
	href="css/ui-lightness/jquery-ui-1.8.21.custom.css" rel="stylesheet" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.21.custom.min.js"></script>

<script type="text/javascript">
        
        $(function() {
            
        	
        });
		</script>
</head>
<body>
	<div class="fm-div-principal">
		<div class="fm-div-header">
			<?php require_once 'include/menu.php';?>
		</div>
		<div class="fm-div-content">
			<div class="fm-div-content-homesets">
				<fieldset>
					<legend>Lançamentos Futuros</legend>
					<table class="fm-table">
						<thead>
							<tr>
								<th>Data Venc.</th>
								<th>Descrição</th>
								<th>Categoria</th>
								<th>Conta</th>
								<th>Valor R$ </th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($parcelasFuturas as $parcelaLancamento){?>
							<tr>

								<td><?=$parcelaLancamento->getDataVencimentoFormat()?></td>
								<td><?=$parcelaLancamento->getLancamento()->getDescricao().' - '.$parcelaLancamento->getParcela()?></td>
								<td><?=$parcelaLancamento->getLancamento()->getCategoria()->getNome()?></td>
								<td><?=$parcelaLancamento->getConta()->getNome()?></td>
								<td class="<?=($parcelaLancamento->getLancamento()->getTipoLancamento()==1)?'income':'cost'?>"><?=number_format($parcelaLancamento->getValor(), 2, ',', '.')?></td>

							</tr>
							<?php }?>
						</tbody>
					</table>
				</fieldset>
			</div>
			<div class="fm-div-content-homesets">
				<fieldset>
					<legend>Lançamentos Pendentes</legend>
					<table class="fm-table">
						<thead>
							<tr>
								<th>Data Venc.</th>
								<th>Descrição</th>
								<th>Categoria</th>
								<th>Conta</th>
								<th>Valor R$</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($parcelasPendentes as $parcelaLancamento){?>
							<tr>

								<td><?=$parcelaLancamento->getDataVencimentoFormat()?></td>
								<td><?=$parcelaLancamento->getLancamento()->getDescricao().' - '.$parcelaLancamento->getParcela()?>	</td>
								<td><?=$parcelaLancamento->getLancamento()->getCategoria()->getNome()?>	</td>
								<td><?=$parcelaLancamento->getConta()->getNome()?></td>
								<td	class="<?=($parcelaLancamento->getLancamento()->getTipoLancamento()==1)?'income':'cost'?>"><?=number_format($parcelaLancamento->getValor(), 2, ',', '.')?></td>

							</tr>
							<?php }?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="4">Total</td>
								<td>123,23</td>
							</tr>
						</tfoot>
					</table>
				</fieldset>
			</div>

			<div class="fm-div-content-homesets">
				<fieldset>
					<legend>Entradas e Saidas do mes</legend>
				</fieldset>
			</div>
			<div class="fm-div-content-homesets">
				<fieldset>
					<legend>Saldo das contas</legend>
				</fieldset>
			</div>
			<div class="fm-div-content-homesets">
				<fieldset>
					<legend>Balanço geral</legend>
				</fieldset>
			</div>
			<div class="fm-div-content-homesets">
				<fieldset>
					<legend>Extrato de Pagamentos e Transferências (saidas)</legend>
				</fieldset>
			</div>

		</div>
	</div>
</body>
</html>
