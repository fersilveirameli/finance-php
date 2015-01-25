<?php
@header("Content-Type: text/html; charset=iso-8859-1");
@header("Cache-Control: no-cache, must-revalidate");
@header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
define('__ROOT__', dirname(__FILE__));
require_once __ROOT__.'/private/dao/ParcelaLancamentoDAO.class.php';
require_once __ROOT__.'/private/utils/util.php';


$mesAtual = $_GET['month'];
$anoAtual = $_GET['year'];

$parcelaLancamentoDAO = new ParcelaLancamentoDAO();
$parcelas = $parcelaLancamentoDAO->getList($mesAtual, $anoAtual);

$contaDAO = new ContaDAO();
$contas = $contaDAO->getList();

?>

<script type="text/javascript">
$( ".remove-transacao" ).click(function(e) {
	e.preventDefault();

	var id = $(this).attr("value");
	
	$( "#dialog-remove" ).dialog({
		buttons: {
			Sim: function() {		
				var values = {action: REMOVE, id : id};
				$.post('lancamentoUI.php', values, function(message){
		           showMessage(message);
		            $.get('lancamentoList.php', {month: <?=$mesAtual?>, year: <?=$anoAtual?>}, function(data){
		                $(".fm-div-list").html(data);
		            });  
		        });   
				$( this ).dialog( "close" );			
			},
			'Não': function() {
				$( this ).dialog( "close" );
			}
		},
		close: function() {
		}
	});

	$("#dialog-remove").dialog("open");

});


$(".edit_td").click(function(){	
	$(this).children(".span_last").hide();
	$(this).children(".input_last").show();
}).change(function(){
	var id = $(this).parent().attr('id');
	var dataPgto = $(this).children(".input_dataPgto").val();
	var conta = $(this).children(".input_conta").val();
	
	$(this).children(".span_last").html('<img src="img/load.gif" />'); // Loading image

	

	var values = {action: UPDATE, id : id, dataPgto: dataPgto, conta: conta};

	$.post('lancamentoUI.php', values, function(message){
       
         $.get('lancamentoList.php', {month: <?=$mesAtual?>, year: <?=$anoAtual?>}, function(data){
             $(".fm-div-list").html(data);
         });  
     });   

});

// Edit input box click action
$(".editbox").mouseup(function(){
	return false;
});

// Outside click action
$(document).mouseup(function(){
	$(".editbox").hide();
	$(".text").show();
});

$( ".editbox-date" ).datepicker({dateFormat: 'dd/mm/yy',});

</script>
<table class="fm-table">
	<thead>
		<tr>
			<th class="fm-td-checkbox"><input type="checkbox" /></th>
			<th>Descrição</th>
			<th class="fm-td-180">Categoria</th>
			<th class="fm-td-180">Cedente/Sacado</th>
			<th class="fm-td-140">Conta</th>
			<th class="fm-td-date">Data Venc.</th>
			<th class="fm-td-date">Data Pgto.</th>
			<th class="fm-td-120">Valor R$</th>
			<th class="fm-th-acoes">Ações</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($parcelas as $parcelaLancamento){?>
		<tr class="edit_tr" id="<?=$parcelaLancamento->getId()?>">
			<td><input type="checkbox" /></td>

			<td><?=$parcelaLancamento->getLancamento()->getDescricao().' ('.$parcelaLancamento->getParcela().')'?></td>
			<td><?=$parcelaLancamento->getLancamento()->getCategoria()->getNome()?></td>
			<td><?=$parcelaLancamento->getLancamento()->getCedenteSacado()->getNome()?></td>
			<td class="edit_td">
				<span class="text span_last"><?=$parcelaLancamento->getConta()->getNome()?></span> 
				<select class="editbox input_last input_conta">
					<option>--</option>
					<?php foreach ($contas as $conta){?>
						<option value="<?=$conta->getId()?>"><?=$conta->getNome()?></option>
					<?php }?>
				</select> 
			</td>
			<td><?=$parcelaLancamento->getDataVencimentoFormat()?></td>
			<td class="edit_td fm-td-date">
				<span class="text span_last"><?=$parcelaLancamento->getDataPgtoFormat()?></span> 
				<input type="text" value="<?=$parcelaLancamento->getDataPgtoFormat()?>" class="editbox editbox-date input_last input_dataPgto" />
			</td>
			<td
				class="<?=($parcelaLancamento->getLancamento()->getTipoLancamento()==1)?'income':'cost'?>"><?=number_format($parcelaLancamento->getValor(), 2, ',', '.')?>
			</td>

			<td class="fm-td-acoes">
				<a href="#"><img width="20" src="img/Blue-Pencil.PNG" alt="Editar" /></a> 
				<a href="#" class="remove-transacao" value="<?=$parcelaLancamento->getId()?>"><img width="20" src="img/Badge-Multiply.PNG" alt="Remover" /></a> 
				<a href="#"><img width="20" src="img/Cash.PNG" alt="Efetivar" /></a>
				<a href="#"><img width="20" src="img/Chat.PNG" alt="Hitorico" /></a>
			</td>
		</tr>
		<?php }?>
	</tbody>
</table>
